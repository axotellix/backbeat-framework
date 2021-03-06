
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backbeat: About</title>

    <!-- [ STYLES ] -->
    <style>
        html {
            font-family: 'Montserrat', sans-serif;
            font-size: 10px;
        }
        body {
            margin: 0;
            padding: 50px;
            background: #F7F6F9;
        }

        h1 {
            color: Orange;
            font-weight: 700;
            font-size: 6rem;
            margin-top: 40px;
            margin-bottom: 10px;
            text-align: left;
        }
        p {
            line-height: 1.5em;
            color: #757993;
            font-size: 1.8rem;
            margin-top: 0;
            margin-bottom: 30px;
        }
        a {
            display: inline-block;
            color: #252536;
            font-size: 1.5rem;
            margin-right: 15px;
            text-align: center;
            text-decoration: none;
            border-bottom: 2px solid #252536;
            padding: 2px;
            transition: 0.25s;
        }
        a:hover {
            color: Orange;
            border-color: Orange;
        }
    </style>
</head>
<body>
    
    <!-- [ HEADER ] -->
    <? require_once(__DIR__ . '/../components/Header.php') ?>

    <!-- [ MAIN ] -->
    <main>

        <h1> Backbeat. About </h1>
        <p>a simple PHP backend-framework</p>

    </main>

</body>
</html>