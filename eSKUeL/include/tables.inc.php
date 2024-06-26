<?php
#####################################
# Show the Home Page of a table
# $sql_ref = SQL link to the base
# $tbl = Current table
#####################################
function show_tbl_hp($sql_ref,$tbl) {
    Global $colors, $txt;
    $output = '<FONT size="-1"><B>'.$txt['tbl'].'</B> '.$tbl.'</FONT>';
    $output .= show_tbl_fields($sql_ref,$tbl);
    $output .= show_tbl_stats($sql_ref,$tbl);


    return $output;
}

#####################################
# Show the fields list of a table
# $sql_ref = SQL link to the base
# $tbl = Current table
#####################################
function show_tbl_fields($sql_ref,$tbl) {
    global $colors, $font, $HTTP_POST_VARS, $txt;


    $sql_ref->query("SHOW FIELDS FROM ".sql_back_ticks($tbl, $sql_ref));
    $output  = '<SCRIPT language=javascript>
    			<!--
    			function chg_action(arg) {
					var value = null;

    				for (var b = 0; b < document.fields_op.field_action.length; b++) {

      					if (document.fields_op.field_action[b].checked) {
	        				value = document.fields_op.field_action[b].value;
	        				document.fields_op.action.value = value;
  						}
  					}
    			}

				function CA(){
					for (var i = 0; i < window.document.fields_op.elements.length; i++) {
						var e = window.document.fields_op.elements[i];
						if (e.type==\'checkbox\') {
								if (window.document.fields_op.chkbox_slt.value == "true") {
									e.checked = true;
								}
								else {
									e.checked = false;
								}
						}
					}
					if (window.document.fields_op.chkbox_slt.value == "true" ){
						window.document.fields_op.chkbox_slt.value = "false";
					}
					else {
						window.document.fields_op.chkbox_slt.value = "true";
					}

				}
				//-->
				</SCRIPT>';
    $output .= '<FORM name="fields_op" action="main.php?db='.urlencode($sql_ref->Database).'&tbl='.urlencode($tbl).'" method="post" onSubmit="chg_action();">';
    $output .= '<table border="1" bgcolor="'.$colors['table_bg'].'" bordercolor="'.$colors['titre_bg'].'" cellspacing="0" cellpadding="5">';
    $output .= '<tr>
                        <td><font '.$font.'><b>'.$txt['name'].'</b></font></td>
                        <td><font '.$font.'><b>'.$txt['type'].'</b></font></td>
                        <td><font '.$font.'><b>'.$txt['can_be_null'].'</b></font></td>
                        <td><font '.$font.'><b>'.$txt['default_value'].'</b></font></td>
                        <td><font '.$font.'><b>'.$txt['xtra'].'</b></font></td>
                        <td><font '.$font.'><b><A href="javascript:CA();">'.$txt['choice'].'</A></b></font></td>
                </tr>';
	$i = 0;
    while (list($field,$type,$null_not_allowed,$key,$default,$extra) = $sql_ref->next_record()) {
        $null_not_allowed = ($null_not_allowed) ? $txt['Yes'] : $txt['No'];
        $default = ($default != '') ? $default : '&nbsp;';
        $extra = ($extra != '') ? $extra : '&nbsp;';
        $output .= '<tr>
                        <td><font '.$font.'>'.stripslashes($field).'</font></td>
                        <td align="right"><font '.$font.'>'.$type.'</font></td>
                        <td align="right"><font '.$font.'>'.$null_not_allowed.'</font></td>
                        <td align="right"><font '.$font.'>'.$default.'</font></td>
                        <td align="right"><font '.$font.'>'.$extra.'</font></td>
                        <td align="center"><input type=checkbox name="field_check['.$i.']" value=1 class="pick"></td>
                    </tr>';
    	$i++;
    }
    $output .= '<tr>'."\n";
    $output .= '	<td colspan="6" align="center" nowrap>'."\n";
    $output .= '		<font '.$font.'>'."\n";
    $output .= '		<input type="radio" name="field_action" value="drop_field" class="pick">'.$txt['delete_choice']."\n";
    $output .= '		<input type="radio" name="field_action" value="modif_field" class="pick" checked>'.$txt['modif_choice']."\n";
    $output .= '		<input type="hidden" name="action" value="">'."\n";
    $output .= '		<input type="submit" value="'.$txt['execute'].'" class="bosses">'."\n";
    $output .= '		</font>'."\n";
    $output .= '	</td>'."\n";
    $output .= '</tr>'."\n";
    $output .= '</table>'."\n";
    $output .= '<INPUT type="hidden" name="chkbox_slt" value="true">';
    $output .= '</FORM>';
    return $output;
}

#####################################
# Show the indexes list of a table
# $sql_ref = SQL link to the base
# $tbl = Current table
#####################################

function show_tbl_indexes($sql_ref,$tbl) {
    global $colors, $font, $txt;
    $sql_ref->query("SHOW INDEX FROM ".sql_back_ticks($tbl, $sql_ref));

	$output_primary = '';
	$output_key		= '';
	$primary_keys 	= array();
    $output  = '<SCRIPT language="javascript">
    			function chg_key(arg) {
    				document.frmkey.key.value = arg;
    				document.frmkey.submit();
    			}
    			</SCRIPT>';
    $output .= '<FORM name="frmkey" action="main.php?db='.urlencode($sql_ref->Database).'&tbl='.urlencode($tbl).'&action=drop_key" method="post">';
    $output .= '<table border="1" bgcolor="'.$colors['table_bg'].'" bordercolor="'.$colors['titre_bg'].'" cellspacing=0 cellpadding=5>';
    $output .= '<tr>';
    $output .= '	<td><font '.$font.'><B>'.$txt['name'].'</B></font></td>';
    $output .= '	<td><font '.$font.'><B>'.$txt['type'].'</B></font></td>';
    $output .= '	<td><font '.$font.'><B>'.$txt['unique'].'</B></font></td>';
    $output .= '	<td><font '.$font.'><B>'.$txt['field'].'</B></font></td>';
    $output .= '	<td>&nbsp;</td>';
    $output .= '</tr>';

    if ( $sql_ref->num_rows() ) {

        while ($ret = $sql_ref->next_record() ) {

			### Gathering Infos about indexes
        	$tbl 			= isset($ret['Table']) ? $ret['Table'] : '';
        	$non_unique		= isset($ret['Non_unique']) ? $ret['Non_unique'] : '';
        	$key_name		= isset($ret['Key_name']) ? $ret['Key_name'] : '';
        	$seq_in_index	= isset($ret['Seq_in_index']) ? $ret['Seq_in_index'] : '';
        	$column_name	= isset($ret['Column_name']) ? $ret['Column_name'] : '';
        	$collation		= isset($ret['Collation']) ? $ret['Collation'] : '';
        	$cardinality	= isset($ret['Cardinality']) ? $ret['Cardinality'] : '';
        	$sub_part		= isset($ret['Sub_part']) ? $ret['Sub_part'] : '';
        	$packed			= isset($ret['Packed']) ? $ret['Packed'] : '';
        	$comment		= isset($ret['Comment']) ? $ret['Comment'] : '';

        	$key_type 		= '';

			if ($non_unique == 0) {
				$key_type = 'UNIQUE';
			}
            $non_unique = (!$non_unique) ? $txt['Yes'] : $txt['No'];

			if ($comment == 'FULLTEXT') {
				$key_type = 'FULLTEXT';
			}

			if ($key_name == 'PRIMARY') {
				$key_type = 'PRIMARY';
			}

			if ($key_type == '') {
				$key_type = 'INDEX';
			}

            $link = '<A href="javascript:chg_key(\''.addslashes(magic_quote_bypass($key_name)).'\')">'.$txt['delete'].'</A>';
			if ($key_name == 'PRIMARY') {
				$primary_keys[] = $column_name;
			}
			else {
				$output_key .= '<tr>'."\n";
				$output_key .= '	<td><font '.$font.'>'.$key_name.'</font></td>'."\n";
				$output_key .= '	<td><font '.$font.'>'.$key_type.'</font></td>'."\n";
				$output_key .= '	<td><font '.$font.'>'.$non_unique.'</font></td>'."\n";
				$output_key .= '	<td><font '.$font.'>'.$column_name.'</font></td>'."\n";
				$output_key .= '	<td><font '.$font.'>'.$link.'</font></td>'."\n";
				$output_key .= '</tr>'."\n";
			}
        }
		$nb_primary = count($primary_keys);
		if ($nb_primary != 0) {
			$output_primary .= '<tr>'."\n";
			$output_primary .= '	<td rowspan="'.$nb_primary.'"><font '.$font.'>PRIMARY</font></td>'."\n";
			$output_primary .= '	<td rowspan="'.$nb_primary.'"><font '.$font.'>PRIMARY</font></td>'."\n";
			$output_primary .= '	<td rowspan="'.$nb_primary.'"><font '.$font.'>'.$txt['Yes'].'</font></td>'."\n";
			$output_primary .= '	<td><font '.$font.'>'.$primary_keys[0].'</font></td>'."\n";
			$output_primary .= '	<td rowspan="'.$nb_primary.'"><font '.$font.'><A href="javascript:chg_key(\'PRIMARY\')">'.$txt['delete'].'</A></font></td>'."\n";

			for ($i = 1; $i < $nb_primary; $i++) {
				$output_primary .= '<tr>'."\n";
				$output_primary .= '	<td><font '.$font.'>'.$primary_keys[$i].'</font></td>';
				$output_primary .= '</tr>';
			}

		}
		$output .= $output_primary;
        $output .= '</table>';
        $output .= '<INPUT type="hidden" name="key" value="">';
        $output .= '</FORM>';
    }
    else {
        $output = '';
    }

     return $output;
}

#####################################
# Show differents statistics infos
# about a table
# $sql_ref = SQL link to the base
# $tbl = Current table
#####################################
function show_tbl_stats($sql_ref,$tbl) {
    global $colors, $font, $txt;
	$output = '';

    $tbl_infos = $sql_ref->getTblsInfos();
    if ($tbl_infos['Version'] < 32306) {
    	$output  = show_tbl_indexes($sql_ref,$tbl);
    	$output .= '<table border="1" bgcolor="'.$colors['table_bg'].'" bordercolor="'.$colors['titre_bg'].'" cellspacing=0 cellpadding=5>';
    	$output .= '<tr><td><font '.$font.'><b>'.$txt['records'].' :</b></font></td><td><font '.$font.'>'.$tbl_infos[$tbl]['Rows'].'</font></td></tr>';
    	$output .= '</table>';
    	return $output;
    }

   	$tbl_type 		= $tbl_infos[$tbl]['Type'];
	$row_format 	= $tbl_infos[$tbl]['Row_Format'];
    $rows 			= $tbl_infos[$tbl]['Rows'];
    $avg_row_length = $tbl_infos[$tbl]['Avg_Row_Length'];
    $data_length 	= $tbl_infos[$tbl]['Data_Length'];
    $index_length 	= $tbl_infos[$tbl]['Index_Length'];
	$auto_increment = $tbl_infos[$tbl]['Auto_Increment'];
    $create_time 	= $tbl_infos[$tbl]['Create_Time'];
    $update_time 	= $tbl_infos[$tbl]['Update_Time'];
    $check_time 	= $tbl_infos[$tbl]['Check_Time'];
    $data_lost 		= $tbl_infos[$tbl]['Data_Free'];
    $comment 		= $tbl_infos[$tbl]['Comment'];

    $create_time 	= ($create_time == '') ? '&nbsp;' : $create_time;
    $update_time 	= ($update_time == '') ? '&nbsp;' : $update_time;
	$check_time 	= ($check_time == '') ? $txt['never_done'] : $check_time;
    $auto_increment = ($auto_increment == '') ? '&nbsp;' : $auto_increment;
    $next_autoincrement_title = ($auto_increment == '&nbsp;') ? '&nbsp;' : '<B>'.$txt['next_auto'].' :</B>';

    if (eregi('fixed',$row_format)) {
    	$row_format = $txt['fixed'];
    }
    if (eregi('dynamic',$row_format)) {
    	$row_format = $txt['dynamic'];
    }
    if (eregi('compressed',$row_format)) {
    	$row_format = $txt['compressed'];
    }


    if ($comment != '') {
    	$output = '<B>'.$txt['tbl_comment'].' : </B><BR>'.nl2br($comment).'<BR><BR>';
    }
    $output .= show_tbl_indexes($sql_ref,$tbl);
    $output .= '<br>';
    $output .= '<table border="1" bgcolor="'.$colors['table_bg'].'" bordercolor="'.$colors['titre_bg'].'" cellspacing=0 cellpadding=5>';
    $output .='<tr>
                    <td><font '.$font.'><b>'.$txt['type'].' :</b></font></td>
                    <td><font '.$font.'>'.$tbl_type.'</font></td>
                    <td rowspan="5">&nbsp;</td>
                    <td><font '.$font.'><b>'.$txt['type_records'].' :</b></font></td>
                    <td><font '.$font.'>'.$row_format.'</font></td>
               </tr>
				<tr>
					<td><font '.$font.'><b>'.$txt['records'].' :</b></font></td>
               		<td><font '.$font.'>'.$rows.'</font></td>
               		<td><font '.$font.'><b>'.$txt['record_size'].' :</b></font></td>
               		<td><font '.$font.'>'.$avg_row_length.'</font></td>
               </tr>
               <tr>
               		<td><font '.$font.'><b>'.$txt['data_size'].' :</b></font></td>
               		<td><font '.$font.'>'.$data_length.'</font></td>
               		<td><font '.$font.'><b>'.$txt['index_size'].' :</b></font></td>
               		<td><font '.$font.'>'.$index_length.'</font></td>
               </tr>
               <tr>
               		<td><font '.$font.'><b>'.$txt['creation_date'].' :</b></font></td>
               		<td><font '.$font.'>'.$create_time.'</font></td>
               		<td><font '.$font.'><b>'.$txt['last_update_date'].' :</b></font></td>
               		<td><font '.$font.'>'.$update_time.'</font></td>
               </tr>
               <tr>
               		<td><font '.$font.'><b>'.$txt['last_check_date'].' :</b></font></td>
               		<td><font '.$font.'>'.$check_time.'</font></td>
               		<td><font '.$font.'>'.$next_autoincrement_title.'</font></td>
               		<td><font '.$font.'>'.$auto_increment.'</font></td>
               </tr>';
    $output .= '</table>';

    if ($data_lost != 0) {
    	$output .= '<BR><font color=#FF0000>'.$txt['lost_space'].' : '.$data_lost.' '.$txt['unit'].'</font>';
    }
	return $output;
}

