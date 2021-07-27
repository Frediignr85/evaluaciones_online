<?php
    include("_core.php");

    $requestData= $_REQUEST;


    require('ssp.customized.class.php');
    // DB table to use
    $table = 'tblcarrera';
    // Table's primary key
    $primaryKey = 'id_facultad';

    // MySQL server connection information
    $sql_details = array(
      'user' => $usuario,
      'pass' => $clave,
      'db'   => $dbname,
      'host' => $servidor
    );

    //permiso del script
    $id_user=$_SESSION["id_usuario"];
    $admin=$_SESSION["admin"];
    $id_sucursal=$_SESSION["id_sucursal"];
    $uri = $_SERVER['SCRIPT_NAME'];
    $filename=get_name_script($uri);
    $links=permission_usr($id_user, $filename);

    $joinQuery = " FROM  tblcarrera INNER JOIN tblfacultad on tblfacultad.id_facultad = tblcarrera.id_facultad";

    $extraWhere = " tblcarrera.deleted is NULL ";

    $columns = array(
    array( 'db' => '`tblcarrera`.`id_carrera`', 'dt' => 0, 'field' => 'id_carrera'  ),
    array( 'db' => "tblcarrera.nombre", 'dt' => 1, 'field' => "nombre"),
    array( 'db' => '`tblcarrera`.`descripcion`', 'dt' => 2, 'field' => 'descripcion'  ),
    array( 'db' => '`tblfacultad`.`nombre`', 'dt' => 3, 'field' => 'nombre_facultad', 'as' => 'nombre_facultad'  ),
    array( 'db' => '`tblcarrera`.`id_carrera`', 'dt' => 4, 'formatter' => function ($id_carrera) {
        $id_user=$_SESSION["id_usuario"];
    	$admin=$_SESSION["admin"];
        $tabla="<td class='col col col-lg-1'><div class=\"btn-group\">
        <a href=\"#\" data-toggle=\"dropdown\" class=\"btn btn-primary dropdown-toggle\"><i class=\"fa fa-user icon-white\"></i> Menu<span class=\"caret\"></span></a>
        <ul class=\"dropdown-menu dropdown-primary\">";
        $sql_x = "SELECT * FROM tblcarrera where id_carrera = '$id_carrera'";
        $query = _query($sql_x);
        $row_x = _fetch_array($query);
        $filename='editar_carrera.php';
        $link=permission_usr($id_user,$filename);
        if ($link!='NOT' || $admin=='1' ){
            $tabla.= "<li><a href=\"editar_carrera.php?id_carrera=".$id_carrera."\"><i class=\"fa fa-pencil\"></i> Editar</a></li>";
        }
        $filename='borrar_carrera.php';
        $link=permission_usr($id_user,$filename);
        if ($link!='NOT' || $admin=='1' ){
            $tabla.= "<li><a data-toggle='modal' href='borrar_carrera.php?id_carrera=".$id_carrera."' data-target='#deleteModal' data-refresh='true'><i class=\"fa fa-trash\"></i> Eliminar</a></li>";
        }
        $tabla.= "	</ul>
                </div>
                </td>
                </tr>";
            return $tabla;
    } , 'field' => 'id_carrera' )

    );
    echo json_encode(
        SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
    );
    ?>
