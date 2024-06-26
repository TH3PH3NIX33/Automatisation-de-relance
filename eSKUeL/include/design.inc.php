<?php
function display_metaNavBar($db,$tbl) {
	global $font, $colors;
	
	if ($db == '' && $tbl == '') {
		$metaNavBar = '<A href="main.php"><FONT '.$font.' color="'.$colors['titre_font'].'">'.getGoodConfigArg('name').'</font></a>';
	}
	elseif ($db != '' && $tbl == '') {
		$metaNavBar = '<a href="main.php"><font '.$font.' color="'.$colors['titre_font'].'">'.getGoodConfigArg('name').'</font></a>';
		$metaNavBar .= '&nbsp;&gt;&nbsp;<a href="main.php?db='.$db.'"><font '.$font.' color="'.$colors['titre_font'].'">'.$db.'</font></A>';
	}
	else {
		$metaNavBar = '<a href="main.php"><font '.$font.' color="'.$colors['titre_font'].'">'.getGoodConfigArg('name').'</font></a>';
		$metaNavBar .= '&nbsp;&gt;&nbsp;<a href="main.php?db='.$db.'"><font '.$font.' color="'.$colors['titre_font'].'">'.$db.'</font></A>';
		$metaNavBar .= '&nbsp;&gt;&nbsp;<a href="main.php?db='.$db.'&tbl='.$tbl.'"><font '.$font.' color="'.$colors['titre_font'].'">'.$tbl.'</font></A>';
	}	
	return $metaNavBar;
}

