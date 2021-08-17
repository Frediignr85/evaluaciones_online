<?php
include_once "_core.php";

function initial() {
	// Page setup
    $title = 'Realizar Evaluacion';
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
    $_PAGE['links'] .= '<link href="css/estilo_evaluacion.css" rel="stylesheet">';
    $_PAGE ['links'] .= '<link href="css/plugins/sweetalert/sweetalert.css" rel="stylesheet">';


	include_once "header.php";
	include_once "main_menu.php";
    //permiso del script
	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];
	$uri = $_SERVER['SCRIPT_NAME'];
    $id_evaluacion = $_REQUEST['id_evaluacion'];
    $id_estudiante = $_SESSION['id_estudiante'];
    $filename=get_name_script($uri);
    $links=permission_usr($id_user,$filename);
	//permiso del script
	if ($links!='NOT' || $admin=='1' ){
        $sql_evaluacion = "SELECT * FROM tblevaluacion WHERE id_evaluacion = '$id_evaluacion'";
        $query_evaluacion = _query($sql_evaluacion);
        $row_evaluacion = _fetch_array($query_evaluacion);
        $minutos_estimados = $row_evaluacion['tiempo_estimado'];
        $segundos_estimados = 60;
        $id_resultado_evaluacion = "-1";
        $sql_resultado_evaluacion = "SELECT * FROM tblresultado_evaluacion WHERE id_estudiante = '$id_estudiante' AND id_evaluacion = '$id_evaluacion'";
        $query_resultado_evaluacion = _query($sql_resultado_evaluacion);
        if( _num_rows($query_resultado_evaluacion) > 0){
            $row_resultado_evaluacion = _fetch_array($query_resultado_evaluacion);
            $id_resultado_evaluacion = $row_resultado_evaluacion['id_resultado_evaluacion'];
            $tiempo_usado = $row_resultado_evaluacion['tiempo_usado'];
            $tiempo_usado = number_format($tiempo_usado,1,".");
            $tiempo_usado = explode(".", $tiempo_usado);
            $minutos_estimados = $tiempo_usado[0];
            $segundos_estimados = $tiempo_usado[1] *10;
        }
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
                    <h3 style="color:#194160;"><i class="fa fa-user"></i> <b><?php echo $title;?></b></h3>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-6" id="temporizador" style="float:right;">
                                <div id="countdown"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="contenido_pregunta">

                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id_pregunta" id="id_pregunta" value="">
                    <input type="hidden" name="minutos_estimados" id="minutos_estimados" value="<?php echo $minutos_estimados; ?>">
                    <input type="hidden" name="segundos_estimados" id="segundos_estimados" value="<?php echo $segundos_estimados; ?>">
                    <input type="hidden" name="id_evaluacion" id="id_evaluacion" value="<?php echo $id_evaluacion; ?>">
                    <input type="hidden" name="id_resultado_evaluacion" id="id_resultado_evaluacion" value="<?php echo $id_resultado_evaluacion; ?>">
                    <input type="hidden" name="id_estudiante" id="id_estudiante" value="<?php echo $id_estudiante; ?>">
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include_once ("footer.php");
echo" <script type='text/javascript' src='js/funciones/funciones_realizar_evaluacion.js'></script>";
} //permiso del script
else {
		echo "<div></div><br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div>";
	}
}


function traer_id_preguntas()
{
	$id_evaluacion = $_POST['id_evaluacion'];
    $array_preguntas = array();
    $sql_preguntas = "SELECT * FROM tblpregunta_evaluacion WHERE id_evaluacion = '$id_evaluacion' ORDER BY rand()";
    $query_preguntas = _query($sql_preguntas);
    while($row = _fetch_array($query_preguntas)){
        $array_preguntas[] = array(
            'id_pregunta' => $row['id_pregunta_evaluacion'],
        );
    }
    echo json_encode($array_preguntas);
}


