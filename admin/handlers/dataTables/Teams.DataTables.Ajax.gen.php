<?php
	//example core include
	require_once($_SERVER['DOCUMENT_ROOT'] . '/assets/classes/core.php');
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */
	
	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 */
	$aColumns = array('GameId','UserId','TeamId','Description');
	
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = 'TeamId';
	
	/* custom search elements */
	/* example
		$column1 = $_GET['txtColumn1'];
		$column2 = $_GET['txtColumn2'];
	*/
	
	/* DB table to use */
	$sTable = 'Teams';
	
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
