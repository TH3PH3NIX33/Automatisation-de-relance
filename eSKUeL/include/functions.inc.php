<?php
$version = '1.0.6';

$data_types = array('TINYINT', 'SMALLINT',
					'MEDIUMINT', 'INT',
					'BIGINT', 'FLOAT',
					'DOUBLE', 'DECIMAL',
					'DATE', 'DATETIME',
					'TIMESTAMP', 'TIME',
					'YEAR', 'CHAR',
					'VARCHAR', 'TINYBLOB',
					'TINYTEXT', 'TEXT',
					'BLOB', 'MEDIUMBLOB',
					'MEDIUMTEXT', 'LONGBLOB',
					'LONGTEXT', 'ENUM',
					'SET'
					);
$data_attributes = array('', 'BINARY',
						'UNSIGNED', 'UNSIGNED ZEROFILL'
                        );
$data_functions = array('', 'ASCII',
						'CHAR', 'SOUNDEX',
						'ENCRYPT', 'LCASE',
						'UCASE', 'NOW',
						'PASSWORD', 'ENCODE',
						'DECODE', 'MD5',
						'RAND', 'LAST_INSERT_ID',
						'COUNT', 'AVG',
						'SUM', 'CURDATE',
						'CURTIME', 'FROM_DAYS',
						'FROM_UNIXTIME', 'PERIOD_ADD',
						'PERIOD_DIFF', 'TO_DAYS',
						'USER', 'WEEKDAY'
						);

function octet_2_kilo($nb) {
	$kilo = $nb / 1024;
	$number = number_format($kilo,1,',',' ');
	return $number;
}

function reg_glob($var) {
	Global $HTTP_GET_VARS, $HTTP_POST_VARS;

	if (isset($HTTP_GET_VARS[$var])) {
		return $HTTP_GET_VARS[$var];
	}
	elseif (isset($HTTP_POST_VARS[$var])) {
		return $HTTP_POST_VARS[$var];
	}
	else {
		return '';
	}
}

function select_lang_config() {
	Global $HTTP_COOKIE_VARS, $HTTP_POST_VARS;
	Global $conf;

	$lang_config_cookie = (isset($HTTP_COOKIE_VARS['ConfLangCookie']) && !ereg('.', $HTTP_COOKIE_VARS['ConfLangCookie'])) ? $HTTP_COOKIE_VARS['ConfLangCookie'] : '';
	$force_config 		= (isset($HTTP_POST_VARS['lang_config']) && !ereg('.', $HTTP_COOKIE_VARS['lang_config'])) ? $HTTP_POST_VARS['lang_config'] : '';

	if ($force_config != '') {
		$lang_conf = $force_config;
	}
	elseif ($lang_config_cookie != '') {
		$lang_conf = $lang_config_cookie;
	}
	else {
		$lang_conf = $conf['defaultTxt'];
	}
	if ($lang_conf == '') {
		$lang_conf = 'francais.inc.php';
	}
	### Getting the good $txt var from the lang res file
    include './lang/'.$lang_conf;

    return $txt;
}

function select_tpl_config() {
    global $HTTP_COOKIE_VARS, $HTTP_POST_VARS;
    Global $confDB;

	$config_selector   = (isset($HTTP_POST_VARS['config_selector'])) ? $HTTP_POST_VARS['config_selector'] : '';
    $tpl_config_cookie = (isset($HTTP_COOKIE_VARS['ConfTplCookie'])) ? $HTTP_COOKIE_VARS['ConfTplCookie'] : '';
    $force_config      = (isset($HTTP_POST_VARS['tpl_config'])) ? $HTTP_POST_VARS['tpl_config'] : '';

    if ($config_selector != '') {
        $tpl_conf = '';
    }
    else {

    	if ($force_config != '') {
    		$tpl_conf = $force_config;
    	}
    	elseif ($tpl_config_cookie != '') {
    		$tpl_conf = $tpl_config_cookie;
    	}
    	else {
    		$tpl_conf = getGoodConfigArg('tpl');
    	}
	$confDB[getGoodConfig()]['tpl'] = $tpl_conf;
    }

    return $tpl_conf;
}

