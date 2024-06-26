<?php 
include("../utilisateurs.php");
include("dataloaded.php");
$user = New Utilisateurs();
$alluser = $user->selectID("profs",$mysqli);
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
        <link href="../assets/libs/prismjs/themes/prism-twilight.min.css" type="text/css" rel="stylesheet">
        <!-- JS -->
        <script src="../assets/libs/simple-datatables/umd/simple-datatables.js"></script>      
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
 
        

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
                                    <div  class="items-center ">
                                        <h1 class="font-medium text-3xl block dark:text-slate-100">Ajouter un enseignant</h1>
                                        <ol class="list-reset flex text-sm">
                                            <li><a href="#" class="text-gray-500 dark:text-slate-400">enseignants</a></li>
                                            <li><span class="text-gray-500 dark:text-slate-400 mx-2">/</span></li>
                                            <li class="text-primary-500 hover:text-primary-600 dark:text-primary-400">ajouter enseignant</li>
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
                <!-- HTML -->
                <table class="w-full" id="datatable_2">
                        <thead class="bg-slate-100 dark:bg-slate-700/20">
                        <tr>
                            <?php
                            foreach ($alluser[0] as $key => $values) {
                                echo '<th scope="col" class="p-3 text-xs font-medium tracking-wider text-left text-gray-700 dark:text-gray-400 uppercase">'.$key
                                .'</th>';
                            }
                                echo '<th scope="col" class="p-3 text-xs font-medium tracking-wider text-left text-gray-700 dark:text-gray-400 uppercase">ACTION</th>';
                            ?>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($alluser as $row) {
                              echo '<tr class="bg-white border-b border-dashed dark:bg-gray-900 dark:border-gray-700 ">';
                              echo '<td class="p-3 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">' . $row['ID'] . '</td>' .
                                  '<td class="p-3 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">' . $row['nom'] . '</td>' .
                                  '<td class="p-3 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">' . $row['prenom'] . '</td>' .
                                  '<td class="p-3 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">' . $row['DATE_DE_NAISSANCE'] . '</td>' .
                                  '<td class="p-3 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">' . $row['email'] . '</td>' .
                                  '<td><a class="btn btn-trigger trigger" data-idprof="' . $row['ID'] . '"><i class="icofont-teacher text-slate-500 dark:text-slate-300 text-center text-[30px]"></i></a></td>' . '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                    <button type="button" class="inline-block focus:outline-none text-primary-500 hover:bg-primary-500 hover:text-white bg-transparent border border-gray-200 dark:bg-transparent dark:text-primary-500 dark:hover:text-white dark:border-gray-700 dark:hover:bg-primary-500  text-sm font-medium py-1 px-3 rounded mb-1 lg:mb-0 csv">Export CSV</button>
                    <button type="button" class="inline-block focus:outline-none text-primary-500 hover:bg-primary-500 hover:text-white bg-transparent border border-gray-200 dark:bg-transparent dark:text-primary-500 dark:hover:text-white dark:border-gray-700 dark:hover:bg-primary-500  text-sm font-medium py-1 px-3 rounded mb-1 lg:mb-0 sql">Export SQL</button>
                    <button type="button" class="inline-block focus:outline-none text-primary-500 hover:bg-primary-500 hover:text-white bg-transparent border border-gray-200 dark:bg-transparent dark:text-primary-500 dark:hover:text-white dark:border-gray-700 dark:hover:bg-primary-500  text-sm font-medium py-1 px-3 rounded mb-1 lg:mb-0 txt">Export TXT</button>
                    <button type="button" class="inline-block focus:outline-none text-primary-500 hover:bg-primary-500 hover:text-white bg-transparent border border-gray-200 dark:bg-transparent dark:text-primary-500 dark:hover:text-white dark:border-gray-700 dark:hover:bg-primary-500  text-sm font-medium py-1 px-3 rounded mb-1 lg:mb-0 json">Export JSON</button>
                    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                    
                    <!-- Init js -->
                    <script>
                    const dataTable_2 = new simpleDatatables.DataTable("#datatable_2")
                    document.querySelector("button.csv").addEventListener("click", () => {
                        dataTable_2.export({
                            type:"csv",
                            download: true,
                            lineDelimiter: "\n\n",
                            columnDelimiter: ";"
                        })
                    })
                    document.querySelector("button.sql").addEventListener("click", () => {
                        dataTable_2.export({
                            type:"sql",
                            download: true,
                            tableName: "export_table"
                        })
                    })
                    document.querySelector("button.txt").addEventListener("click", () => {
                        dataTable_2.export({
                            type:"txt",
                            download: true,
                        })
                    })
                    document.querySelector("button.json").addEventListener("click", () => {
                        dataTable_2.export({
                            type:"json",
                            download: true,
                            escapeHTML: true,
                            space: 3
                        })
                    })
                    $( document ).ready(function() {
                    $('.trigger').click(function() {
                        $('.modal-wrapper').toggleClass('open');
                        //$('.page-wrapper').toggleClass('blur');
                        return false;
                    });
                    });
                    </script>
<style>
  
    .blur {
        -webkit-filter: blur(5px);
        -moz-filter: blur(5px);
        -o-filter: blur(5px);
        -ms-filter: blur(5px);
        filter: blur(5px);
    }

    a.btn {
      margin-left: 3px;
      font-weight: 700;
      text-align: center;
      text-decoration: none;
      border-radius: 5px;
    }

    .modal-wrapper {
      width: 100%;
      height: 100%;
      position: fixed;
      top: 0;
      left: 0;
      background: rgba(255, 257, 153, 0.75);
      visibility: hidden;
      opacity: 0;
      -webkit-transition: all 0.25s ease-in-out;
      -moz-transition: all 0.25s ease-in-out;
      -o-transition: all 0.25s ease-in-out;
      transition: all 0.25s ease-in-out;
      z-index: 1;
    }

    .modal-wrapper.open {
      opacity: 1;
      visibility: visible;
      z-index: 1;

    }

    .modal {
      width: 600px;
      height: 400px;
      display: block;
      margin: 50% 0 0 -300px;
      position: relative;
      top: 50%;
      left: 50%;
      background: #fff;
      opacity: 0;
      -webkit-transition: all 0.5s ease-in-out;
      -moz-transition: all 0.5s ease-in-out;
      -o-transition: all 0.5s ease-in-out;
      transition: all 0.5s ease-in-out;
      z-index: 1111;
    }

    .modal-wrapper.open .modal {
      margin-top: -250px;
      opacity: 1;
      z-index: 1111;

    }

    .head {
      width: 100%;
      height: 70px;
      padding: 1.5em 5%;
      overflow: hidden;
      background: #01bce5;
    }

    .btn-close {
      width: 32px;
      height: 32px;
      display: block;
      float: right;
    }

    .btn-close::before,
    .btn-close::after {
      content: '';
      width: 32px;
      height: 6px;
      display: block;
      background: #fff;
    }

    .btn-close::before {
      margin-top: 12px;
      -webkit-transform: rotate(45deg);
      -moz-transform: rotate(45deg);
      -o-transform: rotate(45deg);
      transform: rotate(45deg);
    }

    .btn-close::after {
      margin-top: -6px;
      -webkit-transform: rotate(-45deg);
      -moz-transform: rotate(-45deg);
      -o-transform: rotate(-45deg);
      transform: rotate(-45deg);
    }

    .content {
      padding: 5%;
    }
                </style>
                <div class="modal-wrapper">
                <div class="modal">
                    <div class="head">
                    <a class="btn-close trigger" href="javascript:;"></a>
                    </div>
                    <div class="content">
                      <div>
                          <label for="Filiere" class="font-medium text-sm text-slate-600 dark:text-slate-400">Filiere</label>
                          <select id="filiere" name="load_filieres"  class="w-full rounded-md mt-1 border border-slate-300/60 dark:border-slate-700 dark:text-slate-300 bg-transparent px-3 py-[6.5px] focus:outline-none focus:ring-0 placeholder:text-slate-400/70 placeholder:font-normal placeholder:text-sm hover:border-slate-400 focus:border-primary-500 dark:focus:border-primary-500  dark:hover:border-slate-700">
                          </select>
                          <label for="Groupe" class="font-medium text-sm text-slate-600 dark:text-slate-400">Groupe</label>
                          <select id="Groupes" name="idgrp" class="w-full rounded-md mt-1 border border-slate-300/60 dark:border-slate-700 dark:text-slate-300 bg-transparent px-3 py-[6.5px] focus:outline-none focus:ring-0 placeholder:text-slate-400/70 placeholder:font-normal placeholder:text-sm hover:border-slate-400 focus:border-primary-500 dark:focus:border-primary-500  dark:hover:border-slate-700">
                          </select>

                          
                          <label for="Module" class="font-medium text-sm text-slate-600 dark:text-slate-400">Module</label>
                          <label class="custom-label block dark:text-slate-300">
                          <div id="modules" name="load_Modules" >
                                

                          </div>
                          </label> 
                          
                          
                          
                      </div>  
                    </div>
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
                              Mannatthemes</span>
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
        <!-- Include simple-datatables library -->
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/umd/simple-datatables.min.js"></script>                            
        <script src="../assets/js/app.js"></script>
        <script src="nvscript.js"></script>
        <!-- JAVASCRIPTS -->
    </body>
</html>