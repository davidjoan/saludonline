<?php

/**
 * Patient
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    saludonline
 * @subpackage model
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Patient extends BasePatient
{
  public function setPassword($password)
  {
    //$this->_set('password', kcCrypt::encrypt($password));
      $this->_set('password', Cipher::getInstance()->encrypt($password));
      
  }
  
  public function asArray()
  {
  	return array(
        'realname'   => $this->getRealname(),
        'username'   => $this->getUsername(),
        'email'      => $this->getEmail()
  	);
  }
    
  public function calculaProgreso()
  {
      $puntaje = 1;
      if($this->getUrl() <> '' )
      {
        $puntaje+=5;
      }
      if($this->getTwitterUsername() <> '' )
      {
        $puntaje+=5;
      }      
      if($this->getPhone() <> '' )
      {
        $puntaje+=5;
      }          
      if($this->getContacts()->count() > 0 )
      {
        $puntaje+=5;
      }
      if($this->getDoctors()->count() > 0 )
      {
        $puntaje+=5;
      }      
      if($this->getProfiles()->count() > 0 )
      {
          foreach($this->getProfiles() as $profile)
          {
            $puntaje+=5;
            if($profile->getWeights()->count() > 0 )
            {
              $puntaje+=3;        
            }
            if($profile->getHeights()->count() > 0 )
            {
              $puntaje+=3;        
            }
            if($profile->getTreatments()->count() > 0 )
            {
              $puntaje+=6;        
            }  
            if($profile->getImage() <> '' )
            { 
              $puntaje+=2;
            }
            if($profile->getDateOfBirth() <> '' )
            { 
              $puntaje+=2;
            }   
            if($profile->getBloodType() <> '' )
            { 
              $puntaje+=2;
            }               
            if($profile->getGender() <> '' )
            { 
              $puntaje+=2;
            }            
            if($profile->getMaritalStatus() <> '' )
            { 
              $puntaje+=2;
            }       
            if($profile->getDescription() <> '' )
            { 
              $puntaje+=2;
            }                    
          }
      }
      return ($puntaje > 100)? 100 : $puntaje;
  }
    
}