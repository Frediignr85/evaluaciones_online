<?php
include_once "_core.php";

function initial() {
	// Page setup
  $title = 'Agregar Usuario';
	$_PAGE = array ();
	$_PAGE ['title'] = $title;
	$_PAGE ['links'] = null;
	$_PAGE ['links'] .= '<link href="css/bootstrap.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="font-awesome/css/font-awesome.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/iCheck/custom.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/chosen/chosen.css" rel="stylesheet">';
    $_PAGE ['links'] .= '<link href="css/plugins/select2/select2.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/jQueryUI/jquery-ui-1.10.4.custom.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/jqGrid/ui.jqgrid.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">';
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
                                        <label>Nombre</label>
                                        <input type="text" placeholder="Ingresa nombre" class="form-control" id="nombre" name="nombre">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Usuario</label>
                                        <input type="text" placeholder="Ingrese usuario" class="form-control" id="usuario" name="usuario">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <label>Clave</label>
                                        <input type="password" placeholder="Ingrese la contraseña " class="form-control" id="clave" name="clave">
                                    </div>
                                    
                                </div>
                                <div class="row">
                                  <div class="form-group col-lg-3">
                                      <div class="form-group">
                                          <div class='checkbox i-checks'><br>
                                              <label id='frentex'>
                                                  <input type='checkbox' id='adminx' name='adminx'> <strong> Administrador</strong>
                                              </label>
                                          </div>
                                          <input type='hidden' id='adminsx' name='adminsx' value="0">
                                      </div>
                                  </div>
                                </div>
                                <div class="row">
                                    <div class="form-actions col-lg-12">
                                        <input type="hidden" name="process" id="process" value="insert">
                                        <input type="hidden" name="activo" id="activo" value="1">
                                        <input type="submit" id="submit1" name="submit1" value="Guardar" class="btn btn-primary m-t-n-xs pull-right"/>
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
echo "<script src='js/funciones/funciones_usuarios.js'></script>";
} //permiso del script
else {
		echo "<div></div><br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div>";
	}
}
function insertar_usuario()
{

    $nombre=$_POST["nombre"];
    $usuario=$_POST["usuario"];
	$clave=md5($_POST["clave"]);
    $admin=$_POST["admin"];
    $activo = $_POST["activo"];
    $id_sucursal = $_SESSION['id_sucursal'];
    $sql_result=_query("SELECT id_usuario FROM tblUsuario WHERE usuario='$usuario'");
    $numrows=_num_rows($sql_result);
    if($admin != 1){
        $admin =2;
    }
    $table = 'tblUsuario';
    $form_data = array (
        'nombre' => $nombre,
        'usuario' => $usuario,
        'password' => $clave,
        'id_tipo_usuario' => $admin,
        'activo' => $activo,
        'id_sucursal' => $id_sucursal
    );

    if($numrows == 0)
    {
        $insertar = _insert($table,$form_data);
        if($insertar)
        {
           $xdatos['typeinfo']='Success';
           $xdatos['msg']='Usuario ingresado correctamente!';
           $xdatos['process']='insert';
        }
        else
        {
           $xdatos['typeinfo']='Error';
           $xdatos['msg']='Usuario no pudo ser ingresado!';
    	}
    }
    else
    {
        $xdatos['typeinfo']='Error';
        $xdatos['msg']='Este usuario ya fue ingresado!';
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
        		insertar_usuario();
        		break;
        }
    }
}
?>
