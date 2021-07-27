<?php
    include("_core.php");

    $requestData= $_REQUEST;


    require('ssp.customized.class.php');
    // DB table to use
    $table = 'tblUsuario';
    // Table's primary key
    $primaryKey = 'id_usuario';

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

    $joinQuery = " FROM tblUsuario LEFT JOIN tblEmpleado on tblEmpleado.id_empleado = tblUsuario.id_empleado_usuario INNER JOIN tblcargos on tblcargos.id_cargo = tblUsuario.id_tipo_usuario";

    $extraWhere = "tblUsuario.id_usuario > 2 AND tblUsuario.deleted is NULL ";

    $columns = array(
    array( 'db' => '`tblUsuario`.`id_usuario`', 'dt' => 0, 'field' => 'id_usuario'  ),
    array( 'db' => "CONCAT(tblEmpleado.nombre,' ',tblEmpleado.apellido)", 'dt' => 1, 'field' => "nombres", 'as'=>'nombres'),
    array( 'db' => '`tblUsuario`.`usuario`', 'dt' => 2, 'field' => 'usuario'  ),
    array( 'db' => '`tblcargos`.`nom_cargo`', 'dt' => 3, 'field' => 'nom_cargo'  ),
    array( 'db' => '`tblUsuario`.`activo`', 'dt' => 4, 'formatter'  => function($activo){
        if($activo == 1){
			return "<label class='badge' style='background:#2EC824; color:#FFF; font-weight:bold;'>Activo</label>";
		}
		else{
			return "<label class='badge' style='background:#FF4646; color:#FFF; font-weight:bold;'>Inactivo</label>";
		}
    },'field' => 'activo'  ),
    array( 'db' => '`tblUsuario`.`id_usuario`', 'dt' => 5, 'formatter' => function ($id_usuario) {
      $id_user=$_SESSION["id_usuario"];
        $admin=$_SESSION["admin"];
        $tabla="<td><div class=\"btn-group\">
        <a href=\"#\" data-toggle=\"dropdown\" class=\"btn btn-primary dropdown-toggle\"><i class=\"fa fa-user icon-white\"></i> Menu<span class=\"caret\"></span></a>
        <ul class=\"dropdown-menu dropdown-primary\">";
        $filename='editar_usuario.php';
        $link=permission_usr($id_user,$filename);
        if ($link!='NOT' || $admin=='1' )	
            $tabla.= "<li><a href=\"editar_usuario.php?id_usuario=".$id_usuario."\"><i class=\"fa fa-pencil\"></i> Editar</a></li>";
        $tabla.= "<li><a href=\"permiso_usuario.php?id_usuario=".$id_usuario."\"><i class=\"fa fa-lock\"></i> Permisos</a></li>";
        $filename='borrar_usuario.php';
        $link=permission_usr($id_user,$filename);
        if ($link!='NOT' || $admin=='1' )
            $tabla.= "<li><a data-toggle='modal' href='borrar_usuario.php?id_usuario=".$id_usuario."' data-target='#deleteModal' data-refresh='true'><i class=\"fa fa-trash\"></i> Eliminar</a></li>";	
        $tabla.= "	</ul>
                </div>
                </td>
                </tr>";
            return $tabla;
    } , 'field' => 'id_usuario' )

    );
    echo json_encode(
        SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
    );
    ?>