function select_colors_config() {
	Global $HTTP_POST_VARS, $HTTP_COOKIE_VARS;
	Global $conf, $confDB;
	Global $globalConfig;

	$tpl_config  	= (isset($HTTP_POST_VARS['tpl_config'])) ? $HTTP_POST_VARS['tpl_config'] : '';
	$use_other_img 	= 0;

	$sql_conf_id = getGoodConfig();

	if ($tpl_config != '') {
            if ($tpl_config == 'null-tpl') {
            	include './include/default_colors.inc.php';
            }
            else {
	            include './tpl/'.$tpl_config.'/colors.inc.php';
	            $confDB[$sql_conf_id]['tpl'] = $tpl_config;
			}
	}
    elseif ($confDB[$sql_conf_id]['tpl'] != '' && (is_file('./tpl/'.$confDB[$sql_conf_id]['tpl'].'/colors.inc.php'))) {
        include './tpl/'.$confDB[$sql_conf_id]['tpl'].'/colors.inc.php';
	}
	elseif (isset($HTTP_COOKIE_VARS['ConfTplCookie']) && $HTTP_COOKIE_VARS['ConfTplCookie'] == 'null-tpl') {
			include './include/default_colors.inc.php';
	}
    else {
       ### The selected tpl is not available (deleted ?) setting it to default
       setcookie('ConfTplCookie','');
       include './include/default_colors.inc.php';
	}

    if ($use_other_img == 1) {
		$img_path = 'tpl/'.$confDB[$sql_conf_id]['tpl'].'/';
	}
	else {
		$img_path = '';
	}


	$colors = array(
        			'name' => $confDB[$sql_conf_id]['tpl'],
        			'bgcolor' => $bgcolor,
        			'table_bg' => $table_bg,
        			'titre_bg' => $titre_bg,
        			'titre_font' => $titre_font,
        			'bordercolor' => $bordercolor,
        			'vlink' => $vlink,
        			'link' => $link,
        			'text' => $text,
        			'alink' => $alink,
        			'trou_bg' => $trou_bg,
        			'trou_border' => $trou_border,
        			'trou_font' => $trou_font,
        			'bosse_bg' => $bosse_bg,
        			'bosse_font' => $bosse_font,
        			'bosse_border' => $bosse_border,
        			'pick_bg' => $pick_bg,
        			'pick_border' => $pick_border,
        			'img_path' => $img_path,
        			'tpl_type' => $tpl_type
        			);
	$design = array('colors' => $colors, 'font' => $font);
	return $design;
}

function select_sql_config() {
	Global $HTTP_POST_VARS, $HTTP_COOKIE_VARS;
	Global $conf, $confDB;

	$sql_config_cookie  = (isset($HTTP_COOKIE_VARS['ConfDBCookie'])) ? $HTTP_COOKIE_VARS['ConfDBCookie'] : '';
	$force_config 		= (isset($HTTP_POST_VARS['config_selector'])) ? $HTTP_POST_VARS['config_selector'] : '';
	$sql_conf			= '';

	if ($force_config != '') {
		$sql_conf_id = $force_config;
	}
	elseif ($sql_config_cookie != '') {
		$sql_conf_id = $sql_config_cookie;
	}
	else {
		$sql_conf_id = $conf['defaultConf'];
	}

	 if (isset($confDB[$sql_conf_id])) {
		 $sql_conf = array(
	        					'HOST' => $confDB[$sql_conf_id]['host'],
	        					'DB' => $confDB[$sql_conf_id]['db'],
	        					'USER' => $confDB[$sql_conf_id]['user'],
	        					'PASSWORD' => $confDB[$sql_conf_id]['password'],
	        					'ONLY_DB' => $confDB[$sql_conf_id]['db']
	        				);
	}


	return $sql_conf;
}

function select_config() {
	Global $HTTP_COOKIE_VARS, $HTTP_POST_VARS;
	Global $conf, $confDB;

	$globalConfig['sql'] 	= select_sql_config();
	$globalConfig['tpl'] 	= select_tpl_config();
	$globalConfig['txt'] 	= select_lang_config();
	$globalConfig['design'] = select_colors_config();

	return $globalConfig;

}

#####################################
# Build the titles and windows.status
# of a link
# $txt = Text to display in the tooltip
# and in the windows status bar
#
#####################################

function link_status($text){
	Global $font, $colors, $txt;

	$output = 'title="'.$text.'"';
	return $output;
}

function select_type($select_name, $preselected = '') {
	global $data_types;

    $selected 	= '';
    $output 	= '<SELECT name='.$select_name.' class="trous">';

    for ($i = 0; $i < count ($data_types); $i++) {

        if ( ($preselected == $i && is_int($preselected)) || ($preselected == $data_types[$i]) ) {
			$selected = 'SELECTED';
		}
		else {
			$selected = '';
		}

		$output .= '<OPTION VALUE='.$i.' '.$selected.'>'.$data_types[$i].'</OPTION>'."\n";
    }
	$output .= '</SELECT>';

	return $output;
}

function select_attribute($select_name, $preselected = '-') {
	global $data_attributes;

	$output = '<SELECT name='.$select_name.' class="trous">';

	for ($i = 0; $i < count ($data_attributes); $i++) {
		if ( ($preselected == $i) || ($preselected == $data_attributes[$i]) ) {
			$selected = 'SELECTED';
		}
		else {
			$selected = '';
		}
		$output .= '<OPTION VALUE='.$i.' '.$selected.'>'.$data_attributes[$i].'</OPTION>'."\n";
	}
	$output .= '</SELECT>';

	return $output;
}

function select_function($select_name, $preselected = '-') {
	global $data_functions;

	$output = '<SELECT name="'.$select_name.'" class="trous">';
	for ($i = 0; $i < count ($data_functions); $i++) {
		if ( ($preselected == $i) || ($preselected == $data_functions[$i]) ) {
			$selected = 'SELECTED';
		}
		else {
			$selected = '';
		}
		$output .= '<OPTION VALUE='.$i.' '.$selected.'>'.$data_functions[$i].'</OPTION>'."\n";
	}
	$output .= '</SELECT>';

	return $output;
}

