<?php
/**
 * This file is part of the sfAntiBruteForcePlugin package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfAntiBruteForceFileStorage allows to manage file storage of users counters
 *
 * @todo create sfAntiBruteForceStorageInterface
 *
 * @package    sfAntiBruteForcePlugin
 * @author     Grégoire Marchal <gregoire.marchal@gmail.com>
 */
class sfAntiBruteForceFileStorage
{
  /**
   * The user identifier
   * @var string
   */
  protected $identifier;

  /**
   * The path of the data file
   * @var string
   */
  protected $dataFilePath;

  /**
   * Class constructor
   *
   * @todo Clean identifier to avoid unsafe chars
   *
   * @param string $identifier The user identifier (generally his login)
   */
  public function  __construct($identifier)
  {
    $this->identifier = $this->clean($identifier);
    $this->dataFilePath = sfConfig::get('sf_cache_dir')
      . DIRECTORY_SEPARATOR . 'sfAntiBruteForcePlugin'
      . DIRECTORY_SEPARATOR . $this->identifier;
  }

  /**
   * Retrieves the fail attempts count from the data file
   *
   * @return integer
   */
  public function getAttemptsCount()
  {
    // file doesn't exist, so zero
    if (!file_exists($this->dataFilePath))
    {
      return 0;
    }

    // retrieve data from file
    $lines = file($this->dataFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $attemptsInfos = explode(':', $lines[0]);

    // check the date of last failed attempts
    if ($attemptsInfos[0] !== date('Y-m-d'))
    {
      // different dates, so no fail today
      // (and let's delete this obsolete file)
      $fs = new sfFilesystem();
      $fs->remove($this->dataFilePath);
      return 0;
    }

    return $attemptsInfos[1];
  }

  /**
   * Increases the fail attempts count for this user
   *
   * @return void
   */
  public function increaseAttemptsCount()
  {
    // create folder if it doesn't exist
    if (!is_dir(sfConfig::get('sf_cache_dir') . DIRECTORY_SEPARATOR . 'sfAntiBruteForcePlugin'))
    {
      $fs = new sfFilesystem();
      $fs->mkdirs(sfConfig::get('sf_cache_dir') . DIRECTORY_SEPARATOR . 'sfAntiBruteForcePlugin', 0777);
    }

    $newCount = $this->getAttemptsCount() + 1;
    $handle = fopen($this->dataFilePath, 'w');
    $written = fwrite($handle, sprintf('%s:%d', date('Y-m-d'), $newCount));
    fclose($handle);
  }

  /**
   * Cleans identifier to avoid security risks
   *
   * @param string $identifier The identifier to clean
   *
   * @return string
   */
  protected function clean($identifier)
  {
    return str_replace(array('/', '.', '\\'), array('', '', ''), $identifier);
  }
}
