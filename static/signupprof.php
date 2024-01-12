<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

session_start();

function createProfessor($data) {
    $xmlFile = 'xml/DATA2.xml';

    // Check if the XML file exists before loading it
    if (file_exists($xmlFile)) {
        $xml = simplexml_load_file($xmlFile);

        // Check if loading the XML file was successful
        if ($xml) {
            // Check if the username, email, and cin are unique
            if (isUniqueProfessor($xml, $data['username'], $data['email'], $data['cin'])) {
                // Generate a new ID for the professor based on the existing IDs
                $existingIds = $xml->xpath('//professeur/@id');
                $maxId = 0;

                foreach ($existingIds as $existingId) {
                    $id = (int)$existingId;
                    if ($id > $maxId) {
                        $maxId = $id;
                    }
                }

                $newId = $maxId + 1;

                // Create a new user node
                $newUser = $xml->users->addChild('user');
                $newUser->addAttribute('username', $data['username']);
                $newUser->addAttribute('password', $data['password']);
                $newUser->addAttribute('role', 'professor');

                // Create a new professor node
                $newProfessor = $xml->professeurs->addChild('professeur');
                $newProfessor->addAttribute('id', $newId); // Use the new generated ID for the professor
                $newProfessor->addAttribute('department', $data['department']);
                $newProfessor->addAttribute('username', $data['username']);

                // Add details to the new professor
                $newDetails = $newProfessor->addChild('details3');
                $newDetails->addChild('fullname')->addChild('fname', $data['firstname']);
                $newDetails->fullname->addChild('lname', $data['lastname']);
                $newDetails->addChild('birthdate', $data['birthdate']);
                $newDetails->addChild('tel', $data['tel']);
                $newDetails->addChild('email', $data['email']);
                $newDetails->addChild('cin', $data['cin']);

                // Save the changes to the XML file
                $xml->asXML($xmlFile);

                // Debug: Check if the data is retrieved
                echo "Data retrieved successfully.";

                // Redirect to indexprof.php after successful signup
                header('Location: http://localhost/SchoolManagement/static/loginprof.php');
                exit;
            } else {
                // Debug: Username, email, or cin is not unique
                $errorMessage = "Username, email, or cin is already in use.";
                echo "<script>alert('$errorMessage');</script>";
            }
        } else {
            // Debug: Check if there is an error loading the XML file
            echo "Failed to load XML file.";
        }
    } else {
        // Debug: Check if the XML file exists
        echo "XML file does not exist.";
    }
}

function isUniqueProfessor($xml, $username, $email, $cin) {
    // Check if the username, email, and cin are unique among professors
    $existingUsernames = $xml->xpath('//professeur/@username');
    $existingEmails = $xml->xpath('//professeur/details3/email');
    $existingCINs = $xml->xpath('//professeur/details3/cin');

    return !in_array($username, $existingUsernames) &&
           !in_array($email, $existingEmails) &&
           !in_array($cin, $existingCINs);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['signup'])) {
        // Sign-up form is submitted
        $signupData = [
            'username' => $_POST['username'],
            'password' => $_POST['password'],
            //'department' => $_POST['department'], // Assuming a department field in the form
            'firstname' => $_POST['firstname'],
            'lastname' => $_POST['lastname'],
            'birthdate' => $_POST['birthdate'],
            'tel' => $_POST['tel'],
            'email' => $_POST['email'],
            'cin' => $_POST['cin']
        ];

        // Create the new professor
        createProfessor($signupData);
    }
}
?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    <meta name="author" content="AdminKit">
    <meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="img/icons/icon-48x48.png" />

    <link rel="canonical" href="https://demo-basic.adminkit.io/pages-sign-in.html" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Sign Up</title>

    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<style>
    body {
            background-image: url('img/photos/backgroundzlij.jpg');
            background-size:auto;
            background-position: center;
            margin: 0;
            padding: 0;
        }
</style>

<body>
    <main class="d-flex w-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">

                        <div class="text-center mt-4">
                            <h1 class="h2">Sign Up</h1>
                            <p class="lead">
                               <strong>Veuillez remplir ces informations pour créer votre compte</strong>
                            </p>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="m-sm-3">
                                    
                                    <form method="POST" action="signup.php" enctype="multipart/form-data">
                                        <div class="mb-3">
                                            <label class="form-label" for="username">Username</label>
                                            <input class="form-control form-control-lg" type="text" name="username"
                                                placeholder="Enter your username" id="username" required/>
                                        </div>
										<div class="mb-3">
                                            <label class="form-label" for="lastname">Nom</label>
                                            <input class="form-control form-control-lg" type="text" name="lastname"
                                                placeholder="Nom" id="lastname" required/>
                                        </div>
										<div class="mb-3">
                                            <label class="form-label" for="firstname">Prénom</label>
                                            <input class="form-control form-control-lg" type="text" name="firstname"
                                                placeholder="Prénom" id="firstname" required/>
                                        </div>
										<div class="mb-3">
                                            <label class="form-label" for="birthdate">Date de naissance</label>
                                            <input class="form-control form-control-lg" type="date" name="birthdate"
                                                placeholder="Date de naissance" id="birthdate" required/>
                                        </div>
										<div class="mb-3">
                                            <label class="form-label" for="tel">Numéro de téléphone</label>
                                            <input class="form-control form-control-lg" type="text" name="tel"
                                                placeholder="Numéro de téléphone" id="tel" required/>
                                        </div>
										<div class="mb-3">
                                            <label class="form-label" for="cin">CIN</label>
                                            <input class="form-control form-control-lg" type="text" name="cin"
                                                placeholder="CIN" id="cin" required/>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="email">Email</label>
                                            <input class="form-control form-control-lg" type="email" name="email"
                                                placeholder="Email" id="email" required/>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="password">Mot de passe</label>
                                            <input class="form-control form-control-lg" type="password"
                                                name="password" placeholder="Mot de passe" id="password" required/>
                                        </div>
                                        <div>
                                            <div class="form-check align-items-center">
                                                <input id="customControlInline" type="checkbox"
                                                    class="form-check-input" value="remember-me" name="remember-me" checked>
                                                <label class="form-check-label text-small"
                                                    for="customControlInline">Remember me</label>
                                            </div>
                                        </div>
                                        <div class="d-grid gap-2 mt-3">
                                            <button class="btn btn-lg btn-primary" type="submit" name="signup">Sign Up</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mb-3">
                            Vous avez déjà un compte ? <a href="loginprof.php">Log In</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div id="alertContainer"></div> <!-- Container for Bootstrap alert -->

    <script src="js/app.js"></script>
</body>

</html>
