<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>
<body>
    <x-navbar></x-navbar>

    <div class="container">

        <div class="formContainer">
            <form>
                <h2>Wyszukiwanie produktu</h2>
                <input id="searchInput" type="text" placeholder="Nazwa produktu lub producent">
            </form>
        </div>

        <div class="productsContainer">
            <h1 class="tableHeader">Products: </h1>

            <div id="tabProductsWrapper">

                <div id="table-wrapper" class="productsTableContainer">
                    <table id="myTable">
                        <thead class="header-sticky">
                            <th>#</th>
                            <th>Nazwa</th>
                            <th>Producent</th>
                            <th>Typ opakowania</th>
                            <th>Długość</th>
                            <th>Szerokość</th>
                            <th>Akcje</th>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>

    <script src="{{asset('js/welcome.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

</body>
</html>