#####################################
# Set a comment for a table
# $sql_ref = SQL link to the base
# $tbl = Current table
#####################################
function set_tbl_comment($sql_ref, $tbl) {
	global $colors, $font, $txt, $HTTP_POST_VARS;


	$do_comment = isset($HTTP_POST_VARS['do_comment']) ? $HTTP_POST_VARS['do_comment'] : '';
	$comment	= isset($HTTP_POST_VARS['comment']) ? $HTTP_POST_VARS['comment'] : '';
	$comment 	= addslashes(magic_quote_bypass($comment));
	$comment 	= htmlentities($comment);

	if ($do_comment == 1) {
		$sql_ref->query("ALTER TABLE ".sql_back_ticks($tbl, $sql_ref)." COMMENT='$comment'");
		$output = $txt['comment_recorded'];
		$output .= return_2_table($sql_ref->Database, $tbl);
	}
	else {
		$tbl_infos = $sql_ref->getTblsInfos();

		$comment = $tbl_infos[$tbl]['Comment'];
		$output  = '<form action="main.php?db='.urlencode($sql_ref->Database).'&tbl='.urlencode($tbl).'&action=comment" method="post">';
		$output .= '<table border="0" bgcolor="'.$colors['table_bg'].'" bordercolor="'.$colors['titre_bg'].'" cellspacing=0 cellpadding=5 width=100%>';
		$output .= '<tr>
						<td><font '.$font.'><B>'.$txt['a_comment'].' : </B></font><br><textarea name=comment cols=30 rows=3 class="trous">'.$comment.'</textarea></td>
					</tr>';
		$output .= '</table>';
		$output .= '<input type="submit" value="'.$txt['record'].'" class="bosses">';
		$output .= '<input type="hidden" name="do_comment" value="1">';
		$output .= '</form>';
	}

	return $output;
}

#####################################
# INSERT a new line into a table
# $sql_ref = SQL link to the base
# $tbl = Current table
#####################################
function insert_into_tbl ($sql_ref,$tbl) {
    Global $colors, $HTTP_POST_VARS, $font, $txt;
    Global $data_functions;

	$field_value 	= isset($HTTP_POST_VARS['field_value']) ? $HTTP_POST_VARS['field_value'] : '';
	$add 			= isset($HTTP_POST_VARS['add']) ? $HTTP_POST_VARS['add'] : '';
	$fields_list	= '';
	$values_list 	= '';
	$output			= '';

    if ($add == 1) {
        $sql_ref->query("DESCRIBE ".sql_back_ticks($tbl, $sql_ref));
        $nbFields = 0;
        while ($arrDesc = $sql_ref->next_record()) {
            $field = $arrDesc['Field'];

            ### Multiple select
            if (isset($HTTP_POST_VARS["field_value_$nbFields"]) && is_array($HTTP_POST_VARS["field_value_$nbFields"])) {

                $value = '';
                $tmp_value = isset($HTTP_POST_VARS["field_value_$nbFields"]) ? $HTTP_POST_VARS["field_value_$nbFields"] : '';

                for ($i = 0; $i < count ($tmp_value); $i++) {
                    $value .= addSlashes(magic_quote_bypass($tmp_value[$i])).',';
                }

                $value = substr($value,0,strlen($value) - 1);
            }
            ### Otherwise
            else {
                $value = isset($HTTP_POST_VARS["field_value_$nbFields"]) ? $HTTP_POST_VARS["field_value_$nbFields"] : '';
            }

            $function = isset($HTTP_POST_VARS["field_function_$nbFields"]) ? $HTTP_POST_VARS["field_function_$nbFields"] : '';
            $fields_list .= sql_back_ticks($field, $sql_ref).',';
            if (isset($HTTP_POST_VARS["field_null_$nbFields"])) {
            	$values_list .= 'NULL, ';
            }
            else {
	            if ($function == 0) {
	                $values_list .= '\''.addSlashes(magic_quote_bypass($value)).'\', ';
	            }
	            else {
	                if ($value == '') {
	                    $values_list .= $data_functions[$function].'(), ';
	                }
	                else {
	                    $values_list .= $data_functions[$function].'(\''.addSlashes(magic_quote_bypass($value)).'\'), ';
	                }
	            }
	        }
            $nbFields++;
        }

        $fields_list = substr($fields_list,0,strlen($fields_list) -1);
        $values_list = substr($values_list, 0, strlen($values_list) - 2);
        $final_query = 'INSERT INTO '.sql_back_ticks($tbl, $sql_ref).' ('.$fields_list.') VALUES ('.$values_list.');';

        $sql_ref->query($final_query);
        $output .= display_bookmarkable_query($final_query);
        $output .= '<BR><BR>'.$txt['modif_done'];
 		$output .= '<BR>'.return_2_table($sql_ref->Database,$tbl);
    }
    else {


	    $sql_ref->query("DESCRIBE ".sql_back_ticks($tbl, $sql_ref));
		$output = '<FORM action="main.php?db='.urlencode($sql_ref->Database).'&tbl='.urlencode($tbl).'&action=insert" method="post">';
		$output .= '<table border="1" bgcolor="'.$colors['table_bg'].'" bordercolor="'.$colors['titre_bg'].'" cellspacing=0 cellpadding=5>';
		$output .= '<tr>
						<td><font '.$font.'><b>'.$txt['name'].'</b></font></td>
						<td><font '.$font.'><b>'.$txt['type'].'</b></font></td>
						<td><font '.$font.'><b>'.$txt['function'].'</b></font></td>
						<td><font '.$font.'><b>'.$txt['null'].'</b></font></td>
						<td><font '.$font.'><b>'.$txt['value'].'</b></font></td>
					</tr>';

		$nbFields = 0;
		while ($arrDesc = $sql_ref->next_record()) {

			$field 	 	= $arrDesc['Field'];
			$type 	 	= $arrDesc['Type'];
			$can_be_null= $arrDesc['Null'];

			$default 				= isset($arrDesc['Default']) ? htmlentities($arrDesc['Default']) : '';
			$default_values_output 	= display_field_form($type,'field_value_'.$nbFields, $default);

			if ( eregi('enum',$type) ) {
                $select_function = '&nbsp;';
			}
			elseif ( eregi('set',$type) ) {
                $select_function = '&nbsp;';
			}
			else {
				$select_function = select_function("field_function_$nbFields");
			}

			### Setting the null checkbox
			if ($can_be_null) {
				$null_checkbox = '<INPUT type="checkbox" name="field_null_'.$nbFields.'">';
			}
			else {
				$null_checkbox = '&nbsp;';
			}

			$output .= '<tr>'."\n";
			$output .= '	<td><font '.$font.'>'.$field.'</font></td>'."\n";
			$output .= '	<td><font '.$font.'>'.$type.'</font></td>'."\n";
			$output .= '	<td><font '.$font.'>'.$select_function.'</font></td>'."\n";
			$output .= '	<td><font '.$font.'>'.$null_checkbox.'</font></td>'."\n";
			$output .= '	<td><font '.$font.'>'.$default_values_output.'</font></td>'."\n";
			$output .= '</tr>'."\n";

			$nbFields++;
		}

		$output .= '</TABLE><BR>'."\n";
		$output .= '<INPUT type="submit" value="'.$txt['add'].'" class="bosses">'."\n";
		$output .= '<INPUT type="hidden" name="add" value="1">'."\n";
		$output .= '</FORM>'."\n";
	}
	return $output;
}

