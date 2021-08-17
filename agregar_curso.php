<?php
include_once "_core.php";

function initial() {
	// Page setup
    $title = 'Agregar Curso';
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
                <h3 style="color:#194160;"><i class="fa fa-user"></i> <b><?php echo $title;?></b></h3> (Los campos marcados con <span style="color:red;">*</span> son requeridos)
                </div>
                <div class="ibox-content">
                    <form name="formulario" id="formulario">
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label>Nombre del Curso:</label>
                                <input type="text" placeholder="Ingrese el nombre del curso" class="form-control"
                                    id="nombre" name="nombre">
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Materia Asociada:</label>
                                <select class="col-md-12 select" id="materia" name="materia">
                                    <option value="">Seleccione</option>
                                    <?php
                                        $sql_materia = "SELECT * FROM tblmateria WHERE deleted is NULL";
                                        $query_materia = _query($sql_materia);
                                        while($row_materia = _fetch_array($query_materia)){
                                            echo "<option value='".$row_materia["id_materia"]."'>".$row_materia["nombre"]."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label>Docente Responsable:</label>
                                <select class="col-md-12 select" id="docente" name="docente">
                                    <option value="">Seleccione</option>
                                    <?php
                                        $sql_docente = "SELECT * FROM tbldocente WHERE deleted is NULL";
                                        $query_docente = _query($sql_docente);
                                        while($row_docente = _fetch_array($query_docente)){
                                            echo "<option value='".$row_docente["id_docente"]."'>".$row_docente["nombres"]." ".$row_docente['apellidos']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Estado:</label>
                                <br>
                                <select class="col-md-12 select" id="estado" name="estado">
                                    <option value="">Seleccione</option>
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-3">
                                <label>Fecha de Inicio:</label>
                                <input type="text" placeholder="Ingrese la fecha de inicio del curso"
                                    class="form-control datepicker" id="fecha_inicio" name="fecha_inicio">
                            </div>
                            <div class="form-group col-lg-3">
                                <div class="form-group">
                                    <label>Hora de Inicio <span style="color:red;">*</span></label>
                                    <input type="text" placeholder="HH:mm" class="form-control" id="hora_inicio"
                                        name="hora_inicio">
                                </div>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Fecha de Finalizacion:</label>
                                <input type="text" placeholder="Ingrese la fecha de inicio del curso"
                                    class="form-control datepicker" id="fecha_fin" name="fecha_fin">
                            </div>
                            <div class="form-group col-lg-3">
                                <div class="form-group">
                                    <label>Hora de Finalizacion <span style="color:red;">*</span></label>
                                    <input type="text" placeholder="HH:mm" class="form-control" id="hora_fin"
                                        name="hora_fin">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-actions col-lg-12">
                                <input type="hidden" name="process" id="process" value="insert">
                                <input type="submit" id="submit1" name="submit1" value="Guardar"
                                    class="btn btn-primary m-t-n-xs pull-right" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<?php
include_once ("footer.php");
echo" <script type='text/javascript' src='js/funciones/funciones_curso.js'></script>";
} //permiso del script
else {
		echo "<div></div><br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div>";
	}
}


function insertar()
{
    $id_sucursal = $_SESSION['id_sucursal'];
    $nombre=$_POST["nombre"];
    $materia=$_POST["materia"];
    $docente = $_POST['docente'];
    $estado = $_POST['estado'];
    $fecha_inicio = MD($_POST['fecha_inicio']);
    $fecha_fin = MD($_POST['fecha_fin']);
    $hora_inicio = $_POST['hora_inicio'];
    $hora_fin = $_POST['hora_fin'];
    //echo "--fecha--$fecha";
    $sql_result=_query("SELECT * FROM tblcurso WHERE nombre='$nombre' AND id_materia = '$materia'  AND deleted is NULL");/*OR materia='$materia'*/
    $numrows=_num_rows($sql_result);
    if($numrows == 0)
    {
        _begin();
        $table_curso = 'tblcurso';
        $form_data_insertar = array(
            'nombre' => $nombre,
            'fecha_de_creacion' => date("Y-m-d H:i:s"),
            'fecha_inicio' => $fecha_inicio." ".$hora_inicio,
            'fecha_final' => $fecha_fin." ".$hora_fin,
            'activo' => 1,
            'disponible' => $estado,
            'id_materia' => $materia,
            'id_docente' => $docente,
            'id_sucursal' => $id_sucursal
        );
        $insertar_curso = _insert($table_curso, $form_data_insertar);
        if($insertar_curso){
            $xdatos['typeinfo']='Success';
            $xdatos['msg']='Curso ingresado correctamente!';
            $xdatos['process']='insert';
            _commit();
        }
        else{
            $xdatos['typeinfo']='Error';
            $xdatos['msg']='El curso no se pudo ingresar!';
            _rollback();
        }
       
    }
    else
    {
        $xdatos['typeinfo']='Error';
        $xdatos['msg']='El nombre del curso junto a la materia ya estan asignados!!';
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
        	case 'insert':
        		insertar();
        		break;
            
        }
    }
}
?>