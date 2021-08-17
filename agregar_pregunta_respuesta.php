<?php
include ("_core.php");
function initial()
{
	//permiso del script
	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];
	$uri = $_SERVER['SCRIPT_NAME'];
	$filename="agregar_evaluacion.php";
	$links=permission_usr($id_user,$filename);
    $id_pregunta = -1;
    if(isset($_REQUEST['id_pregunta'])){
        $id_pregunta = $_REQUEST['id_pregunta'];
        $sql_pregunta = "SELECT * FROM tblpregunta_evaluacion WHERE id_pregunta_evaluacion = '$id_pregunta'";
        $query_pregunta = _query($sql_pregunta);
        $row_pregunta = _fetch_array($query_pregunta);
        $descripcion_p = $row_pregunta['descripcion'];
    }
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Agregar Pregunta / Respuestas</h4>
</div>
<style type="text/css">
.datepicker table tr td,
.datepicker table tr th {
    border: none;
    background: white;
}
</style>
<div class="modal-body">
    <div class="wrapper wrapper-content  animated fadeInRight">
        <div class="row" id="row1">
            <?php
				//permiso del script
				if ($links!='NOT' || $admin=='1' ){
			?>
            <div class="col-lg-12">
                <h3 style="color:#194160;"> <b>Pregunta: <span style="color:red;">*</span></b></h3>
                <textarea name="descripcion_pregunta" id="descripcion_pregunta" cols="10"
                    style="width: 100%;"><?php if(isset($_REQUEST['id_pregunta'])){ echo $descripcion_p;} ?></textarea>
            </div>
            <div class="col-lg-12">
                
            </div>
            <div class="col-lg-12"  id="tabla_pre_res" style="margin-top: 20px;">
            <button type="button" class="btn btn-primary" id="btn_agregar_res" style="float: right;margin-bottom: 20px;">Agregar Respuesta</button>
                <table class="table"  >
                    <thead class="thead-dark" style="background:#D3F29E;">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Respuesta</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Accion</th>
                        </tr>
                    </thead>
                    <tbody id="respuestas_pre">
                        
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <input type="hidden" name="id_pregunta" id="id_pregunta" value="<?php echo $id_pregunta; ?>">
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btn_add_pregunta">Guardar</button>
        <button type="button" class="btn btn-default" id="btn_cerrar_fc" data-dismiss="modal">Cerrar</button>
    </div>
    <script type="text/javascript">
    $(document).ready(function() {
        let id_pregunta = $("#id_pregunta").val();
        if(id_pregunta == "-1"){
            $("#tabla_pre_res").hide();
        }
        else{
            $(".respu").remove();
            $.ajax({
                type: 'POST',
                url: "agregar_pregunta_respuesta.php",
                data: {
                    process: 'actualizar_tabla',
                    id_pregunta: id_pregunta,
                },
                dataType: 'json',
                async: false,
                success: function(datos) {
                    $.each(datos, function(key, value) {
                        var arr = Object.keys(value).map(function(k) { return value[k] });
                        var fila = arr[0];
                        $("#respuestas_pre").append(fila);
                        $(".select").select2();
                    });
                }
            });
        }
        
    });
    $("#btn_agregar_res").click(function(){
        let id_pregunta = $("#id_pregunta").val();
        $.ajax({
                type: 'POST',
                url: "agregar_pregunta_respuesta.php",
                data: {
                    process: 'insertar_nueva_respuesta',
                    id_pregunta: id_pregunta,
                },
                dataType: 'json',
                async: false,
                success: function(datos) {
                    $(".respu").remove();
                    $.ajax({
                        type: 'POST',
                        url: "agregar_pregunta_respuesta.php",
                        data: {
                            process: 'actualizar_tabla',
                            id_pregunta: id_pregunta,
                        },
                        dataType: 'json',
                        async: false,
                        success: function(datos) {
                            $.each(datos, function(key, value) {
                                var arr = Object.keys(value).map(function(k) { return value[k] });
                                var fila = arr[0];
                                $("#respuestas_pre").append(fila);
                                $(".select").select2();
                            });
                        }
                    });
                }
            });
    });


    //FUNCION PARA ELIMINAR RESPUESTAS

    /* ESTA FUNCION SIRVE PARA ELIMINAR PREGUNTAS */
    $(document).on("click", ".eliminar_respuesta", function() {
        var id = $(this).attr("id");
        var id_pregunta = $("#id_pregunta").val();
        swal({
                title: "Esta a punto de eliminar una respuesta",
                text: "Esta seguro de hacerlo?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Si, anular",
                cancelButtonText: "No, cancelar!",
                closeOnConfirm: true,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    var dataString = "process=eliminar_respuesta&id_respuesta=" + id;
                    $.ajax({
                        type: 'POST',
                        url: "agregar_pregunta_respuesta.php",
                        data: dataString,
                        dataType: 'json',
                        async: false,
                        success: function(datax) {
                            //display_notify(datax.typeinfo, datax.msg);
                            if (datax.typeinfo == "Success") {
                                $(".respu").remove();
                            $.ajax({
                                type: 'POST',
                                url: "agregar_pregunta_respuesta.php",
                                data: {
                                    process: 'actualizar_tabla',
                                    id_pregunta: id_pregunta,
                                },
                                dataType: 'json',
                                async: false,
                                success: function(datos) {
                                    $.each(datos, function(key, value) {
                                        var arr = Object.keys(value).map(function(k) { return value[k] });
                                        var fila = arr[0];
                                        $("#respuestas_pre").append(fila);
                                        $(".select").select2();
                                    });
                                }
                            });
                            }
                        }
                    });
                } else {
                    swal("Cancelado", "Operación cancelada", "error");
                    correcto++;
                }
            });
    });
    function update_table(){
        
    }
    </script>
    <!--/modal-footer -->
    <?php
} //permiso del script
else {
		echo "<div></div><br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div>";
	}
}
function insertar_pregunta()
{
    _begin();
    $id_pregunta = $_POST['id_pregunta'];
    $descripcion_pregunta = $_POST['descripcion_pregunta'];
    $id_evaluacion = $_POST['id_evaluacion'];
    $table = 'tblpregunta_evaluacion';
    $form_data = array(
        'id_evaluacion' => $id_evaluacion,
        'descripcion' => $descripcion_pregunta,
    );
    if($id_pregunta == "-1"){
        $insert = _insert($table, $form_data);
        $id_pregunta = _insert_id();
        $table_respuesta1 = 'tblrespuesta_evaluacion';
        $array_respuesta1 = array(
            'id_pregunta' => $id_pregunta,
            'descripcion' => "Verdadero",
            'correcta' => 1
        );
        $insert_respuesta1 = _insert($table_respuesta1, $array_respuesta1);
        $id_respuesta1 = _insert_id();
        $table_respuesta2 = 'tblrespuesta_evaluacion';
        $array_respuesta2 = array(
            'id_pregunta' => $id_pregunta,
            'descripcion' => "Falso",
            'correcta' => 0
        );
        $insert_respuesta2 = _insert($table_respuesta2, $array_respuesta2);
        $id_respuesta2 = _insert_id();
        
        $xdatos['id_respuesta1'] = $id_respuesta1;
        $xdatos['id_respuesta2'] = $id_respuesta2;
        if(!$insert_respuesta1 || !$insert_respuesta2){
            _rollback();
        }
    }
    else{
        $where = " id_pregunta_evaluacion = '$id_pregunta'";
        $insert = _update($table, $form_data, $where);
    }
    if($insert){
        $xdatos['typeinfo'] = "Success";
        $xdatos['msg'] = "Registro Insertado con Exito!!";
        $xdatos['id_pregunta'] = $id_pregunta;
        _commit();
    }
    else{
        $xdatos['typeinfo'] = "Error";
        $xdatos['msg'] = "Registro no pudo ser insertado!!";
        $xdatos['id_pregunta'] = $id_pregunta;
        _rollback();
    }
	echo json_encode ($xdatos);
}
function actualizar_tabla(){
    $id_pregunta = $_POST['id_pregunta'];
    $sql_respuestas = "SELECT * FROM tblrespuesta_evaluacion WHERE id_pregunta = '$id_pregunta' AND deleted is NULL";
    $query_respuestas = _query($sql_respuestas);
    $array_respuestas = array();
    if(_num_rows($query_respuestas) > 0){
        $numero = 1;
        while($row = _fetch_array($query_respuestas)){
            $id_respuesta = $row['id_respuesta'];
            $descripcion = $row['descripcion'];
            $correcta = $row['correcta'];
            $eliminar2 = "<a class='btn eliminar_respuesta' id='".$id_respuesta."'><i class='fa fa-trash'></i></a>";
            if($correcta == 0){
                $select2 = "<select class=\" select\" id=\"tipo\" name=\"tipo\">";
                $select2.= "<option value = '1'>Correcto</option>";
                $select2.="<option value = '0' selected>Incorrecto</option>";
                $select2.= "</select>";
            }
            elseif($correcta == 1){
                $select2 = "<select class=\" select\" id=\"tipo\" name=\"tipo\">";
                $select2.= "<option value = '1' selected>Correcto</option>";
                $select2.="<option value = '0'>Incorrecto</option>";
                $select2.= "</select>";
            }
            $tabla_respuesta = "<tr class='respu' id='".$id_respuesta."'>";
            $tabla_respuesta.= "<td class='numero'> ".$numero."</td>";
            $tabla_respuesta.= "<td class='existe' hidden>1</td>";
            $tabla_respuesta.= "<td class='id_respuesta' hidden>".$id_respuesta."</td>";
            $tabla_respuesta.= "<td class='tex comentario'> ".$descripcion."</td>";
            $tabla_respuesta.= "<td class='vedadero_falso'> ".$select2."</td>";
            $tabla_respuesta.= "<td> ".$eliminar2."</td>";
            $tabla_respuesta.= "</tr>";
            $array_respuestas[] = array(
                'fila' => $tabla_respuesta
            );
        }
    }
    echo json_encode($array_respuestas);
}

