<?php
$airtable_login = array(
    'api_key'   => 'keyK9H1XTdu0nJB4j',
    'base'      => 'appaYuZQVSoSTfJfN',
);

include("../autoapi.php");

// brug newJoint til at tilføje en ny tabel med krydsreferencer
// Formen for newJoint (tabelname, colname), hvor:
// "tablename" er tabelnavn på reference-tabellen i AirTable
// "colname" er kolonne-navn i hoved-tabellen

newJoint('Undervisningsformer', 'Undervisningsformer');
newJoint('Fokusomraader', 'Fokusomraader');
newJoint('Fakultet', 'Fakultet');
newJoint('Fremtidige', 'Fremtidige');
newJoint('Teknologi', 'Teknologi');

loadTable('Aktivitet', 'Name', array("Kommentarer")); // ignore = "";
?>