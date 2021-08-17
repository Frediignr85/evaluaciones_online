<?php

error_reporting(E_ERROR | E_PARSE);
require("_core.php");
require("num2letras.php");
require('fpdf/fpdf.php');

$id_sucursal=$_SESSION["id_sucursal"];
$id_resultado_evaluacion=$_REQUEST["id_resultado_evaluacion"];
if (!function_exists('set_magic_quotes_runtime')) {
    function set_magic_quotes_runtime($new_setting) {
        return true;
    }
}   

$sqll = _query("SELECT * FROM tblempresa where id_empresa='$id_sucursal'");
$fila = _fetch_array($sqll);
$nombre = $fila["nombre"];
$direccion = $fila["direccion"];
$telefono1 = $fila["telefono1"];
$telefono2 = $fila["telefono2"];
$id_municipio = $fila['id_municipio_EMP'];
$sql_d = "SELECT * FROM tblmunicipio WHERE id_municipio = '$id_municipio'";
$query_d  = _query($sql_d);
$row_d = _fetch_array($query_d);
$id_departamento = $row_d['id_departamento_MUN'];
$email = $fila["email"];
$website = $fila["website"];
$logo = $fila["logo"];

$sql_departamento = "SELECT * FROM tbldepartamento where id_departamento = '$id_departamento'";
$query_departamento = _query($sql_departamento);
$row_departamento = _fetch_array($query_departamento);
$nombre_departamento = $row_departamento['nombre_departamento'];

$sql_municipio = "SELECT * FROM tblmunicipio WHERE id_municipio = '$id_municipio'";
$query_municipio = _query($sql_municipio);
$row_municipio = _fetch_array($query_municipio);
$nombre_municipio = $row_municipio['municipio'];

$nombre_direccion = $nombre_municipio.", ".$nombre_departamento.".";


$sql_resultado = "SELECT * FROM tblresultado_evaluacion WHERE id_resultado_evaluacion= '$id_resultado_evaluacion'";
$query_resultado = _query($sql_resultado);

