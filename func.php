<?php
$dbnm = "urlDragon";/*Database name*/
$dbus = "";/*your mysql password*/
$dbpw = "";/*your mysql password*/
$pdo=new PDO('mysql:host=localhost;port=3306;dbname='.$dbnm.';',$dbus,$dbpw);

function errMsgRedirect($msg,$loc)
{
$_SESSION['error'] = $msg;
header("Location: ".$loc);
}
function dataKeep($u,$e,$loc)
{
$_SESSION['u'] = $u;
$_SESSION['e'] = $e;
header("Location: ".$loc);
}

function getrand($n)
{
$characters = '0123456789abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz';
$randomString = '';
for ($i = 0; $i < $n; $i++)
{
$index = rand(0, strlen($characters) - 1);
$randomString .= $characters[$index];
}
return $randomString;
}

function loginCheck1($pdo)
{
if(isset($_COOKIE['user_data_code']))
{
$cd =$_COOKIE['user_data_code'];
$check = 0;
$raw_data = $pdo->query("select * from user_data");
while ($data = $raw_data->fetch(PDO::FETCH_ASSOC))
{
if(md5(strtolower($data['usnm']).strtolower($data['mail'])."dragonBoiExtraTextForExtraSecurity") == $cd)
{
$check = 1;
$arrData = $data;
}
}
if($check == 0){header("Location: home.php");}
}
else{header("Location: home.php");}
return $arrData;
}

function loginCheck2($pdo)
{
if(isset($_COOKIE['user_data_code']))
{
$cd =$_COOKIE['user_data_code'];
$check = 0;
$raw_data = $pdo->query("select * from user_data");
while ($data = $raw_data->fetch(PDO::FETCH_ASSOC))
{
if(md5(strtolower($data['usnm']).strtolower($data['mail'])."dragonBoiExtraTextForExtraSecurity") == $cd)
{
$check = 1;
}
}
if($check == 1){header("Location: index.php");}
}
}
?>
