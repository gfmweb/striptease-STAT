<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>BVCRM</title>
</head>
<body>
<div class="logo">BVCRM / STAT</div>
<a class="login" href="{{ route('home') }}">вход</a>
<style type="text/css">
    body {
        height: 100vh;
        margin: 0;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        background: linear-gradient(97deg, #949494, #e8e8e8);
    }

    .logo {
        font-size: 7em;
        font-weight: bold;
        color: rgba(81, 150, 128, 0.82);
        font-family: "PT SANS", Arial, serif;
        text-shadow: 0px -53px 0px rgba(128, 128, 128, 0.38);
        transition: all 1s ease;
    }

    .login {
        text-decoration: none;
        font-size: 4em;
        font-weight: bold;
        color: rgb(227, 227, 227);
        font-family: "PT SANS", Arial, serif;
        text-transform: uppercase;
        margin-top: 4vh;
        text-shadow: 2px 3px 0px rgba(128, 128, 128, 0.38);
        transition: all 1s ease;
    }

    .login:hover {
        color: rgb(255, 255, 255);
    }
</style>
</body>
</html> 
