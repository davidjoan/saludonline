<?php

/**
 * kcCrypt
 *
 * @package    symfext
 * @subpackage util
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class kcCrypt
{
  protected static
    $passwordChars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz';
    
  /** 
   * Generate a random 32-character hexadecimal token.
   * 
   * @param string  $salt Some sort of salt, if necessary, 
   * to add to random characters before hashing.
   * 
   * @return string The generated token
   */
  public static function generateToken($salt = '')
  {
    $salt = serialize($salt);
    
    return md5(mt_rand(0, 0x7fffffff).$salt);
  }
  
  /**
   * Encrypt some text.
   * 
   * @param string $text The text to encrypt
   * 
   * @return string The encrypted text
   */
  public static function encrypt($text)
  {
    $salt = substr(self::generateToken(), 0, 8);
    
    return sprintf('%s:%s', $salt, md5(sprintf('%s-%s', $salt, md5($text))));
  }
  
  /**
   * Compares a hash and a text to check if
   * the encrypted text is equal to the hash.
   * 
   * @param string $hash The hash to compare
   * @param string $text The text to compare
   * 
   * @return boolean True if are equal, otherwise false
   */
  public static function compare($hash, $text)
  {
    list($salt, $real_hash) = explode(':', $hash, 2);
    
    return md5(sprintf('%s-%s', $salt, md5($text))) == $real_hash;
  }
  
  /**
   * Returns a random generated password.
   * 
   * @param integer $length The length of the password
   * 
   * @return string The generated password
   */
  public static function generatePassword($length = 7)
  {
    $length_chars = strlen(self::$passwordChars) - 1;
    $digit        = mt_rand(0, $length - 1);
    $new_password = '';
    
    for ($i = 0; $i < $length; $i++)
    {
      $new_password .= $i == $digit ? chr(mt_rand(48, 57)) : self::$passwordChars{mt_rand(0, $length_chars)};
    }
    
    return $new_password;
  }
}
