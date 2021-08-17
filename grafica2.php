<?php
	include '_conexion.php';
	$query = _query("SELECT AVG(tblresultado_evaluacion.nota) as 'total', tblcurso.nombre FROM tblresultado_evaluacion INNER JOIN tblevaluacion on tblevaluacion.id_evaluacion = tblresultado_evaluacion.id_evaluacion INNER JOIN tblcurso on tblcurso.id_curso = tblevaluacion.id_curso GROUP BY tblcurso.id_curso ORDER BY total DESC ");
	while($row = _fetch_array($query)){
		$data[] = array(
			"total" => $row['total'],  
			"producto" => $row['nombre'], 
		);
	}
	echo json_encode($data);
?>