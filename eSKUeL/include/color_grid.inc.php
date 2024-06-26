<?php

$vide 		= 'img/vide.gif';	//Image vide
$HSPACE 	= 0;			//Espace Horizontal du <span>
$VSPACE 	= 0;			//Espace Vertical du <span>
$WIDTH 		= 30;			//Largeur du <span>
$HEIGHT 	= 30;			//Hauteur du <span>
$BORDER 	= 1;			//Bordure du <span>
$CELLSPACING	= 5;			//Cellspacing, quoi...

// picker(nom_du_picker, nom_du_formulaire, taille_par_des_cases, type_du_picker_[simple_ou_websafe])
function picker($nom, $form, $img_size=10) {

Global $vide,$HSPACE,$VSPACE,$WIDTH,$HEIGHT,$BORDER, $CELLSPACING;
Global $font, $txt;


$output = "<SCRIPT LANGUAGE=\"JavaScript\">
hexa" . $nom . "color=\"#FFFFFF\";
temp=0;

function expert" . $nom . "()
{
	hexa" . $nom . "color=document." . $form . "." . $nom . ".value;
	if (document.getElementById) {
		document.getElementById('apercu".$nom."').style.background=hexa" . $nom . "color;
	}
	else if (document.layers){
		document.layers['apercu" . $nom . "'].bgColor=hexa" . $nom . "color;
	} else
	{
		document.all['apercu" . $nom . "'].style.background=hexa" . $nom . "color;
	}
}

function select" . $nom . "(hexa" . $nom . "color)
{
	if ( temp == 0 )
	{
		document." . $form . "." . $nom . ".value=hexa" . $nom . "color;
		if (document.getElementById) {
			document.getElementById('apercu".$nom."').style.background=hexa" . $nom . "color;
		}
		else if (document.layers){
			document.layers['apercu" . $nom . "'].bgColor=hexa" . $nom . "color;
		} else
		{
			document.all['apercu" . $nom . "'].style.background=hexa" . $nom . "color;
		}
	}
}

function change" . $nom . "()
{
	if (temp == 0)
	{
		temp = 1;
	} else
	{
		temp = 0;
	}
}
    
</script>";

$output .= "<table border=\"0\" cellspacing=\"".$CELLSPACING."\" cellpadding=\"0\">
  <tr align=\"center\" valign=\"middle\"> 
    <td> 
      <table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" bgcolor=\"#000000\">
        <tr> 
          <td> 
            <table border=\"0\" cellspacing=\"1\" cellpadding=\"0\">
              <tr> 
                <td bgcolor=\"#000000\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#000000')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#000000\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#000000')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#003300\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#003300')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#006600\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#006600')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#009900\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#009900')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#00CC00\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#00CC00')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#00FF00\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#00FF00')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#330000\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#330000')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#333300\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#333300')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#336600\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#336600')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#339900\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#339900')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#33CC00\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#33CC00')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#33FF00\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#33FF00')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#660000\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#660000')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#663300\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#663300')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#666600\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#666600')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#669900\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#669900')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#66CC00\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#66CC00')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#66FF00\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#66FF00')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
              </tr>
              <tr> 
                <td bgcolor=\"#333333\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#333333')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#000033\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#000033')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#003333\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#003333')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#006633\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#006633')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#009933\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#009933')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#00CC33\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#00CC33')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#00FF33\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#00FF33')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#330033\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#330033')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#333333\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#333333')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#336633\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#336633')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#339933\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#339933')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#33CC33\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#33CC33')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#33FF33\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#33FF33')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#660033\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#660033')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#663333\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#663333')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#666633\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#666633')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#669933\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#669933')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#66CC33\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#66CC33')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#66FF33\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#66FF33')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
              </tr>
              <tr> 
                <td bgcolor=\"#666666\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#666666')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#000066\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#000066')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#003366\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#003366')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#006666\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#006666')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#009966\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#009966')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#00CC66\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#00CC66')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#00FF66\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#00FF66')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#330066\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#330066')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#333366\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#333366')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#336666\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#336666')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#339966\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#339966')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#33CC66\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#33CC66')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#33FF66\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#33FF66')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#660066\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#660066')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#663366\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#663366')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#666666\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#666666')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#669966\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#669966')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#66CC66\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#66CC66')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#66FF66\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#66FF66')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
              </tr>
              <tr> 
                <td bgcolor=\"#999999\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#999999')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#000099\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#000099')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#003399\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#003399')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#006699\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#006699')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#009999\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#009999')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#00CC99\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#00CC99')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#00FF99\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#00FF99')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#330099\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#330099')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#333399\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#333399')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#336699\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#336699')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#339999\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#339999')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#33CC99\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#33CC99')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#33FF99\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#33FF99')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#660099\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#660099')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#663399\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#663399')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#666699\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#666699')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#669999\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#669999')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#66CC99\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#66CC99')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#66FF99\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#66FF99')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
              </tr>
              <tr> 
                <td bgcolor=\"#CCCCCC\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#CCCCCC')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#0000CC\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#0000CC')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#0033CC\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#0033CC')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#0066CC\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#0066CC')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#0099CC\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#0099CC')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#00CCCC\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#00CCCC')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#00FFCC\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#00FFCC')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#3300CC\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#3300CC')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#3333CC\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#3333CC')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#3366CC\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#3366CC')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#3399CC\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#3399CC')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#33CCCC\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#33CCCC')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#33FFCC\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#33FFCC')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#6600CC\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#6600CC')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#6633CC\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#6633CC')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#6666CC\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#6666CC')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#6699CC\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#6699CC')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#66CCCC\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#66CCCC')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#66FFCC\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#66FFCC')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
              </tr>
              <tr> 
                <td bgcolor=\"#FFFFFF\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#FFFFFF')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#0000FF\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#0000FF')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#0033FF\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#0033FF')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#0066FF\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#0066FF')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#0099FF\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#0099FF')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#00CCFF\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#00CCFF')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#00FFFF\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#00FFFF')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#3300FF\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#3300FF')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#3333FF\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#3333FF')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#3366FF\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#3366FF')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#3399FF\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#3399FF')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#33CCFF\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#33CCFF')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#33FFFF\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#33FFFF')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#6600FF\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#6600FF')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#6633FF\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#6633FF')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#6666FF\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#6666FF')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#6699FF\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#6699FF')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#66CCFF\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#66CCFF')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#66FFFF\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#66FFFF')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
              </tr>
              <tr> 
                <td bgcolor=\"#FF0000\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#FF0000')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#990000\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#990000')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#993300\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#993300')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#996600\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#996600')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#999900\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#999900')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#99CC00\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#99CC00')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#99FF00\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#99FF00')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#CC0000\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#CC0000')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#CC3300\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#CC3300')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#CC6600\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#CC6600')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#CC9900\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#CC9900')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#CCCC00\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#CCCC00')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#CCFF00\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#CCFF00')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#FF0000\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#FF0000')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#FF3300\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#FF3300')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#FF6600\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#FF6600')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#FF9900\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#FF9900')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#FFCC00\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#FFCC00')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#FFFF00\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#FFFF00')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
              </tr>
              <tr> 
                <td bgcolor=\"#00FF00\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#00FF00')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#990033\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#990033')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#993333\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#993333')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#996633\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#996633')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#999933\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#999933')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#99CC33\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#99CC33')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#99FF33\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#99FF33')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#CC0033\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#CC0033')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#CC3333\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#CC3333')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#CC6633\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#CC6633')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#CC9933\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#CC9933')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#CCCC33\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#CCCC33')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#CCFF33\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#CCFF33')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#FF0033\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#FF0033')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#FF3333\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#FF3333')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#FF6633\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#FF6633')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#FF9933\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#FF9933')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#FFCC33\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#FFCC33')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
                <td bgcolor=\"#FFFF33\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#FFFF33')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 ></a></td>
              </tr>
              <tr> 
                <td bgcolor=\"#0000FF\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#0000FF')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#990066\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#990066')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#993366\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#993366')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#996666\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#996666')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#999966\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#999966')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#99CC66\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#99CC66')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#99FF66\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#99FF66')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#CC0066\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#CC0066')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#CC3366\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#CC3366')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#CC6666\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#CC6666')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#CC9966\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#CC9966')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#CCCC66\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#CCCC66')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#CCFF66\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#CCFF66')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#FF0066\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#FF0066')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#FF3366\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#FF3366')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#FF6666\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#FF6666')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#FF9966\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#FF9966')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#FFCC66\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#FFCC66')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#FFFF66\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#FFFF66')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
              </tr>
              <tr> 
                <td bgcolor=\"#FFFF00\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#FFFF00')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#990099\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#990099')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#993399\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#993399')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#996699\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#996699')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#999999\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#999999')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#99CC99\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#99CC99')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#99FF99\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#99FF99')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#CC0099\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#CC0099')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#CC3399\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#CC3399')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#CC6699\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#CC6699')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#CC9999\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#CC9999')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#CCCC99\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#CCCC99')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#CCFF99\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#CCFF99')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#FF0099\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#FF0099')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#FF3399\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#FF3399')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#FF6699\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#FF6699')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#FF9999\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#FF9999')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#FFCC99\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#FFCC99')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#FFFF99\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#FFFF99')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
              </tr>
              <tr> 
                <td bgcolor=\"#00FFFF\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#00FFFF')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#9900CC\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#9900CC')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#9933CC\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#9933CC')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#9966CC\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#9966CC')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#9999CC\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#9999CC')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#99CCCC\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#99CCCC')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#99FFCC\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#99FFCC')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#CC00CC\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#CC00CC')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#CC33CC\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#CC33CC')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#CC66CC\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#CC66CC')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#CC99CC\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#CC99CC')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#CCCCCC\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#CCCCCC')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#CCFFCC\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#CCFFCC')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#FF00CC\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#FF00CC')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#FF33CC\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#FF33CC')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#FF66CC\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#FF66CC')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#FF99CC\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#FF99CC')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#FFCCCC\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#FFCCCC')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#FFFFCC\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#FFFFCC')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
              </tr>
              <tr> 
                <td bgcolor=\"#FF00FF\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#FF00FF')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#9900FF\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#9900FF')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#9933FF\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#9933FF')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#9966FF\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#9966FF')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#9999FF\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#9999FF')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#99CCFF\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#99CCFF')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#99FFFF\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#99FFFF')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#CC00FF\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#CC00FF')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#CC33FF\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#CC33FF')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#CC66FF\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#CC66FF')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#CC99FF\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#CC99FF')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#CCCCFF\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#CCCCFF')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#CCFFFF\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#CCFFFF')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#FF00FF\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#FF00FF')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#FF33FF\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#FF33FF')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#FF66FF\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#FF66FF')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#FF99FF\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#FF99FF')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#FFCCFF\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#FFCCFF')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
                <td bgcolor=\"#FFFFFF\" width=\"".$img_size."\" height=\"".$img_size."\"><a href=\"javascript:select".$nom."('#FFFFFF')\"><img src=\"".$vide."\" width=".$img_size." height=".$img_size." border=0 hspace=0 vspace=0 ></a></td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
   </tr>
   <tr>
    <td> 
      <font $font>".$txt['color_code']." : <input type=\"TEXT\" size=\"7\" name=\"".$nom."\" value=\"#FFFFFF\" Onchange=\"javascript:expert".$nom."(0)\" class=\"trous\"></font>
      <br>
     </td>
    </tr>
    <tr>
     <td valign=\"top\">
    	<font $font>".$txt['color_preview']." : <span id=\"apercu".$nom."\" style=\"position:relative; background-color: #FFFFFF; layer-background-color: #FFFFFF;\"><IMG SRC=\"".$vide."\" WIDTH=".$WIDTH." HEIGHT=".$HEIGHT." BORDER=".$BORDER." HSPACE=".$HSPACE." VSPACE=".$VSPACE." align=center></span>
     </td>
  </tr>
</table>";

return $output;
};
?>