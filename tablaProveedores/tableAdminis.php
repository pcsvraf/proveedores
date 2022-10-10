<?php
$connect = mysqli_connect("localhost", "dgaeapuc_dgaea", "Dgaeapucv2020", "dgaeapuc_dgaea");
mysqli_set_charset($connect, "utf8");
$query = "SELECT * FROM categoriasAdmin";
$result = mysqli_query($connect, $query);
?>
<html>
    <head>
	      <meta charset="UTF-8" />
       <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <link rel="stylesheet" href="../tablaProveedores/librerias/bootstrap-3.3.6/dist/css/bootstrap.min.css" />
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Quicksand|Raleway" rel="stylesheet">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

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
          <h1 align="center"></h1>
            <div align="left">
                <button type="button" name="add" id="add" class="btn btn-success"><i class="material-icons">library_add</i></button>
                <button type="button" name="borrado" id="borrado" class="btn btn-danger">Eliminar todos los datos</button>
            </div>
            <br>
            <div id="alert_message"></div>

            <div class="width200">
              <font size="2" face="Quicksand" >
                <table id="user_data" style="width: 100%;" class="table table-bordered table-striped anotherhover">
                    <thead>
                        <tr>
                            <th style="color: #000; font-size: 13px;"><font color="#006eb6"><i class="fas fa-users"></i></font>  <?php echo utf8_decode("R. SOCIAL") ?></th>
                            <th style="color: #000; font-size: 13px;"><font color="#006eb6"><i class="fas fa-address-card"></i></font>  RUT</th>
                            <th style="color: #000; font-size: 13px;"><font color="#006eb6"><i class="fas fa-tag"></i></font>  CATEGORIA</th>
                            <th style="color: #000; font-size: 13px;"><font color="#006eb6"><i class="fas fa-building"></i></i></font>  DIRECCIÓN</th>
                            <th style="color: #000; font-size: 13px;"><font color="#006eb6"><i class="fas fa-city"></i></font>  CIUDAD</th>
                            <th style="color: #000; font-size: 13px;"><font color="#006eb6"><i class="fas fa-phone-volume"></i></font>  FONO</th>
                            <th style="color: #000; font-size: 13px;"><font color="#006eb6"><i class="fas fa-envelope"></i></font>  CORREO</th>
                            <th style="color: #000; font-size: 13px;"><font color="#006eb6"><i class="fas fa-user-circle"></i></font>  CONTACTO</th>
                            <th style="color: #000; font-size: 13px;"></th>
                        </tr>
                    </thead>
                </table>
              </font>
            </div>
        </div>

    </body>
    <script type="text/javascript" language="javascript">
    function showfield(name){
      if(name=='other')document.getElementById('div1').innerHTML='<input id="other" class="form-control" type="text" name="other" />';
      else document.getElementById('div1').innerHTML='';
      }
        $(document).ready(function () {

            fetch_data();

            function fetch_data()
            {
                var dataTable = $('#user_data').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                    },
                    "processing": true,
                    "serverSide": true,
                    "order": false,
                    "ordering": false,
                    "bInfo": false,
                    "ajax": {
                        url: "../tablaProveedores/fetch3.php",
                        type: "POST",
                        dataType: "json"
                    }
                });
            }

            function update_data(id, column_name, value)
            {
                $.ajax({
                    url: "../tablaProveedores/editAdmin/update.php",
                    method: "POST",
                    data: {id: id, column_name: column_name, value: value},
                    success: function (data)
                    {
                        $('#alert_message').html('<div class="alert alert-success">' + data + '</div>');
                        $('#user_data').DataTable().destroy();
                        fetch_data();
                    }
                });
                setInterval(function () {
                    $('#alert_message').html('');
                }, 5000);
            }

            $(document).on('blur', '.update', function () {
                var id = $(this).data("id");
                var column_name = $(this).data("column");
                var value = $(this).text();
                var validaRut = /^\d{7,8}-[k|K|\d]{1}$/;
                var reg = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.([a-zA-Z]{2,4})+$/;
                if (column_name != "rut" && column_name != "email") {
                    update_data(id, column_name, value);
                } else if (column_name == "rut" && validaRut.test(value)) {
                    update_data(id, column_name, value);
                } else if (column_name == "correo" && reg.test(value)) {
                    update_data(id, column_name, value);
                } else {
                    alert("El e-mail no es validos");
                    window.location = "tableAdminis.php";
                }
            });
            $('#add').click(function () {

                var html = '<tr>';
                //html += '<td></td>';
                html += '<td contenteditable id="data1"></td>';
                html += '<td contenteditable id="data2"></td>';
                html += '<td id="data8"><select name="category" id="category" class="form-control" onchange="showfield(this.options[this.selectedIndex].value)"><option value="">Seleccione Categoria</option><?php while ($row = mysqli_fetch_array($result)) {echo ('<option value="' . $row["id"] . '">' . utf8_decode($row["nombre"]) . '</option>');}?><option value="other">Otro</option></select><div id="div1"></div></td>';
                html += '<td contenteditable id="data3"></td>';
                html += '<td contenteditable id="data4"></td>';
                html += '<td contenteditable id="data5"></td>';
                html += '<td contenteditable id="data7"></td>';
                html += '<td contenteditable id="data6"></td>';
                html += '<td><button type="button" name="insert" id="insert" class="btn btn-link btn-xs"><font color="#4cae4c"><i class="material-icons">person_add</i></font></button></td>';
                html += '</tr>';
                $('#user_data tbody').prepend(html);
            });

            $(document).on('click', '#borrado', function () {
              if (confirm("\u00BFEst\u00e1s seguro que deseas eliminar todos los datos?"))
                window.location = "../tablaProveedores/editAdmin/deleteTotal.php";

              });

            $(document).on('click', '#insert', function () {
                var razonSocial = $('#data1').text();
                var rut = $('#data2').text();
                var direccion = $('#data3').text();
                var ciudad = $('#data4').text();
                var telefono = $('#data5').text();
                var atencionProveedor = $('#data6').text();
                var correo = $('#data7').text();
                if ($('#category option:selected').text()=="Otro"){
                  //var r= document.getElementById(div1);
                  var categoria= document.getElementById("other").value;
                }
                else{
                  var categoria=  $('#category option:selected').text();
                }

                var reg = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.([a-zA-Z]{2,4})+$/;
                if (razonSocial != '' && atencionProveedor == '') {
                    $.ajax({
                        url: "../tablaProveedores/editAdmin/insert.php",
                        method: "POST",
                        data: {razonSocial: razonSocial, rut: rut, direccion: direccion, ciudad: ciudad, telefono: telefono, atencionProveedor: atencionProveedor, correo: correo, categoria: categoria},
                        success: function (data)
                        {
                            $('#alert_message').html('<div class="alert alert-success">' + data + '</div>');
                            $('#user_data').DataTable().destroy();
                            fetch_data();
                        }
                    });
                    setInterval(function () {
                        $('#alert_message').html('');
                    }, 5000);
                } else if (razonSocial != '' && atencionProveedor != '' && reg.test(correo))
                {
                    $.ajax({
                        url: "../tablaProveedores/editAdmin/insert.php",
                        method: "POST",
                        data: {razonSocial: razonSocial, rut: rut, direccion: direccion, ciudad: ciudad, telefono: telefono, atencionProveedor: atencionProveedor, correo: correo, categoria: categoria},
                        success: function (data)
                        {
                            $('#alert_message').html('<div class="alert alert-success">' + data + '</div>');
                            $('#user_data').DataTable().destroy();
                            fetch_data();
                        }
                    });
                    setInterval(function () {
                        $('#alert_message').html('');
                    }, 5000);
                } else
                {
                    alert("Debe llenar correctamente los datos");
                }
            });
            $(document).on('click', '.delete', function () {
                var id = $(this).attr("id");
                var texto='\u00BFEst\u00e1s seguro de eliminar este proveedor?';
                if (confirm(texto))
                {
                    $.ajax({
                        url: "../tablaProveedores/editAdmin/delete.php",
                        method: "POST",
                        data: {id: id},
                        success: function (data) {
                            $('#alert_message').html('<div class="alert alert-success">' + data + '</div>');
                            $('#user_data').DataTable().destroy();
                            fetch_data();
                        }
                    });
                    setInterval(function () {
                        $('#alert_message').html('');
                    }, 5000);
                }
            });

            });

    </script>
</html>
