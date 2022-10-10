<?php
$connect = mysqli_connect("localhost", "dgaeapuc_dgaea", "Dgaeapucv2020", "dgaeapuc_dgaea");

if(isset($_POST["id"])){
 $value = utf8_decode(mysqli_real_escape_string($connect, $_POST["value"]));
 $query = "UPDATE listadoAdmin SET ".$_POST["column_name"]."='$value' WHERE id = '".$_POST["id"]."'";

 if (strcmp($_POST["column_name"], "nombre") === 0){
    $dato= "SELECT id FROM categoriasAdmin WHERE nombre = '".$value."'";
    $id_existente = mysqli_query($connect,$dato);
    $id_e = mysqli_fetch_row($id_existente);
    $prueba = $id_e[0];

    $contar= mysqli_num_rows($id_existente);
    if($contar == 0){//si el id no existe
      $query3= "INSERT INTO categoriasAdmin (nombre) VALUES ('$value')";
      $query5 = "SELECT id FROM categoriasAdmin order by id DESC LIMIT 1";
      $re = mysqli_query($connect,$query5);
      $nuevo = mysqli_fetch_row($re);
      $id_nuevo = $nuevo[0] + 1;//nuevo id para nueva categoria
      if(mysqli_query($connect, $query3))
      {
        echo '';
      }
      $query3=  "UPDATE listadoAdmin SET idCategoria='$id_nuevo' WHERE id = '".$_POST["id"]."'";
      if(mysqli_query($connect, $query3))
      {
        echo 'Proveedor actualizado';
      }
    }
    else{
      $query3=  "UPDATE listadoAdmin SET idCategoria='$prueba' WHERE id = '".$_POST["id"]."'";
      if(mysqli_query($connect, $query3))
      {
        echo 'Proveedor Actualizado';
      }
    }
 }

 if(mysqli_query($connect, $query))
 {
  echo 'Proveedor Actualizado';
 }
 else {
  echo '';
 }
}
?>
