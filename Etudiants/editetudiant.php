<?php 
include("../connection.php");
include("../etudiant.php");
include("../filieres.php");
$cnx = New Connection();
$cnx->selectDatabase("db_ges_notes");
$mysqli = $cnx->getMysqli();
$getuser = new Etudiant();
$alledu = $getuser->select($mysqli);
$fil = New Filieres();
$allfil = $fil->selectfilwithGRP($cnx);

if (isset($_POST["submit"])) {
    $id     = $_POST["valID"];
    $nom    = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $ddn    = $_POST["ddn"];
    $email  = $_POST["email"];
    $mdp    = $_POST["mdp"];
    $grp    = $_POST["groupes"];
    
    $etud = (object) [
        'idedu' => $id,
        'nom'   => $nom,
        'prenom'=> $prenom,
        'ddn'   => $ddn,
        'email' => $email,
        'mdp'   => $mdp,
        'idgrp' => $grp
    ];
    //$etudobject = (object) $etud;
    Etudiant::updateUser($etud,"etudiant",$mysqli);
    $succesMessage = Etudiant::$successMsg;
    $errorMessage  = Etudiant::$errorMsg;
/*
    if (preg_match('/^\*+$/', $mdp)) {
        $etud = array(
            'idedu' => $id,
            'nom'    => $nom, 
            'prenom' => $prenom,
            'ddn'    => $ddn,
            'email'  => $email,
            'mdp'    => $mdp,
            'idgrp'  => $grp     
            );
            $etudobject = (object) $etud;
            Etudiant::updateUser($etudobject,"etudiant",$mysqli,$id);
            $succesMessage = Etudiant::$successMsg;
            $errorMessage  = Etudiant::$errorMsg;
    }else{
        $etud = array(
        'idedu' => $id,
        'nom'    => $nom, 
        'prenom' => $prenom,
        'ddn'    => $ddn,
        'email'  => $email,
        'mdp'    => $mdp,
        'idgrp'  => $grp  
        );
        $etudobject = (object) $etud;
        Etudiant::updateUser($etudobject,"etudiant",$mysqli,$id);
        $succesMessage = Etudiant::$successMsg;
        $errorMessage  = Etudiant::$errorMsg;
    }*/
}
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $succesMessage = isset($_GET['msgS']) ? $_GET['msgS'] : null;
    $errorMessage  = isset($_GET['msgE']) ? $_GET['msgE'] : null;
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
                                        <h1 class="font-medium text-3xl block dark:text-slate-100">Modifier un Etudiant</h1>
                                        <ol class="list-reset flex text-sm">
                                            <li><a href="#" class="text-gray-500 dark:text-slate-400">Etudiants</a></li>
                                            <li><span class="text-gray-500 dark:text-slate-400 mx-2">/</span></li>
                                            <li class="text-primary-500 hover:text-primary-600 dark:text-primary-400">Modifier un Etudiant</li>
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
            
                <div class="xl:w-full  min-h-[calc(100vh-152px)] relative pb-14"> 
                    <div class="grid md:grid-cols-12 lg:grid-cols-12 xl:grid-cols-12 gap-4 mb-4">
                        <div class="sm:col-span-12  md:col-span-12 lg:col-span-3 xl:col-span-3 ">
                            
                        </div><!--end col-->
                        <div class="sm:col-span-12  md:col-span-12 lg:col-span-9 xl:col-span-9 ">
                            
                        </div><!--end col-->            
                    </div><!--end inner-grid-->
                    <!--Table-->
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
                <table class="w-full" id="tableProf">
                    <thead class="bg-slate-700 dark:bg-slate-900/30">
                        <?php 
                        echo '<tr>';
                        foreach ($alledu[0] as $key => $value) {
                            echo '<th th scope="col" class="p-3 text-xs font-medium tracking-wider text-left text-slate-100 uppercase">' . htmlspecialchars($key) . '</th>';
                        }
                        echo '<th th scope="col" class="p-3 text-xs font-medium tracking-wider text-left text-slate-100 uppercase">ACTION</th></tr>';                            
                        ?>          
                    </thead>
                    <tbody>
                            <?php 
                             foreach ($alledu as $row) {
                                //$grpFil = $getuser->returnID($cnx,$row["GROUPE"]);
                                echo '<tr class="bg-white border-b border-dashed dark:bg-gray-900 dark:border-gray-700/40">';
                                echo "<td class='p-3 text-sm font-medium whitespace-nowrap dark:text-white'>" . $row["NUMERO"] . "</td>" . "<td class='p-3 text-sm font-medium whitespace-nowrap dark:text-white'>" . $row["nom"] . "</td>" . "<td class='p-3 text-sm font-medium whitespace-nowrap dark:text-white'>" . $row["prenom"] . "</td>" . "<td class='p-3 text-sm font-medium whitespace-nowrap dark:text-white'>" . $row["DATE_DE_NAISSANCE"] . "</td>" . "<td class='p-3 text-sm font-medium whitespace-nowrap dark:text-white'>" . $row["email"] . "</td>" . "<td class='p-3 text-sm font-medium whitespace-nowrap dark:text-white'>" . str_repeat('*',strlen($row["MOTS_DE_PASSE"]))  . "</td>". "<td class='p-3 text-sm font-medium whitespace-nowrap dark:text-white text-sky-500 nomgrp-value'>". $row["FILIERE"]. "</td>". "<td class='p-3 text-sm font-medium whitespace-nowrap dark:text-white  nomgrp-value'>".$row["GROUPE"]."</td>";
                                echo '<td class="p-3 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                <a class="edit-btn"><i class="icofont-edit text-lg text-gray-500 dark:text-gray-400"></i></a>
                                <a href="../delete.php?type=etudiant&id='.$row["NUMERO"].'"><i class="icofont-ui-delete text-lg text-red-500 dark:text-red-400"></i></a>
                            </td></tr>';
                            }
                            ?> 
                            
                    </tbody>
                </table>

                <style>
                    body {
    margin: 0;
    font-family: 'Arial', sans-serif;
}

