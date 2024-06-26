<?php

$output 		= '';
$dont_output 	= 0;

if (isset($HTTP_GET_VARS['action'])) {
	$action = $HTTP_GET_VARS['action'];
}
elseif (isset($HTTP_POST_VARS['action'])) {
	$action = $HTTP_POST_VARS['action'];
}
else {
	$action = '';
}

### The config file exists, show modification menu
if (@is_file('./config.inc.php')) {
    include './config.inc.php';
    require './include/setup.inc.php';
    require './include/functions.inc.php';
    require './include/color_grid.inc.php';
	
	$globalConfig = select_config();
	$tplConfig 	= $globalConfig['tpl'];
	$sqlConfig 	= $globalConfig['sql'];
	$txt 		= $globalConfig['txt'];
	$design 	= $globalConfig['design'];
	
	$colors 	= $design['colors'];
	$font 		= $design['font'];

    require './include/design.inc.php';
    
    $metaNavBar  = 'eSKUeL > '.$txt['setup'];
    $page_title  = $metaNavBar;
    $output 	.= '<FONT '.$font.'><FONT size="2"><B>'.$txt['setup_title'].' :</B></FONT>';
    $output 	.= '<BR><BR>';

    
	switch ($action) {
		case '':
			$output .= show_setup_hp();
		break;

		case 'add_entry':
			$output .= add_cfg($confDB);
		break;

		case 'mod_entry':
			$output .= modify_cfg();
		break;

		case 'mod_globals':
			$output .= modify_globals($conf);
		break;

		case 'del_entry':
			$output .= del_cfg($confDB);
		break;

		case 'tpl_create':
			$output .= tpl_create();
		break;

		case 'tpl_mod':
			$output .= tpl_mod();
		break;

		case 'tpl_preview':
			$output .= tpl_preview($new_colors);
			$dont_show_logo = 1;
			$page_title = 'eskuel > Preview';
			$dont_output = 1;
		break;

		case 'tpl_del':
			$output .= tpl_del();
		break;
	}
}
else {
    $lang_config 	= isset($HTTP_POST_VARS['lang_config']) ? $HTTP_POST_VARS['lang_config'] : '';
    $confLangCookie = isset($HTTP_COOKIE_VARS['ConfLangCookie']) ? $HTTP_COOKIE_VARS['ConfLangCookie'] : '';
    
    if (isset($HTTP_GET_VARS['lang_config']) && $lang_config == '') {
    	$lang_config = $HTTP_GET_VARS['lang_config'];
    }
    
    if ($confLangCookie != '' && $lang_config == '') {
    	$lang_config = $confLangCookie;
    }
   
    require './include/setup.inc.php';
    require './include/functions.inc.php';
    
    if ($lang_config == 'no-lang') {
    	$HTTP_POST_VARS['lang_config'] = '';
    	$HTTP_COOKIE_VARS['ConfLangCookie'] = '';
		$lang_config = '';
    }
	
	$globalConfig 	= select_config();
	$tplConfig 		= $globalConfig['tpl'];
	$sqlConfig 		= $globalConfig['sql'];
	$txt 			= $globalConfig['txt'];
	$design 		= $globalConfig['design'];
	
	$colors 		= $design['colors'];
	$font 			= $design['font'];

    require './include/design.inc.php';

    $dont_output = 1;
    

    if ($lang_config == '') {
        $metaNavBar  = 'eskuel > '.$txt['install'].' > '.$txt['setup_step'].' 1 / 2';
        $page_title  = $metaNavBar;
        $output  	 = '<B>'.$txt['setup_install'].'</B><BR><BR>';
        $output 	.= '<B>'.$txt['setup_language'].' :</B><BR><BR>';
        $output 	.= '<FORM action="setup.php" method="post" name="sltLang">';
        $output 	.= '<SELECT name="lang_config" onChange="document.sltLang.submit();" class="trous">';
        $output 	.= select_lang('francais.inc.php');
        $output 	.= '</SELECT>';
        $output 	.= '<INPUT type="submit" class="bosses" value="'.$txt['ok'].'">';
        $output 	.= '</FORM>';
    }
    else {
        $metaNavBar = 'eskuel > '.$txt['install'].' > '.$txt['setup_step'].' 2 / 2';
        $page_title = $metaNavBar;
        setcookie("ConfLangCookie", $lang_config);
        $output = create_cfg();
    }

}

if (!$dont_output) {
	$output .= return_2_eskuel();
}
display_design($output,1);
?>