if(_num_rows($query_resultado) > 0){
    $row_resultado = _fetch_array($query_resultado);
    $fecha_empezado = ED($row_resultado['fecha_empezado']);
    $fecha_terminado = ED($row_resultado['fecha_terminado']);
    $hora_empezado = _hora_media_decode($row_resultado['hora_empezado']);
    $hora_terminado = _hora_media_decode($row_resultado['hora_terminado']);
    $id_evaluacion = ($row_resultado['id_evaluacion']);
    $sql_evaluacion = "SELECT * FROM tblevaluacion WHERE id_evaluacion = '$id_evaluacion'";
    $query_evaluacion = _query($sql_evaluacion);
    $row_evaluacion = _fetch_array($query_evaluacion);
    $nombre_evaluacion = $row_evaluacion['nombre'];
    $descripcion_evaluacion = $row_evaluacion['descripcion'];
    $nota_minima = $row_evaluacion['nota_minima'];
    $nota_maxima = $row_evaluacion['nota_maxima'];
    $fecha_inicio = ED($row_evaluacion['fecha_inicio']);
    $hora_inicio = _hora_media_decode($row_evaluacion['hora_inicio']);
    $fecha_fin = ED($row_evaluacion['fecha_fin']);
    $hora_fin = _hora_media_decode($row_evaluacion['hora_fin']);

    $tiempo_estimado = number_format($row_evaluacion['tiempo_estimado'],2,":")." Minutos";
    $id_curso = $row_evaluacion['id_curso'];
    $sql_curso = "SELECT * FROM tblcurso WHERE id_curso = '$id_curso'";
    $query_curso = _query($sql_curso);
    $row_curso = _fetch_array($query_curso);
    $nombre_curso = $row_curso['nombre'];
    $id_materia = $row_curso['id_materia'];
    $id_docente = $row_curso['id_docente'];
    $sql_materia = "SELECT * FROM tblmateria WHERE id_materia = '$id_materia'";
    $query_materia = _query($sql_materia);
    $row_materia = _fetch_array($query_materia);
    $nombre_materia = $row_materia['nombre'];
    $codigo_materia = $row_materia['codigo'];
    $sql_docente = "SELECT * FROM tbldocente WHERE id_docente = '$id_docente'";
    $query_docente = _query($sql_docente);
    $row_docente = _fetch_array($query_docente);
    $nombres_docente = $row_docente['nombres'];
    $apellidos_docente = $row_docente['apellidos'];
    $nombre_docente = $nombres_docente." ".$apellidos_docente;
    $id_estudiante = $row_resultado['id_estudiante'];
    $nota = $row_resultado['nota'];
    $tiempo_realizado = $row_resultado['tiempo_realizado'];
    $tiempo_realizado = number_format($tiempo_realizado,2,":")." Minutos";
    $sql_estudiante = "SELECT * FROM tblestudiante WHERE id_estudiante = '$id_estudiante'";
    $query_estudiante = _query($sql_estudiante);
    $row_estudiante = _fetch_array($query_estudiante);
    $nombres_estudiante = $row_estudiante['nombres'];
    $apellidos_estudiante = $row_estudiante['apellidos'];
    $nombre_estudiante = $nombres_estudiante." ".$apellidos_estudiante;
    $codigo = $row_estudiante['codigo'];
    $usuario = $row_estudiante['usuario'];
    $id_facultad = $row_estudiante['id_facultad'];
    $id_carrera = $row_estudiante['id_carrera'];
    $sql_facultad = "SELECT  * FROM tblfacultad WHERE id_facultad = '$id_facultad'";
    $query_facultad = _query($sql_facultad);
    $row_facultad = _fetch_array($query_facultad);
    $nombre_facultad = $row_facultad['nombre'];
    $sql_carrera = "SELECT * FROM tblcarrera WHERE id_carrera = '$id_carrera'";
    $query_carrera = _query($sql_carrera);
    $row_carrera = _fetch_array($query_carrera);
    $nombre_carrera = $row_carrera['nombre'];
}

$infoext =  array(
    'nombre_empresa' => $nombre,
    'direccion' => $direccion,
    'telefono1' => $telefono1,
    'email' => $email,
    'website' => $website,
    'logo' => $logo,
    'nombre_estudiante' => $nombre_estudiante,
    'nombre_doctor' => $nombre_doctor,
    'codigo' => $codigo,
    'usuario' => $usuario,
    'fecha_empezado' => $fecha_empezado,
    'id_evaluacion' => $id_evaluacion,
    'nombre_direccion' => $nombre_direccion,
    'fecha_terminado' => $fecha_terminado,
    'hora_empezado' => $hora_empezado,
    'hora_terminado' => $hora_terminado,
    'nombre_facultad' => $nombre_facultad,
    'nombre_carrera' => $nombre_carrera,
    'nota' => $nota,
    'tiempo_realizado' => $tiempo_realizado,
    'nombre_evaluacion' => $nombre_evaluacion,
    'descripcion_evaluacion' => $descripcion_evaluacion,
    'nota_minima' => $nota_minima,
    'nota_maxima' => $nota_maxima,
    'tiempo_estimado' => $tiempo_estimado,
    'nombre_curso' => $nombre_curso,
    'nombre_materia' => $nombre_materia,
    'codigo_materia' => $codigo_materia,
    'nombre_docente' => $nombre_docente
);

class PDF extends FPDF{

  
    
