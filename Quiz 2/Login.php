<?php
session_start();
if(isset($_COOKIE['cookie_uername'])){
    $cookie_username = $_COOKIE['cookie-username'];
    $cookie_password = $_COOKIE['cookie_password'];

    $sql1 = "select * from login where username = '$cookie-username'";
    $q1 = mysqli_query(koneksi,$sql1);
    $r1 = mysqli_fetch_array($r1);
    if($r1['password'] == $cookie_password){
        $_SESSION['session_username'] = $cookie_username;
        $_SESSION['session_username'] = $cookie_password;
    }
}

if(isset($_SESSION['session_username'])){
    header("location:anggota.php");
    exit();
}
$host_db = "localhost";
$user_db = "root";
$pass_db = "";
$nama_db = "login";
$koneksi = mysqli_connect($host_db_,$user_db,$pass_db,$nama_db);

$err = "";
$username = "";
$ingatkansaya = "";
?>

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $ingatkansaya = $_POST['ingatkansaya'];

    if($username == '' or $password == ''){
        $err = "<li>Silakan masukkan username dan password anda </li>"
    }else{
        $sql1 = "select * from login where username = '$username'";
        $sq1 = mysqli_query($koneksi,$sql1);
        $r1 = mysqli_fetch_array($q1);

        if($r1['username'] == ''){
            $err = "<li>Username <b>$username</b> tidak tersedia </li>";
        }elseif($r1['password'] != md5($password)){
            $err = "<li>password yang dimasukkan tidak sesuai </li>";  
        }

        if(empty($err)){
            $_SESSION['session_username'] = $username;
            $_SESSION['session_password'] = md5($password);
            
            if(ingatkansaya == 1){
                $cookie_name = "cookie_username";
                $cookie_value = $username;
                $cookie_time = time() + (60 * 60 * 24 * 30);
                setcookie($cookie_name,$cookie_value,$cookie_time,"/");

                $cookie_name = "cookie_password";
                $cookie_value = md5($password);
                $cookie_time = time() + (60 * 60 * 24 * 30);
                setcookie($cookie_name,$cookie_value,$cookie_time,"/");
            }
            header("location:anggota.php");
        }
    }
}