<?php
require_once "func.php";
session_start();
loginCheck2($pdo);
$unm = "";
$eml = "";
$errMsg = "";
if(isset($_SESSION['error'])){$errMsg = $_SESSION['error'];unset($_SESSION['error']);}
if(isset($_SESSION['u']) and isset($_SESSION['e']))
{
$unm = $_SESSION['u'];$eml = $_SESSION['e'];
unset($_SESSION['u']);unset($_SESSION['e']);
}

if(isset($_POST['usrnm']) and isset($_POST['mail']) and isset($_POST['psswd']))
{
$usnm = $_POST['usrnm'];
$mail = $_POST['mail'];
$pswd = md5($_POST['psswd']."ExtraStringForExtraSecurity");
$cpwd = md5($_POST['cpswd']."ExtraStringForExtraSecurity");
if($usnm != "" and $mail != "" and $pswd != "")
{
if($pswd == $cpwd)
{
$check = 0;
$raw_data = $pdo->query("select * from user_data  where usnm = '".$usnm."' or mail = '".$mail."'");
while ($data = $raw_data->fetch(PDO::FETCH_ASSOC)){$check = 1;}
if($check == 0)
{
$qry = "insert into user_data (usnm,mail,pswd) values(:usnm,:mail,:pswd)";
$raw_data = $pdo->prepare($qry);
$raw_data->execute(array(
':usnm' => $usnm,
':mail' => $mail,
':pswd' => $pswd
));
setcookie("user_data.code",md5(strtolower($usnm).strtolower($mail)."dragonBoiExtraTextForExtraSecurity"),time()+60*60*24*30);
header("Location: index.php");
}
else{errMsgRedirect("username or email already exists !","signup.php"); dataKeep($usnm,$mail,"signup.php");}
}
else{errMsgRedirect("Password mismatch !","signup.php"); dataKeep($usnm,$mail,"signup.php");}
}
else
{errMsgRedirect("All credentials are necessary!","signup.php"); dataKeep($usnm,$mail,"signup.php");}
}

?>
<html>
<head>
<link rel="shortcut icon" type="image/png" href="images/favicon.png">
<link rel="stylesheet" href="css/style.css">
<title>URL Dragon || SignUp</title>
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
<p>Sign Up today for free</p>
<form method='post'>
<input type='text' name='usrnm' placeholder='username' value='<?= $unm; ?>'>
<br><br>
<input type='email' name='mail' placeholder='email' value='<?= $eml; ?>'>
<br><br>
<input type='password' name='psswd' placeholder='password'>
<br><br>
<input type='password' name='cpswd' placeholder='confirm password'>
<br><br>
<input type='button' value = 'Back' onclick="window.location='home.php';">
<input type='submit' value='Sign Up'>
</form>
<p style='color:red;'><?= $errMsg; ?></p>
</center>
<p class='watermark'><a href='http://github.com/rpd-512'>RPD</a> productions</p>
</body>
</html>
