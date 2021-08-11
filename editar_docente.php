<?php
include_once "_core.php";

function initial() {
	// Page setup
    $title = 'Editar Docente';
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


	include_once "header.php";
	include_once "main_menu.php";
    //permiso del script
	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];
	$uri = $_SERVER['SCRIPT_NAME'];
    $filename=get_name_script($uri);
    $links=permission_usr($id_user,$filename);
    $id_docente = $_REQUEST["id_docente"];
    $query_materia = _query("SELECT * FROM tbldocente WHERE id_docente='$id_docente'");
    $datos_materia = _fetch_array($query_materia);
    $nombres = $datos_materia["nombres"];
    $apellidos = $datos_materia["apellidos"];
    $usuario = $datos_materia['usuario'];
    $fecha_de_nacimiento = $datos_materia['fecha_de_nacimiento'];
    //permiso del script
	if ($links!='NOT' || $admin=='1' )
    {
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
                    <h3><b><?php echo $title;?></b></h3>
                </div>
                <div class="ibox-content">
                    <form name="formulario" id="formulario">
                        <div class="row">
                        <div class="form-group col-lg-6">
                                <label>Nombre del Docente:</label>
                                <input type="text" placeholder="Ingrese el nombre del docente" class="form-control"
                                    id="nombre" name="nombre" value="<?php echo $nombres;  ?>">
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Apellido del Docente:</label>
                                <input type="text" placeholder="Ingresa el apellido del docente" class="form-control"
                                    id="apellido" name="apellido" value="<?php echo $apellidos;  ?>">
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Nombre de Usuario:</label>
                                <input type="text" placeholder="Ingrese el nombre de usuario del docente"
                                    class="form-control" id="usuario" name="usuario" value="<?php echo $usuario;  ?>">
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Fecha de Nacimiento:</label>
                                <input type="text" placeholder="Ingrese la fecha de nacimiento del docente"
                                    class="form-control datepicker" id="fecha" name="fecha"  value="<?php echo ED($fecha_de_nacimiento);  ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-actions col-lg-12">
                                <input type="hidden" name="process" id="process" value="edited">
                                <input type="hidden" class="form-control" id="id_docente" name="id_docente"
                                    value="<?php echo $id_docente; ?>">
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
echo" <script type='text/javascript' src='js/funciones/funciones_docente.js'></script>";
} //permiso del script
else {
		echo "<div></div><br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div>";
	}
}

function editar()
{

    $id_docente = $_POST["id_docente"];
    $nombre=$_POST["nombre"];
    $apellido=$_POST["apellido"];
    $usuario = $_POST['usuario'];
    $fecha_de_nacimiento = MD($_POST['fecha']);

    $sql_result=_query("SELECT id_docente FROM tbldocente WHERE  id_docente='$id_docente'");
    $numrows=_num_rows($sql_result);
    _begin();
    $table = 'tbldocente';
    $form_data = array (
        'nombres' => $nombre,
        'apellidos' => $apellido,
        'usuario' => $usuario,
        'fecha_de_nacimiento' => $fecha_de_nacimiento
    );
    $where_clause = "id_docente ='".$id_docente."'";
    if($numrows != 0)
    {
        $sql_result2 = _query("SELECT * FROM tbldocente WHERE usuario = '$usuario' AND id_docente != '$id_docente'");
        $numrows2 = _num_rows($sql_result2);
        if($numrows2 > 0){
            $xdatos['typeinfo']='Error';
            $xdatos['msg']='El nombre de usuario ya esta asignado a otro docente!';
            _rollback();
        }
        else{
            $insertar = _update($table,$form_data, $where_clause);
            if($insertar)
            {
                $table_update_usuario = 'tblusuario';
                $array_update_usuario = array(
                    'usuario' => $usuario
                );
                $where_usuario = " id_empleado = '$id_docente'";
                $update2 = _update($table_update_usuario, $array_update_usuario, $where_usuario);
                if($update2){
                    $xdatos['typeinfo']='Success';
                    $xdatos['msg']='Docente editado correctamente!';
                    $xdatos['process']='insert';
                    _commit();
                }else{
                    $xdatos['typeinfo']='Error';
                    $xdatos['msg']='No se pudo Editar el docente!';
                    _rollback();
                }
            }
            else
            {
                $xdatos['typeinfo']='Error';
                $xdatos['msg']='No se pudo Editar el docente!';
                _rollback();
            }
        } 
    }
    else
    {
        $xdatos['typeinfo']='Error';
        $xdatos['msg']='No se pudo Editar el docente!';
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
        	case 'edited':
        		editar();
        		break;
        }
    }
}
?>