    function drawTextBox($strText, $w, $h, $align='C', $valign='T', $border=true, $primero)
    {
        $vl = $h/4;
        $xi=$this->GetX();
        $yi=$this->GetY();

        $hrow=$this->FontSize;
        $textrows=$this->drawRows($w,$hrow,$strText,0,$align,0,0,0);
        $maxrows=floor($h/$this->FontSize);
        $rows=min($textrows,$maxrows);

        $dy=0;
        if (strtoupper($valign)=='M')
            $dy=($h-$rows*$this->FontSize)/2;
        if (strtoupper($valign)=='B')
            $dy=$h-$rows*$this->FontSize;
            $va = $yi+$dy;
            $v = $xi;
            $calculo = "";
            $this->SetY($yi+$dy);
            $this->SetX($xi);

            $this->drawRows($w,$hrow,$strText,0,$align,false,$rows,1);

            $this->SetY($yi);
            $this->SetX($v+ $w);

        if ($border)
            $this->Rect($xi,$yi,$w,$h);
    }

    function drawRows($w, $h, $txt, $border=0, $align='C', $fill=false, $maxline=0, $prn=0)
    {
        $cw=&$this->CurrentFont['cw'];
        if($w==0)
            $w=$this->w-$this->rMargin-$this->x;
        $wmax=($w-4*$this->cMargin)*1000/$this->FontSize;
        $s=str_replace("\r",'',$txt);
        $nb=strlen($s);
        if($nb>0 && $s[$nb-1]=="\n")
            $nb--;
        $b=0;
        if($border)
        {
            if($border==1)
            {
                $border='LTRB';
                $b='LRT';
                $b2='LR';
            }
            else
            {
                $b2='';
                if(is_int(strpos($border,'L')))
                    $b2.='L';
                if(is_int(strpos($border,'R')))
                    $b2.='R';
                $b=is_int(strpos($border,'T')) ? $b2.'T' : $b2;
            }
        }
        $sep=-1;
        $i=0;
        $j=0;
        $l=0;
        $ns=0;
        $nl=1;
        while($i<$nb)
        {
            //Get next character
            $c=$s[$i];
            if($c=="\n")
            {
                //Explicit line break
                if($this->ws>0)
                {
                    $this->ws=0;
                    if ($prn==1) $this->_out('0 Tw');
                }
                if ($prn==1) {
                    $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,"C",$fill);
                }
                $i++;
                $sep=-1;
                $j=$i;
                $l=0;
                $ns=0;
                $nl++;
                if($border && $nl==2)
                    $b=$b2;
                if ( $maxline && $nl > $maxline )
                    return substr($s,$i);
                continue;
            }
            if($c==' ')
            {
                $sep=$i;
                $ls=$l;
                $ns++;
            }
            $l+=$cw[$c];
            if($l>$wmax)
            {
                //Automatic line break
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                    if($this->ws>0)
                    {
                        $this->ws=0;
                        if ($prn==1) $this->_out('0 Tw');
                    }
                    if ($prn==1) {
                        $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,"C",$fill);
                    }
                }
                else
                {
                    if($align=='J')
                    {
                        $this->ws=($ns>1) ? ($wmax-$ls)/1000*$this->FontSize/($ns-1) : 0;
                        if ($prn==1) $this->_out(sprintf('%.3F Tw',$this->ws*$this->k));
                    }
                    if ($prn==1){
                        $this->Cell($w,$h,substr($s,$j,$sep-$j),$b,2,"C",$fill);
                    }
                    $i=$sep+1;
                }
                $sep=-1;
                $j=$i;
                $l=0;
                $ns=0;
                $nl++;
                if($border && $nl==2)
                    $b=$b2;
                if ( $maxline && $nl > $maxline )
                    return substr($s,$i);
            }
            else
                $i++;
        }
        //Last chunk
        if($this->ws>0)
        {
            $this->ws=0;
            if ($prn==1) $this->_out('0 Tw');
        }
        if($border && is_int(strpos($border,'B')))
            $b.='B';
        if ($prn==1) {
            $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,"C",$fill);
        }
        $this->x=$this->lMargin;
        return $nl;
    }

    public function LineWriteB($array)
    {
      $ygg=0;
      $maxlines=1;
      $array_a_retornar=array();
      $array_max= array();
      foreach ($array as $key => $value) {
        // /Descripcion/
        $nombr=$value[0];
        // /fpdf width/
        $size=$value[1];
        // /fpdf alignt/
        $aling=$value[2];
        $jk=0;
        $w = $size;
        $h  = 0;
        $txt=$nombr;
        $border=0;
        if(!isset($this->CurrentFont))
          $this->Error('No font has been set');
        $cw = &$this->CurrentFont['cw'];
        if($w==0)
          $w = $this->w-$this->rMargin-$this->x;
        $wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
        $s = str_replace("\r",'',$txt);
        $nb = strlen($s);
        if($nb>0 && $s[$nb-1]=="\n")
          $nb--;
        $b = 1;

        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $ns = 0;
        $nl = 1;
        while($i<$nb)
        {
          // Get next character
          $c = $s[$i];
          if($c=="\n")
          {
            $array_a_retornar[$ygg]["valor"][]=substr($s,$j,$i-$j);
            $array_a_retornar[$ygg]["size"][]=$size;
            $array_a_retornar[$ygg]["aling"][]=$aling;
            $jk++;

            $i++;
            $sep = -1;
            $j = $i;
            $l = 0;
            $ns = 0;
            $nl++;
            if($border && $nl==2)
              $b = $b2;
            continue;
          }
          if($c==' ')
          {
            $sep = $i;
            $ls = $l;
            $ns++;
          }
          $l += $cw[$c];
          if($l>$wmax)
          {
            // Automatic line break
            if($sep==-1)
            {
              if($i==$j)
                $i++;
              $array_a_retornar[$ygg]["valor"][]=substr($s,$j,$i-$j);
              $array_a_retornar[$ygg]["size"][]=$size;
              $array_a_retornar[$ygg]["aling"][]=$aling;
              $jk++;
            }
            else
            {
              $array_a_retornar[$ygg]["valor"][]=substr($s,$j,$sep-$j);
              $array_a_retornar[$ygg]["size"][]=$size;
              $array_a_retornar[$ygg]["aling"][]=$aling;
              $jk++;

              $i = $sep+1;
            }
            $sep = -1;
            $j = $i;
            $l = 0;
            $ns = 0;
            $nl++;
            if($border && $nl==2)
              $b = $b2;
          }
          else
            $i++;
        }
        // Last chunk
        if($this->ws>0)
        {
          $this->ws = 0;
        }
        if($border && strpos($border,'B')!==false)
          $b .= 'B';
        $array_a_retornar[$ygg]["valor"][]=substr($s,$j,$i-$j);
        $array_a_retornar[$ygg]["size"][]=$size;
        $array_a_retornar[$ygg]["aling"][]=$aling;
        $jk++;
        $ygg++;
        if ($jk>$maxlines) {
          // code...
          $maxlines=$jk;
        }
      }

      $ygg=0;
      foreach($array_a_retornar as $keys)
      {
        for ($i=count($keys["valor"]); $i <$maxlines ; $i++) {
          // code...
          $array_a_retornar[$ygg]["valor"][]="";
          $array_a_retornar[$ygg]["size"][]=$array_a_retornar[$ygg]["size"][0];
          $array_a_retornar[$ygg]["aling"][]=$array_a_retornar[$ygg]["aling"][0];
        }
        $ygg++;
      }
      $data=$array_a_retornar;
      $total_lineas=count($data[0]["valor"]);
      $total_columnas=count($data);


      $he = 4*$total_lineas;
      for ($i=0; $i < $total_lineas; $i++) {
        // code...
        $y = $this->GetY();
        if($y + $he > 274){
            $this-> AddPage();
        }
        for ($j=0; $j < $total_columnas; $j++) {
          // code...
          $salto=0;
          $abajo="LR";
          if ($i==0) {
            // code...
            $abajo="TLR";
          }
          if ($j==$total_columnas-1) {
            // code...
            $salto=1;
          }
          if ($i==$total_lineas-1) {
            // code...
            $abajo="BLR";
          }
          if ($i==$total_lineas-1&&$i==0) {
            // code...
            $abajo="1";
          }
          // if ($j==0) {
          //   // code...
          //   $abajo="0";
          // }
          $str = $data[$j]["valor"][$i];
          if ($str=="\b")
          {
            $abajo="0";
            $str="";
          }
          $this->Cell($data[$j]["size"][$i],4,$str,$abajo,$salto,$data[$j]["aling"][$i],1);
        }

        $this->setX(13);
      }
      /*
      $arreglo_valores = array();
      $hei = 4 * $total_lineas;
        for($i = 0; $i < $total_columnas ; $i++){
            $valor_p="";
            $size_p = 0;
            for($j = 0; $j < $total_lineas; $j++){
                $valor_p.=" ".$data[$i]["valor"][$j];
                $size_p=$data[$i]["size"][$j];
            }
            $arreglo_valores[] = array(
                'valor' => $valor_p,
                'size' => $size_p
            );
        }
        $count = 0;
        $y = $this->GetY();
        if($y + $hei > 274){
            $this-> AddPage();
        }
        foreach ($arreglo_valores as $key => $value) {
            if($count == 0){
                $this->drawTextBox($value['valor'], $value['size'], $hei, "C", 'M',1,1);
            }
            else{

                $this->drawTextBox($value['valor'], $value['size'], $hei, "C", 'M',1,0);
            }
            $count++;
        }

        $this->Ln($hei);
        */
    }
    // Cabecera de página\
    var $infoext =   array();
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Número de página
        $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');

        $this->SetY(-20);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Número de página
        $this->Cell(0,10,utf8_decode($this->infoext['nombre_direccion']),0,0,'C');

        $this->SetY(-25);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Número de página
        $this->Cell(0,10,utf8_decode($this->infoext['direccion']),0,0,'C');

    }
    public function Header()
    {
        //$this->Image("img/fondo_reporte.png",0,0,220,280);
        if ($this->PageNo() == 1){
            $set_x = $this->getX();
            $set_y = 2;
            $this->SetLineWidth(.5);
            $this->SetFillColor(255,255,255);
            $this->setX(5);
            $this->Image($this->infoext['logo'],2,-10,40,40);
            $this->Image($this->infoext['logo'],175,-10,40,40);
            $this->SetDrawColor(0,0,0);
            $this->SetFont('Courier', 'B', 19);
            $this->SetTextColor(25, 65, 96);
            //$this->Cell(160,7,utf8_decode($this->infoext['nombre_empresa']),0,1,'L');
            $set_y +=5;
            $this->setY($set_y);
            $this->setX(16);
            $this->SetFont('Courier', 'B', 22);
            $this->Cell(0,7,utf8_decode($this->infoext['nombre_empresa']),0,1,'C');
            $this->setY($this->getY());
            $this->SetFont('Courier', 'B', 12);
            $this->Cell(0,7,utf8_decode("WEBSITE: ".$this->infoext['website']."     TELEFONO: ".$this->infoext['telefono1']),0,1,'C');   
            $this->Cell(0,7,utf8_decode("EMAIL: ".$this->infoext['email']),0,1,'C');  
            $this->SetDrawColor(25,65,96);
            $this->Line(13,28,203,28);
        }
    }
    public function set($value,$tel,$logo,$jdas,$pas,$infoext)
    {
      $this->a=$value;
      $this->b=$tel;
      $this->c=$logo;
      $this->d=$jdas;
      $this->e=$pas;
      $this->infoext = $infoext;
    }
    
}

