<?php

$img_path = $colors['img_path'];

$left_navigation  = '<table border="1" cellspacing="0" cellpadding="5" bordercolor="'.$colors['bordercolor'].'">'."\n";
$left_navigation .= '<tr>'."\n";
$left_navigation .= '	<td align="center" bgcolor="'.$colors['titre_bg'].'"';

if (@is_file('tpl/'.$path.'/titre_bg.gif')){
	$left_navigation.=' background="tpl/'.$path.'/titre_bg.gif"';
}

$left_navigation.='>'."\n";
$left_navigation .= '		<table border="0" cellspacing="0" cellpadding="0">'."\n";
$left_navigation .= '		<tr>'."\n";
$left_navigation .= '			<td><img src="'.$img_path.'img/home.gif">&nbsp;</td>'."\n";
$left_navigation .= '			<td colspan="2"><b><a href="main.php"><font '.$font.' color="'.$colors['titre_font'].'">eSKUeL</font></a></b></td>'."\n";
$left_navigation .= '		</tr>'."\n";
$left_navigation .= '		</table>'."\n";
$left_navigation .= '	</td>'."\n";
$left_navigation .= '</tr>'."\n";
$left_navigation .= '<tr>'."\n";
$left_navigation .= '	<td align="center" bgcolor="'.$colors['table_bg'].'">'."\n";
$left_navigation .= '		<table border="0" cellspacing="0" cellpadding="0">'."\n";

### Multiple DB configuration, showing all DBs
if ($main_DB->only_DB == '' ) {
        $main_DB->query("SHOW DATABASES");
        
        while ($list = $main_DB->next_record()) {

            
            if ($db == $list['Database']) {
                ### Current DB, add the collapse arg to collapse the table list
                $collapse = ($collapse == '' || $collapse == 0) ? 1 : 0;
                $arg_collapse = '&collapse='.$collapse;
            }
            else {
            	$arg_collapse = '';
            }

			$left_navigation .= '<tr>'."\n";
			$left_navigation .= '	<td><a href="main.php?db='.urlencode($list['Database']).$arg_collapse.'"><img src="'.$img_path.'img/bdd.gif" border="0" '.link_status($txt['db'].' '.$list['Database']).'></a></td>'."\n";
			$left_navigation .= '	<td colspan="2"><font '.$font.'>&nbsp;<a href="main.php?db='.urlencode($list['Database']).$arg_collapse.'" '.link_status($txt['db'].' '.$list['Database']).'>'.$list['Database'].'</a></font></td>'."\n";
			$left_navigation .= '</tr>'."\n";
			
			if ($db == $list['Database'] && $collapse == 1){
				$left_navigation .= list_left_table($main_DB,$list['Database']);
			}
        }
}
### Only one db must be shown
else {
        $left_navigation .= '<tr>'."\n";
        $left_navigation .= '	<td><font '.$font.'><a href="main.php?db='.urlencode($main_DB->only_DB).'"><img src="'.$img_path.'img/bdd.gif" border="0"></a></font></td>'."\n";
        $left_navigation .= '	<td colspan="2"><font '.$font.'>&nbsp;<a href="main.php?db='.urlencode($main_DB->only_DB).'">'.$main_DB->only_DB.'</a></font></td>'."\n";
        $left_navigation .= '</tr>'."\n";

		if ($db == $main_DB->only_DB && $main_DB->Link_ID != 0){
			$left_navigation .= list_left_table($main_DB,$main_DB->only_DB);
		}
}

$left_navigation .='        </table>'."\n";
$left_navigation .= '	</td>'."\n";
$left_navigation .= '</tr>'."\n";
$left_navigation .= '</table>';
?>