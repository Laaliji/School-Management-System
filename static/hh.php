<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read the raw POST data
    $data = file_get_contents("php://input");
    $data = urldecode($data);

    // Parse the data into an associative array
    parse_str($data, $formData);

    // Validate and sanitize the form data (you should add proper validation)
    $username = htmlspecialchars($formData['username']);
    $firstName = htmlspecialchars($formData['firstName']);
    $lastName = htmlspecialchars($formData['lastName']);
    $email = htmlspecialchars($formData['email']);
    $cin = htmlspecialchars($formData['cin']);
    $tel = htmlspecialchars($formData['tel']);
    $birthdate = htmlspecialchars($formData['birthdate']);
    $adresse = htmlspecialchars($formData['adresse']);
    $cne = htmlspecialchars($formData['cne']);
    $apoge = htmlspecialchars($formData['apoge']);
    $moyenRegional = htmlspecialchars($formData['moyenRegional']);
    $moyenNational = htmlspecialchars($formData['moyenNational']);
    $moyenGeneral = htmlspecialchars($formData['moyenGeneral']);
    $classement = htmlspecialchars($formData['classement']);
    $mention = htmlspecialchars($formData['mention']);
    $date = htmlspecialchars($formData['date']);
    $ville = htmlspecialchars($formData['ville']);
    $selectedFiliere = htmlspecialchars($formData['filiere']);

    // Load the XML file
    $xml = simplexml_load_file('xml/DATA2.xml');

    // Generate a new ID for the student
    $lastStudent = $xml->xpath('//student[last()]');
    $newStudentId = (int) $lastStudent[0]['id'] + 1;

    // Create a new student element
    $newStudent = $xml->students->addChild('student');
    $newStudent->addAttribute('id', $newStudentId);
    $newStudent->addAttribute('username', $username);

    // Add details for the new student in the desired order
    $newStudentDetails = $newStudent->addChild('details');
    $newStudentDetails->addChild('fullname');
    $newStudentDetails->fullname->addChild('fname', $firstName);
    $newStudentDetails->fullname->addChild('lname', $lastName);
    $newStudentDetails->addChild('birthdate', $birthdate);
    $newStudentDetails->addChild('tel', $tel);
    $newStudentDetails->addChild('email', $email);
    $newStudentDetails->addChild('cin', $cin);
    $newStudentDetails->addChild('cne', $cne);
    $newStudentDetails->addChild('apoge', $apoge);
    $newStudentDetails->addChild('adresse', $adresse);
    $newStudentDetails->addChild('mark', 0); // Set mark to 0 for new student

    // Add academic information to the application section
    $newApplication = $xml->applications->addChild('application');
    $newApplication->addAttribute('student', $username);
    $newApplication->addAttribute('status', 'pending');
    $newApplicationDetails = $newApplication->addChild('details2');
    $newApplicationDetails->addChild('MoyRegio', $moyenRegional);
    $newApplicationDetails->addChild('MoyNatio', $moyenNational);
    $newApplicationDetails->addChild('MoyGen', $moyenGeneral);
    $newApplicationDetails->addChild('Classement', $classement);
    $newApplicationDetails->addChild('Mention', $mention);
    $newApplicationDetails->addChild('Date', $date);
    $newApplicationDetails->addChild('ville', $ville);
    $newApplicationDetails->addChild('filiere', $selectedFiliere);

    // Save the updated XML file
    $xml->asXML('xml/DATA2.xml');

    // Return a success message
    echo "Application submitted successfully!";
    exit;
}

// Load the XML file for dynamic options
$xml = simplexml_load_file('xml/DATA2.xml');
$filieres = $xml->filieres;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Welcome to Ecole Supérieure de Technologie de Safi">
    <meta name="author" content="ESTS">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="img/photos/estlogo.png" />

    <link rel="canonical" href="https://your-school-website.com/" />

    <title>Bienvenue à ESTS Safi</title>

    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
       body {
    background-image: url('img/photos/backgroundzlij.jpg');
    background-size: auto;
    background-position: center;
    margin: 0;
    padding: 0;
    font-family: 'Inter', sans-serif;
}

