<?php
$connect = mysqli_connect("localhost", "dgaeapuc_dgaea", "Dgaeapucv2020", "dgaeapuc_dgaea");
if(isset($_POST["id"]))
{
 $query = "DELETE FROM listadoAdmin WHERE id = '".$_POST["id"]."'";
 if(mysqli_query($connect, $query))
 {
  echo "Proveedor eliminado correctamente";
 }
}
?>
