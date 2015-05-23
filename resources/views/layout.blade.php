<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pollie</title>
    <style type="text/css" media="screen">
        html,
        body {
            background: #e2e3e2;
            color: #222;
            font-family: "Helvetica Neue", Helvetica;
            font-size: 16px;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        * {
            box-sizing: border-box;
        }
        ul {
            list-style: none;
            margin: 0;
            padding: 0;
            text-align: left;
        }
        li {
            margin: 0;
            padding: 0;
        }
        li span {
            padding: 0 20px;
        }
        .container {
            background: #fff;
            margin: 20px auto;
            max-width: 800px;
            padding: 20px 40px;
            position: relative;
            width: 100%;
        }
        a {
            color: #00A388;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.1s ease;
        }
        a:hover {
            color: #00705d;
        }
        button {
            background: #00A388;
            border: none;
            color: #fff;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
            padding: 1em 3em;
            transition: all 0.1s ease;
        }
        button:hover {
            background: #00705d;
            color: #fff;
        }
        .hide {
            display: none;
        }
        .transition-content {
            opacity: 0;
            transition: all 0.3s ease;
        }
        .visible {
            opacity: 1;
        }
        .footer {
            color: #999;
            padding: 40px 20px 60px;
            text-align: center;
        }
        .form-row {
            font-size: 0;
            margin-bottom: 20px;
            text-align: center;
            width: 100%;
        }
        .form-col {
            display: inline-block;
            font-size: 16px;
            max-width: 130px;
            width: 30%;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        input[type="text"] {
            font-size: 20px;
            font-weight: bold;
            padding: 10px;
            text-align: center;
            width: 90%;
        }
    </style>
</head>
<body>
    <div class="container">
        @yield('content')
    </div>

    <footer class="footer">
        <small>&copy; {{date('Y')}} A Viget Stunt</small>
    </footer>

    @yield('footer')
</body>
</html>
