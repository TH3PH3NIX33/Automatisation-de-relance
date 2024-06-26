<?php

### If the config file present ? if not, redirect to install section

if (!@is_file('config.inc.php')) {
    header('Location: setup.php');
}
$db 	= (isset($HTTP_GET_VARS['db'])) ? $HTTP_GET_VARS['db'] : '';
$tbl 	= (isset($HTTP_GET_VARS['tbl'])) ? $HTTP_GET_VARS['tbl'] : '';


require './config.inc.php';
require './include/mysql.inc.php';
require './include/functions.inc.php';

### Getting current cfg and setting the design vars
$globalConfig = select_config();
$tplConfig 	= $globalConfig['tpl'];
$sqlConfig 	= $globalConfig['sql'];
$txt 		= $globalConfig['txt'];
$design 	= $globalConfig['design'];

$colors 	= $design['colors'];
$font 		= $design['font'];

require './include/design.inc.php';

### Creating the link to the DB
$main_DB = new DB($sqlConfig);

require './include/databases.inc.php';


$dont_output 	= 0;
$output 		= '';

$action 		= reg_glob('action');
$extra_query 	= reg_glob('extra_query');

### Removing the ' if magic_quote_gpc
$db = magic_quote_bypass($db);
$tbl = magic_quote_bypass($tbl);

