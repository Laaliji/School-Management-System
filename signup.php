<?php

function addUser($username, $password, $role, $cin, $cne, $apoge, $fname, $lname, $birthdate, $tel, $email) {
    $xml = simplexml_load_file('xml/DATA.xml');

    // Check if the user already exists
    $existingUser = $xml->xpath("//user[@username='$username']");

    if ($existingUser) {
        // Update existing user details
        $existingUser[0]['password'] = $password;
        $existingUser[0]['role'] = $role;
    } else {
        // Create a new user element
        $newUser = $xml->users->addChild('user');
        $newUser->addAttribute('username', $username);
        $newUser->addAttribute('password', $password);
        $newUser->addAttribute('role', $role);
    }

    // Save the changes to the XML file for the users section
    $xml->asXML('xml/DATA.xml');

    // Create a new application element
    $newApplication = $xml->applications->addChild('application');
    $newApplication->addAttribute('student', $username);
    $newApplication->addAttribute('status', 'pending');

    // Add details under the new application
    $details = $newApplication->addChild('details');
    $details->addChild('fullname')->addChild('fname', $fname);
    $details->fullname->addChild('lname', $lname);
    $details->addChild('birthdate', $birthdate);
    $details->addChild('tel', $tel);
    $details->addChild('email', $email);
    $details->addChild('cin', $cin);
    $details->addChild('cne', $cne);
    $details->addChild('apoge', $apoge);

    // Save the changes to the XML file for the applications section
    $xml->asXML('xml/DATA.xml');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the signup form
    $username = $_POST["username"];
    $password = $_POST["password"]; // Assuming your password field is named "pass"
    $role = "student"; // Set the role to "student" for new signups

    $cin = $_POST["cin"];
    $cne = $_POST["cne"];
    $apoge = $_POST["apoge"];
    $fname = $_POST["firstname"];
    $lname = $_POST["lastname"];
    $birthdate = $_POST["date"];
    $tel = $_POST["tel"];
    $email = $_POST["email"];

    // Call the addUser function to add the new user to the XML
    addUser($username, $password, $role, $cin, $cne, $apoge, $fname, $lname, $birthdate, $tel, $email);

    // Provide a success message or redirect to a success page
    echo "User registration successful!";
} else {
    // If not a POST request, handle accordingly (optional)
    echo "Invalid request method.";
}

?>
