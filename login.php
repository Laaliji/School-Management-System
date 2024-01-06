<?php

function authenticateUser($username, $password, $enteredEmail) {
    $xml = simplexml_load_file('xml/DATA.xml');

    // XPath to find the user with the specified username and password
    $xpathQuery = "//user[@username='{$username}' and @password='{$password}']";
    $user = $xml->xpath($xpathQuery);

    if ($user) {
        $studentId = (string)$user[0]['username'];

        // Find the corresponding student application
        $application = $xml->xpath("//application[@student='{$studentId}']");
        if ($application) {
            // Extract email from application details
            $correctEmail = (string)$application[0]->details->email;

            // Check if entered email matches the correct email
            if ($enteredEmail == $correctEmail) {
                return true; // Authentication successful
            }
        }
    }

    return false; // Authentication failed
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["your_pass"];
    $enteredEmail = $_POST["email"];

    // Authenticate the user
    if (authenticateUser($username, $password, $enteredEmail)) {
        // Successfully authenticated
        echo "Welcome! Authentication successful!";
    } else {
        // Authentication failed
        echo "Authentication failed. Please check your username, password, and email.";
    }
}
?>
