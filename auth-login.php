<?php
include("connection.php");
$cnx = new Connection();
$cnx->selectDatabase("db_ges_notes");
$mysqli = $cnx->getMysqli();

session_start();  // Start the session at the beginning

if ($mysqli->connect_error) {
    die('Erreur de connexion à la base de données : ' . $mysqli->connect_error);
}

function authenticateUser($email, $password, $mysqli) {
    $queryEtudiant = "SELECT * FROM Etudiant WHERE email = ?";
    $queryProf = "SELECT * FROM Profs WHERE email = ?";
    $stmtEtudiant = $mysqli->prepare($queryEtudiant);
    $stmtEtudiant->bind_param('s', $email);
    $stmtEtudiant->execute();
    $resultEtudiant = $stmtEtudiant->get_result();
    $userEtudiant = $resultEtudiant->fetch_assoc();

    if ($userEtudiant && password_verify($password, $userEtudiant['password'])) {
        return ['role' => 'etudiant', 'user' => $userEtudiant];
    }

    $stmtProf = $mysqli->prepare($queryProf);
    $stmtProf->bind_param('s', $email);
    $stmtProf->execute();
    $resultProf = $stmtProf->get_result();
    $userProf = $resultProf->fetch_assoc();

    if ($userProf && password_verify($password, $userProf['password'])) {
        return ['role' => 'professeur', 'user' => $userProf];
    }

    return false;
}

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $authResult = authenticateUser($email, $password, $mysqli);

    if ($authResult) {
        $_SESSION['id'] = $authResult['user']['id'];
        $_SESSION['nom'] = $authResult['user']['nom'];
        $_SESSION['prenom'] = $authResult['user']['prenom'];
        $_SESSION['role'] = $authResult['role'];
        session_write_close(); // Ensure session data is saved before redirecting

        $iduser = $_SESSION['id'];
        $fullname = $_SESSION['nom'] . " " . $_SESSION['prenom'];
        $role = $_SESSION['role'];
        $redirectUrl = "Dashboard/pages-starter.php?fullname=" . urlencode($fullname) . "&id=$iduser&role=$role";
        header("Location: $redirectUrl");
        exit();
    } else {
        $errorMessage = 'Email ou mot de passe incorrect. Veuillez réessayer.';
        // Consider displaying this message on the login page
    }
    $mysqli->close();
}
?>



<!DOCTYPE html>
<html lang="en" class="scroll-smooth group" data-sidebar="brand" dir="ltr">
    <head>
        <meta charset="utf-8" />
        <title>madev | gestion de notes</title>
        <meta  name="viewport"  content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <meta  content="Tailwind Multipurpose Admin & Dashboard Template"  name="description"/>
        <meta content="" name="Mannatthemes" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico" />
        
        <!-- Css -->
        <!-- Main Css -->
        <link rel="stylesheet" href="assets/libs/icofont/icofont.min.css">
        <link href="assets/libs/flatpickr/flatpickr.min.css" type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/tailwind.min.css">

    </head>
    
    <body data-layout-mode="light"  data-sidebar-size="default" data-theme-layout="vertical" class="bg-[#EEF0FC] dark:bg-gray-900">
    
    <div class="relative flex flex-col justify-center min-h-screen overflow-hidden">
        <div class="w-full  m-auto bg-white dark:bg-slate-800/60 rounded shadow-lg ring-2 ring-slate-300/50 dark:ring-slate-700/50 lg:max-w-md">
            <div class="text-center p-6 bg-slate-900 rounded-t">
                <a href="index.html"><img src="assets/images/logo-sm.png" alt="" class="w-14 h-14 mx-auto mb-2"></a>
                <h3 class="font-semibold text-white text-xl mb-1">Get Started</h3>
                <p class="text-xs text-slate-400">Sign in.</p>
            </div>

            <form class="p-6" action="auth-login.php" method="POST">
                <div>
                    <label for="email" class="font-medium text-sm text-slate-600 dark:text-slate-400">Email</label>
                    <input name="email" type="email" id="email" class="form-input w-full rounded-md mt-1 border border-slate-300/60 dark:border-slate-700 dark:text-slate-300 bg-transparent px-3 py-2 focus:outline-none focus:ring-0 placeholder:text-slate-400/70 placeholder:font-normal placeholder:text-sm hover:border-slate-400 focus:border-primary-500 dark:focus:border-primary-500  dark:hover:border-slate-700" placeholder="Your Email" required>
                </div>
                <div class="mt-4">
                    <label for="password" class="font-medium text-sm text-slate-600 dark:text-slate-400">Your password</label>
                    <input name="password" type="password" id="password" class="form-input w-full rounded-md mt-1 border border-slate-300/60 dark:border-slate-700 dark:text-slate-300 bg-transparent px-3 py-2 focus:outline-none focus:ring-0 placeholder:text-slate-400/70 placeholder:font-normal placeholder:text-sm hover:border-slate-400 focus:border-primary-500 dark:focus:border-primary-500  dark:hover:border-slate-700" placeholder="Password"  required>
                </div>
                                   
                <div class="mt-4">
                    <button name="submit" type="submit"
                        class="w-full px-2 py-2 tracking-wide text-white transition-colors duration-200 transform bg-brand-500 rounded hover:bg-brand-600 focus:outline-none focus:bg-brand-600">
                        Login
                    </button>
                </div>
                
            </form>
           
        </div>
    </div>
        

        <!-- JAVASCRIPTS -->
        <!-- <div class="menu-overlay"></div> -->
        <script src="assets/libs/lucide/umd/lucide.min.js"></script>
        <script src="assets/libs/simplebar/simplebar.min.js"></script>
        <script src="assets/libs/flatpickr/flatpickr.min.js"></script>
        <script src="assets/libs/@frostui/tailwindcss/frostui.js"></script>

        <script src="assets/js/app.js"></script>
        <!-- JAVASCRIPTS -->
    </body>
</html>