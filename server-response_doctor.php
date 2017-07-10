<?php
if(!isset($_SESSION))
{
  session_start();
  if(!($_SESSION['email'] && $_SESSION['email_key'] ) )
  {
    session_destroy();
      header("Location: login.php");//redirect to login page to secure the welcome page without login access.
  }
}
?>

<?php
    /*
     * Script:    DataTables server-side script for PHP and mysqli
     * Copyright: 2010 - Allan Jardine, 2012 - Chris Wright
     * License:   GPL v2 or BSD (3-point)
     */

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * Easy set variables
     */

    /* Array of database columns which should be read and sent back to DataTables. Use a space where
     * you want to insert a non-database field (for example a counter or static image)
     */
  $aColumns = array( 'doctor_id','firstname' ,'lastname', 'areaname', 'city');
//     $aColumns = array('Test_case_idpk', 'Component', 'Iteration', 'Feature_Name', 'Module', 'TC_Prerequisites', 'Test_Case_ID');

    /* Indexed column (used for fast and accurate table cardinality) */
    $sIndexColumn = "doctor_id";

    /* DB table to use */
    $sTable = "doctors";

    /* Database connection information */
    $gaSql['user']       = "sadai";
    $gaSql['password']   = "sadai";
    $gaSql['db']         = "hms";
    $gaSql['server']     = "localhost";


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
     * mysqli connection
     */
    if ( ! $gaSql['link'] = mysqli_connect( $gaSql['server'], $gaSql['user'], $gaSql['password']  ) )
    {
        fatal_error( 'Could not open connection to server' );
    }

    if ( ! mysqli_select_db(  $gaSql['link'] , $gaSql['db']))
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
                $sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
                    ".($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
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
     * on very large tables, and mysqli's regex functionality is very limited
     */
    $sWhere = "";
    if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
    {
        $sWhere = "WHERE (";
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
            if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" )
            {
                $sWhere .= $aColumns[$i]." LIKE '%".mysqli_real_escape_string( $_GET['sSearch'] )."%' OR ";
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
            $sWhere .= $aColumns[$i]." LIKE '%".mysqli_real_escape_string($_GET['sSearch_'.$i])."%' ";
        }
    }


    /*
     * SQL queries
     * Get data to display
     */
    $sQuery = "
        SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
        FROM   $sTable
        $sWhere
        $sOrder
        $sLimit
    ";
    $rResult = mysqli_query( $gaSql['link'], $sQuery ) or fatal_error( 'mysqli Error: ' . mysqli_errno($gaSql['link']) );

    /* Data set length after filtering */
    $sQuery = "
        SELECT FOUND_ROWS()
    ";
    $rResultFilterTotal = mysqli_query( $gaSql['link'], $sQuery ) or fatal_error( 'mysqli Error: ' . mysqli_errno($gaSql['link']) );
    $aResultFilterTotal = mysqli_fetch_array($rResultFilterTotal);
    $iFilteredTotal = $aResultFilterTotal[0];

    /* Total data set length */
    $sQuery = "
        SELECT COUNT(".$sIndexColumn.")
        FROM   $sTable
    ";
    $rResultTotal = mysqli_query( $gaSql['link'], $sQuery ) or fatal_error( 'mysqli Error: ' . mysqli_errno($gaSql['link']) );
    $aResultTotal = mysqli_fetch_array($rResultTotal);
    $iTotal = $aResultTotal[0];


    /*
     * Output
     */
    /*
	$output = array(
        "sEcho" => intval($_GET['sEcho']),
        "iTotalRecords" => $iTotal,
        "iTotalDisplayRecords" => $iFilteredTotal,
        "aaData" => array()
    );
	*/


    while ( $aRow = mysqli_fetch_array( $rResult ) )
    {
		$id =array();
        $row = array();
        for ( $i=0 ; $i<=count($aColumns) ; $i++ )
        {

			if($i==count($aColumns))
			{
        $strtemp = generateRandomString().",".$aRow[$aColumns[0]].",".generateRandomString();
				 $row[] = "<a data-toggle='modal' href='#'><button type='button' name='editmodule_id-modal_btn' onclick='editRow(\"".base64_encode($strtemp)."\")' id='editmodule_id-modal_bt' class='btn btn-success btn-xs'>Edit</button></a>".
        "<a data-toggle='modal' href='#'><button  type='button' onclick='delete_module(\"".base64_encode($strtemp)."\")' class='btn btn-danger btn-xs'>Delete</button></a>";
			}
			else{

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

        }
        $output['aaData'][] = $row;
    }

    echo json_encode( $output );
?>

<?php
function generateRandomString($length = 10) {
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}
?>
