<?php

/**
 * Home actions.
 *
 * @package    saludonline
 * @subpackage Home
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class HomeActions extends ActionsProject
{
  public function executeIndex(sfWebRequest $request)
  {
    Doctrine::getTable('Visit')->createAndSave($request->getPathInfoArray());
    $this->posts = Doctrine::getTable('Post')->findLastPosts(100);
  }
  
  public function executeShow(sfWebRequest $request)
  {    
    $this->posts = Doctrine::getTable('Post')->findLastPosts(10);
    
    $this->post = Doctrine::getTable('Post')->findOneBySlug($request->getParameter('slug'));
    $this->redirectUnless($this->post, '@homepage');
    
    $this->getResponse()->setTitle($this->post->getTitle().' | Articulo | Salud Online');
    $this->getResponse()->addMeta('description', $this->post->getMetaDescription());
    $this->getResponse()->addMeta('keywords'   , $this->post->getMetaKeywords());
    
    $this->commentForm = new CommentForm();
    
    if($this->getUser()->isAuthenticated() == true)
    {
      $this->commentForm->setDefaults(array('author_name' => $this->getUser()->getRealname(), 'author_email' => $this->getUser()->getUserEmail()));
    }
    
    if ($request->isMethod('post'))
    {
      $params = $request->getParameter($this->commentForm->getName());
      $params = array_merge($params, $this->getCommentParams($request));
      $this->commentForm->bind($params);
      
      if ($this->commentForm->isValid())
      {
        $comment = $this->commentForm->save();
        $this->redirect('@post_show?slug='.$this->post->getSlug());
      }
    }
  }
  
  protected function getCommentParams(sfWebRequest $request)
  {
    $data   = $request->getPathInfoArray();
    
    $params = array();
    $params['post_id']   = $this->post->getId();
    $params['author_ip'] = $request->getRemoteAddress();
    $params['agent']     = $data['HTTP_USER_AGENT'];
    $params['approved']  = CommentTable::YES;
    
    return $params;
  }  

  public function executeContact(sfWebRequest $request)
  {
    $this->response->setTitle('Salud Online | Contactenos');
    $this->response->addMeta('description', 'Contactanos por Teléfono:3926855 o escribenos al siguiente e-mail: dtataje@saludonline.org');
    $this->form = new ContactFrontendForm();
    
    if($request->isMethod('post')):

          $this->form->bind($request->getParameter('contact'));
        
          if($this->form->isValid()):
   
             if($this->form->getValue('captcha') == $this->getUser()->getAttribute('security_code')):
             $mensage = Swift_Message::newInstance()
		  ->setFrom($this->form->getValue('email'))
                  ->setTo(sfConfig::get('app_contact_form_email'))
		  ->setSubject($this->form->getValue('subject'))
		  ->setBody($this->getPartial('send'), 'text/html');
 
             $this->getMailer()->send($mensage); //enable in production

             $this->getUser()->setFlash('notice', sfConfig::get('app_contact_form_notice'));
             $this->redirect('@contact');
             else:
             $this->getUser()->setFlash('error', sfConfig::get('app_contact_form_captcha'));     
             endif;
          else:
             $this->getUser()->setFlash('error', sfConfig::get('app_contact_form_error'));
          endif;
      endif;
  }  
  
  public function executeImage()
  {
    sfConfig::set('sf_web_debug', false);
    $font = sfConfig::get('sf_web_dir').'/images/general/monofont.ttf';
    $width = 100;
    $height = 40;
    $characters = 6;
    $possible = '23456789bcdfghjkmnpqrstvwxyz';
    $font_size = $height * 0.75;
    $code = '';
    $i = 0;
    while ($i < $characters) { 
	$code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
	  $i++;    
    }
    $this->getUser()->setAttribute('security_code', $code);
    $image = imagecreate($width, $height);
    $background_color = imagecolorallocate($image, 255, 255, 255);
    $text_color = imagecolorallocate($image, 20, 40, 100);
    $noise_color = imagecolorallocate($image, 100, 180, 240);
      for( $i=0; $i<($width*$height)/3; $i++ ) {
         imagefilledellipse($image, mt_rand(0,$width), mt_rand(0,$height), 1, 1, $noise_color);
      }
      for( $i=0; $i<($width*$height)/150; $i++ ) {
	imageline($image, mt_rand(0,$width), mt_rand(0,$height), mt_rand(0,$width), mt_rand(0,$height), $noise_color);
      }
      $textbox = imagettfbbox($font_size, 0, $font, $code);
      $x = ($width - $textbox[4])/2;
      $y = ($height - $textbox[5])/2;
      imagettftext($image, $font_size, 0, $x, $y, $text_color, $font , $code);
    header("Content-type:  image/jpeg");
    imagepng($image);
    imagedestroy($image);
    return sfView::NONE;
  }    
  
  public function executeRegister(sfWebRequest $request)
  {
    $this->response->setTitle('Salud Online | Registrate');
    $this->response->addMeta('description', 'Registrate ahora mismo sin costo alguno y podras utilizar saludonline.');
    $this->form = new RegisterForm();    
    
    if($request->isMethod('post')):

          $this->form->bind($request->getParameter('patient'));
        
          if($this->form->isValid()):
             
             if($this->form->getValue('captcha') == $this->getUser()->getAttribute('security_code')):
                 
             $this->form->save();
             $mensage = Swift_Message::newInstance()
		  ->setFrom(sfConfig::get('app_contact_form_email'))
                  ->setTo($this->form->getValue('email'))
		  ->setSubject('Bienvenido a Salud Online, gracias por registrarte')
		  ->setBody($this->getPartial('register'), 'text/html');
 
             $this->getMailer()->send($mensage); //enable in production

             $this->getUser()->setFlash('notice', sfConfig::get('app_register_form_notice'));
             $this->redirect('@register');
             else:
             $this->getUser()->setFlash('error', sfConfig::get('app_register_form_captcha'));     
             endif;
          else:
             $this->getUser()->setFlash('error', sfConfig::get('app_register_form_error'));
          endif;
      endif;    
      
  }
  
  public function executeForgotPassword(sfWebRequest $request)
  {
    $this->response->setTitle('Salud Online | Olvido su Contrase単a');
    $this->getResponse()->addMeta('description', 'Si olvidaste tu contraseña, solo escribe tu email y dentro de poco recibiras un email con tu contraseña!');    
    $this->form = new ForgotPasswordForm();
    
    if($request->isMethod('post')):
        //Deb::print_r($request->getParameterHolder()->getAll() );

          $this->form->bind($request->getParameter('patient'));
        
          if($this->form->isValid()):
             //Deb::print_r_pre($this->getUser()->getAttribute('security_code'));
             //Deb::print_r($this->form->getValue('captcha'));
             if($this->form->getValue('captcha') == $this->getUser()->getAttribute('security_code')):
                 
             $patient = Doctrine::getTable('Patient')->findOneByEmail($this->form->getValue('email'));
             //Deb::print_r($patient->toArray());
               if($patient)
               {  
                 $mensage = Swift_Message::newInstance()
		   ->setFrom(sfConfig::get('app_contact_form_email'))
                   ->setTo($this->form->getValue('email'))
		   ->setSubject('Bienvenido a Salud Online, gracias por registrarte')
		   ->setBody($this->getPartial('forgot_password', array('patient' => $patient)), 'text/html');
                 
                 $this->getMailer()->send($mensage); //enable in production      
                 $this->getUser()->setFlash('notice', 'Se acaba de enviar un correo con tu contrase単a!');
                 $this->redirect('@homepage');
               }
               else
               {
                 $this->getUser()->setFlash('error', 'El correo que ingresaste no existe en Salud Online');         
               }
             else:
             $this->getUser()->setFlash('error', sfConfig::get('app_register_form_captcha'));     
             endif;
          else:
             $this->getUser()->setFlash('error', sfConfig::get('app_register_form_error'));
          endif;
      endif;     
  }  
}