function select_lang($preselected = '') {
    Global $conf, $HTTP_COOKIE_VARS;

    $output 			= '';
    $lang_config_cookie = isset($HTTP_COOKIE_VARS['ConfLangCookie']) ? $HTTP_COOKIE_VARS['ConfLangCookie'] : '';
    if ($lang_config_cookie != '' && $preselected == '') {
        $preselected = $lang_config_cookie;
    }

    ### Opening a pointer in the lang dir
    $d = dir("lang");
	while($entry=$d->read()) {
    	if ($entry != '.' && $entry != '..' && eregi('.inc.php',$entry) && !eregi('tips_',$entry)) {
    		$avl_lang[] = $entry;
    	}
   	}
	$d->close();

	### Sorting available lang
	asort($avl_lang);

	for ($i = 0; $i < count($avl_lang); $i++) {
        $display = str_replace('.inc.php','',$avl_lang[$i]);
		if ($avl_lang[$i] == $preselected || ($avl_lang[$i] == $conf['defaultTxt'] && $preselected == '')) {
			$selected = 'SELECTED';
		}
		else {
			$selected = '';
		}
		$output .= '<OPTION value="'.$avl_lang[$i].'" '.$selected.'>'.$display.'</OPTION>';
	}
	return $output;
}

function select_tpl($preselected = '') {
    global $txt, $HTTP_COOKIE_VARS, $HTTP_POST_VARS;

	$output 			= '';
	$tpl_config_cookie 	= isset($HTTP_COOKIE_VARS['ConfTplCookie']) ? $HTTP_COOKIE_VARS['ConfTplCookie'] : '';
	$config_selector 	= isset($HTTP_POST_VARS['config_selector']) ? $HTTP_POST_VARS['config_selector'] : '';

    $d = dir("./tpl");

    if ($config_selector != '') {
        $preselected = getGoodConfigArg('tpl');
        if ($preselected == '') {
            	$preselected = 'null';
		}
    }
    else {
        if ($tpl_config_cookie != '' && $preselected == '') {
            $preselected = $tpl_config_cookie;
        }
        if ($tpl_config_cookie == '' && $preselected == '') {
            $preselected = getGoodConfigArg('tpl');
			if ($preselected == '') {
            	$preselected = 'null-tpl';
            }
        }
    }

    while($entry=$d->read()) {
    	if ($entry != '.' && $entry != '..' && @is_dir('./tpl/'.$entry)) {
    		$avl_tpl[] = $entry;
    	}
   	}
	$d->close();
	asort($avl_tpl);
	while (list($key,$val) = each($avl_tpl)) {
		if ($preselected == $val) {
			$selected = 'SELECTED';
		}
		else {
			$selected = '';
		}
		$output .= '<OPTION value="'.$val.'" '.$selected.'>'.$val.'</OPTION>';
	}
	if ($preselected == 'null-tpl') {
		$selected = 'SELECTED';
	}
	else {
		$selected = '';
	}
	$output .= '<OPTION value="null-tpl" '.$selected.'>'.$txt['default_value'].'</OPTION>';


	return $output;
}

function getGoodConfig() {
	Global $HTTP_COOKIE_VARS, $HTTP_POST_VARS;
	Global $conf;

	$configSelect = (isset($HTTP_POST_VARS['config_selector'])) ? $HTTP_POST_VARS['config_selector'] : '';
	$cookieConfig = (isset($HTTP_COOKIE_VARS['ConfDBCookie'])) ? $HTTP_COOKIE_VARS['ConfDBCookie'] : '';

	if ($configSelect == '') {
		if ($cookieConfig == '') {
			$feedback = $conf['defaultConf'];
		}
		else {
			$feedback = $cookieConfig;
		}
	}
	else {
			$feedback = $configSelect;
	}
	return $feedback;
}

function getGoodConfigArg($arg) {
	Global $confDB;
	if (isset($confDB[getGoodConfig()][$arg])) {
		return $confDB[getGoodConfig()][$arg];
	}
	else {
		return '';
	}
}

