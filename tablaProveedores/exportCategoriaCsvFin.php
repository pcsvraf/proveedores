<?php

//export.php

$connect = mysqli_connect("localhost", "dgaeapuc_dgaea", "Dgaeapucv2020", "dgaeapuc_dgaea");
mysqli_set_charset($connect, "utf8");

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=categoriasFinanzas.csv');
echo "\xEF\xBB\xBF";
$output = fopen("php://output", "w");
fputcsv($output, array('ID', 'NOMBRE'), ';');
$query = "SELECT * from categorias ORDER BY id ASC";
$result = mysqli_query($connect, $query);
while($row = mysqli_fetch_row($result))
{
     fputcsv($output, $row, ';');
}
fclose($output);
?>
