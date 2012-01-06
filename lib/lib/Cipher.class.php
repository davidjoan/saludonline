<?php
class Cipher
{
  private static $instance;
  protected static
    $textkey   = 's4lud0nl1n3',
    $securekey = '';
  
  private function __construct()
  {
    self::$securekey = hash('sha256', self::$textkey, TRUE);  	
  }

  public static function getInstance()
  {
  	if(!(self::$instance instanceof self))
	{
      self::$instance = new self();
    }

    return self::$instance;
  }

  public static function hasInstance()
  {
    return isset(self::$instance);
  }
    
  public function __clone()
  {
    throw new sfException('The object cannot be cloned.');
  }
  
  public function encrypt($input)
  {
    return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, self::$securekey, $input, MCRYPT_MODE_ECB, mcrypt_create_iv(32, MCRYPT_RAND)));
  }
  
  public function decrypt($input)
  {
    return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, self::$securekey, base64_decode($input), MCRYPT_MODE_ECB, mcrypt_create_iv(32, MCRYPT_RAND)));
  }
}
