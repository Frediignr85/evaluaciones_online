<?php

error_reporting(E_ERROR | E_PARSE);
require("_core.php");
require("num2letras.php");
require('fpdf/fpdf.php');

$id_sucursal=$_SESSION["id_sucursal"];
$id_evaluacion=$_REQUEST["id_evaluacion"];
if (!function_exists('set_magic_quotes_runtime')) {
    function set_magic_quotes_runtime($new_setting) {
        return true;
    }
}   

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


$infoext =  array(
    'nombre_empresa' => $nombre,
    'direccion' => $direccion,
    'telefono1' => $telefono1,
    'email' => $email,
    'website' => $website,
    'logo' => $logo,
    'nombre_direccion' => $nombre_direccion,
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
            $this->Image($this->infoext['logo'],235,-10,40,40);
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
            $this->Line(13,28,260,28);
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
$pdf = new PDF('L','mm', 'Letter');
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
    array("DATOS DE LA EVALUACION",250,"C"),
);
$pdf->LineWriteB($array_data);

$pdf->SetFillColor(97,188,247);
$array_data = array(
    array("NOTA MINIMA",50,"C"),
    array("NOTA MAXIMA",50,"C"),    
    array("TIEMPO DISPONIBLE",50,"C"),
    array("FECHA DE INICIO",50,"C"),
    array("FECHA DE FINALIZACION",50,"C"),
);
$pdf->LineWriteB($array_data);
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Courier', '', 9);
$array_data = array(
    array($nota_minima,50,"C"),
    array($nota_maxima,50,"C"),    
    array($tiempo_estimado,50,"C"),
    array($fecha_inicio." ".$hora_inicio,50,"C"),
    array($fecha_fin." ".$hora_fin,50,"C"),
);
$pdf->LineWriteB($array_data);

$pdf->setY($pdf->getY()+5);
$pdf->SetFillColor(247,133,97);
$array_data = array(
    array("RESULTADO DE ESTUDIANTES QUE SE REALIZARON LA PRUEBA",250,"C"),
);
$pdf->SetFont('Courier', 'B', 10);
$pdf->LineWriteB($array_data);

$pdf->SetFillColor(97,188,247);
$array_data = array(
    array("N",15,"C"),
    array("ESTUDIANTE",100,"C"),
    array("CODIGO",33,"C"),    
    array("NOTA FINAL",27,"C"),
    array("TIEMPO TARDADO",35,"C"),
    array("ESTADO",40,"C"),
);
$pdf->LineWriteB($array_data);
$sql_resultado_evaluaciones = "SELECT * FROM tblresultado_evaluacion WHERE id_evaluacion = '$id_evaluacion'";
$query_resultado = _query($sql_resultado_evaluaciones);
$numero = 1;
$total_aprobados = 0;
$total_reprobados = 0;
$nota_acumulada = 0;
$total_evaluaciones = _num_rows($query_resultado);
while($row_resultado = _fetch_array($query_resultado)){
    $id_estudiante = $row_resultado['id_estudiante'];
    $sql_estudiante = "SELECT * FROM tblestudiante WHERE id_estudiante = '$id_estudiante'";
    $query_estudiante = _query($sql_estudiante);
    $row_estudiante = _fetch_array($query_estudiante);
    $nombres_estudiante = $row_estudiante['nombres'];
    $apellidos_estudiante = $row_estudiante['apellidos'];
    $nombre_estudiante = $nombres_estudiante." ".$apellidos_estudiante;
    $codigo = $row_estudiante['codigo'];
    $estado = "Aprobado";
    $total_aprobados++;
    $pdf->SetFillColor(240,255,202);
    if($row_resultado['nota'] < $nota_minima){
        $estado = "Reprobado";
        $pdf->SetFillColor(255,202,202);
        $total_aprobados--;
        $total_reprobados++;
    }
    $nota_acumulada +=$row_resultado['nota'];
    $nota = number_format($row_resultado['nota'],2);
    $tiempo_usado = number_format($row_resultado['tiempo_realizado'],2,":")." Minutos";
    $pdf->SetFont('Courier', '', 9);
    $array_data = array(
        array($numero,15,"C"),
        array(utf8_decode($nombre_estudiante),100,"C"),
        array($codigo,33,"C"),    
        array($nota,27,"C"),
        array($tiempo_usado,35,"C"),
        array($estado,40,"C"),
    );
    $pdf->LineWriteB($array_data);
    $numero++;
}

$pdf->setY($pdf->getY()+5);
$pdf->SetFillColor(247,133,97);
$array_data = array(
    array("ESTADISTICAS DE LA PRUEBA",250,"C"),
);
$pdf->SetFont('Courier', 'B', 10);
$pdf->LineWriteB($array_data);

$pdf->SetFillColor(97,188,247);
$array_data = array(
    array("ESTUDIANTES APROBADOS",50,"C"),
    array("ESTUDIANTES REPROBADOS",50,"C"),
    array("PORCENTAJE APROBADOS",50,"C"),    
    array("PORCENTAJE REPORBADOS",50,"C"),
    array("NOTA PROMEDIO",50,"C"),
);
$pdf->LineWriteB($array_data);
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Courier', '', 9);
$porcentaje_aprobados = ($total_aprobados / $total_evaluaciones)*100;
$porcentaje_reprobados = ($total_reprobados / $total_evaluaciones)*100;
$nota_promedio = $nota_acumulada / $total_evaluaciones;
$array_data = array(
    array($total_aprobados,50,"C"),
    array($total_reprobados,50,"C"),
    array($porcentaje_aprobados." %",50,"C"),    
    array($porcentaje_reprobados." %",50,"C"),
    array($nota_promedio,50,"C"),
);
$pdf->LineWriteB($array_data);

ob_clean();
$pdf->Output("receta_pdf.pdf","I");

?>