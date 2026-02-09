<html>

<head>
    <title><?=$this->e($title)?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

    <nav>
        <ul>
            <li><a href="/users">Homepage</a></li>
            <li><a href="/about">About</a></li>
        </ul>
    </nav>

    <?=$this->section('content')?>
</body>

</html>