#####################################
# Show the content of a table
# $sql_ref = SQL link to the base
# $tbl = Current table
# $extra_query = if we want something
# different than SELECT * FROM $tbl
#####################################
function view_tbl($sql_ref, $tbl, $extra_query = '') {
        global $colors, $font, $txt;
        global $conf;
        global $HTTP_POST_VARS, $HTTP_COOKIE_VARS;
        $start_timing = start_timing();

		$order_field 		= isset($HTTP_POST_VARS["order_field"]) ? magic_quote_bypass($HTTP_POST_VARS["order_field"]) : '';
        $last_order 		= isset($HTTP_POST_VARS["last_order"]) ? $HTTP_POST_VARS["last_order"] : '';
		$last_field			= isset($HTTP_POST_VARS["last_field"]) ? $HTTP_POST_VARS["last_field"] : '';
		$navAction 			= isset($HTTP_POST_VARS["navAction"]) ? $HTTP_POST_VARS["navAction"] : '';
		$nb2show 			= isset($HTTP_POST_VARS["nb2show"]) ? $HTTP_POST_VARS["nb2show"] : '';
		$limit 				= isset($HTTP_POST_VARS["limit"]) ? $HTTP_POST_VARS["limit"] : '';
		$navSqlOrderBy 		= isset($HTTP_POST_VARS['navSqlOrderBy']) ? magic_quote_bypass($HTTP_POST_VARS['navSqlOrderBy']) : '';
		$dont_reduce_blob 	= isset($HTTP_POST_VARS['dont_reduce_blob']) ? $HTTP_POST_VARS['dont_reduce_blob'] : 0;
		$dont_show_forms 	= 0;
		$is_blob 			= 0;
		$keys_counter 		= 0;
		$nb2show 			= ($nb2show == '') ? $conf['defaultPerRequest'] : $nb2show;
		$limit 				= ($limit == '') ? 0 : $limit;
		$keys 				= array();


		### Getting keys
		$sql_ref->query("SHOW INDEX FROM ".sql_back_ticks($tbl, $sql_ref));
		while ($sql_result = $sql_ref->next_record()) {
			$keys[] = $sql_result['Column_name'];
		}

        if ($order_field == '') {
                $sql_order_by = '';
        }
        elseif ($last_field == $order_field) {
                $last_order = ($last_order == 'DESC') ? 'ASC' : 'DESC';
                $sql_order_by = 'ORDER BY '.sql_back_ticks($order_field, $sql_ref).' '.$last_order;

        }
        else {
                $sql_order_by = 'ORDER BY '.sql_back_ticks($order_field, $sql_ref).' ASC';
                $last_order = 'ASC';
        }

        $sql_order_by = ($sql_order_by == '') ? $navSqlOrderBy : $sql_order_by;

        $tbl_infos = $sql_ref->getTblsInfos();
        $nbEnreg = $tbl_infos[$tbl]['Rows'];

		if ($nbEnreg < $nb2show) {
			$nb2show = $nbEnreg;
		}

        switch ($navAction) {
        	case 'begin':
            	$limit = 0;
                $limitfrm = $limit + $nb2show;
			break;

            case 'prev':
	           	$limit_prev = isset($HTTP_POST_VARS['limit_prev']) ? $HTTP_POST_VARS['limit_prev'] : '';
            	$limit = $limit_prev - $nb2show;
				if ($limit <= 0) {
		        	$limit = 0;
            	}
    	        $limitfrm = $limit + $nb2show ;
            break;

            case 'next':
				if ($limit >= $nbEnreg) {
		        	$limit -= $nb2show;
		            $nb2show = $nbEnreg - $limit;
	           	}
                if ( ($limit + $nb2show) >= $nbEnreg) {
                	$nb2show = $nbEnreg - $limit;
                	$limitfrm = $limit ;
				}
                else {
                	$limitfrm = $limit + $nb2show;
                }
			break;

            case 'end':
            	$limit = $nbEnreg - $nb2show;
                $limitfrm = $limit;
            break;

            default:
            	$limitfrm = $limit + $nb2show;
            break;
		}


		$output_js = '<SCRIPT language="Javascript">';
        $output_js .= 'function field_chg(field) {
                        document.tbl_view.order_field.value = field;
                        document.tbl_view.submit();
                       }
                       function nav_chg(value,frm) {
                       	document.forms[frm].navAction.value = value;
                       	document.forms[frm].submit();
                       }
                       function dump(frm, tbl) {
                            document.forms[frm].action = "main.php?db='.urlencode($sql_ref->Database).'&tbl="+tbl+"&action=dump";
                            document.forms[frm].submit();
                       }
                       function full_text() {
                       		document.navFrm.dont_reduce_blob.value = '.(($dont_reduce_blob == 0) ? 1 : 0).';
                       		document.navFrm.limit.value = '.$limit.';
                       		document.navFrm.submit();
                       }
                       ';

        $output_js .= '</SCRIPT>';

      	$output  = $txt['display_records'].' '.strtolower($txt['from']).' '.($limit+1).' '.strtolower($txt['to']).' ';
		$output .= ( ($limit+$nb2show) > $nbEnreg) ? $nbEnreg : ($limit+$nb2show);
		$output .= ' ('.$nb2show.' '.strtolower($txt['records']).')';
		$output .= '<BR>'.$txt['nb_records'].' : '.$nbEnreg;

		$sql = 'SELECT * FROM '.sql_back_ticks($tbl, $sql_ref).' '.$sql_order_by.' LIMIT '.$limit.','.$nb2show;

        $output_top = display_bookmarkable_query($sql);

		$navFormTop = '<FORM name="navFrm" action="main.php?db='.urlencode($sql_ref->Database).'&tbl='.urlencode($tbl).'&action=view" method="post">
					<TABLE border="0" cellspacing="0"cellpadding="5">
					<TR>
						<TD><INPUT type="button" name="start" value="<<" onclick="nav_chg(\'begin\',\'navFrm\')" class="bosses"></TD>
						<TD><INPUT type="button" name="prev" value="<" onclick="nav_chg(\'prev\',\'navFrm\')" class="bosses"></TD>
						<TD><FONT '.$font.'>'.$txt['from'].' : </FONT></TD>
						<TD><INPUT type="text" name="limit" value="'.$limitfrm.'" class="trous"></TD>
						<TD><FONT '.$font.'>'.$txt['display'].' : </FONT></TD>
						<TD><INPUT type="text" name="nb2show" value="'.$nb2show.'" class="trous"></TD>
						<TD><INPUT type="submit" name="next" value=">" onclick="nav_chg(\'next\',\'navFrm\')" class="bosses"></TD>
						<TD><INPUT type="button" name="end" value=">>" onclick="nav_chg(\'end\',\'navFrm\')" class="bosses"></TD>
					</TR>
					</TABLE>
					<INPUT type="hidden" name="dont_reduce_blob" value="'.$dont_reduce_blob.'">
					<INPUT type="hidden" name="limit_prev" value="'.$limit.'">
					<INPUT type="hidden" name="navAction" value="">
					<INPUT type="hidden" name="navSqlOrderBy" value="'.$sql_order_by.'">
					<INPUT type="hidden" name="extra_query" value="'.$extra_query.'">
					</FORM>';
		$navFormBottom = '<FORM name="navFrmBottom" action="main.php?db='.urlencode($sql_ref->Database).'&tbl='.urlencode($tbl).'&action=view" method="post">
					<TABLE border="0" cellspacing="0"cellpadding="5">
					<TR>
						<TD><INPUT type="button" name="start" value="<<" onclick="nav_chg(\'begin\',\'navFrmBottom\')" class="bosses"></TD>
						<TD><INPUT type="button" name="prev" value="<" onclick="nav_chg(\'prev\',\'navFrmBottom\')" class="bosses"></TD>
						<TD><FONT '.$font.'>'.$txt['from'].' : </FONT></TD>
						<TD><INPUT type="text" name="limit" value="'.$limitfrm.'" class="trous"></TD>
						<TD><FONT '.$font.'>'.$txt['display'].' : </FONT></TD>
						<TD><INPUT type="text" name="nb2show" value="'.$nb2show.'" class="trous"></TD>
						<TD><INPUT type="submit" name="next" value=">" onclick="nav_chg(\'next\',\'navFrmBottom\')" class="bosses"></TD>
						<TD><INPUT type="button" name="end" value=">>" onclick="nav_chg(\'end\',\'navFrmBottom\')" class="bosses"></TD>
					</TR>
					</TABLE>
					<INPUT type="hidden" name="dont_reduce_blob" value="'.$dont_reduce_blob.'">
					<INPUT type="hidden" name="limit_prev" value="'.$limit.'">
					<INPUT type="hidden" name="navAction" value="">
					<INPUT type="hidden" name="navSqlOrderBy" value="'.$sql_order_by.'">
					<INPUT type="hidden" name="extra_query" value="'.$extra_query.'">
					</FORM>';

        ### Doing the query

        $sql_ref->query($sql);

        ### The MySQL hasn't returned anything, the table is empty
        if ( $sql_ref->num_rows() == 0) {
                return $txt['empty_tbl'].'.'.return_2_table($sql_ref->Database,$tbl);
        }

        $output .= $navFormTop;
        $output .= '<FORM action="main.php?db='.urlencode($sql_ref->Database).'&tbl='.urlencode($tbl).'&action=view" method="post" name="tbl_view">';
        $output .= '<TABLE border=1 bgcolor="'.$colors['table_bg'].'" bordercolor="'.$colors['titre_bg'].'" cellspacing="0"cellpadding="5">';
        $output .= '<TR>';


		$keys_nb = count($keys);

        while ( $arrFields = $sql_ref->fetch_field() ) {

			### Is this field a type TEXT or BLOB ?

			if ( eregi('blob', $arrFields->type) || eregi('text', $arrFields->type) || (eregi('string',$arrFields->type) && $arrFields->max_length > $conf['reduceBlob'])) {
					$is_blob = 1;
					$blob_array[$keys_counter] = 1;
			}

			if ($keys_nb) {
				if (is_in_array($arrFields->name,$keys)) {
					$keys_index[$keys_counter] = $arrFields->name;
				}
			}
			else {
				$keys_index[$keys_counter] = $arrFields->name;
			}

			$output .= '<td><font '.$font.'><b><a href="javascript:field_chg(\''.addSlashes($arrFields->name).'\');">'.$arrFields->name.'</A></b></font></td>';

			$keys_counter++;

		}

	$output .= '<INPUT type="hidden" name="order_field" value="">';
    $output .= '<INPUT type="hidden" name="last_field" value="'.$order_field.'">';
    $output .= '<INPUT type="hidden" name="last_order" value="'.$last_order.'">';
    $output .= '<INPUT type="hidden" name="extra_query" value="'.$extra_query.'">';
    $output .= '<INPUT type="hidden" name="limit" value="'.$limit.'">';
	$output .= '<INPUT type="hidden" name="nb2show" value="'.$nb2show.'">';
	$output .= '</FORM>';

	$output .= '<td>&nbsp;</td></tr>';


    while ($arrView = $sql_ref->next_record(MYSQL_NUM)) {
        $output .= '<tr onMouseOver="this.bgColor=\''.$colors['bgcolor'].'\';" onMouseOut="this.bgColor=\''.$colors['table_bg'].'\';">';
        $js_link = '';

		for ($i = 0; $i < count($arrView); $i++) {

			if (isset($keys_index[$i])) {
            	if (strlen($js_link)) {
                	$js_link .= ' AND ';
				}

				if (!isset($arrView[$i])) {
					$js_link .= sql_back_ticks($keys_index[$i], $sql_ref).' IS NULL';
				}
				else {
					$js_link .= sql_back_ticks($keys_index[$i], $sql_ref).'=\''.(addslashes($arrView[$i])).'\'';
				}
			}

            if ($arrView[$i] == '' && isset($arrView[$i])) {
            	$output .= '<td><IMG src="img/vide.gif"></td>';
            }
            else {
				if ((isset($blob_array[$i])) && $conf['reduceBlob'] && !$dont_reduce_blob && (strlen($arrView[$i]) > $conf['reduceBlob'])) {
                	$output .= '<td><font '.$font.'>'.htmlentities(substr($arrView[$i],0,$conf['reduceBlob'])).'...</font></td>';
                }
                else {
                	if (!isset($arrView[$i])) {
                			$output .= '<td><font '.$font.'><I>NULL</I></font></td>';
                	}
                	else {
               			$output .= '<td><font '.$font.'>'.nl2br(htmlentities($arrView[$i])).'</font></td>';
               		}
                }
			}
		}

		### Add the action in HTTP_POST_VARS
		$HTTP_POST_VARS['action'] = 'view';
		$HTTP_POST_VARS['tbl_suppr'] = $tbl;
		$modif_link = 'main.php?db='.urlencode($sql_ref->Database).'&tbl='.urlencode($tbl).'&action=mod_record&query='.urlencode($js_link);
		$suppr_link = 'main.php?db='.urlencode($sql_ref->Database).'&tbl='.urlencode($tbl).'&action=sup_record&query='.urlencode($js_link);

		$output .= '<TD><font '.$font.'><a href="'.$modif_link.'">'.$txt['modify'].'</a><br><a href="'.$suppr_link.'">'.$txt['delete'].'</a></font></TD></TR>';

	}
	$output .= '</TABLE>';

	setcookie("serial",(serialize($HTTP_POST_VARS)));

	$output_extra  		 = '<BR><img src="'.$colors['img_path'].'img/dump.gif" border="0">&nbsp;<A href="javascript:dump(\'extra_actions_bottom\',\''.urlencode(urlencode(addSlashes($tbl))).'\');">'.$txt['dump_this_query'].'</A>';
	$output_extra_frm 	 = '<FORM action="" method="post" name="extra_actions_bottom">';
	$output_extra_frm 	.= '<INPUT type="hidden" name="extra_query" value="'.htmlentities($sql).'">';
	$output_extra_frm 	.= '</FORM>';


	### Have we encountered an type TEXT or BLOB ?
	if ($is_blob && $conf['reduceBlob']) {
		$txt_2_show = ($dont_reduce_blob == 1) ? $txt['hide_full_text'] : $txt['show_full_text'];
		$output_extra .= '<BR><img src="'.$colors['img_path'].'img/show_hide_txt.gif" border="0">&nbsp;<A href="javascript:full_text();">'.$txt_2_show.'</A><BR><BR>';
	}
	else {
		if ($output_extra != '') {
			$output_extra .= '<BR><BR>';
		}
	}

    $output .= $navFormBottom;

    $output = $output_js.$output_top.$output_extra.$output.$output_extra.$output_extra_frm;
    $output .= print_timing($start_timing);

    return $output;

}
#####################################
# Change the name of a table
# $sql_ref = SQL link to the base
# $tbl = Current table
#####################################
function rename_tbl($sql_ref,$tbl) {
	global $HTTP_POST_VARS,$colors, $font, $txt;

    $output 	= '';
    $rename 	= isset($HTTP_POST_VARS['rename']) ? $HTTP_POST_VARS['rename'] : '';
    $new_tbl 	= isset($HTTP_POST_VARS['new_tbl']) ? magic_quote_bypass($HTTP_POST_VARS['new_tbl']) : '';
    $input_error = (eregi('"',$new_tbl) || !strlen($new_tbl) || eregi('[\]',$new_tbl) || eregi('<',$new_tbl) || eregi('>',$new_tbl));

    if ($input_error && $rename == 1) {
    	$output = '<FONT color=#FF0000><B>'.$txt['invalid_dest'].'</B></FONT>';
        $rename = 0;
	}
    if ($rename == 1) {
    	$sql_ref->query("ALTER TABLE ".sql_back_ticks($tbl, $sql_ref)." RENAME ".sql_back_ticks($new_tbl, $sql_ref));
        $output .= '<font '.$font.'><b>'.$txt['tbl_renamed'].' '.$new_tbl.'.</b>';
        $output .= '<BR><BR><A href="main.php?db='.urlencode($sql_ref->Database).'">'.$txt['back'].'</A></font>';
        return $output;
	}
	else {
    	$output .= '<FORM action="main.php?db='.urlencode($sql_ref->Database).'&tbl='.urlencode($tbl).'&action=rename" method="post">';
    	$output .= '<table border=0 bgcolor="'.$colors['table_bg'].'">';
        $output .= '<TR><TD><font '.$font.'><B>'.$txt['old_name'].' : </B></TD><TD><font '.$font.'>'.$tbl.'</font></TD></TR>';
        $output .= '<TR><TD><font '.$font.'><B>'.$txt['new_name'].' : </B></font></TD><TD><INPUT type="text" name="new_tbl" class="trous">';
        $output .= '<INPUT type="hidden" name="rename" value="1">';
		$output .= '</TABLE><br><INPUT type="submit" value="'.$txt['rename'].'" class="bosses"></FORM>';
	}

    return $output;
}

