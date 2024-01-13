<?php
session_start();

function authenticateUser($username, $password, $enteredEmail, $xml) {
    // XPath to find the user with the specified username
    $xpathQuery = "//user[@username='" . htmlspecialchars($username, ENT_QUOTES) . "']";
    $user = $xml->xpath($xpathQuery);

    if ($user && isset($user[0]['password'])) {
        $storedPassword = (string) $user[0]['password'];

        // Verify the entered password against the stored plain text password
        if ($password === $storedPassword && isset($user[0]['username'])) {
            $role = (string) $user[0]['role'];

            // Check if the user is an admin
            if ($role === 'student') {
                return true; // Authentication successful for admin
            }

            // If not an admin, check for student role
            if ($role === 'student') {
                $studentId = (string) $user[0]['username'];

                // Now find the corresponding student by user ID
                $student = $xml->xpath("//student[@username='{$studentId}']");

                if ($student && isset($student[0]->details->email)) {
                    // Extract email from student details
                    $correctEmail = (string) $student[0]->details->email;

                    // Check if entered email matches the correct email
                    if ($enteredEmail == $correctEmail) {
                        return true; // Authentication successful for student
                    }
                }
            }
        }
    }

    return false; // Authentication failed
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $xml = simplexml_load_file('xml/DATA2.xml'); // Replace with the actual path
    $username = $_POST["username"];
    $password = $_POST["password"];
    $enteredEmail = $_POST["email"];

    // Authenticate the user
    $authenticated = authenticateUser($username, $password, $enteredEmail, $xml);

    if ($authenticated) {
        // Redirect based on the user's role
        $role = (string) $xml->xpath("//user[@username='{$username}']/@role")[0];
        if ($role === 'student') {
            header("Location: index.php");
        } 
        } else {
            echo "Invalid role!";
        }
        exit;
    } else {
        ?> 
            
        
        <?php
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

    <title>Sign In</title>

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
                            <h1 class="h2"><strong>Salut Cher Etudiant!</strong> </h1>
                            <p class="lead">
                            <strong>Veuillez s'authentifier pour compléter votre candidature.</strong>
                            </p>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="m-sm-3">
                                    
                                    <form  method="POST" enctype="multipart/form-data">
                                        <div class="mb-3">
                                            <label class="form-label" for="username">Username</label>
                                            <input class="form-control form-control-lg" type="text" name="username"
                                                placeholder="Enter your username" id="username" required/>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="email">Email</label>
                                            <input class="form-control form-control-lg" type="email" name="email"
                                                placeholder="Enter your email" id="email" required/>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="password">Password</label>
                                            <input class="form-control form-control-lg" type="password"
                                                name="password" placeholder="Enter your password" id="password" required/>
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
                                            <button class="btn btn-lg btn-primary" type="submit" name="btn">Log In</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mb-3">
                            Don't have an account? <a href="signupstudent.php">Sign up</a>
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
