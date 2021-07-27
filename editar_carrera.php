<?php
include_once "_core.php";

function initial() {
	// Page setup
    $title = 'Editar Carrera';
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
    $id_carrera = $_REQUEST["id_carrera"];
    $query_carrera = _query("SELECT * FROM tblcarrera WHERE id_carrera='$id_carrera'");
    $datos_carrera = _fetch_array($query_carrera);
    $nombre = $datos_carrera["nombre"];
    $descripcion = $datos_carrera["descripcion"];
    $id_facultad = $datos_carrera['id_facultad'];
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
                                <label>Nombre de la Carrera:</label>
                                <input type="text" placeholder="Ingrese el nombre de la carrera" class="form-control"
                                    id="nombre" name="nombre" value="<?php echo $nombre; ?>">
                            </div>
                            <div class="form-group col-lg-12">
                                <label>Descripcion de la Carrera:</label>
                                <input type="text" placeholder="Ingresa la descripcion de la carrera"
                                    class="form-control" id="descripcion" name="descripcion"
                                    value="<?php echo $descripcion; ?>">
                            </div>
                            <div class="form-group col-lg-12">
                                <label>Facultad a la que pertenece:</label>
                                <br>
                                <select name="id_facultad" id="id_facultad" class="select" style="width:100%;">
                                    <?php
                                        $sql_facultad = "SELECT * FROM tblfacultad WHERE deleted is NULL";
                                        $query_carrera = _query($sql_facultad);
                                        while($row_facultad = _fetch_array($query_carrera)){
                                            ?>
                                            <option value="<?php echo $row_facultad['id_facultad'] ?>"
                                            <?php
                                                if($row_facultad['id_facultad'] == $id_facultad){
                                                    echo " selected ";
                                                }
                                            ?>                                            
                                            ><?php echo $row_facultad['nombre'] ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-actions col-lg-12">
                                <input type="hidden" name="process" id="process" value="edited">
                                <input type="hidden" class="form-control" id="id_carrera" name="id_carrera"
                                    value="<?php echo $id_carrera; ?>">
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
echo" <script type='text/javascript' src='js/funciones/funciones_carrera.js'></script>";
} //permiso del script
else {
		echo "<div></div><br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div>";
	}
}

function editar()
{

    $id_carrera = $_POST["id_carrera"];
    $nombre=$_POST["nombre"];
    $descripcion=$_POST["descripcion"];
    $id_facultad = $_POST['id_facultad'];

    $sql_result=_query("SELECT id_carrera FROM tblcarrera WHERE  id_carrera='$id_carrera'");
    $numrows=_num_rows($sql_result);

    $table = 'tblcarrera';
    $form_data = array (
        'nombre' => $nombre,
        'descripcion' => $descripcion,
        'id_facultad' => $id_facultad
    );
    $where_clause = "id_carrera ='".$id_carrera."'";
    if($numrows != 0)
    {
        $insertar = _update($table,$form_data, $where_clause);
        if($insertar)
        {
           $xdatos['typeinfo']='Success';
           $xdatos['msg']='Carrera editada correctamente!';
           $xdatos['process']='insert';
        }
        else
        {
           $xdatos['typeinfo']='Error';
           $xdatos['msg']='La Carrera no pudo ser editada!';
    	}
    }
    else
    {
        $xdatos['typeinfo']='Error';
        $xdatos['msg']='La carrera no se encuentra disponible!';
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