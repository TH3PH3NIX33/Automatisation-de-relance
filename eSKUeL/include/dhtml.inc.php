<script language="JavaScript">
<!--
function Reload_NN(init) {
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=Reload_NN; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
Reload_NN(true);
// -->
<!--
function Reperage_Obj(n, d) {
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=Reperage_Obj(n,d.layers[i].document);
  if(!x && document.getElementById) x=document.getElementById(n); return x;
}

function Afficher_Masquer() {
  var i,p,v,obj,args=Afficher_Masquer.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=Reperage_Obj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v='hide')?'hidden':v; }
    obj.visibility=v; }
}

if (document.layers){
var largeur_ecran=window.innerWidth
var hauteur_ecran=window.innerHeight
}else{
var largeur_ecran=document.clientWidth
var hauteur_ecran=document.clientHeight
}
var pos_left=20
var pos_top=20

function popup(url, name, largeur, hauteur)
{
    var largeur_screen=screen.width
    var hauteur_screen=screen.height

    var pos_left=Math.round((largeur_screen/2)-(largeur/2))
    var pos_top=Math.round((hauteur_screen/2)-(hauteur/2))

    window.open(url,name,"toolbar=0,location=0,directories=0,resizable=0,copyhistory=1,menuBar=0,scrollbars=1,left=" + pos_left + ",top=" + pos_top + ",width=" + largeur + ",height=" + hauteur);
}

//-->
</script>
<script language="Javascript">
document.write('<div id="mimine" style="position:absolute; left:40%; top:15%; width:1px; height:1px; z-index:200; visibility: hidden">');
</script>
  <table border="1" bgcolor="<?php echo $colors['table_bg']; ?>" bordercolor="<?php echo $colors['bordercolor']; ?>" cellspacing=0 cellpadding=5 width="300">
    <tr>
      <td align="left" bgcolor="<?php echo $colors['titre_bg']; ?>"';
    <?php      
    $path = $colors['name'];			
	if (@is_file('tpl/'.$path.'/titre_bg.gif')){
		 echo ' background="tpl/'.$path.'/titre_bg.gif"';
	}
     echo '>';
     ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><img src="img/manuel.gif">&nbsp;<font <?php echo $font; ?>><b><font color="<?php echo $colors['titre_font']; ?>"><?php echo $txt['manual_request']; ?> :</font></b></font></td>
            <td align="right"><a href="Javascript:Afficher_Masquer('mimine','','hide')"><img src="img/close.gif" border="0" title="<?php echo $txt['close']; ?>"></a></td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td align="center" bgcolor="<?php echo $colors['table_bg']; ?>"> <font face="Verdana, Arial, Helvetica, sans-serif" size="2">
		<form action="main.php?db=<?php echo urlencode($db); ?>&action=do_query" name="miminedhtml" method="post">
      	<a href="Javascript:popup('popup_bookmark.php?action=see', 'Bookmark', 420, 400);"><img src="<?php echo $img_path.'img/bookmark.gif'; ?>" border="0" align="center" title="<?php echo $txt['bkmk_manage']; ?>"></a>
<?php

$length_2_cut = 43;

echo '<select name="bookmarked" class="trous" onChange="if (form.bookmarked.selectedIndex != 0 && (miminedhtml.bookmarked.options[miminedhtml.bookmarked.selectedIndex].value != \'\')) miminedhtml.extra_query.value = miminedhtml.bookmarked.options[miminedhtml.bookmarked.selectedIndex].value">';
echo '    <option value="">'.$txt['bkmk_available'].'</option>';

for ($i=1; $i <= 25; $i++){
	$current_bookmark = isset($HTTP_COOKIE_VARS["bookmark_$i"]) ? $HTTP_COOKIE_VARS["bookmark_$i"] : '';
	if ($current_bookmark == ''){
		$disp = $txt['empty'];
		$disp_value = '';
	}else{
		
		$disp = base64_decode(magic_quote_bypass(($current_bookmark)));
		$disp_value = htmlentities(base64_decode(magic_quote_bypass($current_bookmark)));

		if (strlen($disp) > $length_2_cut) {
			$disp = substr($disp, 0, $length_2_cut).'...';
		}
	}

	echo '    <option value="'.$disp_value.'">'.$disp.'</option>';

}	
echo '</select>';
?>
      </font></td>
      </tr>
      <tr>
      <td align="center" bgcolor="<?php echo $colors['table_bg']; ?>"> <font face="Verdana, Arial, Helvetica, sans-serif" size="2">
          <textarea name=extra_query cols=60 rows=10 class="trous"><?php echo 'SELECT * FROM '.sql_back_ticks($tbl, $main_DB); ?></textarea>
          <br>
          <input type=submit value="<?php echo $txt['execute']; ?>" class="bosses">
        </form>
        </font></td>
    </tr>
  </table>
</div>