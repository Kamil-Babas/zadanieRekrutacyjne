function checkFileInput() {
    event.preventDefault(); // Prevent the default form submission behavior
    const fileInput = document.getElementById("fileInput");

    if (fileInput.files.length === 0) {
        alert("Nie wybrano pliku");
        return;
    }

    const file = fileInput.files[0];
    const fileName = file.name;
    const fileExtension = fileName.split(".").pop().toLowerCase();

    if (fileExtension !== "csv" && fileExtension !== "xlsx" && fileExtension !== "xls" && fileExtension !== 'ods')
    {
        alert("Wybierz plik  .csv / .xlsx / .xls ");
        fileInput.value = ""; // Clear the file input to allow selecting another file
        return;
    }

    sendRequest();
}

function sendRequest() {
    const formElement = document.getElementById("load_excel_form");
    const formData = new FormData(formElement);

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch('/excel/parse', {
        method: 'POST',
        body: formData, // FormData object automatically sets Content-Type header to multipart/form-data
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            const resultDiv = document.getElementById('resultDiv');
            resultDiv.innerHTML = data.message;
        })
        .catch(error => {
            window.alert('Fetch request error:');
            console.error('Error:', error);
        });
}
