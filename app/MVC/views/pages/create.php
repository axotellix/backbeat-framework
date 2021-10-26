
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backbeat: Home</title>

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
        span {
            line-height: 1.5em;
            color: #2C2F42;
            font-size: 1.5rem;
            margin-top: 0;
            margin-bottom: 10px;
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
        form {
            display: flex;
            width: 500px;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }
        input {
            box-sizing: border-box;
            width: 100%; height: 40px;
            padding: 0 12px;
            border: 1px solid #ccc;
            border-radius: 3px;
            margin: 10px 0;
            transition: all 0.25s;
        }
        input[type='submit'] {
            cursor: pointer;
            color: #333;
        }
        input[type='submit']:hover {
            background: #ddd;
        }
    </style>
</head>
<body>
    
    <!-- [ HEADER ] -->
    @component('Header')
    
    <!-- [ MAIN ] -->
    <main>
        
        <h1> Backbeat. Create </h1>
        <p>create a new image</p>

        <form action="/create" method = "POST">
            <input name = 'URL' placeholder = 'URL ...' />
            <input name = 'description' placeholder = 'Description ...' />
            <input type = 'submit' value = 'create' />
        </form>

        
    </main>
    
    <!-- [ FOOTER ] -->
    @include('components/Footer')

</body>
</html>