function show_hp() {
	Global $confDB,$HTTP_COOKIE_VARS, $HTTP_POST_VARS, $conf;
	Global $font, $txt, $tplConfig, $version;
	Global $main_DB;

	$preselected_cookie = isset($HTTP_COOKIE_VARS['ConfDBCookie']) ? $HTTP_COOKIE_VARS['ConfDBCookie'] : '';
	$config_selector 	= isset($HTTP_POST_VARS['config_selector']) ? $HTTP_POST_VARS['config_selector'] : '';
    $lang_config 		= isset($HTTP_POST_VARS['lang_config']) ? $HTTP_POST_VARS['lang_config'] : '';
    $do_action 			= isset($HTTP_POST_VARS['do_action']) ? $HTTP_POST_VARS['do_action'] : '';
    $tpl_config 		= isset($HTTP_POST_VARS['tpl_config']) ? $HTTP_POST_VARS['tpl_config'] : '';
 	$MySQL_Version		= $main_DB->Infos['Full_Version'];
 	$preselected_lang 	= '';
    $preselected_tpl 	= '';

    $preselected = getGoodConfig();


    if ($do_action == 'setCookieDB') {
        setcookie('ConfDBCookie',$config_selector);
        setcookie('ConfTplCookie','');
        $preselectedConf = $config_selector;
    }
    if ($do_action == 'setCookieLang') {
        setcookie("ConfLangCookie", $lang_config);
        $preselected_lang = $lang_config;
    }
    if ($do_action == 'setCookieTpl') {
        setcookie("ConfTplCookie", $tpl_config);
        $preselected_tpl = $tpl_config;
    }

	$output  = '<SCRIPT language="Javascript">'."\n";
	$output .= '	function chg_cfg() {'."\n";
	$output .= '		document.configselect.submit();'."\n";
	$output .= '	}'."\n";
	$output .= '	function chg_lang() {'."\n";
	$output .= '		document.langselect.submit();'."\n";
	$output .= '	}'."\n";
	$output .= '	function chg_tpl() {'."\n";
	$output .= '		document.tplselect.submit();'."\n";
	$output .= '	}'."\n";
	$output .= '</SCRIPT>'."\n";
	$output .= '<TABLE border="0" width=100%>';
	$output .= '<TR>';
    $output .= '    <TD valign="top" width="10%">';
    $output .= '        <FONT '.$font.'>';
    $output .= '        <B>'.$txt['setup'].'&nbsp;: </B>';
    $output .= '        </FONT>';
    $output .= '    </TD>';


    if (count($confDB) <= 1) {
    	### If there's one configuration, don't show the select
    	$output .= '    <TD valign="top"><FONT '.$font.'>'.$confDB[0]['name'].'</FONT></TD>';
    }
    else {
        $output .= '    <TD valign="top" width="40%">';
        $output .= '		<FORM action="main.php" name="configselect" method="POST">';
        $output .= '        <INPUT type="hidden" name="do_action" value="setCookieDB">';
        $output .= '        <SELECT name="config_selector" onChange="chg_cfg();" class="trous">';
	    for ($i = 0; $i < count($confDB); $i++) {
	        $selected = ($i == $preselected) ? 'SELECTED' : '';
	        $output .= '           <OPTION VALUE="'.$i.'" '.$selected.'>'.$confDB[$i]['name'].'</OPTION>';
		}
		$output .= '        </SELECT>';
        $output .= '        </FORM>';
        $output .= '    </TD>';
    }

    $output .= '    <TD valign="top" width="10%">';
	$output .= '        <FONT '.$font.'><B>'.$txt['language'].'&nbsp;:</B></FONT>';
	$output .= '	</TD>';
	$output .= '	<TD valign="top" width="40%">';
	$output .= '        <FORM action="main.php" name="langselect" method="POST">';
	$output .= '        <INPUT type="hidden" name="do_action" value="setCookieLang">';
    $output .= '        <SELECT name="lang_config" onChange="chg_lang();" class="trous">';
	$output .=          	select_lang($preselected_lang);
	$output .= '        </SELECT>';
    $output .= '        </FORM>';
    $output .= '    </TD>';
    $output .= '<TR>';
    $output .= '    <TD valign="top">';
    $output .= '        <FONT '.$font.'><B>';
    $output .= '        '.$txt['setup_tpl'].'&nbsp;:';
    $output .= '        </B></FONT>';
    $output .= '    </TD>';
    $output .= '    <TD valign="top">';
    $output .= '        <FORM action="main.php" name="tplselect" method="POST">';
    $output .= '        <INPUT type="hidden" name="do_action" value="setCookieTpl">';
    $output .= '        <SELECT name="tpl_config" onChange="chg_tpl();" class="trous">';
    $output .=              select_tpl($preselected_tpl);
    $output .= '        </SELECT>';
    $output .= '        </FORM>';
    $output .= '	</TD>';
    $output .= '	<TD colspan="2" valign="top" width="50%">';
    $output .= '		<FONT '.$font.'>';

    if ($conf['showMysqlState'] && !getGoodConfigArg('db')) {
    	$output .= '		<A href="main.php?db=mysql&action=show_mysql_state">'.$txt['show_mysql_state'].'</A>';
    }
    if ($conf['showMysqlVars'] && !getGoodConfigArg('db')) {
    	$output .= '		<BR><A href="main.php?db=mysql&action=show_mysql_vars">'.$txt['show_mysql_vars'].'</A>';
    }
    if ($conf['showMysqlProcess'] && !getGoodConfigArg('db')) {
    	$output .= '		<BR><A href="main.php?db=mysql&action=show_mysql_process">'.$txt['show_mysql_process'].'</A>';
    }
    $output .= '		</FONT>';
    $output .= '	</TD>';
    $output .= '</TR>';
    $output .= '<TR>';
    $output .= '	<TD colspan="2">';
    $output .= '		<FONT '.$font.'><B>eskuel v '.$version.'</B>&nbsp;<A href="http://eskuel.sourceforge.net/site/upgrade-eskuel.php?v='.$version.'&lang='.$txt['config_name'].'" target="_blank">'.$txt['check_version'].'</A>';
    $output .= '    	</FONT>';
    $output .= '	</TD>';
    $output .= '	<TD colspan="2">';
    $output .= '		<FONT '.$font.'><B>MySQL v '.$MySQL_Version.'</B></FONT>';
    $output .= '</TD>';
   	$output .= '</TR>';
	$output .= '</TABLE>';

	$output .= show_tips(0);
	return $output;
}

function magic_quote_bypass($arg) {
	if (get_magic_quotes_gpc()) {
		$arg = stripslashes($arg);
	}
	return $arg;
}

