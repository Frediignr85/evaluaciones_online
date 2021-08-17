<?php
include_once "_core.php";

$query = $_REQUEST['query'];

$sql="SELECT * from tbldocente WHERE (nombres LIKE '%{$query}%' OR apellidos LIKE '%{$query}%' OR codigo LIKE '%{$query}%') AND deleted is NULL";
	//echo $sql;
$result = _query($sql);
$numrows = _num_rows($result);
$array_estu = array();
if ($numrows>0){
	while ($row = _fetch_assoc($result)) {
        $array_estu[] =$row['id_docente']."|".$row['nombres']." ".$row['apellidos']."|".$row['codigo']."|".$row['usuario'];
	}
}
	echo json_encode ($array_estu); //Return the JSON Array
?>
