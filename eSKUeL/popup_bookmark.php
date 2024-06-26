<?php

require './config.inc.php';
require './include/mysql.inc.php';
require './include/functions.inc.php';
require './include/design.inc.php';

$globalConfig 	= select_config();
$tplConfig 		= $globalConfig['tpl'];
$sqlConfig 		= $globalConfig['sql'];
$txt 			= $globalConfig['txt'];
$design 		= $globalConfig['design'];

$colors 		= $design['colors'];
$font 			= $design['font'];
$sql			= isset($sql) ? $sql : '';
$action			= isset($HTTP_GET_VARS['action']) ? $HTTP_GET_VARS['action'] : '';
$confirm		= isset($HTTP_GET_VARS['confirm']) ? $HTTP_GET_VARS['confirm'] : '';
$place 			= isset($HTTP_GET_VARS['place']) ? $HTTP_GET_VARS['place'] : '';
$sql 			= isset($HTTP_GET_VARS['sql']) ? $HTTP_GET_VARS['sql'] : '';

if ( (($action == 'add') || ($action == 'modify') || ($action == 'delete')) && $confirm == 1 ){

	$expire = 365*24*3600;
	$where = 'bookmark_'.$place;
	if ($action == 'modify') {
		$sql = base64_encode(magic_quote_bypass($sql));
	}
	
	setcookie($where,$sql,time()+$expire);
	
	if ($action == 'add'){
		$action = 'added';
	}
	if ($action == 'modify'){
		$action = 'modified';
	}
	if ($action == 'delete'){
		$action = 'deleted';
	}

	header("Location: popup_bookmark.php?action=$action&place=$place");

}

if ( ($action == 'added') || ($action == 'modified') || ($action == 'deleted') ){
	${'bookmark_'.$place} = isset(${'bookmark_'.$place}) ? ${'bookmark_'.$place} : '';
	if ($action == 'added'){
		$msg = $txt['bkmk_been_saved'];
	}
	if ($action == 'modified'){
		$msg = $txt['bkmk_been_modified'];
	}
	if ($action == 'deleted'){
		$msg = $txt['bkmk_been_deleted'];
		
	}

	$content  ='<font face="Verdana, Arial, Helvetica" size="1"><B>'.$txt['bkmk_query'].'</b><i>'.base64_decode(${'bookmark_'.$place}).'</i><b>'.$msg.'</B>';
	$content .='<center><BR><BR><BR><a href="popup_bookmark.php?action=see">'.$txt['bkmk_manage'].'</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="javascript:window.close()">'.$txt['close'].'</a></center>';

}

if ($action == 'add'){

	$content  = '<font '.$font.'><B>'.$txt['bkmk_add1'].'</B><i>'.base64_decode($sql).'</i><b>'.$txt['bkmk_add2'].'</B><BR>';
    $content .= '<BR></font>';
    $content .= '<form method="get" action="popup_bookmark.php">';
    $content .= '<input type="hidden" name="sql" value="'.$sql.'">';
    $content .= '<table border="1" bgcolor="'.$colors['table_bg'].'" bordercolor="'.$colors['bordercolor'].'" cellspacing="0" cellpadding="5" width="100%">';
	
	for ($i=1; $i <= 25; $i++){
		
		if (!isset(${'bookmark_'.$i})){
			$disp = $txt['empty'];
			$disabled = '';
		} else {
			$disp = base64_decode(${'bookmark_'.$i});
			$disabled = 'disabled';
		}
		
		$content .='<tr> 
		          		<td><input type="radio" name="place" '.$disabled.'  value="'.$i.'" class="pick"></td>
		          		<td><font face="Verdana, Arial, Helvetica" size="1">'.$i.'</font></td>
		          		<td><font face="Verdana, Arial, Helvetica" size="1">'.$disp.'</font></td>
		        	</tr>';
		}
                
	$content .='</table>
              <br>
              <center>
              <input type="submit" value="'.$txt['add'].'" class="bosses">
              <input type="hidden" name="action" value="add">
              <input type="hidden" name="confirm" value="1">
              <input type="button" name="cancel" value="'.$txt['cancel'].'" OnClick="window.close()"; class="bosses">
              <BR><BR><BR><font face="Verdana, Arial, Helvetica" size="1"><a href="popup_bookmark.php?action=see">'.$txt['bkmk_manage'].'</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="javascript:window.close()">'.$txt['close'].'</a></font>
              </center>
            </form>';
}

