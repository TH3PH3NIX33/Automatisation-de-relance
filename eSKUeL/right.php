<?php
$img_path 	= $colors['img_path'];


function nav_bar($diff = '') {
		Global $colors, $db, $tbl, $main_DB, $txt, $action;
		Global $collapse_right, $font;
				
		$img_path 	= $colors['img_path'];
		$tbl_menu 	= urlencode(urlencode(addslashes($tbl)));
		$db_menu 	= urlencode(urlencode(addslashes($db)));

		$right_navigation = '<script language="Javascript">
							function tips(diff) {
			                        if (count == 0) {
				                            count = 1;
				                            if (diff) {
				                            	eval("document.tip"+diff+".src=\''.$img_path.'img/tips_on.gif\'");
				                            }
				                            else {
				                            	eval("document.tip.src=\''.$img_path.'img/tips_on.gif\'");
				                            }
			                            }
			                            else {
				                            count = 0;
				                            if (diff) {
				                            	eval("document.tip"+diff+".src=\''.$img_path.'img/tips_off.gif\'");
				                            }
				                            else {
				                            	eval("document.tip.src=\''.$img_path.'img/tips_off.gif\'");
				                            }
			                            }
			                    }
			                    </script>';
	
	if ($action == 'do_query' || $action == 'dump' || $action == 'desc') {
		$action_collapse = '';
	}
	else {
		$action_collapse = $action;
	}
	
	
	
	if ($colors['tpl_type'] == 0  || $collapse_right == 'no') {
	
		### Right nav Bar
		
		### Separator
	    $separateur  = '<tr>'."\n";
	    $separateur .= '	<td align="center" colspan="2" height="1"><img src="img/vide.gif" height="1" width="10"></td>'."\n";
	    $separateur .= '</tr>'."\n";
	    $separateur .= '<tr>'."\n";
	    $separateur .= '	<td align="center" bgcolor="'.$colors['titre_bg'].'" colspan="2" height="1"><img src="img/vide.gif" height="1" width="10"></td>'."\n";
	    $separateur .= '</tr>'."\n";
	    $separateur .= '<tr>'."\n";
	    $separateur .= '	<td align="center" colspan="2" height="1"><img src="img/vide.gif" height="1" width="10"></td>'."\n";
	    $separateur .= '</tr>'."\n";
	
	    $right_navigation .= '<table border="1" cellspacing="0" cellpadding="5" bordercolor="'.$colors['bordercolor'].'">'."\n";
	    $right_navigation .= '<tr>'."\n";
	    $right_navigation .= '	<td align="center" bgcolor="'.$colors['titre_bg'].'"';
		
		if (@is_file('tpl/'.$path.'/titre_bg.gif')) {
	    	$right_navigation.=' background="tpl/'.$path.'/titre_bg.gif"';
		}
	
	    $right_navigation .= '>'."\n";
	    $right_navigation .= '		<table border="0" cellspacing="0" cellpadding="0" align="left" width="100%">'."\n";
	    $right_navigation .= '		<tr>'."\n";
	    $right_navigation .= '			<td><img src="'.$img_path.'img/options.gif">&nbsp;</td>'."\n";
	    $right_navigation .= '			<td align="center"><font '.$font.' color="'.$colors['titre_font'].'"><b>'.$txt['options'].'</b></font></td>'."\n";
	    $right_navigation .= '			<td align="right"><A href="javascript:tips();"><img src="'.$img_path.'img/tips_off.gif" border="0" name="tip" '.link_status($txt['help']).'></A>&nbsp;</td>'."\n";
	    $right_navigation .= '			<td><a href="main.php?db='.urldecode($db_menu).'&tbl='.urldecode($tbl_menu).'&action='.$action_collapse.'&collapse_right=yes"><img src="'.$img_path.'img/close.gif" border="0"  '.link_status($txt['close']).'></a></td>'."\n";
	    $right_navigation .= '		</tr>'."\n";
	    $right_navigation .= '		</table>'."\n";
	    $right_navigation .= '	</td>'."\n";
	    $right_navigation .= '</tr>'."\n";
	    $right_navigation .= '<tr>'."\n";
	    $right_navigation .= '	<td bgcolor="'.$colors['table_bg'].'">'."\n";
	    $right_navigation .= '		<table border="0" cellspacing="0" cellpadding="2" width="100%">'."\n";
	
	    ### Setup
	    if ($tbl == '' && $db == '') {
			$right_navigation .= '<tr>'."\n";
			$right_navigation .= '	<td nowrap width="10%"><A href="setup.php"><img src="'.$img_path.'img/setup.gif" border="0" '.link_status($txt['setup']).'></A></td>'."\n";
			$right_navigation .= '	<td nowrap width="90%"><font '.$font.'><a href="setup.php" '.link_status($txt['setup']).'>'.$txt['setup'].'</a></font></td>'."\n";
			$right_navigation .= '</tr>'."\n";
			$right_navigation .= $separateur;
	    }
	    ### /Setup
	
	    ### Manual query
	    if ($db) {
		    $right_navigation .= '<tr>'."\n";
		    $right_navigation .= '	<td nowrap><A href="javascript:alt(\'mimineshow\',\'mimine\');"><img src="'.$img_path.'img/manuel.gif" border="0" '.link_status($txt['manual_request']).'></A></td>'."\n";
		    $right_navigation .= '	<td nowrap><font '.$font.'><a href="javascript:alt(\'mimineshow\',\'mimine\');" '.link_status($txt['manual_request']).'>'.$txt['manual_request'].'</a></font></td>'."\n";
		    $right_navigation .= '</tr>'."\n";
		    $right_navigation .= $separateur;
	    }
	    ### /Manual query
	
	    ### DB ###
	    ### If we show multiples DB, can create a new one and also drop the current
	    if ($main_DB->only_DB == '') {
	        $right_navigation .= '<tr>'."\n";
	        $right_navigation .= '	<td nowrap><A href="javascript:alt(\'main.php?action=create_db\',\'create_db\');"><img src="'.$img_path.'img/db.gif" border="0" '.link_status($txt['create_db']).'></A></td>'."\n";
	        $right_navigation .= '	<td nowrap><font '.$font.'><a href="javascript:alt(\'main.php?action=create_db\',\'create_db\');" '.link_status($txt['create_db']).'>'.$txt['create_db'].'</a></font></td>'."\n";
	        $right_navigation .= '</tr>'."\n";
			
			### Drop database        
	        if ($db) {
	            $right_navigation .= '<tr>'."\n";
	            $right_navigation .= '	<td nowrap><A href="javascript:alt(\'main.php?db='.$db_menu.'&action=drop_database\',\'drop_database\');"><img src="'.$img_path.'img/delete_db.gif" border="0" '.link_status($txt['delete_db']).'></A></td>'."\n";
	            $right_navigation .= '	<td nowrap><font '.$font.'><A href="javascript:alt(\'main.php?db='.$db_menu.'&action=drop_database\',\'drop_database\');" '.link_status($txt['delete_db']).'>'.$txt['delete_db'].'</A></font></td>'."\n";
	            $right_navigation .= '</tr>'."\n";
	            $right_navigation .= $separateur;
	        }
	
	    }
	    ### /DB ###
	
	    if ($tbl) {
		    ### View table
		    $right_navigation .= '<tr>'."\n";
		    $right_navigation .= '	<td nowrap><A href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=view\',\'view\');"><img src="'.$img_path.'img/affich.gif" border="0" '.link_status($txt['display_content']).'></A></td>'."\n";
		    $right_navigation .= '	<td nowrap><font '.$font.'><a href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=view\',\'view\');" '.link_status($txt['display_content']).'>'.$txt['display_content'].'</A></font></td>'."\n";
		    $right_navigation .= '</tr>'."\n";
		    ### Select
	        $right_navigation .= '<tr>'."\n";
	        $right_navigation .= '	<td nowrap><A href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=build_select\',\'build_select\');"><img src="'.$img_path.'img/select.gif" border="0" '.link_status($txt['select']).'></A></td>'."\n";
	        $right_navigation .= '	<td nowrap><font '.$font.'><a href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=build_select\',\'build_select\');" '.link_status($txt['select']).'>'.$txt['select'].'</A></font></td>'."\n";
	        $right_navigation .= '</tr>'."\n";
	        ### Insert new record
	        $right_navigation .= '<tr>'."\n";
	        $right_navigation .= '	<td nowrap><A href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=insert\',\'insert\');"><img src="'.$img_path.'img/nouv_enr.gif" border="0" '.link_status($txt['add_record']).'></A></td>'."\n";
	        $right_navigation .= '	<td nowrap><font '.$font.'><a href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=insert\',\'insert\');" '.link_status($txt['add_record']).'>'.$txt['add_record'].'</A></font></td>'."\n";
	        $right_navigation .= '</tr>'."\n";
	        
	        ### Tables Comments allowed > 3.23.00
	        if ($main_DB->Infos['Version'] > 32300) {
		        $right_navigation .= '<tr>'."\n";
		        $right_navigation .= '	<td nowrap><A href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=comment\',\'comment\');"><img src="'.$img_path.'img/comment.gif" border="0" '.link_status($txt['add_comment']).'></A></td>'."\n";
		        $right_navigation .= '	<td nowrap><font '.$font.'><a href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=comment\',\'comment\');" '.link_status($txt['add_comment']).'>'.$txt['add_comment'].'</A></font></td>'."\n";
		        $right_navigation .= '</tr>'."\n";
		    }
		    
	        $right_navigation .= $separateur;
	    }
	    if ($db){
	    	### Create new table
	    	$right_navigation .= '<tr>'."\n";
	    	$right_navigation .= '	<td nowrap><A href="javascript:alt(\'main.php?db='.$db_menu.'&action=create_new_table\',\'create_new_table\');"><img src="'.$img_path.'img/table.gif" border="0" '.link_status($txt['create_tbl']).'></A></td>'."\n";
	    	$right_navigation .= '	<td nowrap><font '.$font.'><A href="javascript:alt(\'main.php?db='.$db_menu.'&action=create_new_table\',\'create_new_table\');" '.link_status($txt['create_tbl']).'>'.$txt['create_tbl'].'</A></font></td>'."\n";
	    	$right_navigation .= '</tr>'."\n";
	    	### Incomong SQL
	    	$right_navigation .= '<tr>'."\n";
	    	$right_navigation .= '	<td nowrap><A href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=incoming_sql\',\'incoming_sql\');"><img src="'.$img_path.'img/upload_dump.gif" border="0" '.link_status($txt['incoming_sql']).'></A></td>'."\n";
	    	$right_navigation .= '	<td nowrap><font '.$font.'><A href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=incoming_sql\',\'incoming_sql\');" '.link_status($txt['incoming_sql']).'>'.$txt['incoming_sql'].'</A></font></td>'."\n";
	    	$right_navigation .= '</tr>'."\n";
	    }
	    if ($tbl) {
	    	$right_navigation .= '<tr>'."\n";
	    	$right_navigation .= '	<td nowrap><A href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=add_field\',\'add_field\');"><img src="'.$img_path.'img/ajout_champ.gif" border="0" '.link_status($txt['add_field']).'></A></td>'."\n";
	    	$right_navigation .= '	<td nowrap><font '.$font.'><a href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=add_field\',\'add_field\');" '.link_status($txt['add_field']).'>'.$txt['add_field'].'</A></font></td>'."\n";
	    	$right_navigation .= '</tr>'."\n";
	    	
	    	### Change type >= 3.23.22
	    	if ($main_DB->Infos['Version'] >= 32322) {
	        	$right_navigation .= '<tr>'."\n";
	        	$right_navigation .= '	<td nowrap><A href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=change_type\',\'change_type\');"><img src="'.$img_path.'img/change_type.gif" border="0" '.link_status($txt['change_type']).'></A></td>'."\n";
	        	$right_navigation .= '	<td nowrap><font '.$font.'><a href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=change_type\',\'change_type\');" '.link_status($txt['change_type']).'>'.$txt['change_type'].'</A></font></td>'."\n";
	        	$right_navigation .= '</tr>'."\n";
			}
			$right_navigation .= '<tr>'."\n";
			$right_navigation .= '	<td nowrap><A href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=dump\',\'dump\');"><img src="'.$img_path.'img/dump.gif" border="0" '.link_status($txt['dump_tbl']).'></A></td>'."\n";
			$right_navigation .= '	<td nowrap><font '.$font.'><a href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=dump\',\'dump\');" '.link_status($txt['dump_tbl']).'>'.$txt['dump_tbl'].'</A></font></td>'."\n";
			$right_navigation .= '</tr>'."\n";
			$right_navigation .= '<tr>'."\n";
			$right_navigation .= '	<td nowrap><A href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=empty\',\'empty\');"><img src="'.$img_path.'img/empty.gif" border="0" '.link_status($txt['emptyer_tbl']).'></A></td>'."\n";
			$right_navigation .= '	<td nowrap><font '.$font.'><a href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=empty\',\'empty\');" '.link_status($txt['emptyer_tbl']).'>'.$txt['emptyer_tbl'].'</A></font></td>'."\n";
			$right_navigation .= '</tr>'."\n";
			$right_navigation .= '<tr>'."\n";
			$right_navigation .= '	<td nowrap><A href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=rename\',\'rename\');"><img src="'.$img_path.'img/renommer.gif" border="0" '.link_status($txt['rename_tbl']).'></A></td>'."\n";
			$right_navigation .= '	<td nowrap><font '.$font.'><a href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=rename\',\'rename\');" '.link_status($txt['rename_tbl']).'>'.$txt['rename_tbl'].'</A></font></td>'."\n";
			$right_navigation .= '</tr>'."\n";
			$right_navigation .= '<tr>'."\n";
			$right_navigation .= '	<td nowrap><A href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=copy\',\'copy\');"><img src="'.$img_path.'img/copier.gif" border="0" '.link_status($txt['copy_tbl']).'></A></td>'."\n";
			$right_navigation .= '	<td nowrap><font '.$font.'><a href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=copy\',\'copy\');" '.link_status($txt['copy_tbl']).'>'.$txt['copy_tbl'].'</A></font></td>'."\n";
			$right_navigation .= '</tr>'."\n";
			$right_navigation .= '<tr>'."\n";
			$right_navigation .= '	<td nowrap><A href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=move\',\'move\');"><img src="'.$img_path.'img/deplacer.gif" border="0" '.link_status($txt['move_tbl']).'></A></td>'."\n";
			$right_navigation .= '	<td nowrap><font '.$font.'><a href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=move\',\'move\');" '.link_status($txt['move_tbl']).'>'.$txt['move_tbl'].'</A></font></td>'."\n";
			$right_navigation .= '</tr>'."\n";
	            
			### Order the table / MySQL >= 3.23.34
			if ($main_DB->Infos['Version'] >= 32334) {
				$right_navigation .= '<tr>'."\n";
				$right_navigation .= '	<td nowrap><A href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=order\',\'order\');"><img src="'.$img_path.'img/ordonner.gif" border="0" '.link_status($txt['order_tbl']).'></A></td>'."\n";
				$right_navigation .= '	<td nowrap><font '.$font.'><a href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=order\',\'order\');" '.link_status($txt['order_tbl']).'>'.$txt['order_tbl'].'</A></font></td>'."\n";
				$right_navigation .= '</tr>'."\n";
			}
	            
	    	$right_navigation .= '<tr>'."\n";
	        $right_navigation .= '	<td nowrap><A href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=delete_tbl\',\'delete_tbl\');"><img src="'.$img_path.'img/delete_tbl.gif" border="0" '.link_status($txt['delete_tbl']).'></A></td>'."\n";
	        $right_navigation .= '	<td nowrap><font '.$font.'><a href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=delete_tbl\',\'delete_tbl\');" '.link_status($txt['delete_tbl']).'>'.$txt['delete_tbl'].'</A></font></td>'."\n";
	        $right_navigation .= '</tr>'."\n";
	        
	        ### Maintenance / MySQL >= 3.23.22
			if ($main_DB->Infos['Version'] >= 32322) {
				$right_navigation .= $separateur;
				$right_navigation .= '<tr>'."\n";
				$right_navigation .= '	<td nowrap><A href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=check\',\'check\');"><img src="'.$img_path.'img/check.gif" border="0" '.link_status($txt['check_tbl']).'></A></td>'."\n";
				$right_navigation .= '	<td nowrap><font '.$font.'><a href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=check\',\'check\');" '.link_status($txt['check_tbl']).'>'.$txt['check_tbl'].'</A></font></td>'."\n";
				$right_navigation .= '</tr>'."\n";
				$right_navigation .= '<tr>';
				$right_navigation .= '	<td nowrap><A href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=analyze\',\'analyze\');"><img src="'.$img_path.'img/analyse.gif" border="0" '.link_status($txt['analyse_tbl']).'></A></td>'."\n";
				$right_navigation .= '	<td nowrap><font '.$font.'><a href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=analyze\',\'analyze\');" '.link_status($txt['analyse_tbl']).'>'.$txt['analyse_tbl'].'</A></font></td>'."\n";
				$right_navigation .= '</tr>'."\n";
				$right_navigation .= '<tr>'."\n";
				$right_navigation .= '	<td nowrap><A href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=repair\',\'repair\');"><img src="'.$img_path.'img/reparer.gif" border="0" '.link_status($txt['repare_tbl']).'></A></td>'."\n";
				$right_navigation .= '	<td nowrap><font '.$font.'><a href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=repair\',\'repair\');" '.link_status($txt['repare_tbl']).'>'.$txt['repare_tbl'].'</A></font></td>'."\n";
				$right_navigation .= '</tr>'."\n";
	            $right_navigation .= '<tr>'."\n";
	            $right_navigation .= '	<td nowrap><A href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=optimize\',\'optimize\');"><img src="'.$img_path.'img/optimize.gif" border="0" '.link_status($txt['optimize_tbl']).'></A></td>'."\n";
	            $right_navigation .= '	<td nowrap><font '.$font.'><a href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=optimize\',\'optimize\');" '.link_status($txt['optimize_tbl']).'>'.$txt['optimize_tbl'].'</A></font></td>'."\n";
	            $right_navigation .= '</tr>'."\n";
			}
	    }
	
	    $right_navigation .= '          </table>';
	    $right_navigation .= '		</td>';
	    $right_navigation .= '	</tr>';
	    $right_navigation .= '	</table>';
	}
	else {
	
		### Top nav bar
	
	    $separateur 		= '<img src="'.$img_path.'img/separ.gif" height="20" border="0">';
	    $ico_setup 			= '<a href="setup.php" onMouseOver="over(\'setup\', \''.$diff.'\')" onMouseOut="out(\'setup\',\''.$diff.'\')"><img src="'.$img_path.'img/setup_off.gif" name="setup'.$diff.'" border="0"  '.link_status($txt['setup']).'"></a>&nbsp;';
	    $ico_mimine 		= '<a href="javascript:alt(\'mimineshow\',\'mimine\');" onMouseOver="over(\'manuel\', \''.$diff.'\')" onMouseOut="out(\'manuel\', \''.$diff.'\')"><img src="'.$img_path.'img/manuel_off.gif" name="manuel'.$diff.'" border="0" '.link_status($txt['manual_request']).'></a>&nbsp;';
	    $ico_create_db 		= '<a href="javascript:alt(\'main.php?action=create_db\',\'create_db\');" onMouseOver="over(\'db\', \''.$diff.'\')" onMouseOut="out(\'db\', \''.$diff.'\')"><img src="'.$img_path.'img/db_off.gif" name="db'.$diff.'" border="0" '.link_status($txt['create_db']).'></a>&nbsp;';
	    $ico_delete_db 		= '<a href="javascript:alt(\'main.php?db='.$db_menu.'&action=drop_database\',\'drop_database\');" onMouseOver="over(\'deletedb\', \''.$diff.'\')" onMouseOut="out(\'deletedb\', \''.$diff.'\')"><img src="'.$img_path.'img/deletedb_off.gif" name="deletedb'.$diff.'" border="0" '.link_status($txt['delete_db']).'></a>&nbsp;';
	    $ico_show 			= '<a href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=view\',\'view\');" onMouseOver="over(\'affich\', \''.$diff.'\')" onMouseOut="out(\'affich\', \''.$diff.'\')"><img src="'.$img_path.'img/affich_off.gif" name="affich'.$diff.'" border="0" '.link_status($txt['display_content']).'"></a>&nbsp;';
	    $ico_select 		= '<a href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=build_select\',\'build_select\');" onMouseOver="over(\'select\', \''.$diff.'\')" onMouseOut="out(\'select\', \''.$diff.'\')"><img src="'.$img_path.'img/select_off.gif" name="select'.$diff.'" border="0" '.link_status($txt['select']).'></a>&nbsp;';
	    $ico_insert_into 	= '<a href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=insert\',\'insert\');" onMouseOver="over(\'nouv_enr\', \''.$diff.'\')" onMouseOut="out(\'nouv_enr\', \''.$diff.'\')"><img src="'.$img_path.'img/nouv_enr_off.gif" name="nouv_enr'.$diff.'" border="0" '.link_status($txt['add_record']).'></a>&nbsp;';
	    
	    ### Comment a table / MySQL >= 3.23.00
	    if ($main_DB->Infos['Version'] >= 32300) {
	    	$ico_comment 		= '<a href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=comment\',\'comment\');" onMouseOver="over(\'comment\', \''.$diff.'\')" onMouseOut="out(\'comment\', \''.$diff.'\')"><img src="'.$img_path.'img/comment_off.gif" name="comment'.$diff.'" border="0" '.link_status($txt['add_comment']).'></a>&nbsp;';
	    }
	    else {
	    	$ico_comment = '';
	    }
	    $ico_create_tbl 	= '<a href="javascript:alt(\'main.php?db='.$db_menu.'&action=create_new_table\',\'create_new_table\');" onMouseOver="over(\'table\', \''.$diff.'\')" onMouseOut="out(\'table\', \''.$diff.'\')"><img src="'.$img_path.'img/table_off.gif" name="table'.$diff.'" border="0" '.link_status($txt['create_tbl']).'></a>&nbsp;';
	    $ico_upload_dump 	= '<a href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=incoming_sql\',\'incoming_sql\');" onMouseOver="over(\'upload_dump\', \''.$diff.'\')" onMouseOut="out(\'upload_dump\', \''.$diff.'\')"><img src="'.$img_path.'img/upload_dump_off.gif" name="upload_dump'.$diff.'" border="0" '.link_status($txt['incoming_sql']).'></a>&nbsp;';
	    $ico_add_field 		= '<a href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=add_field\',\'add_field\');" onMouseOver="over(\'ajout_champs\', \''.$diff.'\')" onMouseOut="out(\'ajout_champs\', \''.$diff.'\')"><img src="'.$img_path.'img/ajout_champs_off.gif" name="ajout_champs'.$diff.'" border="0" '.link_status($txt['add_field']).'></a>&nbsp;';
	    
	    ### Change type / MySQL >= 3.23.22
	    if ($main_DB->Infos['Version'] >= 32322) {
	    	$ico_chg_type 		= '<a href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=change_type\',\'change_type\');" onMouseOver="over(\'change_type\', \''.$diff.'\')" onMouseOut="out(\'change_type\', \''.$diff.'\')"><img src="'.$img_path.'img/change_type_off.gif" name="change_type'.$diff.'" border="0" '.link_status($txt['change_type']).'></a>&nbsp;';
	    }
	    else {
	    	$ico_chg_type = '';
	    }
	    $ico_dump 			= '<a href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=dump\',\'dump\');" onMouseOver="over(\'dump\', \''.$diff.'\')" onMouseOut="out(\'dump\', \''.$diff.'\')"><img src="'.$img_path.'img/dump_off.gif" name="dump'.$diff.'" border="0" '.link_status($txt['dump_tbl']).'></a>&nbsp;';
	    $ico_empty_tbl 		= '<a href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=empty\',\'empty\');" onMouseOver="over(\'empty\', \''.$diff.'\')" onMouseOut="out(\'empty\', \''.$diff.'\')"><img src="'.$img_path.'img/empty_off.gif" name="empty'.$diff.'" border="0" '.link_status($txt['emptyer_tbl']).'></a>&nbsp;';
	    $ico_rename_tbl 	= '<a href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=rename\',\'rename\');" onMouseOver="over(\'renommer\', \''.$diff.'\')" onMouseOut="out(\'renommer\', \''.$diff.'\')"><img src="'.$img_path.'img/renommer_off.gif" name="renommer'.$diff.'" border="0" '.link_status($txt['rename_tbl']).'></a>&nbsp;';
	    $ico_copy_tbl 		= '<a href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=copy\',\'copy\');" onMouseOver="over(\'copier\', \''.$diff.'\')" onMouseOut="out(\'copier\', \''.$diff.'\')"><img src="'.$img_path.'img/copier_off.gif" name="copier'.$diff.'" border="0" '.link_status($txt['copy_tbl']).'></a>&nbsp;';
	    $ico_move_tbl 		= '<a href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=move\',\'move\');" onMouseOver="over(\'deplacer\', \''.$diff.'\')" onMouseOut="out(\'deplacer\', \''.$diff.'\')"><img src="'.$img_path.'img/deplacer_off.gif" name="deplacer'.$diff.'" border="0" '.link_status($txt['move_tbl']).'></a>&nbsp;';
	    
	    ### Order a table / MySQL >= 3.23.34
	    if ($main_DB->Infos['Version'] >= 32334) {
	    	$ico_order_tbl = '<a href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=order\',\'order\');" onMouseOver="over(\'ordonner\', \''.$diff.'\')" onMouseOut="out(\'ordonner\', \''.$diff.'\')"><img src="'.$img_path.'img/ordonner_off.gif" name="ordonner'.$diff.'" border="0" '.link_status($txt['order_tbl']).'></a>&nbsp;';
	    }
	    else {
	    	$ico_order_tbl = '';
	    }
	    
	    $ico_delete_tbl 	= '<a href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=delete_tbl\',\'delete_tbl\');" onMouseOver="over(\'del\', \''.$diff.'\')" onMouseOut="out(\'del\', \''.$diff.'\')"><img src="'.$img_path.'img/del_off.gif" name="del'.$diff.'" border="0" '.link_status($txt['delete_tbl']).'></a>&nbsp;';
		$ico_check_tbl 		= '<a href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=check\',\'check\');" onMouseOver="over(\'check\', \''.$diff.'\')" onMouseOut="out(\'check\', \''.$diff.'\')"><img src="'.$img_path.'img/check_off.gif" name="check'.$diff.'" border="0" '.link_status($txt['check_tbl']).'></a>&nbsp;';
		$ico_analyze_tbl 	= '<a href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=analyze\',\'analyze\');" onMouseOver="over(\'analyse\', \''.$diff.'\')" onMouseOut="out(\'analyse\', \''.$diff.'\')"><img src="'.$img_path.'img/analyse_off.gif" name="analyse'.$diff.'" border="0" '.link_status($txt['analyse_tbl']).'></a>&nbsp;';
		$ico_repair_tbl 	= '<a href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=repair\',\'repair\');" onMouseOver="over(\'reparer\', \''.$diff.'\')" onMouseOut="out(\'reparer\', \''.$diff.'\')"><img src="'.$img_path.'img/reparer_off.gif" name="reparer'.$diff.'" border="0" '.link_status($txt['repare_tbl']).'></a>&nbsp;';
		$ico_optimize_tbl 	= '<a href="javascript:alt(\'main.php?db='.$db_menu.'&tbl='.$tbl_menu.'&action=optimize\',\'optimize\');" onMouseOver="over(\'optimize\', \''.$diff.'\')" onMouseOut="out(\'optimize\', \''.$diff.'\')"><img src="'.$img_path.'img/optimize_off.gif" name="optimize'.$diff.'" border="0" '.link_status($txt['optimize_tbl']).'></a>&nbsp;';
		
	
	    $right_navigation .= '<table border="0" cellspacing="2" cellpadding="2" bordercolor="'.$colors['trou_border'].'" bgcolor="'.$colors['trou_bg'].'">';
	    $right_navigation .= '<tr>';
	    $right_navigation .= '  <td>';
	
	    if ($db == '' && $tbl == '') {
	        $right_navigation .= $ico_setup;
	    }
	
	    if($db){
	        $right_navigation .= $ico_mimine;
	        $right_navigation .= $separateur;
	    }
	
	    if ($main_DB->only_DB == '') {
	        $right_navigation .= $ico_create_db;
	        if ($db){
	            $right_navigation .= $ico_delete_db;
	            $right_navigation .= $separateur;
	        }
	    }
	
	    if ($tbl) {
	        $right_navigation .= $ico_show.$ico_select.$ico_insert_into.$ico_comment;
	        $right_navigation .= $separateur;
	    }
	    if ($db) {
	        $right_navigation .= $ico_create_tbl.$ico_upload_dump;
	    }
	    if ($tbl) {
	        $right_navigation .= $ico_add_field.$ico_chg_type.$ico_dump.$ico_empty_tbl.$ico_rename_tbl.$ico_copy_tbl.$ico_move_tbl.$ico_order_tbl.$ico_delete_tbl;
	       
	        
	        ### Maintenance / MySQL >= 3.23.22
	        if ($main_DB->Infos['Version'] >= 32322) {
	        	$right_navigation .= $separateur;
	        	$right_navigation .= $ico_check_tbl.$ico_analyze_tbl.$ico_repair_tbl.$ico_optimize_tbl;
	        }
	    }
	
	    $right_navigation .= '<img src="'.$img_path.'img/separ.gif" height="20" border="0"><A href="javascript:tips(\''.$diff.'\');"><img src="'.$img_path.'img/tips_off.gif" border="0" name="tip'.$diff.'" '.link_status($txt['help']).'></A>';
	    $right_navigation .= $separateur;
	    $right_navigation .= '<A href="main.php?db='.urldecode($db_menu).'&tbl='.urldecode($tbl_menu).'&action='.$action_collapse.'&collapse_right=no"><img src="'.$img_path.'img/close.gif" border="0" '.link_status($txt['close']).'></A>';
	    $right_navigation .= '  </td>';
	    $right_navigation .= '</tr>';
	    $right_navigation .= '</table>';
	
	}
	
	return $right_navigation;
}

?>