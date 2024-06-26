<?php

$general_css = '<style type="text/css">
<!--

BODY
{
scrollbar-base-color: '.$colors['table_bg'].';
scrollbar-arrow-color: '.$colors['titre_bg'].';
scrollbar-track-color: '.$colors['bgcolor'].';

scrollbar-shadow-color: '.$colors['table_bg'].';
scrollbar-lightshadow-color: '.$colors['table_bg'].';
scrollbar-darkshadow-color: '.$colors['table_bg'].';

scrollbar-highlight-color: '.$colors['table_bg'].';
scrollbar-3dlight-color: '.$colors['table_bg'].';
}';

$general_css .= '.trous { background-color: '.$colors['trou_bg'].'; border: 1 '.$colors['trou_border'].' solid; color: '.$colors['trou_font'].'; font-family: '.$font.'; font-size: '.$css.'px; scrollbar-3dlight-color:'.$colors['trou_bg'].'; scrollbar-arrow-color:'.$colors['trou_border'].'; scrollbar-base-color:'.$colors['trou_bg'].'; scrollbar-darkshadow-color:'.$colors['trou_bg'].'; scrollbar-face-color:'.$colors['trou_bg'].'; scrollbar-highlight-color:'.$colors['trou_bg'].'; scrollbar-shadow-color:'.$colors['trou_bg'].' }';

if (eregi('Mozilla/4.', $HTTP_USER_AGENT) && !eregi('msie', $HTTP_USER_AGENT) && !eregi('opera', $HTTP_USER_AGENT) && !eregi('Konqueror', $HTTP_USER_AGENT)){
$general_css .='.bosses {  background-color: '.$colors['bosse_bg'].'; border: 1px '.$colors['bosse_border'].'  color: '.$colors['bosse_font'].'}';
}else{
$general_css .='.bosses {  background-color: '.$colors['bosse_bg'].'; border: 1px '.$colors['bosse_border'].' dotted; color: '.$colors['bosse_font'].'}';
}

$general_css .='.pick { background-color: '.$colors['pick_bg'].'; color: '.$colors['pick_border'].'; font-family: '.$font.', sans-serif; font-size: '.$css.'px}';

$general_css .= '-->
</style>';

?>