if ($action == 'see') {

	$content = '<table border=1 bgcolor="'.$colors['table_bg'].'" bordercolor="'.$colors['bordercolor'].'" cellspacing="0"cellpadding="5" width="100%">';
            
	for ($i = 1; $i <= 25; $i++){
		
			if (!isset($HTTP_COOKIE_VARS["bookmark_$i"])){
				$disp = $txt['empty'];
				$disabled = '';
				$modif = '<a href="popup_bookmark.php?action=modify&place='.$i.'">'.$txt['modify'].'</a>';
				$suppr = '';
				
			}else{
				$disp = base64_decode($HTTP_COOKIE_VARS["bookmark_$i"]);
				$disabled = 'disabled';
				$modif = '<a href="popup_bookmark.php?action=modify&place='.$i.'">'.$txt['modify'].'</a>';
				$suppr = '<a href="popup_bookmark.php?action=delete&place='.$i.'">'.$txt['delete'].'</a>';
			}
	            
		$content .='              <tr> 
	                <td><font face="Verdana, Arial, Helvetica" size="1">'.$i.'</font></td>
	                <td><font face="Verdana, Arial, Helvetica" size="1">'.$disp.'</font></td>
	                <td><font face="Verdana, Arial, Helvetica" size="1">'.$modif.'<br>'.$suppr.'</font></td>
	              </tr>';
	            }

	$content .= '</table><BR>';

}

if ($action == 'delete'){
	${'bookmark_'.$place} = isset($HTTP_COOKIE_VARS["bookmark_$place"]) ? $HTTP_COOKIE_VARS["bookmark_$place"] : '';
	$content = '            <font face="Verdana, Arial, Helvetica" size="1"><b>'.$txt['bkmk_delete'].' 
            :</b><br>
            <br><center>
            <form method="get" action="popup_bookmark.php">
            <input type="hidden" name="place" value="'.$place.'">'.base64_decode(${'bookmark_'.$place}).'<br><br>
              <input type="submit" value="'.$txt['delete'].'" class="bosses">
              <input type="hidden" name="action" value="delete">
              <input type="hidden" name="confirm" value="1">
              <input type="button" name="cancel" value="'.$txt['cancel'].'" OnClick="window.close()"; class="bosses">
              </center>
            </form>
            </font>';
	$content .='<center><BR><BR><BR><a href="popup_bookmark.php?action=see">'.$txt['bkmk_manage'].'</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="javascript:window.close()">'.$txt['close'].'</a></center>';
}

if ($action == 'modify'){
	${'bookmark_'.$place} = isset($HTTP_COOKIE_VARS["bookmark_$place"]) ? $HTTP_COOKIE_VARS["bookmark_$place"] : '';
	$content = '            <font face="Verdana, Arial, Helvetica" size="1"><b>'.$txt['bkmk_modify'].' 
            :</b><br>
            <br><center>
            <form method="get" action="popup_bookmark.php">
            <input type="hidden" name="place" value="'.$place.'">
            <textarea name="sql" cols=45 rows=10 class="trous">'.base64_decode(${'bookmark_'.$place}).'</textarea><br>
              <input type="submit" value="'.$txt['modify'].'" class="bosses">
              <input type="hidden" name="confirm" value="1">
              <input type="hidden" name="action" value="modify">
              <input type="reset" name="cancel" value="'.$txt['cancel'].'" class="bosses">
	<BR><BR><BR><a href="popup_bookmark.php?action=see">'.$txt['bkmk_manage'].'</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="javascript:window.close()">'.$txt['close'].'</a>
              </center>
            </form>
            </font>';

}

$page_title = $txt['bkmk_manage'];
$dont_show_logo = 1;
$metaNavBar = '<U>'.$txt['bkmk_manage'].'</U>';

display_design($content,1);
?>