$(document).ready(function () {
    var idProf = null;
    $('.btn-trigger').on('click', function () {
        // Get the data-idprof attribute value
        idProf = $(this).data('idprof');
        //console.log(idProf);
        loadFilieres();
    });
    // Charge les filières au chargement de la page
    // Attache un gestionnaire d'événement au changement de la filière
    $('#filiere').change(function () {
        $('#modules').empty();
        loadGroupes(idProf);
    });
    // Attache un gestionnaire d'événement au changement de la filière
    // $('#modules').change(function () {
    //     $('#Groupes').empty();
    //     $('#tableBody').empty();
    //     loadGroupes(idProf);
        
    // });

    // Attache un gestionnaire d'événement au changement du groupe
    $('#Groupes').change(function () {
        $('#modules').empty();
        loadModules(idProf); // Charge les candidats une fois le groupe sélectionné
    });
    
});

function loadModules(idProf) {
    var selectedFiliere = $('#filiere').val();
    var selectedGroupe = $('#Groupes').val();
    $.ajax({
        url: 'dataloaded.php',
        type: 'GET',
        data: { action: 'load_modules',idProf:idProf, idfiliere: selectedFiliere, idgroupe: selectedGroupe }, // Ajout de l'action et de l'idfiliere
        dataType: 'json',
        success: function (response) {
            var data = response.data;
            var dataothers = response.dataothers;
            var moduleDropdown = $('#modules');

            // Remplit la liste déroulante des modules
            //moduleDropdown.empty(); // Efface les options précédentes
            //moduleDropdown.append('<option value="">Sélectionner module</option>');

            $.each(data, function (index, item) {
                // moduleDropdown.append('<option value="' + item.idmodule + '">' + item.libelleM + '</option>');
                // moduleDropdown.append('<input value = "'+ item.idmodule +'" type="checkbox" class="hidden"><i class="fas fa-check hidden text-xs text-green-500"></i></div>'+ item.libelleM);
                moduleDropdown.append('<label class="custom-label block dark:text-slate-300"><div class="bg-white dark:bg-slate-700  border border-slate-200 dark:border-slate-600 rounded w-4 h-4  inline-block leading-4 text-center -mb-[3px]"><input type="checkbox" class="hidden" value = "'+item.idmodule+'" checked><i class="fas fa-check hidden text-xs text-green-500"></i></div> '+item.libelleM+' </label>');
            });
            $.each(dataothers, function (index, item) {
                // moduleDropdown.append('<option value="' + item.idmodule + '">' + item.libelleM + '</option>');
                // moduleDropdown.append('<input value = "'+ item.idmodule +'" type="checkbox" class="hidden"><i class="fas fa-check hidden text-xs text-green-500"></i></div>'+ item.libelleM);
                moduleDropdown.append('<label class="custom-label block dark:text-slate-300"><div class="bg-white dark:bg-slate-700  border border-slate-200 dark:border-slate-600 rounded w-4 h-4  inline-block leading-4 text-center -mb-[3px]"><input type="checkbox" class="hidden" value = "'+item.idmodule+'"><i class="fas fa-check hidden text-xs text-green-500"></i></div> '+item.libelleM+' </label>');
            });
            // Attach event listener for checkbox change
            moduleDropdown.find('input[type="checkbox"]').change(function () {
                var moduleId = $(this).val();
                var isChecked = $(this).prop('checked');

                // Perform insertion or deletion based on checkbox state
                if (isChecked) {
                    // Insert into Enseigner table
                    insertIntoEnseigner(idProf, selectedGroupe, selectedFiliere, moduleId);
                } else {
                    // Delete from Enseigner table
                    deleteFromEnseigner(idProf, selectedGroupe, selectedFiliere, moduleId);
                }
            });
        },
        error: function (error) {
            console.log('Erreur Ajax: ', error);
        }
    })};

    
function insertIntoEnseigner(idProf, idGroupe, idFiliere, idModule) {
    $.ajax({
        url: 'dataloaded.php',
        type: 'POST',
        data: { action: 'insert_enseigner', idProf: idProf, idGroupe: idGroupe, idFiliere: idFiliere, idModule: idModule },
        dataType: 'json',
        success: function (response) {
            console.log('Insertion successful:', response);
        },
        error: function (error) {
            console.log('Error during insertion:', error);
        }
    });
}

function deleteFromEnseigner(idProf, idGroupe, idFiliere, idModule) {
    $.ajax({
        url: 'dataloaded.php',
        type: 'POST',
        data: { action: 'delete_enseigner', idProf: idProf, idGroupe: idGroupe, idFiliere: idFiliere, idModule: idModule },
        dataType: 'json',
        success: function (response) {
            console.log('Deletion successful:', response);
        },
        error: function (error) {
            console.log('Error during deletion:', error);
        }
    });
}

function loadFilieres() {
    $.ajax({
        url: 'dataloaded.php',
        type: 'GET',
        data: { action: 'load_filieres' }, // Ajout de l'action pour spécifier la requête
        dataType: 'json',
        success: function (data) {
            var filiereDropdown = $('#filiere');

            // Remplit la liste déroulante des filières
            filiereDropdown.empty();
            filiereDropdown.append('<option value="">Sélectionner Filiére</option>');
            $.each(data, function (index, item) {
                filiereDropdown.append('<option value="' + item.idfiliere + '">' + item.libelleF + '</option>');
            });

            // Charge les groupes une fois la filière sélectionnée
            //loadGroupes();
        },
        error: function (error) {
            console.log('Erreur Ajax: ', error);
        }
    });
}