function start_timing() {
	$time_grab = explode(' ',microtime() );
    $start_time = $time_grab[1].substr($time_grab[0], 1);
    return $start_time;
}

function print_timing($start_time) {
	Global $txt;

	$timeparts = explode(' ',microtime() );
	$end_time = $timeparts[1].substr($timeparts[0],1);
	$timing = number_format($end_time - $start_time, 4);
	return $txt['timed_query'].' '.$timing.' '.$txt['secondes'].'<BR>';
}

function select_database($sql_ref, $select_name, $preselected = '') {
	$output = '<SELECT name='.$select_name.' class="trous">';
  	if (getGoodConfigArg('db') == '') {
    	$sql_ref->query("SHOW DATABASES");

        while ( $arrDB = $sql_ref->next_record() ) {
			if ( $preselected == $arrDB[0] ) {
				$selected = 'SELECTED';
			}
			else {
				$selected = '';
			}
			$output .= '<OPTION VALUE='.$arrDB[0].' '.$selected.'>'.$arrDB[0].'</OPTION>'."\n";
		}
	}
	else {
		$output .= '<OPTION VALUE='.getGoodConfigArg('db').'>'.getGoodConfigArg('db').'</OPTION>'."\n";
	}
	$output .= '</SELECT>';
	return $output;
}

#####################################
# Build the navigation tree of a DB
# (list only the tables for a given
# DB)
# $sql_ref = SQL link to the base
# $db = the DB which contains the
#       table to show
#####################################
function list_left_table($sql_ref,$db){
	Global $font, $colors, $txt;

	$img_path 	= $colors['img_path'];
	$tbl_infos 	= $sql_ref->getTblsInfos();
	$out 		= '';

	for ($i = 0; $i < $tbl_infos['Number_Of_Tables']; $i++) {
		$current_tbl = $tbl_infos['Tables_List'][$i];
		$out .= '<tr>'."\n";
		$out .= '	<td align="left"><img src="'.$img_path.'img/coin.gif"></td>'."\n";

		if ($tbl_infos[$current_tbl]['Rows'] != 0) {
        	$out .= '	<td align="left" nowrap><a href="main.php?db='.urlencode($db).'&tbl='.urlencode($current_tbl).'&action=view"><img src="'.$img_path.'img/tbl.gif" border="0" '.link_status($txt['tbl'].' '.$current_tbl.' ('.$txt['display_content'].')').'></a><img src="img/vide.gif" width=2 height=1><font '.$font.'><a href="main.php?db='.urlencode($db).'&tbl='.urlencode($current_tbl).'" '.link_status($txt['tbl'].' '.$current_tbl).'>'.$current_tbl.'</a> ('.$tbl_infos[$current_tbl]['Rows'].')</font></td>'."\n";
        	$out .= '</tr>'."\n";
		}
        else {
        	$out .= '	<td align="left" nowrap><img src="'.$img_path.'img/tbl.gif" border="0"  '.link_status($txt['empty_tbl']).'><img src="img/vide.gif" width=2 height=1><font '.$font.'><a href="main.php?db='.urlencode($db).'&tbl='.urlencode($current_tbl).'"  '.link_status($txt['tbl'] .' '.$current_tbl).'>'.$current_tbl.'</A> ('.$tbl_infos[$current_tbl]['Rows'].')</font></td>'."\n";
        	$out .= '</tr>'."\n";
		}

	}
	return $out;
}

#####################################
# Find if an element if present
# or not in an array
# => in_array() in php4, php3 compat.
# $elt = element to find in the array
# $arr = the array
#####################################
function is_in_array($elt,$arr) {
	for ($i=0; $i < count($arr); $i++) {
		if ($arr[$i] == $elt) {
			return 1;
		}
	}
	return 0;
}

function get_mysql_version($sql_ref) {

	@$sql_ref->query("SHOW VARIABLES LIKE 'version'");
    $resultset = $sql_ref->next_record();
    if (is_array($resultset)) {
    	$mysql_version = $resultset['Value'];
    	$version_array = explode('.',$mysql_version);
    	return (int)sprintf('%d%d%02d', $version_array[0], $version_array[1], intval($version_array[2]));
    }
    else {
    	return -1;
    }
}

function sql_back_ticks($str, $sql_ref) {
	if ($sql_ref->Infos['Version'] >= 32306) {
		$str = '`'.$str.'`';
	}


	return $str;
}