#####################################
# Copy a table
# $sql_ref = SQL link to the base
# $tbl = Current Table
#####################################

function copy_tbl($sql_ref, $tbl) {
    global $HTTP_POST_VARS, $colors, $font, $txt;

	$output 		= '';
	$copy 			= isset($HTTP_POST_VARS["copy"]) ? $HTTP_POST_VARS["copy"] : '';
    $copy_type 		= isset($HTTP_POST_VARS["copy_type"]) ? $HTTP_POST_VARS["copy_type"] : '';
    $copy_db_dest 	= isset($HTTP_POST_VARS["copy_db_dest"]) ? magic_quote_bypass($HTTP_POST_VARS["copy_db_dest"]) : '';
    $copy_tbl_dest 	= isset($HTTP_POST_VARS["copy_tbl_dest"]) ? magic_quote_bypass($HTTP_POST_VARS["copy_tbl_dest"]) : '';

    $input_error = (eregi('"',$copy_tbl_dest) || !strlen($copy_tbl_dest) || eregi('[\]',$copy_tbl_dest) || eregi('<',$copy_tbl_dest) || eregi('>',$copy_tbl_dest));
        if ($input_error && $copy == 1) {
                $output = '<FONT color=#FF0000><B>'.$txt['invalid_dest'].'</B></FONT>';
                $copy = 0;
        }
        if ($copy == 1) {
			$start_timing = start_timing();
			if ($sql_ref->Infos['Version'] >= 32303) {
				$sql_ref->query("SHOW CREATE TABLE ".sql_back_ticks($tbl, $sql_ref));
		        list (,$result) = $sql_ref->next_record();
		    }
		    else {
		    	$result = show_create_table($tbl, $sql_ref);
		    }
            $result = str_replace("CREATE TABLE ".sql_back_ticks($tbl, $sql_ref), "CREATE TABLE ".sql_back_ticks($copy_db_dest, $sql_ref).".".sql_back_ticks($copy_tbl_dest, $sql_ref), $result);
            $sql_ref->query($result);

            ### Structure + data copy
            if ($copy_type == "data") {
                $sql = 'INSERT INTO '.sql_back_ticks($copy_db_dest, $sql_ref).'.'.sql_back_ticks($copy_tbl_dest, $sql_ref).' SELECT * FROM ' . sql_back_ticks($tbl, $sql_ref);
                $sql_ref->query($sql);
			}

            $output .= $txt['the_tbl'].' <B>'.$tbl .'</B> '.$txt['copy_successful'].'<BR>';
			$output .= print_timing($start_timing);
            $output .= return_2_table($sql_ref->Database, $tbl);
        }
        else {
           	$output .= '<TABLE border="0" bgcolor="'.$colors['table_bg'].'">';
            $output .= '<FORM action="main.php?db='.urlencode($sql_ref->Database).'&tbl='.urlencode($tbl).'&action=copy" method="post">';
            $output .= '<tr><td><font '.$font.'><B>'.$txt['dest'].' : </B></font>'.select_database($sql_ref,"copy_db_dest", $sql_ref->Database).'.<INPUT type="text" name="copy_tbl_dest" class="trous"></td></tr>';
            $output .= '<tr><td><INPUT type="radio" name="copy_type" value="struct" checked><font '.$font.'><B>'.$txt['structure'].'</B></font></td></tr>';
            $output .= '<tr><td><INPUT type="radio" name="copy_type" value="data"><font '.$font.'><B>'.$txt['data_struc'].'</B></font></td></tr>';
            $output .= '</TABLE>';
            $output .= '<INPUT type="hidden" name="copy" value="1">';
            $output .= '<INPUT type="submit"  value="'.$txt['copy_tbl'].'" class="bosses">';
            $output .= '</FORM>';
        }
        return $output;
}

#####################################
# Move a table
# $sql_ref = SQL link to the base
# $tbl = Current Table
#####################################

function move_tbl($sql_ref, $tbl) {
	global $HTTP_POST_VARS, $colors, $font, $txt;

	$output 		= '';
	$move 			= isset($HTTP_POST_VARS["move"]) ? $HTTP_POST_VARS["move"] : '';
    $move_db_dest 	= isset($HTTP_POST_VARS["move_db_dest"]) ? magic_quote_bypass($HTTP_POST_VARS["move_db_dest"]) : '';
	$move_tbl_dest 	= isset($HTTP_POST_VARS["move_tbl_dest"]) ? magic_quote_bypass($HTTP_POST_VARS["move_tbl_dest"]) : '';

	$input_error = (eregi('"',$move_tbl_dest) || !strlen($move_tbl_dest) || eregi('[\]',$move_tbl_dest) || eregi('<',$move_tbl_dest) || eregi('>',$move_tbl_dest));

    if ($input_error && $move == 1) {
		$output = '<FONT color=#FF0000><B>'.$txt['invalid_dest'].'</B></FONT>';
        $move = 0;
	}

    ### Form has benn submitted, acting
    if ($move == 1) {
		$start_timing = start_timing();
	    if ($sql_ref->Infos['Version'] >= 32303) {
		    $sql_ref->query("SHOW CREATE TABLE ".sql_back_ticks($tbl, $sql_ref));
		    list (,$result) = $sql_ref->next_record();
		}
		else {
			$result = show_create_table($tbl, $sql_ref);
		}
	    $result = str_replace("CREATE TABLE ".sql_back_ticks($tbl, $sql_ref), "CREATE TABLE ".sql_back_ticks($move_db_dest, $sql_ref).".".sql_back_ticks($move_tbl_dest, $sql_ref), $result);
	    $sql_ref->query($result);
	    $sql = 'INSERT INTO '.sql_back_ticks($move_db_dest, $sql_ref).'.'.sql_back_ticks($move_tbl_dest, $sql_ref).' SELECT * FROM ' . sql_back_ticks($tbl, $sql_ref)  ;

	    $sql_ref->query($sql);

	    ### Dropping the table
	    $sql = 'DROP TABLE '.sql_back_ticks($tbl, $sql_ref);
		$sql_ref->query($sql);

        $output .= $txt['the_tbl'].' <B>'.$tbl.'</B> '.$txt['move_successful'].'<BR>';
        $output .= print_timing($start_timing);
        $output .= return_2_db($sql_ref->Database);
	}
    ### Form hasn't benn submitted, showing it
    else {
    	$output .= '<TABLE border=0 bgcolor="'.$colors['table_bg'].'">';
        $output .= '<FORM action="main.php?db='.urlencode($sql_ref->Database).'&tbl='.urlencode($tbl).'&action=move" method="post">';
        $output .= '<TR>';
        $output .= '	<TD><font '.$font.'><B>'.$txt['dest'].' : </b></font></TD>';
        $output .= '	<TD>'.select_Database($sql_ref,"move_db_dest", $sql_ref->Database).'.<INPUT type="text" name="move_tbl_dest" class="trous"></TD>';
        $output .= '</TR>';
        $output .= '</TABLE>';
        $output .= '<INPUT type="hidden" name="move" value="1">';
        $output .= '<div align="right"><INPUT type="submit" value="'.$txt['move'].'" class="bosses"></div>';
        $output .= '</FORM>';
	}
	return $output;
}

#####################################
# Order a table
# $sql_ref = SQL link to the base
# $tbl = Current Table
#####################################

function order_tbl($sql_ref, $tbl) {
	global $HTTP_POST_VARS, $colors, $font, $txt;

	$order 			= isset($HTTP_POST_VARS['order']) ? $HTTP_POST_VARS['order'] : '';
	$order_field	= isset($HTTP_POST_VARS['order_field']) ? $HTTP_POST_VARS['order_field'] : '';


	if ($order == 1) {
		$sql_query = 'ALTER TABLE '.sql_back_ticks($tbl, $sql_ref).' ORDER BY '.sql_back_ticks($order_field, $sql_ref);
		$sql_ref->query($sql_query);

		$output  = display_bookmarkable_query($sql_query);
		$output .= return_2_table($sql_ref->Database,$tbl);
	}
	else {
		$sql_ref->query("SHOW FIELDS FROM ".sql_back_ticks($tbl, $sql_ref));
		$output  = '<FORM action="main.php?db='.urlencode($sql_ref->Database).'&tbl='.urlencode($tbl).'&action=order" method="post">';
		$output .= '<B>'.$txt['order_tbl_by']. '&nbsp;:&nbsp;</B>';
		$output .= '<SELECT name="order_field" class="trous">';
		while (list($field_name) = $sql_ref->next_record(MYSQL_NUM)) {
			$output .= '<OPTION value="'.$field_name.'">'.$field_name.'</OPTION>';
		}
		$output .= '</SELECT>';
		$output .= '<BR><BR><INPUT type="submit" value="'.$txt['ok'].'" class="bosses">';
		$output .= '<INPUT type="hidden" name="order" value="1">';
		$output .= '</FORM>';
	}

	return $output;
}


#####################################
# Split the data type
# returned by MySQL
# into an array :
# 0->type, 1->length, 2->attributes
# $type = MySQL type
#####################################

function split_type($type) {

	if ( ereg('\(', $type) ) {
		if ( ereg(' ',$type) ) {
			$tmpvar = explode(" ",$type);
			$mytab[2] = $tmpvar[1];
			if (isset($tmpvar[2])) {
				$mytab[2] .= ' '.$tmpvar[2];
			}
		}
		$fparenthesis = strpos($type,"(");
		$lparenthesis = strpos($type,")",$fparenthesis);

		$mytab[0] = substr($type,0,$fparenthesis);
		$mytab[1] = substr($type,$fparenthesis+1, $lparenthesis - $fparenthesis-1);
		$mytab[2] = (isset($mytab[2])) ? $mytab[2] : '';
	}
	elseif ( ereg(' ',$type) ) {

		$tmpvar = explode(" ",$type);
		$mytab[0] = '';
		$mytab[1] = '';
		$mytab[2] = $tmpvar[1];
	}
	else {
		$mytab[0] = $type;
		$mytab[1] = '';
		$mytab[2] = '';
	}

	return $mytab;
}

#####################################
# Modify the structure of a table
# $sql_ref = SQL link to the base
# $tbl = Current Table
#####################################

