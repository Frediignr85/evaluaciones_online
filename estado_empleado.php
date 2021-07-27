<?php
include ("_core.php");
function initial(){
	$estado=0;
	$id_empleado = $_REQUEST ['id_empleado'];
	$estadoS = $_REQUEST ['estado'];
	$id_sucursal= $_SESSION['id_sucursal'];
	if($estadoS=="1"){
		$estadoEMP = "Activar";
		$estado=1;
	}else{
		$estadoEMP = "Desactivar";
		$estado=2;
	}
	$sql="SELECT *FROM tblEmpleado WHERE id_empleado='$id_empleado' and id_sucursal_EMP='$id_sucursal'";
	$result = _query( $sql );
	$count = _num_rows( $result );
    //permiso del script
	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];
	$filename = "estado_empleado.php";
	$links=permission_usr($id_user,$filename);

?>
<div class="modal-header">

	<button type="button" class="close" data-dismiss="modal"
		aria-hidden="true">&times;</button>
	<h4 class="modal-title"> <?php echo $estadoEMP;?> Empleado</h4>
</div>
<div class="modal-body">
	<div class="wrapper wrapper-content  animated fadeInRight">
		<div class="row" id="row1">
			<?php
				//permiso del script
				if ($links!='NOT' || $admin=='1' ){
			?>
			<div class="col-lg-12">
				<table class="table table-bordered table-striped" id="tableview">
					<thead>
						<tr>
							<th>CAMPO</th>
							<th>NOMBRE</th>
						</tr>
					</thead>
					<tbody>
							<?php
								if ($count > 0) {
									for($i = 0; $i < $count; $i ++) {
										$row = _fetch_array ( $result, $i );
										echo "<tr><td>ID EMPLEADO</th><td>$id_empleado</td></tr>";
										echo "<tr><td>NOMBRE</td><td>".$row['nombre']."</td>";
										echo "</tr>";

									}
								}
							?>
						</tbody>
				</table>
			</div>
		</div>
			<?php
			echo "<input type='hidden' nombre='id_empleado' id='id_empleado' value='$id_empleado'>";
			echo "<input type='hidden' nombre='estado' id='estado' value='$estado'>";
			?>
		</div>

</div>
<div class="modal-footer">
	<button type="button" class="btn btn-primary" id="anular"><?php echo $estadoEMP;?></button>
	<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

</div>
<!--/modal-footer -->

<?php
} //permiso del script
else{
		echo "<div></div><br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div>";
	}
}
function estado()
{
	$id_sucursal= $_SESSION['id_sucursal'];
  	$estado = $_POST['estado'];
	$id_empleado = $_POST['id_empleado'];
	$table = 'tblEmpleado';
	$form_data = array(
		'id_estado_EMP' => $estado
	);
	$where_clause = " id_empleado ='".$id_empleado."'";
	if($estado!=1){
		$insertar = _update($table,$form_data, $where_clause);
		if($insertar)
		{
			 $xdatos['typeinfo']='Success';
			 $xdatos['msg']='Empleado desactivado correctamente!';
			 $xdatos['process']='insert';
		}
		else
		{
			 $xdatos['typeinfo']='Error';
			 $xdatos['msg']='Empleado no pudo ser desactivado!';
		}
	}
	else
	{
		$insertar = _update($table,$form_data, $where_clause);
		if($insertar)
		{
			$xdatos['typeinfo']='Success';
			$xdatos['msg']='Empleado activado correctamente!';
			$xdatos['process']='insert';
		}
		else
		{
			$xdatos['typeinfo']='Error';
			$xdatos['msg']='Empleado no pudo ser activado!';
		}
	}
	echo json_encode ($xdatos);
}
if(!isset($_REQUEST ['process']))
{
	initial();
} else
{
	if (isset($_REQUEST ['process']))
	{
		switch ($_REQUEST ['process'])
		{
			case 'formDelete' :
				initial();
				break;
			case 'anular' :
				estado();
				break;
		}
	}
}
?>