.container {
    display: grid;
    place-items: center;
    min-height: 100vh;
}

.content-container {
    background-color: rgba(255, 255, 255, 0.9);
    padding: 20px; /* Adjusted padding */
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    text-align: center;
    max-width: 600px; /* Adjusted max-width */
    width: 100%;
    margin: auto; /* Center the container */
}

.form-step {
    display: none;
    animation: fadeIn 0.5s ease-in-out;
}

.form-step.active {
    display: block;
}

button {
    margin-top: 20px;
    background-color: #4CAF50;
    color: white;
    border: none;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #45a049;
}

label {
    display: block;
    margin-top: 10px;
    font-weight: bold;
}

/* Add this style for the form elements */
.form-step label,
.form-step input,
.form-step select,
.form-step button {
    width: calc(100% - 20px); /* Full width with reduced spacing */
    margin: 5px 0; /* Adjusted margin */
    box-sizing: border-box;
}

/* Add this style for responsive design (adjust breakpoints as needed) */
@media (max-width: 768px) {
    .form-step label,
    .form-step input,
    .form-step select,
    .form-step button {
        width: 100%;
    }
}

.progress-container {
    margin-top: 10px; /* Reduced margin-top */
    display: flex;
    justify-content: space-between;
    width: 100%;
}

.progress-bar {
    flex-grow: 1;
    height: 10px; /* Reduced height */
    background-color: #ddd;
    position: relative;
    border-radius: 5px;
}

.progress-bar-fill {
    height: 100%;
    border-radius: 5px;
    background-color: #4CAF50;
}

    </style>
</head>

