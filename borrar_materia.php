<?php
include ("_core.php");
function initial(){
	$id_materia = $_REQUEST["id_materia"];
	$sql = ("SELECT * FROM tblmateria WHERE id_materia='$id_materia'");
	$result = _query( $sql );
	$count = _num_rows( $result );
    //permiso del script
	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];
	$filename = "borrar_materia.php";
	$links=permission_usr($id_user,$filename);

?>
<div class="modal-header">

	<button type="button" class="close" data-dismiss="modal"
		aria-hidden="true">&times;</button>
	<h4 class="modal-title">Borrar Materia</h4>
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
							<th>Id Materia</th>
							<th>Nombre Materia</th>
						</tr>
					</thead>
					<tbody>
							<?php
								if ($count > 0) {
									for($i = 0; $i < $count; $i ++) {
										$row = _fetch_array ( $result, $i );
										echo "<tr><td>".$row['id_materia']."</td>";
										echo "<td>".$row['nombre']."</td>";
										echo "</tr>";
										echo "<tr><th colspan=\"2\">"."Codigo Materia"."</th></tr>";
										echo "<tr><td colspan=\"2\">".$row['codigo']."</td></tr>";


									}
								}
							?>
						</tbody>
				</table>
			</div>
		</div>
			<?php
			echo "<input type='hidden' nombre='id_materia' id='id_materia' value='$id_materia'>";
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
	$id_materia = $_POST ['id_materia'];
	$table = 'tblmateria';
	$where_clause = "id_materia='" . $id_materia . "'";
	$delete = _delete ( $table, $where_clause );
	if ($delete) {
		$xdatos ['typeinfo'] = 'Success';
		$xdatos ['msg'] = 'Materia eliminada correctamente!';
	} else {
		$xdatos ['typeinfo'] = 'Error';
		$xdatos ['msg'] = 'La Materia no pudo ser eliminada';
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