function traer_info_pregunta(){
    $id_pregunta = $_POST['id_pregunta'];
    $posicion = $_POST['posicion'];
    $tamanio = $_POST['tamanio_array'];
    $id_evaluacion = $_POST['id_evaluacion'];
    $id_estudiante = $_SESSION['id_estudiante'];
    $id_resultado_evaluacion = $_POST['id_resultado_evaluacion'];

    $numero_pregunta = $posicion+1;
    $sql_pregunta = "SELECT * FROM tblpregunta_evaluacion WHERE id_pregunta_evaluacion = '$id_pregunta'";
    $query_pregunta = _query($sql_pregunta);
    $row_pregunta = _fetch_array($query_pregunta);
    $descripcion_pregunta = $row_pregunta['descripcion'];
    $sql_res = "SELECT * FROM tblrespuesta_evaluacion WHERE id_pregunta = '$id_pregunta'";
    $query_res = _query($sql_res);
    $comprobar_multiple = "SELECT * FROM tblrespuesta_evaluacion WHERE id_pregunta = '$id_pregunta' AND correcta = '1'";
    $query_multiple = _query($comprobar_multiple);
    $multiple = _num_rows($query_multiple);
    
    $html_devolver = "";
    $html_devolver.=" <div class=\"card-new-2\">";
    $html_devolver.=" <div class=\"card-header-2\"><h2>PREGUNTA #$numero_pregunta</h2></div>";
    $html_devolver.=" <div class=\"card-header-2\"><h2> $descripcion_pregunta</h2></div>";
        $html_devolver.="<div class=\"card-body-2\">";
        if($multiple > 1){
            while($row_respuestas = _fetch_array($query_res)){
                $id_respues = $row_respuestas['id_respuesta'];
                $descripcion_respuesta = $row_respuestas['descripcion'];
                $sql_comprobar_respuesta = "SELECT * FROM tblrespuesta_estudiante where id_resultado_evaluacion = '$id_resultado_evaluacion' AND id_pregunta = '$id_pregunta' AND id_respuesta = '$id_respues' AND id_estudiante = '$id_estudiante' AND marcada = '1'";
                $query_comprobar_respuesta = _query($sql_comprobar_respuesta);
                $checado = "";
                if(_num_rows($query_comprobar_respuesta) > 0){
                    $checado = " checked ";
                }

                $html_devolver.="<label class='label_respuesta'><input type=\"checkbox\" name=\"check_lista\" $checado class='check_lista' value=\"$id_respues\">    $descripcion_respuesta</label>";
                $html_devolver.="</br>";
            }
        }
        else{
            while($row_respuestas = _fetch_array($query_res)){
                $id_respues = $row_respuestas['id_respuesta'];
                $descripcion_respuesta = $row_respuestas['descripcion'];
                $sql_comprobar_respuesta = "SELECT * FROM tblrespuesta_estudiante where id_resultado_evaluacion = '$id_resultado_evaluacion' AND id_pregunta = '$id_pregunta' AND id_respuesta = '$id_respues' AND id_estudiante = '$id_estudiante' AND marcada = '1'";
                $query_comprobar_respuesta = _query($sql_comprobar_respuesta);
                $checado = "";
                if(_num_rows($query_comprobar_respuesta) > 0){
                    $checado = " checked ";
                }
                $html_devolver.="<label class='label_respuesta'><input type=\"checkbox\" name=\"check_lista\" $checado class='check_lista' value=\"$id_respues\">    $descripcion_respuesta</label>";
                $html_devolver.="</br>";
            }
        }
            
            $html_devolver.="</div>";
            $html_devolver.="<div class=\"card-footer-2\">";
            if(($posicion+1) == $tamanio){
                
                $html_devolver.="<button type=\"button\" class=\"btn btn-warning btn_anterior\" style=\"float:left;margin-right:20px;\" >Anterior</button>";
                $html_devolver.="<button type=\"button\" class=\"btn btn-danger btn_terminar_prueba\"  style=\"float:right;margin-left:20px;\">Terminar la Prueba</button>";
            }
            if($posicion == 0){
                $html_devolver.="<button type=\"button\" class=\"btn btn-primary btn_siguiente\"  style=\"float:right;\">Siguiente</button>";
            }
            if($posicion > 0 && ($posicion +1) < $tamanio){
                
                $html_devolver.="<button type=\"button\" class=\"btn btn-warning btn_anterior\" style=\"float:left;margin-right:20px;\" >Anterior</button>";
                $html_devolver.="<button type=\"button\" class=\"btn btn-primary btn_siguiente\"  style=\"float:right;margin-left:20px;\">Siguiente</button>";
            }
        $html_devolver.="</div>";
    $html_devolver.="</div>";
    echo $html_devolver;
}

