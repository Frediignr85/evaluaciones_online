<?php
    include("_core.php");

    $requestData= $_REQUEST;


    require('ssp.customized.class.php');
    // DB table to use
    $table = 'tblestudiante';
    // Table's primary key
    $primaryKey = 'id_estudiante';

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

    $joinQuery = " FROM tblestudiante INNER JOIN tblcarrera on tblestudiante.id_carrera = tblcarrera.id_carrera";

    $extraWhere = " tblestudiante.deleted is NULL";

    $columns = array(
    array( 'db' => '`tblestudiante`.`id_estudiante`', 'dt' => 0, 'field' => 'id_estudiante'  ),
    array( 'db' => "CONCAT(tblestudiante.nombres,' ',tblestudiante.apellidos)", 'dt' => 1, 'field' => "nombre_estudiante", 'as' => 'nombre_estudiante'),    
    array( 'db' => "tblestudiante.codigo", 'dt' => 2, 'field' => "codigo"),
    array( 'db' => '`tblestudiante`.`usuario`', 'dt' => 3, 'field' => 'usuario'  ),    
    array( 'db' => '`tblcarrera`.`nombre`', 'dt' => 4, 'field' => 'nombre'  ),    
    array( 'db' => '`tblestudiante`.`fecha_de_inscripcion`', 'dt' => 5, 'formatter' => function($fecha_de_inscripcion){
        return ED($fecha_de_inscripcion);
    }, 'field' => 'fecha_de_inscripcion'  ),   
    array( 'db' => '`tblestudiante`.`id_estudiante`', 'dt' => 6, 'formatter' => function ($id_estudiante) {
        $id_user=$_SESSION["id_usuario"];
    	$admin=$_SESSION["admin"];
        $tabla="<td class='col col col-lg-1'><div class=\"btn-group\">
        <a href=\"#\" data-toggle=\"dropdown\" class=\"btn btn-primary dropdown-toggle\"><i class=\"fa fa-user icon-white\"></i> Menu<span class=\"caret\"></span></a>
        <ul class=\"dropdown-menu dropdown-primary\">";
        $sql_x = "SELECT * FROM tblestudiante where id_estudiante = '$id_estudiante'";
        $query = _query($sql_x);
        $row_x = _fetch_array($query);
        $filename='editar_estudiante.php';
        $link=permission_usr($id_user,$filename);
        if ($link!='NOT' || $admin=='1' ){
            $tabla.= "<li><a href=\"editar_estudiante.php?id_estudiante=".$id_estudiante."\"><i class=\"fa fa-pencil\"></i> Editar</a></li>";
        }
        $filename='borrar_estudiante.php';
        $link=permission_usr($id_user,$filename);
        if ($link!='NOT' || $admin=='1' ){
            $tabla.= "<li><a data-toggle='modal' href='borrar_estudiante.php?id_estudiante=".$id_estudiante."' data-target='#deleteModal' data-refresh='true'><i class=\"fa fa-trash\"></i> Eliminar</a></li>";
        }
        $tabla.= "	</ul>
                </div>
                </td>
                </tr>";
            return $tabla;
    } , 'field' => 'id_estudiante' )

    );
    echo json_encode(
        SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
    );
    ?>