date_default_timezone_set("America/El_Salvador");
$pdf = new PDF('P','mm', 'Letter');
$jdas="";
$pdf->set($nombrelab,$telefono1,$logo,$jdas,1,$infoext);
$pdf->SetMargins(15,15);
$pdf->SetTopMargin(10);
$pdf->SetLeftMargin(13);
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,15);
$pdf->AddPage();

//QUERY PARA DATOS DEL PACIENTE
//DATOS DEL PACIENTE



$pdf->setY($pdf->getY()+5);
$pdf->SetFont('Courier', 'B', 10);
$pdf->Cell(0,5,utf8_decode("Estudiante: "),0,1,'L');
$pdf->SetFont('Courier', '', 10);
$pdf->Cell(0,5,utf8_decode($nombre_estudiante),0,1,'L');
$pdf->SetFont('Courier', 'B', 10);
$pdf->Cell(0,5,utf8_decode("Codigo: "),0,1,'L');
$pdf->SetFont('Courier', '', 10);
$pdf->Cell(0,5,utf8_decode($codigo),0,1,'L');
$pdf->SetFont('Courier', 'B', 10);
$pdf->MultiCell(0,5,utf8_decode("Nombre evaluacion: "),0,'L');
$pdf->SetFont('Courier', '', 10);
$pdf->MultiCell(0,5,utf8_decode($nombre_evaluacion),0,'L');
$pdf->SetFont('Courier', 'B', 10);
$pdf->MultiCell(0,5,utf8_decode("Descripcion evaluacion: "),0,'L');
$pdf->SetFont('Courier', '', 10);
$pdf->MultiCell(0,5,utf8_decode($descripcion_evaluacion),0,'L');
$pdf->SetFont('Courier', 'B', 10);
$pdf->MultiCell(0,5,utf8_decode("Docente Responsable: "),0,'L');
$pdf->SetFont('Courier', '', 10);
$pdf->MultiCell(0,5,utf8_decode($nombre_docente),0,'L');


