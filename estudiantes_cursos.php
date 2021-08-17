<?php
    include("_core.php");
    include('num2letras.php');
?>
<?php
    function initial(){
        $title="Asignacion de estudiantes al curso";
        $_PAGE = array();
        $_PAGE ['title'] = $title;
        $_PAGE ['links'] = null;
        $_PAGE ['links'] .= '<link href="css/bootstrap.min.css" rel="stylesheet">';
        $_PAGE ['links'] .= '<link href="font-awesome/css/font-awesome.css" rel="stylesheet">';
        $_PAGE ['links'] .= '<link href="css/plugins/iCheck/custom.css" rel="stylesheet">';
        $_PAGE ['links'] .= '<link href="css/plugins/select2/select2.css" rel="stylesheet">';
        $_PAGE ['links'] .= '<link href="css/plugins/select2/select2-bootstrap.css" rel="stylesheet">';
        $_PAGE ['links'] .= '<link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">';
        $_PAGE ['links'] .= '<link href="css/plugins/sweetalert/sweetalert.css" rel="stylesheet">';
        $_PAGE ['links'] .= '<link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">';
        $_PAGE ['links'] .= '<link href="css/plugins/datetime/bootstrap-datetimepicker.min.css" rel="stylesheet">';
        $_PAGE ['links'] .= '<link href="css/plugins/datetime/bootstrap-datetimepicker.css" rel="stylesheet">';
        $_PAGE ['links'] .= '<link href="css/animate.css" rel="stylesheet">';
        $_PAGE ['links'] .= '<link href="css/plugins/bootstrap-checkbox/bootstrap-checkbox.css" rel="stylesheet">';
        $_PAGE ['links'] .= '<link href="css/style.css" rel="stylesheet">';
        $_PAGE ['links'] .= '<link href="css/plugins/timepicker/jquery.timepicker.css" rel="stylesheet">';
        $_PAGE ['links'] .= '<link rel="stylesheet" type="text/css" href="css/plugins/perfect-scrollbar/perfect-scrollbar.css">';
        $_PAGE ['links'] .= '<link rel="stylesheet" type="text/css" href="css/util.css">';
        $_PAGE ['links'] .= '<link rel="stylesheet" type="text/css" href="css/main.css">';
        $_PAGE ['links'] .= '<link href="css/plugins/timepicki/timepicki.css" rel="stylesheet">';

        include_once "header.php";
        include_once "main_menu.php";
        $hoy=date('d-m-Y');

        //permiso del script
        $id_user=$_SESSION["id_usuario"];
        $admin=$_SESSION["admin"];
        $uri = $_SERVER['SCRIPT_NAME'];
        $filename=get_name_script($uri);
        $links=permission_usr($id_user,$filename);
        $id_curso= $_REQUEST['id_curso'];
        $id_sucursal = $_SESSION['id_sucursal'];

        $sql_curso = "SELECT tblcurso.nombre as 'nombre_curso', tblmateria.nombre as 'nombre_materia', tbldocente.nombres, tbldocente.apellidos FROM tblcurso INNER JOIN tbldocente on tbldocente.id_docente = tblcurso.id_docente INNER JOIN tblmateria on tblmateria.id_materia = tblcurso.id_materia WHERE id_curso = '$id_curso'";
        $query_curso = _query($sql_curso);
        $row_curso = _fetch_array($query_curso);
        $nombre_curso = $row_curso['nombre_curso'];
        $nombre_materia = $row_curso['nombre_materia'];
        $nombre_docente = $row_curso['nombres']." ".$row_curso['apellidos'];
        ?>
<style type="text/css">
.datepicker table tr td,
.datepicker table tr th {
    border: none;
    background: white;
}
</style>
<div class="gray-bg">
    <div class="wrapper wrapper-content  animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <?php
                              //permiso del script
                                  if ($links!='NOT' || $admin=='1') {
                              ?>
                    <div class="ibox-content">
                        <div class="row focuss"><br>
                            <div class="form-group col-md-6">
                                <label>Curso:</label>
                                <input type="text" id="paciente" name="paciente"
                                    value='<?php echo $nombre_curso; ?>'
                                    class="form-control usage" hidden readonly autocomplete="off">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Materia:</label>
                                <input type="text" id="doctor" name="doctor" class="form-control usage"
                                    value='<?php echo $nombre_materia; ?>'
                                     readonly autocomplete="off">
                            </div>
                            <div class="form-group col-md-12">
                                <label>Profesor:</label>
                                <input type="text" id="doctor" name="doctor" class="form-control usage"
                                    value='<?php echo $nombre_docente; ?>'
                                     readonly autocomplete="off">
                            </div>

                            <div class="form-group col-md-12">
                                <label id='buscar_habilitado'>Buscar Estudiante</label>
                                <input type="text" id="estudiante_buscar" name="estudiante_buscar"
                                    class="form-control usage" placeholder="Ingrese Descripcion del Estudiante"
                                    data-provide="typeahead" style="border-radius:0px">

                            </div>
                        </div>
                        <div class="row">

                        </div>
                        <div class="row focuss">
                            <div class="title-action col-md-6" id='botones'
                                style="margin-top:-10px;text-align: center;">

                                <a class="btn btn-danger " style="margin-left:3%;" href="admin_curso.php"
                                    id='salir'><i class="fa fa-mail-reply"></i> F4 Salir</a>
                                <button type="button" id="submit1" name="submit1" class="btn btn-primary usage"><i
                                        class="fa fa-check"></i> F2 Guardar</button>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <section>
                                    <div class="">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="wrap-table1001">
                                                    <div class="table100 ver1 m-b-10">
                                                        <div class="table100-head">
                                                            <table id="inventable1">
                                                                <thead>
                                                                    <tr class="row100 head">
                                                                        <th class="success cell100 column100">CODIGO</th>
                                                                        <th class='success  cell100 column35'>ESTUDIANTE</th>
                                                                        <th class='success  cell100 column35'>FECHA DE INSCRIPCION</th>
                                                                        <th class='success  cell100 column100'>ACCI&Oacute;N</th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                        <div class="table100-body js-pscroll">
                                                            <table>
                                                                <tbody id="inventable"></tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--valores ocultos para referencia -->
                                        <input type='hidden' name='id_curso' id='id_curso' value="<?php echo $id_curso; ?>">
                                        
                                    </div>
                                    <!--div class="table-responsive m-t"-->
                                </section>
                            </div>
                        </div>
                        
                    </div>
                    <!--<div class='ibox float-e-margins' -->
                </div>
            </div>
            <!--div class='col-lg-12'-->
            <!--div class='row'-->
            <!--div class='wrapper wrapper-content  animated fadeInRight'-->

            <?php

                  include_once("footer.php");

                  echo "<script src='js/funciones/funciones_estudiantes_cursos.js'></script>";
                  echo "<script src='js/plugins/arrowtable/arrow-table.js'></script>";
                  echo "<script src='js/plugins/bootstrap-checkbox/bootstrap-checkbox.js'></script>";
                  echo "<script src='js/plugins/datetime/bootstrap-datetimepicker.js'></script>";
                  echo '<script src="js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
                  <script src="js/funciones/main.js"></script>';
                  echo "<script src='js/funciones/util.js'></script>";
                } //permiso del script
                else {
                  echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div></div></div></div></div>";
                  include_once("footer.php");
                }
      ?>
            <?php
    }
