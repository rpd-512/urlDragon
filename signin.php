<?php
require_once "func.php";
session_start();

$unm = "";
if(isset($_SESSION['u']))
{$unm = $_SESSION['u'];unset($_SESSION['u']);}

loginCheck2($pdo);
$errMsg = "";
if(isset($_SESSION['error'])){$errMsg = $_SESSION['error'];unset($_SESSION['error']);}
if(isset($_POST['usrnm']) and isset($_POST['psswd']))
{
$usnm = $_POST['usrnm'];
$pswd = md5($_POST['psswd']."ExtraStringForExtraSecurity");
$check = 0;
$raw_data = $pdo->query("select * from user_data  where usnm = '".$usnm."'");
while ($data = $raw_data->fetch(PDO::FETCH_ASSOC))
{
$check = 1;
$arrData = $data;
}
if($check == 1)
{
if(strtolower($pswd) == strtolower($arrData['pswd']))
{
setcookie("user_data.code",md5(strtolower($usnm).strtolower($arrData['mail'])."dragonBoiExtraTextForExtraSecurity"),time()+60*60*24*30);
header("Location: index.php");
}
else{errMsgRedirect("Incorrect password","signin.php"); dataKeep($usnm,"","signin.php");}
}
else{errMsgRedirect("Usernames not found!","signin.php"); dataKeep($usnm,"","signin.php");}
}
?>
<html>
<head>
<link rel="shortcut icon" type="image/png" href="images/favicon.png">
<link rel="stylesheet" href="css/style.css">
<title>URL Dragon || SignIn</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href='https://fonts.googleapis.com/css?family=Acme' rel='stylesheet'>
</head>
<style>
input{width:50%;font-family:acme;}
</style>
<body>
<center>
<hr>
<h1>URL Dragon</h1>
<hr>
<br>
<p>Good to see you back</p>
<form method='post'>
<input type='text' name='usrnm' placeholder='username' value='<?= $unm ?>'>
<br><br>
<input type='password' name='psswd' placeholder='password'>
<br><br>
<input type='button' value = 'Back' onclick="window.location='home.php';">
<input type='submit' value='Sign In'>
</form>
<p style='color:red;'><?= $errMsg; ?></p>
</center>
<p class='watermark'><a href='http://github.com/rpd-512'>RPD</a> productions</p>
</body>
</html>
