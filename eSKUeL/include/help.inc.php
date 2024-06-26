<?php
function data_types() {
	Global $txt, $font, $colors;
	
	$output  = '<TABLE border="1" cellspacing="0" cellpadding="5" bordercolor="'.$colors['bordercolor'].'" width="100%" >';
	$output .= '<TR>';
	$output .= '	<TD><FONT '.$font.'><B>TINYINT</B></FONT></TD>';
	$output .= '	<TD><FONT '.$font.'>SIGNED : '.$txt['from'].' -128 '.$txt['to'].' 127</FONT></TD>';
	$output .= '	<TD><FONT '.$font.'>UNSIGNED : '.$txt['from'].' 0 '.$txt['to'].' 255</FONT></TD>';
	$output .= '</TR>';
	$output .= '<TR>';
	$output .= '	<TD><FONT '.$font.'><B>SMALLINT</B></FONT></TD>';
	$output .= '	<TD><FONT '.$font.'>SIGNED : '.$txt['from'].' -32768 '.$txt['to'].' 32767</FONT></TD>';
	$output .= '	<TD><FONT '.$font.'>UNSIGNED : '.$txt['from'].' 0 '.$txt['to'].' 65535</FONT></TD>';
	$output .= '</TR>';
	$output .= '<TR>';
	$output .= '	<TD><FONT '.$font.'><B>MEDIUMINT</B></FONT></TD>';
	$output .= '	<TD><FONT '.$font.'>SIGNED : '.$txt['from'].' -8388608 '.$txt['to'].' 8388607</FONT></TD>';
	$output .= '	<TD><FONT '.$font.'>UNSIGNED : '.$txt['from'].' 0 '.$txt['to'].' 16777215</FONT></TD>';
	$output .= '</TR>';
	$output .= '<TR>';
	$output .= '	<TD><FONT '.$font.'><B>INT</B></FONT></TD>';
	$output .= '	<TD><FONT '.$font.'>SIGNED : '.$txt['from'].' -2147483648 '.$txt['to'].' 2147483647</FONT></TD>';
	$output .= '	<TD><FONT '.$font.'>UNSIGNED : '.$txt['from'].' 0 '.$txt['to'].' 4294967295</FONT></TD>';
	$output .= '</TR>';
	$output .= '<TR>';
	$output .= '	<TD><FONT '.$font.'><B>BIGINT</B></FONT></TD>';
	$output .= '	<TD><FONT '.$font.'>SIGNED : '.$txt['from'].' -9223372036854775808 <BR>'.$txt['to'].' 9223372036854775807</FONT></TD>';
	$output .= '	<TD><FONT '.$font.'>UNSIGNED : '.$txt['from'].' 0 <BR>'.$txt['to'].' 18446744073709551615</FONT></TD>';
	$output .= '</TR>';
	$output .= '<TR>';
	$output .= '	<TD><FONT '.$font.'><B>FLOAT</B></FONT></TD>';
	$output .= '	<TD colspan="2">
						<FONT '.$font.'>'.$txt['from'].' -3.402823466E+38 '.$txt['to'].' -1.175494351E-38, 0,
						'.$txt['from'].' 1.175494351E-38 '.$txt['to'].' 3.402823466E+38</FONT>
					</TD>';
	$output .= '</TR>';
	$output .= '<TR>';
	$output .= '	<TD><FONT '.$font.'><B>DOUBLE</B></FONT></TD>';
	$output .= '	<TD colspan="2">
						<FONT '.$font.'>'.$txt['from'].' -1.7976931348623157E+308 '.$txt['to'].' -2.2250738585072014E-308, 0,<BR>
						'.$txt['from'].' 2.2250738585072014E-308 '.$txt['to'].' to 1.7976931348623157E+308</FONT>
					</TD>';
	$output .= '</TR>';
	$output .= '<TR>';
	$output .= '	<TD><FONT '.$font.'><B>DECIMAL</B></FONT></TD>';
	$output .= '	<TD colspan="2">
						<FONT '.$font.'>-</FONT>
					</TD>';
	$output .= '</TR>';
	$output .= '<TR>';
	$output .= '	<TD><FONT '.$font.'><B>DATE</B></FONT></TD>';
	$output .= '	<TD colspan="2"><FONT '.$font.'>'.$txt['from'].' 1000-01-01  '.$txt['to'].' 9999-12-31</FONT></TD>';
	$output .= '</TR>';
	$output .= '<TR>';
	$output .= '	<TD><FONT '.$font.'><B>DATETIME</B></FONT></TD>';
	$output .= '	<TD colspan="2"><FONT '.$font.'>'.$txt['from'].' 1000-01-01 00:00:00 '.$txt['to'].' 9999-12-31 23:59:59</FONT></TD>';
	$output .= '</TR>';
	$output .= '	<TD><FONT '.$font.'><B>TIMESTAMP</B></FONT></TD>';
	$output .= '	<TD colspan="2">
						<FONT '.$font.'>-</FONT>
					</TD>';
	$output .= '</TR>';
	$output .= '<TR>';
	$output .= '	<TD><FONT '.$font.'><B>TIME</B></FONT></TD>';
	$output .= '	<TD colspan="2"><FONT '.$font.'>'.$txt['from'].' -838:59:59  '.$txt['to'].' 838:59:59</FONT></TD>';
	$output .= '</TR>';
	$output .= '<TR>';
	$output .= '	<TD><FONT '.$font.'><B>YEAR</B></FONT></TD>';
	$output .= '	<TD><FONT '.$font.'>4 : '.$txt['from'].' 1901 '.$txt['to'].' 2155, 0000</FONT></TD>';
	$output .= '	<TD><FONT '.$font.'>2 : '.$txt['from'].' 70 (1970) '.$txt['to'].' 69 (2069)</FONT></TD>';
	$output .= '</TR>';
	$output .= '<TR>';
	$output .= '	<TD><FONT '.$font.'><B>CHAR</B></FONT></TD>';
	$output .= '	<TD colspan="2"><FONT '.$font.'>'.$txt['from'].' 0 '.$txt['to'].' 255 '.$txt['help_chars'].'</FONT></TD>';
	$output .= '</TR>';
	$output .= '<TR>';
	$output .= '	<TD><FONT '.$font.'><B>VARCHAR</B></FONT></TD>';
	$output .= '	<TD colspan="2"><FONT '.$font.'>'.$txt['from'].' 0 '.$txt['to'].' 255 '.$txt['help_chars'].'</FONT></TD>';
	$output .= '</TR>';
	$output .= '<TR>';
	$output .= '	<TD><FONT '.$font.'><B>TINYTEXT<BR>TINYBLOB</B></FONT></TD>';
	$output .= '	<TD colspan="2"><FONT '.$font.'>'.$txt['from'].' 0 '.$txt['to'].' 255 '.$txt['help_chars'].'</FONT></TD>';
	$output .= '</TR>';
	$output .= '<TR>';
	$output .= '	<TD><FONT '.$font.'><B>TEXT<BR>BLOB</B></FONT></TD>';
	$output .= '	<TD colspan="2"><FONT '.$font.'>'.$txt['from'].' 0 '.$txt['to'].' 65535 '.$txt['help_chars'].'</FONT></TD>';
	$output .= '</TR>';
	$output .= '<TR>';
	$output .= '	<TD><FONT '.$font.'><B>MEDIUMTEXT<BR>MEDIUMBLOB</B></FONT></TD>';
	$output .= '	<TD colspan="2"><FONT '.$font.'>'.$txt['from'].' 0 '.$txt['to'].' 16777215 '.$txt['help_chars'].'</FONT></TD>';
	$output .= '</TR>';
	$output .= '<TR>';
	$output .= '	<TD><FONT '.$font.'><B>LONGTEXT<BR>LONGBLOB</B></FONT></TD>';
	$output .= '	<TD colspan="2"><FONT '.$font.'>'.$txt['from'].' 0 '.$txt['to'].' 4294967295 '.$txt['help_chars'].'</FONT></TD>';
	$output .= '</TR>';
	$output .= '<TR>';
	$output .= '	<TD><FONT '.$font.'><B>SET</B></FONT></TD>';
	$output .= '	<TD colspan="2"><FONT '.$font.'>'.$txt['from'].' 0 '.$txt['to'].' 255 '.$txt['help_values'].'</FONT></TD>';
	$output .= '</TR>';
	$output .= '<TR>';
	$output .= '	<TD><FONT '.$font.'><B>ENUM</B></FONT></TD>';
	$output .= '	<TD colspan="2"><FONT '.$font.'>'.$txt['from'].' 0 '.$txt['to'].' 64 '.$txt['help_members'].'</FONT></TD>';
	$output .= '</TR>';
	
	
	
	
	$output .= '</TABLE>';

	return $output;	
}

?>