<body>

    <main>
        <div class="container">
            <div class="content-container">
                <div class="progress-container">
                    <div class="progress-bar" id="progressBar">
                        <div class="progress-bar-fill" id="progressBarFill"></div>
                    </div>
                </div>
                <div class="form-step active" id="step1" data-step="1">
                    <h1 class="h2 mt-5">Step 1: Informations personnelles</h1>
                    <label for="username">Username</label>
                    <input type="text" id="username" placeholder="Enter your username" >
                    <label for="firstName">First Name</label>
                    <input type="text" id="firstName" placeholder="Enter your first name">
                    <label for="lastName">Last Name</label>
                    <input type="text" id="lastName" placeholder="Enter your last name">
                    <label for="email">Email</label>
                    <input type="email" id="email" placeholder="Enter your email">
                    <label for="cin">CIN</label>
                    <input type="text" id="cin" placeholder="Enter your CIN">
                    <label for="tel">Phone Number</label>
                    <input type="tel" id="tel" placeholder="Enter your phone number">
                    <label for="birthdate">Birthdate</label>
                    <input type="date" id="birthdate" placeholder="Enter your birthdate">
                    <label for="adresse">Address</label>
                    <input type="text" id="adresse" placeholder="Enter your address"><br><br><br><br>
                    <button onclick="nextStep(1)">Next</button>
                </div>

                <div class="form-step" id="step2" data-step="2">
                    <h1 class="h2 mt-5">Step 2: Informations académiques</h1>
                    <label for="cne">CNE</label>
                    <input type="text" id="cne" placeholder="Enter your CNE">
                    <label for="apoge">Apoge</label>
                    <input type="text" id="apoge" placeholder="Enter your apoge">
                    <label for="moyenRegional">Moyen Regional</label>
                    <input type="text" id="moyenRegional" placeholder="Enter your moyen regional">
                    <label for="moyenNational">Moyen National</label>
                    <input type="text" id="moyenNational" placeholder="Enter your moyen national">
                    <label for="moyenGeneral">Moyen General</label>
                    <input type="text" id="moyenGeneral" placeholder="Enter your moyen general">
                    <label for="classement">Classement</label>
                    <input type="text" id="classement" placeholder="Enter your classement">
                    <label for="mention">Mention</label>
                    <input type="text" id="mention" placeholder="Enter your mention">
                    <label for="date">Date</label>
                    <input type="date" id="date" placeholder="Enter the date">
                    <label for="ville">Ville</label>
                    <input type="text" id="ville" placeholder="Enter your city"><br><br><br><br>
                    <button onclick="prevStep(2)">Previous</button>
                    <button onclick="nextStep(2)">Next</button>
                </div>

                <div class="form-step" id="step3" data-step="3">
                    <h1 class="h2 mt-5">Step 3: Choix de la candidature</h1>
                    <label for="filiere">Choose your major</label>
                    <select id="filiere">
                        <?php foreach ($filieres->filiere as $filiere) : ?>
                            <option value="<?= $filiere['id'] ?>"><?= $filiere['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <br><br><br>
                    <button onclick="prevStep(3)">Previous</button>
                    <button onclick="submitForm()">Submit</button>
                </div>

                <div class="form-step thanks-message" id="thanksStep">
                    <h1 class="h2 mt-5">Thank you for your submission!</h1>
                    <p>Your application has been submitted successfully.</p>
                    <button class="return-home-button" onclick="returnHome()">Revenir à la page d'accueil</button>
                </div>
            </div>

        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        function nextStep(step) {
            // Hide the current step
            $('#step' + step).hide();

            // Show the next step
            $('#step' + (step + 1)).show();

            // Update progress bar
            updateProgressBar(step + 1);
        }

        function prevStep(step) {
            // Hide the current step
            $('#step' + step).hide();

            // Show the previous step
            $('#step' + (step - 1)).show();

            // Update progress bar
            updateProgressBar(step - 1);
        }

        function submitForm() {
            // Collect data from all steps
            var username = document.getElementById('username').value;
            var firstName = document.getElementById('firstName').value;
            var lastName = document.getElementById('lastName').value;
            var email = document.getElementById('email').value;
            var cin = document.getElementById('cin').value;
            var tel = document.getElementById('tel').value;
            var birthdate = document.getElementById('birthdate').value;
            var adresse = document.getElementById('adresse').value;
            var cne = document.getElementById('cne').value;
            var apoge = document.getElementById('apoge').value;
            var moyenRegional = document.getElementById('moyenRegional').value;
            var moyenNational = document.getElementById('moyenNational').value;
            var moyenGeneral = document.getElementById('moyenGeneral').value;
            var classement = document.getElementById('classement').value;
            var mention = document.getElementById('mention').value;
            var date = document.getElementById('date').value;
            var ville = document.getElementById('ville').value;
            var selectedFiliere = document.getElementById('filiere').value;

            // Use Ajax to submit data to the server
            $.ajax({
                url: 'hh.php',
                type: 'POST',
                data: {
                    username: username,
                    firstName: firstName,
                    lastName: lastName,
                    email: email,
                    cin: cin,
                    tel: tel,
                    birthdate: birthdate,
                    adresse: adresse,
                    cne: cne,
                    apoge: apoge,
                    moyenRegional: moyenRegional,
                    moyenNational: moyenNational,
                    moyenGeneral: moyenGeneral,
                    classement: classement,
                    mention: mention,
                    date: date,
                    ville: ville,
                    filiere: selectedFiliere
                },
                success: function (response) {
                    console.log(response);

                    // Hide the current step
                    $('#step3').hide();

                    // Show the thanks step
                    $('#thanksStep').show();
                },
                error: function (error) {
                    console.log('Error:', error);
                }
            });
        }

        function updateProgressBar(step) {
            var totalSteps = 3; // Total number of steps
            var progressBarFill = (step / totalSteps) * 100;

            // Update progress bar
            $('#progressBarFill').css('width', progressBarFill + '%');
        }

        // Call this function to set the initial progress bar state
        updateProgressBar(1)

        function returnHome() {
            // Redirect to the welcome page
            window.location.href = 'welcome.html';
        }
    </script>
</body>

</html>