$pdf->setY($pdf->getY()+5);

$pdf->SetFont('Courier', 'B', 10);

$pdf->SetFillColor(247,133,97);
$array_data = array(
    array("DATOS DE LA EVALUACION",190,"C"),
);
$pdf->LineWriteB($array_data);

$pdf->SetFillColor(97,188,247);
$array_data = array(
    array("NOTA MINIMA",28,"C"),
    array("NOTA MAXIMA",28,"C"),    
    array("TIEMPO DISPONIBLE",38,"C"),
    array("FECHA DE INICIO",38,"C"),
    array("FECHA DE FINALIZACION",58,"C"),
);
$pdf->LineWriteB($array_data);
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Courier', '', 9);
$array_data = array(
    array($nota_minima,28,"C"),
    array($nota_maxima,28,"C"),    
    array($tiempo_estimado,38,"C"),
    array($fecha_inicio." ".$hora_inicio,38,"C"),
    array($fecha_fin." ".$hora_fin,58,"C"),
);
$pdf->LineWriteB($array_data);
$pdf->setY($pdf->getY()+5);

$pdf->SetFont('Courier', 'B', 10);

$pdf->SetFillColor(247,133,97);
$array_data = array(
    array("RESULTADOS OBTENIDOS EN LA EVALUACION",190,"C"),
);
$pdf->LineWriteB($array_data);

