<?php

require_once('DataProcessing.class.php');

function ImportCSV($filename) {
	$file = new SplFileObject($filename);
	$file->setFlags(SplFileObject::DROP_NEW_LINE);
	$file->setCsvControl(',',"\"","\\");
	return new InMemoryDataSet($file);
}

$dataSet = ImportCSV("examples__284_29.csv");
$query = new DataProcessing($dataSet);
$query->processData();

?>