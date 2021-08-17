<?php
include ("_core.php");
function initial(){
	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];
	$uri = $_SERVER['SCRIPT_NAME'];
	$filename=get_name_script($uri);
	$links=permission_usr($id_user,$filename);
    $id_evaluacion = $_REQUEST['id_evaluacion'];
    $sql_nota_maxima = "SELECT * FROM tblevaluacion WHERE id_evaluacion = '$id_evaluacion'";
    $query_nota_maxima = _query($sql_nota_maxima);
    $row_nota_maxima = _fetch_array($query_nota_maxima);
    $nombre_evaluacion = $row_nota_maxima['nombre'];
    $descripcion_evaluacion = $row_nota_maxima['descripcion'];
    $nota_maxima_imprimir = number_format($row_nota_maxima['nota_maxima'],2);
    $nota_maxima = $row_nota_maxima['nota_maxima'];
    $nota_minima = number_format($row_nota_maxima['nota_minima'],2);
    $fecha_inicio = ED($row_nota_maxima['fecha_inicio']);
    $hora_inicio = _hora_media_decode($row_nota_maxima['hora_inicio']);
    $fecha_fin = ED($row_nota_maxima['fecha_fin']);
    $hora_fin = _hora_media_decode($row_nota_maxima['hora_fin']);
    $tiempo_estimado = number_format($row_nota_maxima['tiempo_estimado'],2,":");

    $sql_preguntas = "SELECT * FROM tblpregunta_evaluacion WHERE id_evaluacion = '$id_evaluacion' AND deleted is NULL";
    //echo $sql_preguntas;
    $query_preguntas = _query($sql_preguntas);
    $numero = 1;
    if(_num_rows($query_preguntas) > 0){
        $tabla_devolver="";
        while($row_preguntas = _fetch_array($query_preguntas)){
            $id_pregunta = $row_preguntas['id_pregunta_evaluacion'];
            $descripcion = $row_preguntas['descripcion'];
            $tabla_devolver .= "<tr class='pregu' id='".$id_pregunta."'>";
            $sql_respuestas = "SELECT * FROM tblrespuesta_evaluacion WHERE id_pregunta = '$id_pregunta' AND deleted is NULL";
            $query_respuestas = _query($sql_respuestas);
            $numero_espacios = _num_rows($query_respuestas);
            $numero_espacios+=1;
            $tabla_devolver.="<td rowspan=".$numero_espacios.">$numero</td>";
            $tabla_devolver.="<td rowspan=".$numero_espacios.">$descripcion</td>";
            if( $numero> 0){
                $contador_x =0;
                while($row_respuestas = _fetch_array($query_respuestas)){
                    $id_respuesta = $row_respuestas['id_respuesta'];
                    $descripcion_respuesta  = $row_respuestas['descripcion'];
                    $porcentaje_x = $row_respuestas['porcentaje'];
                    $per = (($porcentaje_x/$nota_maxima)*100);
                    $correcta = $row_respuestas['correcta'];
                    if($correcta == 1){
                        $correcta = "Correcta";
                        $porcentaje = "<td id='porcentaje_p' style='background:#9EF2BA; border:1px solid black;'>$porcentaje_x  ($per%)</td>";
                        $tabla_devolver.="<tr>";
                        $tabla_devolver.="<td style='background:#9EF2BA; border:1px solid black;'>$descripcion_respuesta</td>";
                        $tabla_devolver.="<td style='background:#9EF2BA; border:1px solid black;'>$correcta</td>";
                        $tabla_devolver.=$porcentaje;
                        $tabla_devolver.="</tr>";
                    }
                    elseif($correcta == 0){
                        $correcta = "Incorrecta";
                        $porcentaje = "<td id='porcentaje_p' style='background:#F29E9E; border:1px solid black;' >$porcentaje_x</td>";
                        $tabla_devolver.="<tr>";
                        $tabla_devolver.="<td style='background:#F29E9E; border:1px solid black;'>$descripcion_respuesta</td>";
                        $tabla_devolver.="<td style='background:#F29E9E; border:1px solid black;'>$correcta</td>";
                        $tabla_devolver.=$porcentaje;
                        $tabla_devolver.="</tr>";
                    }
                    
                    $contador_x++;
                }
            }
            $tabla_devolver.="</tr>";
            $numero++;
        }
    }
		
?>
<div class="modal-header">
	
	<button type="button" class="close" data-dismiss="modal"
		aria-hidden="true">&times;</button>
	<h4 class="modal-title">Borrar Estudiante</h4>