function guardar_pregunta(){
    $id_resultado_evaluacion = $_POST['id_resultado_evaluacion'];
    $id_evaluacion = $_POST['id_evaluacion'];
    $id_pregunta = $_POST['id_pregunta'];
    $checkbox = $_POST['checkbox'];
    $id_estudiante = $_SESSION['id_estudiante'];
    $error = 0;
    _begin();
    $sql_respuestas = "SELECT * FROM tblrespuesta_evaluacion WHERE id_pregunta = '$id_pregunta'";
    $query_respuestas = _query($sql_respuestas);
    while($row = _fetch_array($query_respuestas)){
        $id_respuesta = $row['id_respuesta'];
        $marcado = 0;
        foreach ($checkbox as $key => $value) {
            if($id_respuesta == $value){
                $marcado = 1;
            }
        }
        $sql_verificacion_marcado = "SELECT * FROM tblrespuesta_estudiante WHERE id_pregunta = '$id_pregunta' AND id_respuesta = '$id_respuesta' AND id_resultado_evaluacion = '$id_resultado_evaluacion' AND id_estudiante = '$id_estudiante'";
        $query_verificacion_marcado = _query($sql_verificacion_marcado);
        $esta_marcado = _num_rows($query_verificacion_marcado);
        $tabla = 'tblrespuesta_estudiante';
        if($esta_marcado){
            $row_marcado = _fetch_array($query_verificacion_marcado);
            $id_respuesta_estudiante = $row_marcado['id_respuesta_estudiante'];
            $form_data = array(
                'marcada' => $marcado
            );
            $where = " WHERE id_respuesta_estudiante = '$id_respuesta_estudiante'";
            $update = _update($tabla,$form_data,$where);
            if(!$update){
                $error++;
            }
        }
        else{
            $tabla = 'tblrespuesta_estudiante';
            $form_data = array(
                'id_pregunta' => $id_pregunta,
                'id_respuesta' => $id_respuesta,
                'id_resultado_evaluacion' => $id_resultado_evaluacion,
                'id_estudiante' => $id_estudiante,
                'marcada' => $marcado
            );
            $insertar = _insert($tabla,$form_data);
            if(!$insertar){
                $error++;
            }
        }
    }
    if($error == 0){
        $xdatos['typeinfo'] = "Success";
        $xdatos['msg'] = "Respuesta Guardada con Exito!!";
        _commit();
    }
    else{
        $xdatos['typeinfo'] = "Error";
        $xdatos['msg'] = "La Respuesta no pudo ser guardada!!";
        _rollback();
    }
    echo json_encode($xdatos);
    
}

function guardar_evaluacion_automatico(){
    $id_evaluacion = $_POST['id_evaluacion'];
    $id_resultado_evaluacion = $_POST['id_resultado_evaluacion'];
    $id_estudiante = $_SESSION['id_estudiante'];
    $tiempo_usado = $_POST['tiempo_usado'];
    $tabla = 'tblresultado_evaluacion';
    if($id_resultado_evaluacion == "-1"){
        $form_data = array(
            'id_estudiante' =>$id_estudiante,
            'id_evaluacion' => $id_evaluacion,
            'fecha_empezado' => date("Y-m-d"),
            'hora_empezado' => date("H:i:s"),
            'nota' => 0,
            'tiempo_usado' =>$tiempo_usado,
        );
        $insert = _insert($tabla,$form_data);
        $id_resultado_evaluacion = _insert_id();
    }
    else{
        $form_data = array(
            'tiempo_usado' =>$tiempo_usado,
        );
        $where = " id_resultado_evaluacion = '$id_resultado_evaluacion'";
        $insert = _update($tabla,$form_data,$where);
    }
    $xdatos['id_resultado_evaluacion'] = $id_resultado_evaluacion;
    echo json_encode($xdatos);
}

