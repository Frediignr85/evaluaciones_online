<?php
    include("_core.php");

    $requestData= $_REQUEST;


    require('ssp.customized.class.php');
    // DB table to use
    $table = 'tblcurso';
    // Table's primary key
    $primaryKey = 'id_curso';

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
    
    $joinQuery = " FROM tblcurso INNER JOIN tblmateria on tblmateria.id_materia = tblcurso.id_materia INNER JOIN tbldocente on tbldocente.id_docente = tblcurso.id_docente";

    $extraWhere = " tblcurso.deleted is NULL AND tblcurso.activo = 1";
    if($admin == 2){
        $joinQuery.= " LEFT JOIN tbldocente_curso on tbldocente_curso.id_curso = tblcurso.id_curso";
        $extraWhere.= " AND (tbldocente_curso.id_docente = '".$_SESSION['id_docente']."' OR tblcurso.id_docente = '".$_SESSION['id_docente']."' )";
    }

    $columns = array(
    array( 'db' => '`tblcurso`.`id_curso`', 'dt' => 0, 'field' => 'id_curso'  ),
    array( 'db' => "tblcurso.nombre", 'dt' => 1, 'field' => "nombre", 'as' => 'nombre'),    
    array( 'db' => "tblmateria.nombre", 'dt' => 2, 'field' =>"nombre_materia", 'as' => 'nombre_materia'),
    array( 'db' => '`tblcurso`.`id_curso`', 'dt' => 3, 'formatter' => function($id_curso){
        $sql_fecha = "SELECT * FROM tblcurso WHERE id_curso = '$id_curso'";
        $query_fecha = _query($sql_fecha);
        $row_fecha = _fetch_array($query_fecha);
        $fecha_inicio = $row_fecha['fecha_inicio'];
        $fecha_final = $row_fecha['fecha_final'];
        $fecha_inicio = explode(" ", $fecha_inicio);
        $fecha_final = explode(" ", $fecha_final);
        $fecha1 =ED($fecha_inicio[0]);
        $hora1 = _hora_media_decode($fecha_inicio[1]);
        $fecha2 = ED($fecha_final[0]);
        $hora2 = _hora_media_decode($fecha_final[1]);
        return $fecha1." ".$hora1." - ".$fecha2." ".$hora2;
    }, 'field' => 'id_curso'  ),    
    array( 'db' => "CONCAT(tbldocente.nombres,' ',tbldocente.apellidos)", 'dt' => 4, 'field' => "nombre_docente", 'as' => 'nombre_docente'),    
    array( 'db' => '`tblcurso`.`id_curso`', 'dt' => 5, 'formatter' => function($id_curso){
        $sql_count = "SELECT id_estudiante_curso FROM tblestudiante_curso WHERE id_curso = '$id_curso' AND deleted is NULL";
        $query_count = _query($sql_count);
        $row_count = _num_rows($query_count);
        return $row_count;
    }, 'field' => 'id_curso'  ),    
    array( 'db' => '`tblcurso`.`id_curso`', 'dt' => 6, 'formatter' => function ($id_curso) {
        $id_user=$_SESSION["id_usuario"];
    	$admin=$_SESSION["admin"];
        $tabla="<td class='col col col-lg-1'><div class=\"btn-group\">
        <a href=\"#\" data-toggle=\"dropdown\" class=\"btn btn-primary dropdown-toggle\"><i class=\"fa fa-user icon-white\"></i> Menu<span class=\"caret\"></span></a>
        <ul class=\"dropdown-menu dropdown-primary\">";
        $sql_x = "SELECT * FROM tblcurso where id_curso = '$id_curso'";
        $query = _query($sql_x);
        $row_x = _fetch_array($query);
        $filename='editar_curso.php';
        $link=permission_usr($id_user,$filename);
        if ($link!='NOT' || $admin=='1' ){
            $tabla.= "<li><a href=\"editar_curso.php?id_curso=".$id_curso."\"><i class=\"fa fa-pencil\"></i> Editar</a></li>";
        }
        $filename='borrar_curso.php';
        $link=permission_usr($id_user,$filename);
        if ($link!='NOT' || $admin=='1' ){
            $tabla.= "<li><a data-toggle='modal' href='borrar_curso.php?id_curso=".$id_curso."' data-target='#deleteModal' data-refresh='true'><i class=\"fa fa-trash\"></i> Eliminar</a></li>";
        }
        
        $filename='estudiantes_cursos.php';
        $link=permission_usr($id_user,$filename);
        if ($link!='NOT' || $admin=='1' ){
            $tabla.= "<li><a href=\"estudiantes_cursos.php?id_curso=".$id_curso."\"><i class=\"fa fa-user-o\"></i> Ver Estudiantes</a></li>";
        }
        $filename='docentes_cursos.php';
        $link=permission_usr($id_user,$filename);
        if ($link!='NOT' || $admin=='1' ){
            $tabla.= "<li><a href=\"docentes_cursos.php?id_curso=".$id_curso."\"><i class=\"fa fa-black-tie\"></i> Ver Docentes</a></li>";
        }
        $filename='admin_evaluaciones.php';
        $link=permission_usr($id_user,$filename);
        if ($link!='NOT' || $admin=='1' ){
            $tabla.= "<li><a href=\"admin_evaluaciones.php?id_curso=".$id_curso."\"><i class=\"fa fa-tasks\"></i> Ver Evaluaciones</a></li>";
        }
        $filename='agregar_evaluacion.php';
        $link=permission_usr($id_user,$filename);
        if ($link!='NOT' || $admin=='1' ){
            $tabla.= "<li><a href=\"agregar_evaluacion.php?id_curso=".$id_curso."\"><i class=\"fa fa-plus\"></i> Agregar Evaluacion</a></li>";
        }
        

        $tabla.= "	</ul>
                </div>
                </td>
                </tr>";
            return $tabla;
    } , 'field' => 'id_curso' )

    );
    echo json_encode(
        SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
    );
    ?>