function insertar_nueva_respuesta(){
    $id_pregunta = $_POST['id_pregunta'];
    $tabla = 'tblrespuesta_evaluacion';
    $form_data = array(
        'id_pregunta' => $id_pregunta,
        'descripcion' => "Pregunta",
        'correcta' => 0
    );
    $insertar = _insert($tabla,$form_data);
    if($insertar){
        $id_respuesta = _insert_id();
        $xdatos['typeinfo'] = "Success";
        $xdatos['msg'] ="Respuesta Agregada con Exito!!";
    }
    else{
        $xdatos['typeinfo'] = "Error";
        $xdatos['msg'] ="Respuesta no pudo ser Agregada!!";
    }
    echo json_encode($xdatos);
}

function actualizar_respuestas(){
    $array_json=$_POST['json_arr'];
    $array = json_decode($array_json, true);
    _begin();
    $error = 0;
    foreach ($array as $key => $fila){
        $id_respuesta=$fila['id'];
        $descripcion=$fila['descripcion'];
        $tipo=$fila['tipo'];
        if($tipo == "Correcto"){
            $tipo = 1;
        }
        elseif($tipo == "Incorrecto"){
            $tipo = 0;
        }
        $tabla_insertar = 'tblrespuesta_evaluacion';
        $array_insertar = array(
            'descripcion' => $descripcion,
            'correcta' => $tipo
        );
        $where = " id_respuesta = '$id_respuesta'";
        $insertar = _update($tabla_insertar, $array_insertar,$where);
        if(!$insertar){
            $error++;
        }
    }
    if($error == 0){
        $xdatos['typeinfo'] ="Success";
        $xdatos['msg'] = "Pregunta y Respuestas Actualizadas Correctamente!!";
        _commit();
    }
    else{
        $xdatos['typeinfo'] ="Error";
        $xdatos['msg'] = "No se pudieron actualizar correctamente los registros!!";
        
        _rollback();
    }
    echo json_encode($xdatos);
}

function eliminar_respuesta(){
    $id_respuesta = $_POST['id_respuesta'];
    $table = 'tblrespuesta_evaluacion';
    $where = " WHERE id_respuesta = '$id_respuesta'";
    $delete = _delete_total($table, $where);
    if($delete){
        $xdatos['typeinfo'] ="Success";
        $xdatos['msg'] = "Respuesta Eliminada con Exito!!";
    }
    else{
        $xdatos['typeinfo'] ="Error";
        $xdatos['msg'] = "No se pudo eliminar la respuesta!!";
    }
    echo json_encode($xdatos);
}

if (! isset ( $_REQUEST ['process'] ))
{
	initial();
} else {
	if (isset ( $_REQUEST ['process'] ))
	{
		switch ($_REQUEST ['process'])
		{
			case 'formDelete' :
				initial();
				break;
			case 'insertar_pregunta' :
				insertar_pregunta();
				break;
            case 'actualizar_tabla':
                actualizar_tabla();
                break;
            case 'insertar_nueva_respuesta':
                insertar_nueva_respuesta();
                break;
            case 'actualizar_respuestas':
                actualizar_respuestas();
                break;
            case 'eliminar_respuesta':
                eliminar_respuesta();
                break;
		}
	}
}

?>