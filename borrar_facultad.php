<?php
include ("_core.php");
function initial(){
	$id_facultad = $_REQUEST["id_facultad"];
	$sql = ("SELECT * FROM tblfacultad WHERE id_facultad='$id_facultad'");
	$result = _query( $sql );
	$count = _num_rows( $result );
    //permiso del script
	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];
	$filename = "borrar_facultad.php";
	$links=permission_usr($id_user,$filename);

?>
<div class="modal-header">

	<button type="button" class="close" data-dismiss="modal"
		aria-hidden="true">&times;</button>
	<h4 class="modal-title">Borrar Facultad</h4>
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
							<th>Id Facultad</th>
							<th>Nombre Facultad</th>
						</tr>
					</thead>
					<tbody>
							<?php
								if ($count > 0) {
									for($i = 0; $i < $count; $i ++) {
										$row = _fetch_array ( $result, $i );
										echo "<tr><td>".$row['id_facultad']."</td>";
										echo "<td>".$row['nombre']."</td>";
										echo "</tr>";
										echo "<tr><th colspan=\"2\">"."Descripcion Facultad"."</th></tr>";
										echo "<tr><td colspan=\"2\">".$row['descripcion']."</td></tr>";


									}
								}
							?>
						</tbody>
				</table>
			</div>
		</div>
			<?php
			echo "<input type='hidden' nombre='id_facultad' id='id_facultad' value='$id_facultad'>";
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
	$id_facultad = $_POST ['id_facultad'];
	$table = 'tblfacultad';
	$where_clause = "id_facultad='" . $id_facultad . "'";
	$delete = _delete ( $table, $where_clause );
	if ($delete) {
		$xdatos ['typeinfo'] = 'Success';
		$xdatos ['msg'] = 'Facultad eliminada correctamente!';
	} else {
		$xdatos ['typeinfo'] = 'Error';
		$xdatos ['msg'] = 'La Facultad no pudo ser eliminada';
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