function modif_field($sql_ref, $tbl) {
   	Global $colors, $font, $data_types, $data_attributes, $txt;
   	Global $HTTP_POST_VARS;

    $modify = isset($HTTP_POST_VARS['modify']) ? $HTTP_POST_VARS['modify'] : '';
    $output 				= '';
    $input_error 			= 0;
    $primary_key_defined 	= 0;
    $primary_key_name		= array();

    ### Getting the keys definition
    $sql_ref->query("SHOW KEYS FROM ".sql_back_ticks($tbl, $sql_ref));
    while (list(,$non_unique,$key_name,,$column_name) = $sql_ref->next_record()) {
    		$keys[$column_name]['non_unique'] = isset($keys[$column_name]['non_unique']) ? $keys[$column_name]['non_unique'] : '';

    		if ($key_name == 'PRIMARY') {
	    		$keys[$column_name]['primary'] 	= 1;
	    		### Flaggin that there's a primary key in that table
	    		$primary_key_defined 			= 1;
	    		$primary_key_name[]				= $column_name;
	    	}

	    	if ($non_unique == 0 && ($keys[$column_name]['non_unique'] == 0 || $keys[$column_name]['non_unique'] == '')	) {
				$keys[$column_name]['non_unique'] = $non_unique;
	    	}
	    	$keys[$column_name]['key_name'] = $key_name;


    }


    ### Gathering diff infos and checking the inputs
    if ($modify == 1)	{
    	$nb_fields = isset($HTTP_POST_VARS["nb_fields"]) ? $HTTP_POST_VARS["nb_fields"] : '';
    	for ($i = 0; $i < $nb_fields; $i++) {
    		$name = isset($HTTP_POST_VARS["field_name_$i"]) ? $HTTP_POST_VARS["field_name_$i"] : '';
			$input_error = $input_error || (eregi('"',$name) || eregi('[\]',$name) || eregi('<',$name) || eregi('>',$name));
			$to_modify = $nb_fields;
		}
	}

    ### The has been posted, building and executing the query
 	if ($modify == 1 && !$input_error) {
 		$nb_fields 	 	 = isset($HTTP_POST_VARS["nb_fields"]) ? $HTTP_POST_VARS["nb_fields"] : '';
 		$sql 		 	 = "ALTER TABLE ".sql_back_ticks($sql_ref->Database, $sql_ref).".".sql_back_ticks($tbl, $sql_ref);
 		$add_unique  	 = array();
 		$add_index 	 	 = array();
 		$add_primary	 = array();
 		$add_fulltext	 = array();
 		$sql_add_unique  = '';
 		$sql_add_primary = '';
 		$sql_add_index 	 = '';
 		$sql_add_fulltext 	 = '';

 		for ($i = 0; $i < $nb_fields; $i++) {
 			$old_field_name 	= isset($HTTP_POST_VARS["old_field_name_$i"]) ? magic_quote_bypass($HTTP_POST_VARS["old_field_name_$i"]) : '';
 			$field_name 		= isset($HTTP_POST_VARS["field_name_$i"]) ? magic_quote_bypass($HTTP_POST_VARS["field_name_$i"]) : '';
 			$field_type 		= isset($HTTP_POST_VARS["field_type_$i"]) ? $data_types[$HTTP_POST_VARS["field_type_$i"]] : '';
 			$field_length 		= ($HTTP_POST_VARS["field_length_$i"] == '') ? '' : '('.magic_quote_bypass($HTTP_POST_VARS["field_length_$i"]).')';
 			$field_attribute 	= $data_attributes[$HTTP_POST_VARS["field_attribute_$i"]];
 			$field_null 		= ($HTTP_POST_VARS["field_null_$i"] == 'yes') ? '' : 'NOT NULL';
 			$field_default 		= ($HTTP_POST_VARS["field_default_$i"] == '') ? '' : 'DEFAULT \''.addslashes(magic_quote_bypass($HTTP_POST_VARS["field_default_$i"])).'\'';
 			$field_increment 	= ($HTTP_POST_VARS["field_increment_$i"] == 'yes') ? 'AUTO_INCREMENT' : '';
 			$field_unique 		= isset($HTTP_POST_VARS["field_unique_$i"]) ? 1 : 0;
 			$field_index 		= isset($HTTP_POST_VARS["field_index_$i"]) ? 1 : 0;
 			$field_primary 		= isset($HTTP_POST_VARS["field_primary_$i"]) ? 1 : 0;
 			$field_fulltext		= isset($HTTP_POST_VARS["field_fulltext_$i"]) ? 1 : 0;


 			$sql .= " CHANGE ".sql_back_ticks($old_field_name, $sql_ref)." ".sql_back_ticks($field_name, $sql_ref)." $field_type $field_length $field_attribute $field_default $field_null $field_increment";
 			if ( ($i + 1) < $nb_fields) {
 				$sql .= ",\n";
 			}

 			### Getting the diff check between old and new keys
 			if ($field_unique) {
 					$add_unique[] = $field_name;
 			}

 			if ($field_index) {
 					$add_index[] = $field_name;

 			}

 			if ($field_primary) {
 					$add_primary[] = $field_name;
 			}

 			if ($field_fulltext) {
 					$add_fulltext[] = $field_name;
 			}

 		}
 		### Building the add key sql part
 		### Unique keys
 		for ($i = 0; $i < count($add_unique); $i++) {
 			$sql_add_unique .= ' ADD UNIQUE ('.sql_back_ticks($add_unique[$i], $sql_ref)."),\n";
 		}

 		### Index keys

 		for ($i = 0; $i < count($add_index); $i++) {
 			$sql_add_index .= ' ADD INDEX ('.sql_back_ticks($add_index[$i], $sql_ref)."),\n";
 		}

 		### Primary keys
 		for ($i = 0; $i < count($add_primary); $i++) {
 			$sql_primary_keys = '';
 			if ($i == 0 && $primary_key_defined == 1) {
 				$sql_add_primary .= ' DROP PRIMARY KEY, ';

 				for ($j = 0; $j < count($primary_key_name); $j++) {
 					$sql_primary_keys .= sql_back_ticks($primary_key_name[$j], $sql_ref).', ';
 				}

 			}
 			$sql_add_primary .= ' ADD PRIMARY KEY('.$sql_primary_keys.sql_back_ticks($add_primary[$i], $sql_ref)."),\n";
 		}

 		### Full text keys

 		for ($i = 0; $i < count($add_fulltext); $i++) {
 			$sql_add_fulltext .= " ADD FULLTEXT(".sql_back_ticks($add_fulltext[$i], $sql_ref)."),\n";
 		}


 		$total_sql = $sql.",\n".$sql_add_unique.$sql_add_index.$sql_add_primary.$sql_add_fulltext;
 		$total_sql = substr($total_sql, 0, strlen($total_sql) - 2);


 		$sql_ref->query($total_sql);

 		$output .= display_bookmarkable_query($total_sql);
 		$output .= '<BR><BR>'.$txt['modif_done'];
 		$output .= '<BR>'.return_2_table($sql_ref->Database,$tbl);

 	}
 	### The form hasn't been posted -> showing the HTML table
 	else {
        if ($input_error) {
			$output .= '<FONT color="#FF0000"><B>'.$txt['input_invalid'].'</B></FONT>';
		}
		else {
        	$to_modify = isset($HTTP_POST_VARS['field_check']) ? $HTTP_POST_VARS['field_check'] : array();

	        ### No fields specified, going back
	        if (count($to_modify) == 0) {
	        	return $txt['choose_field'].'.'.return_2_table($sql_ref->Database, $tbl);
	        }
	    }
		$sql_ref->query("SHOW KEYS FROM ".sql_back_ticks($tbl, $sql_ref));

		while ($tmp_value = $sql_ref->next_record()) {
			if (isset($tmp_value['Comment']) && $tmp_value['Comment'] == 'FULLTEXT') {
				$full_text_keys[$tmp_value['Column_name']] = 1;
			}
			else {
				$full_text_keys[$tmp_value['Column_name']] = 0;
			}
		}
        $sql_ref->query("SHOW FIELDS FROM ".sql_back_ticks($tbl, $sql_ref));
        $i 		= 0;
        $valide = 0;
        $output .= '<table border="1" bgcolor="'.$colors['table_bg'].'" bordercolor="'.$colors['titre_bg'].'" cellspacing=0 cellpadding=5 width=100%>';
		$output .= '<FORM action="main.php?db='.urlencode($sql_ref->Database).'&tbl='.urlencode($tbl).'&action=modif_field" method="POST">';

         while (list($field,$type,$null_not_allowed,$key,$default,$extra) = $sql_ref->next_record()) {

        	if (isset($to_modify[$i])) {
        			$check_primary 		= '';
        			$check_unique 		= '';
        			$check_index 		= '';
        			$check_fulltext		= '';
        			$old_unique			= 0;
        			$old_index			= 0;
        			$old_primary 		= 0;
        			$old_fulltext		= 0;
        			$key_check_unique 	= isset($keys[$field]['non_unique']) ? $keys[$field]['non_unique'] : '';
        			$key_check_index	= isset($keys[$field]['key_name']) ? $keys[$field]['key_name'] : '';
        			$key_check_primary	= isset($keys[$field]['primary']) ? $keys[$field]['primary'] : '';
        			$key_check_fulltext = (isset($full_text_keys[$field]) && $full_text_keys[$field] == 1) ? 1 : 0;

        			### Add ' ' around the 0 to avoid null && 0 confusion
        			if ($key_check_unique == '0') {
        				$check_unique = 'CHECKED DISABLED';
        			}
        			if ($key_check_index == $field) {
        				$check_index = 'CHECKED DISABLED';
        			}
        			if ($key_check_primary == 1) {
        				$check_primary = 'CHECKED DISABLED';
        			}

        			if ($key_check_fulltext == 1) {
        				$check_fulltext = 'CHECKED DISABLED';
        			}

        			$type = split_type($type);
        			$field_type = strtoupper($type[0]);
        			$field_length = $type[1];

        			if ($field_type == 'ENUM' || $field_type == 'SET') {
        				$field_length_title = 'Valeurs';
					}
					else {
						$field_length_title = 'Longueur';
					}

        			$output .= '<tr>
									<td><font '.$font.'><B>'.$txt['key'].'</B></font></td>
									<td><font '.$font.'><B>'.$txt['field_name'].'</b></font></td>
									<td><font '.$font.'><B>'.$txt['type'].'</b></font></td>
									<td><font '.$font.'><B>'.$txt['can_be_null'].'</b></font></td>
									<td><font '.$font.'><B>'.$field_length_title.'</b></font></td>
								</tr>';



        			$field_attribute 	= strtoupper($type[2]);
        			$null_allowed 		= ($null_not_allowed == 'YES') ? 'SELECTED' : '';
        			$null_not_allowed 	= ($null_not_allowed == '') ? 'SELECTED' : '';
        			$auto_increment 	= ($extra == 'auto_increment') ? 'SELECTED' : '';
        			$not_auto_increment = ($extra == '') ? 'SELECTED' : '';

        			### Showing hte fulltext option if available
        			if ($sql_ref->Infos['Version'] >= 32333 ) {
        				$check_box_fulltext = '<BR><input '.$check_fulltext.' type="checkbox" name="field_fulltext_'.$valide.'" value=1 class="pick"><font '.$font.'> '.$txt['fulltext'].'</font>';
        			}
        			else {
        				$check_box_fulltext = '';
        			}
        			$output .= '<tr>
        							<td nowrap rowspan="3" valign="top">
                                    	<input '.$check_primary.' type="checkbox" name="field_primary_'.$valide.'" value=1 class="pick"><font '.$font.'> '.$txt['primary'].'</font>
							        	<BR><input '.$check_index.' type="checkbox" name="field_index_'.$valide.'" value=1 class="pick"><font '.$font.'> '.$txt['index'].'</font>
										<BR><input '.$check_unique.' type="checkbox" name="field_unique_'.$valide.'" value=1 class="pick"><font '.$font.'> '.$txt['unique'].'</font>
										'.$check_box_fulltext.'
                            		</td>
									<td>
										<input type="text" name="field_name_'.$valide.'" class="trous" value="'.$field.'">
										<input type="hidden" name="old_field_name_'.$valide.'" value="'.$field.'">
									</td>
									<td>'.select_type("field_type_$valide",$field_type).'</td>
									<td><select name="field_null_'.$valide.'" class="trous">
										<option value="yes" '.$null_allowed.'>'.$txt['Yes'].'</option>
										<option value="no"'.$null_not_allowed.'>'.$txt['No'].'</option>
										</select>
									</td>
									<td><input type="text" name="field_length_'.$valide.'" size=5 class="trous" value="'.$field_length.'"></td>
								</tr>
								<tr>
									<td><font '.$font.'><B>'.$txt['attribs'].'</b></font></td>
									<td><font '.$font.'><B>'.$txt['default_value'].'</b></font></td>
									<td colspan="2"><font '.$font.'><B>'.$txt['auto_incr'].'</b></font></td>
								</tr>
								<tr>
									<td>'.select_attribute("field_attribute_$valide", $field_attribute).'</td>
									<td><input type=text name="field_default_'.$valide.'" class="trous" value="'.htmlentities($default).'"></td>
									<td colspan="2">
										<select name="field_increment_'.$valide.'" class="trous">
										<option value="yes" '.$auto_increment.'>'.$txt['Yes'].'</option>
										<option value="no" '.$not_auto_increment.'>'.$txt['No'].'</option>
										</select>
									</td>
								</tr>';


        			$valide++;
        	}
        	$i++;
        }

        if ($valide == 0) {

        	return $txt['choose_field'].'.'.return_2_table($sql_ref->Database, $tbl);
        }
        else {
        	$output .= '</table>';
        	$output .= '<input type=hidden name="nb_fields" value="'.$valide.'">';
        	$output .= '<input type=hidden name="modify" value="1">';
        	$output .= '<BR><input type=submit value="'.$txt['execute'].'" class="bosses">';
        	$output .= '</FORM>';
        	$output .= '<BR><BR><img src="'.$colors['img_path'].'img/tips_off.gif" width="20" height="20" align="center">&nbsp;<A href="javascript:help(\'data_types\');">'.$txt['help_data_types'].'</A>';
        }

    }
       return $output;

}

