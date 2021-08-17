<?php
    include("_core.php");

    $requestData= $_REQUEST;


    require('ssp.customized.class.php');
    // DB table to use
    $table = 'tblevaluacion';
    // Table's primary key
    $primaryKey = 'id_evaluacion';

    // MySQL server connection information
    $sql_details = array(
      'user' => $usuario,
      'pass' => $clave,
      'db'   => $dbname,
      'host' => $servidor
    );
    $id_curso_w = $_REQUEST['id_curso'];
    //permiso del script
    $id_user=$_SESSION["id_usuario"];
    $admin=$_SESSION["admin"];
    $id_sucursal=$_SESSION["id_sucursal"];
    $uri = $_SERVER['SCRIPT_NAME'];
    $filename=get_name_script($uri);
    $links=permission_usr($id_user, $filename);
    $joinQuery= "FROM tblevaluacion INNER JOIN tblcurso on tblcurso.id_curso = tblevaluacion.id_curso INNER JOIN tblmateria on tblmateria.id_materia = tblcurso.id_materia
                INNER JOIN tblestado_evaluacion on tblestado_evaluacion.id_estado = tblevaluacion.id_estado";
    $extraWhere = " tblcurso.deleted is NULL AND tblcurso.activo = 1 AND tblevaluacion.deleted is NULL";
    if($admin == 2){
        $joinQuery.= " LEFT JOIN tbldocente_curso on tbldocente_curso.id_curso = tblcurso.id_curso";
        $extraWhere.= " AND (tbldocente_curso.id_docente = '".$_SESSION['id_docente']."' OR tblcurso.id_docente = '".$_SESSION['id_docente']."' )";
    }
    elseif($admin == 3){
        $joinQuery.= " INNER JOIN tblestudiante_curso on tblestudiante_curso.id_curso = tblcurso.id_curso";
        $extraWhere.= " AND (tblestudiante_curso.id_estudiante = '".$_SESSION['id_estudiante']."')";
    }
    if($id_curso_w != "0"){
        $extraWhere.= " AND tblevaluacion.id_curso = '$id_curso_w'";
    }
    $columns = array(
    array( 'db' => '`tblevaluacion`.`id_evaluacion`', 'dt' => 0, 'field' => 'id_evaluacion'  ),
    array( 'db' => "tblevaluacion.nombre", 'dt' => 1, 'field' => "nombre_evaluacion", 'as' => 'nombre_evaluacion'),    
    array( 'db' => "tblcurso.nombre", 'dt' => 2, 'field' =>"nombre_curso", 'as' => 'nombre_curso'),
    array( 'db' => '`tblevaluacion`.`id_evaluacion`', 'dt' => 3, 'formatter' => function($id_evaluacion){
        $sql_fecha = "SELECT * FROM tblevaluacion WHERE id_evaluacion = '$id_evaluacion'";
        $query_fecha = _query($sql_fecha);
        $row_fecha = _fetch_array($query_fecha);
        $fecha = ED($row_fecha['fecha_inicio']);
        $hora = _hora_media_decode($row_fecha['hora_inicio']);
        return $fecha." ".$hora;
    }, 'field' => 'id_evaluacion'  ),    
    array( 'db' => '`tblevaluacion`.`id_evaluacion`', 'dt' => 4, 'formatter' => function($id_evaluacion){
        $sql_fecha = "SELECT * FROM tblevaluacion WHERE id_evaluacion = '$id_evaluacion'";
        $query_fecha = _query($sql_fecha);
        $row_fecha = _fetch_array($query_fecha);
        $fecha = ED($row_fecha['fecha_fin']);
        $hora = _hora_media_decode($row_fecha['hora_fin']);
        return $fecha." ".$hora;
    }, 'field' => 'id_evaluacion'  ),  
    array( 'db' => "tblevaluacion.nota_maxima", 'dt' => 5, 'field' => "nota_maxima", 'as' => 'nota_maxima'),    
    array( 'db' => "tblevaluacion.nota_minima", 'dt' => 6, 'field' => "nota_minima", 'as' => 'nota_minima'),  
    array( 'db' => '`tblestado_evaluacion`.`id_estado`', 'dt' => 7, 'formatter' => function($id_estado){
        $sql_estado = "SELECT * FROM tblestado_evaluacion WHERE id_estado = '$id_estado'";
        $query_estado = _query($sql_estado);
        $row_estado = _fetch_array($query_estado);
        $estado = $row_estado['estado'];
        $color = $row_estado['color'];
        $label = "<span class=\"label other\" style=\"color:$color\">$estado</span>";
        return $label;
    }, 'field' => 'id_estado'  ),    
    array( 'db' => '`tblevaluacion`.`id_evaluacion`', 'dt' => 8, 'formatter' => function ($id_evaluacion) {
        $id_user=$_SESSION["id_usuario"];
    	$admin=$_SESSION["admin"];
        $tabla="<td class='col col col-lg-1'><div class=\"btn-group\">
        <a href=\"#\" data-toggle=\"dropdown\" class=\"btn btn-primary dropdown-toggle\"><i class=\"fa fa-user icon-white\"></i> Menu<span class=\"caret\"></span></a>
        <ul class=\"dropdown-menu dropdown-primary\">";
        $sql_x = "SELECT * FROM tblevaluacion where id_evaluacion = '$id_evaluacion'";
        $query = _query($sql_x);
        $row_x = _fetch_array($query);
        $id_estado = $row_x['id_estado'];
        $filename='editar_evaluacion.php';
        $link=permission_usr($id_user,$filename);
        if ($link!='NOT' || $admin=='1' ){
            $tabla.= "<li><a href=\"agregar_evaluacion.php?id_evaluacion=".$id_evaluacion."\"><i class=\"fa fa-pencil\"></i> Editar</a></li>";
        }
        $filename='borrar_evaluacion.php';
        $link=permission_usr($id_user,$filename);
        if ($link!='NOT' || $admin=='1' ){
            $tabla.= "<li><a data-toggle='modal' href='borrar_evaluacion.php?id_evaluacion=".$id_evaluacion."' data-target='#viewModal1' data-refresh='true'><i class=\"fa fa-trash\"></i> Eliminar</a></li>";
        }
        if($id_estado > 1){
            $filename='ver_evaluacion.php';
            $link=permission_usr($id_user,$filename);
            if ($link!='NOT' || $admin=='1' ){
                $tabla.= "<li><a data-toggle='modal' href='ver_evaluacion.php?id_evaluacion=".$id_evaluacion."' data-target='#viewModal1' data-refresh='true'><i class=\"fa fa-eye\"></i> Ver</a></li>";
            }
        }
        
        $filename='realizar_evaluacion.php';
        $link=permission_usr($id_user,$filename);
        if ($link!='NOT'){
            $tabla.= "<li><a href=\"realizar_evaluacion.php?id_evaluacion=".$id_evaluacion."\"><i class=\"fa fa-pencil\"></i> Realizar Evaluacion</a></li>";
        }
        if($id_estado == 4){
            $filename='resultados_evaluacion.php';
            $link=permission_usr($id_user,$filename);
            if ($link!='NOT' || $admin=='1' ){
                $tabla.= "<li><a href=\"resultados_evaluacion.php?id_evaluacion=".$id_evaluacion."\"><i class=\"fa fa-black-tie\"></i> Ver Resultados</a></li>";
            }
        }   
        

        $tabla.= "	</ul>
                </div>
                </td>
                </tr>";
            return $tabla;
    } , 'field' => 'id_evaluacion' )

    );
    echo json_encode(
        SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
    );
    ?>
