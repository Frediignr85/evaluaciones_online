<?php
include_once "_core.php";

function initial() {
	// Page setup
    $title = 'Agregar Evaluacion';
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
    $_PAGE ['links'] .= '<link href="css/estilos_evaluacion.css" rel="stylesheet">';
    $_PAGE['links'] .= '<link href="css/plugins/timepicki/timepicki.css" rel="stylesheet">';    
    $_PAGE ['links'] .= '<link href="css/plugins/sweetalert/sweetalert.css" rel="stylesheet">';


	include_once "header.php";
	include_once "main_menu.php";
    //permiso del script
	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];
	$uri = $_SERVER['SCRIPT_NAME'];
    $filename=get_name_script($uri);
    $links=permission_usr($id_user,$filename);
	//permiso del script
    
    $id_evaluacion = "-1";
    $nombre = "";
    $descripcion = "";
    $nota_maxima = "";
    $nota_minima ="";
    $id_curso = "";
    $fecha_inicio = "";
    $fecha_fin = "";
    $hora_inicio = "";
    $hora_fin = "";
    $tiempo_estimado = "";
    if(isset($_REQUEST['id_curso'])){
        $id_curso = $_REQUEST['id_curso'];
    }
    if(isset($_REQUEST['id_evaluacion'])){
        $id_evaluacion = $_REQUEST['id_evaluacion'];
        $sql_evaluacion = "SELECT * FROM tblevaluacion WHERE id_evaluacion = '$id_evaluacion'";
        $query_evaluacion = _query($sql_evaluacion);
        if(_num_rows($query_evaluacion) > 0){
            $row_evaluacion = _fetch_array($query_evaluacion);
            $nombre = $row_evaluacion['nombre'];
            $descripcion = $row_evaluacion['descripcion'];
            $nota_maxima = $row_evaluacion['nota_maxima'];
            $nota_minima = $row_evaluacion['nota_minima'];
            $id_curso = $row_evaluacion['id_curso'];
            $fecha_inicio = $row_evaluacion['fecha_inicio'];
            $fecha_fin = $row_evaluacion['fecha_fin'];
            $hora_inicio = $row_evaluacion['hora_inicio'];
            $hora_fin = $row_evaluacion['hora_fin'];
            $tiempo_estimado = $row_evaluacion['tiempo_estimado'];
        }
    }
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
                    <h2 style="color:#194160;"><i class="fa fa-user"></i> <b><?php echo $title;?></b></h2> (Los campos
                    marcados con <span style="color:red;">*</span> son requeridos)
                </div>
                <div class="ibox-content">
                    <!-- ESTE CONTAINER SERA EL ENCARGADO DE ALMACENAR LOS PROGRESS BAR -->
                    <div class="container">
                        <!--ACA EMPIEZA EL PRIMER PROGRESS BAR CON 0% DE AVANCE EL CUAL REFLEJARA QUE SE DEBEN DE INTRODUCIR
                        LOS DATOS GENERALES DE LA EVALUACION QUE SE PRETENDE CREAR -->
                        <div id="parte_1">
                            <h3 style="color:#F68383;">Parte #1 - Datos Generales Sobre la Prueba</b></h3>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 0%; color:black;"
                                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">0%</div>
                            </div>
                        </div>
                        <!--ACA FINALIZA EL PRIMER PROGRESS BAR CON 0% DE AVANCE EL CUAL REFLEJARA QUE SE DEBEN DE INTRODUCIR
                        LOS DATOS GENERALES DE LA EVALUACION QUE SE PRETENDE CREAR -->
                        <!--ACA EMPIEZA EL SEGUNDO PROGRESS BAR CON 25% DE AVANCE EL CUAL REFLEJARA QUE SE DEBEN DE INTRODUCIR
                        LAS PREGUNTAS Y LAS RESPUESTAS DE LA EVALUACION QUE SE PRETENDE CREAR -->
                        <div id="parte_2">
                            <h3 style="color:#F68383;">Parte #2 - Ingreso de Preguntas y Respuestas</b></h3>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 25%"
                                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                            </div>
                        </div>
                        <!--ACA FINALIZA EL SEGUNDO PROGRESS BAR CON 25% DE AVANCE EL CUAL REFLEJARA QUE SE DEBEN DE INTRODUCIR
                        LAS PREGUNTAS Y LAS RESPUESTAS DE LA EVALUACION QUE SE PRETENDE CREAR -->
                        <!--ACA EMPIEZA EL TERCER PROGRESS BAR CON 50% DE AVANCE EL CUAL REFLEJARA QUE SE DEBEN DE INTRODUCIR
                        LOS PORCENTAJES QUE TENDRAN LAS PREGUNTAS Y LAS RESPUESTAS DE LA EVALUACION QUE SE PRETENDE CREAR -->
                        <div id="parte_3">
                            <h3 style="color:#F68383;">Parte #3 - Ingreso de Porcentajes</b></h3>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 50%"
                                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">50%</div>
                            </div>
                        </div>
                        <!--ACA FINALIZA EL TERCER PROGRESS BAR CON 50% DE AVANCE EL CUAL REFLEJARA QUE SE DEBEN DE INTRODUCIR
                        LOS PORCENTAJES QUE TENDRAN LAS PREGUNTAS Y LAS RESPUESTAS DE LA EVALUACION QUE SE PRETENDE CREAR -->
                        <!--ACA EMPIEZA EL CUARTO PROGRESS BAR CON 75% DE AVANCE EL CUAL REFLEJARA QUE SE DEBE DE REVISAR
                        LA PRUEBA CREADA CON ANTERIORIDAD -->
                        <div id="parte_4">
                            <h3 style="color:#F68383;">Parte #4 - Revision de la Prueba</b></h3>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 75%"
                                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">75%</div>
                            </div>
                        </div>
                        <!--ACA FINALIZA EL CUARTO PROGRESS BAR CON 75% DE AVANCE EL CUAL REFLEJARA QUE SE DEBE DE REVISAR
                        LA PRUEBA CREADA CON ANTERIORIDAD -->
                    </div>
                    <!-- ESTE CONTAINER SERA EL ENCARGADO DE ALMACENAR LOS PROGRESS BAR -->
                    <!-- ESTE CONTAINER SERA EL ENCARGADO DE ALMACENAR CADA UNA DE LAS PARTES DEL REGISTRO DE
                    UNA EVALUACION -->
                    <div class="container-partes">
                        <!--ACA EMPIEZA EL PRIMER DIV EL CUAL REFLEJARA QUE SE DEBEN DE INTRODUCIR
                        LOS DATOS GENERALES DE LA EVALUACION QUE SE PRETENDE CREAR -->
                        <div id="primer_div">
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <h3 style="color:#194160;"> <b>Nombre de la evaluacion: <span
                                                style="color:red;">*</span></b></h3>
                                    <input type="text" placeholder="Ingrese el nombre de la evaluacion"
                                        class="form-control" id="nombre" name="nombre"
                                        <?php if(isset($_REQUEST['id_evaluacion'])){ echo "value=\"$nombre\"";} ?>>
                                </div>
                                <div class="form-group col-lg-2">
                                    <h3 style="color:#194160;"> <b>Tiempo estimado: <span
                                                style="color:red;">*</span></b></h3>
                                    <input type="number" placeholder="Ingrese el tiempo estimado (MIN)"
                                        class="form-control" id="tiempo_estimado" name="tiempo_estimado"
                                        <?php if(isset($_REQUEST['id_evaluacion'])){ echo "value=\"$tiempo_estimado\"";} ?>>
                                </div>
                                <div class="form-group col-lg-2">
                                    <h3 style="color:#194160;"> <b>Nota Minima: <span style="color:red;">*</span></b>
                                    </h3>
                                    <input type="number" placeholder="Ingrese la nota minima" class="form-control"
                                        id="nota_minima" name="nota_minima"
                                        <?php if(isset($_REQUEST['id_evaluacion'])){ echo "value=\"$nota_minima\"";} ?>>
                                </div>
                                <div class="form-group col-lg-2">
                                    <h3 style="color:#194160;"> <b>Nota Maxima: <span style="color:red;">*</span></b>
                                    </h3>
                                    <input type="number" placeholder="Ingrese la nota maxima" class="form-control"
                                        id="nota_maxima" name="nota_maxima"
                                        <?php if(isset($_REQUEST['id_evaluacion'])){ echo "value=\"$nota_maxima\"";} ?>>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-2">
                                    <h3 style="color:#194160;"> <b>Fecha de Inicio: <span
                                                style="color:red;">*</span></b></h3>
                                    <input type="text" placeholder="Ingrese la fecha de inicio"
                                        class="form-control datepicker" id="fecha_inicio" name="fecha_inicio"
                                        <?php if(isset($_REQUEST['id_evaluacion'])){ echo "value=\"".ED($fecha_inicio)."\"";} ?>>
                                </div>
                                <div class="form-group col-lg-2">
                                    <h3 style="color:#194160;"> <b>Hora de Inicio: <span style="color:red;">*</span></b>
                                    </h3>
                                    <input type="text" placeholder="Ingrese la hora de inicio" class="form-control"
                                        id="hora_inicio" name="hora_inicio"
                                        <?php if(isset($_REQUEST['id_evaluacion'])){ echo "value=\""._hora_media_decode($hora_inicio)."\"";} ?>>
                                </div>
                                <div class="form-group col-lg-2">
                                    <h3 style="color:#194160;"> <b>Fecha de Finalizacion: <span
                                                style="color:red;">*</span></b></h3>
                                    <input type="text" placeholder="Ingrese la fecha de finalizacion"
                                        class="form-control datepicker" id="fecha_fin" name="fecha_fin"
                                        <?php if(isset($_REQUEST['id_evaluacion'])){ echo "value=\"".ED($fecha_fin)."\"";} ?>>
                                </div>
                                <div class="form-group col-lg-2">
                                    <h3 style="color:#194160;"> <b>Hora de Finalizacion: <span
                                                style="color:red;">*</span></b></h3>
                                    <input type="text" placeholder="Ingrese la hora de finalizacion"
                                        class="form-control" id="hora_fin" name="hora_fin"
                                        <?php if(isset($_REQUEST['id_evaluacion'])){ echo "value=\""._hora_media_decode($hora_fin)."\"";} ?>>
                                </div>
                                <div class="form-group col-lg-4">
                                    <h3 style="color:#194160;"> <b>Curso: <span style="color:red;">*</span></b></h3>
                                    <select class="col-md-12 select" id="curso" name="curso">
                                        <option value="">Seleccione</option>
                                        <?php
                                        if($admin == 1){
                                            $sql_docente = "SELECT tblcurso.id_curso, tblcurso.nombre as 'nombre_curso', tblmateria.nombre as 'nombre_materia' FROM tblcurso INNER JOIN tblmateria on tblmateria.id_materia = tblcurso.id_materia WHERE tblcurso.deleted is NULL";
                                            $query_docente = _query($sql_docente);
                                            while($row_docente = _fetch_array($query_docente)){
                                                echo "<option value='".$row_docente["id_curso"]."'";
                                                if(isset($_REQUEST['id_evaluacion']) || isset($_REQUEST['id_curso'])){
                                                    if($id_curso == $row_docente['id_curso']){
                                                        echo " selected ";
                                                    }
                                                }
                                                echo ">".$row_docente["nombre_curso"]." | ".$row_docente['nombre_materia']."</option>";
                                            }
                                        }
                                        else{
                                            $sql_docente = "SELECT tblcurso.id_curso, tblcurso.nombre as 'nombre_curso', tblmateria.nombre as 'nombre_materia' FROM tblcurso 
                                            INNER JOIN tblmateria on tblmateria.id_materia = tblcurso.id_materia
                                            LEFT JOIN tbldocente on tbldocente.id_docente = tblcurso.id_docente
                                            LEFT JOIN tbldocente_curso on tbldocente_curso.id_curso = tblcurso.id_curso
                                            WHERE tblcurso.deleted is NULL AND (tbldocente_curso.id_docente = '".$_SESSION['id_docente']."' OR tblcurso.id_docente = '".$_SESSION['id_docente']."' )";
                                            $query_docente = _query($sql_docente);
                                            while($row_docente = _fetch_array($query_docente)){
                                                echo "<option value='".$row_docente["id_curso"]."'";
                                                if(isset($_REQUEST['id_evaluacion']) || isset($_REQUEST['id_curso'])){
                                                    if($id_curso == $row_docente['id_curso']){
                                                        echo " selected ";
                                                    }
                                                }
                                                echo ">".$row_docente["nombre_curso"]." | ".$row_docente['nombre_materia']."</option>";
                                            }
                                        }
                                        
                                    ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12">
                                    <h3 style="color:#194160;"> <b>Descripcion de la evaluacion: <span
                                                style="color:red;">*</span></b></h3>
                                    <textarea name="descripcion_evaluacion" id="descripcion_evaluacion" cols="10"
                                        style="width: 100%;"><?php if(isset($_REQUEST['id_evaluacion'])){ echo $descripcion;} ?></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <?php
                                        if(isset($_REQUEST['id_evaluacion'])){
                                           ?>
                                    <button type="button" id="btn_siguiente_1" class="btn btn-danger"
                                        style="float:right;">Siguiente</button>
                                    <?
                                        }
                                    ?>
                                    <button type="button" id="btn_guardar_siguiente" class="btn btn-warning"
                                        style="float:right;margin-right:10px;">Guardar y Siguiente</button>
                                    <button type="button" id="btn_guardar" class="btn btn-success"
                                        style="float:right;margin-right:10px;">Guardar</button>
                                </div>
                            </div>

                        </div>
                        <!--ACA FINALIZA EL PRIMER DIV EL CUAL REFLEJARA QUE SE DEBEN DE INTRODUCIR
                        LOS DATOS GENERALES DE LA EVALUACION QUE SE PRETENDE CREAR -->
                        <!--ACA EMPIEZA EL SEGUNDO DIV EL CUAL REFLEJARA QUE SE DEBEN DE INTRODUCIR
                        LAS PREGUNTAS Y LAS RESPUESTAS DE LA EVALUACION QUE SE PRETENDE CREAR -->
                        <div id="segundo_div">
                            <div class="row">
                                <div class="col-md-10">
                                    <h2 style="color:#194160;"><?php echo "Tabla de Preguntas y Respuestas";?></b></h2>
                                </div>
                                <div class="col-md-2">
                                    <a style="margin-top: 10px; float:right; border-radius:5px;" class="btn btn-success"
                                        data-toggle="modal" data-target="#viewModal" data-refresh="true"
                                        href="agregar_pregunta_respuesta.php?id_evaluacion=<?php echo $id_evaluacion;?>"><i
                                            class="fa fa-plus-circle fa-2x"></i> Agregar</a>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12" style="margin-top:10px;">
                                    <table class="table">
                                        <thead class="thead-dark" style="background:#D3F29E;">
                                            <tr>
                                                <th scope="col-md-1">#</th>
                                                <th scope="col-md-3">Pregunta</th>
                                                <th scope="col-md-3">Respuestas</th>
                                                <th scope="col-md-3">Tipo</th>
                                                <th scope="col-md-2">Accion</th>
                                            </tr>
                                        </thead>
                                        <tbody id="preguntas_respuestas">

                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="btn_segunda_parte">

                                    </div>
                                    <button type="button" id="btn_anterior1" class="btn btn-warning"
                                        style="float:left;margin-right:10px;">Anterior</button>
                                </div>
                            </div>
                        </div>
                        <!--ACA FINALIZA EL SEGUNDO DIV EL CUAL REFLEJARA QUE SE DEBEN DE INTRODUCIR
                        LAS PREGUNTAS Y LAS RESPUESTAS DE LA EVALUACION QUE SE PRETENDE CREAR -->
                        <!--ACA EMPIEZA EL TERCER DIV EL CUAL REFLEJARA QUE SE DEBEN DE INTRODUCIR
                        LOS PORCENTAJES QUE TENDRAN LAS PREGUNTAS Y LAS RESPUESTAS DE LA EVALUACION QUE SE PRETENDE CREAR -->
                        <div id="tercer_div">
                            <div class="row">
                                <div class="col-md-9">
                                    <h2 style="color:#194160;">
                                        <?php echo "Ingreso de Porcentajes a Preguntas y Respuestas";?></b></h2>
                                </div>
                                <div class="col-md-3">
                                    <h2 style="color:#194160;" id="comparacion_notas">0 / <?php echo $nota_maxima; ?> De Nota</h2>
                                </div>
                                <div class="col-md-12" style="margin-top:10px;">
                                    <table class="table">
                                        <thead class="thead-dark" style="background:#D3F29E;">
                                            <tr>
                                                <th scope="col-md-1">#</th>
                                                <th scope="col-md-3">Pregunta </th>
                                                <th scope="col-md-3">Respuestas</th>
                                                <th scope="col-md-3">Tipo </th>
                                                <th scope="col-md-2">Porcentaje (Puntos)</th>
                                            </tr>
                                        </thead>
                                        <tbody id="porcentaje_respuestas">

                                        </tbody>
                                    </table>

                                    <button type="button" id="btn_anterior2" class="btn btn-warning"
                                        style="float:left;">Anterior</button>
                                    <button type="button" id="btn_guardar_siguiente2" class="btn btn-warning"
                                        style="float:right;margin-right:10px;">Guardar y Siguiente</button>
                                    <button type="button" id="btn_guardar2" class="btn btn-success"
                                        style="float:right;margin-right:10px;">Guardar</button>
                                </div>
                            </div>
                        </div>
                        <!--ACA FINALIZA EL TERCER DIV EL CUAL REFLEJARA QUE SE DEBEN DE INTRODUCIR
                        LOS PORCENTAJES QUE TENDRAN LAS PREGUNTAS Y LAS RESPUESTAS DE LA EVALUACION QUE SE PRETENDE CREAR -->
                        <!--ACA EMPIEZA EL CUARTO DIV EL CUAL REFLEJARA QUE SE DEBE DE REVISAR
                        LA PRUEBA CREADA CON ANTERIORIDAD -->
                        <div id="cuarto_div">
                            <div class="row">
                            <div class="col-md-9">
                                    <h2 style="color:#194160;">
                                        <?php echo "Revision de la evaluacion";?></b></h2>
                                </div>
                                <div class="col-md-3">
                                    <h2 style="color:#194160;" id="comparacion_notas"> <?php echo $nota_maxima; ?> /  <?php echo $nota_maxima; ?> De Nota</h2>
                                </div>
                                <div class="col-md-12" style="margin-top:10px;">
                                    <table class="table">
                                        <thead class="thead-dark" style="background:#D3F29E;">
                                            <tr>
                                                <th scope="col-md-1">#</th>
                                                <th scope="col-md-3">Pregunta </th>
                                                <th scope="col-md-3">Respuestas</th>
                                                <th scope="col-md-3">Tipo </th>
                                                <th scope="col-md-2">Porcentaje (Puntos)</th>
                                            </tr>
                                        </thead>
                                        <tbody id="revision_final">

                                        </tbody>
                                    </table>

                                    <button type="button" id="btn_anterior3" class="btn btn-warning"
                                        style="float:left;">Anterior</button>
                                    <button type="button" id="btn_guardar_publicar" class="btn btn-warning"
                                        style="float:right;margin-right:10px;">Publicar y Salir</button>
                                    <button type="button" id="btn_guardar3" class="btn btn-success"
                                        style="float:right;margin-right:10px;">Publicar</button>
                                </div>
                            </div>
                        </div>
                        <!--ACA FINALIZA EL CUARTO DIV EL CUAL REFLEJARA QUE SE DEBE DE REVISAR
                        LA PRUEBA CREADA CON ANTERIORIDAD -->
                    </div>
                    <!-- ESTE CONTAINER SERA EL ENCARGADO DE ALMACENAR CADA UNA DE LAS PARTES DEL REGISTRO DE
                    UNA EVALUACION -->
                </div>

                <input type="hidden" name="fecha_actual" id="fecha_actual" value="<?php echo date("d-m-Y"); ?>">
                <input type="hidden" name="hora_actual" id="hora_actual"
                    value="<?php echo  _hora_media_decode(date("H:i:s")); ?>">
                <input type="hidden" name="id_evaluacion" id="id_evaluacion" value="<?php echo $id_evaluacion; ?>">
                <input type="hidden" name="nota_maxima" id="nota_maxima" value="<?php echo $nota_maxima; ?>">
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" id="viewModal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

            </div>
        </div>
    </div>