function loadGroupes(idProf) {
    var selectedFiliere = $('#filiere').val();
    //var selectedModule = $('#modules').val();

    $.ajax({
        url: 'dataloaded.php',
        type: 'GET',
        data: { action: 'load_groupes',idProf:idProf , idfiliere: selectedFiliere }, // Ajout de l'action et de l'idfiliere
        dataType: 'json',
        success: function (data) {
            var groupeDropdown = $('#Groupes'); // Correction de l'ID ici

            // Remplit la liste déroulante des groupes
            groupeDropdown.empty(); // Efface les options précédentes
            groupeDropdown.append('<option value="">Sélectionner groupe</option>');

            $.each(data, function (index, item) {
                groupeDropdown.append('<option value="' + item.idgrp + '">' + item.nomgrp + '</option>');
            });

            // Charge les candidats une fois le groupe sélectionné
            //loadCandidats();
        },
        error: function (error) {
            console.log('Erreur Ajax: ', error);
        }
    });
}
/*
function updateNote(idedu, type, value) {
    $.ajax({
        url: '../dataloaded.php', // Create a new PHP file for handling the updates
        type: 'POST',
        data: { idedu: idedu, type: type, value: value },
        dataType: 'json',
        success: function (response) {
            // Handle success, if needed
            console.log('Note updated successfully');
        },
        error: function (error) {
            console.log('Erreur Ajax: ', error);
        }
    });}
    
function loadCandidats() {
    var selectedFiliere = $('#filiere').val();
    var selectedGroupe = $('#Groupes').val(); // Correction de l'ID ici

    $.ajax({
        url: '../dataloaded.php',
        type: 'GET',
        data: { action: 'load_candidats', idfiliere: selectedFiliere, idgrp: selectedGroupe }, // Ajout de l'action et de l'idgrp
        dataType: 'json',
        success: function (data) {
            var tbody = $('#tableBody');

            // Vide le tableau précédent
            tbody.empty();

            // Remplit le tableau avec les candidats
            $.each(data, function (index, item) {
                var row = '<tr class="bg-white border-b border-dashed dark:bg-gray-900 dark:border-gray-700/40">' +
                '<td class="font-thin dark:text-white p-3 text-sm text-primary-500 whitespace-nowrap dark:text-gray-400">' +
                '<input type="text" type="number" id="idedu" name="idedu" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b border-slate-300/60 appearance-none dark:text-slate-300 dark:border-slate-700 dark:focus:border-primary-500 focus:outline-none focus:ring-0 focus:border-primary-500 peer" disabled value =' + item.idedu + '></td>' +
                '<td class="font-thin dark:text-white p-3 text-sm text-primary-500 whitespace-nowrap dark:text-gray-400">' + '<input type="text" id="nomedu" name="nomedu" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b border-slate-300/60 appearance-none dark:text-slate-300 dark:border-slate-700 dark:focus:border-primary-500 focus:outline-none focus:ring-0 focus:border-primary-500 peer" disabled value ='+item.NOM_COMPLET+'></td>' +
                '<td class="p-3 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">' +
                '<input type="text" type="number" id="note_devoir" name="devoir" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b border-slate-300/60 appearance-none dark:text-slate-300 dark:border-slate-700 dark:focus:border-primary-500 focus:outline-none focus:ring-0 focus:border-primary-500 peer" oninput="updateNote(' + item.idedu + ', \'DEVOIRE\',this.value);"  value =' + item.note_devoir + ' />' +
                '</td>' +
                '<td class="p-3 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">' +
                '<input type="text" name="note_controle" id="note_controle" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b border-slate-300/60 appearance-none dark:text-slate-300 dark:border-slate-700 dark:focus:border-primary-500 focus:outline-none focus:ring-0 focus:border-primary-500 peer" oninput="updateNote(' + item.idedu + ', \'CONTROLE\',this.value);" value =' + item.note_controle + ' />' +
                '</td>' +
                '<td class="p-3 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">' +
                '<input type="text" name="note_exam" id="note_exam" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b border-slate-300/60 appearance-none dark:text-slate-300 dark:border-slate-700 dark:focus:border-primary-500 focus:outline-none focus:ring-0 focus:border-primary-500 peer" oninput="updateNote(' + item.idedu + ', \'EXAM\', this.value);" value=' + item.note_exam + ' />' +
                '</td>' +
                '<td class="p-3 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400 bg-slate-100 dark:bg-slate-700/20">' +
                '<input type="text" name="note_moyenne" id="note_moyenne" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b border-slate-300/60 appearance-none dark:text-slate-300 dark:border-slate-700 dark:focus:border-primary-500 focus:outline-none focus:ring-0 focus:border-primary-500 peer" value=' + item.moyenne + ' />' +
                '</td>' +
                '</tr>';

            tbody.append(row);

            });
        },
        error: function (error) {
            console.log('Erreur Ajax: ', error);
        }
    });
}*/