function display_design($output, $noNavBar = 0){
	Global $db, $tbl, $colors, $font, $conf, $main_DB, $txt, $coded;
	Global $HTTP_SERVER_VARS, $HTTP_USER_AGENT, $HTTP_GET_VARS, $HTTP_COOKIE_VARS, $action;
	Global $metaNavBar, $new_colors, $dont_show_logo, $page_title, $collapse;
    Global $tplConfig, $version;
    
    $collapse = reg_glob('collapse');
    

    $css 					= '12';
	$collapse_right_get 	= isset($HTTP_GET_VARS['collapse_right']) ? $HTTP_GET_VARS['collapse_right'] : '';
    $collapse_right_cookie 	= isset($HTTP_COOKIE_VARS['ConfCollapseRight']) ? $HTTP_COOKIE_VARS['ConfCollapseRight'] : '';
    $collapse_right 		= '';
    
    if ($collapse_right_get != '') {
        $HTTP_GET_VARS['action'] = '';
    }
    
    ### Order to show the right nav bar or not
    if ($collapse_right_cookie != '') {
		$collapse_right = $collapse_right_cookie;
		$colors['tpl_type'] = ($collapse_right == 'yes') ? 1 : 0;
	}
	if ($collapse_right_get == 'yes') {
		setcookie('ConfCollapseRight','yes');
		$collapse_right = 'yes';
		$colors['tpl_type'] = ($collapse_right == 'yes') ? 1 : 0;
	}
	if ($collapse_right_get == 'no') {
		setcookie('ConfCollapseRight', 'no');
		$collapse_right = 'no';
		$colors['tpl_type'] = ($collapse_right == 'yes') ? 1 : 0;
	}



	### hack tpl_preview (setup.inc.php) ==> replace $colors if $new_colors is defined
	if (is_array($new_colors)) {
		$colors = $new_colors;
	}

	include './include/css.inc.php';
	$img_path 	= $colors['img_path'];
    $path 		= $colors['name'];

	### We want to see the navigation bars
	if ($noNavBar == 0) {
		include './left.php';
		include './right.php';
		$metaNavBar = display_metaNavBar($db,$tbl);
		$page_title = 'eSKUeL '.$version.' > '.$HTTP_SERVER_VARS['SERVER_NAME'].' > '.getGoodConfigArg('name');
		
		### Toolbar mode on
		if ($colors['tpl_type'] == 1 || $collapse_right == 'yes') {
        	$top_navigation 	= nav_bar();
        	$bottom_navigation	= nav_bar('_b');
        	$right_navigation 	= '&nbsp;';
        	
    	}
    	
    	### Toolbar mode off
    	else {
	        $top_navigation 	= '<img src="img/vide.gif" width="1" height="1">';
	        $bottom_navigation 	= '<img src="img/vide.gif" width="1" height="1">';
	        $right_navigation	= nav_bar();
	    }
	    
	}
	else {
		$top_navigation 	= '';
		$bottom_navigation 	= '';
		$left_navigation 	= '&nbsp;';
		$right_navigation 	= '<img src="img/vide.gif" width="1" height="1">';
    }
    
    if ($metaNavBar == '') {
    	$metaNavBar = 'eSKUeL';	
    }

    


	$design  = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">'."\n";
	$design .= '<HTML>'."\n";
	$design .= '<HEAD>'."\n";
	$design .= '<TITLE>'.$page_title.'</TITLE>'."\n";
	$design .= '<META HTTP-EQUIV="Pragma"  CONTENT="no-cache">'."\n";
	$design .= '<META HTTP-EQUIV="Cache-Control" CONTENT="no-cache">'."\n";
	$design .= '<META HTTP-EQUIV="Expires" CONTENT="Mon, 06 May 1996 04:57:00 GMT">'."\n";
	$design .= '<META HTTP-EQUIV="content-type" CONTENT="text/html; charset='.$txt['charset'].'">'."\n";
	$design .= '
	<SCRIPT>
	<!--
	function help(arg)
	{
	    var largeur=screen.width
	    var hauteur=screen.height

	    var url="help.php?action="+arg
	    var name="tipsPopup"
	    var largeur_popup=800
	    var hauteur_popup=600

	    var pos_left=Math.round((largeur/2)-(largeur_popup/2))
	    var pos_top=Math.round((hauteur/2)-(hauteur_popup/2))

	    window.open(url,name,"toolbar=0,location=0,directories=0,resizable=1,copyhistory=1,menuBar=0,scrollbars=1,left=" + pos_left + ",top=" + pos_top + ",width=" + largeur_popup + ",height=" + hauteur_popup);
	}
	
	function s(texte) {
	    window.status = texte; 
	    return false;
	}
	function dels() {
	    window.status="";
	}
	var count = 0;
	function over(img, diff) {
		if(document.images)
			if (diff) {
				eval("document." + img+diff + ".src = \''.$img_path.'img/" + img + "_on.gif\'");
			}
			else {
				eval("document." + img + ".src = \''.$img_path.'img/" + img + "_on.gif\'");
			}
				
	}
	function out(img, diff) {
		if(document.images)
			if (diff) {
				eval("document." + img+diff + ".src = \''.$img_path.'img/" + img + "_off.gif\'");
			}
			else {
				eval("document." + img + ".src = \''.$img_path.'img/" + img + "_off.gif\'");
			}
		}
	function alt(url,action) {
		if (count == 0) {
			if (url != \'mimineshow\') {
				window.location = url;
			}
			else {
				Afficher_Masquer(\'mimine\',\'\',\'show\');
				document.miminedhtml.extra_query.select();
			}
		}
		else {
			tips();
			help(action);
		}
	}
	//-->
	</SCRIPT>

	'.$general_css.'
	</HEAD>
	<BODY bgcolor="'.$colors['bgcolor'].'" vlink="'.$colors['vlink'].'" link="'.$colors['link'].'" text="'.$colors['text'].'" alink="'.$colors['alink'].'" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
	<TABLE width="100%" border="0" cellspacing="10" cellpadding="0">'."\n";
    
    
	### Do we show the logo ?
	if (@is_file('./tpl/'.$path.'/logo.gif') && !$dont_show_logo){
		$design .= '<tr>';
        $design .= '    <td colspan=3>';
		
		### Is logo url is set ? if yes, make it clickable !
        if ($conf['siteUrl'] != '' && $conf['siteUrl'] != 'http://') {
			$design .= '<A href="'.$conf['siteUrl'].'"><img src="tpl/'.$path.'/logo.gif" border="0"></A>'."\n";
		}
		else {
			$design .= '<img src="tpl/'.$path.'/logo.gif">'."\n";
		}

        $design .= '    </td>'."\n";
        $design .= '</tr>'."\n";
	}

	$design .= '<TR valign="top">'."\n";
	$design .= '	<TD>'.$left_navigation.'</TD>'."\n";
	$design .= '	<TD align="center" width="100%">'."\n";
	$design .= '		<TABLE border="1" cellspacing="0" cellpadding="5" bordercolor="'.$colors['bordercolor'].'" width="100%" >'."\n";
	$design .= '		<TR>'."\n";
	$design .= '			<TD align="left" bgcolor="'.$colors['titre_bg'].'"';
	
	### Is there a titre_bg.gif file ? If yes, use it
	if (@is_file('tpl/'.$path.'/titre_bg.gif')){
		$design .= ' background="tpl/'.$path.'/titre_bg.gif"';
	}
	
	$design .= '>'."\n";				
	$design .= '				<font '.$font.' color="'.$colors['titre_font'].'"><B>';
	$design .= $metaNavBar;
	$design .= '				</B></font>'."\n";
	$design .= '			</TD>'."\n";
	$design .= '		</TR>'."\n";
	$design .= '		<TR>'."\n";
	$design .= '			<TD align="left" bgcolor="'.$colors['table_bg'].'">'.$top_navigation.'<br><font '.$font.'>'.$output.'</font><BR><BR>'.$bottom_navigation.'</TD>'."\n";
	$design .= '		</TR>'."\n";
	$design .= '		</TABLE>'."\n";
	$design .= '	</TD>'."\n";
	$design .= '	<TD>'.$right_navigation.'</TD>'."\n";
	$design .= '</TR>'."\n";
	$design .= '</TABLE>'."\n";
	
	echo $design;
	
	if ($noNavBar == 0) {
		include('./include/dhtml.inc.php');
	}
	echo '</body>';
	echo '<!--'.base64_decode($coded).'//-->';
	echo '</HTML>';
}

?>