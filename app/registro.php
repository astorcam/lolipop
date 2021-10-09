<?php


  // phpinfo();
  $hostname = "db";
  $username = "admin";
  $password = "test";
  $db = "database";

  $conn = mysqli_connect($hostname,$username,$password,$db);
  if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
  }





 //https://phpdelusions.net/mysqli_examples/insert


$contrasenaHasheada=password_hash($_GET["fcontrasena"],PASSWORD_DEFAULT); //esto se usa para hashear la contraseña https://www.php.net/manual/en/function.password-hash.php
$sql = "INSERT INTO usuarios (nombre,apellidos, mail, contrasena) VALUES (?,?,?,?); ";
$stmt= $conn->prepare($sql);//prepara el texto sql para que no haya inyecciones sql

$stmt->bind_param("ssss", $_GET["fnombre"],$_GET["fapellidos"], $_GET["fmail"], $contrasenaHasheada );//asigna los parametros


if ($stmt->execute()) {//ejecuta la instruccion sql


    echo ' rows updated properly!';
} else {

    print_r($stmt->error);
}

?>