$pdf->SetFillColor(97,188,247);
$array_data = array(
    array("NOTA FINAL",28,"C"),
    array("ESTADO",28,"C"),    
    array("TIEMPO UTILIZADO",38,"C"),
    array("FECHA DE INICIO",38,"C"),
    array("FECHA DE FINALIZACION",58,"C"),
);
$pdf->LineWriteB($array_data);
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Courier', '', 9);
$estado = "Aprobado";
if($nota < $nota_minima){
    $estado = "Reprobado";
}

$array_data = array(
    array($nota,28,"C"),
    array($estado,28,"C"),    
    array($tiempo_realizado,38,"C"),
    array($fecha_empezado." ".$hora_empezado,38,"C"),
    array($fecha_terminado." ".$hora_terminado,58,"C"),
);
$pdf->LineWriteB($array_data);

$pdf->setY($pdf->getY()+5);

$pdf->SetFont('Courier', 'B', 10);

$pdf->SetFillColor(247,133,97);
$array_data = array(
    array("RESPUESTAS EN LA EVALUACION",190,"C"),
);
$pdf->LineWriteB($array_data);
$pdf->setY($pdf->getY()+5);
$sql_preguntas = "SELECT * FROM tblpregunta_evaluacion WHERE id_evaluacion = '$id_evaluacion'";
$query_preguntas = _query($sql_preguntas);
while($row_preguntas = _fetch_array($query_preguntas)){
    $id_pregunta = $row_preguntas['id_pregunta_evaluacion'];
    $descripcion = $row_preguntas['descripcion'];
    $sql_respuestas = "SELECT * FROM tblrespuesta_evaluacion WHERE id_pregunta = '$id_pregunta'";
    $query_respuestas = _query($sql_respuestas);
    $pdf->SetFont('Courier', 'B', 10);
    $pdf->SetFillColor(97,188,247);
    $array_data = array(
        array("PREGUNTA",190,"C"),
    );
    $pdf->LineWriteB($array_data);
    $pdf->SetFont('Courier', '', 10);
    $pdf->SetFillColor(255,255,255);
    $array_data = array(
        array($descripcion,190,"C"),
    );
    $pdf->LineWriteB($array_data);
    $pdf->SetFont('Courier', 'B', 10);
    $pdf->SetFillColor(254,251,141);
    $array_data = array(
        array("RESPUESTA",105,"C"),
        array("MARCADA",20,"C"),
        array("CORRECTA",20,"C"),
        array("ACUMULA",20,"C"),
        array("PUNTOS",25,"C"),
    );
    $pdf->LineWriteB($array_data);
    $pdf->SetFont('Courier', '', 10);
    while($row_respuestas = _fetch_array($query_respuestas)){
        $id_respuesta = $row_respuestas['id_respuesta'];
        $descripcion_respuesta = $row_respuestas['descripcion'];
        $correcta = $row_respuestas['correcta'];
        if($correcta == 1){
            $correcta = "Si";
            $acumula = "Si";
        }
        elseif($correcta == 0){
            $correcta = "No";
            $acumula = "No";
        }
        $sql_comprobar_respuesta = "SELECT * FROM tblrespuesta_estudiante WHERE id_pregunta = '$id_pregunta' AND id_respuesta = '$id_respuesta' AND id_resultado_evaluacion = '$id_resultado_evaluacion' AND id_estudiante = '$id_estudiante'";
        $query_comprobar_respuesta = _query($sql_comprobar_respuesta);
        $row_comprobar_respuesta = _fetch_array($query_comprobar_respuesta);
        $marcada = $row_comprobar_respuesta['marcada'];
        if($marcada == 1){
            $marcada = "Si";
        }
        elseif($marcada == 0){
            $marcada = "No";
        }
        $respuesta_correcta = $row_comprobar_respuesta['correcta'];
        $porcentaje = $row_comprobar_respuesta['porcentaje'];
        if($respuesta_correcta && $acumula == "Si"){
            $pdf->SetFillColor(175,254,141);
        }
        else{
            $pdf->SetFillColor(255,255,255);
        }
        if($marcada == "Si" && $acumula == "No"){
            $pdf->SetFillColor(254,141,141);
        }
        
        $array_data = array(
            array($descripcion_respuesta,105,"C"),
            array($marcada,20,"C"),
            array($correcta,20,"C"),
            array($acumula,20,"C"),
            array($porcentaje,25,"C"),
        );
        $pdf->LineWriteB($array_data);
    }
    $pdf->setY($pdf->getY()+5);
}

ob_clean();
$pdf->Output("receta_pdf.pdf","I");

?>