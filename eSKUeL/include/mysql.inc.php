<?php
/***************************************************************************
             ____  _   _ ____  _              _     _  _   _   _
            |  _ \| | | |  _ \| |_ ___   ___ | |___| || | | | | |
            | |_) | |_| | |_) | __/ _ \ / _ \| / __| || |_| | | |
            |  __/|  _  |  __/| || (_) | (_) | \__ \__   _| |_| |
            |_|   |_| |_|_|    \__\___/ \___/|_|___/  |_|  \___/

                       mysql.inc.php  -  A Mysql Class
                             -------------------
    begin                : Sat Oct 20 2001
    copyright            : (C) 2002-? PHPtools4U.com - Mathieu LESNIAK
    email                : support@phptools4u.com

***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

class DB {



        var $Host 		= '';		// Hostname of our MySQL server
        var $Database 	= '';   	// Logical database name on that server
        var $User 		= '';   	// Database user
        var $Password 	= '';  		// Database user's password
        var $only_DB 	= '';

        var $Link_ID 	= 0;    	// Result of mysql_connect()
        var $Query_ID 	= 0;    	// Result of most recent mysql_query()
        var $Record     = array();  // Current mysql_fetch_array()->result
        var $Row;                   // Current row number
        var $Errno 		= 0;		// Error state of query
        var $Error 		= '';
        var $DB_selected;
        var $Infos		= array('Number_Of_Tables' => 0, 'Version' => -1);			// avoiding multiple calls to db, storing infos


	#
	# Create a link id to the MySQL database
	#

	function DB($arrConfig) {
		$this->Host = $arrConfig['HOST'];
		$this->Database = $arrConfig['DB'];
		$this->User = $arrConfig['USER'];
		$this->Password = $arrConfig['PASSWORD'];
		if ($arrConfig['ONLY_DB'] != '') {
				$this->only_DB = $arrConfig['ONLY_DB'];
		}
		$this->connect();
	}

    #
    # Stop the execution of the script
    # in case of error
    # $msg : the message that'll be printed
    #

    function halt($msg,$design = 0) {
        $output  = "<FONT COLOR=\"#FF0000\"><B>Erreur MySQL :</B> <BR>".nl2br($msg)."<BR>\n";
        $output .= "<B>Erreur MySQL numéro</B>: $this->Errno ($this->Error)<BR><BR></FONT>\n";

        $this->Link_ID = 0;
        if ($design != 1) {
	       	display_design($output);
        }
        else {
        	setcookie("ConfDBCookie",'');
        	display_design($output,1);
        }
        die();

    }


	#
	# Connect to the MySQL server
	#

	function connect() {
		global $DBType;

		if($this->Link_ID == 0) {
			$this->Link_ID = @mysql_connect($this->Host, $this->User, $this->Password);

			if (!$this->Link_ID) {
				$this->halt('<BR>Database connection failed.<BR>Please go to <A href="setup.php">setup</A> to fix it<BR><BR>Echec de connexion à la base de donn&eacute;es.<BR>Merci de v&eacute;rifier vos <A href="setup.php">param&egrave;tres de connexion</A><BR>',1);
            }
		}

	}

	function select_db($db) {
		$this->Database = $db;
		if ($this->Link_ID == 0) {
				$this->connect();
		}

		$SelectResult = mysql_select_db($db,$this->Link_ID) or $this->halt("cannot select database <I>".$this->Database."</I>");

        if(!$SelectResult) {
			$this->halt("cannot select database <I>".$this->Database."</I>");
		}
		else {
			$this->DB_selected = 1;
			$this->Database = $db;
		}
	}

	#
    # Send a query to the MySQL server
    # $Query_String = the query
    #

    function query($Query_String) {
		//echo "<B>Requête :</B> : <PRE>$Query_String</PRE><BR>";
		if ($this->Link_ID == 0) {
			$this->connect();
		}
		$this->Query_ID = mysql_query($Query_String,$this->Link_ID);
        $this->Row = 0;
        $this->Errno = mysql_errno();
        $this->Error = mysql_error();
        if (!$this->Query_ID) {
			$this->halt("Invalid SQL: ".$Query_String);
		}
		return $this->Query_ID;
	}

	#
	# return the next record of a MySQL query
	# in an array
	#

    function next_record($type = MYSQL_BOTH) {

		$this->Record = mysql_fetch_array($this->Query_ID,$type);
        $this->Row += 1;
		$this->Errno = mysql_errno();
		$this->Error = mysql_error();
		$stat = is_array($this->Record);
		if (!$stat) {
			mysql_free_result($this->Query_ID);
			$this->Query_ID = 0;
		}
		return $this->Record;
    }

	#
	# Return the number of rows affected by a query
	# (except insert and delete query)
	#

	function num_rows() {
		return mysql_num_rows($this->Query_ID);
	}

	#
	# Return the number of affected rows
	# by a UPDATE, INSERT or DELETE query
	#

    function affected_rows() {
		return mysql_affected_rows($this->Link_ID);
	}

    #
    # Return the id of the last inserted element
    #

	function insert_id() {
		return mysql_insert_id($this->Link_ID);
	}

	#
	# Optimize a table
	# $tbl_name : the name of the table
	#

	function optimize($tbl_name) {
		$this->connect();
		$this->Query_ID = @mysql_query("OPTIMIZE TABLE $tbl_name",$this->Link_ID);
	}

	function fetch_field() {
		return mysql_fetch_field($this->Query_ID);
	}

	function field_seek($offset) {
		return mysql_field_seek($this->Query_ID,$offset);
	}

	function field_table($offset) {
		return mysql_field_table($this->Query_ID,$offset);
	}
	#
	# Free the memory used by a result
	#

	function clean_results() {
		if($this->Query_ID != 0) mysql_freeresult($this->Query_ID);
	}

	#
	# Close the link to the MySQL database
	#

	function close() {
		if($this->Link_ID != 0) mysql_close($this->Link_ID);
	}

	function storeTblsInfos() {
		@$this->query("SHOW VARIABLES LIKE 'version'");
    	$resultset = $this->next_record();
    	if (is_array($resultset)) {
    		$mysql_version = $resultset['Value'];
    		$version_array = explode('.',$mysql_version);
    		$this->Infos['Version'] =  (int)sprintf('%d%02d%02d', $version_array[0], $version_array[1], intval($version_array[2]));
    		$this->Infos['Full_Version'] = $mysql_version;
    	}
    	else {
    		$this->Infos['Version'] = -1;
	    }
		if ($this->Infos['Version'] > 32303 && $this->Database != '') {
			$this->query("SHOW TABLE STATUS FROM `".$this->Database."`");
			$tbls_counter = 0;
			while ($tmp_var = $this->next_record()) {

				$this->Infos['Tables_List'][] 						= $tmp_var['Name'];
				$this->Infos[$tmp_var['Name']]['Type'] 				= $tmp_var['Type'];
				$this->Infos[$tmp_var['Name']]['Row_Format'] 		= $tmp_var['Row_format'];
				$this->Infos[$tmp_var['Name']]['Rows'] 				= $tmp_var['Rows'];
				$this->Infos[$tmp_var['Name']]['Avg_Row_Length'] 	= $tmp_var['Avg_row_length'];
				$this->Infos[$tmp_var['Name']]['Data_Length'] 		= $tmp_var['Data_length'];
				$this->Infos[$tmp_var['Name']]['Max_Data_Length'] 	= $tmp_var['Max_data_length'];
				$this->Infos[$tmp_var['Name']]['Index_Length'] 		= $tmp_var['Index_length'];
				$this->Infos[$tmp_var['Name']]['Data_Free'] 		= $tmp_var['Data_free'];
				$this->Infos[$tmp_var['Name']]['Auto_Increment'] 	= isset($tmp_var['Auto_increment']) ? $tmp_var['Auto_increment'] : '';
				$this->Infos[$tmp_var['Name']]['Create_Time'] 		= $tmp_var['Create_time'];
				$this->Infos[$tmp_var['Name']]['Update_Time']		= isset($tmp_var['Update_time']) ? $tmp_var['Update_time'] : '';
				$this->Infos[$tmp_var['Name']]['Check_Time'] 		= isset($tmp_var['Check_time']) ? $tmp_var['Check_time'] : '';
				$this->Infos[$tmp_var['Name']]['Comment'] 			= $tmp_var['Comment'];
				$tbls_counter++;

			}
			$this->Infos['Number_Of_Tables'] = $tbls_counter;
		}
		else {
			$result = mysql_list_tables($this->Database);
			$tbls_counter = 0;
			if ($this->Database != '') {
				while ($row = mysql_fetch_row($result)) {
	        		$this->Infos['Tables_List'][] = $row[0];
	        		$this->query("SELECT COUNT(*) FROM ".sql_back_ticks($row[0], $this));
	        		list($this->Infos[$row[0]]['Rows']) = $this->next_record();
	        		$this->Infos[$row[0]]['Type'] 				= '';
					$this->Infos[$row[0]]['Row_Format'] 		= '';
					$this->Infos[$row[0]]['Avg_Row_Length'] 	= '';
					$this->Infos[$row[0]]['Data_Length'] 		= '';
					$this->Infos[$row[0]]['Max_Data_Length'] 	= '';
					$this->Infos[$row[0]]['Index_Length'] 		= '';
					$this->Infos[$row[0]]['Data_Free'] 			= '';
					$this->Infos[$row[0]]['Auto_Increment'] 	= '';
					$this->Infos[$row[0]]['Create_Time'] 		= '';
					$this->Infos[$row[0]]['Update_Time']		= '';
					$this->Infos[$row[0]]['Check_Time'] 		= '';
					$this->Infos[$row[0]]['Comment'] 			= '';
	        		$tbls_counter++;

	    		}
    			$this->Infos['Number_Of_Tables'] = $tbls_counter;
    		}


		}
	}

	function getTblsInfos() {
		return $this->Infos;
	}
}
?>