?>
<?php


function consultar_existencia(){
    $id_estudiante = $_POST['id_estudiante'];
    $id_curso = $_POST['id_curso'];
    $sql_existencia = "SELECT * FROM tblestudiante_curso WHERE id_estudiante = '$id_estudiante' AND id_curso = '$id_curso' AND deleted is NULL";
    $query_existencia = _query($sql_existencia);
    if(_num_rows($query_existencia) > 0){
        $xdatos['typeinfo'] = "Error";
        $xdatos['msg'] = "El estudiante ya esta agregado al curso!";
    }
    else{
        $xdatos['typeinfo'] = "Success";
    }
    echo json_encode($xdatos);
}

?>

<?php
    function traer_estudiantes(){
        $id_curso = $_POST['id_curso'];
        $sql_estudiante_curso = "SELECT * FROM tblestudiante INNER JOIN tblestudiante_curso ON tblestudiante.id_estudiante = tblestudiante_curso.id_estudiante WHERE tblestudiante_curso.deleted is NULL AND tblestudiante.deleted is NULL AND tblestudiante_curso.id_curso = '$id_curso'";
        $query_estudiante_curso = _query($sql_estudiante_curso);
        $array_estudiante = array();
        if(_num_rows($query_estudiante_curso) > 0){
            while($row = _fetch_array($query_estudiante_curso)){
                $nombre_estudiante = $row['nombres']." ".$row['apellidos'];
                $codigo = $row['codigo'];
                $id_estudiante = $row['id_estudiante'];
                $fecha_inscripcion = $row['fecha_de_inscripcion'];
                $array_estudiante[] = array(
                    'id_estudiante' => $id_estudiante,
                    'nombre_estudiante' => $nombre_estudiante,
                    'codigo' =>   $codigo,
                    'fecha_inscripcion' =>  $fecha_inscripcion
                );
            }
        }
        echo json_encode($array_estudiante);
    }
?>

<?php 
    function insertar(){
        $id_curso = $_POST['id_curso'];
        $array_json=$_POST['json_arr'];
        $array = json_decode($array_json, true);
        _begin();
        $table_delete = 'tblestudiante_curso';
        $where_delete = " id_curso = '$id_curso'";
        $delete_total = _delete_total($table_delete,$where_delete);
        $error = 0;
        foreach ($array as $key => $fila){
            $id_estudiante=$fila['id'];
            $tabla_insertar = 'tblestudiante_curso';
            $array_insertar = array(
                'id_estudiante' => $id_estudiante,
                'id_curso' => $id_curso
            );
            $insertar = _insert($tabla_insertar, $array_insertar);
            if(!$insertar){
                $error++;
            }
        }
        if($delete_total && $error == 0){
            $xdatos['typeinfo'] ="Success";
            $xdatos['msg'] ="Estudiantes del curso actualizados correctamente!";
            _commit();
        }
        else{
            $xdatos['typeinfo'] ="Error";
            $xdatos['msg'] ="No se pudieron actualizar los estudiantes del curso!";
            _rollback();
        }
        echo json_encode($xdatos);
    }
?>

<?php
if (!isset($_REQUEST['process']))
{
  initial();
}
if (isset($_REQUEST['process']))
{
    switch ($_REQUEST['process'])
    {
        case 'consultar_existencia':
            consultar_existencia();
            break;
        case 'traer_estudiantes':
            traer_estudiantes();
            break;
        case 'insert':
            insertar();
            break;
    }
}
?>