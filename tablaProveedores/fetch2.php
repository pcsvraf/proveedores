<?php
$connect = mysqli_connect("localhost", "udb_proveedores", "s4uw28vk", "db_proveedores");
mysqli_set_charset($connect, "utf8");
$column = array("listado.id", "listado.categoria", "listado.rut", "listado.telefono", "listado.direccion",
    "listado.atencionProveedor", "categorias.nombre", "listado.razonSocial");
$query = "
 SELECT * FROM listado 
 INNER JOIN categorias ON categorias.id = listado.idCategoria 
 ";
$query .= " WHERE ";
if (isset($_POST["is_category"])) {
    $query .= "listado.idCategoria = '" . $_POST["is_category"] . "' AND ";
}
if (isset($_POST["search"]["value"])) {
    $query .= '(listado.id LIKE "%' . $_POST["search"]["value"] . '%" ';
    $query .= 'OR listado.categoria LIKE "%' . $_POST["search"]["value"] . '%" ';
    $query .= 'OR categorias.nombre LIKE "%' . $_POST["search"]["value"] . '%" ';
    $query .= 'OR listado.rut LIKE "%' . $_POST["search"]["value"] . '%" ';
    $query .= 'OR listado.correo LIKE "%' . $_POST["search"]["value"] . '%" ';
    $query .= 'OR listado.atencionProveedor LIKE "%' . $_POST["search"]["value"] . '%" ';
    $query .= 'OR listado.ciudad LIKE "%' . $_POST["search"]["value"] . '%" ';
    $query .= 'OR listado.direccion LIKE "%' . $_POST["search"]["value"] . '%" ';
    $query .= 'OR listado.telefono LIKE "%' . $_POST["search"]["value"] . '%" ';
    $query .= 'OR listado.razonSocial LIKE "%' . $_POST["search"]["value"] . '%") ';
}

if (isset($_POST["order"])) {
    $query .= 'ORDER BY ' . $column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
} else {
    $query .= 'ORDER BY listado.id DESC ';
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
    $sub_array[] = $row["razonSocial"];
    $sub_array[] = $row["rut"];
    $sub_array[] = $row["nombre"];
    $sub_array[] = $row["direccion"];
    $sub_array[] = $row["ciudad"];
    $sub_array[] = $row["telefono"];
    $sub_array[] = $row["correo"];
    $sub_array[] = $row["atencionProveedor"];
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
