<?php
    include_once "_core.php";
    // Page setup
    $_PAGE = array();
    $_PAGE['title'] = 'Ver Curso';
    $_PAGE['links'] = null;
    $_PAGE['links'] .= '<link href="css/bootstrap.min.css" rel="stylesheet">';
    $_PAGE['links'] .= '<link href="font-awesome/css/font-awesome.css" rel="stylesheet">';
    $_PAGE['links'] .= '<link href="css/plugins/iCheck/custom.css" rel="stylesheet">';
    $_PAGE['links'] .= '<link href="css/plugins/chosen/chosen.css" rel="stylesheet">';
    $_PAGE['links'] .= '<link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">';
    $_PAGE['links'] .= '<link href="css/plugins/jQueryUI/jquery-ui-1.10.4.custom.min.css" rel="stylesheet">';
    $_PAGE['links'] .= '<link href="css/plugins/jqGrid/ui.jqgrid.css" rel="stylesheet">';
    $_PAGE['links'] .= '<link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">';
    $_PAGE['links'] .= '<link href="css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">';
    $_PAGE['links'] .= '<link href="css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">';
    $_PAGE['links'] .= '<link href="css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">';
    $_PAGE['links'] .= '<link href="css/animate.css" rel="stylesheet">';
    $_PAGE['links'] .= '<link href="css/style.css" rel="stylesheet">';
    $_PAGE['links'] .= '<link href="css/estilo_evaluacion.css" rel="stylesheet">';

    include_once "header.php";
    include_once "main_menu.php";
    //permiso del script
	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];
	$uri = $_SERVER['SCRIPT_NAME'];
	$filename=get_name_script($uri);
	$links=permission_usr($id_user,$filename);

    //permiso del script
    date_default_timezone_set('America/El_Salvador');
    $fecha_actual = date("Y-m-d");
    $id_curso = $_REQUEST['id_curso'];
    /*VISTA DE DASHBOARD PARA ADMIN */
    if($admin == 1){
?>
<div class="row">
    <div class="col-lg-12">
        <div class="wrapper wrapper-content">
            <div class="row">
                <div class="col-lg-3">
                    <a href="admin_paciente.php">
                        <div class="widget style1 bg-success">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-group fa-5x"></i>
                                </div>
                                <div class="col-xs-8 text-right">
                                    <span> Empleados </span>
                                    <h2 class="font-bold"><?php echo num_datos("tblempleado");?></h2>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!--<div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title bg-green"><h5>Video Tutorial</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link" style="color: #fff;"><i class="fa fa-chevron-up"></i></a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <figure>
                                <iframe width="495" height="250" src="http://www.youtube.com/embed/bwj2s_5e12U" frameborder="0" allowfullscreen></iframe>
                            </figure>
                        </div>
                    </div>
                </div>   -->
            </div>
        </div>
    </div>


    <?php
}

/*VISTA DE DASHBOARD PARA DOCENTE */
if($admin == 2){
    ?>


    <?php
}

/* VISTA DE DASHBOARD PARA ESTUDIANTE */

