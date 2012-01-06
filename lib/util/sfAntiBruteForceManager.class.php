<?php
/**
 * This file is part of the sfAntiBruteForcePlugin package.
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfAntiBruteForceManager allows to manage the brute force attempts
 *
 * @package    sfAntiBruteForcePlugin
 * @author     Grégoire Marchal <gregoire.marchal@gmail.com>
 */
class sfAntiBruteForceManager
{
  /**
   * Increments the failed attempts of the user
   *
   * @param string $identifier The user identifier (generally his login)
   *
   * @return void
   */
  public static function notifyFailedAuthentication($identifier)
  {
    $storage = new sfAntiBruteForceFileStorage($identifier);
    $storage->increaseAttemptsCount();
  }

  /**
   * Tells if the user has reached the attempts threshold
   *
   * @param string $identifier The user identifier (generally his login)
   *
   * @return bool
   */
  public static function canTryAuthentication($identifier)
  {
    // first, retrieve threshold from config
    $threshold = sfConfig::get('app_sfAntiBruteForcePlugin_threshold', 50);

    // then, retrieve user count
    $storage = new sfAntiBruteForceFileStorage($identifier);

    // check the fail counter
    return ($storage->getAttemptsCount() < $threshold);
  }
}
