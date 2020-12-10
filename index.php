<?php
require_once "func.php";
session_start();

if(isset($_POST['lgout'])){setcookie("user_data.code","",0);header("Location: home.php");}
if(isset($_GET['l']))
{
$raw_data = $pdo->query("select * from saved_urls where shortUrl = '".$_GET['l']."';");
$available = 0;
while ($data = $raw_data->fetch(PDO::FETCH_ASSOC))
{
$available = 1;
$arrData = $data;
}
if($available == 1){header("Location: ".$arrData['mainUrl']);exit;}
else{header("Location: ../notfound.php");exit;}
}

$arrData = loginCheck1($pdo);
$id = $arrData['userId'];

$domloc = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

$errMsg = "";
$sucMsg = "";
$urlErr = "";

if(isset($_SESSION['error'])){$errMsg = $_SESSION['error'];unset($_SESSION['error']);}
if(isset($_SESSION['succs'])){$sucMsg = $_SESSION['succs'];unset($_SESSION['succs']);}
if(isset($_SESSION['url'])){$urlErr = $_SESSION['url'];unset($_SESSION['url']);}
if(isset($_POST['dlt'])){
$qry = "delete from saved_urls where shortUrl=:surl";
$raw_data = $pdo->prepare($qry);
$raw_data->execute(array(':surl' => $_POST['dlt']));
$_SESSION['succs'] = "Deleted successfully";header("Location: index.php");
}

if(isset($_POST['urlInp']))
{
$url = $_POST['urlInp'];
$surl = getrand(10);
if(strpos($url,".") and strpos($url,"//") and strlen($url) > 3)
{
$qry = "insert into saved_urls (userId,mainUrl,shortUrl) values(:id,:murl,:surl)";
$raw_data = $pdo->prepare($qry);
$raw_data->execute(array(
':id' => $id,
':murl' => $url,
':surl' => $surl
));
$_SESSION['succs'] = "URL Shortened";header("Location: index.php");
}
else{$_SESSION['error'] = "invalid url";$_SESSION['url'] = $url;header("Location: index.php");}
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
</center>
<form method='post'>
<table>
<td><p style='display:inline;'>Welcome back <?= $arrData['usnm'] ?></p></td>
<td><input style="text-align:center;" type='submit' value='Logout' name='lgout'></td>
</table>
</form>
<center>
<hr>
<br>
<form method='post'>
<input type="text" name="urlInp" value="<?= $urlErr; ?>" placeholder="Enter your long URL"/><input type="submit" value="Shorten">
</form>
<p class='error'> <?= $errMsg; ?> </p>
<p class='succs'> <?= $sucMsg; ?> </p>
<table>
<tr class='heading'><td>Actual URL</td><td>Shortened URL</td><td>Delete</td></tr>
<form method='post'>
<?php
$raw_data = $pdo->query("select * from saved_urls where userId = ".$id);
while ($data = $raw_data->fetch(PDO::FETCH_ASSOC))
{
$acc = $data['mainUrl'];
$shrt = $domloc."/?l=".$data['shortUrl'];
echo '<tr><td class="main_url"><div class="tooltip">'.$acc.'<span class="tooltiptext">'.$acc.'</span></div></td><td class="short_url"><a href="'.$shrt.'"><span>'.$shrt.'</span></a></td><td><button value="'.$data['shortUrl'].'" name="dlt" type="submit">Delete?</button></td></tr>';
}
?>
</form>
</table>
<hr>
</center>
</body>
</html>
