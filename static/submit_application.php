<?php
// Read the raw POST data
$data = file_get_contents("php://input");
$data = urldecode($data);

// Parse the data into an associative array
parse_str($data, $formData);

// Validate and sanitize the form data (you should add proper validation)
$username = htmlspecialchars($formData['username']);
$firstName = htmlspecialchars($formData['firstName']);
$cne = htmlspecialchars($formData['cne']);
$apoge = htmlspecialchars($formData['apoge']);
$filiere = htmlspecialchars($formData['filiere']);

// Load the XML file
$xml = simplexml_load_file('DATA2.xml');

// Create a new student element
$newStudent = $xml->students->addChild('student');
$newStudent->addAttribute('username', $username);

// Add details for the new student
$newStudentDetails = $newStudent->addChild('details');
$newStudentDetails->addChild('fullname')->addChild('fname', $firstName);
// Add other details based on your XML structure

// Add academic information to the application section
$newApplication = $xml->applications->addChild('application');
$newApplication->addAttribute('student', $username);
$newApplication->addAttribute('status', 'pending');
$newApplicationDetails = $newApplication->addChild('details2');
$newApplicationDetails->addChild('filiere', $filiere);
// Add other academic details based on your XML structure

// Save the updated XML file
$xml->asXML('DATA2.xml');

// Return a success message
echo "Application submitted successfully!";
?>
