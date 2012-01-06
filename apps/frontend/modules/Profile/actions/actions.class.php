<?php

/**
 * Profile actions.
 *
 * @package    saludonline
 * @subpackage Profile
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ProfileActions extends ActionsFrontend
{
  public function executePrint(sfWebRequest $request)
  {
    $slug    = $request->getParameter('slug');
    $profile = Doctrine::getTable('Profile')->findOneBySlug($slug);
    $this->forward404Unless($profile);
    $id = $this->getUser()->getUserId();
    $titular = Doctrine::getTable('Patient')->findOneById($id);  	
    $nombres_titular    = explode(" ", $titular->getRealname());
    $nombres_paciente   = explode(" ", $profile->getLastname());
  	
    $pdf = new HistoryPDF('P', 'mm', 'A4', $titular->getId().'-'.$profile->getId());
    $pdf->AddPage(); 
    $pdf->Ln(10);
    
    $pdf->SetFont('Arial','B',12);
    $pdf->SetTextColor(222,184,135);
    $pdf->Cell(0,5,'Datos del Titular',0,1);
    $pdf->Ln(3);
    $pdf->SetTextColor(0);

    $pdf->Cell(63,5,'Nombre del Titular',1,0,'C');
    $pdf->Cell(63,5,'Nombre Usuario',1,0,'C');
    $pdf->Cell(63,5,'Twitter',1,0,'C');
    $pdf->Ln();
    $pdf->SetFont('Arial','I',12);
    $pdf->Cell(63,5,utf8_decode($titular->getRealname()),1,0,'C');
    $pdf->Cell(63,5,$titular->getUsername(),1,0,'C');
    $pdf->Cell(63,5,$titular->getTwitterUsername(),1,0,'C');
    
    $pdf->Ln(8);
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(63,5,'Url',1,0,'C');
    $pdf->Cell(63,5,'Email',1,0,'C');
    $pdf->Cell(63,5,'Telefono',1,0,'C');
    $pdf->Ln();
    $pdf->SetFont('Arial','I',12);
    $pdf->Cell(63,5,utf8_decode($titular->getUrl()),1,0,'C');
    $pdf->Cell(63,5,utf8_decode($titular->getEmail()),1,0,'C');
    $pdf->Cell(63,5,utf8_decode($titular->getPhone()),1,0,'C');

    $pdf->Ln(8); 
    $pdf->SetFont('Arial','B',12);
    $pdf->SetTextColor(222,184,135);
    $pdf->Cell(0,10,'Datos del Paciente',0,1);
    $pdf->Ln(3);
    $pdf->SetTextColor(0);
    if($profile->getImage())
    {
      $pdf->Image(sfConfig::get('app_profile_dir').'/'.$profile->getImage(),10,8,26,28);    
    }
    else
    {
      $pdf->Image(sfConfig::get('sf_web_dir') .'/images/general/pdf.jpg',10,8,33);
    }
    //paciente
    $identificacion = 'Estado Civil';
    $pdf->Cell(63,5,'Apellido Paterno',1,0,'C');
    $pdf->Cell(63,5,'Apellido Materno',1,0,'C');
    $pdf->Cell(63,5,'Nombre(s)',1,0,'C');
    $pdf->Ln();
    $pdf->SetFont('Arial','I',12);
    $pdf->Cell(63,5,utf8_decode($nombres_paciente[0]),1,0,'C');
    @$pdf->Cell(63,5,utf8_decode($nombres_paciente[1]),1,0,'C');
    $pdf->Cell(63,5,$profile->getFirstname(),1,0,'C');

    $pdf->Ln(8);
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(63,5,'Sexo',1,0,'C');
    $pdf->Cell(63,5,'Fecha de Nacimiento',1,0,'C');
    $pdf->Cell(63,5,utf8_decode($identificacion),1,0,'C');
    $pdf->Ln();
    $pdf->SetFont('Arial','I',12);
    $pdf->Cell(63,5,utf8_decode($profile->getGenderStr()),1,0,'C');
    @$pdf->Cell(63,5,utf8_decode($profile->getFormattedDateOfBirth()),1,0,'C');
    @$pdf->Cell(63,5,utf8_decode($profile->getMaritalStatusStr()),1,0,'C');
    
    $pdf->Ln(8);
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(63,5,'Parentesco',1,0,'C');
    $pdf->Cell(63,5,'Tipo de Sangre',1,0,'C');
    $pdf->Cell(63,5,'DNI',1,0,'C');
    $pdf->Ln();
    $pdf->SetFont('Arial','I',12);
    @$pdf->Cell(63,5,utf8_decode($profile->getTypeStr()),1,0,'C');
    $pdf->Cell(63,5,utf8_decode($profile->getBloodTypeStr()),1,0,'C');
    $pdf->Cell(63,5,utf8_decode($profile->getDni()),1,0,'C');    
    

    $header = array('Doctor', 'Especialidad', 'Correo', 'Telefono');
    $pdf->Ln(10);
    $pdf->SetFont('Arial','B',12);
    $pdf->SetTextColor(222,184,135);
    $pdf->Cell(0,5,'Mis Doctores',0,1);
    $pdf->Ln(3);
    $pdf->SetTextColor(0);    

    $data = $profile->getReportDoctors();
    $pdf->DoctorTable($header,$data);
    
    $header2 = array('Nombre', 'Genero', 'Correo', 'Telefono');
    $pdf->Ln(10);
    $pdf->SetFont('Arial','B',12);
    $pdf->SetTextColor(222,184,135);
    $pdf->Cell(0,5,'Contactos de Emergencia',0,1);
    $pdf->Ln(3);
    $pdf->SetTextColor(0);    

    $data2 = $profile->getReportContacts();
    @$pdf->DoctorTable($header2,$data2);    
    
    
    $pdf->Ln(30);
    $firma = 'Firma del Médico Tratante';
    $pdf->Cell(60);
    $pdf->Cell(58,5,utf8_decode($firma),'T',0,'C');
    
    $pdf->Output(sprintf('historia-%s.pdf',Doctrine_Inflector::urlize($profile->getFullName())),'D');
    //$pdf->Output();
    
    throw new sfStopException();
  }  
}
