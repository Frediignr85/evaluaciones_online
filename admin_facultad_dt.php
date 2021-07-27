<?php
    include("_core.php");

    $requestData= $_REQUEST;


    require('ssp.customized.class.php');
    // DB table to use
    $table = 'tblfacultad';
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

    $joinQuery = " FROM  tblfacultad";

    $extraWhere = " deleted is NULL ";

    $columns = array(
    array( 'db' => '`tblfacultad`.`id_facultad`', 'dt' => 0, 'field' => 'id_facultad'  ),
    array( 'db' => "tblfacultad.nombre", 'dt' => 1, 'field' => "nombre"),
    array( 'db' => '`tblfacultad`.`descripcion`', 'dt' => 2, 'field' => 'descripcion'  ),
    array( 'db' => '`tblfacultad`.`id_facultad`', 'dt' => 3, 'formatter' => function ($id_facultad) {
        $id_user=$_SESSION["id_usuario"];
    	$admin=$_SESSION["admin"];
        $tabla="<td class='col col col-lg-1'><div class=\"btn-group\">
        <a href=\"#\" data-toggle=\"dropdown\" class=\"btn btn-primary dropdown-toggle\"><i class=\"fa fa-user icon-white\"></i> Menu<span class=\"caret\"></span></a>
        <ul class=\"dropdown-menu dropdown-primary\">";
        $sql_x = "SELECT * FROM tblfacultad where id_facultad = '$id_facultad'";
        $query = _query($sql_x);
        $row_x = _fetch_array($query);
        $filename='editar_facultad.php';
        $link=permission_usr($id_user,$filename);
        if ($link!='NOT' || $admin=='1' ){
            $tabla.= "<li><a href=\"editar_facultad.php?id_facultad=".$id_facultad."\"><i class=\"fa fa-pencil\"></i> Editar</a></li>";
        }
        $filename='borrar_facultad.php';
        $link=permission_usr($id_user,$filename);
        if ($link!='NOT' || $admin=='1' ){
            $tabla.= "<li><a data-toggle='modal' href='borrar_facultad.php?id_facultad=".$id_facultad."' data-target='#deleteModal' data-refresh='true'><i class=\"fa fa-trash\"></i> Eliminar</a></li>";
        }
        $tabla.= "	</ul>
                </div>
                </td>
                </tr>";
            return $tabla;
    } , 'field' => 'id_facultad' )

    );
    echo json_encode(
        SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
    );
    ?>
