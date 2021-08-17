<?php
    include("_core.php");

    $requestData= $_REQUEST;


    require('ssp.customized.class.php');
    // DB table to use
    $table = 'tblresultado_evaluacion';
    // Table's primary key
    $primaryKey = 'id_resultado_evaluacion';
    $id_evaluacion = $_REQUEST['id_evaluacion'];
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

    $joinQuery = " FROM tblresultado_evaluacion INNER JOIN tblestudiante ON tblestudiante.id_estudiante = tblresultado_evaluacion.id_estudiante";

    $extraWhere = " tblresultado_evaluacion.id_evaluacion = '$id_evaluacion'";

    $columns = array(
    array( 'db' => '`tblresultado_evaluacion`.`id_resultado_evaluacion`', 'dt' => 0, 'field' => 'id_resultado_evaluacion'  ),
    array( 'db' => "CONCAT(tblestudiante.nombres,' ',tblestudiante.apellidos)", 'dt' => 1, 'field' => "nombre", 'as' => 'nombre'),    
    array( 'db' => "tblresultado_evaluacion.nota", 'dt' => 2, 'formatter' => function($nota){
        return number_format($nota,2);
    }, 'field' =>"nota", 'as' => 'nota'),
    array( 'db' => '`tblresultado_evaluacion`.`tiempo_realizado`', 'dt' => 3, 'formatter' => function($tiempo_realizado){
        $tiempo_realizado = number_format($tiempo_realizado,2,":");
        return $tiempo_realizado." Minutos";
    }, 'field' => 'tiempo_realizado'  ),    

    array( 'db' => '`tblresultado_evaluacion`.`id_resultado_evaluacion`', 'dt' => 4, 'formatter' => function($id_resultado_evaluacion){
        $sql_fecha = "SELECT * FROM tblresultado_evaluacion WHERE id_resultado_evaluacion = '$id_resultado_evaluacion'";
        $query_fecha = _query($sql_fecha);
        $row_fecha = _fetch_array($query_fecha);
        $fecha_empezado = ED($row_fecha['fecha_empezado']);
        $hora_empezado = _hora_media_decode($row_fecha['hora_empezado']);
        return $fecha_empezado." ".$hora_empezado;
    }, 'field' => 'id_resultado_evaluacion'  ),  
    array( 'db' => '`tblresultado_evaluacion`.`id_resultado_evaluacion`', 'dt' => 5, 'formatter' => function($id_resultado_evaluacion){
        $sql_fecha = "SELECT * FROM tblresultado_evaluacion WHERE id_resultado_evaluacion = '$id_resultado_evaluacion'";
        $query_fecha = _query($sql_fecha);
        $row_fecha = _fetch_array($query_fecha);
        $fecha_empezado = ED($row_fecha['fecha_terminado']);
        $hora_empezado = _hora_media_decode($row_fecha['hora_terminado']);
        return $fecha_empezado." ".$hora_empezado;
    }, 'field' => 'id_resultado_evaluacion'  ),  
   
    array( 'db' => '`tblresultado_evaluacion`.`id_resultado_evaluacion`', 'dt' => 6, 'formatter' => function ($id_resultado_evaluacion) {
        $id_user=$_SESSION["id_usuario"];
    	$admin=$_SESSION["admin"];
        $tabla="<td class='col col col-lg-1'><div class=\"btn-group\">
        <a href=\"#\" data-toggle=\"dropdown\" class=\"btn btn-primary dropdown-toggle\"><i class=\"fa fa-user icon-white\"></i> Menu<span class=\"caret\"></span></a>
        <ul class=\"dropdown-menu dropdown-primary\">";
        $sql_x = "SELECT * FROM tblresultado_evaluacion where id_resultado_evaluacion = '$id_resultado_evaluacion'";
        $query = _query($sql_x);
        $row_x = _fetch_array($query);
        $filename='ver_resultado_evaluacion.php';
        $link=permission_usr($id_user,$filename);
        if ($link!='NOT' || $admin=='1' ){
            $tabla.= "<li><a href=\"ver_resultado_evaluacion.php?id_resultado_evaluacion=".$id_resultado_evaluacion."\"><i class=\"fa fa-eye\"></i> Ver Resultado</a></li>";
        }
        $filename='resultado_individual.php';
        $link=permission_usr($id_user,$filename);
        if ($link!='NOT' || $admin=='1' ){
            $tabla.= "<li><a href='resultado_individual.php?id_resultado_evaluacion=".$id_resultado_evaluacion."'  target='_blank' ><i class=\"fa fa-print\"></i> Imprimir Resultado</a></li>";
        }
        

        $tabla.= "	</ul>
                </div>
                </td>
                </tr>";
            return $tabla;
    } , 'field' => 'id_resultado_evaluacion' )

    );
    echo json_encode(
        SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
    );
    ?>
