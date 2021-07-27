<?php
include_once "_core.php";

function initial() {
	// Page setup
    $title = 'Editar Empleado';
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

	include_once "header.php";
	include_once "main_menu.php";
    //permiso del script
    $id_sucursal=$_SESSION['id_sucursal'];
	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];
	$uri = $_SERVER['SCRIPT_NAME'];
    $filename=get_name_script($uri);
    $links=permission_usr($id_user,$filename);

    $id_empleado = $_REQUEST["id_empleado"];
    $query_user = _query("SELECT * FROM tblEmpleado WHERE id_empleado='$id_empleado' and id_sucursal_EMP='$id_sucursal'");
    $datos_user = _fetch_array($query_user);
    $nombre = $datos_user["nombre"];
    $apellido = $datos_user["apellido"];
    $direccion = $datos_user["direccion"];
    $telefono = $datos_user["telefono"];
    $sexo = $datos_user["id_sexo_EMP"];
    $dui = $datos_user["dui"];
    $cargo = $datos_user["id_tipo_empleado_EMP"];
    $fecha_na = ED($datos_user["fecha_de_nacimiento"]);
    $sueldo = $datos_user['sueldo'];
    $fecha_inicio = ED($datos_user['fecha_inicio']);
    $id_area = $datos_user['id_area'];
    $logo = $datos_user['imagen'];
    echo $logo;

    //permiso del script
	if ($links!='NOT' || $admin=='1' )
    {
    ?>
        <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-2">
                    <input type="hidden" id="id_cargo_empleado" name="id_cargo_empleado" value="<?php echo $cargo; ?>">
                </div>
            </div>
        <div class="wrapper wrapper-content  animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h3 class="text-navy"><b><i class="fa fa-edit fa-1x"></i> <?php echo $title;?></b></h3>
                        </div>
                        <div class="ibox-content">
                            <form name="formulario" id="formulario">
                              <div class="row">
                                  <div class="form-group col-lg-6">
                                      <label>Nombre</label>
                                      <input type="text" placeholder="Ingresa Nombres" class="form-control may" id="nombre" name="nombre" value="<?php echo $nombre; ?>">
                                  </div>
                                  <div class="form-group col-lg-6">
                                      <label>Apellido</label>
                                      <input type="text" placeholder="Ingresa Apellidos" class="form-control may" id="apellido" name="apellido" value="<?php echo $apellido; ?>">
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="form-group col-lg-6">
                                      <label>Dirección</label>
                                      <input type="text" placeholder="Ingrea Dirección " class="form-control may" id="direccion" name="direccion" value="<?php echo $direccion; ?>">
                                  </div>
                                  <div class="form-group col-lg-6">
                                      <label>Telefono</label>
                                      <input type="text" placeholder="Telefono" class="form-control" id="telefono" name="telefono" value="<?php echo $telefono; ?>">
                                  </div>
                              </div>
                              <div class="row">
                            <div class="form-group col-lg-4">
                                <label>Departamento</label>
                                <select class="col-md-12 select" id="area" name="area" >
                                    <option value="">Seleccionar</option>
                                    <?php
                                        $sqld = "SELECT * FROM tblDeptos";
                                        $resultd=_query($sqld);
                                        while($depto = _fetch_array($resultd))
                                        {
                                            echo "<option value='".$depto["id_depto"]."'";
                                            if($depto["id_depto"] == $id_area){
                                                echo " selected ";
                                            }
                                            echo">".$depto["nom_depto"]."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-4">
                                <label>Sueldo base</label>
                                <input type="text" placeholder="Ingrese el sueldo" class="form-control decimal" id="sueldo" name="sueldo" value="<?php echo $sueldo ?>">
                            </div>
                            <div class="form-group col-lg-4">
                                <label>Fecha de inicio</label>
                                <input type="text" placeholder="Ingrese fecha de inicio de operaciones" class="form-control datepicker" id="inicio_operaciones" name="inicio_operaciones" value="<?php echo $fecha_inicio; ?>">
                            </div>
                        </div>
                                <div class="row">
                                    <div class="form-group col-lg-3">
                                        <label>Género</label>
                                        <select class="form-control select" name="sexo" id="sexo" value="<?php echo $sexo;?>">
                                        <?php
                                            $sqld = "SELECT * FROM tblSexo";
                                            $resultd=_query($sqld);
                                            while($depto = _fetch_array($resultd))
                                            {
                                                echo "<option value='".$depto["id_sexo"]."'";
                                                if($depto["id_sexo"] == $sexo)
                                                {
                                                    echo " selected ";
                                                }
                                                echo">".$depto["sexo"]."</option>";
                                            }
                                        ?>
                                      </select>
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <label>N° Dui</label>
                                        <input type="text" placeholder="Ingresa N° Dui" class="form-control" id="dui" name="dui" value="<?php echo $dui; ?>">
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <label>Fecha de Nacimiento</label>
                                        <input type="text" placeholder="Ingresa Fecha" class="form-control datepicker" id="fecha_na" name="fecha_na" value="<?php echo $fecha_na; ?>">
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <label> Seleccion Cargo</label>
                                        <select class="col-md-12 select" id="tipo_empleado" name="tipo_empleado" value="<?php echo $cargo; ?>">
                                            <option value="">Seleccione</option>
                                            <?php
                                                $sqld = "SELECT * FROM tblCargos";
                                                $resul=_query($sqld);
                                                while($depto = _fetch_array($resul))
                                                {
                                                    echo "<option value='".$depto["id_cargo"]."'";
                                                    if($depto["id_cargo"] == $cargo)
                                                    {
                                                        echo " selected ";
                                                    }
                                                    echo">".$depto["nom_cargo"]."</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
										<div class="form-group has-info single-line">
											<label>Imagen</label>
											<input type="file" name="logo" id="logo" class="file" data-preview-file-type="image">
										</div>
									</div>
                                    <div class="col-lg-6">
										<div class="form-group has-info" align="center">
											<?php
											if($logo=="")
											{
												$logo = "img/usuario_foto.png";
											}
											echo "<img style='width:50%; heigth:50%;' src='".$logo."'>";
											?>
										</div>
									</div>
                                </div>
                                <div class="row">
                                    <div class="form-actions col-lg-12">
                                        <input type="hidden" name="process" id="process" value="edited">
                                        <input type="hidden" name="id_empleado" id="id_empleado" value="<?php echo $id_empleado; ?>">
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


function editar_empleado()
{
    require_once 'class.upload.php';
    $id_empleado = $_POST["id_empleado"];
    $nombre=$_POST["nombre"];
    $apellido=$_POST["apellido"];
    $direccion=$_POST["direccion"];
    $telefono = $_POST["telefono"];
    $sexo = $_POST["sexo"];
    $dui = $_POST["dui"];
    $tipo = $_POST["tipo_empleado"];
    $fecha_na = MD($_POST["fecha_na"]);
    $id_sucursal=$_SESSION['id_sucursal'];
    $departamento = $_POST['area'];
    $sueldo = $_POST['sueldo'];
    $fecha_inicio = MD($_POST['inicio_operaciones']);

    $sql_result=_query("SELECT id_empleado FROM tblEmpleado WHERE id_empleado='$id_empleado'and id_sucursal_EMP='$id_sucursal'");
    $numrows=_num_rows($sql_result);
    $table = 'tblEmpleado';
    $form_data = array (
        'nombre' => $nombre,
        'apellido' => $apellido,
        'direccion' => $direccion,
        'telefono' => $telefono,
        'id_sexo_EMP' => $sexo,
        'dui' => $dui,
        'fecha_de_nacimiento' => $fecha_na,
        'id_tipo_empleado_EMP' => $tipo,
        'sueldo' => $sueldo,
        'fecha_inicio' => $fecha_inicio,
        'id_area' => $departamento
    );
    $where_clause = "id_empleado ='".$id_empleado."'and id_sucursal_EMP='".$id_sucursal."'";
    if($numrows != 0)
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
					$query = _query("SELECT imagen FROM tblempleado WHERE id_empleado='$id_empleado'");
					$result = _fetch_array($query);
					$urlb=$result["imagen"];
					if($urlb!="" && file_exists($urlb))
					{
						unlink($urlb);
					}
					$cuerpo=quitar_tildes($foo->file_src_name_body);
					$cuerpo=trim($cuerpo);
					$logo = 'img/'.$pref.$cuerpo.".".$foo->file_src_name_ext;
				}
			}
		}
        else {
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
            'fecha_de_nacimiento' => $fecha_na,
            'id_tipo_empleado_EMP' => $tipo,
            'sueldo' => $sueldo,
            'fecha_inicio' => $fecha_inicio,
            'id_area' => $departamento,
            'imagen' => $logo
        );
        $where_clause = "id_empleado ='".$id_empleado."'and id_sucursal_EMP='".$id_sucursal."'";
        $insertar = _update($table,$form_data, $where_clause);
        if($insertar)
        {
            _updated_at($table,$where_clause);
            $xdatos['typeinfo']='Success';
            $xdatos['msg']='Empleado editado correctamente!';
            $xdatos['process']='insert';
        }
        else
        {
           $xdatos['typeinfo']='Error';
           $xdatos['msg']='Empleado no pudo ser editado!';
    	}
    }
    else
    {
        $xdatos['typeinfo']='Error';
        $xdatos['msg']='Este Empleado no esta disponible, intente con uno diferente!';
    }
	echo json_encode($xdatos);
    

}
if(!isset($_POST['process'])){
	initial();
}
else
{
    if(isset($_POST['process']))
    {
        switch ($_POST['process'])
        {
        	case 'edited':
        		editar_empleado();
        		break;
        }
    }
}
?>
