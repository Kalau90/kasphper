<?php
$airtable_login = array(
    'api_key'   => 'keyK9H1XTdu0nJB4j',
    'base'      => 'appbJWdkuvOgHMbTl',
);

include("autoapi.php");

// brug newJoint til at tilføje en ny tabel med krydsreferencer
// Formen for newJoint (tabelname, colname), hvor:
// "tablename" er tabelnavn på reference-tabellen i AirTable
// "colname" er kolonne-navn i hoved-tabellen

newJoint('Maalgruppe', 'Maalgruppe');
newJoint('Format', 'Format');
newJoint('Vaerktojer', 'Vaerktojer');
newJoint('Sprog', 'Sprog');

loadTable('Kurser', 'Name', array("Kommentarer")); // ignore = "";
?>