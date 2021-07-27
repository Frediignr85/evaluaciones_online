<?php
include_once "_core.php";

function initial() {
	// Page setup
    $title = 'Editar Facultad';
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
    $id_facultad = $_REQUEST["id_facultad"];
    $query_facultad = _query("SELECT * FROM tblfacultad WHERE id_facultad='$id_facultad'");
    $datos_facultad = _fetch_array($query_facultad);
    $nombre = $datos_facultad["nombre"];
    $descripcion = $datos_facultad["descripcion"];
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
                            <div class="form-group col-lg-12">
                                <label>Nombre de la Facultad:</label>
                                <input type="text" placeholder="Ingrese el nombre de la facultad" class="form-control"
                                    id="nombre" name="nombre" value="<?php echo $nombre; ?>">
                            </div>
                            <div class="form-group col-lg-12">
                                <label>Descripcion de la Facultad:</label>
                                <input type="text" placeholder="Ingresa la descripcion de la facultad"
                                    class="form-control" id="descripcion" name="descripcion"
                                    value="<?php echo $descripcion; ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-actions col-lg-12">
                                <input type="hidden" name="process" id="process" value="edited">
                                <input type="hidden" class="form-control" id="id_facultad" name="id_facultad"
                                    value="<?php echo $id_facultad; ?>">
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
echo" <script type='text/javascript' src='js/funciones/funciones_facultad.js'></script>";
} //permiso del script
else {
		echo "<div></div><br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div>";
	}
}

function editar()
{

    $id_facultad = $_POST["id_facultad"];
    $nombre=$_POST["nombre"];
    $descripcion=$_POST["descripcion"];

    $sql_result=_query("SELECT id_facultad FROM tblfacultad WHERE  id_facultad='$id_facultad'");
    $numrows=_num_rows($sql_result);

    $table = 'tblfacultad';
    $form_data = array (
        'nombre' => $nombre,
        'descripcion' => $descripcion,
    );
    $where_clause = "id_facultad ='".$id_facultad."'";
    if($numrows != 0)
    {
        $insertar = _update($table,$form_data, $where_clause);
        if($insertar)
        {
           $xdatos['typeinfo']='Success';
           $xdatos['msg']='Facultad editada correctamente!';
           $xdatos['process']='insert';
        }
        else
        {
           $xdatos['typeinfo']='Error';
           $xdatos['msg']='La Facultad no pudo ser editada!';
    	}
    }
    else
    {
        $xdatos['typeinfo']='Error';
        $xdatos['msg']='La facultad no se encuentra disponible!';
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