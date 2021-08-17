<?php
include ("_core.php");
function initial()
{
	//permiso del script
	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];
	$uri = $_SERVER['SCRIPT_NAME'];
	$filename=get_name_script($uri);
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
    <h4 class="modal-title">Descripcion Pregunta</h4>
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
                <h2><?php echo $descripcion_p ?></h2>
                
            </div>
            <div class="col-lg-12">
                
            </div>
            <div class="col-lg-12"  id="tabla_pre_res" style="margin-top: 20px;">
                <table class="table"  >
                    <thead class="thead-dark" style="background:#D3F29E;">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Respuesta</th>
                            <th scope="col">Tipo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql_respuestas = "SELECT * FROM tblrespuesta_evaluacion WHERE id_pregunta = '$id_pregunta' AND deleted is NULL";
                            $query_respuestas = _query($sql_respuestas);
                            if(_num_rows($query_pregunta) > 0){
                                $numero = 1;
                                while($row_res = _fetch_array($query_respuestas)){
                                    $desc_res = $row_res['descripcion'];
                                    $correcta = $row_res['correcta'];
                                    if($correcta == 1){
                                        $correcta = "Correcta";
                                    }
                                    elseif($correcta == 0){
                                        $correcta = "Incorrecta";
                                    }
                                    ?>
                                        <tr>
                                            <td><?php echo $numero; ?></td>
                                            <td><?php echo $desc_res; ?></td>
                                            <td><?php echo $correcta; ?></td>
                                        </tr>
                                    <?php
                                    $numero++;
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <input type="hidden" name="id_pregunta" id="id_pregunta" value="<?php echo $id_pregunta; ?>">
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    </div>
    
    <!--/modal-footer -->
    <?php
} //permiso del script
else {
		echo "<div></div><br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div>";
	}

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
			
		}
	}
}

?>