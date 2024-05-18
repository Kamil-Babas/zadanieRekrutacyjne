
const searchInput = document.getElementById('searchInput');

searchInput.addEventListener("keydown", function(event) {
    if (event.key === "Enter") {
        event.preventDefault();
    }
});

searchInput.addEventListener("input", sendRequest);

function sendRequest() {
    const searchInputValue = searchInput.value.trim();
    const url = `/api/products/search?q=${searchInputValue}`

    if (searchInputValue === '') {
        $('#myTable tbody').empty();

        // Destroy DataTable instance if exists
        if ($.fn.DataTable.isDataTable('#myTable')) {

            const dataTableInstance = $('#myTable').DataTable();
            dataTableInstance.clear().destroy();

            $('#tabProductsWrapper .dataTables-controls').remove();
            $('#tabProductsWrapper .dataTables_length').remove();
            $('#tabProductsWrapper .dataTables_info').remove();
            $('#tabProductsWrapper .dataTables_paginate').remove();
            $('#tabProductsWrapper .dataTables_filter').remove();
        }

    }
    else
    {
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                createTableRows(data);
            })
            .catch(error => {
                // Handle errors
                console.error('There was a problem with the fetch operation:', error);
            });
    }



}

function createTableRows(response) {

    $('#myTable tbody').empty();
    const tbody = document.getElementById('myTable').getElementsByTagName('tbody')[0];

    // Destroy DataTable instance if exists
    if ($.fn.DataTable.isDataTable('#myTable')) {
        const dataTableInstance = $('#myTable').DataTable();
        dataTableInstance.clear().destroy();
    }

    let i = 0;

    if(response.length > 0) {
        response.forEach((product, index) => {

            const nazwa = product.nazwa_produktu;
            const producent = product.producent;
            const typOpakowania = product.typ_opakowania ? product.typ_opakowania : '---';
            const dlugosc = product.dlugosc;
            const szerokosc = product.szerokosc;
            const minimalnaIlosc = calculateQuantity(
                           product.jednostka_ceny,
                           product.typ_opakowania,
                           product.jednostki_zakupu);

            const row = tbody.insertRow(index);
            const cell1 = row.insertCell(0);
            const cell2 = row.insertCell(1);
            const cell3 = row.insertCell(2);
            const cell4 = row.insertCell(3);
            const cell5 = row.insertCell(4);
            const cell6 = row.insertCell(5);
            const cell7 = row.insertCell(6);

            // Populate the cells with data
            cell1.textContent = i + 1;
            cell2.textContent = nazwa;
            cell3.textContent = producent;
            cell4.textContent = typOpakowania;
            cell5.textContent = dlugosc;
            cell6.textContent = szerokosc;
            cell7.textContent = minimalnaIlosc;
            i++;

        })
    }
    initializeDataTable();
}

//dataTable
function initializeDataTable(){

    $('#tabProductsWrapper .dataTables-controls').remove();
    $('#tabProductsWrapper .dataTables_length').remove();
    $('#tabProductsWrapper .dataTables_info').remove();
    $('#tabProductsWrapper .dataTables_paginate').remove();
    $('#tabProductsWrapper .dataTables_filter').remove();

    $('#myTable').DataTable({
        paging: true,
        searching: true,
        lengthMenu: [[100, -1, 10, 25, 50, 100, 250], ["Domyślnie (100)","Wszystkie", 10, 25, 50, 100, 250]],
        language: {
            search: "",
            lengthMenu: "Pokaż _MENU_ pozycji",
            info: `Pozycje od <span class="color0-font">_START_</span> do <span class="color0-font">_END_</span> (<span class="color0-font">_TOTAL_</span> pozycji łącznie)`,
            infoFiltered: `(Przefiltrowano z <span class="color0-font">_MAX_</span> wszystkich rekordów)`,
            paginate: {
                previous: `<i class="icon-chevron-left"></i>`,
                next: `<i class="icon-chevron-right"></i>`
            }
        },
        columnDefs: [
            // Disable sorting for this column}
            // {targets: [0], sortable: false},
            {targets: [6], sortable: false},
        ]
    });

    // Stwórz dodatkowy div na elementy paska DataTables
    const dataTableControlsDiv = $('<div class="dataTables-controls"></div>');

    const insertToDiv = $('#table-wrapper');

    //insert przed divem
    dataTableControlsDiv.insertBefore(insertToDiv);

    // Find the div with class "dataTable_length"
    const dataTableLengthDiv = $('#myTable_wrapper .dataTables_length');

    //insert before
    dataTableLengthDiv.insertBefore(dataTableControlsDiv);

    dataTableControlsDiv.append(dataTableLengthDiv);
    dataTableControlsDiv.append($('#myTable_filter'));

    // // Move the pagination info to the new div
    $('#myTable_wrapper .dataTables_paginate').appendTo(dataTableControlsDiv);

    // Move the pagination to the end of the "myTable_wrapper" div
    $('#tabProductsWrapper').append($('#myTable_wrapper .dataTables_info'));

    $('.dataTables_filter input[type="search"]').addClass('search-table');
    $('.dataTables_length select').addClass('select-table');

    // Obsługa kliknięcia w nagłówki kolumn
    $('#myTable thead tr:first-child th').on('click', function() {
        let th = $(this);
        let icon = th.find('.sort-icon');

        // Usuń ikony sortowania z innych kolumn
        $('#myTable thead th .sort-icon').not(icon).removeClass('up down');

        // Dodaj odpowiednią ikonę sortowania
        if (th.hasClass('sorting_asc')) {
            icon.addClass('up').removeClass('down');
        } else if (th.hasClass('sorting_desc')) {
            icon.addClass('down').removeClass('up');
        } else {
            icon.removeClass('up down');
        }
    });

    const searchInput = document.querySelector('input[type="search"]');
    searchInput.placeholder = "Find in table";

}