.popup-container {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.8); /* White background with transparency */
    backdrop-filter: blur(5px); /* Blur effect */
    z-index: 0;
}

.popup {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: #fff; /* White background */
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.trigger-btn {
    margin-top: 20px;
    cursor: pointer;
}

.cancel-btn {
    margin-top: 10px;
    cursor: pointer;
}
/* Add any other styles you need for your form inputs and buttons */
                </style>
                <div class="popup-container " id="popup">
                                <div class="popup" >
                                        <!-- Popup content goes here -->
                                        
                                        <form action="editetudiant.php" method="POST">
                                        <div class="mb-2">
                                        <label for="nom" class="font-medium text-sm text-slate-600 dark:text-slate-400">ID</label>
                                        <span  type="text" id="IDPROF" class="bg-indigo-500 text-white text-[11px] font-medium mr-1 px-2.5 py-0.5 rounded-full" value=""></span>
                                        <input style="display:none;" type="text" name="valID" id="valID">
                                        
                                        </div>
                                        <div class="mb-2">
                                        <label for="nom" class="font-medium text-sm text-slate-600 dark:text-slate-400">Nom</label>
                                        <input name="nom" type="text" id="nom" class="form-input">
                                        </div>
                                    <div class="mb-2">
                                        <label for="prenom" class="font-medium text-sm text-slate-600 dark:text-slate-400">Prenom</label>
                                        <input name="prenom" type="text" id="prenom" class="form-input">
                                    </div>
                                    <div class="mb-2">
                                        <label for="ddn" class="font-medium text-sm text-slate-600 dark:text-slate-400">Date de naissance</label>
                                        <input name="ddn" type="date" id="ddn" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b border-slate-300/60 appearance-none dark:text-slate-300 dark:border-slate-700 dark:focus:border-primary-500 focus:outline-none focus:ring-0 focus:border-primary-500 peer">
                                    </div>
                            <div class="relative z-0 mb-2 w-full group">
                            <select name="idg" id="filiereslist" class="block py-2.5 px-0 w-full text-smtext-gray-900 bg-transparent border-0 border-b border-slate-300/60 appearance-nonedark:text-slate-300 dark:border-slate-700 dark:focus:border-primary-500focus:outline-none focus:ring-0 focus:border-primary-500 peer" required>
                            <option value="" disabled selected>Sélectionnez une filière</option>
                            <?php 
                            foreach ($allfil as $row) {
                                $idf = $row["idfiliere"];
                                $nomF = $row["libelleF"];
                                echo '<option value="' . $idf . '">' . $nomF . '</option>';
                            }
                            ?> 
                                </select>   
                                <select name="groupes" id="groupeslist" class="block py-2.5 px-0 w-full text-smtext-gray-900 bg-transparent border-0 border-b border-slate-300/60 appearance-nonedark:text-slate-300 dark:border-slate-700 dark:focus:border-primary-500focus:outline-none focus:ring-0 focus:border-primary-500 peer" required>
                                <option value="" disabled selected>Sélectionnez un groupe</option>
                                </select> 
                                <script>
                                    
                                $(document).ready(function(){
                                $('#filiereslist').on('change', function(){
                                var idfiliere = $(this).val();
                                if(idfiliere){
                                $.ajax({
                                type:'POST',
                                url:'../getdata.php', // Le fichier PHP qui récupère les groupes en fonction de la  filière
                                data:'idfiliere='+idfiliere,
                                success:function(html){
                                    $('#groupeslist').html(html);
                                }
                                });
                                }else{
                                $('#groupeslist').html('<option value="" disabled selected>Sélectionnez un groupe</ option>');
                                }
                                    });
                                });
                                </script>
                            </div>                                                                      
                                    <div class="mb-2">
                                        <label for="email" class="font-medium text-sm text-slate-600 dark:text-slate-400">Email</label>
                                        <input name="email" type="email" id="email" class="form-input">
                                    </div>
                                    <div class="mb-2">
                                        <label for="password" class="font-medium text-sm text-slate-600 dark:text-slate-400">Password</label>
                                        <input name="mdp" type="text" id="password" class="form-input">
                                    </div>
                                            <button id="subbtn" name="submit" type="submit" class="inline-block focus:outline-none text-primary-500 hover:bg-primary-500 hover:text-white bg-transparent border border-gray-200 dark:bg-transparent dark:text-primary-500 dark:hover:text-white dark:border-gray-700 dark:hover:bg-primary-500  text-sm font-medium py-1 px-3 rounded mb-1">Submit</button>
                                            <button id="cancelbtn"  type="text" class="cancel-btn inline-block focus:outline-none text-red-500 hover:bg-red-500 hover:text-white bg-transparent border border-gray-200 dark:bg-transparent dark:text-red-500 dark:hover:text-white dark:border-gray-700 dark:hover:bg-red-500  text-sm font-medium py-1 px-3 rounded mb-1">Cancel</button>

                                        </form>
                                        <script>
                                        var editButtons = document.querySelectorAll('.edit-btn');

                                        editButtons.forEach(function(button, index) {
                                        button.addEventListener('click', function () {
                                        document.getElementById('popup').style.display = 'block';

                                        // Get data from the clicked row and populate the form
                                        var rowData = this.closest('tr').querySelectorAll('td');
                                        document.getElementById('IDPROF').innerHTML = rowData[0].innerText;
                                        document.getElementById('valID').value = rowData[0].innerText;
                                        document.getElementById('nom').value = rowData[1].innerText;
                                        document.getElementById('prenom').value = rowData[2].innerText;
                                        document.getElementById('ddn').value = rowData[3].innerText;
                                        document.getElementById('email').value = rowData[4].innerText;
                                        document.getElementById('password').value = rowData[5].innerText;
                                        //document.getElementById('groupeslist').value = rowData[5].innerText;
                                        var groupeGroupe = document.getElementById('groupeslist');
                                        var filieresDropdown = document.getElementById('filiereslist');
                                        var libelleFValue = rowData[6].innerText;
                                        var nomgrpValue = rowData[7].innerText;
                                        //var nomgrpElement = document.querySelector('.nomgrp-value');
                                        //var nomgrpValue = nomgrpElement.lastChild.nodeValue.trim(); 
                                        
                                    setTimeout(function () {
                                    for (var i = 0; i < filieresDropdown.options.length; i++) {
                                        if (filieresDropdown.options[i].text.trim() === libelleFValue) {
                                            filieresDropdown.selectedIndex = i;
                                            $(filieresDropdown).trigger('change'); // Trigger the 'change' event
                                            break;
                                        }
                                    }
                                    }, 50);
                                    setTimeout(function () {
                                        for (var j = 0; j < groupeGroupe.options.length; j++) {
                                            for (var i = 0; i < groupeGroupe.options.length; i++) {
                                            if (groupeGroupe.options[i].text.trim() === nomgrpValue) {
                                                groupeGroupe.selectedIndex = i;
                                                break;
                                            }
                                        };
                                        }
                                    }, 100);                                  
                                    });
                                    });

                                    document.getElementById('cancelbtn').addEventListener('click', function () {
                                        // Remove the class to remove the blur effect
                                        document.body.classList.remove('blur');
                                        
                                        // Hide the popup and reset its styles
                                        var popup = document.getElementById('popup');
                                        popup.style.display = 'none';
                                        popup.removeAttribute('style');

                                        // Reset the form content
                                        document.querySelector('form').reset();
                                    });

                                    </script>
                                </div>
                            </div> 
                


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