#####################################
# Destroy a table field
# $sql_ref = SQL link to the base
# $tbl = Current Table
#####################################

function drop_field($sql_ref, $tbl) {
	global $HTTP_POST_VARS, $colors, $font, $txt;


	### $to_modify = array containing the field's id to be dropped
	$to_modify  = isset($HTTP_POST_VARS['field_check']) ? $HTTP_POST_VARS['field_check'] : '';
	$drop_field = isset($HTTP_POST_VARS['drop_field']) ? $HTTP_POST_VARS['drop_field'] : '';
	$field_list = isset($HTTP_POST_VARS['field_list']) ? $HTTP_POST_VARS['field_list'] : '';
	$output 	= '';
	$hidden_list= '';
	if ($drop_field == 1) {
		$sql = 'ALTER TABLE '.sql_back_ticks($tbl, $sql_ref).' ';
		for ($i = 0; $i < count($field_list); $i++) {
			$sql .= 'DROP '.sql_back_ticks(magic_quote_bypass($field_list[$i]), $sql_ref).'';
			if ( ($i +1) < count($field_list) ) {
					$sql .= ', ';
			}
		}
		$sql_ref->query($sql);

		$output .= display_bookmarkable_query($sql);
		$output .= '<BR><BR>'.$txt['modif_done'].'.';
        $output .= '<BR>'.return_2_table($sql_ref->Database,$tbl);

	}
	else {

	    $sql_ref->query('SHOW FIELDS FROM '.sql_back_ticks($tbl, $sql_ref));
	    $i = 0;
	    $valide = 0;

	    while (list($field) = $sql_ref->next_record()) {
	    	if (isset($to_modify[$i])) {
	    		$field = htmlentities(magic_quote_bypass($field));
	    		$field_list .= ' '.$field.',';
	    		$hidden_list .= '<input type=hidden name="field_list[]" value="'.$field.'">';
	    		$valide++;
	    	}
	    	$i++;
	    }
	    if ($valide != 0) {
		    $field_list = substr($field_list,0,strlen($field_list) - 1);
		    $output = '<BR><BR><B>'.$txt['confirm_delete'].' <font color=#FF0000>'.$field_list.' </font>?</B>';
			$output .= '<form action="main.php?db='.urlencode($sql_ref->Database).'&tbl='.urlencode($tbl).'&action=drop_field" method="post">';
			$output .= '<input type=hidden name=drop_field value=1>';
			$output .= '<input type=submit value="'.$txt['Yes'].'" class="bosses"> <input type=button value="'.$txt['No'].'" onClick="javascript:history.go(-1);" class="bosses">';
			$output .= $hidden_list;
			$output .= '</FORM>';
		}
		else {
			$output .= $txt['choose_field'].'.'.return_2_table($sql_ref->Database, $tbl);
		}
	}

	return $output;
}

#####################################
# Add a field to a table
# $sql_ref = SQL link to the base
# $tbl = Current Table
#####################################

function add_field($sql_ref, $tbl) {
	global $colors, $font, $HTTP_POST_VARS, $data_attributes, $data_types, $txt;

	$add_field 		= isset($HTTP_POST_VARS['add_field']) ? $HTTP_POST_VARS['add_field'] : '';
	$enter_fields 	= isset($HTTP_POST_VARS['enter_fields'])  ?$HTTP_POST_VARS['enter_fields'] : '';
	$nb_fields 		= isset($HTTP_POST_VARS['nb_fields']) ? $HTTP_POST_VARS['nb_fields'] : '';
	$field_pos 		= isset($HTTP_POST_VARS['field_pos']) ? $HTTP_POST_VARS['field_pos'] : '';
	$field_list		= '';
	$input_error	= 0;
	$output			= '';
	$arrPrimary 	= array();
	$arrIndex		= array();
	$arrUnique		= array();
	$arrFulltext	= array();

	if ($enter_fields == 1 && $nb_fields == "") {
		$enter_fields = 0;
	}
	if ($add_field == 1) {
		for ($i = 0; $i < $nb_fields; $i++) {
			$name = magic_quote_bypass($HTTP_POST_VARS["field_name_$i"]);
			$input_error = $input_error || (eregi('"',$name) || !strlen($name) || eregi('[\]',$name) || eregi('<',$name) || eregi('>',$name));
		}
	}

	if ($add_field == 1 && !$input_error) {
		$sql_query = 'ALTER TABLE '.sql_back_ticks($tbl, $sql_ref).' ';
        for ($i = 0; $i < $nb_fields; $i++) {
			### getting differents fields
			$name 			= isset($HTTP_POST_VARS["field_name_$i"]) ? magic_quote_bypass($HTTP_POST_VARS["field_name_$i"]) : '';
			$type 			= isset($HTTP_POST_VARS["field_type_$i"]) ? $data_types[ $HTTP_POST_VARS["field_type_$i"] ] : '';
			$length 		= isset($HTTP_POST_VARS["field_length_$i"]) ? $HTTP_POST_VARS["field_length_$i"] : '';
			$attributes 	= isset($HTTP_POST_VARS["field_attribute_$i"]) ? $data_attributes[ $HTTP_POST_VARS["field_attribute_$i"] ] : '';
			$null_allowed 	= isset($HTTP_POST_VARS["field_null_$i"]) ? $HTTP_POST_VARS["field_null_$i"] : '';
			$default_value 	= isset($HTTP_POST_VARS["field_default_$i"]) ? $HTTP_POST_VARS["field_default_$i"] : '';
			$increment 		= isset($HTTP_POST_VARS["field_increment_$i"]) ? $HTTP_POST_VARS["field_increment_$i"] : '';
			$primary 		= isset($HTTP_POST_VARS["field_primary_$i"]) ? $HTTP_POST_VARS["field_primary_$i"] : '';
			$index 			= isset($HTTP_POST_VARS["field_index_$i"]) ? $HTTP_POST_VARS["field_index_$i"] : '';
			$unique 		= isset($HTTP_POST_VARS["field_unique_$i"]) ? $HTTP_POST_VARS["field_unique_$i"] : '';
			$fulltext 		= isset($HTTP_POST_VARS["field_fulltext_$i"]) ? $HTTP_POST_VARS["field_fulltext_$i"] : '';
			$length 		= ($length != '') ? '('.$length.')' : '';
			$null_allowed 	= ($null_allowed == 'no') ? 'NOT NULL' : '';
			$default_value 	= addslashes(magic_quote_bypass($default_value));
			$default_value 	= ($default_value != '') ? 'DEFAULT \''.$default_value.'\'' : '';
			$increment 		= ($increment == 'yes') ? 'AUTO_INCREMENT' : '';

			$primary_query 	= '';
			$index_query	= '';
			$unique_query	= '';
			$fulltext_query	= '';


			$sql_query .= "ADD ".sql_back_ticks($name, $sql_ref)." $type $length $attributes $default_value $null_allowed $increment";
                        if ($field_pos == 'first pos') {
                                $sql_query .= ' FIRST';
                                $field_pos = $name;
                        }
                        elseif ($field_pos != 'end pos') {
                                $sql_query .= 'AFTER '.sql_back_ticks($field_pos, $sql_ref).' ';
                                $field_pos = $name;
                        }

                        if ( ($i + 1) < $nb_fields) {
				$sql_query .= ', ';
			}
			### Building 3 arrays for the primary, index && unique keys

			if ($primary != '') {
				$arrPrimary[] = $name;
			}
			if ($index != '') {
				$arrIndex[] = $name;
			}
			if ($unique != '') {
				$arrUnique[] = $name;
			}
			if ($fulltext != '') {
				$arrFulltext[] = $name;
			}

		}

		### Building the Primary Key SQL part
		$nb_arrPrimary = count($arrPrimary);
		for ($i = 0; $i < $nb_arrPrimary; $i++) {
			$primary_query .= sql_back_ticks($arrPrimary[$i], $sql_ref);
			if ( ($i + 1) < $nb_arrPrimary) {
				$primary_query .= ',';
			}
		}

		if ($primary_query != '') {
			$primary_query = 'ALTER TABLE '.sql_back_ticks($tbl, $sql_ref).' ADD PRIMARY KEY ('.$primary_query.')';
		}


		### Building the Index key SQL part
		$nb_arrIndex = count($arrIndex);
		for ($i = 0; $i < $nb_arrIndex; $i++) {
			$index_query .= sql_back_ticks($arrIndex[$i], $sql_ref);
			if ( ($i + 1) < $nb_arrIndex) {
				$index_query .= ',';
			}
		}

		if ($index_query != '') {
			$index_query = 'ALTER TABLE '.sql_back_ticks($tbl, $sql_ref).' ADD INDEX ('.$index_query.')';
		}


		### Building the Unique key SQL part
		$nb_arrUnique = count($arrUnique);
		for ($i = 0; $i < $nb_arrUnique; $i++) {
			$unique_query .= sql_back_ticks($arrUnique[$i], $sql_ref);
			if ( ($i + 1) < $nb_arrUnique) {
				$unique_query .= ',';
			}
		}

		if ($unique_query != '') {
			$unique_query = 'ALTER TABLE '.sql_back_ticks($tbl, $sql_ref).' ADD UNIQUE ('.$unique_query.')';
		}

		### Building the FULLTEXT key SQL part
		$nb_arrFulltext = count($arrFulltext);
		for ($i = 0; $i < $nb_arrFulltext; $i++) {
			$fulltext_query .= sql_back_ticks($arrFulltext[$i], $sql_ref);
			if ( ($i + 1) < $nb_arrFulltext) {
				$fulltext_query .= ',';
			}
		}

		if ($fulltext_query != '') {
			$fulltext_query = 'ALTER TABLE '.sql_back_ticks($tbl, $sql_ref).' ADD FULLTEXT ('.$fulltext_query.')';
		}



		$sql_ref->query($sql_query);
		if ($primary_query != '') {
        	$sql_ref->query($primary_query);
		}
		if ($index_query != '') {
        	$sql_ref->query($index_query);
        }
        if ($unique_query != '') {
        	$sql_ref->query($unique_query);
		}
		if ($fulltext_query != '') {
        	$sql_ref->query($fulltext_query);
		}


		$output .= display_bookmarkable_query($sql_query);

        if ($primary_query != '') {
        	$output .= '<BR>'.$primary_query;
        }
        if ($unique_query != '') {
        	$output .= '<BR>'.$unique_query;
        }
        if ($index_query != '') {
        	$output .= '<BR>'.$index_query;
        }
        if ($fulltext_query != '') {
        	$output .= '<BR>'.$fulltext_query;
        }
        $output .= '<BR>'.return_2_table($sql_ref->Database,$tbl);
	}
	elseif ($enter_fields == 1) {
		if ($input_error && $add_field == 1) {
            $output .= '<FONT color="#FF0000"><B>'.$txt['input_invalid'].'</B></FONT><BR><BR>';
        }
		$output .= '<table border=1 bordercolor="'.$colors['bordercolor'].'" bgcolor="'.$colors['table_bg'].'" cellpadding="5" cellspacing="0">';
		$output .= '<tr>';
		$output .= '	<td>';
		$output .= '<FORM action="main.php?db='.urlencode($sql_ref->Database).'&tbl='.urlencode($tbl).'&action=add_field" method="POST">';
		$output .= '		<table border="0" bgcolor="'.$colors['table_bg'].'" bordercolor="'.$colors['titre_bg'].'" cellspacing=0 cellpadding=5>';


		$current_mysql_version = get_mysql_version($sql_ref);
		for ($i = 0; $i < $nb_fields; $i++) {
			$output .= '<tr>
						<td><b><font '.$font.'>'.$txt['key'].'</font></b></td>
						<td><b><font '.$font.'>'.$txt['field_name'].'</font></b></td>
						<td><b><font '.$font.'>'.$txt['type'].'</font></b></td>
						<td><b><font '.$font.'>'.$txt['can_be_null'].'</font></b></td>
						<td><b><font '.$font.'>'.$txt['length'].'</font></b></td>


					</tr>';



			if ($current_mysql_version >= 32323) {
				$output_fulltext = '<BR><input type="checkbox" name="field_fulltext_'.$i.'" value=1 class="pick"><font '.$font.'> '.$txt['fulltext'].'</font>';
			}
			else {
				$output_fulltext = '';
			}

			$output .= '<tr>
							<td nowrap rowspan="3">
								<input type="checkbox" name="field_primary_'.$i.'" value=1 class="pick"><font '.$font.'>'.$txt['primary'].'</font>
							    <br><input type="checkbox" name="field_index_'.$i.'" value=1 class="pick"><font '.$font.'>'.$txt['index'].'</font>
							    <br><input type="checkbox" name="field_unique_'.$i.'" value=1 class="pick"><font '.$font.'>'.$txt['unique'].'</font>
							    '.$output_fulltext.'
							</td>
							<td><input type="text" name="field_name_'.$i.'" class="trous"></td>
							<td>'.select_type("field_type_$i").'</td>


							<td><select name="field_null_'.$i.'" class="trous">
									<option value="yes">'.$txt['Yes'].'</option>
									<option value="no">'.$txt['No'].'</option>
								</select>
							</td>
							<td><input type="text" name="field_length_'.$i.'" size=5 class="trous"></td>


						</tr>';
			$output .= '<tr>
							<td><b><font '.$font.'>'.$txt['attribs'].'</font></b></td>
							<td><b><font '.$font.'>'.$txt['default_value'].'</font></b></td>
							<td colspan="2"><b><font '.$font.'>'.$txt['auto_incr'].'</font></b></td>
						</tr>';
			$output .= '<tr>
							<td>'.select_attribute("field_attribute_$i").'</td>
							<td><input type=text name="field_default_'.$i.'" class="trous"></td>
							<td colspan="2"><select name="field_increment_'.$i.'" class="trous">
									<option value="yes">'.$txt['Yes'].'</option>
									<option value="no" selected>'.$txt['No'].'</option>
								</select>
							</td>
						</tr>';
			### Outputting a separator
			if ($i+1 < $nb_fields) {
				$output .= '<tr>
								<td colspan="5">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
								    <td bgcolor="'.$colors['titre_bg'].'"><img src="img/vide.gif"></td>
								  </tr>
								</table>
								</td>
							</tr>';
			}
		}
		$output .= '		</table>';
		$output .= '	</td>';
		$output .= '</tr>';
		$output .= '</table>';
		$output .= '<input type="hidden" name="nb_fields" value="'.$nb_fields.'">';
		$output .= '<input type="hidden" name="add_field" value="1">';
		$output .= '<input type="hidden" name="field_pos" value="'.$field_pos.'">';
		$output .= '<input type="hidden" name="enter_fields" value="1">';
		$output .= '<BR>';
		$output .= '<input type=submit value="'.$txt['add'].'" class="bosses">';
		$output .= '</form>';
	    $img_path = $colors['img_path'];
	    $output .= '<BR><BR><img src="'.$img_path.'img/tips_off.gif" width="20" height="20" border="0" name="tip" align="center">&nbsp;<A href="javascript:help(\'data_types\');">'.$txt['help_data_types'].'</A>';

	}
	else {
		$sql_ref->query('SHOW FIELDS FROM '.sql_back_ticks($tbl, $sql_ref));
		while ( list($field) = $sql_ref->next_record() ) {
			$field_list .= '<OPTION value="'.$field.'">'.$txt['after'].' '.$field.'</OPTION>';
		}
		$output  = '<table border="1" bgcolor="'.$colors['table_bg'].'" bordercolor="'.$colors['titre_bg'].'" cellspacing=0 cellpadding=5>';
		$output .= '<FORM action="main.php?db='.urlencode($sql_ref->Database).'&tbl='.urlencode($tbl).'&action=add_field" method="POST">';
		$output .= '<tr>';
        $output .= '    <td><font '.$font.'><B>'.$txt['nb_fields'].' : </B></font></td>';
        $output .= '    <td><INPUT type="text" name="nb_fields" class="trous" size="3"></td>';
        $output .= '</tr>';
		$output .= '<tr>';
        $output .= '    <td><font '.$font.'><B>'.$txt['position'].' : </B></font></td>';
        $output .='     <td><SELECT name="field_pos" class="trous">
		                    <OPTION value="first pos">'.$txt['tbl_begin'].'</OPTION>
							<OPTION value="end pos">'.$txt['tbl_end'].'</OPTION>
							'.$field_list.'
							</SELECT>
                        </td>';
        $output .= '</tr>';

		$output .= '</table>';
		$output .= '<INPUT type="hidden" name="enter_fields" value="1">';
		$output .= '<BR><INPUT type="submit" value="'.$txt['execute'].'" class="bosses">';
		$output .= '</form>';

	}
	return $output;
}

