<?php
// Load XML file
$xml = simplexml_load_file('xml/DATA2.xml');

// Retrieve students data
$students = $xml->xpath('//student');

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["process_application"])) {
    $studentId = $_POST["student_id"];
    $applicationStatus = $_POST["application_status"];

    // Find the student node
    $studentNode = $xml->xpath("//student[@id='{$studentId}']");

    if ($studentNode) {
        $studentUsername = (string) $studentNode[0]['username'];

        // Find the application for the current student
        $applicationNode = $xml->xpath("//application[@student='{$studentUsername}']");

        // Check if an application exists for the student
        if ($applicationNode) {
            $applicationNode = $applicationNode[0];

            // Update the application status
            $applicationNode['status'] = $applicationStatus;

            // Save the updated XML file
            $xml->asXML('xml/DATA2.xml');

            // Redirect or display success message as needed
            header("Location: etudiantsdashboard.php");
            exit();
        } else {
            echo "Application node not found for student ID: " . $studentId;
        }
    } else {
        echo "Student node not found for student ID: " . $studentId;
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

    <title>Admin Dashboard</title>

    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>
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
</style>

<body>
    <div class="wrapper">
        <nav id="sidebar" class="sidebar js-sidebar">
            <div class="sidebar-content js-simplebar">
                <a class="sidebar-brand" href="index.html">
                    <span class="align-middle">Dashboard Admin</span>
                </a>

                <ul class="sidebar-nav">
                    <li class="sidebar-header">
                        Admin Panel
                    </li>
                    <li class="sidebar-header">
                        Pages
                    </li>

                    <li class="sidebar-item active">
                        <a class="sidebar-link" href="etudiantsdashboard.php">
                            <i class="align-middle" data-feather="user"></i> <span class="align-middle">Etudiants</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="professeursdashboard.php">
                            <i class="align-middle" data-feather="user"></i> <span class="align-middle">Professeurs</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="departementsdashboard.php">
                            <i class="align-middle" data-feather="list"></i> <span class="align-middle">Départements</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="filieresdashboard.php">
                            <i class="align-middle" data-feather="bookmark"></i> <span class="align-middle">Filières</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="matieresdashboard.php">
                            <i class="align-middle" data-feather="book"></i> <span class="align-middle">Matières</span>
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

                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav navbar-align">

                        <li class="nav-item dropdown">
                            <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                                <i class="align-middle" data-feather="settings"></i>
                            </a>
                            <img src="img/photos/estlogo.png" class="avatar img-fluid rounded me-1" alt="Charles Hall" />
                            <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                                Admin
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">

                                <a class="dropdown-item" href="loginadmin.php">Log out</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <main class="content">
                <div class="container-fluid p-0">

                    <h1 class="h3 mb-3"><strong>Gestion</strong> des étudiants</h1>

                    <div class="card">
                        <h5 class="card-header">Liste d'attente des étudiants</h5>

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
                                        <th>Moyen régional</th>
                                        <th>Moyen national</th>
                                        <th>Moyen general</th>
                                        <th>Classement</th>
                                        <th>Mention</th>
                                        <th>Date d'obtention</th>
                                        <th>Ville</th>
                                        <th>Filière voulue</th>
                                        <th>Statut de candidature</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($students as $student): ?>
                                        <?php
                                        // Find the application for the current student
                                        $applicationNode = $xml->xpath("//application[@student='{$student['username']}']");

                                        // Check if an application exists for the student
                                        if ($applicationNode) {
                                            $applicationNode = $applicationNode[0];
                                        } else {
                                            // Set default values if no application is found
                                            $applicationNode = new SimpleXMLElement('<application><details2></details2></application>');
                                        }

                                        // Find the filière name based on the filière id in the application
                                        $filiereId = (string)$applicationNode->details2->filiere;
                                        $filiereName = $xml->xpath("//filieres/filiere[@id='{$filiereId}']/@name");
                                        $filiereName = $filiereName ? (string)$filiereName[0] : 'Unknown Filiere';
                                        ?>

                                        <tr>
                                            <td><?= (string)$student['id']; ?></td>
                                            <td><?= (string)$student['username']; ?></td>
                                            <td><?= (string)$student->details->fullname->fname . ' ' . (string)$student->details->fullname->lname; ?></td>
                                            <td><?= (string)$student->details->birthdate; ?></td>
                                            <td><?= (string)$student->details->tel; ?></td>
                                            <td><?= (string)$student->details->email; ?></td>
                                            <td><?= (string)$student->details->cin; ?></td>
                                            <td><?= (string)$student->details->cne; ?></td>
                                            <td><?= (string)$student->details->apoge; ?></td>
                                            <td><?= (string)$student->details->adresse; ?></td>
                                            <td><?= (string)$applicationNode->details2->MoyRegio; ?></td>
                                            <td><?= (string)$applicationNode->details2->MoyNatio; ?></td>
                                            <td><?= (string)$applicationNode->details2->MoyGen; ?></td>
                                            <td><?= (string)$applicationNode->details2->Classement; ?></td>
                                            <td><?= (string)$applicationNode->details2->Mention; ?></td>
                                            <td><?= $applicationNode->details2->Date; ?></td>
                                            <td><?= (string)$applicationNode->details2->ville; ?></td>
                                            <td><?= $filiereName; ?></td>
                                            <td><?= $applicationNode['status']; ?></td>
                                            <td>
                                                <form method="post">
                                                    <input type="hidden" name="student_id" value="<?= $student['id'] ?>">
                                                    <input type="hidden" name="application_status" value="acceptée">
                                                    <button type="submit" name="process_application" class="btn btn-success">Approuver candidature</button>
                                                </form>
                                                <form method="post">
                                                    <input type="hidden" name="student_id" value="<?= $student['id'] ?>">
                                                    <input type="hidden" name="application_status" value="refusée">
                                                    <button type="submit" name="process_application" class="btn btn-danger">Rejeter candidature</button>
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
