<?php session_start(); ?>


<?php
echo "
<head><link rel='stylesheet' type='text/css' href='style.css'></head>

<center>";

error_reporting(E_ALL);
ini_set('display_errors', 1);

  // phpinfo();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {//si el usuario esta registrado puede acceder a la pagina
  $hostname = "db";
  $username = "admin";
  $password = "test";
  $db = "database";

  $conn = mysqli_connect($hostname,$username,$password,$db);
  if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT followedMail FROM `seguidores` WHERE followerMail=?; ";
  $stmt= $conn->prepare($sql);//prepara el texto sql para que no haya inyecciones sql
  $stmt->bind_param("s", $_SESSION['username']);//asigna los parametros
  $stmt->execute();
  $result = $stmt->get_result(); // conseguir el resultado sql







  $query = mysqli_query($conn, "SELECT * FROM usuarios")
     or die (mysqli_error($conn));
  $followedA=array();
  while($row = mysqli_fetch_array($result)){
    print($row['followedMail']);
    array_push($followedA,$row['followedMail']);

  }
  while ($row = mysqli_fetch_array($query)) {
    $mail=$row["mail"];

    if (in_array($row["mail"],$followedA)){
      echo
        "<body style='background-color:#887162;'>
      <form method='POST'  action='follow.php?fmail=$mail&follow=False'><tr>
        <td>Nombre: {$row['nombre']}</td><br>
        <td>Gustos: {$row['gustos']}</td><br>
        <td>Mail:{$mail}</td><br><br><br>


        <input type='submit' value='unfollow'><br>
        <center>_______________________________________<br></center>

        </form>
        </tr><br><br>";
    }else{
      echo
      "<body style='background-color:#887162;'>
      <form method='POST'  action='follow.php?fmail=$mail&follow=True'><tr>
        <td>Nombre: {$row['nombre']}</td><br>
        <td>Gustos: {$row['gustos']}</td><br>
        <td>Mail:{$mail}</td><br>
        <input type='submit' value='follow'><br>
        <center>_______________________________________<br></center>


        </form>
        </tr><br><br>";
    }


  }
}else{
      echo 'No estas loggeado. <a href="registro.html><b><n>Login</a><br><br>';
}
echo '</div>';

?>
