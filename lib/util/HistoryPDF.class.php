<?php

/**
 * HistoryPDF
 *
 * @package    saludonline
 * @subpackage lib
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 */
class HistoryPDF extends FPDF
{
  public $codigo; 
  public $B;
  public $I;
  public $U;
  public $HREF;

  function PDF($orientation='P', $unit='mm', $size='A4')
  {
    //Llama al constructor de la clase padre
    $this->FPDF($orientation,$unit,$size);
    //Iniciación de variables
    $this->B = 0;
    $this->I = 0;
    $this->U = 0;
    $this->HREF = '';
  }
  
  function HistoryPDF($orientation='P', $unit='mm', $size='A4', $code)
  {
    $this->codigo = $code;  	
    parent::FPDF($orientation,$unit,$size);
  }

  function Header()
  {
    $this->SetFont('Arial','B',15);
    $this->Cell(45);
    $titulo = 'Historia Clinica';
    $this->Cell(80,10,utf8_decode($titulo),1,0,'C');

    $this->SetFont('Arial','B',12);
    $this->Cell(15);
    $this->Cell(30,5,'# de Historia',1,0,'C');
    $this->Ln();
    $this->Cell(140);
    $this->Cell(30,5,$this->codigo,1,0,'C');
    $this->Ln(8);
    $this->Cell(140);
    $this->Cell(30,5,'Fecha',1,0,'C');
    $this->Ln();
    $this->SetFont('Arial','I',12);
    $this->Cell(140);
    $this->Cell(30,5,date('d/m/Y'),1,0,'C');    
  }

  function Footer()
  {
    $this->SetY(-15);
    $this->SetFont('Arial','I',8);
    $footer = 'Salud Online - Página ';
    $this->Cell(0,10,utf8_decode($footer).$this->PageNo(),0,0,'C');
  }

  function DoctorTable($header, $data)
  {
    // Colores, ancho de línea y fuente en negrita
    $this->SetFillColor(70,130,180);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    // Cabecera
    $w = array(54.25, 40.25, 47.25, 47.25);
    for($i=0;$i<count($header);$i++)
    { 
      $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
    }
    $this->Ln();
    // Restauración de colores y fuentes
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Datos
    $fill = false;
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
        $this->Cell($w[1],6,$row[1],'LR',0,'C',$fill);
        $this->Cell($w[2],6,$row[2],'LR',0,'C',$fill);
        $this->Cell($w[3],6,$row[3],'LR',0,'C',$fill);
        $this->Ln();
        $fill = !$fill;
    }
    // Línea de cierre
    $this->Cell(array_sum($w),0,'','T');
  }  
  
  function FancyTable($header, $data)
  {
    // Colores, ancho de línea y fuente en negrita
    $this->SetFillColor(70,130,180);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    // Cabecera
    $w = array(149, 20, 20);
    for($i=0;$i<count($header);$i++)
    { 
      $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
    }
    $this->Ln();
    // Restauración de colores y fuentes
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Datos
    $fill = false;
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
        $this->Cell($w[1],6,$row[1],'LR',0,'C',$fill);
        $this->Cell($w[2],6,$row[2],'LR',0,'C',$fill);
        $this->Ln();
        $fill = !$fill;
    }
    // Línea de cierre
    $this->Cell(array_sum($w),0,'','T');
  }
  
  
  
  function DiagnosticoTable($header, $data)
  {
    $this->SetFillColor(70,130,180);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    // Cabecera
    $w = array(37.8, 37.8, 37.8, 37.8, 37.8);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $this->Ln();
    // Restauración de colores y fuentes
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Datos
    $fill = false;
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
        $this->Cell($w[1],6,$row[1],'LR',0,'C',$fill);
        $this->Cell($w[2],6,$row[2],'LR',0,'C',$fill);
        $this->Cell($w[2],6,$row[3],'LR',0,'C',$fill);
        $this->Cell($w[2],6,$row[4],'LR',0,'C',$fill);
        $this->Ln();
        $fill = !$fill;
    }
    // Línea de cierre
    $this->Cell(array_sum($w),0,'','T');
  }  
  

  function OpenTag($tag, $attr)
  {
    // Etiqueta de apertura
    if($tag=='B' || $tag=='I' || $tag=='U')
        $this->SetStyle($tag,true);
    if($tag=='A')
        $this->HREF = $attr['HREF'];
    if($tag=='BR')
        $this->Ln(5);
  }

  function CloseTag($tag)
  {
    // Etiqueta de cierre
    if($tag=='B' || $tag=='I' || $tag=='U')
        $this->SetStyle($tag,false);
    if($tag=='A')
        $this->HREF = '';
  }

  function SetStyle($tag, $enable)
  {
    // Modificar estilo y escoger la fuente correspondiente
    $this->$tag += ($enable ? 1 : -1);
    $style = '';
    foreach(array('B', 'I', 'U') as $s)
    {
        if($this->$s>0)
            $style .= $s;
    }
    $this->SetFont('',$style);
  }

  function PutLink($URL, $txt)
  {
    // Escribir un hiper-enlace
    $this->SetTextColor(0,0,255);
    $this->SetStyle('U',true);
    $this->Write(5,$txt,$URL);
    $this->SetStyle('U',false);
    $this->SetTextColor(0);
}  
  
function WriteHTML($html)
{
    // Intérprete de HTML
    $html = str_replace("\n",' ',$html);
    $a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
    foreach($a as $i=>$e)
    {
        if($i%2==0)
        {
            // Text
            if($this->HREF)
                $this->PutLink($this->HREF,$e);
            else
                $this->Write(5,$e);
        }
        else
        {
            // Etiqueta
            if($e[0]=='/')
                $this->CloseTag(strtoupper(substr($e,1)));
            else
            {
                // Extraer atributos
                $a2 = explode(' ',$e);
                $tag = strtoupper(array_shift($a2));
                $attr = array();
                foreach($a2 as $v)
                {
                    if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                        $attr[strtoupper($a3[1])] = $a3[2];
                }
                $this->OpenTag($tag,$attr);
            }
        }
    }
  }  
}