</div>
<div class="modal-body">
	<div class="wrapper wrapper-content  animated fadeInRight">
    <div class="row" id="row1">
            <?php
				//permiso del script
				if ($links!='NOT' || $admin=='1' ){
			?>
            <div class="col-lg-12">
                <h3 style="color:#194160;"> <b>Nombre de la evaluacion : <?php echo $nombre_evaluacion;?></b></h3>
            </div>
            <div class="col-lg-12">
                <h3 style="color:#194160;"> <b>Descripcion : <?php echo $descripcion_evaluacion;?></b></h3>
            </div>
            <div class="col-lg-3">
                <h3 style="color:#194160;"> <b>Nota Maxima : <?php echo $nota_maxima_imprimir;?></b></h3>
            </div>
            <div class="col-lg-3">
                <h3 style="color:#194160;"> <b>Nota Minima : <?php echo $nota_minima;?></b></h3>
            </div>
            
            <div class="col-lg-6">
                <h3 style="color:#194160;"> <b>Tiempo estimado : <?php echo $tiempo_estimado." Minutos";?></b></h3>
            </div>
            <div class="col-lg-6">
                <h3 style="color:#194160;"> <b>Fecha Inicio : <?php echo $fecha_inicio." ".$hora_inicio;?></b></h3>
            </div>
            <div class="col-lg-6">
                <h3 style="color:#194160;"> <b>Fecha Fin : <?php echo $fecha_fin." ".$hora_fin;?></b></h3>
            </div>
            <div class="col-lg-12"  id="tabla_pre_res" style="margin-top: 20px;">
                <table class="table">
                    <thead class="thead-dark" style="background:#D3F29E;">
                        <tr>
                            <th scope="col-md-1">#</th>
                            <th scope="col-md-3">Pregunta</th>
                            <th scope="col-md-3">Respuestas</th>
                            <th scope="col-md-3">Tipo</th>
                            <th scope="col-md-2">Accion</th>
                        </tr>
                    </thead>
                    <tbody id="preguntas_respuestas">
                        <?php echo $tabla_devolver;  ?>
                    </tbody>
                </table>
            </div>

        </div>
		</div>
			<?php 
			echo "<input type='hidden' nombre='id_evaluacion' id='id_evaluacion' value='$id_evaluacion'>";
			?>
		</div>

</div>
<div class="modal-footer">
	<button type="button" class="btn btn-primary" id="btnDelete">Eliminar</button>
	<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

</div>
<!--/modal-footer -->

<?php
} //permiso del script
else{
		echo "<div></div><br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div>";
	}
}
function deleted() 
{
	$id_evaluacion = $_POST ['id_evaluacion'];
	$table = 'tblevaluacion';
	$where_clause = "id_evaluacion='" . $id_evaluacion . "'";
    _begin();
    $error = 0;
	$delete = _delete ( $table, $where_clause );
	if ($delete) {
        $sql_preguntas = "SELECT * FROM tblpregunta_evaluacion WHERE id_evaluacion = '$id_evaluacion'";
        $query_preguntas = _query($sql_preguntas);
        if(_num_rows($query_preguntas) > 0){
            while($row_preguntas = _fetch_array($query_preguntas)){
                $id_pregunta = $row_preguntas['id_pregunta_evaluacion'];
                $table2 = 'tblpregunta_evaluacion';
                $where2 = "  WHERE id_pregunta_evaluacion = '$id_pregunta'";

                $table3 = 'tblrespuesta_evaluacion';
                $where3 = " WHERE id_pregunta = '$id_pregunta'";

                $eliminar2 = _delete_total($table2,$where2);
                $eliminar3 = _delete_total($table3,$where3);
                if(!$eliminar2 || !$eliminar3){
                    $error++;
                }
            }
        }
	} else {
		$error++;
	}
    if($error == 0){
        $xdatos['typeinfo'] = "Success";
        $xdatos['msg'] = "Evaluacion Eliminada con Exito!!";
        _commit();
    }
    else{
        $xdatos['typeinfo'] = "Error";
        $xdatos['msg'] = "La Evaluacion no pudo ser Eliminada!!";
        _commit();
    }
	echo json_encode ($xdatos);
}
if (! isset ( $_REQUEST ['process'] ))
{
	initial();
} else
{
	if (isset ( $_REQUEST ['process'] ))
	{
		switch ($_REQUEST ['process'])
		{
			case 'formDelete' :
				initial();
				break;
			case 'deleted' :
				deleted();
				break;
		}
	}
}

?>
