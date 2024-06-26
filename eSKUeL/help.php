<?php
### help.php

include './config.inc.php';
require './include/setup.inc.php';
require './include/functions.inc.php';
require './include/help.inc.php';

### Getting current cfg and setting the design vars
$globalConfig = select_config();
$tplConfig 	= $globalConfig['tpl'];
$sqlConfig 	= $globalConfig['sql'];
$txt 		= $globalConfig['txt'];
$design 	= $globalConfig['design'];

$colors 	= $design['colors'];
$font 		= $design['font'];

$metaNavBar = 'eskuel > '.$txt['help'];
$page_title = $metaNavBar;
$output		= '';
require './include/design.inc.php';

switch ($action) {
	case 'data_types':
		$output .= data_types();
	break;
	
	default:
		@include './help/'.$txt['config_name'].'/'.$HTTP_GET_VARS['action'].'.inc.php';
		if ($help == '') {
			### Help not found or there is an error, displaying an error message
			$output .= '<B>'.$txt['help_not_found'].'</B>';
		}
		else {
			$output .= $help;
		}
	break;
}
$output .= '<BR><BR><CENTER><A href="javascript:window.close();">'.$txt['help_close'].'</A></CENTER>';
display_design($output,1);

?>