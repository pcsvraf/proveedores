<?php
$connect = mysqli_connect("localhost", "dgaeapuc_dgaea", "Dgaeapucv2020", "dgaeapuc_dgaea");
 mysqli_set_charset($connect, "utf8");

 $column = array("listadoAdmin.id", "listadoAdmin.razonSocial", "listadoAdmin.rut", "listadoAdmin.direccion", "listadoAdmin.ciudad", "listadoAdmin.telefono", "listadoAdmin.atencionProveedor", "listadoAdmin.correo", "listadoAdmin.idCategoria");
 $query =  "SELECT listadoAdmin.id, listadoAdmin.razonSocial, listadoAdmin.rut, listadoAdmin.direccion, listadoAdmin.ciudad, listadoAdmin.telefono,listadoAdmin.atencionProveedor, listadoAdmin.correo, listadoAdmin.idCategoria,categoriasAdmin.nombre FROM (listadoAdmin
 INNER JOIN categoriasAdmin ON categoriasAdmin.id=listadoAdmin.idCategoria)";
 $query .= " WHERE ";
 if (isset($_POST["is_category"])) {
     $query .= "listadoAdmin.idCategoria = '" . $_POST["is_category"] . "' AND ";
 }
 if (isset($_POST["search"]["value"])) {
 $query .= '(listadoAdmin.id LIKE "%' . $_POST["search"]["value"] . '%" ';
 $query .= 'OR listadoAdmin.razonSocial LIKE "%' . $_POST["search"]["value"] . '%" ';
 $query .= 'OR listadoAdmin.direccion LIKE "%' . $_POST["search"]["value"] . '%" ';
 $query .= 'OR listadoAdmin.telefono LIKE "%' . $_POST["search"]["value"] . '%" ';
 $query .= 'OR listadoAdmin.ciudad LIKE "%' . $_POST["search"]["value"] . '%" ';
 $query .= 'OR listadoAdmin.atencionProveedor LIKE "%' . $_POST["search"]["value"] . '%" ';
 $query .= 'OR categoriasAdmin.nombre LIKE "%' . $_POST["search"]["value"] . '%" ';
 $query .= 'OR listadoAdmin.idCategoria LIKE "%' . $_POST["search"]["value"] . '%") ';
 }

 if (isset($_POST["order"])) {
     $query .= 'ORDER BY ' . $column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
 } else {
     $query .= 'ORDER BY listadoAdmin.id ';
 }

 $query1 = '';

 if ($_POST["length"] != 1) {
     $query1 .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
 }

 $number_filter_row = mysqli_num_rows(mysqli_query($connect, $query));

 $result = mysqli_query($connect, $query . $query1);

 $data = array();

 while ($row = mysqli_fetch_array($result)) {
 $sub_array = array();
 $sub_array[] = '<div contenteditable class="update" data-id="' . $row["id"] . '" data-column="razonSocial">' . $row["razonSocial"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="' . $row["id"] . '" data-column="rut">' . $row["rut"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="' . $row["id"] . '" data-column="nombre">' . $row["nombre"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="' . $row["id"] . '" data-column="direccion">' . $row["direccion"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="' . $row["id"] . '" data-column="ciudad">' . $row["ciudad"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="' . $row["id"] . '" data-column="telefono">' . $row["telefono"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="' . $row["id"] . '" data-column="correo">' . $row["correo"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="' . $row["id"] . '" data-column="atencionProveedor">' . $row["atencionProveedor"] . '</div>';
 $sub_array[] = '<button type="button" name="delete" class="btn btn-link btn-xs delete" id="' . $row["id"] . '"><font color="#dc3545"><i class="material-icons">delete_forever</i></font></button>';
 $data[] = $sub_array;
 }

 function get_all_data($connect) {
     $query = "SELECT * FROM listadoAdmin";
     $result = mysqli_query($connect, $query);
     return mysqli_num_rows($result);
 }

 $output = array(
     "draw" => intval($_POST["draw"]),
     "recordsTotal" => get_all_data($connect),
     "recordsFiltered" => $number_filter_row,
     "data" => $data
 );

 echo json_encode($output);
 ?>
