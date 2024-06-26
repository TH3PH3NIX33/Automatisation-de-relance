<?php

require './config.inc.php';
require './include/mysql.inc.php';
require './include/functions.inc.php';
require './include/dump.inc.php';

### Getting / Setting vars
$globalConfig 		= select_config();
$tplConfig 			= $globalConfig['tpl'];
$sqlConfig 			= $globalConfig['sql'];
$txt 				= $globalConfig['txt'];
$design 			= $globalConfig['design'];

$colors 			= $design['colors'];
$font 				= $design['font'];
$css				= 12;
$img_path 			= $colors['img_path'];

$db 				= reg_glob('db');
$tbl				= reg_glob('tbl');
$offset				= reg_glob('offset');
$split				= reg_glob('split');
$type				= reg_glob('type');
$dumpwindow 		= isset($HTTP_GET_VARS['dumpwindow']) ? $HTTP_GET_VARS['dumpwindow'] : '';
$navbar				= isset($HTTP_GET_VARS['navbar']) ? $HTTP_GET_VARS['navbar'] : '';
$step 				= isset($HTTP_GET_VARS['step']) ? $HTTP_GET_VARS['step'] : '';
$options			= isset($HTTP_GET_VARS['options']) ? $HTTP_GET_VARS['options']  :'';
$nbRecords			= isset($HTTP_GET_VARS['nbRecords']) ? $HTTP_GET_VARS['nbRecords'] : '';
$feedback			= '';
$complete_insert 	= 0;
$drop_table 		= 0;


### Building an array containing the n°(offset) of tables to dump
$tbl_list = explode('|', $tbl);

$db = stripSlashes($db);



$popup_DB = new DB($sqlConfig);
$popup_DB->select_db($db);
$popup_DB->storeTblsInfos();

if ($popup_DB->Infos['Version'] >= 32303) {
	$popup_DB->query("SHOW TABLE STATUS");

	### Building 2 arrays : names and records
	while ($list = $popup_DB->next_record()) {
			$tbl_list_name[] = $list[0];
			$tbl_list_records[] = $list[3];
	}
}
else {
	$popup_DB->query('SHOW TABLES FROM '.sql_back_ticks($db, $popup_DB));
	while ($list = $popup_DB->next_record()) {
		$tbl_list_name[] = $list[0];
		$popup_DB2 = new DB($sqlConfig);
		$popup_DB2->query('SELECT COUNT(*) FROM '.sql_back_ticks($list[0], $popup_DB));
		list($tbl_list_records[]) = $popup_DB2->next_record();
	}

}

if (count($tbl_list) > 1) {
	### Multiple tables, counting the nb of records

	if ($nbRecords == '') {

		for ($i = 0; $i < count($tbl_list); $i++) {
			$tbl_2_dump 	= $tbl_list[$i];
			$current_tbl 	= $tbl_list_name[$tbl_2_dump];
			$nbRecords += $tbl_list_records[$tbl_2_dump];
		}
	}

}
else {
	$tbl_2_dump = $tbl_list[0];
	$current_tbl = $tbl_list_name[$tbl_2_dump];
	$nbRecords = $tbl_list_records[$tbl_2_dump];

}

if ($nbRecords == '') {
	$nbRecords = 0;
}
if ( ($offset + $split) > $nbRecords ) {
	$limit = $nbRecords;
}
else {
	$limit = $offset + $split;
}

$step = ($step == '') ? 0 : ($step + 1);
switch ($options) {
	case '1':
		$complete_insert = 1;
	break;

	case '2':
		$drop_table = 1;

	break;

	case '3':
		$complete_insert = 1;
		$drop_table = 1;

	break;
}

