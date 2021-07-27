<?php
include ("_core.php");
function initial(){
	$id_empleado = $_REQUEST ['id_empleado'];
	$id_sucursal= $_SESSION['id_sucursal'];
	$sql="SELECT em.*, te.nom_cargo FROM tblEmpleado as em, tblcargos as te WHERE te.id_cargo=em.id_tipo_empleado_EMP and em.id_empleado='$id_empleado' and em.id_sucursal_EMP='$id_sucursal'";
	$result = _query( $sql );
	$count = _num_rows( $result );
    //permiso del script
	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];
	$filename = "ver_empleado.php";
	$links=permission_usr($id_user,$filename);

?>
<div class="modal-header">

	<button type="button" class="close" data-dismiss="modal"
		aria-hidden="true">&times;</button>
	<h3 class="modal-title text-center text-navy">Detalle de Empleado</h3>
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
							<th>Campo</th>
							<th>Descripción</th>
						</tr>
					</thead>
					<tbody>
							<?php
								if ($count > 0) {
									for($i = 0; $i < $count; $i ++) {
										$row = _fetch_array ( $result, $i );
										echo "<tr><td class='col-lg-4'>ID</td><td class='col-lg-8'>$id_empleado</td></tr>";
										echo "<tr><td>Nombre</td><td>".$row['nombre']."</td>";
										echo "<tr><td>Apellido</td><td>".$row['apellido']."</td>";
										echo "<tr><td>Dirección</td><td>".$row['direccion']."</td>";
										echo "<tr><td>Telefono</td><td>".$row['telefono']."</td>";
										echo "<tr><td>Fecha nacimiento</td><td>".$row['fecha_de_nacimiento']."</td>";
										echo "<tr><td>Cargo</td><td>".$row['nom_cargo']."</td>";
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
			?>
		</div>

</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

</div>
<!--/modal-footer -->

<?php
} //permiso del script
else{
		echo "<div></div><br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div>";
	}
}
function ver()
{
	$id_empleado = $_POST ['id_empleado'];
	if (isset($id_empleado)) {
		$xdatos ['typeinfo'] = 'Success';
		} else {
		$xdatos ['typeinfo'] = 'Error';
		}
	echo json_encode ( $xdatos );
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
			case 'formVer' :
				initial();
				break;
			case 'ver' :
				ver();
				break;
		}
	}
}

?>
