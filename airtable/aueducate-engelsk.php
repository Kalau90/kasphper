<?php
$airtable_login = array(
    'api_key'   => 'keyK9H1XTdu0nJB4j',
    'base'      => 'appuTkKn1beBN5hrv',
);

include("autoapi.php");

// brug newJoint til at tilføje en ny tabel med krydsreferencer
// Formen for newJoint (tabelname, colname), hvor:
// "tablename" er tabelnavn på reference-tabellen i AirTable
// "colname" er kolonne-navn i hoved-tabellen

newJoint('Undervisningsformer', 'Undervisningsformer', 'engelskname');
newJoint('Fokusomraader', 'Fokusomraader', 'engelskname');
newJoint('Fakultet', 'Fakultet', 'engelskname');

loadTable('Praksis', 'engelskname', array("Kommentarer")); // ignore = "";
?>