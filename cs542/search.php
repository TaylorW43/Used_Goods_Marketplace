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
//echo "DB Connection Successful"."<br>";


if ($_REQUEST['keyword']){
    $keyword = explode(' ', $_REQUEST['keyword']);
    echo 'Got it !';
}
else{
    echo 'What are you looking for? ';

}

echo '<a href="https://stefanzhang.com/cs542"> Return </a>';

//https://wiki.jikexueyuan.com/project/php-and-mysql-web/keywords-and-search.html
//http://www.phpweblog.net/myhoth/archive/2008/05/26/3884.html