</div>

<?php
include_once ("footer.php");
echo" <script type='text/javascript' src='js/funciones/funciones_evaluaciones.js'></script>";
} //permiso del script
else {
		echo "<div></div><br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div>";
	}
}


function insertar()
{
    $id_sucursal = $_SESSION['id_sucursal'];
    $nombre = $_POST['nombre'];
    $tiempo_estimado = $_POST['tiempo_estimado'];
    $nota_minima = $_POST['nota_minima'];
    $nota_maxima = $_POST['nota_maxima'];
    $fecha_inicio = MD($_POST['fecha_inicio']);
    $hora_inicio = _hora_media_encode($_POST['hora_inicio']);
    $fecha_fin = MD($_POST['fecha_fin']);
    $hora_fin = _hora_media_encode($_POST['hora_fin']);
    $curso = $_POST['curso'];
    $descripcion_evaluacion = $_POST['descripcion_evaluacion'];
    $fecha_actual = MD($_POST['fecha_actual']);
    $hora_actual = _hora_media_encode($_POST['hora_actual']);
    $id_evaluacion = $_POST['id_evaluacion'];
    $id_usuario = $_SESSION['id_usuario'];

    $tabla = 'tblevaluacion';
    if($id_evaluacion == "-1"){
        $form_data = array(
            'nombre' => $nombre,
            'descripcion' => $descripcion_evaluacion,
            'nota_maxima' => $nota_maxima,
            'nota_minima' => $nota_minima,
            'id_estado' => 1,
            'id_curso' => $curso,
            'id_usuario' => $id_usuario,
            'fecha_creacion' => $fecha_actual,
            'hora_creacion' => $hora_actual,
            'fecha_inicio' => $fecha_inicio,
            'hora_inicio' => $hora_inicio,
            'fecha_fin' => $fecha_fin,
            'hora_fin' => $hora_fin,
            'tiempo_estimado' => $tiempo_estimado,
            'id_sucursal' => $id_sucursal
        );
        $insertar = _insert($tabla,$form_data);
        $id_evaluacion = _insert_id();
    }
    else{
        $form_data = array(
            'nombre' => $nombre,
            'descripcion' => $descripcion_evaluacion,
            'nota_maxima' => $nota_maxima,
            'nota_minima' => $nota_minima,
            'id_curso' => $curso,
            'fecha_inicio' => $fecha_inicio,
            'hora_inicio' => $hora_inicio,
            'fecha_fin' => $fecha_fin,
            'hora_fin' => $hora_fin,
            'tiempo_estimado' => $tiempo_estimado,
        );
        $where = " WHERE id_evaluacion = '$id_evaluacion'";
        $insertar = _update($tabla,$form_data,$where);
    }
    if($insertar){
        $xdatos['typeinfo'] = "Success";
        $xdatos['msg'] ="Registro guardado con exito!!";
        $xdatos['id_evaluacion'] = $id_evaluacion;
    }
    else{
        $xdatos['typeinfo'] = "Success";
        $xdatos['msg'] ="Registro guardado con exito!!";
    }
    echo json_encode($xdatos);
}

