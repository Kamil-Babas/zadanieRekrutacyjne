
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
            const typOpakowania = product.typ_opakowania;
            const dlugosc = product.dlugosc;
            const szerokosc = product.szerokosc;
            const button = `<button onclick="test('${nazwa}', '${producent}')">Test</button>`;

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
            cell5.innerHTML = dlugosc;
            cell6.innerHTML = szerokosc;
            cell7.innerHTML = button;
            i++;

        })
    }
    initializeDataTable();
}



function test(nazwa, prod) {
    alert(nazwa + prod)
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
            // {targets: [4], sortable: false},
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

}
