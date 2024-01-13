<?php
session_start();

// Load XML file
$xml = simplexml_load_file('xml/DATA2.xml');

if (!isset($_SESSION['professorDepartment'])) {
    // Redirect to login page if not authenticated
    header("Location: loginprof.php"); // Change to the actual login page
    exit;
}

$professorUsername = $_SESSION['professorUsername'];
$professor = $xml->xpath("//professeur[@username='$professorUsername']");

if (!empty($professor)) {
    $professor = $professor[0];
    $professorDepartment = (int)$professor['department'];

    // Retrieve students data
    $students = [];
    foreach ($xml->applications->application as $application) {
        $studentUsername = (string)$application['student'];
        $applicationStatus = (string)$application['status'];
        $studentFiliereID = (int)$application->details2->filiere;

        // Check conditions: accepted status and matching department
        $studentDepartment = (int)$xml->filieres->filiere[$studentFiliereID - 101]['department'];
        if ($applicationStatus === 'acceptée' && $studentDepartment === $professorDepartment) {
        
            $student = $xml->xpath("//student[@username='$studentUsername']");

            if (!empty($student)) {
                $student = $student[0];
                $students[] = [
                    'id' => (int)$student['id'],
                    'username' => $studentUsername,
                    'fullname' => $student->details->fullname->fname . ' ' . $student->details->fullname->lname,
                    'birthdate' => (string)$student->details->birthdate,
                    'tel' => (string)$student->details->tel,
                    'email' => (string)$student->details->email,
                    'cin' => (string)$student->details->cin,
                    'cne' => (string)$student->details->cne,
                    'apoge' => (string)$student->details->apoge,
                    'adresse' => (string)$student->details->adresse,
                    'mark' => (float)$student->details->mark,
                ];
            } else {
                echo "Student not found for username: $studentUsername<br>";
            }
        }
    }
} else {
    echo "Professor not found for username: $professorUsername<br>";
}

// Handle form submission to update marks
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentId = (int)$_POST['student_id'];
    $updatedMark = (float)$_POST['updated_mark'];

    // Update the mark in XML
    $studentToUpdate = $xml->xpath("//student[@id='$studentId']");
    if (!empty($studentToUpdate)) {
        $studentToUpdate = $studentToUpdate[0];
        $studentToUpdate->details->mark = $updatedMark;

        // Save changes to XML file
        $xml->asXML('xml/DATA2.xml');

        // Redirect to refresh the page and reflect the changes
        header("Location: {$_SERVER['PHP_SELF']}");
        exit;
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

    <link rel="canonical" href="https://demo-basic.adminkit.io/" />

    <title>Professor Dashboard</title>

    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        main {
            background-image: url('img/photos/backgroundzlij.jpg');
            background-size: auto;
            background-position: center;
            margin: 0;
            padding: 0;
        }

        .table-container {
            width: 100%;
            max-height: 500px; /* Adjust the height as needed */
            overflow-y: auto;
        }

        /* Add the following styles for the update mark form */
        .update-mark-form {
            display: flex;
            gap: 5px;
            margin-bottom: 10px;
        }

        .update-mark-form input[type="text"] {
            padding: 5px;
        }

        .update-mark-form button {
            padding: 5px 10px;
            background-color: green;
            color: #fff;
            border: none;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <nav id="sidebar" class="sidebar js-sidebar">
            <div class="sidebar-content js-simplebar">
                <a class="sidebar-brand" href="index.html">
                    <span class="align-middle">Dashboard Admin</span>
                </a>

                <ul class="sidebar-nav">
                   
                    <li class="sidebar-header">
                        Pages
                    </li>

                    <li class="sidebar-item active">
                        <a class="sidebar-link" href="listeetudiants.php">
                            <i class="align-middle" data-feather="user"></i> <span class="align-middle">Liste Etudiants</span>
                        </a>
                    </li>
                </ul>

            </div>
        </nav>
        <div class="main">
            <nav class="navbar navbar-expand navbar-light navbar-bg">
                <a class="sidebar-toggle js-sidebar-toggle">
                    <i class="hamburger align-self-center"></i>
                </a>

                <!-- Replace this block in your HTML -->
                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav navbar-align">
                        <?php if (!empty($professor)): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                                    <i class="align-middle" data-feather="settings"></i>
                                </a>
                                <img src="img/photos/estlogo.png" class="avatar img-fluid rounded me-1" alt="Professor Photo" />
                                <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                                    <?php echo $professor->details3->fullname->fname . ' ' . $professor->details3->fullname->lname; ?>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="loginprof.php">Log out</a>
                                </div>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </nav>
            <main class="content">
                <div class="container-fluid p-0">

                    <h1 class="h3 mb-3"><strong>Votre liste </strong>des étudiants</h1>

                    <div class="card">
                        <h5 class="card-header">Liste</h5>

                        <div class="table-responsive text-nowrap">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Username</th>
                                        <th>Fullname</th>
                                        <th>Date de naissance</th>
                                        <th>Tel</th>
                                        <th>Email</th>
                                        <th>CIN</th>
                                        <th>CNE</th>
                                        <th>Numero apogé</th>
                                        <th>adresse</th>
                                        <th>Note</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($students as $student) : ?>
                                        <tr>
                                            <td><?= $student['id']; ?></td>
                                            <td><?= $student['username']; ?></td>
                                            <td><?= $student['fullname']; ?></td>
                                            <td><?= $student['birthdate']; ?></td>
                                            <td><?= $student['tel']; ?></td>
                                            <td><?= $student['email']; ?></td>
                                            <td><?= $student['cin']; ?></td>
                                            <td><?= $student['cne']; ?></td>
                                            <td><?= $student['apoge']; ?></td>
                                            <td><?= $student['adresse']; ?></td>
                                            <td><?= $student['mark'] === 0 ? 'N/A' : $student['mark']; ?></td>
                                            <td>
                                                <!-- Update mark form -->
                                                <form class="update-mark-form" action="" method="post">
                                                    <input type="hidden" name="student_id" value="<?= $student['id']; ?>">
                                                    <input type="text" name="updated_mark" placeholder="Changer la note">
                                                    <button type="submit">Valider</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row text-muted">
                        <div class="col-6 text-start">
                            <p class="mb-0">
                                <a class="text-muted" href="http://www.ests.uca.ma/" target="_blank"><strong>EST Safi</strong></a>
                                <a class="text-muted" href="https://adminkit.io/" target="_blank"><strong></strong></a>
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="js/app.js"></script>

</body>

</html>
