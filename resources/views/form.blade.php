<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }
    </style>
</head>
<body>
<form method="post" action="{{route('file')}}" enctype="multipart/form-data">

    <input type="text" name="title" value="abc">
    <input type="file" name="file">
    {{csrf_field()}}
    <input type="submit">
</form>
</body>
</html>