/* ESTA FUNCION MANDARA A TRAER TODA LA TABLA */
function actualizar_tabla(){
    $id_evaluacion = $_POST['id_evaluacion'];
    $sql_preguntas = "SELECT * FROM tblpregunta_evaluacion WHERE id_evaluacion = '$id_evaluacion' AND deleted is NULL";
    //echo $sql_preguntas;
    $query_preguntas = _query($sql_preguntas);
    $array_preguntas = array();
    $numero = 1;
    if(_num_rows($query_preguntas) > 0){
        while($row_preguntas = _fetch_array($query_preguntas)){
            $id_pregunta = $row_preguntas['id_pregunta_evaluacion'];
            $descripcion = $row_preguntas['descripcion'];
            $tabla_devolver = "<tr class='pregu' id='".$id_pregunta."'>";
            $sql_respuestas = "SELECT * FROM tblrespuesta_evaluacion WHERE id_pregunta = '$id_pregunta' AND deleted is NULL";
            $query_respuestas = _query($sql_respuestas);
            $numero_espacios = _num_rows($query_respuestas);
            $numero_espacios+=1;
            $tabla_devolver.="<td rowspan=".$numero_espacios.">$numero</td>";
            $tabla_devolver.="<td rowspan=".$numero_espacios.">$descripcion</td>";
            if( $numero> 0){
                $contador_x =0;
                while($row_respuestas = _fetch_array($query_respuestas)){
                    $id_respuesta = $row_respuestas['id_respuesta'];
                    $descripcion_respuesta  = $row_respuestas['descripcion'];
                    $correcta = $row_respuestas['correcta'];
                    if($correcta == 1){
                        $correcta = "Correcta";
                    }
                    elseif($correcta == 0){
                        $correcta = "Incorrecta";
                    }
                    $tabla_devolver.="<tr>";
                    $tabla_devolver.="<td>$descripcion_respuesta</td>";
                    $tabla_devolver.="<td>$correcta</td>";
                    if($contador_x == 0){
                        $tabla_devolver.="<td >
                        <a class='btn eliminar_pregunta' id='".$id_pregunta."'><i class='fa fa-trash'></i></a>
                        <a href='ver_pregunta.php?id_pregunta=".$id_pregunta."' class='btn' data-toggle='modal' data-target='#viewModal' data-refresh='true'><i class='fa fa-eye'></i></a>
                        <a href='agregar_pregunta_respuesta.php?id_pregunta=".$id_pregunta."' class='btn' data-toggle='modal' data-target='#viewModal' data-refresh='true'><i class='fa fa-pencil'></i></a>
                    </td>";
                    }
                    $tabla_devolver.="</tr>";
                    $contador_x++;
                }
            }
            
            
            $tabla_devolver.="</tr>";
            $numero++;
            $array_preguntas[] = array(
                'fila' => $tabla_devolver
            );
        }
    }
    echo json_encode($array_preguntas);
}

