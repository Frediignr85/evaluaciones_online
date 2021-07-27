<?php
include_once "_core.php";

function initial() {
	// Page setup
    $title = 'Agregar Empleado';
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
	$_PAGE ['links'] .= '<link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/animate.css" rel="stylesheet">';
    $_PAGE ['links'] .= '<link href="css/style.css" rel="stylesheet">';
    $_PAGE ['links'] .= '<link href="css/plugins/fileinput/fileinput.css" media="all" rel="stylesheet" type="text/css"/>';

	include_once "header.php";
	include_once "main_menu.php";

    //permiso del script
    $id_sucursal=1;//$_SESSION['id_sucursal'];
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
                    <h3 class="text-navy"><b><i class="fa fa-plus-circle fa-1x"></i> <?php echo $title;?></b></h3>
                </div>
                <div class="ibox-content">
                    <form name="formulario" id="formulario">
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label>Nombres</label>
                                <input type="text" placeholder="Ingrese Nombres" class="form-control may" id="nombre" name="nombre">
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Apellidos</label>
                                <input type="text" placeholder="Ingrese Apellidos" class="form-control may" id="apellido" name="apellido">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label>Dirección</label>
                                <input type="text" placeholder="Ingrese Dirección " class="form-control may" id="direccion" name="direccion">
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Teléfono</label>
                                <input type="text" placeholder="Teléfono" class="form-control" id="telefono" name="telefono">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-3">
                                <label>Area</label>
                                <select class="col-md-12 select" id="area" name="area" >
                                    <option value="">Seleccionar</option>
                                    <?php
                                        $sqld = "SELECT * FROM tblDeptos";
                                        $resultd=_query($sqld);
                                        while($depto = _fetch_array($resultd))
                                        {
                                            echo "<option value='".$depto["id_depto"]."'";
                                            echo">".$depto["nom_depto"]."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Sueldo base</label>
                                <input type="text" placeholder="Ingrese el sueldo" class="form-control decimal" id="sueldo" name="sueldo">
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Fecha de inicio</label>
                                <input type="text" placeholder="Ingrese fecha de inicio de operaciones" class="form-control datepicker" id="inicio_operaciones" name="inicio_operaciones" >
                            </div>
                            <div class="col-lg-3">
                                 <div class="form-group has-info single-line">
                                    <label>Imagen</label>
                                    <input type="file" name="logo" id="logo" class="file" data-preview-file-type="image">
                                    <input type="hidden" name="id_id_p" id="id_id_p">
                                    <input type="hidden" name="process" id="process" value="insert_img">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-3">
                                <label>Género</label>
                                <select class="col-md-12 select" id="sexo" name="sexo" >
                                    <option value="">Seleccionar</option>
                                    <?php
                                        $sqld = "SELECT * FROM tblSexo";
                                        $resultd=_query($sqld);
                                        while($depto = _fetch_array($resultd))
                                        {
                                            echo "<option value='".$depto["id_sexo"]."'";
                                            echo">".$depto["sexo"]."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>N° Dui</label>
                                <input type="text" placeholder="Ingrese N° Dui" class="form-control" id="dui" name="dui">
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Fecha de Nacimiento</label>
                                <input type="text" placeholder="Ingrese fecha de nacimiento" class="form-control datepicker" id="fecha_na" name="fecha_na" >
                            </div>
                            <div class="form-group col-lg-3">
                                <label> Seleccion Cargo</label>
                                    <select class="col-md-12 select" id="tipo_empleado" name="tipo_empleado">
                                        <option value="">Seleccione</option>
                                        <?php
                                            $sqld = "SELECT * FROM tblCargos";
                                            $resul=_query($sqld);
                                            while($depto = _fetch_array($resul))
                                            {
                                                echo "<option value='".$depto["id_cargo"]."'";
                                                echo">".$depto["nom_cargo"]."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-actions col-lg-12">
                                    <input type="hidden" name="process" id="process" value="insert">
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
echo "<script src='js/funciones/funciones_empleado.js'></script>";


} //permiso del script
else {
		echo "<div></div><br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div>";
	}
}


function insertar_empleado()
{
    /*
    $nombre=$_POST["nombre"];
    $apellido=$_POST["apellido"];
	$direccion=$_POST["direccion"];
    $telefono = $_POST["telefono"];
    $sexo = $_POST["sexo"];
    $dui = $_POST["dui"];
    $tipo = $_POST["tipo"];    
    $fechaN = MD($_POST["fecha_na"]);
    $id_sucursal=$_SESSION['id_sucursal'];
    $departamento = $_POST['area'];
    $sueldo = $_POST['sueldo'];
    $fecha_inicio = MD($_POST['inicio_operaciones']);

    $sql_result=_query("SELECT * from tblEmpleado  order by id_empleado DESC limit 1");
    if(_num_rows($sql_result) == 0){
        $correlativo = "001";
    }
    else{
        $row=_fetch_array($sql_result);
        $correlativo=$row['correlativo']+1;  
    }
    $correlative=str_pad($correlativo, 3, '0', STR_PAD_LEFT);

    $codigo_ingresar = "0218".$correlative;

    $sql_result=_query("SELECT id_empleado FROM tblEmpleado WHERE nombre='$nombre' and dui='$dui' and id_sucursal_EMP='$id_sucursal'");
    $numrows=_num_rows($sql_result);
    if($numrows == 0)
    {
        $table = 'tblEmpleado';
        $form_data = array (
            'nombre' => $nombre,
            'apellido' => $apellido,
            'direccion' => $direccion,
            'telefono' => $telefono,
            'id_sexo_EMP' => $sexo,
            'dui' => $dui,
            'fecha_de_nacimiento' => $fechaN,
            'id_tipo_empleado_EMP' => $tipo,
            'id_estado_EMP' => 1,
            'id_sucursal_EMP' => $id_sucursal,
            'codigo' => $codigo_ingresar,
            'correlativo' =>$correlativo,
            'sueldo' => $sueldo,
            'fecha_inicio' => $fecha_inicio,
            'id_area' => $departamento
        );
        $insertar = _insert($table,$form_data);
        if($insertar)
        {
            $xdatos['typeinfo']='Success';
            $xdatos['msg']='Empleado agregado correctamente!';
            $xdatos['process']='insert';
        }
        else
        {
            $xdatos['typeinfo']='Error';
            $xdatos['msg']='Empleado no pudo ser ingresado!';
    	}
    }
    else
    {
        $xdatos['typeinfo']='Error';
        $xdatos['msg']='Este Empleado ya fue ingresado!';
    }
	echo json_encode($xdatos);*/

    require_once 'class.upload.php';
    $nombre=$_POST["nombre"];
    $apellido=$_POST["apellido"];
	$direccion=$_POST["direccion"];
    $telefono = $_POST["telefono"];
    $sexo = $_POST["sexo"];
    $dui = $_POST["dui"];
    $tipo = $_POST["tipo_empleado"];    
    $fechaN = MD($_POST["fecha_na"]);
    $id_sucursal=$_SESSION['id_sucursal'];
    $departamento = $_POST['area'];
    $sueldo = $_POST['sueldo'];
    $fecha_inicio = MD($_POST['inicio_operaciones']);
    $id_sucursal=$_SESSION["id_sucursal"];

    $sql_result=_query("SELECT * from tblEmpleado  order by id_empleado DESC limit 1");
    if(_num_rows($sql_result) == 0){
        $correlativo = "001";
    }
    else{
        $row=_fetch_array($sql_result);
        $correlativo=$row['correlativo']+1;  
    }
    $correlative=str_pad($correlativo, 3, '0', STR_PAD_LEFT);

    $codigo_ingresar = "0218".$correlative;

    $sql_result=_query("SELECT id_empleado FROM tblEmpleado WHERE nombre='$nombre' and dui='$dui' and id_sucursal_EMP='$id_sucursal'");
    $numrows=_num_rows($sql_result);
    if($numrows > 0)
    {
        $xdatos['typeinfo']='Error';
        $xdatos['msg']='Ya existe ese empleado registrado!';
    }
    else
    {
        if ($_FILES["logo"]["name"]!="")
        {
            $foo = new \Verot\Upload\Upload($_FILES['logo'],'es_ES');
            if ($foo->uploaded)
            {
                $pref = uniqid()."_";
                $foo->file_force_extension = false;
                $foo->no_script = false;
                $foo->file_name_body_pre = $pref;
            // save uploaded image with no changes
            $foo->Process('img/');
            if ($foo->processed)
            {
                    $query = _query("SELECT imagen FROM tblempleado WHERE dui='$dui'");
                    $numero = _num_rows($query);
                    $urlb="";
                    if($numero > 0){
                        $result = _fetch_array($query);
                        $urlb=$result["imagen"];
                    }

                    if($urlb!="" && file_exists($urlb))
                    {
                        unlink($urlb);
                    }
                    $cuerpo=quitar_tildes($foo->file_src_name_body);
                    $cuerpo=trim($cuerpo);
                    $logo = 'img/'.$pref.$cuerpo.".".$foo->file_src_name_ext;
                }else{
                    echo "Error al subir la imagen";
                    }
            }
        }else {
                $logo = '';

        }
        $table = 'tblEmpleado';
        $form_data = array (
            'nombre' => $nombre,
            'apellido' => $apellido,
            'direccion' => $direccion,
            'telefono' => $telefono,
            'id_sexo_EMP' => $sexo,
            'dui' => $dui,
            'fecha_de_nacimiento' => $fechaN,
            'id_tipo_empleado_EMP' => $tipo,
            'id_estado_EMP' => 1,
            'id_sucursal_EMP' => $id_sucursal,
            'codigo' => $codigo_ingresar,
            'correlativo' =>$correlativo,
            'sueldo' => $sueldo,
            'fecha_inicio' => $fecha_inicio,
            'id_area' => $departamento,
            'imagen' => $logo
        );
        $insertar = _insert($table,$form_data);
        if($insertar)
        {
            $xdatos['typeinfo']='Success';
            $xdatos['msg']='Empleado agregado correctamente!';
            $xdatos['process']='insert';
        }
        else
        {
            $xdatos['typeinfo']='Error';
            $xdatos['msg']='Empleado no pudo ser ingresado!';
    	}
    }
    echo json_encode($xdatos);
}
function cambiarFormato($fecha){
    $fechaN = explode("-",$fecha);
    $fecha = $fechaN[2]."-".$fechaN[1]."-".$fechaN[0];
    return $fecha;
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
        		insertar_empleado();
        		break;
        }
    }
}
?>
