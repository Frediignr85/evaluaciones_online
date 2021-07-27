<?php
include_once "_core.php";

function initial() {
	// Page setup
    $title = 'Editar Usuario';
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

    $id_usuario = $_REQUEST["id_usuario"];
    $query_user = _query("SELECT * FROM tblUsuario WHERE id_usuario='$id_usuario'");
    $datos_user = _fetch_array($query_user);
    $nombre = $datos_user["nombre"];
    $usuario = $datos_user["usuario"];
    $tipo = $datos_user["id_tipo_usuario"];
    $activo = $datos_user["activo"];
    $id_empleado = $datos_user["id_empleado_usuario"];

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
                            <h3 style="color:#5a0860;"><i class="fa fa-user"></i> <b><?php echo $title;?></b></h3>
                        </div>
                        <div class="ibox-content">
                            <form name="formulario" id="formulario">
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <label>Nombre</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre; ?>">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Usuario</label>
                                        <input type="text" class="form-control" id="usuario" name="usuario" value="<?php echo $usuario; ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <label>Clave</label>
                                        <input type="password" placeholder="Ingrese una contraseña" class="form-control" id="clave" name="clave">
                                    </div>
                                    <div class="form-group col-lg-6">
                                          <label>Empleado</label>
                                          <select id="id_empleado" name="id_empleado" class="form-control select" >
                                              <option value="">Seleccione</option>
                                              <?php
                                                  $sql = _query("SELECT * FROM tblEmpleado ORDER BY id_empleado DESC");
                                                  while($row=_fetch_array($sql))
                                                  {
                                                      echo "<option value='".$row["id_empleado"]."'";
                                                      if($id_empleado == $row["id_empleado"])
                                                      {
                                                          echo " selected ";
                                                      }
                                                      echo ">".$row["nombre"]." ".$row["apellido"]."</option>";
                                                  }
                                              ?>
                                          </select>
                                      </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-3">
                                        <div class="form-group">
                                            <div class='checkbox i-checks'><br>
                                                <label id='frentex'>
                                                    <input type='checkbox' id='adminx' name='adminx' <?php if($tipo=='1') echo " checked ";?>> <strong> Administrador</strong>
                                                </label>
                                            </div>
                                            <input type='hidden' id='adminsx' name='adminsx' <?php if($tipo=='1') echo " value='1' "; else echo " value='0' "; ?>>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <div class="form-group">
                                            <div class='checkbox i-checks'><br>
                                                <label id='frentex'>
                                                    <input type='checkbox' id='activ' name='activ' <?php if($activo) echo " checked ";?>> <strong> Activo</strong>
                                                </label>
                                            </div>
                                            <input type='hidden' id='activo' name='activo' <?php if($activo) echo " value='1' "; else echo " value='0' "; ?>>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-actions col-lg-12">
                                        <input type="hidden" name="process" id="process" value="edited">
                                        <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $id_usuario; ?>">
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

function editar_usuario()
{
    $id_usuario = $_POST["id_usuario"];
    $nombre=$_POST["nombre"];
    $usuario=$_POST["usuario"];
	$clave=md5($_POST["clave"]);
    $id_empleado = $_POST["id_empleado"];
    $admin=$_POST["admin"];
    $activo=$_POST["activo"];
    $sql_result=_query("SELECT id_usuario FROM tblUsuario WHERE usuario='$usuario' AND id_usuario!='$id_usuario'");
    $numrows=_num_rows($sql_result);
    if($admin != 1){
        $admin =2;
    }
    $table = 'tblUsuario';
    $form_data = array (
    'id_empleado_usuario' => $id_empleado,
    'nombre' => $nombre,
    'usuario' => $usuario,
    'password' => $clave,
    'id_tipo_usuario' => $admin,
    'activo' => $activo
    );
    $where_clause = "id_usuario ='".$id_usuario."'";
    if($numrows == 0)
    {
        $insertar = _update($table,$form_data, $where_clause);
        if($insertar)
        {
            _updated_at($table,$where_clause);
           $xdatos['typeinfo']='Success';
           $xdatos['msg']='Usuario editado correctamente!';
           $xdatos['process']='insert';
        }
        else
        {
           $xdatos['typeinfo']='Error';
           $xdatos['msg']='Usuario no pudo ser editado!';
    	}
    }
    else
    {
        $xdatos['typeinfo']='Error';
        $xdatos['msg']='Este usuario no esta disponible, intente con uno diferente!';
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
        		editar_usuario();
        		break;
        }
    }
}
?>
