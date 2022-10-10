<?php
$connect = mysqli_connect("localhost", "dgaeapuc_dgaea", "Dgaeapucv2020", "dgaeapuc_dgaea");
mysqli_set_charset($connect, "utf8");
$query = "SELECT * FROM categorias ORDER BY nombre ASC";
$result = mysqli_query($connect, $query);
?>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Programa Calidad de Servicios</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <link rel="stylesheet" href="librerias/bootstrap-3.3.6/dist/css/bootstrap.min.css" />
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
        <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Quicksand|Raleway" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
        <style type="text/css">
          .anotherhover tbody tr:hover td {
              background-color: #D3D3D3;
          }
          .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
    border: 1px solid #fff;
}
@media screen and (max-width: 600px) {
  table {
    border: 0;
  }

  table caption {
    font-size: 1.3em;
  }

  table thead {
    border: none;
    clip: rect(0 0 0 0);
    height: 1px;
    margin: -1px;
    overflow: hidden;
    padding: 0;
    position: absolute;
    width: 1px;
  }

  table tr {
    border-bottom: 3px solid #ddd;
    display: block;
    margin-bottom: .625em;
  }

  table td {
    border-bottom: 1px solid #ddd;
    display: block;
    font-size: .8em;
    text-align: right;
  }

  td:nth-of-type(1) { font-weight: bold; }
  td:nth-of-type(1):before { content: "Proveedor"; }
  td:nth-of-type(2):before { content: "rut"; }
  td:nth-of-type(3):before { content: "categoria"; }
  td:nth-of-type(4):before { content: "direccion"; }
  td:nth-of-type(5):before { content: "ciudad"; }
  td:nth-of-type(6):before { content: "fono"; }
  td:nth-of-type(7):before { content: "correo"; }
  td:nth-of-type(8):before { content: "contacto"; }

  table td::before {
    /*
    * aria-label has no advantage, it won't be read inside a table
    content: attr(aria-label);
    */
    content: attr(data-label);
    float: left;
    font-weight: bold;
    text-transform: uppercase;
  }

  table td:last-child {
    border-bottom: 0;
  }
}
        </style>
    </head>
    <body>
        <div class="container-fluid">
          <font size="2" face="Quicksand" >
            <table id="listado" style="font-size: 15px; width: 100%;" class="table anotherhover table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="color: #000; font-size: 13px;"><font color="#006eb6"><i class="fas fa-users"></i></font>  <?php echo utf8_decode('R. SOCIAL'); ?></th>
                        <th style="color: #000; font-size: 13px;"><font color="#006eb6"><i class="fas fa-address-card"></i></font>  RUT</th>
                        <th style="color: #000; font-size: 13px;">
                            <select name="category" id="category" class="form-control" style="background-color: #006eb6; color: #FFF">
                                <option value="">TODAS LAS CATEGORIAS</option>
                                <?php
                                while ($row = mysqli_fetch_array($result)) {
                                    echo utf8_decode('<option value="' . $row["id"] . '">' . utf8_encode($row["nombre"]) . '</option>');
                                }
                                ?>
                            </select>
                        </th>
                        <th style="color: #000; font-size: 13px;"><font color="#006eb6"><i class="fas fa-building"></i></i></font>  DIRECCIÓN</th>
                        <th style="color: #000; font-size: 13px;"><font color="#006eb6"><i class="fas fa-city"></i></font>  CIUDAD</th>
                        <th style="color: #000; font-size: 13px;"><font color="#006eb6"><i class="fas fa-phone-volume"></i></font>  <?php echo utf8_decode('FONO'); ?></th>
                        <th style="color: #000; font-size: 13px;"><font color="#006eb6"><i class="fas fa-envelope"></i></font>  CORREO</th>
                        <th style="color: #000; font-size: 13px;"><font color="#006eb6"><i class="fas fa-user-circle"></i></font>  CONTACTO</th>
                    </tr>
                </thead>
            </table>
          </font>
        </div>
        <script type="text/javascript" src="librerias/bootstrap-3.3.6/dist/js/bootstrap.min.js"></script>
    </body>
</html>
<script type="text/javascript" language="javascript" >
    $(document).ready(function () {

        load_data();
        function load_data(is_category)
        {
            $('#listado').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },
                "processing": true,
                "serverSide": true,
                "order": false,
                "ordering": false,
                "ajax": {
                    url: "fetch2.php",
                    type: "POST",
                    data: {is_category: is_category}
                },
                "columnDefs": [
                    {
                        "targets": [2],
                        "orderable": false
                    }
                ]
            });
        }

        $(document).on('change', '#category', function () {
            var category = $(this).val();
            $('#listado').DataTable().destroy();
            if (category != '')
            {
                load_data(category);
            } else
            {
                load_data();
            }
        });
    });


</script>
