<?php
$connect = mysqli_connect("localhost", "dgaeapuc_dgaea", "Dgaeapucv2020", "dgaeapuc_dgaea");
mysqli_set_charset($connect, "utf8");
$column = array("listadoAdmin.id", "listadoAdmin.rut", "listadoAdmin.telefono", "listadoAdmin.direccion",
    "listadoAdmin.atencionProveedor", "categoriasAdmin.nombre", "listadoAdmin.razonSocial");
$query = "
 SELECT * FROM listadoAdmin
 INNER JOIN categoriasAdmin ON categoriasAdmin.id = listadoAdmin.idCategoria
 ";
$query .= " WHERE ";
if (isset($_POST["is_category"])) {
    $query .= "listadoAdmin.idCategoria = '" . $_POST["is_category"] . "' AND ";
}
if (isset($_POST["search"]["value"])) {
    $query .= '(listadoAdmin.id LIKE "%' . $_POST["search"]["value"] . '%" ';
    $query .= 'OR categoriasAdmin.nombre LIKE "%' . $_POST["search"]["value"] . '%" ';
    $query .= 'OR listadoAdmin.rut LIKE "%' . $_POST["search"]["value"] . '%" ';
    $query .= 'OR listadoAdmin.correo LIKE "%' . $_POST["search"]["value"] . '%" ';
    $query .= 'OR listadoAdmin.atencionProveedor LIKE "%' . $_POST["search"]["value"] . '%" ';
    $query .= 'OR listadoAdmin.ciudad LIKE "%' . $_POST["search"]["value"] . '%" ';
    $query .= 'OR listadoAdmin.direccion LIKE "%' . $_POST["search"]["value"] . '%" ';
    $query .= 'OR listadoAdmin.telefono LIKE "%' . $_POST["search"]["value"] . '%" ';
    $query .= 'OR listadoAdmin.razonSocial LIKE "%' . $_POST["search"]["value"] . '%") ';
}

if (isset($_POST["order"])) {
    $query .= 'ORDER BY ' . $column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
} else {
    $query .= 'ORDER BY listadoAdmin.id DESC ';
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
