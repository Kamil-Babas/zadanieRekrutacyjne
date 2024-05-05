<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('css/loadExcel.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<x-navbar></x-navbar>

<h1 align="center">Load Excel</h1>

<div style="margin-top: 0.7rem;">

    <form method="post" id="load_excel_form" enctype="multipart/form-data">

        <div class="form-wrapper">

            <div>
                <label for="fileInput">Select Excel File</label>
            </div>

            <div>
                <input id="fileInput" type="file" name="select_excel" />
            </div>

            <div>
                <input type="submit" onclick="checkFileInput()"/>
            </div>

        </div>

    </form>

</div>

<div class="resultDiv">
    Przesyłanie plików zostało "wyłączone" <br/>
    Funkcjonalność ta powstała w celu <br/>
    jednorazowego wprowadzenia danych do bazy
</div>

<div id="resultDiv" class="resultDiv">

</div>

<script src="{{ asset('js/loadExcel.js') }}"></script>

</body>
</html>
