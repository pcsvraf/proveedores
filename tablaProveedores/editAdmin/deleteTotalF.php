<?php
$connect = mysqli_connect("localhost", "dgaeapuc_dgaea", "Dgaeapucv2020", "dgaeapuc_dgaea");

$query = "TRUNCATE TABLE listado";
$resultado = mysqli_query($connect,$query);
$reset_increment_column = "ALTER TABLE listado AUTO_INCREMENT = 1";
mysqli_query($connect, $reset_increment_column);
if($resultado)
{
  echo '<script> alert("Datos borrados exitosamente"); window.location = "../tableFinanzas.php" </script>';

}
else{
  echo 'Error al borrar datos';
}
?>
