<?php
include_once "_core.php";

function initial() {
	// Page setup
    $title = 'Revisar Evaluacion: ';
	$_PAGE = array ();
    $_PAGE ['title'] = $title;
	$_PAGE ['links'] = null;
	$_PAGE ['links'] .= '<link href="css/bootstrap.min.css" rel="stylesheet">';
  	$_PAGE ['links'] .= '<link href="font-awesome/css/font-awesome.css" rel="stylesheet">';
  	$_PAGE ['links'] .= '<link href="css/plugins/iCheck/custom.css" rel="stylesheet">';
  	$_PAGE ['links'] .= '<link href="css/plugins/chosen/chosen.css" rel="stylesheet">';
  	$_PAGE ['links'] .= '<link href="css/plugins/select2/select2.css" rel="stylesheet">';
    $_PAGE ['links'] .= '<link href="css/plugins/select2/select2-bootstrap.css" rel="stylesheet">';
    $_PAGE ['links'] .= '<link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">';
    $_PAGE ['links'] .= '<link href="css/plugins/jQueryUI/jquery-ui-1.10.4.custom.min.css" rel="stylesheet">';
    $_PAGE ['links'] .= '<link href="css/plugins/jqGrid/ui.jqgrid.css" rel="stylesheet">';
    $_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">';
    $_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">';
    $_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">';
    $_PAGE ['links'] .= '<link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">';
    $_PAGE ['links'] .= '<link href="css/plugins/tour/bootstrap-tour.css" rel="stylesheet">';
    $_PAGE ['links'] .= '<link href="css/animate.css" rel="stylesheet">';
    $_PAGE ['links'] .= '<link href="css/style.css" rel="stylesheet">';
    $_PAGE['links'] .= '<link href="css/plugins/timepicki/timepicki.css" rel="stylesheet">';    


	include_once "header.php";
	include_once "main_menu.php";
    //permiso del script
	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];
	$uri = $_SERVER['SCRIPT_NAME'];
    $filename=get_name_script($uri);
    $links=permission_usr($id_user,$filename);
    $id_sucursal=$_SESSION["id_sucursal"];
    $id_resultado_evaluacion=$_REQUEST["id_resultado_evaluacion"];  


    $sql_resultado = "SELECT * FROM tblresultado_evaluacion WHERE id_resultado_evaluacion= '$id_resultado_evaluacion'";
    $query_resultado = _query($sql_resultado);
    
    if(_num_rows($query_resultado) > 0){
        $row_resultado = _fetch_array($query_resultado);
        $fecha_empezado = ED($row_resultado['fecha_empezado']);
        $fecha_terminado = ED($row_resultado['fecha_terminado']);
        $hora_empezado = _hora_media_decode($row_resultado['hora_empezado']);
        $hora_terminado = _hora_media_decode($row_resultado['hora_terminado']);
        $id_evaluacion = ($row_resultado['id_evaluacion']);
        $sql_evaluacion = "SELECT * FROM tblevaluacion WHERE id_evaluacion = '$id_evaluacion'";
        $query_evaluacion = _query($sql_evaluacion);
        $row_evaluacion = _fetch_array($query_evaluacion);
        $nombre_evaluacion = $row_evaluacion['nombre'];
        $descripcion_evaluacion = $row_evaluacion['descripcion'];
        $nota_minima = $row_evaluacion['nota_minima'];
        $nota_maxima = $row_evaluacion['nota_maxima'];
        $fecha_inicio = ED($row_evaluacion['fecha_inicio']);
        $hora_inicio = _hora_media_decode($row_evaluacion['hora_inicio']);
        $fecha_fin = ED($row_evaluacion['fecha_fin']);
        $hora_fin = _hora_media_decode($row_evaluacion['hora_fin']);
    
        $tiempo_estimado = number_format($row_evaluacion['tiempo_estimado'],2,":")." Minutos";
        $id_curso = $row_evaluacion['id_curso'];
        $sql_curso = "SELECT * FROM tblcurso WHERE id_curso = '$id_curso'";
        $query_curso = _query($sql_curso);
        $row_curso = _fetch_array($query_curso);
        $nombre_curso = $row_curso['nombre'];
        $id_materia = $row_curso['id_materia'];
        $id_docente = $row_curso['id_docente'];
        $sql_materia = "SELECT * FROM tblmateria WHERE id_materia = '$id_materia'";
        $query_materia = _query($sql_materia);
        $row_materia = _fetch_array($query_materia);
        $nombre_materia = $row_materia['nombre'];
        $codigo_materia = $row_materia['codigo'];
        $sql_docente = "SELECT * FROM tbldocente WHERE id_docente = '$id_docente'";
        $query_docente = _query($sql_docente);
        $row_docente = _fetch_array($query_docente);
        $nombres_docente = $row_docente['nombres'];
        $apellidos_docente = $row_docente['apellidos'];
        $nombre_docente = $nombres_docente." ".$apellidos_docente;
        $id_estudiante = $row_resultado['id_estudiante'];
        $nota = $row_resultado['nota'];
        $tiempo_realizado = $row_resultado['tiempo_realizado'];
        $tiempo_realizado = number_format($tiempo_realizado,2,":")." Minutos";
        $sql_estudiante = "SELECT * FROM tblestudiante WHERE id_estudiante = '$id_estudiante'";
        $query_estudiante = _query($sql_estudiante);
        $row_estudiante = _fetch_array($query_estudiante);
        $nombres_estudiante = $row_estudiante['nombres'];
        $apellidos_estudiante = $row_estudiante['apellidos'];
        $nombre_estudiante = $nombres_estudiante." ".$apellidos_estudiante;
        $codigo = $row_estudiante['codigo'];
        $usuario = $row_estudiante['usuario'];
        $id_facultad = $row_estudiante['id_facultad'];
        $id_carrera = $row_estudiante['id_carrera'];
        $sql_facultad = "SELECT  * FROM tblfacultad WHERE id_facultad = '$id_facultad'";
        $query_facultad = _query($sql_facultad);
        $row_facultad = _fetch_array($query_facultad);
        $nombre_facultad = $row_facultad['nombre'];
        $sql_carrera = "SELECT * FROM tblcarrera WHERE id_carrera = '$id_carrera'";
        $query_carrera = _query($sql_carrera);
        $row_carrera = _fetch_array($query_carrera);
        $nombre_carrera = $row_carrera['nombre'];
    }

	//permiso del script
	if ($links!='NOT' || $admin=='1' ){
?>

<div class="row wrapper border-bottom white-bg page-heading">

    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content  animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h3 style="color:#194160;"><i class="fa fa-user"></i>
                        <b><?php echo $title." ".$nombre_evaluacion." del curso, ".$nombre_curso;?></b></h3><br>
                    <h3 style="color:#194160;"><b>Estudiante: </b><?php echo $nombre_estudiante; ?> ______________
                        <b>Codigo: </b><?php echo $codigo; ?></h3>
                    <h3 style="color:#194160;"><b>Nota Final: </b><?php echo $nota; ?> ______________
                        <b>Tiempo Utilizado: </b><?php echo $tiempo_realizado; ?></h3>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Pregunta</th>
                                        <th scope="col">Respuesta</th>
                                        <th scope="col">Marcada</th>
                                        <th scope="col">Correcta</th>
                                        <th scope="col">Acumula</th>
                                        <th scope="col">Puntos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $numero_pregunta = 1;
                                        $sql_preguntas = "SELECT * FROM tblpregunta_evaluacion WHERE id_evaluacion = '$id_evaluacion'";
                                        $query_preguntas = _query($sql_preguntas);
                                        while($row_preguntas = _fetch_array($query_preguntas)){
                                            $id_pregunta = $row_preguntas['id_pregunta_evaluacion'];
                                            $descripcion = $row_preguntas['descripcion'];
                                            $sql_respuestas = "SELECT * FROM tblrespuesta_evaluacion WHERE id_pregunta = '$id_pregunta'";
                                            $query_respuestas = _query($sql_respuestas);
                                            $numero_espacios_respuesta = _num_rows($query_respuestas);
                                            $numero_espacios_respuesta++;
                                            ?>
                                            <tr>
                                                <td rowspan="<?php echo $numero_espacios_respuesta; ?>"><?php echo $numero_pregunta; ?></td>
                                                <td rowspan="<?php echo $numero_espacios_respuesta; ?>"><?php echo $descripcion; ?></td>
                                            <?php
                                            while($row_respuestas = _fetch_array($query_respuestas)){
                                                $id_respuesta = $row_respuestas['id_respuesta'];
                                                $descripcion_respuesta = $row_respuestas['descripcion'];
                                                $correcta = $row_respuestas['correcta'];
                                                if($correcta == 1){
                                                    $correcta = "Si";
                                                    $acumula = "Si";
                                                }
                                                elseif($correcta == 0){
                                                    $correcta = "No";
                                                    $acumula = "No";
                                                }
                                                $sql_comprobar_respuesta = "SELECT * FROM tblrespuesta_estudiante WHERE id_pregunta = '$id_pregunta' AND id_respuesta = '$id_respuesta' AND id_resultado_evaluacion = '$id_resultado_evaluacion' AND id_estudiante = '$id_estudiante'";
                                                $query_comprobar_respuesta = _query($sql_comprobar_respuesta);
                                                $row_comprobar_respuesta = _fetch_array($query_comprobar_respuesta);
                                                $marcada = $row_comprobar_respuesta['marcada'];
                                                if($marcada == 1){
                                                    $marcada = "Si";
                                                }
                                                elseif($marcada == 0){
                                                    $marcada = "No";
                                                }
                                                $respuesta_correcta = $row_comprobar_respuesta['correcta'];
                                                $porcentaje = $row_comprobar_respuesta['porcentaje'];
                                                if($respuesta_correcta == 1 && $acumula == "Si"){
                                                    ?>
                                                    <tr style="background:#E8FFCA">
                                                        <td><?php echo $descripcion_respuesta; ?></td>
                                                        <td><?php echo $marcada; ?></td>
                                                        <td><?php echo $correcta; ?></td>
                                                        <td><?php echo $acumula; ?></td>
                                                        <td><?php echo $porcentaje; ?></td>
                                                    </tr>
                                                    <?php
                                                }
                                                elseif( $marcada == "Si" && $acumula == "No"){
                                                    ?>
                                                    <tr style="background:#FFCACA">
                                                        <td><?php echo $descripcion_respuesta; ?></td>
                                                        <td><?php echo $marcada; ?></td>
                                                        <td><?php echo $correcta; ?></td>
                                                        <td><?php echo $acumula; ?></td>
                                                        <td><?php echo $porcentaje; ?></td>
                                                    </tr>
                                                    <?php
                                                }
                                                else{
                                                    ?>
                                                    <tr >
                                                        <td><?php echo $descripcion_respuesta; ?></td>
                                                        <td><?php echo $marcada; ?></td>
                                                        <td><?php echo $correcta; ?></td>
                                                        <td><?php echo $acumula; ?></td>
                                                        <td><?php echo $porcentaje; ?></td>
                                                    </tr>
                                                <?php
                                                }
                                                

                                            }

                                            ?>
                                                </tr>

                                            <?php
                                        }


                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php
include_once ("footer.php");
} //permiso del script
else {
		echo "<div></div><br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div>";
	}
}

if(!isset($_POST['process']))
{
	initial();
}
else
{
    if(isset($_POST['process']))
    {
        switch ($_POST['process'])
        {
        	case 'insert':
        		insertar();
        		break;
            
        }
    }
}
?>