if ( empty($db) ) {
    ### HP
    $main_DB->storeTblsInfos();
    switch ($action) {
    	case '':
    		$output = show_hp();
    	break;
    	
    	case 'create_db':
    		$output = create_db($main_DB);
    	break;
    	
    	case 'do_query':
        	$output .= do_sql_query($main_DB,$extra_query);
        break;
        
        case 'show_tips':
	        $dont_output = 1;
	        $html		= isset($HTTP_GET_VARS['html']) ? $HTTP_GET_VARS['html'] : '';
	        $random 	= isset($HTTP_GET_VARS['random']) ? $HTTP_GET_VARS['random'] : '';
	        $never 		= isset($HTTP_GET_VARS['never']) ? $HTTP_GET_VARS['never'] : '';
	        $old_one 	= isset($HTTP_GET_VARS['old_one']) ? $HTTP_GET_VARS['old_one'] : '';
	        echo show_tips($html, $random, $never, $old_one);
        break;
    }

}
elseif ($db != '' && $tbl == '') {
    ### DB HP
  
    if ($action != 'show_mysql_state' && $action != 'show_mysql_vars' && $action != 'show_mysql_process') {
    	$main_DB->select_db($db);
		$main_DB->storeTblsInfos();
	}
	
    switch ($action) {
    	case '':
	    	$output .= show_db_hp($main_DB,$db);
    	break;

    	case 'create_new_table':
    		$output .= create_new_table($main_DB);
    	break;

        case 'drop_database':
	        $output .= do_sql_query($main_DB, 'DROP DATABASE '.sql_back_ticks($db, $main_DB));
        break;

        case 'do_query':
        	$output .= do_sql_query($main_DB,$extra_query);
        break;

        case 'incoming_sql':
        	require './include/dump.inc.php';
        	$output .= incoming_sql($main_DB);
        break;

        case 'incoming_upload_sql':
        	require './include/dump.inc.php';
        	$output .= incoming_upload_sql($main_DB);
        break;

        case 'dump':
			require './include/dump.inc.php';
        	$output .= show_dump_hp($main_DB,$tbl);
        break;
        
        case 'optimize':
       		$tbl_check = reg_glob('tbl_check') ? reg_glob('tbl_check') : array();
       		$output = optimize_mult_tables($main_DB, $tbl_check);
       	break;
       	
       	case 'drop':
       	 	$tbl_check = reg_glob('tbl_check') ? reg_glob('tbl_check') : array();
       		$output = drop_mult_tables($main_DB, $tbl_check);
       	break;
       	
       	case 'empty':
       		$tbl_check = reg_glob('tbl_check') ? reg_glob('tbl_check') : array();
       		$output = empty_mult_tables($main_DB, $tbl_check);
       	break;

		case 'desc':
		    $tbl_check = reg_glob('tbl_check') ? reg_glob('tbl_check') : array();
			$output = open_desc_mult_tables($tbl_check);
        break;

		case 'desc_mult_tables_popup':
			$out_type       = (isset($HTTP_GET_VARS['out_type'])) ? $HTTP_GET_VARS['out_type'] : '';
			$output         = desc_mult_tables($main_DB, reg_glob('selected_tbl'), $out_type);
			$dont_output    = 1;
		break;
       	
       	case 'show_mysql_state':
       		if ($conf['showMysqlState'] && !getGoodConfigArg('db')) {
       			$output .= do_sql_query($main_DB, "SHOW STATUS");
       		}
       		else {
       			$output .= $txt['not_allowed'];	
       			$collapse = 1;
       		}
       	break;
       	
       	case 'show_mysql_vars':
       		if ($conf['showMysqlVars'] && !getGoodConfigArg('db')) {
       			$output .= do_sql_query($main_DB, "SHOW VARIABLES");
       		}
       		else {
       			$output .= $txt['not_allowed'];	
       			$collapse = 1;
       		}
       	break;
       	
       	case 'show_mysql_process':
       		if ($conf['showMysqlProcess'] && !getGoodConfigArg('db')) {
       			$output .= do_sql_query($main_DB, "SHOW PROCESSLIST");
       		}
       		else {
       			$output .= $txt['not_allowed'];	
       			$collapse = 1;
       		}
       	break;
    }
}
elseif ($db != '' && $tbl != '') {
    ### TBL HP
    require './include/tables.inc.php';

    $main_DB->select_db($db);
    $main_DB->storeTblsInfos();
    switch ($action) {
        case '':
        	$output .= show_tbl_hp($main_DB,$tbl);
        break;

        case 'dump':
        	require './include/dump.inc.php';
        	$output .= show_dump_hp($main_DB,$tbl);
        break;

        case 'check':
        	$output .= do_sql_query($main_DB,'CHECK TABLE '.sql_back_ticks($tbl, $main_DB));
        break;

        case 'analyze':
        	$output .= do_sql_query($main_DB,'ANALYZE TABLE '.sql_back_ticks($tbl, $main_DB));
        break;

        case 'repair':
        	$output .= do_sql_query($main_DB,'REPAIR TABLE '.sql_back_ticks($tbl, $main_db));
        break;

        case 'optimize':
       		$output .= do_sql_query($main_DB,'OPTIMIZE TABLE '.sql_back_ticks($tbl, $main_DB));
       	break;

        case 'delete_tbl':
        	$output .= do_sql_query($main_DB,'DROP TABLE '.sql_back_ticks($tbl, $main_DB));
        break;

        case 'insert':
        	$output .= insert_into_tbl($main_DB,$tbl);
        break;

        case 'view':
        	$output .= view_tbl($main_DB,$tbl,$extra_query);
        break;

        case 'rename':
        	$output .= rename_tbl($main_DB,$tbl);
        break;

        case 'copy':
        	$output .= copy_tbl($main_DB,$tbl);
        break;

        case 'move':
        	$output .= move_tbl($main_DB,$tbl);
        break;
        
        case 'order':
        	$output .= order_tbl($main_DB, $tbl);
        break;
        
        case 'comment':
        	$output .= set_tbl_comment($main_DB, $tbl);
        break;
        
        case 'modif_field':
        	$output .= modif_field($main_DB, $tbl);
        break;
        
        case 'drop_field':
        	$output .= drop_field($main_DB, $tbl);
        break;
        
        case 'add_field':
        	$output .= add_field($main_DB, $tbl);
        break;
        
        case 'drop_key':
        	$output .= drop_key($main_DB, $tbl);
        break;
        
        case 'change_type':
        	$output .= change_tbl_type($main_DB, $tbl);
        break;
        
        case 'mod_record':
        	$output .= modif_record($main_DB, $tbl);
        break;
        
        case 'sup_record':
        	$output .= do_sql_query($main_DB, 'DELETE FROM '.sql_back_ticks($tbl, $main_DB).' WHERE '.reg_glob('query'));
        break;
        
        case 'build_select':
        	$output .= build_select($main_DB, $tbl);
        break;
        
        case 'empty':
        	$output .= do_sql_query($main_DB,'DELETE FROM '.sql_back_ticks($tbl, $main_DB));
        break;

        case 'incoming_sql':
        	require './include/dump.inc.php';
        	$output .= incoming_sql($main_DB);
        break;

        case 'incoming_csv':
        	require './include/dump.inc.php';
        	$output .= incoming_csv($main_DB);
        break;
        
        case 'incoming_upload_sql':
        	require './include/dump.inc.php';
        	$output .= incoming_upload_sql($main_DB);
        break;


    }
}

if (!$dont_output) {
	display_design($output,0);
}

$main_DB->close();
?>