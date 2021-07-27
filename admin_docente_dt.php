<?php
    include("_core.php");

    $requestData= $_REQUEST;


    require('ssp.customized.class.php');
    // DB table to use
    $table = 'tbldocente';
    // Table's primary key
    $primaryKey = 'id_docente';

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

    $joinQuery = " FROM tbldocente";

    $extraWhere = " tbldocente.deleted is NULL";

    $columns = array(
    array( 'db' => '`tbldocente`.`id_docente`', 'dt' => 0, 'field' => 'id_docente'  ),
    array( 'db' => "CONCAT(tbldocente.nombres,' ',tbldocente.apellidos)", 'dt' => 1, 'field' => "nombre", 'as' => 'nombre'),    
    array( 'db' => "tbldocente.codigo", 'dt' => 2, 'field' => "codigo"),
    array( 'db' => '`tbldocente`.`usuario`', 'dt' => 3, 'field' => 'usuario'  ),    
    array( 'db' => '`tbldocente`.`fecha_de_nacimiento`', 'dt' => 4, 'formatter' => function($fecha_de_nacimiento){
        return ED($fecha_de_nacimiento);
    }, 'field' => 'fecha_de_nacimiento'  ),
    array( 'db' => '`tbldocente`.`id_docente`', 'dt' => 5, 'formatter' => function ($id_docente) {
        $id_user=$_SESSION["id_usuario"];
    	$admin=$_SESSION["admin"];
        $tabla="<td class='col col col-lg-1'><div class=\"btn-group\">
        <a href=\"#\" data-toggle=\"dropdown\" class=\"btn btn-primary dropdown-toggle\"><i class=\"fa fa-user icon-white\"></i> Menu<span class=\"caret\"></span></a>
        <ul class=\"dropdown-menu dropdown-primary\">";
        $sql_x = "SELECT * FROM tbldocente where id_docente = '$id_docente'";
        $query = _query($sql_x);
        $row_x = _fetch_array($query);
        $filename='editar_docente.php';
        $link=permission_usr($id_user,$filename);
        if ($link!='NOT' || $admin=='1' ){
            $tabla.= "<li><a href=\"editar_docente.php?id_docente=".$id_docente."\"><i class=\"fa fa-pencil\"></i> Editar</a></li>";
        }
        $filename='borrar_docente.php';
        $link=permission_usr($id_user,$filename);
        if ($link!='NOT' || $admin=='1' ){
            $tabla.= "<li><a data-toggle='modal' href='borrar_docente.php?id_docente=".$id_docente."' data-target='#deleteModal' data-refresh='true'><i class=\"fa fa-trash\"></i> Eliminar</a></li>";
        }
        $tabla.= "	</ul>
                </div>
                </td>
                </tr>";
            return $tabla;
    } , 'field' => 'id_docente' )

    );
    echo json_encode(
        SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
    );
    ?>