#####################################
# Replacement function for
# SHOW CREATE TABLE statement
# $tbl = the table
# $sql_ref = link to the db
#####################################
function show_create_table($tbl, $sql_ref) {

	$primary 	= array();
	$primary_part = '';

	$output = 'CREATE TABLE '.sql_back_ticks($tbl, $sql_ref). ' ('."\n";
	$sql_ref->query('SHOW FIELDS FROM '.sql_back_ticks($tbl, $sql_ref));

	while ($res = $sql_ref->next_record()) {
		$field_name 	= $res['Field'];
		$field_type 	= isset($res['Type']) ? ' '.$res['Type'] : '';
		$field_null 	= ($res['Null'] == 'YES') ? '' : ' NOT NULL ';
		$field_key		= $res['Key'];
		$field_default 	= (isset($res['Default']) && $res['Default'] != '') ? 'DEFAULT \''.addSlashes($res['Default']).'\' ' : '';
		$field_extra 	= $res['Extra'];

		$output .= '    '.sql_back_ticks($field_name, $sql_ref);
		$output .= $field_type.$field_null;
		$output .= $field_default.$field_extra.",\n";
	}

	### Key part of the query
	$sql_ref->query('SHOW KEYS FROM '.sql_back_ticks($tbl, $sql_ref));
	$key_part = '';
	while ($res = $sql_ref->next_record()) {
		$key_name 		= $res['Key_name'];
		$non_unique 	= $res['Non_unique'];
		$column_name	= $res['Column_name'];

		if ($key_name == 'PRIMARY') {
			$primary[] = $column_name;
		}
		else {
			if ($non_unique == 1) {
				$key_part .= '    KEY '.sql_back_ticks($key_name, $sql_ref).' ('.sql_back_ticks($column_name, $sql_ref).'),'."\n";
			}
			else {
				$key_part .= '    UNIQUE '.sql_back_ticks($key_name, $sql_ref).' ('.sql_back_ticks($column_name, $sql_ref).'),'."\n";
			}
		}
	}

	for ($i = 0; $i < count($primary); $i++) {
		$primary_part .= sql_back_ticks($primary[$i], $sql_ref);
		if ( ($i + 1) < count($primary) ) {
			$primary_part .= ', ';
		}
	}
	if ($primary_part != '') {
		$key_part = '    PRIMARY KEY ('.$primary_part.'),'."\n".$key_part;

	}
	if ($key_part != '') {
		$key_part = substr($key_part, 0, strlen($key_part) - 2)."\n";
	}

	$output .= $key_part;
	$output .= ');'."\n";

	return $output;
}

function like_table($tbl) {

	$feedback = stripSlashes($tbl);
	$feedback = str_replace('%','\%',$feedback);
	$feedback = str_replace("'","\'",$feedback);
	return $feedback;
}

#####################################
# Display a 'return to table XXX' link
# $db = the current database
# $tbl = the table
#####################################
function return_2_table($db,$tbl) {
	Global $txt;
    return '<BR><BR><A href="main.php?db='.urlencode($db).'&tbl='.urlencode($tbl).'">'.$txt['back_2_tbl'].' '.$tbl.'</A>';
}

#####################################
# Display a 'return to Database XXX' link
# $db = the current database
#####################################
function return_2_db($db) {
	Global $txt;
	return '<BR><BR><A href="main.php?db='.urlencode($db).'">'.$txt['back_2_db'].' '.$db.'</A>';
}

function display_bookmarkable_query($query) {
	Global $txt, $colors;

	$feedback  = '<FORM action="" method="POST" name="bookmark">';
	$feedback .= '<INPUT type="hidden" name="sql" value="'.base64_encode($query).'">';
	$feedback .= '</FORM>';
	$feedback .= '<B>'.$txt['sql_query'].' :</B><BR>';
	$feedback .= '<A HREF="Javascript:popup(\'popup_bookmark.php?action=add&sql=\'+document.bookmark.sql.value+\'\', \'BookmarkPopup\', 420, 400);"><IMG SRC="'.$colors['img_path'].'img/bookmark.gif" '.link_status($txt['bkmk_this']).' BORDER="0"></A>&nbsp;'.nl2br(htmlentities($query)).'<BR>';

	return $feedback;
}
function display_field_form($type, $name, $default = '') {

	switch (1) {
		case eregi('enum',$type):
			$enum_values	= explode(',',substr($type, 5, ( strlen($type) - 6) ));
			$output 		= '<SELECT NAME="'.$name.'" class="trous">';

			for ($i = 0; $i < count($enum_values); $i++) {
	        	# removing the ' around each values

                $display_default_values = substr($enum_values[$i],1,strlen($enum_values[$i])-2);

				if ($display_default_values == $default) {
	            	$selected = 'SELECTED';
				}
            	else {
	            	$selected = '';
				}
				$output .= '<OPTION value="'.htmlentities($display_default_values).'" '.$selected.'>'.$display_default_values.'</OPTION>';
			}
        	$output .= '</SELECT>';
		break;

		case eregi('set',$type):

    		$set_values = explode(',',substr($type, 4, ( strlen($type) - 5) ));
        	$output 	= '<SELECT NAME="'.$name.'[]" multiple="multiple" class="trous">';
            $default 	= explode(',',$default);

			for ($i = 0; $i < count($set_values); $i++) {
	        	# removing the ' around each values

	            $display_default_values = substr($set_values[$i],1,strlen($set_values[$i])-2);

                if (is_in_array($display_default_values,$default)) {
	            	$selected = 'SELECTED';
				}
	            else {
	            	$selected = '';
				}

				$output .= '<OPTION value="'.htmlentities($display_default_values).'" '.$selected.'>'.$display_default_values.'</OPTION>';
			}
	        $output .= '</SELECT>';
		break;

        case eregi('char',$type):
        case eregi('varchar',$type):
			$var_length = substr($type, strpos($type,'(') + 1, strlen($type)- strpos($type,'(')-2 );
			if ($var_length > 50) {
				$output = '<TEXTAREA name="'.$name.'" rows=5 cols=25 class="trous">'.htmlentities($default).'</TEXTAREA>';
			}
			else {
				$output = '<INPUT type="text" name="'.$name.'" value="'.htmlentities($default).'" class="trous">';
			}
		break;


		case eregi('blob',$type):
		case eregi('text',$type):
			$output = '<TEXTAREA name="'.$name.'" rows=5 cols=25 class="trous">'.htmlentities($default).'</TEXTAREA>';
		break;

		case eregi('datetime', $type) :
			$default = ($default == '0000-00-00 00:00:00') ? date("Y-m-d H:i:s") : $default;
			$output = $output = '<INPUT type="text" name="'.$name.'" value="'.htmlentities($default).'" class="trous">';
		break;

		case eregi('date', $type) :
			$default = ($default == '0000-00-00') ? date("Y-m-d") : $default;
			$output = $output = '<INPUT type="text" name="'.$name.'" value="'.htmlentities($default).'" class="trous">';
		break;

		case eregi('time', $type) :
			$default = ($default == '00:00:00') ? date("H:i:s") : $default;
			$output = $output = '<INPUT type="text" name="'.$name.'" value="'.htmlentities($default).'" class="trous">';
		break;

		case eregi('year', $type) :
			$default = ($default == '0000' && strlen($default) == 4) ? date("Y") : $default;
			$default = ($default == '00' && strlen($default) == 2) ? date("y") : $default;
			$output = $output = '<INPUT type="text" name="'.$name.'" value="'.htmlentities($default).'" class="trous">';
		break;

		default:
    		$output = '<INPUT type="text" name="'.$name.'" value="'.htmlentities($default).'" class="trous">';
		break;

	}
    return $output;
}

