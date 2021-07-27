<?php
    include("_core.php");

    $requestData= $_REQUEST;


    require('ssp.customized.class.php');
    // DB table to use
    $table = 'tblEmpleado';
    // Table's primary key
    $primaryKey = 'id_empleado';

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

    $joinQuery = "
			FROM  tblEmpleado as em
		  LEFT JOIN tblCargos as te ON (te.id_cargo=em.id_tipo_empleado_EMP)
	  ";

    $extraWhere = "em.id_sucursal_EMP='$id_sucursal' and em.id_empleado>1";

    $columns = array(
    array( 'db' => '`em`.`id_empleado`', 'dt' => 0, 'field' => 'id_empleado'  ),
    array( 'db' => "CONCAT(em.nombre,' ',em.apellido)", 'dt' => 1, 'field' => "nombres", 'as'=>'nombres'),
    array( 'db' => '`em`.`codigo`', 'dt' => 2, 'field' => 'codigo'  ),
    array( 'db' => '`em`.`direccion`', 'dt' => 3, 'field' => 'direccion'  ),
    array( 'db' => '`em`.`telefono`', 'dt' => 4, 'field' => 'telefono'  ),
    array( 'db' => '`te`.`nom_cargo`', 'dt' => 5, 'field' => 'nom_cargo'  ),
    array( 'db' => '`em`.`id_empleado`', 'dt' => 6, 'formatter' => function ($id_empleado) {
      $query=_query("SELECT * FROM tblEmpleado WHERE id_empleado='$id_empleado'");
      $row=_fetch_array($query);
      $id_user=$_SESSION["id_usuario"];
    	$admin=$_SESSION["admin"];
      $table="<div class=\"btn-group\">
        <a href=\"#\" data-toggle=\"dropdown\" class=\"btn btn-primary dropdown-toggle\"><i class=\"fa fa-user icon-white\"></i> Menu<span class=\"caret\"></span></a>
        <ul class=\"dropdown-menu dropdown-primary\">";
        $filename='editar_empleado.php';
        $link=permission_usr($id_user,$filename);
        if ($link!='NOT' || $admin=='1' )
          $table.= "<li><a href=\"editar_empleado.php?id_empleado=".$id_empleado."\"><i class=\"fa fa-pencil\"></i> Editar</a></li>";
          $filename='ver_empleado.php';
          $link=permission_usr($id_user,$filename);
          if ($link!='NOT' || $admin=='1' )
            $table.= "<li><a data-toggle='modal' href='ver_empleado.php?id_empleado=".$id_empleado."' data-target='#verModal' data-refresh='true'><i class=\"fa fa-book\"></i> Ver Detalle</a></li>";
            $estadoS="";
            $icono="";
            if($row['id_estado_EMP']==1)
            {
              $idEstadoEMP = 2;
              $estadoS="Desactivar";
              $icono="fa fa-toggle-off"	;
            }
            else if($row['id_estado_EMP']==2)
            {
              $idEstadoEMP = 1;
              $estadoS="Activar";
              $icono="fa fa-toggle-on"	;
            }
            $filename='estado_empleado.php';
            $link=permission_usr($id_user,$filename);
            if ($link!='NOT' || $admin=='1' )
              $table.= "<li><a data-toggle='modal' href='estado_empleado.php?id_empleado=".$id_empleado."&estado=".$idEstadoEMP."' data-target='#deleteModal' data-refresh='true'><i class=\"$icono\"></i> $estadoS</a></li>";
            $table.= "	</ul>
            </div>
            ";
            return $table;
    } , 'field' => 'id_empleado' )

    );
    echo json_encode(
        SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
    );
    ?>