#####################################
# Alter a table to drop a key
# $sql_ref = SQL link to the base
# $tbl = Current Table
#####################################
function drop_key($sql_ref,$tbl) {
	global $HTTP_POST_VARS, $colors, $font, $txt;

	$confirm_drop_key = isset($HTTP_POST_VARS['confirm_drop_key']) ? $HTTP_POST_VARS['confirm_drop_key'] : '';
	$output			  = '';

	if ($confirm_drop_key == 1) {
			if ($HTTP_POST_VARS['key'] == 'PRIMARY') {
				$sql_query = 'ALTER TABLE '.sql_back_ticks($tbl, $sql_ref).' DROP PRIMARY KEY';
			}
			else {
				$sql_query = 'ALTER TABLE '.sql_back_ticks($tbl, $sql_ref).' DROP INDEX '.sql_back_ticks($HTTP_POST_VARS['key'], $sql_ref);
			}
			$sql_ref->query($sql_query);

			$output .= display_bookmarkable_query($sql_query);
			$output .= '<BR><BR>'.$txt['the_key'].' '.$HTTP_POST_VARS['key'].' '.$txt['been_deleted'].'.';
			$output .= return_2_table($sql_ref->Database,$tbl);
	}
	else {
		$output = $txt['confirm_key'].' :<BR><B>'.$HTTP_POST_VARS['key'].'</B> ?';
		$output .= '<form action="main.php?db='.urlencode($sql_ref->Database).'&tbl='.urlencode($tbl).'&action=drop_key" method="post">';
		$output .= '<input type=submit value="'.$txt['Yes'].'" class="bosses">&nbsp;<input type=button value="'.$txt['No'].'" onClick="javascript:history.go(-1);" class="bosses">';
		$output .= '<input type="hidden" name="key" value="'.$HTTP_POST_VARS['key'].'">';
		$output .= '<input type=hidden name="confirm_drop_key" value="1">';
		$output .= '</form>';
	}

	return $output;
}

#####################################
# Alter a table to change the type
# $sql_ref = SQL link to the base
# $tbl = Current Table
#####################################
function change_tbl_type($sql_ref,$tbl) {
	global $HTTP_POST_VARS, $colors, $font, $txt;

	$change_type 	= isset($HTTP_POST_VARS['change_type']) ? $HTTP_POST_VARS['change_type'] : '';
	$new_tbl_type 	= isset($HTTP_POST_VARS['new_tbl_type']) ? $HTTP_POST_VARS['new_tbl_type'] : '';
	$output			= '';

	if ($change_type == 1) {
		$sql_ref->query("ALTER TABLE ".sql_back_ticks($tbl, $sql_ref)." TYPE=$new_tbl_type");
		$sql = 'ALTER TABLE '.sql_back_ticks($tbl, $sql_ref).' TYPE='.$new_tbl_type;

		$output .= display_bookmarkable_query($sql);

		$output .= '<BR><BR>'.$txt['query_done'].'.';
                $output .= '<BR>'.$txt['the_tbl'].' "'.$tbl.'" '.$txt['type_now'].' '.$new_tbl_type.'.';
                $output .= return_2_table($sql_ref->Database,$tbl);
	}
	else {
		$sql_ref->query("SHOW VARIABLES LIKE 'have_%'");
		while ($sql_result = $sql_ref->next_record()) {
               	switch ($sql_result['Variable_name']) {
                    case 'have_isam':
                        if ($sql_result['Value'] == 'YES') {
                            $avl_type[] = 'isam';
                        }
                    break;
                    case 'have_innodb':
                        if ($sql_result['Value'] == 'YES') {
                            $avl_type[] = 'innodb';
                        }
                    break;
                    case 'have_bdb':
                        if ($sql_result['Value'] == 'YES') {
                            $avl_type[] = 'BerkeleyDB';
                        }
                    break;
                    case 'have_gemini':
                        if ($sql_result['Value'] == 'YES') {
                            $avl_type[] = 'gemini';
                        }
                        break;

                }
		}
		$avl_type[] = 'myisam';
		$avl_type[] = 'heap';
		$avl_type[] = 'mrg_myisam';
		$tbl_infos = $sql_ref->getTblsInfos();
        $tbl_type = $tbl_infos[$tbl]['Type'];

        $output = $txt['new_type'].' :<BR><BR>';
        $output .= '<FORM name="tbl_chg_type" method="post" action="main.php?db='.urlencode($sql_ref->Database).'&tbl='.urlencode($tbl).'&action=change_type">';
        $output .= '<SELECT name="new_tbl_type" class="trous">';
        for ($i = 0; $i < count($avl_type); $i++) {
        		if (strToLower($tbl_type) == $avl_type[$i]) {
        			$selected = 'SELECTED';
        		}
        		else {
        			$selected = '';
        		}
        		$output .= '<OPTION VALUE="'.$avl_type[$i].'" '.$selected.'>'.$avl_type[$i].'</OPTION>';

        }
        $output .= '</SELECT>';
        $output .= '<BR><BR><INPUT type="submit" value="'.$txt['change_type'].'" class="bosses">';
        $output .= '<INPUT type="hidden" name="change_type" value="1">';
        $output .= '</FORM>';
	}

return $output;
}

