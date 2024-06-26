<?php 
require_once "../connection.php";
$cnx = new Connection();
$cnx->selectDatabase("db_ges_notes");


require_once "../utilisateurs.php";

$allprof = Utilisateurs::selectAllProf($cnx);
$retP = Utilisateurs::retDATA($cnx,'profs');
$retE = Utilisateurs::retDATA($cnx,'Etudiant');
$retG = Utilisateurs::retDATA($cnx,'groupes');
$retF = Utilisateurs::retDATA($cnx,'Filieres');




//$allgroup = Utilisateurs::selectAllgroupes($cnx);
//$allfil = Utilisateurs::selectAllFilieres($cnx);
//$alledu = Utilisateurs::selectAllEtudiants($cnx);



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
                                        <h1 class="font-medium text-3xl block dark:text-slate-100">Starter</h1>
                                        <ol class="list-reset flex text-sm">
                                            <li><a href="#" class="text-gray-500 dark:text-slate-400">Robotech</a></li>
                                            <li><span class="text-gray-500 dark:text-slate-400 mx-2">/</span></li>
                                            <li class="text-gray-500 dark:text-slate-400">Pages</li>
                                            <li><span class="text-gray-500 dark:text-slate-400 mx-2">/</span></li>
                                            <li class="text-primary-500 hover:text-primary-600 dark:text-primary-400">Starter</li>
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
                <!-- JS -->
                <script src="../assets/libs/raphael/raphael.min.js"></script>
                <script src="../assets/libs/justgage/justgage.min.js"></script>

                <style>
                    body {
                        font-family: 'Arial', sans-serif; /* Replace 'Arial' with your preferred font or font stack */
                    }
                
                    .datacounter {
                        display: flex;
                        flex-direction: row;
                        justify-content: center;
                    }
                
                    .nombredesenseignants,
                    .nombredesgroupes,
                    .nombredesfiliers,
                    .nombredesetudiants {
                        text-align: center;
                        margin-bottom: 20px;
                    }
                
                    .gauge {
                        /* Add your gauge styles here */
                    }
                
                    button {
                        padding: 8px 16px;
                        background-color: transparent;
                        color: #3498db; /* Change the text color to your preferred color */
                        font-size: 14px;
                        border: 2px solid #3498db; /* Change the border color to your preferred color */
                        border-radius: 999px; /* Use a large border-radius for a rounded button */
                        cursor: pointer;
                        transition: background-color 0.3s, color 0.3s;
                    }
                
                    button:hover {
                        background-color: #3498db; /* Change the background color to your preferred color */
                        color: #fff; /* Change the text color on hover to white or a contrasting color */
                    }
                    .etdtable{
                      margin-top: 0%;
                    }
                </style>
                <!-- HTML -->
                
                <div class="datacounter">
                    <div class="nombredesenseignants">
                        <center><h3 class="text-3xl block dark:text-slate-100">nombre des professeurs</h3></center>
                        <div id="gg1" class="gauge" data-value="<?php echo $retP ?>"></div>
                    </div>
                    
                    <div class="nombredesgroupes">
                        <center><h3 class="text-3xl block dark:text-slate-100">nombre des groupes</h3></center>
                        <div id="gg2" class="gauge" data-value="<?php echo $retG ?>"></div>
                    </div>

                    <div class="nombredesfiliers">
                        <center><h3 class="text-3xl block dark:text-slate-100">nombre des filiéres</h3></center>
                        <div id="gg3" class="gauge" data-value="<?php echo $retF ?>"></div>
                    </div>

                    <div class="nombredesetudiants">
                        <center><h3 class="text-3xl block dark:text-slate-100">nombre des etudiants</h3></center>
                        <div id="gg4" class="gauge" data-value="<?php echo $retE ?>"></div>
                    </div>

                </div>
                <div class="etdtable"><h3 class="text-3xl block dark:text-slate-100">Table des enseignants</h3>
                    <table class="w-full" id="datatable_2">
                        <thead class="bg-slate-100 dark:bg-slate-700/20">
                            <?php 
                            echo '<tr scope="col" class="p-3 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">';
                            foreach ($allprof[0] as $key => $value) {
                                echo '<th scope="col" class="p-3 text-xs font-medium tracking-wider text-left text-gray-700 dark:text-gray-400 uppercase">' . htmlspecialchars($key) . '</th>';
                            }
                            echo '</tr>';                            
                            ?>
                        </thead>
                        <tbody>
                            <?php 
                             foreach ($allprof as $row) {
                                echo '<tr class="bg-white border-b border-dashed dark:bg-gray-900 dark:border-gray-700">';
                                echo "<td class='p-3 text-sm font-medium whitespace-nowrap dark:text-white'>" . $row["idprof"] . "</td>" . "<td class='p-3 text-sm font-medium whitespace-nowrap dark:text-white'>" . $row["nom"] . "</td>" . "<td class='p-3 text-sm font-medium whitespace-nowrap dark:text-white'>" . $row["prenom"] . "</td>" . "<td class='p-3 text-sm font-medium whitespace-nowrap dark:text-white'>" . $row["email"] . "</td>" . "<td class='p-3 text-sm font-medium whitespace-nowrap dark:text-white text-sky-500 nomgrp-value'>" . $row["filiere"] . "</td>" . "<td class='p-3 text-sm font-medium whitespace-nowrap dark:text-white'>" . $row["groupesenseigner"] . "</td>";
                                echo '</tr>';
                            }
                            ?> 
                        </tbody>
                    </table>
                </div>
                <!-- Init js -->
                <script>
                document.addEventListener("DOMContentLoaded", function(event) {
                    var dflt = {
                        min: 0,
                        max: 200,
                        donut: true,
                        gaugeWidthScale: 0.6,
                        counter: true,
                        hideInnerShadow: true,
                        gaugeColor: ['rgba(42, 118, 244, .1)'],
                        levelColors:['#4c7cf5'],
                    }
                    var gg1 = new JustGage({
                        id: 'gg1',
                        title: 'data-attributes',
                        defaults: dflt
                    });
                    var gg2 = new JustGage({
                        id: 'gg2',
                        title: 'data-attributes',
                        defaults: dflt
                    });
                    var gg3 = new JustGage({
                        id: 'gg3',
                        title: 'data-attributes',
                        defaults: dflt
                    });
                    var gg4 = new JustGage({
                        id: 'gg4',
                        title: 'data-attributes',
                        defaults: dflt
                    });
                });

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