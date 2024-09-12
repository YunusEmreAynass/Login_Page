<?php
$host = "localhost"; //php sayfamızı mysqlimize bağlıyoruz
$user = "root"; //kullanıcı adı
$password = ""; //şifre
$database = "login"; //veritabanı

$conn = mysqli_connect($host, $user, $password, $database); //true false döner
mysqli_set_charset($conn, "utf8");
