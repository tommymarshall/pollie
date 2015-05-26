<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pollie</title>
    <style type="text/css" media="screen">
        html,
        body {
            background: #092F40;
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
            padding: 20px 80px;
            position: relative;
            text-align: left;
            width: 100%;
        }
        a {
            color: #F26D21;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.1s ease;
        }
        a:hover {
            color: #F26D21;
        }
        .primary {
            background: #F26D21;
            border: none;
            color: #fff;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
            padding: 1em 3em;
            transition: all 0.1s ease;
        }
        .primary:hover {
            background: #d4550c;
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
            margin-bottom: 20px;
            width: 100%;
        }
        .form-col {
            font-size: 16px;
        }
        h1 {
            text-align: center;
            font-weight: normal;
        }
        h1 b {
            display: block;
            font-size: 10px;
            text-transform: uppercase;
        }
        label {
            border-bottom: 2px solid #ddd;
            color: #092F40;
            display: inline-block;
            font-weight: bold;
            margin-top: 16px;
            padding-bottom: 8px;
        }
        small {
            color: #777;
            display: inline-block;
            font-size: 12px;
        }
        input[type="password"],
        input[type="text"] {
            border: none;
            border-bottom: 1px solid #ddd;
            display: block;
            font-size: 28px;
            padding: 10px;
            width: 100%;
        }
        .message {
            background: #c2ecf8;
            padding: 20px 40px;
            position: relative;
        }
        .options {
            margin-bottom: 10px;
        }
        .options li {
            position: relative;
            margin-bottom: 6px;
        }
        .options li:hover .delete-button {
            opacity: 1;
        }
        .add-option {
            background: #eee;
            border: 1px solid #ddd;
        }
        .delete-button {
            background-color: #d9534f;
            border-radius: 50%;
            border: 0;
            color: #fff;
            cursor: pointer;
            font-size: 14px;
            height: 24px;
            line-height: 1;
            opacity: 0;
            padding: 0;
            position: absolute;
            right: 4px;
            text-align: center;
            top: 14px;
            transition: all 0.3s ease;
            width: 24px;
        }
        .delete-button:hover {
            background-color: #c9302c;
        }
        .pin-form {
            text-align: center;
        }
        .pin-form label {
            display: inline-block;
            margin: 0 auto;
            text-align: center;
        }
        .pin-form input[type="text"] {
            font-size: 80px;
            margin: 0 auto;
            padding: 12px;
            text-align: center;
            width: 250px;
            letter-spacing: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        @if(Session::has('message'))
            <div class="message">
                <p>{{{ Session::get('message') }}}</p>
            </div>
        @endif

        @yield('content')
    </div>

    <footer class="footer">
        <small>&copy; {{date('Y')}} A Viget Stunt</small>
    </footer>

    @yield('footer')
</body>
</html>
