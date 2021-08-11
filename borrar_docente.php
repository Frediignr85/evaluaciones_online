<?php
include ("_core.php");
function initial(){
	$id_docente = $_REQUEST ['id_docente'];
	$sql="SELECT *FROM tbldocente WHERE id_docente='$id_docente'";
	$result = _query( $sql );
	$count = _num_rows( $result );
    //permiso del script
	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];
	$filename = "borrar_docente.php";
	$links=permission_usr($id_user,$filename);
		
?>
<div class="modal-header">
	
	<button type="button" class="close" data-dismiss="modal"
		aria-hidden="true">&times;</button>
	<h4 class="modal-title">Borrar Docente</h4>
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
							<th>Nombre</th>
						</tr>
					</thead>
					<tbody>	
							<?php
								if ($count > 0) {
									for($i = 0; $i < $count; $i ++) {
										$row = _fetch_array ( $result, $i );
										echo "<tr><td>Id Docente</th><td>$id_docente</td></tr>";
										echo "<tr><td>Nombres</td><td>".$row['nombres']."</td>";
										echo "<tr><td>Apellidos</td><td>".$row['apellidos']."</td>";
										echo "<tr><td>Usuario</td><td>".$row['usuario']."</td>";
                                        echo "<tr><td>Codigo</td><td>".$row['codigo']."</td>";
										echo "<tr><td>Fecha de Nacimiento</td><td>".ED($row['fecha_de_nacimiento'])."</td>";
										echo "</tr>";
													
									}
								}	
							?>
						</tbody>
				</table>
			</div>
		</div>
			<?php 
			echo "<input type='hidden' nombre='id_docente' id='id_docente' value='$id_docente'>";
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
	$id_docente = $_POST ['id_docente'];
	$table = 'tbldocente';
	$where_clause = "id_docente='" . $id_docente . "'";
	$delete = _delete ( $table, $where_clause );
	if ($delete) {
		$xdatos ['typeinfo'] = 'Success';
		$xdatos ['msg'] = 'Docente eliminado correctamente!';
	} else {
		$xdatos ['typeinfo'] = 'Error';
		$xdatos ['msg'] = 'Docente no pudo ser eliminado';
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
