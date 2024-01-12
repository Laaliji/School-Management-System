<?php
// Load XML file
$xml = new DOMDocument;
$xml->load('xml/DATA2.xml');

// Create XSLT processor
$xsl = new DOMDocument;
$xsl->load('xml/admin_dashboard.xsl');

// Create XSLT processor and load XSL stylesheet
$proc = new XSLTProcessor;
$proc->importStyleSheet($xsl);

// Create a new DOMDocument for the transformed XML
$transformedXml = new DOMDocument;

// Load only the relevant portion of the XML data (professeurs)
$professeurs = $xml->getElementsByTagName('professeurs')->item(0);
$transformedXml->appendChild($transformedXml->importNode($professeurs, true));

// Transform XML data using XSLT
$html = $proc->transformToXML($transformedXml);

// Send the transformed HTML to the browser
echo $html;
?>
