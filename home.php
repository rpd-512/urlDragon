<?php
require_once "func.php";
session_start();
loginCheck2($pdo);
if(isset($_GET['wrk']))
{
if($_GET['wrk'] == "snup"){header("Location: signup.php");}
if($_GET['wrk'] == "snin"){header("Location: signin.php");}
}
?>
<html>
<head>
<link rel="shortcut icon" type="image/png" href="images/favicon.png">
<link rel="stylesheet" href="css/style.css">
<title>URL Dragon</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href='https://fonts.googleapis.com/css?family=Acme' rel='stylesheet'>
</head>

<body>
<center>
<hr>
<h1>URL Dragon</h1>
<hr>
<br>
<p>a free URL shortener made for people like you</p>
<form method='get'>
<button type='submit' value='snup' name='wrk'>Sign Up</button> <button type='submit' value='snin' name='wrk'>Sign In</button>
</form>
<img src='images/favicon.png' class='dragon_001'/>
</center>
</body>
</html>
