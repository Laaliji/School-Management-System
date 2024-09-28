<?php
// Load XML file
$xml = simplexml_load_file('xml/DATA2.xml');

// Your other PHP logic here

// Load XSL file
$xsl = new DOMDocument;
$xsl->load('xml/panel.xsl');

// Configure the transformer
$proc = new XSLTProcessor;
$proc->importStyleSheet($xsl);

// Output result of transformation
echo $proc->transformToXML($xml);
?>