function eliminar_pregunta(){
    $id_pregunta = $_POST['id_pregunta'];
    $table1 = 'tblrespuesta_evaluacion';
    $where1 = " WHERE id_pregunta = '$id_pregunta'";
    $table2 = 'tblpregunta_evaluacion';
    $where2 = " WHERE id_pregunta_evaluacion = '$id_pregunta'";
    _begin();
    $delete1 = _delete_total($table1,$where1);
    $delete2 = _delete_total($table2,$where2);
    if($delete1 && $delete2){
        $xdatos['typeinfo'] ="Success";
        $xdatos['msg'] = "Pregunta eliminada con exito!!";
        _commit();
    }
    else{
        $xdatos['typeinfo'] ="Error";
        $xdatos['msg'] = "No se pudo eliminar la pregunta!!";
        _rollback();
    }
    echo json_encode($xdatos);
}

function verificar_preguntas(){
    $id_evaluacion = $_POST['id_evaluacion'];
    $sql_preguntas = "SELECT * FROM tblpregunta_evaluacion WHERE id_evaluacion = '$id_evaluacion'";
    $query_preguntas = _query($sql_preguntas);
    $numero_preguntas = _num_rows($query_preguntas);
    if($numero_preguntas == 0){
        echo "<h3 style=\"color:#194160;\"> <b>Pregunta: <span style=\"color:red;\">*</span></b></h3>";
    }
    elseif($numero_preguntas > 0){
        echo "<button type=\"button\" id=\"btn_siguiente_2\" class=\"btn btn-danger\"
        style=\"float:right;\">Siguiente</button>";
    }
}
function actualizar_tabla_respuestas(){
    $id_evaluacion = $_POST['id_evaluacion'];
    $sql_preguntas = "SELECT * FROM tblpregunta_evaluacion WHERE id_evaluacion = '$id_evaluacion' AND deleted is NULL";
    //echo $sql_preguntas;
    $query_preguntas = _query($sql_preguntas);
    $array_preguntas = array();
    $numero = 1;
    if(_num_rows($query_preguntas) > 0){
        while($row_preguntas = _fetch_array($query_preguntas)){
            $id_pregunta = $row_preguntas['id_pregunta_evaluacion'];
            $descripcion = $row_preguntas['descripcion'];
            $tabla_devolver = "<tr class='pregu' id='".$id_pregunta."'>";
            $sql_respuestas = "SELECT * FROM tblrespuesta_evaluacion WHERE id_pregunta = '$id_pregunta' AND deleted is NULL";
            $query_respuestas = _query($sql_respuestas);
            $numero_espacios = _num_rows($query_respuestas);
            $numero_espacios+=1;
            $tabla_devolver.="<td rowspan=".$numero_espacios.">$numero</td>";
            $tabla_devolver.="<td rowspan=".$numero_espacios.">$descripcion</td>";
            if( $numero> 0){
                $contador_x =0;
                while($row_respuestas = _fetch_array($query_respuestas)){
                    $id_respuesta = $row_respuestas['id_respuesta'];
                    $descripcion_respuesta  = $row_respuestas['descripcion'];
                    $porcentaje_x = $row_respuestas['porcentaje'];
                    $correcta = $row_respuestas['correcta'];
                    if($correcta == 1){
                        $correcta = "Correcta";
                        $porcentaje = "<td id='porcentaje_p' style='background:#9EF2BA; border:1px solid black;' class='nm comentario'>$porcentaje_x</td>";
                    }
                    elseif($correcta == 0){
                        $correcta = "Incorrecta";
                        $porcentaje = "<td id='porcentaje_p' style='background:#F29E9E;' readonly>$porcentaje_x</td>";
                    }
                    $tabla_devolver.="<tr>";
                    $tabla_devolver.="<td>$descripcion_respuesta</td>";
                    $tabla_devolver.="<td>$correcta</td>";
                    $tabla_devolver.="<td class='id_respuesta_evaluacion' hidden>$id_respuesta</td>";
                    $tabla_devolver.=$porcentaje;
                    $tabla_devolver.="</tr>";
                    $contador_x++;
                }
            }
            
            
            $tabla_devolver.="</tr>";
            $numero++;
            $array_preguntas[] = array(
                'fila' => $tabla_devolver
            );
        }
    }
    echo json_encode($array_preguntas);
}