function calculateQuantity(jednostkaCeny, typOpakowania, jednostkiZakupu) {
    // quantity to order
    let orderQuantity = 'unknown quantity';

    if(typOpakowania === 'rolka'){
        switch(jednostkiZakupu) {

            case '1 pełna paleta':
                orderQuantity = '80 rolek';
                break;

            case '':
                orderQuantity = '150 M2'
                break;
        }
    }

    if(typOpakowania === 'karton'){
        switch(jednostkiZakupu){

            case '1 pełna paleta':
                orderQuantity = '7 kartonów';
                break;

                case '1 paczka':
                // paczka to 1/2 palety na palecie miesci sie 7 kartonow
                // pol palety kartonow to 3,5 kartonu czyli do zamowienia 3 kartony
                orderQuantity = '3 kartony'
                break;
        }
    }

    if(typOpakowania === 'paczka'){
        switch(jednostkiZakupu){
            case '1 pełna paleta':
                orderQuantity = '2 paczki';
                break;
        }
    }

    if(typOpakowania === 'paleta'){
        switch(jednostkiZakupu){
            case '1 pełna paleta':
                orderQuantity = '1 paleta';
                break;
        }
    }

    if(typOpakowania === ''){
        switch(jednostkiZakupu){

            case '80 szt':
                orderQuantity = '80 sztuk';
                break;

            case '':
                switch(jednostkaCeny){
                    case 'M2':
                        orderQuantity = '150 M2';
                        break;
                    case 'szt':
                        orderQuantity = '400 sztuk'
                        break;
                    case 'paczka':
                        orderQuantity = '2 paczki'
                        break;
                    case 'KRT':
                        orderQuantity = 'jednostka zakupu KRT? czy to karton?'
                        break;
                    case 'M':
                        orderQuantity = '200 M'
                        break;
                    case 'M3':
                        orderQuantity = '1 M3'
                        break;
                }
                break;

            case '7 szt':
                orderQuantity = '7 sztuk';
                break;

            case '10 szt':
                orderQuantity = '10 sztuk';
                break;

            case '1 pełna paleta':
                switch(jednostkaCeny){
                    case 'M2':
                        orderQuantity = '150 M2';
                        break;
                    case 'szt':
                        orderQuantity = '400 sztuk'
                        break;
                    case 'paczka':
                        orderQuantity = '2 paczki'
                        break;
                    case 'KRT':
                        orderQuantity = 'jednostka zakupu KRT? czy to karton?'
                        break;
                    case 'M':
                        orderQuantity = '200 M'
                        break;
                    case 'M3':
                        orderQuantity = '1 M3'
                        break;
                }
                break;

            case '192 szt':
                orderQuantity = '192 sztuki';
                break;

            case '216 szt':
                orderQuantity = '216 sztuki';
                break;

            case '100 szt':
                orderQuantity = '100 sztuki';
                break;

            case '144 szt':
                orderQuantity = '144 sztuki';
                break;

            case '72 szt':
                orderQuantity = '72 sztuki';
                break;

            case '54 szt':
                orderQuantity = '54 sztuki';
                break;

            case '48 szt':
                orderQuantity = '48 sztuki';
                break;

            case '90 szt':
                orderQuantity = '90 sztuki';
                break;

            case '24 szt':
                orderQuantity = '24 sztuki';
                break;

            case '200 szt':
                orderQuantity = '200 sztuki';
                break;

            case '1 szt':
                orderQuantity = '1 sztuka';
                break;

            case '1 paczka':
                orderQuantity = '1 paczka';
                break;

            case '12 paczka':
                orderQuantity = '12 paczek';
                break;

            case '10 paczka':
                orderQuantity = '10 paczek';
                break;
        }
    }

    return orderQuantity;
}