#####################################
# Alter a record
# $sql_ref = SQL link to the base
# $tbl = Current Table
#####################################
function modif_record($sql_ref, $tbl) {
    Global $HTTP_POST_VARS, $colors, $font, $txt;
    Global $HTTP_GET_VARS, $HTTP_COOKIE_VARS;
    Global $data_functions;


    $modif_record 	= isset($HTTP_POST_VARS['modif_record']) ? $HTTP_POST_VARS['modif_record'] : '';
    $query			= isset($HTTP_GET_VARS['query']) ? magic_quote_bypass($HTTP_GET_VARS['query']) : '';
    $nb_fields 		= isset($HTTP_POST_VARS['nb_fields']) ? $HTTP_POST_VARS['nb_fields'] : '';
    $sql_query		= '';


    ### The form has been posted, updating the table
    if ($modif_record == 1) {
    	$field_name  = '';
    	$field_value = '';
        for ($i = 0; $i <= $nb_fields; $i++) {
    		$field_name  	= magic_quote_bypass($HTTP_POST_VARS["field_name_$i"]);
			$HTTP_POST_VARS["field_value_$i"] = is_array($HTTP_POST_VARS["field_value_$i"]) ? implode(',', $HTTP_POST_VARS["field_value_$i"]) : $HTTP_POST_VARS["field_value_$i"];
			$field_value 	= isset($HTTP_POST_VARS["field_value_$i"]) ? magic_quote_bypass($HTTP_POST_VARS["field_value_$i"]) : '';
    		$field_function = isset($HTTP_POST_VARS["field_function_$i"]) ? $HTTP_POST_VARS["field_function_$i"] : '';
        	$field_is_null	= isset($HTTP_POST_VARS["null_value_$i"]) ? $HTTP_POST_VARS["null_value_$i"] : '';

        	$sql_query .= sql_back_ticks($field_name, $sql_ref);
        	$sql_query .= "=";

        	if ($field_is_null) {
        		$sql_query .= 'NULL';
        	}
        	else {
	        	if ($field_function == 0) {
	        		$sql_query .= "'";
	        	}
	        	else {
	        		$sql_query .= $data_functions[$field_function]."(";
	        		if ($field_value != '') {
	        			$sql_query .= "'";
	        		}
	        	}

	            if (is_array($HTTP_POST_VARS["field_value_$i"])) {

	                $value = '';

	                $tmp_value = isset($HTTP_POST_VARS["field_value_$i"]) ? $HTTP_POST_VARS["field_value_$i"] : '';

	                for ($j = 0; $j < count ($tmp_value); $j++) {
	                    $value .= addSlashes(magic_quote_bypass($tmp_value[$j])).',';
	                }
	                $value = substr($value,0,strlen($value) - 1);
	                $value .= '\'';
	                $sql_query .= $value;
	            }
	            else {
	                $sql_query .= addSlashes($field_value);
	            }

	            if ($field_function == 0) {
	        		$sql_query .= "'";
	        	}
	        	else {
	        		if ($field_value != '') {
	        			$sql_query .= "'";
	        		}
	        		$sql_query .= ')';

	        	}
	        }


        	if ($i+1 <= $nb_fields) {
        		$sql_query .= ', ';
        	}

        }
        $sql_query = "UPDATE ".sql_back_ticks($tbl, $sql_ref)." SET $sql_query WHERE $query";
		$sql_ref->query($sql_query);


        $output = display_bookmarkable_query($sql_query);

        $serial = isset($HTTP_COOKIE_VARS['serial']) ? unserialize(magic_quote_bypass($HTTP_COOKIE_VARS['serial'])) : array();

        ### Unsetting the 'serial' cookie
        setcookie('serial','');


        ### If we're coming from do_query, do not specify $tbl
        $serial_action = isset($serial['action']) ? $serial['action'] : '';


	    if ($serial_action == 'do_query') {
	    	$tbl = '';
		}

	    $hidden_counter = 0;
	    $output_return	= '';

	    $output_return .= '<FORM name="back2future" action="main.php?db='.urlencode($sql_ref->Database).'&tbl='.urlencode($tbl).'&action='.$serial_action.'" method="post">';

	    while ( list($key,$val) = each($serial) ) {

			if ($key != 'action' && $key != 'tbl_suppr' && !is_array($val)) {
	        	$hidden_counter++;
	        	$output_return .= '<INPUT type="hidden" name="'.$key.'" value="'.htmlentities($val).'">';
			}
		}
	    $output_return .= '</FORM>';
	    $output_return .= '<A href="javascript:document.back2future.submit()">'.$txt['back'].'</A>';

		$output .= ($hidden_counter > 0) ? $output_return : '<BR><BR><A href="main.php?db='.urlencode($sql_ref->Database).'&tbl='.urlencode($tbl).'&action='.$serial_action.'">'.$txt['back'].'</A>';



    }
    ### Form hasn't been posted, showing the form
    else {
        $sql_ref->query("DESCRIBE ".sql_back_ticks($tbl, $sql_ref));
        $output   = '<FORM method="post" action="main.php?db='.urlencode($sql_ref->Database).'&tbl='.urlencode($tbl).'&action=mod_record&query='.urlencode($query).'">';
        $output  .= '<TABLE border="1" bgcolor="'.$colors['table_bg'].'" bordercolor="'.$colors['titre_bg'].'" cellspacing="0" cellpadding="5">';

        $field_name_counter = 0;
        while (list($field_name,$field_type, $null_allowed) = $sql_ref->next_record()) {
            $fields[] = $field_type;
            $nulls_array[] = $null_allowed;
            $output .= '<INPUT type="hidden" name="field_name_'.$field_name_counter.'" value="'.$field_name.'">'."\n";
            $field_name_counter++;
        }

        $output .= '<TR>'."\n";
        $output .= '	<TD><FONT '.$font.'><B>'.$txt['field'].'</B></FONT></TD>'."\n";
        $output .= '	<TD><FONT '.$font.'><B>'.$txt['function'].'</B></FONT></TD>'."\n";
        $output .= '	<TD><FONT '.$font.'><B>'.$txt['null'].'</B></FONT></TD>'."\n";
        $output .= '	<TD><FONT '.$font.'><B>'.$txt['value'].'</B></FONT></TD>'."\n";
        $output .= '</TR>';

        $sql_ref->query("SELECT * FROM ".sql_back_ticks($tbl, $sql_ref)." WHERE $query");
       	$values = $sql_ref->next_record(MYSQL_ASSOC);
        $i 		= 0;


        while ( list($key,$val) = each($values) ) {

        	$current_field_type = $fields[$i];
        	$current_field_name = 'field_value_'.$i;
        	$current_null_name	= 'null_value_'.$i;
        	$current_field_value = $val;
        	$current_field_can_be_null = ($nulls_array[$i] != '');

        	### Determining the good type of form object to show
        	if ( eregi('enum',$current_field_type) ) {
                $select_function = '&nbsp;';
			}
			elseif ( eregi('set',$current_field_type) ) {
                $select_function = '&nbsp;';
			}
			else {
				$select_function = select_function("field_function_$i");
			}

        	### Setting the null checkbox
        	if ($current_field_can_be_null) {
	        	### The current field can be null by its definition
	        	if (!isset($current_field_value)) {
	        		$null_checkbox = '<INPUT type="checkbox" name="'.$current_null_name.'" CHECKED>';
	        	}
	        	else {
	        		$null_checkbox = '<INPUT type="checkbox" name="'.$current_null_name.'">';
	        	}
	        }
	        else {
	        	### The current field cannot be null, cancelling the checkbox
	        	$null_checkbox = '&nbsp;';
	        }

        	$output .= '<TR>'."\n";
        	$output .= '	<TD><FONT '.$font.'>'.$key.'</FONT></TD>'."\n";
        	$output .= '	<TD valign="top"><FONT '.$font.'>'.$select_function.'</FONT></TD>'."\n";
        	$output .= '	<TD>'.$null_checkbox.'</TD>';
        	$output .= '	<TD>'.display_field_form($current_field_type, $current_field_name, $current_field_value).'</TD>'."\n";
        	$output .= '</TR>'."\n";
        	$i++;
        }



        $output .= '</TABLE>'."\n";

        $output .= '<INPUT type="submit" value="'.$txt['modify'].'" class="bosses">'."\n";
        $output .= '<INPUT type="hidden" name="modif_record" value="1">'."\n";
        $output .= '<INPUT type="hidden" name="nb_fields" value="'.($i-1).'">'."\n";


        $output .= '</FORM>';
    }
    return $output;
}

function build_select($sql_ref, $tbl) {
	global $font, $colors, $HTTP_POST_VARS, $conf, $txt;

	$do_select 	= isset($HTTP_POST_VARS['do_select']) ? $HTTP_POST_VARS['do_select'] : '';
	$nb_fields 	= isset($HTTP_POST_VARS['nb_fields']) ? $HTTP_POST_VARS['nb_fields'] : '';
	$where 		= isset($HTTP_POST_VARS['where']) ? $HTTP_POST_VARS['where'] : '';
	$like		= '';
	$hidden 	= '';
	$output		= '';
	$fields_list= '';

	if ($do_select == 1) {
		### Building the SQL query before sending it to "do_sql_query" function
		$like_list		= '';
		$order_list		= '';
		for ($i = 0; $i < $nb_fields; $i++) {

			$field_selected = isset($HTTP_POST_VARS['fields'][$i]) ? magic_quote_bypass($HTTP_POST_VARS['fields'][$i]) : '';
			$current_field 	= isset($HTTP_POST_VARS["field_$i"]) ? magic_quote_bypass($HTTP_POST_VARS["field_$i"]): '';
			$order 			= isset($HTTP_POST_VARS["order_$i"]) ? $HTTP_POST_VARS["order_$i"] : '';
			$order_selected = isset($HTTP_POST_VARS["by_$i"]) ? $HTTP_POST_VARS["by_$i"] : '';
			$criteria		= isset($HTTP_POST_VARS["crit_$i"]) ? $HTTP_POST_VARS["crit_$i"] : '';



			$criteria = addSlashes(magic_quote_bypass($criteria));
			$criteria = trim($criteria);

			if ($field_selected != '') {
				$fields_list .= sql_back_ticks($field_selected, $sql_ref).', ';
			}

			if ($criteria != '') {
				$like_list .= sql_back_ticks($current_field, $sql_ref)." LIKE '$criteria' AND ";
			}
			if ($order == 1) {
				if ($order_list != '') {
					$order_list .= sql_back_ticks($current_field, $sql_ref)." $order_selected,";
				}
				else {
					$order_list = " ORDER BY ".sql_back_ticks($current_field, $sql_ref)." $order_selected,";
				}

			}


		}

		$fields_list = substr($fields_list,0,strlen($fields_list) -2);
		$like_list = substr($like_list,0,strlen($like_list) - 4);
		$order_list = substr($order_list,0,strlen($order_list) -1);

		if ($like_list == '') {
			$like_list = '1';
		}

		if ($where == '') {
			$sql_query = 'SELECT '.$fields_list.' FROM '.sql_back_ticks($tbl, $sql_ref).' WHERE '.$like_list.$order_list;
		}
		else {
			$sql_query = 'SELECT '.$fields_list.' FROM '.sql_back_ticks($tbl).' WHERE '.$where.$order_list;
		}
		$output .= do_sql_query($sql_ref,$sql_query);
	}
	else {
		### No form posted yet, showing the form
		$sql_ref->query("DESCRIBE ".sql_back_ticks($tbl, $sql_ref));

		$output .= '<SCRIPT language="Javascript">
					function CA(){
					for (var i = 0; i < build_select.elements.length; i++) {
						var e = build_select.elements[i];
						if (e.type==\'checkbox\') {
								if (build_select.chkbox_slt.value == "true") {
									e.checked = true;
								}
								else {
									e.checked = false;
								}
						}
					}
					if (build_select.chkbox_slt.value == "true" ){
						build_select.chkbox_slt.value = "false";
					}
					else {
						build_select.chkbox_slt.value = "true";
					}

				}
				</SCRIPT>';
		$output .= '<FORM name="build_select" method="post" action="main.php?db='.urlencode($sql_ref->Database).'&tbl='.urlencode($tbl).'&action=build_select">';
		$output .= '<TABLE border=0>';
		$output .= '<TR>';
		$output .= '	<TD valign="top">';
		$output .= '		<FONT '.$font.'>'.$txt['fields'].' :</FONT>';
		$output .= '	</TD>';
		$output .= '	<TD>';
		$output .= '		<SELECT name="fields[]" multiple class="trous">';

		$i = 0;
		while (list($field_name,$field_type) = $sql_ref->next_record()) {

            $output .= '		<OPTION value="'.$field_name.'" SELECTED>'.$field_name.'</OPTION>';
            $like .= '<TR>';
            $like .= '		<TD><font '.$font.'>'.$field_name.' : </font></TD>';
            $like .= '		<TD><INPUT type="text" name="crit_'.$i.'" class="trous"></TD>';
            $like .= '		<TD><font '.$font.'>'.$txt['order_by'].' ? <INPUT type="checkbox" name="order_'.$i.'" value=1 class=pick></TD>';
            $like .= '		<TD><SELECT name="by_'.$i.'" class=trous>';
            $like .= '			<OPTION value="ASC">ASC</OPTION>';
            $like .= '			<OPTION value="DESC">DESC</OPTION>';
            $like .= '			</SELECT>';
            $like .= '		</TD>';
            $like .= '</TR>';

        	$hidden .= '<INPUT type="hidden" name="field_'.$i.'" value="'.$field_name.'">';

            $i++;
        }
        $output .= '		</SELECT>';
        $output .= '	</TD>';
        $output .= '	<TD valign="top">';
        $output .= '		<FONT '.$font.'>';
        $output .= '		'.$txt['where'].' : <INPUT type="text" name="where" class="trous">';
        $output .= '		</FONT>';
        $output .= '	</TD>';
        $output .= '</TR>';
        $output .= '</TABLE>';

        $output .= '<BR>LIKE : <BR>';
        $output .= '<TABLE border="1" bgcolor="'.$colors['table_bg'].'" bordercolor="'.$colors['titre_bg'].'" cellspacing="0" cellpadding="5">';
        $output .= '<TR>';
        $output .= '	<TD><FONT '.$font.'><B>'.$txt['field'].'</B></FONT></TD>';
        $output .= '	<TD><FONT '.$font.'><B>'.$txt['criteria'].'</B></FONT></TD>';
        $output .= '	<TD><font '.$font.'><a href="javascript:CA();"><B>'.$txt['CtrlA'].'</B></A></font></TD>';
        $output .= '	<TD><FONT '.$font.'><B>'.$txt['order'].'</B></FONT></TD>';
        $output .= '</TR>';
        $output .= $like;
        $output .= '</TABLE>';

        $output .= '<BR><BR><DIV align="right"><INPUT type="submit" value="'.$txt['launch_query'].'" class="bosses"></DIV>';

        $output .= '<INPUT type="hidden" name="nb_fields" value="'.$i.'">';
        $output .= '<INPUT type="hidden" name="do_select" value="1">';
        $output .= '<INPUT type="hidden" name="chkbox_slt" value="true">';
        $output .= $hidden;
        $output .='</FORM>';

	}

	return $output;
}

?>