function finalizar_prueba(){
    $id_evaluacion = $_POST['id_evaluacion'];
    $id_resultado_evaluacion = $_POST['id_resultado_evaluacion'];
    $id_estudiante = $_SESSION['id_estudiante'];
    $tiempo_usado = $_POST['tiempo_usado'];    
    _begin();
    $error=0;
    $sql_tiempo = "SELECT * FROM tblevaluacion WHERE id_evaluacion = '$id_evaluacion'";
    $query_tiempo = _query($sql_tiempo);
    $row_tiempo = _fetch_array($query_tiempo);
    $tiempo_estimado = $row_tiempo['tiempo_estimado'];
    $tiempo_tardo = $tiempo_estimado - $tiempo_usado;

    $tabla = 'tblresultado_evaluacion';
    $form_data = array(
        'tiempo_usado' =>$tiempo_usado,
        'fecha_terminado' => date("Y-m-d"),
        'hora_terminado' => date("H:i:s"),
        'tiempo_realizado' => $tiempo_tardo
    );
    $where = " id_resultado_evaluacion = '$id_resultado_evaluacion'";
    $insert = _update($tabla,$form_data,$where);
    if(!$insert){
        $error++;
    }
    $sql_pregunta = "SELECT * FROM tblpregunta_evaluacion WHERE id_evaluacion = '$id_evaluacion'";
    $nota_final = 0;
    $query_pregunta = _query($sql_pregunta);
    while($row_pregunta = _fetch_array($query_pregunta)){
        $id_pregunta = $row_pregunta['id_pregunta_evaluacion'];
        $sql_respuesta = "SELECT * FROM tblrespuesta_evaluacion WHERE id_pregunta = '$id_pregunta'";
        $query_respuesta = _query($sql_respuesta);
        $total_correctas = 0;
        $total_incorrectas = 0;
        $total_respuesta = _num_rows($query_respuesta);
        while($row_respuesta = _fetch_array($query_respuesta)){
            $id_respuesta = $row_respuesta['id_respuesta'];
            $correcta = $row_respuesta['correcta'];
            $sql_comprobar_respuesta = " SELECT * FROM tblrespuesta_estudiante WHERE id_respuesta = '$id_respuesta' AND id_estudiante = '$id_estudiante' AND id_pregunta = '$id_pregunta' AND id_resultado_evaluacion = '$id_resultado_evaluacion'";
            $query_comprobar_respuesta = _query($sql_comprobar_respuesta);
            if(_num_rows($query_comprobar_respuesta) > 0){
                $row_comprobar_respuesta = _fetch_array($query_comprobar_respuesta);
                $id_respuesta_estudiante = $row_comprobar_respuesta['id_respuesta_estudiante'];
                $marcada = $row_comprobar_respuesta['marcada'];
                $tabla_update_respuesta = 'tblrespuesta_estudiante';
                if($marcada == $correcta){
                    $total_correctas++;
                    $form_update_respuesta = array(
                        'correcta' => 1
                    );
                }
                else{
                    $total_incorrectas++;
                    $form_update_respuesta = array(
                        'correcta' => 0
                    );
                }
                $where_update_respuesta = " WHERE id_respuesta_estudiante = '$id_respuesta_estudiante'";
                $update_respuesta = _update($tabla_update_respuesta,$form_update_respuesta,$where_update_respuesta);
                if(!$update_respuesta){
                    $error++;
                }
            }
        }
        $diferencia_respuesta = $total_correctas - $total_incorrectas;
        $cociente_multiplicacion = ($diferencia_respuesta/$total_respuesta);
        $sql_respuesta = "SELECT * FROM tblrespuesta_evaluacion WHERE id_pregunta = '$id_pregunta'";
        $query_respuesta = _query($sql_respuesta);
        while($row_respuesta = _fetch_array($query_respuesta)){
            $id_respuesta = $row_respuesta['id_respuesta'];
            $porcentaje = $row_respuesta['porcentaje'];
            $correcta = $row_respuesta['correcta'];
            $sql_comprobar_respuesta = " SELECT * FROM tblrespuesta_estudiante WHERE id_respuesta = '$id_respuesta' AND id_estudiante = '$id_estudiante' AND id_pregunta = '$id_pregunta' AND id_resultado_evaluacion = '$id_resultado_evaluacion'";
            $query_comprobar_respuesta = _query($sql_comprobar_respuesta);
            if(_num_rows($query_comprobar_respuesta) > 0){
                $row_comprobar_respuesta = _fetch_array($query_comprobar_respuesta);
                $id_respuesta_estudiante = $row_comprobar_respuesta['id_respuesta_estudiante'];
                $porcentaje_actualizar = $porcentaje * $cociente_multiplicacion;
                if($porcentaje_actualizar < 0){
                    $porcentaje_actualizar = 0;
                }
                //echo "PORCENTAJE ACTUALIZAR -  ".$porcentaje_actualizar;
                $nota_final+= $porcentaje_actualizar;
                $tabla_update_respuesta = 'tblrespuesta_estudiante';
                $form_update_respuesta = array(
                    'porcentaje' => $porcentaje_actualizar
                );
                $where_update_respuesta = " WHERE id_respuesta_estudiante = '$id_respuesta_estudiante'";
                $update_respuesta = _update($tabla_update_respuesta,$form_update_respuesta,$where_update_respuesta);
                if(!$update_respuesta){
                    $error++;
                }
            }
        }
    }
    $tbl_resultado_update = 'tblresultado_evaluacion';
    $form_data_resultado = array(
        'nota' => $nota_final,
        'terminado' => '1'
    );
    $where_resultado = " WHERE id_resultado_evaluacion = '$id_resultado_evaluacion'";
    $update_resultado_evaluacion = _update($tbl_resultado_update,$form_data_resultado,$where_resultado);
    if(!$update_resultado_evaluacion){
        $error++;
    }

    if($error == 0){
        $xdatos['typeinfo'] = "Success";
        $xdatos['msg'] = "Evaluacion Realizada con Exito!";
        _commit();
    }
    else{
        $xdatos['typeinfo'] = "Error";
        $xdatos['msg'] = "Problemas al ingresar la evaluacion, intente otra vez!";
        _rollback();
    }
    echo json_encode($xdatos);
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
        	case 'traer_id_preguntas':
        		traer_id_preguntas();
        		break;
            case 'traer_info_pregunta':
                traer_info_pregunta();
                break;
            case 'guardar_pregunta':
                guardar_pregunta();
                break;
            case 'guardar_evaluacion_automatico':
                guardar_evaluacion_automatico();
                break;
            case 'finalizar_prueba':
                finalizar_prueba();
                break;
        }
    }
}
?>