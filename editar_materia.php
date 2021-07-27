<?php
include_once "_core.php";

function initial() {
	// Page setup
    $title = 'Editar Materia';
	$_PAGE = array ();
	$_PAGE ['title'] = $title;
	$_PAGE ['links'] = null;
	$_PAGE ['links'] .= '<link href="css/bootstrap.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="font-awesome/css/font-awesome.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/iCheck/custom.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/chosen/chosen.css" rel="stylesheet">';
    $_PAGE ['links'] .= '<link href="css/plugins/select2/select2.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">';
    $_PAGE ['links'] .= '<link href="css/plugins/select2/select2.css" rel="stylesheet">';
    $_PAGE ['links'] .= '<link href="css/plugins/select2/select2-bootstrap.css" rel="stylesheet">';
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
    $id_materia = $_REQUEST["id_materia"];
    $query_materia = _query("SELECT * FROM tblmateria WHERE id_materia='$id_materia'");
    $datos_materia = _fetch_array($query_materia);
    $nombre = $datos_materia["nombre"];
    $descripcion = $datos_materia["descripcion"];
    $codigo = $datos_materia['codigo'];
    $unidades = $datos_materia['unidades_valorativas'];
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
                                <label>Nombre de la Materia:</label>
                                <input type="text" placeholder="Ingrese el nombre de la materia" class="form-control"
                                    id="nombre" name="nombre" value="<?php echo $nombre; ?>">
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Descripcion de la Materia:</label>
                                <input type="text" placeholder="Ingresa la descripcion de la materia"
                                    class="form-control" id="descripcion" name="descripcion" value="<?php echo $descripcion; ?>">
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Codigo de la Materia:</label>
                                <input type="text" placeholder="Ingrese el codigo de la materia" class="form-control"
                                    id="codigo" name="codigo" value="<?php echo $codigo; ?>">
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Unidades Valorativas:</label>
                                <input type="text" placeholder="Ingrese las unidades valorativas de la materia"
                                    class="form-control" id="unidades" name="unidades" value="<?php echo $unidades; ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-actions col-lg-12">
                                <input type="hidden" name="process" id="process" value="edited">
                                <input type="hidden" class="form-control" id="id_materia" name="id_materia"
                                    value="<?php echo $id_materia; ?>">
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
echo" <script type='text/javascript' src='js/funciones/funciones_materia.js'></script>";
} //permiso del script
else {
		echo "<div></div><br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div>";
	}
}

function editar()
{

    $id_materia = $_POST["id_materia"];
    $nombre=$_POST["nombre"];
    $descripcion=$_POST["descripcion"];
    $codigo = $_POST['codigo'];
    $unidades = $_POST['unidades'];

    $sql_result=_query("SELECT id_materia FROM tblmateria WHERE  id_materia='$id_materia'");
    $numrows=_num_rows($sql_result);

    $table = 'tblmateria';
    $form_data = array (
        'nombre' => $nombre,
        'descripcion' => $descripcion,
        'codigo' => $codigo,
        'unidades_valorativas' => $unidades
    );
    $where_clause = "id_materia ='".$id_materia."'";
    if($numrows != 0)
    {
        $insertar = _update($table,$form_data, $where_clause);
        if($insertar)
        {
           $xdatos['typeinfo']='Success';
           $xdatos['msg']='Materia editada correctamente!';
           $xdatos['process']='insert';
        }
        else
        {
           $xdatos['typeinfo']='Error';
           $xdatos['msg']='La Materia no pudo ser editada!';
    	}
    }
    else
    {
        $xdatos['typeinfo']='Error';
        $xdatos['msg']='La Materia no se encuentra disponible!';
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