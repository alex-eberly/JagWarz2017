<?php
	//example core include
	require_once($_SERVER['DOCUMENT_ROOT'] . '/assets/classes/core.php');

	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */
	 
	 /* DB table to use */
	$sTable = 'Challenge';
	 
	 /* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = 'ChallengeId';
	
	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 */
	$aColumns = array('ChallengeId','Title','Description','CorrectAnswer','PointValue','IsComplete','IsOpen','Tags');
	/*$aColumns = array(
		array(
			'db' => 'ChallengeId', 'dt' => 'DT_RowId',
			'formatter' => function($d, $row){
				return 'row_'.$d;
			}
		),
		
		array('db' => 'Title', 'dt' => 0),
		array('db' => 'Description', 'dt' => 1),
		array('db' => 'CorrectAnswer', 'dt' => 2),
		array('db' => 'PointValue', 'dt' => 3),
		array('db' => 'IsComplete', 'dt' => 4),
		array('db' => 'IsOpen', 'dt' => 5),
		array('db' => 'Tags', 'dt' => 6)		
		
	);*/
	
	
	
	/* custom search elements */
	/* example
		$column1 = $_GET['txtColumn1'];		
	*/
	
	
	$GameId = $_GET['GameId'];
	
	
	
	/* Database connection information (optional) */
	
	
	$gaSql['user']       = $dbuser;
	$gaSql['password']   = $dbpassword;
	$gaSql['db']         = $db;
	$gaSql['server']     = $dbserver;
	
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * If you just want to use the basic configuration for DataTables with PHP server-side, there is
	 * no need to edit below this line
	 */
	
	/* 
	 * Local functions
	 */
	function fatal_error ( $sErrorMessage = '' )
	{
		header( $_SERVER['SERVER_PROTOCOL'] .' 500 Internal Server Error' );
		die( $sErrorMessage );
	}

	
	/* 
	 * MySQL connection
	 */
	if ( ! $gaSql['link'] = mysql_pconnect( $gaSql['server'], $gaSql['user'], $gaSql['password']  ) )
	{
		fatal_error( 'Could not open connection to server' );
	}

	if ( ! mysql_select_db( $gaSql['db'], $gaSql['link'] ) )
	{
		fatal_error( 'Could not select database ' );
	}

	/* 
	 * Paging
	 */
	$sLimit = "";
	if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
	{
		$sLimit = "LIMIT ".intval( $_GET['iDisplayStart'] ).", ".
			intval( $_GET['iDisplayLength'] );
	}
	
	
	/*
	 * Ordering
	 */
	$sOrder = "";
	if ( isset( $_GET['iSortCol_0'] ) )
	{
		$sOrder = "ORDER BY  ";
		for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
		{
			if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
			{
				$sOrder .= "`".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."` ".
					($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
			}
		}
		
		$sOrder = substr_replace( $sOrder, "", -2 );
		if ( $sOrder == "ORDER BY" )
		{
			$sOrder = "";
		}
	}
	
	
	/* 
	 * Filtering
	 * NOTE this does not match the built-in DataTables filtering which does it
	 * word by word on any field. It's possible to do here, but concerned about efficiency
	 * on very large tables, and MySQL's regex functionality is very limited
	 */
	$sWhere = "";
	if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
	{
		$sWhere = "WHERE (";
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" )
			{
				$sWhere .= "`".$aColumns[$i]."` LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
			}
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ')';
	}
	
	/* Individual column filtering */
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
		{
			if ( $sWhere == "" )
			{
				$sWhere = "WHERE ";
			}
			else
			{
				$sWhere .= " AND ";
			}
			$sWhere .= "`".$aColumns[$i]."` LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
		}
	}
	
	/* custom column filtering */
	//Commenting out this section in order to display all challenges.
	/*for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if (isset($GameId) && $GameId != '')
		{
			if ($aColumns[$i] == 'GameId')
			{
				if ( $sWhere == "" )
				{
					$sWhere = "WHERE ";
				}
				else
				{
					$sWhere .= " AND ";
				}
				$sWhere .= "`".$aColumns[$i]."` = '".mysql_real_escape_string($GameId)."' ";
			}
		}
	}*/
	
	/* custom column filtering */
	/* example
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if (isset($operator) && $operator != '')
			{
				if ($aColumns[$i] == 'CurrentOperator')
				{
					if ( $sWhere == "" )
					{
						$sWhere = "WHERE ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "`".$aColumns[$i]."` = '".mysql_real_escape_string($operator)."' ";
				}
			}
			if (isset($well) && $well != '')
			{
				if ($aColumns[$i] == 'CurrentWellName')
				{
					if ( $sWhere == "" )
					{
						$sWhere = "WHERE ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "`".$aColumns[$i]."` = '".mysql_real_escape_string($well)."' ";
				}
			}
		}
	*/
	
	/* filter deleted / inactive records */
	/* example
	if ( $sWhere == "" )
	{
		$sWhere = "WHERE ";
	}
	else
	{
		$sWhere .= " AND ";
	}
	$sWhere .= "`Active` = '1' ";
	*/
	
	/*
	 * SQL queries
	 * Get data to display
	 */
	/*$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS `".str_replace(" , ", " ", implode("`, `", $aColumns))."`
		FROM   $sTable
		$sWhere
		$sOrder
		$sLimit
		";
	$rResult = mysql_query( $sQuery, $gaSql['link'] ) or fatal_error( 'MySQL Error: ' . mysql_errno() );*/
	
	
	
	$sQuery = "
		SELECT Challenge.ChallengeId, Title, Description, CorrectAnswer, PointValue, IsComplete, IsOpen, Tags 
		FROM Challenge
		WHERE Challenge.ChallengeId NOT IN
			(SELECT GameChallenges.ChallengeId 
			FROM GameChallenges
			WHERE GameChallenges.GameId = " . $GameId . ")
		";
		$rResult = mysql_query( $sQuery, $gaSql['link'] ) or fatal_error( 'MySQL Error: ' . mysql_errno() );
		
		
	
	/*$sQuery = "
		SELECT Challenge.ChallengeId, Title, Description, CorrectAnswer, PointValue, IsComplete, IsOpen, Tags 
		FROM Challenge
		LEFT JOIN 
			(SELECT GameChallengeId, GameId, ChallengeId, RowPosition
			 FROM GameChallenges
			 WHERE GameId = " . $GameId . ") B
		ON B.ChallengeId = Challenge.ChallengeId
		
		";
	$rResult = mysql_query( $sQuery, $gaSql['link'] ) or fatal_error( 'MySQL Error: ' . mysql_errno() );*/
	
	/*$sQuery = "
			(SELECT GameChallengeId, GameId, ChallengeId, RowPosition
			 FROM GameChallenges
			 WHERE GameId = " . $GameId . ")
		
		";
	$rResult = mysql_query( $sQuery, $gaSql['link'] ) or fatal_error( 'MySQL Error: ' . mysql_errno() );*/
	
	/* Data set length after filtering */
	$sQuery = "
		SELECT FOUND_ROWS()
	";
	$rResultFilterTotal = mysql_query( $sQuery, $gaSql['link'] ) or fatal_error( 'MySQL Error: ' . mysql_errno() );
	$aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
	$iFilteredTotal = $aResultFilterTotal[0];
	
	/* Total data set length */
	$sQuery = "
		SELECT COUNT(`".$sIndexColumn."`)
		FROM   $sTable
		$sWhere
	";
	$rResultTotal = mysql_query( $sQuery, $gaSql['link'] ) or fatal_error( 'MySQL Error: ' . mysql_errno() );
	$aResultTotal = mysql_fetch_array($rResultTotal);
	$iTotal = $aResultTotal[0];
	
	
	/*
	 * Output
	 */
	$output = array(
		"sEcho" => intval($_GET['sEcho']),
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);

	
	while ( $aRow = mysql_fetch_array( $rResult ) )
	{
		$row = array();
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] == "version" )
			{
				/* Special output formatting for 'version' column */
				$row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ];
			}
			else if ( $aColumns[$i] != ' ' )
			{
				/* General output */
				$row[] = $aRow[ $aColumns[$i] ];
			}
		}
		$output['aaData'][] = $row;
	}
	
	echo json_encode( $output );
?>