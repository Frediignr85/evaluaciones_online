<?php
include_once "_core.php";
function initial() 
{
    $title='Configuraciones';
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
    $_PAGE ['links'] .= '<link href="css/plugins/fileinput/fileinput.css" media="all" rel="stylesheet" type="text/css"/>';
    $_PAGE ['links'] .= '<link href="css/animate.css" rel="stylesheet">';
    $_PAGE ['links'] .= '<link href="css/style.css" rel="stylesheet">';

    include_once "header.php";
    include_once "main_menu.php"; 

    //permiso del script
    $id_user=$_SESSION["id_usuario"];
    $id_sucursal=$_SESSION["id_sucursal"];
    $admin=$_SESSION["admin"];
    $uri = $_SERVER['SCRIPT_NAME'];
    $filename=get_name_script($uri);
    $links=permission_usr($id_user,$filename);
    
    //Get data from db
    $sql_empresa = _query("SELECT e.*, m.municipio FROM tblEmpresa as e, tblMunicipio as m WHERE  m.id_municipio=e.id_municipio_EMP AND e.id_empresa=$id_sucursal");
    $row = _fetch_array($sql_empresa);

    $nombre = $row['nombre'];
    $propietario = $row['propietario'];
    $telefono1 = $row["telefono1"];
    $telefono2 = $row["telefono2"];
    $email=$row["email"];
    $web=$row["website"];
    $direccion = $row["direccion"];
    $municipio = $row["id_municipio_EMP"];
    $nit = $row["nit"];
    $logo = $row["logo"];
    $moneda = $row["moneda"];
    $simbolo = $row["simbolo"];
                
?>
<div class="wrapper wrapper-content  animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
            <?php 
                //permiso del script
            if ($links!='NOT' || $admin=='1' ){
            ?>
            <div class="ibox-title">
                 <h3 style="color:#5a0860;"><i class="fa fa-gear"></i> <b><?php echo $title;?></b></h3> (Los campos marcados con <span style="color:red;">*</span> son requeridos)
            </div>
            <div class="ibox-content">
                <form name="formulario_empresa" id="formulario_empresa" autocomplete='off'>
                    <div class="row">
                        <div class="form-group has-info col-md-6">
                            <label>Nombre de la clínica <span style="color:red;">*</span></label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre; ?>">
                        </div>
                        <div class="form-group has-info col-md-6">
                              <label>Propietario <span style="color:red;">*</span></label>
                              <input type="text" class="form-control" id="propietario" name="propietario" value="<?php echo $propietario; ?>">
                        </div>
                    </div>
                    <div class="row">      
                        <div class="col-md-6">
                            <div class="form-group has-info">
                                <label>NIT</label>
                                <input type="text" name="nit" id="nit" class="form-control" value="<?php echo $nit; ?>">
                            </div>    
                        </div>
                        <div class="col-md-6">                                
                            <div class="form-group has-info">
                                <label>Email</label>
                                <input type="text" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
                            </div>       
                        </div>
                    </div>
                    <div class="row">      
                        <div class="col-md-6">
                            <div class="form-group has-info">
                                <label>Teléfono 1<span style="color:red;">*</span></label>
                                <input type="text" class="form-control tel" id="telefono1" name="telefono1" value="<?php echo $telefono1; ?>">
                            </div>
                        </div>    
                        <div class="col-md-6">
                            <div class="form-group has-info">
                                <label>Teléfono 2</label>
                                <input type="text" class="form-control tel" id="telefono2" name="telefono2" value="<?php echo $telefono2; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">      
                        <div class="col-md-6">
                            <div class="form-group has-info">
                                <label>Departamento <span style="color:red;">*</span></label>
                                <select class="col-md-12 select" id="departamento" name="departamento">
                                    <option value="">Seleccione</option>
                                    <?php 
                                        $sql1 = "SELECT tblDepartamento.id_departamento FROM tblDepartamento INNER JOIN tblMunicipio on tblMunicipio.id_departamento_MUN = tblDepartamento.id_departamento WHERE tblMunicipio.id_municipio = $municipio";
                                        $departamento ="";
                                        $resultd1=_query($sql1);
                                        while($depto1 = _fetch_array($resultd1))
                                        {
                                            $departamento = $depto1["id_departamento"];
                                        }
                                        
                                        $sqld = "SELECT * FROM tblDepartamento";
                                        $resultd=_query($sqld);
                                        while($depto = _fetch_array($resultd))
                                        {
                                            echo "<option value='".$depto["id_departamento"]."'";
                                            if($depto["id_departamento"] == $departamento)
                                            {
                                                echo " selected ";
                                            }
                                            echo">".$depto["nombre_departamento"]."</option>";
                                        }
                                    ?>
                                </select>
                            </div>                            
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-info">
                                <label>Municipio <span style="color:red;">*</span></label>
                                <select class="col-md-12 select" id="municipio" name="municipio">
                                    <?php 
                                        $sqld = "SELECT * FROM tblMunicipio WHERE id_departamento_MUN ='$departamento'";
                                        $resultd=_query($sqld);
                                        while($depto = _fetch_array($resultd))
                                        {
                                            echo "<option value='".$depto["id_municipio"]."'";
                                            if($depto["id_municipio"] == $municipio)
                                            {
                                                echo " selected ";
                                            }
                                            echo">".$depto["municipio"]."</option>";
                                        }
                                    ?>
                                </select>
                            </div>                            
                        </div>
                    </div>
                    <div class="row"> 
                        <div class="col-md-6">
                            <div class="form-group has-info">
                                <label>Dirección <span style="color:red;">*</span></label> 
                                <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $direccion; ?>">
                            </div>        
                        </div>     
                        <div class="col-md-6">
                            <div class="form-group has-info">
                                <label>Sitio Web</label>
                                <input type="text" class="form-control" id="web" name="web" value="<?php echo $web; ?>">
                            </div>
                        </div>    
                    </div>
                    <div class="row"> 
                        <div class="col-md-6">
                            <div class="form-group has-info">
                                <label>Moneda (Ej: dolares, lempiras, quetzales)<span style="color:red;">*</span></label> 
                                <input type="text" class="form-control" id="moneda" name="moneda" value="<?php echo $moneda; ?>">
                            </div>        
                        </div>     
                        <div class="col-md-6">
                            <div class="form-group has-info">
                                <label>Símbolo Moneda <span style="color:red;">*</span></label>
                                <input type="text" class="form-control" id="simbolo" name="simbolo" value="<?php echo $simbolo; ?>">
                            </div>
                        </div>    
                    </div>
                    <div class="row">      
                        <div class="col-md-6">
                            <div class="form-group has-info">
                                <label>Logo</label>
                                <input type="file" name="logo" id="logo" class="file" data-preview-file-type="image">
                            </div> 
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-info">
                                <img id="logo_view" src="<?php echo $logo;?>" style='width: 100px; height: 100px;'>
                            </div> 
                        </div>
                    </div>
                    <div class="row">      
                        <div class="col-md-12">
                            <div class="form-actions"><br>
                                <input type="hidden" name="process" id="process" value="edit">
                                <input type="submit" id="submit1" name="submit1" value="Guardar" class="btn btn-primary m-t-n-xs pull-right" />  
                            </div>
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
echo "<script src='js/funciones/funciones_empresa.js'></script>";
} //permiso del script
else 
{
  echo "<div></div><br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div>";
} 
}
function editar()
{
    require_once 'class.upload.php';
    $id_sucursal=$_SESSION["id_sucursal"];
    if ($_FILES["logo"]["name"]!="")
    { 
        $foo = new \Verot\Upload\Upload($_FILES['logo'],'es_ES');
        if ($foo->uploaded) {
            $pref = uniqid()."_";
            $foo->file_force_extension = false; 
            $foo->no_script = false;
            $foo->file_name_body_pre = $pref;
            // save uploaded image with no changes
            $foo->Process('img/');
            if ($foo->processed) 
            {
                $query = _query("SELECT logo FROM tblEmpresa WHERE id_empresa= $id_sucursal");
                $result = _fetch_array($query);
                $urlb=$result["logo"];
                if($urlb!="")
                {
                    unlink($urlb);
                } 
                $nombre = $_POST["nombre"];
                $propietario = $_POST["propietario"];
                $telefono1=$_POST["telefono1"];
                $telefono2=$_POST["telefono2"];
                $email=$_POST["email"];
                $web=$_POST["web"];
                $direccion=$_POST["direccion"];
                $nit=$_POST["nit"];
                $municipio=$_POST["municipio"];
                $moneda=$_POST["moneda"];
                $simbolo=$_POST["simbolo"];
                $cuerpo=quitar_tildes($foo->file_src_name_body);
                $cuerpo=trim($cuerpo);
                $url = 'img/'.$pref.$cuerpo.".".$foo->file_src_name_ext;
                $tabla = 'tblEmpresa';
                $form_data = array(
                    'nombre' => $nombre,
                    'propietario' => $propietario,
                    'id_municipio_EMP' => $municipio,
                    'nit' => $nit,
                    'direccion' => $direccion,
                    'telefono1' => $telefono1,
                    'telefono2' => $telefono2,
                    'email' => $email,
                    'website' => $web,
                    'moneda' => $moneda,
                    'simbolo' => $simbolo,
                    'logo' => $url
                    );  
                $where_clause = " id_empresa=$id_sucursal";
                $editar =_update($tabla, $form_data, $where_clause);
                if($editar)
                {
                _updated_at($tabla, $where_clause);
                $xdatos['typeinfo']='Success';
                $xdatos['msg']='Datos de empresa editados correctamente!';
                $xdatos['process']='edit';
                }
                else
                {
                $xdatos['typeinfo']='Error';
                $xdatos['msg']='Datos de empresa no pudieron ser editados!';
                }    
            }
            else
            {
                $xdatos['typeinfo']='Error';
                $xdatos['msg']='Error al guardar la imagen!'; 
            }
        }
        else
        {
            $xdatos['typeinfo']='Error';
            $xdatos['msg']='Error al subir la imagen!';
        }
    }
    else
    {
        $nombre = $_POST["nombre"];
        $propietario = $_POST["propietario"];
        $telefono1=$_POST["telefono1"];
        $telefono2=$_POST["telefono2"];
        $email=$_POST["email"];
        $web=$_POST["web"];
        $nit=$_POST["nit"];
        $municipio=$_POST["municipio"];
        $direccion=$_POST["direccion"];
        $moneda=$_POST["moneda"];
        $simbolo=$_POST["simbolo"];
        
        $tabla = 'tblEmpresa';
        
        $form_data = array(
            'nombre' => $nombre,
            'propietario' => $propietario,
            'id_municipio_EMP' => $municipio,
            'nit' => $nit,
            'direccion' => $direccion,
            'telefono1' => $telefono1,
            'telefono2' => $telefono2,
            'email' => $email,
            'website' => $web,
            'moneda' => $moneda,
            'simbolo' => $simbolo,
            );  
        $where_clause = " id_empresa=$id_sucursal";
        $editar =_update($tabla, $form_data, $where_clause);
        if($editar)
        {
            _updated_at($tabla, $where_clause);
           $xdatos['typeinfo']='Success';
           $xdatos['msg']='Datos de empresa editados correctamente !';
           $xdatos['process']='edit';
        }
        else
        {
           $xdatos['typeinfo']='Error';
           $xdatos['msg']='Datos de empresa no pudieron ser editados!';
        }    
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
            case 'edit':
                editar();
                break;
        } 
    }     
}
?>