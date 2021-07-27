<?php
    include("_core.php");

    $requestData= $_REQUEST;


    require('ssp.customized.class.php');
    // DB table to use
    $table = 'tblmateria';
    // Table's primary key
    $primaryKey = 'id_materia';

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

    $joinQuery = " FROM  tblmateria";

    $extraWhere = " tblmateria.deleted is NULL ";

    $columns = array(
    array( 'db' => '`tblmateria`.`id_materia`', 'dt' => 0, 'field' => 'id_materia'  ),
    array( 'db' => "tblmateria.codigo", 'dt' => 1, 'field' => "codigo"),
    array( 'db' => "tblmateria.nombre", 'dt' => 2, 'field' => "nombre"),
    array( 'db' => '`tblmateria`.`descripcion`', 'dt' => 3, 'field' => 'descripcion'  ),    
    array( 'db' => '`tblmateria`.`unidades_valorativas`', 'dt' => 4, 'field' => 'unidades_valorativas'  ),
    array( 'db' => '`tblmateria`.`id_materia`', 'dt' => 5, 'formatter' => function ($id_materia) {
        $id_user=$_SESSION["id_usuario"];
    	$admin=$_SESSION["admin"];
        $tabla="<td class='col col col-lg-1'><div class=\"btn-group\">
        <a href=\"#\" data-toggle=\"dropdown\" class=\"btn btn-primary dropdown-toggle\"><i class=\"fa fa-user icon-white\"></i> Menu<span class=\"caret\"></span></a>
        <ul class=\"dropdown-menu dropdown-primary\">";
        $sql_x = "SELECT * FROM tblmateria where id_materia = '$id_materia'";
        $query = _query($sql_x);
        $row_x = _fetch_array($query);
        $filename='editar_materia.php';
        $link=permission_usr($id_user,$filename);
        if ($link!='NOT' || $admin=='1' ){
            $tabla.= "<li><a href=\"editar_materia.php?id_materia=".$id_materia."\"><i class=\"fa fa-pencil\"></i> Editar</a></li>";
        }
        $filename='borrar_materia.php';
        $link=permission_usr($id_user,$filename);
        if ($link!='NOT' || $admin=='1' ){
            $tabla.= "<li><a data-toggle='modal' href='borrar_materia.php?id_materia=".$id_materia."' data-target='#deleteModal' data-refresh='true'><i class=\"fa fa-trash\"></i> Eliminar</a></li>";
        }
        $tabla.= "	</ul>
                </div>
                </td>
                </tr>";
            return $tabla;
    } , 'field' => 'id_materia' )

    );
    echo json_encode(
        SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
    );
    ?>
