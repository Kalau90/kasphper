<?php
//$link = mysqli_connect(, "dynamiccases", 3306);
include("../logs.php");

echo $server;

// Create connection
/*$conn = new mysqli($server, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

$airtable_login = array(
    'api_key'   => 'keyK9H1XTdu0nJB4j',
    'base'      => 'appuTkKn1beBN5hrv',
);

/* if not using composer, uncomment this*/
include('Airtable.php');
include('Request.php');
include('Response.php');

//require 'vendor/autoload.php';

use TANIOS\Airtable\Airtable;

$airtable = new Airtable($airtable_login);

$joints = [];

function newJoint($tablename, $colname, $idcol = "Name", $addcol = array()){
	global $airtable;
	global $joints;
	$joint_params = array(
		"filterByFormula" => "AND( ".$idcol." != '')",
		"sort" => array(array('field' => $idcol, 'direction' => 'asc'))
	);
	$joints_request = $airtable->getContent( $tablename, $joint_params );
	$joints[$colname] = array();

	$str = "var ".$tablename." = JSON.parse('[";
	do {
		$joints_response = $joints_request->getResponse();
		foreach($joints_response[ 'records' ] as $record){
			$str.= '{';
			$id = $record->id;
			foreach($record->fields as $key => $val){
				if(is_array($val)){
					// if it is an array, it is a reference
				}elseif(!in_array($key, $ignores)){
					$str.= '"'.preg_replace("/\s/", "", $key).'": "'.preg_replace( "/\r|\n/", "<br>", htmlspecialchars($val, ENT_QUOTES)).'", '; //  
				}	
			}
			$str = substr($str, 0, -2);
			$str.= '},';
			$name_val = $record->fields->$idcol;
			$joints[$colname][$id] = $name_val;
		}

	}
	while( $joints_request = $joints_response->next() );
	echo substr($str, 0, -1);
	echo "]');\n";
}

function loadTable($tablename, $keyname, $ignores = array()){
	global $joints;
	global $airtable;

	$params = array(
		"filterByFormula" => "AND( ".$keyname." != '')",
		"sort" => array(array('field' => $keyname, 'direction' => 'asc'))
	);

	$request = $airtable->getContent( $tablename, $params );

	$str = "var ".$tablename." = JSON.parse('[";

	do {
		$response = $request->getResponse();
		foreach($response[ 'records' ] as $record){
			$str.= '{';
			foreach($record->fields as $key => $val){
				if(is_array($val)){
					if(array_key_exists($key, $joints)){
						$str .= '"'.$key.'": ';
						$str .= "[";
						for($v = 0; $v < sizeof($val); $v++){
							$str .= '"'.$joints[$key][$val[$v]].'", ';
						}
						$str = substr($str, 0, -2);
						$str .= "], ";
					}
				}elseif(!in_array($key, $ignores)){
					$str.= '"'.preg_replace("/\s/", "", $key).'": "'.preg_replace( "/\r|\n/", "<br>", htmlspecialchars($val, ENT_QUOTES)).'", '; //  
				}	
			}
			$str = substr($str, 0, -2);
			$str.= '},';
		}
	}
	while( $request = $response->next() );

	echo substr($str, 0, -1);
	echo "]');";
}

newJoint('Undervisningsformer', 'Undervisningsformer');
loadTable('Praksis', 'Name', array("Kommentarer")); // ignore = "";
?>