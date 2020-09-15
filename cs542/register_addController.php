<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

<?php
$servername = "localhost";
$username = "cs542";
$password = "cs542";
$dbname = "cs542";
// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);
// 检测连接
if (!$conn) {
    die("DB Connection failed: " . mysqli_connect_error());
}

//Fetching Values from URL
$username=strval($_GET['username']);
$email=strval($_GET['email']);
$Phone_Number=intval($_GET['Phone_Number']);
$Address=strval($_GET['Address']);
$card=intval($_GET['card']);
$card_cvv=intval($_GET['card_cvv']);
$psw=strval($_GET['psw']);

$SQL = "INSERT INTO Buyer (Bname, Bemail, Bphone, Baddress, Bcredit_card, Bpassword, Bcredit_card_cvv) 
VALUES ('$username','$email',$Phone_Number,'$Address',$card,'$psw',$card_cvv)";

if ($conn->query($SQL)) {
    echo '<h1> Register Buyer Success </h1>';
    echo '<a href="https://stefanzhang.com/cs542/login.php"> Login </a>';
}
else{
    echo '<h1> Not Success, please check </h1>';
    echo '<a href="https://stefanzhang.com/cs542/register.php"> Return </a>';
}
?>