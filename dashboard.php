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

if ($links!='NOT' || $admin=='1' )
                        {
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

} //permiso del script
else { ?>
    <?php
    $id_usuario=$_SESSION["id_usuario"];

    $sql_permisos="SELECT tblmodulo.filename,tblmodulo.descripcion FROM tblusuario_modulo, tblmodulo WHERE id_usuario='$id_usuario' AND tblusuario_modulo.id_modulo=tblusuario_modulo.id_modulo AND tblmodulo.admin='1' GROUP BY tblmodulo.filename LIMIT 12 ";
	
    $sql_user=_query($sql_permisos);
    echo"
    <div class='row'>
    <div class='col-lg-12'>
    <div class='wrapper wrapper-content'>
    <div class='row'>";
    $contador=1;
    while($campos=_fetch_array($sql_user))
    {
        $nombre_modulo=$campos["descripcion"];
        $filename=$campos["filename"];

        if ($contador > 4) {
            $contador = 1;
            echo "</div>";
            echo"<div class='row'>";
        }


        echo "
         <div class='col-lg-3'>
                    <a href='$filename'>
                    <div class='ibox float-e-margins'>
                        <div class='ibox-title'>
                            <span class='label label-warning pull-right'>ADMINISTRAR</span>
                                <i class='fa fa-info-circle fa-3x'></i>
                            </div>
                            <div class='ibox-content'>
                                 <h3 class='no-margins'>$nombre_modulo</h3>
                            </div>
                        </div>
                    </a>
        </div>
            ";
    $contador++;
    }
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";

    ?>

       <!--div></div><br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div-->

 <?php   }
 include("footer.php");
 echo '<script src="js/funciones/funciones_dashboard.js"></script>';
?>
