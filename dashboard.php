    <?php
    include_once "_core.php";
    // Page setup
    $_PAGE = array();
    $_PAGE['title'] = 'Dashboard';
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
    $_PAGE['links'] .= '<link href="css/estilo_dashboard.css" rel="stylesheet">';
    

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
    /*VISTA DE DASHBOARD PARA ADMIN */
    if($admin == 1){
?>

    <script src="js/highcharts.js"></script>
    <script src="js/data.js"></script>
    <script src="js/drilldown.js"></script>
    <script src="js/exporting.js"></script>
    <script src="js//export-data.js"></script>
    <script src="js/accessibility.js"></script>
    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content">
                <div class="row">
                    <div class="col-lg-3">
                        <a href="admin_docente.php">
                            <div class="widget style1 bg-success">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <i class="fa fa-group fa-5x"></i>
                                    </div>
                                    <div class="col-xs-8 text-right">
                                        <span> Empleados </span>
                                        <h2 class="font-bold"><?php echo num_datos("tbldocente");?></h2>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3">
                        <a href="admin_estudiante.php">
                            <div class="widget style1 bg-warning">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <i class="fa fa-user fa-5x"></i>
                                    </div>
                                    <div class="col-xs-8 text-right">
                                        <span> Estudiantes </span>
                                        <h2 class="font-bold"><?php echo num_datos("tblestudiante");?></h2>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="col-lg-3">
                        <a href="admin_evaluaciones.php">
                            <div class="widget style1 bg-info">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <i class="fa fa-calendar fa-5x"></i>
                                    </div>
                                    <div class="col-xs-8 text-right">
                                        <span>Evaluaciones Pendientes</span>
                                        <h2 class="font-bold">
                                            <?php echo num_datos("tblevaluacion","WHERE id_estado< 4 AND id_estado > 1");?>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="col-lg-3">
                        <a href="admin_evaluaciones.php">
                            <div class="widget style1 bg-green">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <i class="fa fa-calendar fa-5x"></i>
                                    </div>
                                    <div class="col-xs-8 text-right">
                                        <span> Evaluaciones Finalizadas </span>
                                        <h2 class="font-bold">
                                            <?php echo num_datos("tblevaluacion","WHERE id_estado> 3 AND id_estado < 6");?>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="col-lg-3">
                        <a href="admin_curso.php">
                            <div class="widget style1 bg-dorado">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <i class="fa fa-bolt fa-5x"></i>
                                    </div>
                                    <div class="col-xs-8 text-right">
                                        <span> Cursos Activos</span>
                                        <h2 class="font-bold">
                                            <?php echo num_datos("tblcurso","WHERE activo = 1");?>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="col-lg-3">
                        <a href="admin_facultad.php">
                            <div class="widget style1 bg-danger">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <i class="fa fa-medium fa-5x"></i>
                                    </div>
                                    <div class="col-xs-8 text-right">
                                        <span>Facultades</span>
                                        <h2 class="font-bold">
                                            <?php echo num_datos("tblfacultad","WHERE deleted is NULL");?>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="col-lg-3">
                        <a href="admin_carreras.php">
                            <div class="widget style1 bg-naranja">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <i class="fa fa-book fa-5x"></i>
                                    </div>
                                    <div class="col-xs-8 text-right">
                                        <span>Carreras</span>
                                        <h2 class="font-bold">
                                            <?php echo num_datos("tblcarrera","WHERE deleted is NULL");?>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="col-lg-3">
                        <a href="admin_materia.php">
                            <div class="widget style1 bg-success">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <i class="fa fa-pencil fa-5x"></i>
                                    </div>
                                    <div class="col-xs-8 text-right">
                                        <span>Materias</span>
                                        <h2 class="font-bold">
                                            <?php echo num_datos("tblmateria","WHERE deleted is NULL");?>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title bg-green">
                    <h5 style="color:#FFF;">EVALUACIONES REALIZADAS POR MES</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up" style="color:#FFF;"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content" style="margin-top: 1.8px;">
                    <div id="container1">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title bg-green">
                    <h5 style="color:#FFF;">CURSOS CON MAS EVALUACIONES</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up" style="color:#FFF;"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content" style="margin-top: 1.8px;">
                    <div id="container2">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title bg-green">
                    <h5 style="color:#FFF;">CURSOS CON MEJOR PROMEDIO</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up" style="color:#FFF;"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content" style="margin-top: 1.8px;">
                    <div id="container3">
                    </div>
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
                    <div class="row">
                        <?php 
                    $id_estudiante = $_SESSION['id_estudiante'];
                    $sql_cursos = "SELECT * FROM tblcurso INNER JOIN tblestudiante_curso on tblcurso.id_curso = tblestudiante_curso.id_curso WHERE tblcurso.activo = 1 AND tblestudiante_curso.id_estudiante = '$id_estudiante' AND tblcurso.deleted IS NULL and tblestudiante_curso.deleted is NULL";
                    //echo $sql_cursos;
                    $query_cursos = _query($sql_cursos);
                    if(_num_rows($query_cursos) > 0){
                        while($row_cursos = _fetch_array($query_cursos)){
                            $id_curso = $row_cursos['id_curso'];
                            $nombre_curso = $row_cursos['nombre'];
                            $id_docente = $row_cursos['id_docente'];
                            $sql_docente = "SELECT * FROM tbldocente WHERE id_docente = '$id_docente'";
                            $query_docente = _query($sql_docente);
                            $row_docente = _fetch_array($query_docente);
                            $nombre_docente = $row_docente['nombres']." ".$row_docente['apellidos'];
                            $numero_imagen = rand(1, 10);
                            $nombre_imagen = "img/fondos/".$numero_imagen.".jpg";
                            ?>
                        <div class="col-lg-3">
                            <div class="container-fluid contenedor text-center">
                                <div class=" container text-center">
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 container_foto"
                                        onclick="ir_al_curso('<?php echo $id_curso;?>')">
                                        <div class="ver_mas text-center">
                                            <span class="fa fa-arrow-right"></span>
                                        </div>
                                        <article class="text-left">
                                            <h2><?php echo $nombre_curso; ?></h2>
                                            <h4><?php echo $nombre_docente;; ?></h4>
                                        </article>
                                        <img src="<?php echo $nombre_imagen; ?>" alt="">
                                    </div>

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