function update_porcentajes(){
    $array_json=$_POST['json_arr'];
    $array = json_decode($array_json, true);
    _begin();
    $error = 0;
    foreach ($array as $key => $fila){
        $id_respuesta=$fila['id'];
        $porcentaje = $fila['porcentaje'];
        $tabla_insertar = 'tblrespuesta_evaluacion';
        $array_insertar = array(
            'porcentaje' => $porcentaje
        );
        $where = " WHERE id_respuesta = '$id_respuesta'";
        $insertar = _update($tabla_insertar, $array_insertar,$where);
        if(!$insertar){
            $error++;
        }
    }
    if($error == 0){
        $xdatos['typeinfo'] ="Success";
        $xdatos['msg'] ="Porcentajes actualizados correctamente!";
        _commit();
    }
    else{
        $xdatos['typeinfo'] ="Error";
        $xdatos['msg'] ="No se pudieron actualizar los porcentajes de la evaluacion!";
        _rollback();
    }
    echo json_encode($xdatos);
}

function actualizar_tabla_revision(){
    $id_evaluacion = $_POST['id_evaluacion'];
    $sql_nota_maxima = "SELECT * FROM tblevaluacion WHERE id_evaluacion = '$id_evaluacion'";
    $query_nota_maxima = _query($sql_nota_maxima);
    $row_nota_maxima = _fetch_array($query_nota_maxima);
    $nota_maxima = $row_nota_maxima['nota_maxima'];
    $sql_preguntas = "SELECT * FROM tblpregunta_evaluacion WHERE id_evaluacion = '$id_evaluacion' AND deleted is NULL";
    //echo $sql_preguntas;
    $query_preguntas = _query($sql_preguntas);
    $array_preguntas = array();
    $numero = 1;
    if(_num_rows($query_preguntas) > 0){
        while($row_preguntas = _fetch_array($query_preguntas)){
            $id_pregunta = $row_preguntas['id_pregunta_evaluacion'];
            $descripcion = $row_preguntas['descripcion'];
            $tabla_devolver = "<tr class='pregu' id='".$id_pregunta."'>";
            $sql_respuestas = "SELECT * FROM tblrespuesta_evaluacion WHERE id_pregunta = '$id_pregunta' AND deleted is NULL";
            $query_respuestas = _query($sql_respuestas);
            $numero_espacios = _num_rows($query_respuestas);
            $numero_espacios+=1;
            $tabla_devolver.="<td rowspan=".$numero_espacios.">$numero</td>";
            $tabla_devolver.="<td rowspan=".$numero_espacios.">$descripcion</td>";
            if( $numero> 0){
                $contador_x =0;
                while($row_respuestas = _fetch_array($query_respuestas)){
                    $id_respuesta = $row_respuestas['id_respuesta'];
                    $descripcion_respuesta  = $row_respuestas['descripcion'];
                    $porcentaje_x = $row_respuestas['porcentaje'];
                    $per = (($porcentaje_x/$nota_maxima)*100);
                    $correcta = $row_respuestas['correcta'];
                    if($correcta == 1){
                        $correcta = "Correcta";
                        $porcentaje = "<td id='porcentaje_p' style='background:#9EF2BA; border:1px solid black;'>$porcentaje_x  ($per%)</td>";
                        $tabla_devolver.="<tr>";
                        $tabla_devolver.="<td style='background:#9EF2BA; border:1px solid black;'>$descripcion_respuesta</td>";
                        $tabla_devolver.="<td style='background:#9EF2BA; border:1px solid black;'>$correcta</td>";
                        $tabla_devolver.=$porcentaje;
                        $tabla_devolver.="</tr>";
                    }
                    elseif($correcta == 0){
                        $correcta = "Incorrecta";
                        $porcentaje = "<td id='porcentaje_p' style='background:#F29E9E; border:1px solid black;' >$porcentaje_x</td>";
                        $tabla_devolver.="<tr>";
                        $tabla_devolver.="<td style='background:#F29E9E; border:1px solid black;'>$descripcion_respuesta</td>";
                        $tabla_devolver.="<td style='background:#F29E9E; border:1px solid black;'>$correcta</td>";
                        $tabla_devolver.=$porcentaje;
                        $tabla_devolver.="</tr>";
                    }
                    
                    $contador_x++;
                }
            }
            $tabla_devolver.="</tr>";
            $numero++;
            $array_preguntas[] = array(
                'fila' => $tabla_devolver
            );
        }
    }
    echo json_encode($array_preguntas);
}

function update_evaluacion(){
    $id_evaluacion = $_POST['id_evaluacion'];
    $tabla = 'tblevaluacion';
    $form_data = array(
        'id_estado' => 2
    );
    $where = " WHERE id_evaluacion = '$id_evaluacion'";
    $update = _update($tabla,$form_data,$where);
    if($update){
        $xdatos['typeinfo'] ="Success";
        $xdatos['msg'] ="Evaluacion actualizada correctamente!";
    }
    else{
        $xdatos['typeinfo'] ="Error";
        $xdatos['msg'] ="No se pudieron actualizar la evaluacion!";
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
        	case 'insertar_evaluacion':
        		insertar();
        		break;
            case 'actualizar_tabla':
                actualizar_tabla();
                break;
            case 'eliminar_pregunta':
                eliminar_pregunta();
                break;
            case 'verificar_preguntas':
                verificar_preguntas();
                break;
            case 'actualizar_tabla_respuestas':
                actualizar_tabla_respuestas();
                break;
            case 'update_porcentajes':
                update_porcentajes();
                break;
            case 'actualizar_tabla_revision':
                actualizar_tabla_revision();
                break;
            case 'update_evaluacion':
                update_evaluacion();
                break;
        }
    }
}
?>