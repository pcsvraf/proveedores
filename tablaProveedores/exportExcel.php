<?php

//export.php
header("Content-Type: application/xls; charset=utf-8");
header("Content-Disposition: attachment; filename= listadoAdmin.xls");
header("Pragma: no-cache");
header("Expires: 0");

$connect = mysqli_connect("localhost", "dgaeapuc_dgaea", "Dgaeapucv2020", "dgaeapuc_dgaea");
mysqli_set_charset($connect, "utf8");
$output = '';

$query = "SELECT * from listadoAdmin";
$result = mysqli_query($connect, $query);
if (mysqli_num_rows($result) > 0) {
    $output .= utf8_decode('
   <table class="table" border="1" cellspacing=0 cellpadding=2>
                    <tr>
                         <th>Id</th>
                         <th>Razon Social</th>
                         <th>Rut</th>
                         <th>Dirección</th>
                         <th>Ciudad</th>
                         <th>Teléfono</th>
                         <th>Atención Proveedor</th>
                         <th>Correo</th>
                         <th>Id Categoria</th>
                         <th>Nombre Categoria</th>
                    </tr>
  ');
    while ($datos = mysqli_fetch_row($result)) {
      $query2 = "SELECT nombre from categoriasAdmin WHERE id=$datos[8]";
      $result2 = mysqli_query($connect, $query2);
      $nom= mysqli_fetch_row($result2);

        $output .= '
    <tr>
                         <td>' . $datos[0] . '</td>
                         <td>' . utf8_decode($datos[1]) . '</td>
                         <td>' . $datos[2] . '</td>
                         <td>' . utf8_decode($datos[3]) . '</td>
                         <td>' . utf8_decode($datos[4]) . '</td>
                         <td>' . $datos[5] . '</td>
                         <td>' . utf8_decode($datos[6]) . '</td>
                         <td>' . $datos[7] . '</td>
                         <td>' . $datos[8] . '</td>
                         <td>' . utf8_decode($nom[0]) . '</td>
                    </tr>
   ';
    }
    $output .= '</table>';
    echo $output;
}
exit();
?>
