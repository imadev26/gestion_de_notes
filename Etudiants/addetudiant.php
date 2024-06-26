<?php 
include("../connection.php");
include("../etudiant.php");
$cnx = New Connection();
$cnx->selectDatabase("db_ges_notes");
include("../filieres.php");
$fil = New Filieres();
$allfil = $fil->selectfilwithGRP($cnx);
$etu = New Etudiant();

if (isset($_POST["submit"])) {
    $nom = $_POST['fname'];
    $prenom = $_POST['lname'];
    $ddn = $_POST['ddn'];
    $mdp = $_POST['mdp'];
    $rpmdp = $_POST['rpmdp'];
    $email = $_POST['emailval'];
    $grp = $_POST['groupes'];
    if (!empty($nom) && !empty($prenom)) {
        // Vérifier si la date de naissance est au format YYYY/MM/DD
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $ddn)) {
            // Convertir la date de naissance en objet DateTime
            $dateNaissance = DateTime::createFromFormat('Y-m-d', $ddn);
    
            // Calculer la différence d'âge
            $aujourdHui = new DateTime();
            $difference = $aujourdHui->diff($dateNaissance);
    
            // Vérifier si la personne a plus de 18 ans
            if ($difference->y > 18) {
                // Vérifier si le mot de passe respecte les critères
                if (strlen($mdp) >= 8 && preg_match('/[!@#$%^&*(),.?":{}|<>]/', $mdp) && preg_match('/\d.*\d.*\d/', $mdp) && preg_match('/.*[A-Z].*/', $mdp)) {
                    // Vérifier si le mot de passe correspond au mot de passe de confirmation
                    if ($mdp === $rpmdp) {
                        
                        $user = New Etudiant($nom,$prenom,$ddn,$email,$mdp,$grp);
                        $user->insertuser('Etudiant',$cnx);
                        // Si tout est valide, fusionner le mot de passe avec les autres données
    
                        $succesMessage = Etudiant::$successMsg;
                    } else {
                        $errorMessage = "Les mots de passe ne correspondent pas.";
                    }
                } else {
                    $errorMessage = "Le mot de passe doit avoir au moins 8 caractères, 1 symbole et 3 chiffres et une lettre majuscule.";
                }
            } else {
                $errorMessage = "La personne doit avoir plus de 18 ans.";
            }
        } else {
            $errorMessage = "Format de date de naissance invalide. Utilisez le format JJ/MM/AAAA.";
        }
    } else {
        $errorMessage = "Veuillez saisir un nom et un prénom";
    }
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
        <link rel="shortcut icon" href="../assets/images/favicon.ico" />
        
        <!-- Css -->
        <!-- Main Css -->
        <link rel="stylesheet" href="../assets/libs/icofont/icofont.min.css">
        <link href="../assets/libs/flatpickr/flatpickr.min.css" type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="../assets/css/tailwind.min.css">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    </head>
    
    <body data-layout-mode="light"  data-sidebar-size="default" data-theme-layout="vertical" class="bg-[#EEF0FC] dark:bg-gray-900">

        <?php include("../navbar.php") ?>

        
        <div class="ltr:flex flex-1 rtl:flex-row-reverse">
            <div class="page-wrapper relative ltr:ml-auto rtl:mr-auto rtl:ml-0 w-[calc(100%-260px)] px-4 pt-[64px] duration-300">
                <div class="xl:w-full">        
                    <div class="flex flex-wrap">
                        <div class="flex items-center py-4 w-full">
                            <div class="w-full">                    
                                <div class="flex flex-wrap justify-between">
                                    <div class="items-center ">
                                        <h1 class="font-medium text-3xl block dark:text-slate-100">Ajouter un etudiant</h1>
                                        <ol class="list-reset flex text-sm">
                                            <li><a href="#" class="text-gray-500 dark:text-slate-400">Etudiants</a></li>
                                            <li><span class="text-gray-500 dark:text-slate-400 mx-2">/</span></li>
                                            <li class="text-primary-500 hover:text-primary-600 dark:text-primary-400">ajouter un etudiant</li>
                                        </ol>
                                    </div><!--end /div-->
                                    <div class="flex items-center">
                                        <div class="today-date leading-5 mt-2 lg:mt-0 form-input w-auto rounded-md border inline-block border-primary-500/60 dark:border-primary-500/60 text-primary-500 bg-transparent px-3 py-1 focus:outline-none focus:ring-0 placeholder:text-slate-400/70 placeholder:font-normal placeholder:text-sm hover:border-primary-400 focus:border-primary-500 dark:focus:border-primary-500  dark:hover:border-slate-700">
                                            <input type="text" class="dash_date border-0 focus:border-0 focus:outline-none" readonly  required="">
                                        </div>
                                    </div><!--end /div-->
                                </div><!--end /div-->
                            </div><!--end /div-->
                        </div><!--end /div-->
                    </div><!--end /div-->
                </div><!--end container-->
                <form id="addprof" action="addetudiant.php" method="POST">
                        <div class="relative z-0 mb-2 w-full group">
                            <input type="email" name="emailval" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b border-slate-300/60 appearance-none dark:text-slate-300 dark:border-slate-700 dark:focus:border-primary-500 focus:outline-none focus:ring-0 focus:border-primary-500 peer" placeholder=" " required />
                            <label for="floating_email" class="absolute text-sm text-gray-400 dark:text-slate-400/70 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-primary-500 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Adresse e-mail</label>
                        </div>
                        <div class="relative z-0 mb-2 w-full group">
                            <input type="password" name="mdp" id="floating_password" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b border-slate-300/60 appearance-none dark:text-slate-300 dark:border-slate-700 dark:focus:border-primary-500 focus:outline-none focus:ring-0 focus:border-primary-500 peer" placeholder=" " required />
                            <label for="floating_password" class="absolute text-sm text-gray-400 dark:text-slate-400/70 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-primary-500 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Mot de passe</label>
                        </div>
                        <div class="relative z-0 mb-2 w-full group">
                            <input type="password" name="rpmdp" id="floating_repeat_password" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b border-slate-300/60 appearance-none dark:text-slate-300 dark:border-slate-700 dark:focus:border-primary-500 focus:outline-none focus:ring-0 focus:border-primary-500 peer" placeholder=" " required />
                            <label for="floating_repeat_password" class="absolute text-sm text-gray-400 dark:text-slate-400/70 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-primary-500 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                    Confirmez le mot de passe</label>
                        </div>
                        <div class="grid xl:grid-cols-2 xl:gap-6">
                        <div class="relative z-0 mb-2 w-full group">
                            <input type="text" name="fname" id="floating_first_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b border-slate-300/60 appearance-none dark:text-slate-300 dark:border-slate-700 dark:focus:border-primary-500 focus:outline-none focus:ring-0 focus:border-primary-500 peer" placeholder=" " required />
                            <label for="floating_first_name" class="absolute text-sm text-gray-400 dark:text-slate-400/70 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-primary-500 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Prenom</label>
                        </div>
                        <div class="relative z-0 mb-2 w-full group">
                            <input type="text" name="lname" id="floating_last_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b border-slate-300/60 appearance-none dark:text-slate-300 dark:border-slate-700 dark:focus:border-primary-500 focus:outline-none focus:ring-0 focus:border-primary-500 peer" placeholder=" " required />
                            <label for="floating_last_name" class="absolute text-sm text-gray-400 dark:text-slate-400/70 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-primary-500 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nom</label>
                        </div>
                        <div class="relative z-0 mb-2 w-full group">
                            <input type="date" name="ddn" id="floating_ddn" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b border-slate-300/60 appearance-none dark:text-slate-300 dark:border-slate-700 dark:focus:border-primary-500 focus:outline-none focus:ring-0 focus:border-primary-500 peer" placeholder="" required />
                            <label for="floating_last_name" class="absolute text-sm text-gray-400 dark:text-slate-400/70 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-primary-500 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">date de naissance</label>
                        </div>
                        <?php 
                            if  (!empty($errorMessage)){
                                echo '<div class="p-3 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                                <span class="font-medium">'. $errorMessage.'</span></div>';
                            }
                            ?>
                            <?php 
                            if  (!empty($succesMessage)){
                                echo '<div class="p-3 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
                                <span class="font-medium">'. $succesMessage .'</span></div>';
                            }
                            ?>
                        </div>
                        <div class="relative z-0 mb-2 w-full group">
                                <select name="idg" id="filiereslist" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b border-slate-300/60 appearance-none dark:text-slate-300 dark:border-slate-700 dark:focus:border-primary-500 focus:outline-none focus:ring-0 focus:border-primary-500 peer" required>
                                <option value="" disabled selected>Sélectionnez une filière</option>
                                <?php 
                                foreach ($allfil as $row) {
                                    $idf = $row["idfiliere"];
                                    $nomF = $row["libelleF"];
                                    echo '<option value="' . $idf . '">' . $nomF . '</option>';
                                }
                                ?> 
                                </select>   
                            <select name="groupes" id="groupeslist" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b border-slate-300/60 appearance-none dark:text-slate-300 dark:border-slate-700 dark:focus:border-primary-500 focus:outline-none focus:ring-0 focus:border-primary-500 peer" required>
                            <option value="" disabled selected>Sélectionnez un groupe</option>
                            </select> 
                            <script>
                            $(document).ready(function(){
                            $('#filiereslist').on('change', function(){
                            var idfiliere = $(this).val();
                            if(idfiliere){
                            $.ajax({
                            type:'POST',
                            url:'../getdata.php', // Le fichier PHP qui récupère les groupes en fonction de la filière
                            data:'idfiliere='+idfiliere,
                            success:function(html){
                                $('#groupeslist').html(html);
                            }
                            });
                            }else{
                            $('#groupeslist').html('<option value="" disabled selected>Sélectionnez un groupe</option>');
                            }
                                });
                            });
                            </script>
                        </div>
                        <button type="submit" name="submit" class="inline-block focus:outline-none text-primary-500 hover:bg-primary-500 hover:text-white bg-transparent border border-gray-200 dark:bg-transparent dark:text-primary-500 dark:hover:text-white dark:border-gray-700 dark:hover:bg-primary-500  text-sm font-medium py-1 px-3 rounded mb-1 lg:mb-0">Submit</button>
                        <button type="text" class="inline-block focus:outline-none text-red-500 hover:bg-red-500 hover:text-white bg-transparent border border-gray-200 dark:bg-transparent dark:text-red-500 dark:hover:text-white dark:border-gray-700 dark:hover:bg-red-500  text-sm font-medium py-1 px-3 rounded mb-1 lg:mb-0" onclick="clearForm()">Clear</button>
                    </form>
                    <script>
                            function clearForm() {
                                document.getElementById("addprof").reset();
                            }
                    </script>
                <div class="xl:w-full  min-h-[calc(100vh-152px)] relative pb-14"> 
                    <div class="grid md:grid-cols-12 lg:grid-cols-12 xl:grid-cols-12 gap-4 mb-4">
                        <div class="sm:col-span-12  md:col-span-12 lg:col-span-3 xl:col-span-3 ">
                            
                        </div><!--end col-->
                        <div class="sm:col-span-12  md:col-span-12 lg:col-span-9 xl:col-span-9 ">
                            
                        </div><!--end col-->            
                    </div><!--end inner-grid-->
                    <!-- footer -->
                    <div class="absolute bottom-0 -left-4 -right-4 block print:hidden border-t p-4 h-[52px] dark:border-slate-700/40">
                        <div class="container">
                          <!-- Footer Start -->
                          <footer
                            class="footer bg-transparent  text-center  font-medium text-slate-600 dark:text-slate-400 md:text-left "
                          >
                            &copy;
                            <script>
                              var year = new Date();document.write(year.getFullYear());
                            </script>
                            Robotech
                            <span class="float-right hidden text-slate-600 dark:text-slate-400 md:inline-block"
                              >Crafted with <i class="ti ti-heart text-red-500"></i> by
                              Mannatthemes</span
                            >
                          </footer>
                          <!-- end Footer -->
                        </div>
                      </div>
  
  
                </div><!--end container-->
            </div><!--end page-wrapper-->
        </div><!--end /div-->
        

        <!-- JAVASCRIPTS -->
        <!-- <div class="menu-overlay"></div> -->
        <script src="../assets/libs/lucide/umd/lucide.min.js"></script>
        <script src="../assets/libs/simplebar/simplebar.min.js"></script>
        <script src="../assets/libs/flatpickr/flatpickr.min.js"></script>
        <script src="../assets/libs/@frostui/tailwindcss/frostui.js"></script>

        <script src="../assets/js/app.js"></script>
        <!-- JAVASCRIPTS -->
    </body>
</html>