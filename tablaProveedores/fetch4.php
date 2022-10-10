<?php
$connect = mysqli_connect("localhost", "dgaeapuc_dgaea", "Dgaeapucv2020", "dgaeapuc_dgaea");
 mysqli_set_charset($connect, "utf8");

 $column = array("listado.id", "listado.razonSocial", "listado.rut", "listado.direccion", "listado.ciudad", "listado.telefono", "listado.atencionProveedor", "listado.correo", "listado.idCategoria");
 $query =  "SELECT listado.id, listado.razonSocial, listado.rut, listado.direccion, listado.ciudad, listado.telefono,listado.atencionProveedor, listado.correo, listado.idCategoria,categorias.nombre FROM (listado
 INNER JOIN categorias ON categorias.id=listado.idCategoria)";
 $query .= " WHERE ";
 if (isset($_POST["is_category"])) {
     $query .= "listado.idCategoria = '" . $_POST["is_category"] . "' AND ";
 }
 if (isset($_POST["search"]["value"])) {
 $query .= '(listado.id LIKE "%' . $_POST["search"]["value"] . '%" ';
 $query .= 'OR listado.razonSocial LIKE "%' . $_POST["search"]["value"] . '%" ';
 $query .= 'OR listado.direccion LIKE "%' . $_POST["search"]["value"] . '%" ';
 $query .= 'OR listado.telefono LIKE "%' . $_POST["search"]["value"] . '%" ';
 $query .= 'OR listado.ciudad LIKE "%' . $_POST["search"]["value"] . '%" ';
 $query .= 'OR listado.atencionProveedor LIKE "%' . $_POST["search"]["value"] . '%" ';
 $query .= 'OR categorias.nombre LIKE "%' . $_POST["search"]["value"] . '%" ';
 $query .= 'OR listado.idCategoria LIKE "%' . $_POST["search"]["value"] . '%") ';
 }

 if (isset($_POST["order"])) {
     $query .= 'ORDER BY ' . $column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
 } else {
     $query .= 'ORDER BY listado.id ';
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
     $query = "SELECT * FROM listado";
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