function priv_str_repeat($str,$count) {
	$feedback = '';
	for ($i = 0; $i < $count; $i++) {
        $feedback .= $str;
	}
	return $feedback;
}

function show_tips($html, $random = 0, $never = 0, $old_one = 0) {
	Global $HTTP_COOKIE_VARS, $txt, $colors, $font, $conf, $css;
	$css 			= 12;
	$img_path 		= $colors['img_path'];
	$tips_cookie 	= (isset($HTTP_COOKIE_VARS['ConfTipsCookie'])) ? $HTTP_COOKIE_VARS['ConfTipsCookie'] : '';

	include './lang/tips_'.$txt['config_name'].'.inc.php';

	if (($tips_cookie == 'never' || $tips_cookie == 'done' || !$conf['tipsOfTheDay']) && !$random && !$html) {
		return '';
	}

	$day = date("j");

	if ($random == 1) {
		mt_srand((double)microtime()*1000000);
  		$randval = mt_rand(1,count($tips));
  		while ($randval == $old_one) {
			$randval = mt_rand(1,count($tips));
		}
  		$tips = $tips[$randval];
  		$current_tip = $randval;
	}
	else {
		$tips = $tips[$day];
		$current_tip = $day;
	}

	if ($html == 1) {
		if ($never == 1) {
			$expiration_date = mktime('23','59','59',date('m'),date('d'),date('Y')+10);
			setcookie('ConfTipsCookie','never',$expiration_date);
			echo '<SCRIPT language="Javascript">
					window.close();
				</SCRIPT>';
		}

		$output = '<HTML>
				<HEAD>
				<TITLE>eskuel > '.$txt['tips_day'].'</TITLE>
				<META HTTP-EQUIV="Pragma"  CONTENT="no-cache">
				<META HTTP-EQUIV="Cache-Control" CONTENT="no-cache">
				<META HTTP-EQUIV="Expires" CONTENT="Mon, 06 May 1996 04:57:00 GMT">
				<META HTTP-EQUIV="content-type" CONTENT="text/html; charset='.$txt['charset'].'">
				<style type="text/css">
				<!--
				.trous { background-color: '.$colors['trou_bg'].'; border: 1 '.$colors['trou_border'].' solid; color: '.$colors['trou_font'].'; font-family: '.$font.'; font-size: '.$css.'px; scrollbar-3dlight-color:'.$colors['trou_bg'].'; scrollbar-arrow-color:'.$colors['trou_border'].'; scrollbar-base-color:'.$colors['trou_bg'].'; scrollbar-darkshadow-color:'.$colors['trou_bg'].'; scrollbar-face-color:'.$colors['trou_bg'].'; scrollbar-highlight-color:'.$colors['trou_bg'].'; scrollbar-shadow-color:'.$colors['trou_bg'].' }
				.bosses {  background-color: '.$colors['bosse_bg'].'; border: 1px '.$colors['bosse_border'].' dotted; color: '.$colors['bosse_font'].'}
				.pick { background-color: '.$colors['pick_bg'].'; color: '.$colors['pick_border'].'; font-family: '.$font.', sans-serif; font-size: '.$css.'px}
				-->
				</style>
				</head>
				<body bgcolor="'.$colors['table_bg'].'" vlink="'.$colors['vlink'].'" link="'.$colors['link'].'" text="'.$colors['text'].'" alink="'.$colors['alink'].'" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
				<TABLE border="0" cellspacing="0" cellpadding="0" width="300">
				<TR>
					<TD>
						<TABLE border=0 width="100%" cellpadding="15" cellspacing="0" >
						<TR>
							<TD valign="top" colspan="2" bgcolor="'.$colors['titre_bg'].'"><IMG src="img/tips.gif" align="absmiddle">&nbsp;&nbsp;<FONT '.$font.'><FONT size="+1" color="'.$colors['titre_font'].'"><B>'.$txt['tips_day'].'</B></FONT></FONT></TD>
						</TR>
						</TABLE>
					</TD>
				</TR>
				<TR>
					<TD bgcolor="'.$colors['bordercolor'].'" colspan="2" width="100%"><IMG src="img/vide.gif" width="100" height="2"></TD>
				</TR>
				<TR>
					<TD>
						<TABLE cellspacing="0" cellpadding="15" border="0" width="100%">
						<TR>
							<TD width="30%">
								<FONT '.$font.'>
								<A href="main.php?action=show_tips&html=1&random=1&old_one='.$current_tip.'">'.$txt['next_tip'].'</A>
								<BR><BR><A href="main.php?action=show_tips&html=1&never=1">'.$txt['dont_show_again'].'</A>
								<BR><BR><A href="javascript:window.close();">'.$txt['close_popup'].'</A>
								</FONT>
							</TD>
							<TD width="70%" valign="top"><FONT '.$font.'>'.$tips.'</FONT></TD>
						</TR>
						</TABLE>
					</TD>
				</TR>
				</TABLE>
				<SCRIPT language="Javascript">
				window.focus();
				</SCRIPT>
				</BODY>
				</HTML>';
	}
	else {
        setcookie('ConfTipsCookie','done');

		$output = '<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">
        <!--
        function open_tips()
        {
            var largeur=screen.width
            var hauteur=screen.height

            var url="main.php?action=show_tips&html=1"
            var name="tipsPopup"
            var largeur_popup=300
            var hauteur_popup=200

            var pos_left=Math.round((largeur/2)-(largeur_popup/2))
            var pos_top=Math.round((hauteur/2)-(hauteur_popup/2))

            window.open(url,name,"toolbar=0,location=0,directories=0,resizable=0,copyhistory=1,menuBar=0,left=" + pos_left + ",top=" + pos_top + ",width=" + largeur_popup + ",height=" + hauteur_popup);
        }
        open_tips();
        //-->
        </SCRIPT>';
	}

	return $output;
}

