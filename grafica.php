<?php
	include '_core.php';
	$inicio = restar_meses(date("Y-m-d"),4);
	for($i=0; $i<5; $i++)
	{
		$a = explode("-",$inicio)[0];
		$m = explode("-",$inicio)[1];
		$ult = cal_days_in_month(CAL_GREGORIAN, $m, $a);
		$ini = "$a-$m-01";
		$fin = "$a-$m-$ult";

		$query = _query("SELECT count(id_evaluacion) as total FROM tblevaluacion WHERE id_estado!= 1 AND id_estado != 6 AND fecha_creacion BETWEEN '$ini' AND '$fin'");
		$row = _fetch_array($query);
		$total = $row["total"];

		$data[] = array(
			"total" => $total,  
			"producto" => meses($m), 
		);
		$inicio = sumar_meses($ini,1);
	}
	echo json_encode($data);
?>