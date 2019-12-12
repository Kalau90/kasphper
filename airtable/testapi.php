<?php

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
			$val = $record->fields->$idcol;
			$joints[$colname][$id] = $val;
			$str.= '"name": "'.($val).'"';
			foreach($addcol as $mycol){
				$str.= ', "'.$mycol.'": "'.($record->fields->$mycol).'"';
			}
			$str.= '},';
		}
		//$str = substr($str, 0, -2);

	}
	while( $joints_request = $joints_response->next() );
	echo substr($str, 0, -1);
	echo "]');\n";
}

function loadTable($tablename, $keyname, $ignores = array()){
	global $joints;
	global $airtable;

	/* PRAKSISEKSEMPLER */
	$params = array(
		"filterByFormula" => "AND( ".$keyname." != '')",
		"sort" => array(array('field' => $keyname, 'direction' => 'asc'))
	);

	$request = $airtable->getContent( $tablename, $params );

	$str = "var ".$tablename." = JSON.parse('[";

	do {
		$response = $request->getResponse();
		foreach($response[ 'records' ] as $record){
			/*$str.= '{';
			foreach($record->fields as $key => $val){
				if(is_array($val)){
					if(array_key_exists($key, $joints)){
				//		$str .= "JA";
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
			$str.= '},';*/
			print_r($record);
		}
	}
	while( $request = $response->next() );

	echo substr($str, 0, -1);
	echo "]');";
}

loadTable('Praksis', 'Name', array("Kommentarer")); // ignore = "";

?>