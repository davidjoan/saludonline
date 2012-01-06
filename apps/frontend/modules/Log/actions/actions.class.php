<?php

/**
 * Log actions.
 *
 * @package    saludonline
 * @subpackage Log
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class LogActions extends sfActions
{  
  public function executeLoginFacebook(sfWebRequest $request)
  {
   $app_id     = "216460831062";
   $app_secret = "d6de7d61bfba7479418505453d5fad98";
   $my_url     = "http://saludonline.org/login/facebook";
   $code       = $request->getParameter("code");
   $state      = $request->getParameter("state");   

   if(empty($code)) 
   {
   $this->getUser()->setAttribute('state' ,md5(uniqid(rand(),TRUE)));
     $dialog_url = "https://www.facebook.com/dialog/oauth?client_id=" 
       . $app_id . "&redirect_uri=" . urlencode($my_url) . "&state="
       . $this->getUser()->getAttribute('state');
    return $this->redirect($dialog_url); 

   }      
   if($state == $this->getUser()->getAttribute('state') )
   {
     $token_url = "https://graph.facebook.com/oauth/access_token?"
       . "client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url)
       . "&client_secret=" . $app_secret . "&code=" . $code;

     $response = @file_get_contents($token_url);
     $params = null;
     parse_str($response, $params);

     $graph_url = "https://graph.facebook.com/me?access_token=" 
       . $params['access_token'];

     $user = json_decode(file_get_contents($graph_url));
     $patient = Doctrine::getTable('Patient')->findOneByFacebookId($user->id);
     if(!$patient)
     {
       $patient = Doctrine::getTable('Patient')->findOneByEmail($user->email);
     }
     
     if(!$patient)
     {
       $patient = new Patient();     
       $patient->setRealname($user->name);
       $patient->setUsername($user->username);
       $patient->setEmail($user->email);
       $patient->setUrl($user->link);           
     }


       $patient->setFacebookId($user->id);     
       $patient->save();      
     $this->getUser()->loginFrontend($patient);
     return $this->redirect('@profile_show');        
     //Deb::print_r($user);
   }
   else {
     echo("The state does not match. You may be a victim of CSRF.");
   }
  }
  public function executeLogin(sfWebRequest $request)
  {  
    
    if ($request->isMethod('post'))
    {
      $this->result = "no";
      $username = $request->getPostParameter('user_name');
      $password = $request->getPostParameter('password');
      
      if (!sfAntiBruteForceManager::canTryAuthentication($username))
      {
        $this->result = "mal";
      }
      else
      {
        $user = Doctrine::getTable('Patient')->findOneByLowerCaseUsername($username);
        if($user)
        {
          if (Cipher::getInstance()->decrypt($user->getPassword()) === $password)
          {
            $this->getUser()->loginFrontend($user);
            $this->result = "si";
          }    
          else
          {
            sfAntiBruteForceManager::notifyFailedAuthentication($username);
          }
        }          
      }
    }
    else
    {
      return $this->redirect('@homepage');        
    }

  }
  public function executeLogout()
  {
    if ($this->getUser()->isAuthenticated())
    {
      $this->getUser()->logout();
    }
    
    return $this->redirect('@homepage');
  }

}