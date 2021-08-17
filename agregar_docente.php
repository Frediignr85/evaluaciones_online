<?php
include_once "_core.php";

function initial() {
	// Page setup
    $title = 'Agregar Docente';
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
                                <label>Nombre del Docente:</label>
                                <input type="text" placeholder="Ingrese el nombre del docente" class="form-control"
                                    id="nombre" name="nombre">
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Apellido del Docente:</label>
                                <input type="text" placeholder="Ingresa el apellido del docente" class="form-control"
                                    id="apellido" name="apellido">
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Nombre de Usuario:</label>
                                <input type="text" placeholder="Ingrese el nombre de usuario del docente"
                                    class="form-control" id="usuario" name="usuario">
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Fecha de Nacimiento:</label>
                                <input type="text" placeholder="Ingrese la fecha de nacimiento del docente"
                                    class="form-control datepicker" id="fecha" name="fecha">
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
echo" <script type='text/javascript' src='js/funciones/funciones_docente.js'></script>";
} //permiso del script
else {
		echo "<div></div><br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div>";
	}
}


function insertar()
{
    $id_sucursal = $_SESSION['id_sucursal'];
    $nombre=$_POST["nombre"];
    $apellido=$_POST["apellido"];
    $usuario = $_POST['usuario'];
    $fecha = MD($_POST['fecha']);
    $codigo = traer_codigo_docente();
    //echo "--fecha--$fecha";
    $sql_result=_query("SELECT * FROM tbldocente WHERE nombres='$nombre' AND apellidos = '$apellido'  AND usuario = '$usuario' AND deleted is NULL");/*OR apellido='$apellido'*/
    $numrows=_num_rows($sql_result);
    if($numrows == 0)
    {
        _begin();
        $table_usuario = 'tblusuario';
        $form_data_insertar = array(
            'nombre' => $usuario,
            'usuario' => $codigo,
            'password' => md5($codigo),
            'id_tipo_usuario' => 2,
            'activo' => 1,
            'id_sucursal' => $id_sucursal,
            'id_estudiante' => 0
        );
        $insertar_usuario = _insert($table_usuario, $form_data_insertar);
        if($insertar_usuario){
            $id_usuario = _insert_id();
            $table = 'tbldocente';
            $form_data = array (
                'nombres' => $nombre,
                'apellidos' =>$apellido,
                'usuario' => $usuario,
                'fecha_de_nacimiento' => $fecha,
                'codigo' => $codigo,
                'id_sucursal' => $id_sucursal,
                'id_usuario' => $id_usuario
            );
            $insertar = _insert($table,$form_data);
            if($insertar)
            {
                $id_docente = _insert_id();
                $table_update = 'tblusuario';
                $form_data_update = array(
                    'id_empleado' => $id_docente
                );
                $where_update = " id_usuario = '$id_usuario'";
                $update_usuario = _update($table_update,$form_data_update, $where_update);
                if($update_usuario){
                    $xdatos['typeinfo']='Success';
                    $xdatos['msg']='Docente ingresado correctamente!';
                    $xdatos['process']='insert';
                    actualizar_correlativo_docente();
                    asignar_permisos_docente($id_usuario);
                    _commit();
                }
                else{
                    $xdatos['typeinfo']='Error';
                    $xdatos['msg']='El docente no se pudo ingresar!';
                    _rollback();
                }
            }
            else
            {
               $xdatos['typeinfo']='Error';
               $xdatos['msg']='El docente no se pudo ingresar!';
               _rollback();
            }
        }
        else{
            $xdatos['typeinfo']='Error';
            $xdatos['msg']='El docente no se pudo ingresar!';
            _rollback();
        }
       
    }
    else
    {
        $xdatos['typeinfo']='Error';
        $xdatos['msg']='El nombre del usuario ya esta asignado a otro docente!!';
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