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
                    <h3></i> <b><?php echo $title;?></b></h3>
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
                                    class="form-control" id="fecha" name="fecha">
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

    $nombre=$_POST["nombre"];
    $descripcion=$_POST["descripcion"];
    $codigo = $_POST['codigo'];
    $unidades = $_POST['unidades'];
    $sql_result=_query("SELECT * FROM tblmateria WHERE nombre='$nombre' AND codigo = '$codigo' AND deleted is NULL");/*OR descripcion='$descripcion'*/
    $numrows=_num_rows($sql_result);
    $table = 'tblmateria';
    $form_data = array (
        'nombre' => $nombre,
        'descripcion' =>$descripcion,
        'codigo' => $codigo,
        'unidades_valorativas' => $unidades
    );
    if($numrows == 0)
    {
        $insertar = _insert($table,$form_data);
        if($insertar)
        {
           $xdatos['typeinfo']='Success';
           $xdatos['msg']='Materia ingresada correctamente!';
           $xdatos['process']='insert';
        }
        else
        {
           $xdatos['typeinfo']='Error';
           $xdatos['msg']='La Materia no se pudo ingresar!';
    	}
    }
    else
    {
        $xdatos['typeinfo']='Error';
        $xdatos['msg']='El nombre de la Materia o el Codigo ya pertecene a otra materia';
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