$coded = 'DQoNCi8qKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioNCiAgICAgICAgICAgICBfX19fICBfICAgXyBfX19fICBfICAgICAgICAgICAgICBfICAgICBfICBfICAgXyAgIF8NCiAgICAgICAgICAgIHwgIF8gXHwgfCB8IHwgIF8gXHwgfF8gX19fICAgX19fIHwgfF9fX3wgfHwgfCB8IHwgfCB8DQogICAgICAgICAgICB8IHxfKSB8IHxffCB8IHxfKSB8IF9fLyBfIFwgLyBfIFx8IC8gX198IHx8IHxffCB8IHwgfA0KICAgICAgICAgICAgfCAgX18vfCAgXyAgfCAgX18vfCB8fCAoXykgfCAoXykgfCBcX18gXF9fICAgX3wgfF98IHwNCiAgICAgICAgICAgIHxffCAgIHxffCB8X3xffCAgICBcX19cX19fLyBcX19fL3xffF9fXy8gIHxffCAgXF9fXy8NCg0KICAgICAgICAgICAgICAgICAgICAgICBlU0tVZUwgLSBNeVNRTCBBZG1pbmlzdHJhdGlvbg0KICAgICAgICAgICAgICAgICAgICAgICAgICAgICAtLS0tLS0tLS0tLS0tLS0tLS0tDQpiZWdpbiAgICAgICAgICAgICAgICA6IERlYyAyMDAxDQpjb3B5cmlnaHQgICAgICAgICAgICA6IChDKSAyMDAxIFBIUHRvb2xzNFUuY29tIC0gTWF0aGlldSBMRVNOSUFLIC0gTGF1cmVudCBHT1VTU0FSRA0KZW1haWwgICAgICAgICAgICAgICAgOiBtYXRoaWV1QHBocHRvb2xzNHUuY29tIC0gbGF1cmVudEBwaHB0b29sczR1LmNvbQ0KDQoqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKiovDQoNCi8qKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioNCioNCiogICBUaGlzIHByb2dyYW0gaXMgZnJlZSBzb2Z0d2FyZTsgeW91IGNhbiByZWRpc3RyaWJ1dGUgaXQgYW5kL29yIG1vZGlmeQ0KKiAgIGl0IHVuZGVyIHRoZSB0ZXJtcyBvZiB0aGUgR05VIEdlbmVyYWwgUHVibGljIExpY2Vuc2UgYXMgcHVibGlzaGVkIGJ5DQoqICAgdGhlIEZyZWUgU29mdHdhcmUgRm91bmRhdGlvbjsgZWl0aGVyIHZlcnNpb24gMiBvZiB0aGUgTGljZW5zZSwgb3INCiogICAoYXQgeW91ciBvcHRpb24pIGFueSBsYXRlciB2ZXJzaW9uLg0KKg0KKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqLw==';
?>