<?php
include_once "_core.php";

function initial() {
	// Page setup
    $title = 'Agregar Estudiante';
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
                    <h3></i> <b><?php echo $title;?></b></h3>
                </div>
                <div class="ibox-content">
                    <form name="formulario" id="formulario">
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label>Nombres del Estudiante:</label>
                                <input type="text" placeholder="Ingrese el nombre del estudiante" class="form-control"
                                    id="nombre" name="nombre">
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Apellidos del Estudiante:</label>
                                <input type="text" placeholder="Ingresa el apellido del estudiante" class="form-control"
                                    id="apellido" name="apellido">
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Nombre de Usuario:</label>
                                <input type="text" placeholder="Ingrese el nombre de usuario del estudiante"
                                    class="form-control" id="usuario" name="usuario">
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Fecha de Nacimiento:</label>
                                <input type="text" placeholder="Ingrese la fecha de nacimiento del estudiante"
                                    class="form-control datepicker" id="fecha" name="fecha">
                            </div>
                            <div class="col-md-6">
                                <div class="form-group has-info">
                                    <label>Departamento <span style="color:red;">*</span></label>
                                    <select class="col-md-12 select" id="departamento" name="departamento">
                                        <option value="">Seleccione</option>
                                        <?php 
                                        $sqld = "SELECT * FROM tbldepartamento";
                                        $resultd=_query($sqld);
                                        while($depto = _fetch_array($resultd))
                                        {
                                            echo "<option value='".$depto["id_departamento"]."'>".$depto["nombre_departamento"]."</option>";
                                        }
                                    ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group has-info">
                                    <label>Municipio <span style="color:red;">*</span></label>
                                    <select class="col-md-12 select" id="municipio" name="municipio">
                                        <option value="">Primero seleccione un departamento</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group has-info">
                                    <label>Facultad <span style="color:red;">*</span></label>
                                    <select class="col-md-12 select" id="facultad" name="facultad">
                                        <option value="">Facultad</option>
                                        <?php 
                                        $sqld = "SELECT * FROM tblfacultad";
                                        $resultd=_query($sqld);
                                        while($depto = _fetch_array($resultd))
                                        {
                                            echo "<option value='".$depto["id_facultad"]."'>".$depto["nombre"]."</option>";
                                        }
                                    ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group has-info">
                                    <label>Carrera <span style="color:red;">*</span></label>
                                    <select class="col-md-12 select" id="carrera" name="carrera">
                                        <option value="">Primero seleccione una facultad</option>
                                    </select>
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
echo" <script type='text/javascript' src='js/funciones/funciones_estudiante.js'></script>";
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
    $departamento = $_POST['departamento'];
    $municipio = $_POST['municipio'];
    $facultad = $_POST['facultad'];
    $carrera = $_POST['carrera'];
    $codigo = traer_codigo_estudiante();
    //echo "--fecha--$fecha";
    $sql_result=_query("SELECT * FROM tblestudiante WHERE nombres='$nombre' AND apellidos = '$apellido'  AND usuario = '$usuario' AND deleted is NULL");/*OR apellido='$apellido'*/
    $numrows=_num_rows($sql_result);
    if($numrows == 0)
    {
        _begin();
        $table_usuario = 'tblusuario';
        $form_data_insertar = array(
            'nombre' => $usuario,
            'usuario' => $codigo,
            'password' => md5($codigo),
            'id_tipo_usuario' => 3,
            'activo' => 1,
            'id_sucursal' => $id_sucursal,
            'id_estudiante' => 0
        );
        $insertar_usuario = _insert($table_usuario, $form_data_insertar);
        if($insertar_usuario){
            $id_usuario = _insert_id();
            $table = 'tblestudiante';
            $form_data = array (
                'nombres' => $nombre,
                'apellidos' =>$apellido,
                'usuario' => $usuario,
                'fecha_de_nacimiento' => $fecha,
                'codigo' => $codigo,
                'id_sucursal' => $id_sucursal,
                'id_usuario' => $id_usuario,
                'id_departamento' => $departamento,
                'id_municipio' => $municipio,
                'id_facultad' => $facultad,
                'id_carrera' => $carrera,
                'fecha_de_inscripcion' => date("Y-m-d")
            ); 
            $insertar = _insert($table,$form_data);
            if($insertar)
            {
                $id_estudiante = _insert_id();
                $table_update = 'tblusuario';
                $form_data_update = array(
                    'id_estudiante' => $id_estudiante
                );
                $where_update = " id_usuario = '$id_usuario'";
                $update_usuario = _update($table_update,$form_data_update, $where_update);
                if($update_usuario){
                    $xdatos['typeinfo']='Success';
                    $xdatos['msg']='Estudiante ingresado correctamente!';
                    $xdatos['process']='insert';
                    actualizar_correlativo_estudiante();
                    _commit();
                }
                else{
                    $xdatos['typeinfo']='Error';
                    $xdatos['msg']='El estudiante no se pudo ingresar!';
                    _rollback();
                }
            }
            else
            {
               $xdatos['typeinfo']='Error';
               $xdatos['msg']='El estudiante no se pudo ingresar!';
               _rollback();
            }
        }
        else{
            $xdatos['typeinfo']='Error';
            $xdatos['msg']='El estudiante no se pudo ingresar!';
            _rollback();
        }
       
    }
    else
    {
        $xdatos['typeinfo']='Error';
        $xdatos['msg']='El nombre del usuario ya esta asignado a otro estudiante!!';
    }
	echo json_encode($xdatos);
}

function municipio($id_departamento)
{
    $option = "";
    $sql_mun = _query("SELECT * FROM tblmunicipio WHERE id_departamento_MUN='$id_departamento'");
    while($mun_dt=_fetch_array($sql_mun))
    {
        $option .= "<option value='".$mun_dt["id_municipio"]."'>".$mun_dt["municipio"]."</option>";
    }
    echo $option;
}

function carrera($id_facultad)
{
    $option = "";
    $sql_mun = _query("SELECT * FROM tblcarrera WHERE id_facultad='$id_facultad'");
    while($mun_dt=_fetch_array($sql_mun))
    {
        $option .= "<option value='".$mun_dt["id_carrera"]."'>".$mun_dt["nombre"]."</option>";
    }
    echo $option;
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
            case 'municipio':
                municipio($_POST["id_departamento"]);
                break;	
            case 'carrera':
                carrera($_POST["id_facultad"]);
                break;	
        }
    }
}
?>