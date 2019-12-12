<?php
$airtable_login = array(
    'api_key'   => 'keyK9H1XTdu0nJB4j',
    'base'      => 'appuTkKn1beBN5hrv',
);

function getHttpVar($key, $default){
	if(isset($_GET[$key])){
		return $_GET[$key];
	}
	return $default;
}

$lang = getHttpVar("lang", "da");
$table = getHttpVar("table", "praksis");

include("../autoapi.php");

// brug newJoint til at tilføje en ny tabel med krydsreferencer
// Formen for newJoint (tabelname, colname), hvor:
// "tablename" er tabelnavn på reference-tabellen i AirTable
// "colname" er kolonne-navn i hoved-tabellen

$lang_col = "Name";
if($lang == "en"){
	$lang_col = "engelskname";
}

if($table == "aktivitet"){
	newJoint('Undervisningsformer', 'Undervisningsformer', $lang_col);
	newJoint('Fokusomraader', 'Fokusomraader', $lang_col);
	newJoint('Fakultet', 'Fakultet', $lang_col);
	newJoint('Fremtidige', 'Fremtidige', $lang_col);
	newJoint('Teknologi', 'Teknologi', $lang_col);
	loadTable('Aktivitet', $lang_col, array("Kommentarer")); // ignore = "";
}elseif($table == "praksis"){
	newJoint('Undervisningsformer', 'Undervisningsformer', $lang_col);
	newJoint('Fokusomraader', 'Fokusomraader', $lang_col);
	newJoint('Fakultet', 'Fakultet', $lang_col);
	loadTable('Praksis', $lang_col, array("Kommentarer")); // ignore = "";
}
?>