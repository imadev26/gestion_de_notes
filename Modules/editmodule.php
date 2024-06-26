<?php 
include("../modules.php");
include("../connection.php");
include("../groupes.php");
include("../filieres.php");
$grp = new Groupes();
$cnx = New Connection();
$cnx->selectDatabase("db_ges_notes");

$getfil = New filieres();
$allfil = $getfil->selectfil('Filieres',$cnx);

$modules = New Modules();
$allModule = $modules->selectModules("Modules",$cnx);

//MESSAGE AFTER UPDATE
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $succesMessage = isset($_GET['msgS']) ? $_GET['msgS'] : null;
    $errorMessage  = isset($_GET['msgE']) ? $_GET['msgE'] : null;
}


if (isset($_POST["submit"])) {
    $nomModule = $_POST["nomModule"];
    $idModule  = $_POST["idmodule"];
    $idF       = $_POST["idf"];
    $ModuleBeta = array(
        "libM" => $nomModule,
        "idFil" => $idModule,
    );
    $moduleObject = (object)$ModuleBeta;
    $modules->updateModule($moduleObject,"Modules",$cnx,$idModule);
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
                                        <h1 class="font-medium text-3xl block dark:text-slate-100">Modifier un module</h1>
                                        <ol class="list-reset flex text-sm">
                                            <li><a href="#" class="text-gray-500 dark:text-slate-400">Modules</a></li>
                                            <li><span class="text-gray-500 dark:text-slate-400 mx-2">/</span></li>
                                            <li class="text-primary-500 hover:text-primary-600 dark:text-primary-400">Modifier un module</li>
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
                <table class="w-full" id="tableModule">
                    <thead class="bg-slate-700 dark:bg-slate-900/30">
                        <?php 
                        echo '<tr>';
                        foreach ($allModule[0] as $key => $value) {
                            echo '<th th scope="col" class="p-3 text-xs font-medium tracking-wider text-left text-slate-100 uppercase">' . htmlspecialchars($key) . '</th>';
                        }
                        echo '<th th scope="col" class="p-3 text-xs font-medium tracking-wider text-left text-slate-100 uppercase">ACTION</th></tr>';                            
                        ?>          
                    </thead>
                    <tbody>
                            <?php 
                             foreach ($allModule as $row) {
                                echo '<tr class="bg-white border-b border-dashed dark:bg-gray-900 dark:border-gray-700/40">';
                                echo "<td class='p-3 text-sm font-medium whitespace-nowrap dark:text-white'>" . $row["idmodule"] . "</td>" . "<td class='p-3 text-sm font-medium whitespace-nowrap dark:text-white'>" . $row["Module"] . "</td>" . "<td class='p-3 text-sm font-medium whitespace-nowrap dark:text-white'>" . $grp->returnID($cnx,$row["filiére"]) . "</td>";
                                echo '<td class="p-3 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                <a class="edit-btn"><i class="icofont-edit text-lg text-gray-500 dark:text-gray-400"></i></a>
                                <a href="../delete.php?type=module&id='.$row["idmodule"].'"><i class="icofont-ui-delete text-lg text-red-500 dark:text-red-400"></i></a>
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
            z-index: 1;
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
                 <!-- Popup container -->
    <div class="popup-container" id="popup">
        <div class="popup">
            <!-- Popup content goes here -->
            <form action="editmodule.php" method="POST">
                <div class="mb-2">
                    <label for="nom" class="font-medium text-sm text-slate-600 dark:text-slate-400">ID</label>
                    <span type="text" id="moduleID"
                        class="bg-indigo-500 text-white text-[11px] font-medium mr-1 px-2.5 py-0.5 rounded-full"
                        value=""></span>
                    <input style="display:none;" type="text" name="idmodule" id="idmodule">
                </div>
                <div class="mb-2">
                    <label for="nom" class="font-medium text-sm text-slate-600 dark:text-slate-400">Nom</label>
                    <input name="nomModule" type="text" id="nomModule" class="form-input">
                </div>
                <div class="relative z-0 mb-2 w-full group">
                <select name="idF" id="filiereslist" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b border-slate-300/60 appearance-none dark:text-slate-300 dark:border-slate-700 dark:focus:border-primary-500 focus:outline-none focus:ring-0 focus:border-primary-500 peer" required>
                <option value="" disabled selected>Sélectionnez une filière</option>
                <?php 
                foreach ($allfil as $row) {
                    $idf = $row["idfiliere"];
                    $nomF = $row["libelleF"];
                    echo '<option value="' . $idf . '">' . $nomF . '</option>';
                }
                ?> 
                </select>    
                </div>
                <button name="submit"
                    class="inline-block focus:outline-none text-primary-500 hover:bg-primary-500 hover:text-white bg-transparent border border-gray-200 dark:bg-transparent dark:text-primary-500 dark:hover:text-white dark:border-gray-700 dark:hover:bg-primary-500  text-sm font-medium py-1 px-3 rounded mb-1"
                    type="submit">Submit</button>
                <button id="cancelbtn"
                    class="cancel-btn inline-block focus:outline-none text-red-500 hover:bg-red-500 hover:text-white bg-transparent border border-gray-200 dark:bg-transparent dark:text-red-500 dark:hover:text-white dark:border-gray-700 dark:hover:bg-red-500  text-sm font-medium py-1 px-3 rounded mb-1"
                    type="button">Cancel</button>
                    <script>
        var editButtons = document.querySelectorAll('.edit-btn');

        editButtons.forEach(function (button, index) {
            button.addEventListener('click', function () {
                document.getElementById('popup').style.display = 'block';

                // Get data from the clicked row and populate the form
                var rowData = this.closest('tr').querySelectorAll('td');
                document.getElementById('moduleID').innerHTML = rowData[0].innerText;
                document.getElementById('idmodule').value = rowData[0].innerText;
                document.getElementById('nomModule').value = rowData[1].innerText;
            });
        });

        document.getElementById('cancelbtn').addEventListener('click', function () {
            // Hide the popup and reset its styles
            var popup = document.getElementById('popup');
            popup.style.display = 'none';
            popup.removeAttribute('style');

            // Reset the form content
            document.querySelector('form').reset();
        });
    </script> 
            </form>
        </div>
    </div>
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