if($admin == 3){
    ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content">
                <?php
                    $sql_curso = "SELECT * FROM tblcurso WHERE id_curso = '$id_curso'";
                    $query_curso = _query($sql_curso);
                    $row_curso = _fetch_array($query_curso);
                    $nombre_curso = $row_curso['nombre'];
                    $id_docente = $row_curso['id_docente'];
                    $id_materia = $row_curso['id_materia'];
                    $sql_materia = "SELECT * FROM tblmateria WHERE id_materia = '$id_materia'";
                    $query_materia = _query($sql_materia);
                    $row_materia = _fetch_array($query_materia);
                    $nombre_materia = $row_materia['nombre'];
                    $descripcion_materia = $row_materia['descripcion'];
                    $codigo_materia = $row_materia['codigo'];
                    $unidades_valorativas = $row_materia['unidades_valorativas'];
                    $sql_docente = "SELECT * FROM tbldocente WHERE id_docente = '$id_docente'";
                    $query_docente = _query($sql_docente);
                    $row_docente = _fetch_array($query_docente);
                    $nombre_docente = $row_docente['nombres']." ".$row_docente['apellidos'];
                ?>
            </div>
            <div class="wrapper wrapper-content">
                <div class="row">
                    <?php 
                    $id_estudiante = $_SESSION['id_estudiante'];
                    $sql_evaluacion = "SELECT * FROM tblevaluacion WHERE id_curso = '$id_curso' ORDER BY id_evaluacion DESC";
                    $query_evaluacion = _query($sql_evaluacion);
                    if(_num_rows($query_evaluacion) > 0){
                        while($row_evaluacion = _fetch_array($query_evaluacion)){
                            $id_evaluacion = $row_evaluacion['id_evaluacion'];
                            $nombre_evaluacion = $row_evaluacion['nombre'];
                            $descripcion_evaluacion = $row_evaluacion['descripcion'];
                            $nota_minima = number_format($row_evaluacion['nota_minima'],2,".");
                            $nota_maxima = number_format($row_evaluacion['nota_maxima'],2,".");
                            $tiempo_estimado = number_format($row_evaluacion['tiempo_estimado'],2,":")." Minutos";
                            $fecha_inicio = ED($row_evaluacion['fecha_inicio']);
                            $hora_inicio = _hora_media_decode($row_evaluacion['hora_inicio']);
                            $fecha_fin = ED($row_evaluacion['fecha_fin']);
                            $hora_fin = _hora_media_decode($row_evaluacion['hora_fin']);
                            $id_estado = $row_evaluacion['id_estado'];
                        ?>
                    <div class="col-lg-12">
                        <div class="card-new">
                            <div class="card-header"><?php echo $nombre_evaluacion; ?></div>
                            <div class="card-body">
                                <h2><b>Descripcion: </b> <?php echo $descripcion_evaluacion; ?> </h2>
                                <h3><b>Nota Minima: </b> <?php echo $nota_minima; ?> , <b>Nota Maxima: </b><?php echo $nota_maxima; ?> , <b>Tiempo estimado: </b><?php echo $tiempo_estimado; ?></h3>
                                <h3><b>Fecha de Inicio: </b> <?php echo $fecha_inicio." ".$hora_inicio; ?> , <b>Fecha de finalizacion: </b><?php echo $fecha_fin." ".$hora_fin; ?></h3>
                                <h3><b>Docente Encargado: </b> <?php echo $nombre_docente; ?> </h3>
                            </div>
                            <div class="card-footer">
                                <?php
                                    $sql_estado_estudiante = "SELECT * FROM tblresultado_evaluacion WHERE id_evaluacion = '$id_evaluacion' AND id_estudiante = '$id_estudiante' AND terminado = '1'";
                                    $query_estado_estudiante = _query($sql_estado_estudiante);
                                    $numero_estado_estudiante = _num_rows($query_estado_estudiante);
                                    if($numero_estado_estudiante == 0 && $id_estado == 3){
                                        ?>
                                        <button type="button" class="btn btn-warning btn_empezar_prueba" id="<?php echo $id_evaluacion; ?>">Empezar la Prueba</button>
                                        <?php
                                    }
                                    if($numero_estado_estudiante == 0 && $id_estado > 3){
                                        ?>
                                        <h2 class='text-warning'><b>USTED NO HA REALIZADO LA PRUEBA! </b</h2>
                                        <?php
                                    }
                                    if($numero_estado_estudiante > 0 && $id_estado == 3){
                                        ?>
                                        <h2 class='text-warning'><b>PRUEBA FINALIZADA CON EXITO!! </b</h2>
                                        <?php
                                    }
                                    if($numero_estado_estudiante > 0 && $id_estado == 6){
                                        ?>
                                        <button type="button" class="btn btn-info">Revisar los resultados!</button>
                                        <?php
                                    }
                                    if($numero_estado_estudiante > 0 && $id_estado == 4){
                                        ?>
                                        <h2 class='text-warning'><b>PRUEBA FINALIZADA, ESPERAR RESULTADOS! </b</h2>
                                        <?php
                                    }
                                    if($numero_estado_estudiante > 0 && $id_estado == 4){
                                        ?>
                                        <h2 class='text-warning'><b>PRUEBA EN REVISION, ESPERAR RESULTADOS! </b</h2>
                                        <?php
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                        }
                    }
                    else{

                    }


                ?>


                </div>
            </div>
        </div>
    </div>

    <?php
}

































 include("footer.php");
 echo '<script src="js/funciones/funciones_dashboard.js"></script>';
?>