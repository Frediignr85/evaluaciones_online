<?php
	include '_conexion.php';
	$query = _query("SELECT COUNT(tblevaluacion.id_evaluacion) as 'total', tblcurso.nombre FROM tblevaluacion INNER JOIN tblcurso on tblcurso.id_curso = tblevaluacion.id_curso GROUP BY tblcurso.id_curso ORDER BY total DESC");
	while($row = _fetch_array($query)){
		$data[] = array(
			"total" => $row['total'],  
			"producto" => $row['nombre'], 
		);
	}
	echo json_encode($data);
?>