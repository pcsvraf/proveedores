<?php
$connect = mysqli_connect("localhost", "dgaeapuc_dgaea", "Dgaeapucv2020", "dgaeapuc_dgaea");
//obteniendo datos desde el formulario en la tabla
if(isset($_POST["razonSocial"],  $_POST["rut"], $_POST["direccion"], $_POST["ciudad"], $_POST["telefono"], $_POST["atencionProveedor"], $_POST["correo"], $_POST["categoria"]))
{
 $razon = mysqli_real_escape_string($connect, $_POST["razonSocial"]);
 $rut = mysqli_real_escape_string($connect, $_POST["rut"]);
 $direccion = mysqli_real_escape_string($connect, $_POST["direccion"]);
 $ciudad = mysqli_real_escape_string($connect, $_POST["ciudad"]);
 $telefono = mysqli_real_escape_string($connect, $_POST["telefono"]);
 $atencion = mysqli_real_escape_string($connect, $_POST["atencionProveedor"]);
 $correo = mysqli_real_escape_string($connect, $_POST["correo"]);
 $categoria = mysqli_real_escape_string($connect, $_POST["categoria"]);
//se selecciona el id de la persona para ver en que id debo agregar el nuevo
$query1 = "SELECT id FROM listadoAdmin order by id DESC LIMIT 1";
$resultado = mysqli_query($connect,$query1);
$id = mysqli_fetch_row($resultado);
$ide = $id[0] + 1; //id nuevo

//se decodifican los textos para que acepte utf8
$rsocial = utf8_decode($razon);
$dir = utf8_decode($direccion);
$ciud = utf8_decode($ciudad);
$aproveedor = utf8_decode($atencion);
$categ = utf8_decode($categoria);

//para obtener el id de la categoria ingresada cuando este ya existe
$dato= "SELECT id FROM categoriasAdmin WHERE nombre = '".$categ."'";
$id_existente = mysqli_query($connect,$dato);
$id_e = mysqli_fetch_row($id_existente);
$cat = $id_e[0];

$contar= mysqli_num_rows($id_existente);
if($contar == 0 ){//si el id no existe
  $query3= "INSERT INTO categoriasAdmin (nombre) VALUES ('$categ')";
  $query5 = "SELECT id FROM categoriasAdmin order by id DESC LIMIT 1";
  $re = mysqli_query($connect,$query5);
  $nuevo = mysqli_fetch_row($re);
  $id_nuevo = $nuevo[0] + 1;//nuevo id para nueva categoria
  if(mysqli_query($connect, $query3))
  {
    echo '';
  }
  $rs=mysqli_query("SELECT @@identity AS id");
  if($row=mysqli_fetch_row($rs)){
    $id_n=trim($row[0]);
  }
  $query = "INSERT INTO listadoAdmin(id, razonSocial, rut, direccion, ciudad, telefono, atencionProveedor, correo, idCategoria)"
         . " VALUES('$ide', '$rsocial', '$rut', '$dir', '$ciud', '$telefono', '$aproveedor', '$correo', '$id_nuevo')";
  if(mysqli_query($connect, $query))
  {
    echo 'Proveedor agregado';
  }
  else{
    echo 'Error al insertar proveedor';
  }

}
else{//id de categoria existe
    $query = "INSERT INTO listadoAdmin(id, razonSocial, rut, direccion, ciudad, telefono, atencionProveedor, correo, idCategoria)"
           . " VALUES('$ide', '$rsocial', '$rut', '$dir', '$ciud', '$telefono', '$aproveedor', '$correo', '$cat')";
    if(mysqli_query($connect, $query))
    {
      echo 'Proveedor agregado';
    }
    else{
      echo 'Error al insertar proveedor';
    }

}}
?>
