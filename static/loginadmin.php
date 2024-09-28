<?php
session_start();

function authenticateAdmin($username, $password, $xml) {
    // XPath to find the admin user
    $xpathQuery = "//user[@username='admin' and @role='admin']";
    $user = $xml->xpath($xpathQuery);

    if ($user && isset($user[0]['password'])) {
        $storedPassword = (string) $user[0]['password'];

        // Verify the entered password against the stored plain text password
        if ($password === $storedPassword && isset($user[0]['username'])) {
            return true; // Authentication successful for admin
        }
    }

    return false; // Authentication failed
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $xml = simplexml_load_file('xml/DATA2.xml'); // Replace with the actual path
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Authenticate the admin user
    $authenticated = authenticateAdmin($username, $password, $xml);

    if ($authenticated) {
        // Redirect to the admin dashboard after successful login
        header("Location: panel.php");
        exit;
    } else {
        ?>
        <div class="alert alert-danger" role="alert">
            Attention! Les informations sont incorrectes.
        </div>
        <?php
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
                            <h1 class="h2"><strong>Salut Admin!</strong></h1>
                            <p class="lead">
                                <strong>
                                Veuillez s'authentifier pour accéder à votre Dashboard
                                </strong>
                            </p>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="m-sm-3">
                                    
                                    <form  method="POST" enctype="multipart/form-data">
                                        <div class="mb-3">
                                            <label class="form-label" for="username">Username</label>
                                            <input class="form-control form-control-lg" type="text" name="username"
                                                placeholder="Enter your username" id="username" />
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label" for="password">Password</label>
                                            <input class="form-control form-control-lg" type="password"
                                                name="password" placeholder="Enter your password" id="password"/>
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
                        
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div id="alertContainer"></div> <!-- Container for Bootstrap alert -->

    <script src="js/app.js"></script>
</body>

</html>