if ($navbar == 1) {
	if (count($tbl_list) == 1) {
		$tbl_js = $tbl_list_name[$tbl_2_dump];
	}
	else {
		$tbl_js = '';
	}

	$url_meta = 'popup_dump.php?dumpwindow=1&offset='.$offset.'&split='.$split.'&nbRecords='.$nbRecords.'&db='.urlencode(addSlashes($db)).'&tbl='.urlencode($tbl).'&type='.$type.'&options='.$options.'&step='.$step;
	echo '<HTML>
			<HEAD>
			<style type="text/css">
			<!--
				.trous { background-color: '.$colors['trou_bg'].'; border: 1 '.$colors['trou_border'].' solid; color: '.$colors['trou_font'].'; font-family: '.$font.'; font-size: '.$css.'px; scrollbar-3dlight-color:'.$colors['trou_bg'].'; scrollbar-arrow-color:'.$colors['trou_border'].'; scrollbar-base-color:'.$colors['trou_bg'].'; scrollbar-darkshadow-color:'.$colors['trou_bg'].'; scrollbar-face-color:'.$colors['trou_bg'].'; scrollbar-highlight-color:'.$colors['trou_bg'].'; scrollbar-shadow-color:'.$colors['trou_bg'].' }
				.bosses {  background-color: '.$colors['bosse_bg'].'; border: 1px '.$colors['bosse_border'].' dotted; color: '.$colors['bosse_font'].'}
				.pick { background-color: '.$colors['pick_bg'].'; color: '.$colors['pick_border'].'; font-family: '.$font.', sans-serif; font-size: '.$css.'px}
			-->
			</style>
			<SCRIPT language="Javascript">
			function refresh_main() {
				parent.opener.location = "main.php?db='.urlencode($db).'&tbl='.urlencode($tbl_js).'";
				parent.close();
			}
			</SCRIPT>
			<meta HTTP-EQUIV="Refresh" CONTENT="2;URL='.$url_meta.'">


			</HEAD>
			<body bgcolor="'.$colors['bgcolor'].'" vlink="'.$colors['vlink'].'" link="'.$colors['link'].'" text="'.$colors['text'].'" alink="'.$colors['alink'].'" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
			<table border="1" cellspacing="0" cellpadding="5" bordercolor="'.$colors['bordercolor'].'" width="300">
        	<tr>
          		<td align="center" bgcolor="'.$colors['titre_bg'].'"';

	if (@is_file('./tpl/'.$path.'/titre_bg.gif')){
		 echo ' background="tpl/'.$path.'/titre_bg.gif"';
	}

    echo '        	>
    				<table border="0" cellspacing="0" cellpadding="0">
              		<tr>
                		<td><img src="'.$img_path.'img/home.gif">&nbsp;</td>
                		<td colspan="2"><font '.$font.'><b><font color="'.$colors['titre_font'].'">eSKUeL</font></b></font></td>
              		</tr>
            		</table>
          		</td>
        	</tr>
        	<tr>
          		<td align="center" bgcolor="'.$colors['table_bg'].'">';
	### Avoiding division by zero :o)
	if ($nbRecords) {
		$percentage = round((100 * $limit)/$nbRecords);
	}
	else {
		$percentage = 100;
	}

	### Displaying percentage progress bar
	echo '		<table border="1" cellspacing="0" cellpadding="3" bordercolor="'.$colors['bordercolor'].'" width="206">
				<tr>
					<td>
						<table border="0" width="200" height="15" cellpadding="0" cellspacing="0">
						<tr>
							<td width="'.($percentage*2).'" bgcolor="'.$colors['bgcolor'].'"><img src="img/vide.gif" width="'.($percentage*2).'" height="15" title="'.$percentage.' %"></td>
							<td width="'.(200-($percentage*2)).'"><img src="img/vide.gif" width="'.(200-($percentage*2)).'" height="15"></td>
						</tr>
						</table>
					</td>
				</tr>
				</table>';


	if ($nbRecords <= $limit) {
		echo '<FONT '.$font.'>'.$txt['dump_finished'].'<BR><A href="javascript:refresh_main();">'.$txt['close_window'].'</A>';
	}
	else {

		echo '	<FONT '.$font.'>'.$txt['dump_status'].'<BR>'.$txt['from'].' '.$offset.' '.$txt['to'].' '.$limit.' / '.$nbRecords.'
            	<FORM action="popup_dump.php" method="GET" name="frmnavbar">
            	<INPUT type="hidden" name="navbar" value="1">
            	<INPUT type="hidden" name="split" value="'.$split.'">
            	<INPUT type="hidden" name="offset" value="'.$limit.'">
            	<INPUT type="hidden" name="tbl" value="'.$tbl.'">
            	<INPUT type="hidden" name="db" value="'.$db.'">
            	<INPUT type="hidden" name="step" value="'.$step.'">
            	<INPUT type="hidden" name="nbRecords" value="'.$nbRecords.'">
            	<INPUT type="hidden" name="type" value="'.$type.'">
            	<INPUT type="submit" class="bosses" value="'.$txt['next'].' >>">
            	</FORM>';
       	echo '	<BR>'.$txt['dump_wait'].'.';
	}
    echo '	<BR>'.$txt['dump_dont_start'].' <A href="'.$url_meta.'">'.$txt['dump_here'].'</A>.';
    echo '			</font>';
    echo '		</td>';
    echo '	</tr>';
    echo '  </table>';
	echo '	</BODY></HTML>';

}
if ($dumpwindow == 1) {
	$ext = 'sql';

	if (count($tbl_list) > 1) {
		$tbl = "Multi-dump-".$db;
		$already_done = 0;
		$past_tbl = 0;
		$tmp_offset = $offset;
		$rec_2_do = $split;
			for ($i = 0; $i < count($tbl_list); $i++) {

				$current_tbl_records = $tbl_list_records[$tbl_list[$i]];

				### Check if we've already done the amount of records
				if ($already_done < $rec_2_do) {

					### Are we in the good table range ?
					if ( $tmp_offset < ($current_tbl_records + $past_tbl) ) {

						### Do we have enough records in the current table
						if ( ($current_tbl_records + $past_tbl) > ($tmp_offset + $split) ) {
							### YES

							$feedback .= do_data_dump($popup_DB, $tbl_list_name[$tbl_list[$i]], $complete_insert, ($tmp_offset - $past_tbl),$split, '', 1);
							$already_done += $split;

						}
						else {
							### NO

							$feedback .= do_data_dump($popup_DB, $tbl_list_name[$tbl_list[$i]], $complete_insert, ($tmp_offset - $past_tbl), ( ($current_tbl_records + $past_tbl) - $tmp_offset),'',1);
							$already_done += ( ($current_tbl_records + $past_tbl) - $tmp_offset);
							$split -= ( ($current_tbl_records + $past_tbl) - $tmp_offset);
							$tmp_offset = $current_tbl_records + $past_tbl;
						}
					}
				}
				$past_tbl += $current_tbl_records;
			}
		if ($step == 1) {

			### Add the 'CREATE TABLE XXX'
			if ($type == 1) {
				for ($i = 0; $i < count($tbl_list); $i++) {
					$feedback = do_structural_dump($popup_DB,$tbl_list_name[$tbl_list[$i]]).$feedback;
				}
			}
			### Add the 'DROP TABLE IF EXISTS'
			if ($drop_table == 1) {
				for ($i = 0; $i < count($tbl_list); $i++) {
					$feedback = 'DROP TABLE IF EXISTS '.sql_back_ticks($tbl_list_name[$tbl_list[$i]], $popup_DB).";\n".$feedback;
				}
			}
		}
	}
	else {
		$tbl = $current_tbl;
		$feedback = do_data_dump($popup_DB, $tbl, $complete_insert, $offset, $split,'',1);
		if ($step == 1) {
			if ($type == 1) {
				$feedback = do_structural_dump($popup_DB,$tbl).$feedback;
			}
			if ($drop_table == 1) {
				$feedback = 'DROP TABLE IF EXISTS '.sql_back_ticks($tbl, $popup_DB).";\n".$feedback;
			}
		}
	}

    if (eregi('MSIE',$HTTP_USER_AGENT) || eregi('opera', $HTTP_USER_AGENT)) {
        $content_type = 'application/octetstream';

    }
    else {
        $content_type = 'application/octet-stream';
    }
    if (eregi('MSIE', $HTTP_USER_AGENT)) {
        $content_disposition = 'inline';
    }
    else {
        $content_disposition =  'attachment';
    }

    header('Content-Type: '.$content_type);
	header('Content-Disposition: '.$content_disposition.'; filename="'.$tbl.'-'.$step.'.'.$ext.'"');
    header('Content-Description: SQL data dump');

    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");    // Date in the past
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
                                                            // always modified
    header("Cache-Control: no-store, no-cache, must-revalidate");  // HTTP/1.1
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");


    header('Expires: 0');
	echo $feedback;
	die();

}
?>