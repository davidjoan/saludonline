<?php

/**
 * sfValidatorBuilderExt builds and assigns complex validators.
 *
 * @package    symfext
 * @subpackage validator
 * @author     David Joan Tataje Mendoza <new.skin007@gmail.com>
 * 
 * @TODO I18N
 */
class sfValidatorBuilderExt
{
  protected
    // normal messages
    $msgEmpty         = "The '%field%' field can't be left blank.",
    $msgEmptyList     = "Please, select at least an option in the '%field%' field.",
    $msgShort         = "The '%field%' field is too short (%min_length% characters min).",
    $msgLong          = "The '%field%' field is too long (%max_length% characters max).",
    $msgCombo         = "Please, choose an option in the '%field%' field.",
    $msgComboInvalid  = "The '%field%' field has an error in the chosen option.",
    $msgSimpleRegex   = "The '%field%' field has forbidden characters",
    $msgRegex         = "The '%field%' field has forbidden characters: &nbsp; %chars%",
    $msgUrl           = "Please, write a correct url in the '%field%' field.",
    $msgEmail         = "Please, write a correct e-mail in the '%field%' field.",
    $msgDate          = "Please, choose a correct date in the '%field%' field.",
    $msgMin           = "The '%field%' must be greater or equal than %min%.",
    $msgMax           = "The '%field%' must be less or equal than %max%.",
    $msgLength        = "The '%field%' field length must be %length% characters.",
    $msgCaptcha       = "The '%field%' field contains a wrong code.",
    
    // file messages
    $msgMaxSize       = "The file in the '%field%' field is too large (max size: %max_size% bytes).",
    $msgMimeTypes     = "The file in the '%field%' field has an invalid mime type (%mime_type%).",
    $msgPartialFile   = "The file in the '%field%' field was only partially uploaded.",
    $msgNoTmpDir      = "The file in the '%field%' field has a missing temporary folder.",
    $msgCantWrite     = "The file in the '%field%' field can not be written to disk.",
    $msgFileExtension = "The file in the '%field%' field was stopped by its extension.",
    
    // regular expressions
    $reCode           = '/[^A-Za-z0-9\-\_]+/',
    $reAlphabet       = '/[^A-Za-z áéíóúÁÉÍÓÚñÑ,\.\'"_\* \\\ \/ # ]+/',
    $reAlphabetExt    = '/[^\w çàáâãäåāæèéêëėēęìíîïīįòóôõōöøœùúûüůũūųýÿŷñÇÀÁÂÃÄÅĀÆÈÉÊËĖĒĘÌÍÎÏĪĮÒÓÔÕŌÖØŒÙÚÛÜŮŨŪŲÝŸŶÑ\.,\-_:?¿!¡ %&\$\n\r\+ @\'"\* \\\ \/ # \(\)]+$/',
    $reNumber         = '/[^\d+]+/',
    $reUser           = '/[^\w.\-_]+/',
    $rePhone          = '/[^\(\)\d \-\* \\\ \/ # ]+/',
    $reContent        = '/[^\w çàáâãäåāæèéêëėēęìíîïīįòóôõōöøœùúûüůũūųýÿŷñÇÀÁÂÃÄÅĀÆÈÉÊËĖĒĘÌÍÎÏĪĮÒÓÔÕŌÖØŒÙÚÛÜŮŨŪŲÝŸŶÑ\.…,\-_:;?¿!¡ %&\$\n\r\+= @\'"\* \\\ \/ # \(\)]+$/',
    $reIpAddress      = '/^(([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5]).){3}([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/',
    
    $types           = array(),
    $labels          = array(),
    $validatorSchema = null;
  
	/**
   * Constructor.
   *
   * @param array             $types           An array of field types
   * @param array             $labels          An array of field labels
   * @param sfValidatorSchema $validatorSchema A validator schema to update
   */
  public function __construct($types, $labels, sfValidatorSchema $validatorSchema)
  {
  	$this->types           = $types;
  	$this->labels          = $labels;
  	$this->validatorSchema = $validatorSchema;
  }
  
  /**
   * Returns the updated validator schema.
   *
   * @return sfValidatorSchema The updated validator schema
   */
  public function build()
  {
    foreach ($this->types as $field => $type)
    {
      if ('=' == $type)
      {
        // preserve the validator
      }
      elseif ('-' == $type)
      {
      	unset($this->validatorSchema[$field]);
      }
      else
      {
      	$options = array();
      	if (is_array($type))
      	{
      	  $options = $type[1];
      	  $type    = $type[0];
      	}
      	
      	$setType = 'setType'.sfInflector::camelize($type);
      	$this->$setType($field, $options);
      }
    }
    
    $this->updatePostValidators($this->validatorSchema->getPostValidator());

    return $this->validatorSchema;
  }
  
  /**
   * Updates a validator to a common validator regex.
   *
   * @param string $field The validator field
   * @param string $regex The regex to use in the validator
   */
  protected function updateToCommonValidatorRegex($field, $regex)
  {
    $validator = $this->validatorSchema[$field];
    
    $validator->addMessage('max_length', $this->processMessage($field, $this->msgLong));
    $validator->addMessage('min_length', $this->processMessage($field, $this->msgShort));
    
    $validator = new sfValidatorAnd
    (
      array($validator, new sfValidatorMessageRegex
      (
        array('pattern' => $regex),
        array('invalid' => $this->processMessage($field, $this->msgRegex))
      )),
      array('required' => $validator->getOption('required'), 'trim' => true),
      array('required' => $this->processMessage($field, $this->msgEmpty))
    );
    
    $this->validatorSchema[$field] = $validator;
  }
  
  /**
   * Updates a validator with the code validation.
   *
   * @param string $field The validator field
   */
  protected function setTypeCode($field)
  {
    $this->updateToCommonValidatorRegex($field, $this->reCode);
  }
  
  /**
   * Updates a validator with the name validation.
   *
   * @param string $field The validator field
   */
  protected function setTypeName($field)
  {
    $this->updateToCommonValidatorRegex($field, $this->reAlphabet);
  }
  
  /**
   * Updates a validator with the text validation.
   *
   * @param string $field The validator field
   */
  protected function setTypeText($field)
  {
    $this->updateToCommonValidatorRegex($field, $this->reAlphabetExt);
  }
  
  /**
   * Updates a validator with the fixed number validation.
   * 
   * @param string $field The validator field
   */
  protected function setTypeFixedNumber($field)
  {
    $this->updateToCommonValidatorRegex($field, $this->reNumber);
  }
  
  /**
   * Updates a validator with the wiki text validation.
   * 
   * @param string $field The validator field
   */
  protected function setTypeContent($field)
  {
    $this->updateToCommonValidatorRegex($field, $this->reContent);
  }
  
  /**
   * Updates a validator with the user validation.
   * 
   * @param string $field The validator field
   */
  protected function setTypeUser($field)
  {
    $this->updateToCommonValidatorRegex($field, $this->reUser);
  }
  
  /**
   * Updates a validator with the phone validation.
   * 
   * @param string $field The validator field
   */
  protected function setTypePhone($field)
  {
    $this->updateToCommonValidatorRegex($field, $this->rePhone);
  }
  
  /**
   * Updates a validator with the IP address validation.
   *
   * @param string $field The validator field
   */
  protected function setTypeIpAddress($field)
  {
    $validator = $this->validatorSchema[$field];
    
    $validator->addMessage('max_length', $this->processMessage($field, $this->msgLong));
    $validator->addMessage('min_length', $this->processMessage($field, $this->msgShort));
    
    $validator = new sfValidatorAnd
    (
      array($validator, new sfValidatorRegex
      (
        array('pattern' => $this->reIpAddress),
        array('invalid' => $this->processMessage($field, $this->msgSimpleRegex))
      )),
      array('required' => $validator->getOption('required'), 'trim' => true),
      array('required' => $this->processMessage($field, $this->msgEmpty))
    );
                 
    $this->validatorSchema[$field] = $validator;
  }
  
  /**
   * Updates a validator with the password validation.
   * 
   * @param string $field The validator field
   */
  protected function setTypePassword($field)
  {
  	$validator = $this->validatorSchema[$field];
  	
  	$validator->addMessage('max_length', $this->processMessage($field, $this->msgLong));
    $validator->addMessage('min_length', $this->processMessage($field, $this->msgShort));
  	$validator->setOption('min_length', 1);
  	$validator->setOption('max_length', 15);
    
  	$validator->setMessage('required', $this->processMessage($field, $this->msgEmpty));
  	$validator->setMessage('invalid' , $this->processMessage($field, $this->msgSimpleRegex));
  }
  
  /**
   * Updates a validator with the url validation.
   * 
   * @param string $field The validator field
   */
  protected function setTypeUrl($field)
  {
  	$validator = $this->validatorSchema[$field];
  	
  	$validator->addMessage('max_length', $this->processMessage($field, $this->msgLong));
  	$validator->addMessage('min_length', $this->processMessage($field, $this->msgShort));
  	
  	$validator = new sfValidatorAnd
    (
      array($validator, new sfValidatorUrl
      (
        array(),
        array('invalid' => $this->processMessage($field, $this->msgUrl))
      )),
      array('required' => $validator->getOption('required'), 'trim' => true),
      array('required' => $this->processMessage($field, $this->msgEmpty))
    );
    
  	$this->validatorSchema[$field] = $validator;
  }
  
  /**
   * Updates a validator with the email validation.
   * 
   * @param string $field The validator field
   */
  protected function setTypeEmail($field)
  {
  	$validator = $this->validatorSchema[$field];
  	
  	$validator->addMessage('max_length', $this->processMessage($field, $this->msgLong));
  	$validator->addMessage('min_length', $this->processMessage($field, $this->msgShort));
  	
  	$validator = new sfValidatorAnd
    (
      array($validator, new sfValidatorEmail
      (
        array(),
        array('invalid' => $this->processMessage($field, $this->msgEmail))
      )),
      array('required' => $validator->getOption('required'), 'trim' => true),
      array('required' => $this->processMessage($field, $this->msgEmpty))
    );
  	
  	$this->validatorSchema[$field] = $validator;
  }
  
  /**
   * Updates a validator with the combo validation.
   * 
   * @param string $field   The validator field
   * @param array  $options The validation options
   */
  protected function setTypeCombo($field, $options)
  {
  	$validator = $this->validatorSchema[$field];
  	
  	if ($validator instanceof sfValidatorDoctrineChoice)
  	{
  	  if (isset($options['query']))
  	  {
  	    $validator->setOption('query', $options['query']);
  	  }
  	  
  	  $validator->setMessage('required', $this->processMessage($field, $this->msgCombo));
  	  $validator->setMessage('invalid' , $this->processMessage($field, $this->msgCombo));
  	  return;
  	}
  	
  	$validator = new sfValidatorChoice
    (
      array
      (
        'choices'  => $options['choices'],
        'required' => $validator->getOption('required'),
        'multiple' => isset($options['multiple']) ? $options['multiple'] : false
      ),
      array
      (
        'required' => $this->processMessage($field, $this->msgCombo),
        'invalid'  => $this->processMessage($field, $this->msgComboInvalid)
      )
    );
  	
  	$this->validatorSchema[$field] = $validator;
  }
  
  /**
   * Updates a validator with the list validation.
   *
   * @param string $field The validator field
   * @param array  $options The validation options
   */
  protected function setTypeList($field, $options)
  {
    $validator = $this->validatorSchema[$field];
    
    if ($validator instanceof sfValidatorDoctrineChoice)
    {
      if (isset($options['query']))
      {
        $validator->setOption('query', $options['query']);
      }
      
      $validator->setMessage('required', $this->processMessage($field, $this->msgEmptyList));
      $validator->setMessage('invalid' , $this->processMessage($field, $this->msgEmptyList));
      return;
    }
    
    $validator = new sfValidatorChoice
    (
      array
      (
        'choices'  => $options['choices'],
        'required' => $validator->getOption('required'),
        'multiple' => isset($options['multiple']) ? $options['multiple'] : false
      ),
      array
      (
        'required' => $this->processMessage($field, $this->msgEmptyList),
        'invalid'  => $this->processMessage($field, $this->msgEmptyList)
      )
    );
                 
    $this->validatorSchema[$field] = $validator;
  }
  
  /**
   * Updates a validator with the integer validation.
   * 
   * @param string $field   The validator field
   * @param array  $options The validation options
   */
  protected function setTypeInteger($field, $options)
  {
  	$validator = $this->validatorSchema[$field];

  	$validator = new sfValidatorInteger
    (
      array
      (
        'required' => $validator->getOption('required'),
        'trim'     => true,
      ),
      array
      (
        'required' => $this->processMessage($field, $this->msgEmpty),
        'invalid'  => $this->processMessage($field, $this->msgRegex),
        'min'      => $this->processMessage($field, $this->msgMin),
        'max'      => $this->processMessage($field, $this->msgMax)
      )
    );
    
  	if (isset($options['min']))
  	{
  	  $validator->setOption('min', $options['min']);
  	}
  	if (isset($options['max']))
  	{
  	  $validator->setOption('max', $options['max']);
  	}
  	
    $this->validatorSchema[$field] = $validator;
  }
  
  /**
   * Updates a validator with the float validation.
   * 
   * @param string $field   The validator field
   * @param array  $options The validation options
   */
  protected function setTypeFloat($field, $options)
  {
  	$validator = $this->validatorSchema[$field];
  	
  	$validator = new sfValidatorNumber
    (
      array
      (
        'required' => $validator->getOption('required'),
        'trim'     => true,
      ),
      array
      (
        'required' => $this->processMessage($field, $this->msgEmpty),
        'invalid'  => $this->processMessage($field, $this->msgRegex),
        'min'      => $this->processMessage($field, $this->msgMin),
        'max'      => $this->processMessage($field, $this->msgMax)
      )
    );
    
  	if (isset($options['min']))
  	{
  	  $validator->setOption('min', $options['min']);
  	}
  	if (isset($options['max']))
  	{
  	  $validator->setOption('max', $options['max']);
  	}
  	
    $this->validatorSchema[$field] = $validator;
  }
  
  /**
   * Updates a validator with the date validation.
   *
   * @param string $field The validator field
   * @param array  $options The validation options
   */
  protected function setTypeDate($field, $options)
  {
  	$validator = $this->validatorSchema[$field];
  	
  	$validator->setMessage('required', $this->processMessage($field, $this->msgEmpty));
  	$validator->setMessage('invalid' , $this->processMessage($field, $this->msgDate));
  	
  	if (isset($options['min']))
  	{
  	  $validator->setOption('min', $options['min']);
  	  $validator->setMessage('min', $this->processMessage($field, $validator->processMessage('min')));
  	}
  	if (isset($options['max']))
  	{
  	  $validator->setOption('max', $options['max']);
  	  $validator->setMessage('max', $this->processMessage($field, $validator->processMessage('max')));
  	}
  	
    $this->validatorSchema[$field] = $validator;
  }
  
  /**
   * Updates a validator with the pass validation.
   *
   * @param string $field The validator field
   */
  protected function setTypePass($field)
  {
  	$validator = new sfValidatorPass(array('required' => false));
  	
    $this->validatorSchema[$field] = $validator;
  }
  
  /**
   * Updates a validator with the file validation.
   *
   * @param string $field The validator field
   */
  protected function setTypeFile($field)
  {
  	$validator = $this->validatorSchema[$field];
  	
  	$validator->setMessage('required'  , $this->processMessage($field, $this->msgEmpty));
  	
  	$validator->setMessage('max_size'  , $this->processMessage($field, $this->msgMaxSize));
  	$validator->setMessage('mime_types', $this->processMessage($field, $this->msgMimeTypes));
  	$validator->setMessage('partial'   , $this->processMessage($field, $this->msgPartialFile));
  	$validator->setMessage('no_tmp_dir', $this->processMessage($field, $this->msgNoTmpDir));
  	$validator->setMessage('cant_write', $this->processMessage($field, $this->msgCantWrite));
  	$validator->setMessage('extension' , $this->processMessage($field, $this->msgFileExtension));
  	
    $this->validatorSchema[$field] = $validator;
  }
  
  /**
   * Updates a validator with the captcha validation.
   *
   * @param string $field The validator field
   */
  protected function setTypeCaptcha($field)
  {
    $validator = $this->validatorSchema[$field];
    
    $validator->addMessage('max_length', $this->processMessage($field, $this->msgLong));
    $validator->addMessage('min_length', $this->processMessage($field, $this->msgShort));
    
    $validator = new sfValidatorAnd
    (
      array($validator, new sfValidatorCaptcha
      (
        array('length' => sfConfig::get('app_captcha_length', 5), 'required' => true), 
        array
        (
          'length'  => $this->processMessage($field, $this->msgLength), 
          'captcha' => $this->processMessage($field, $this->msgCaptcha),
        )
      )),
      array('required' => $validator->getOption('required'), 'trim' => true),
      array('required' => $this->processMessage($field, $this->msgEmpty))
    );
    
    $this->validatorSchema[$field] = $validator;
  }
  
  /**
   * Updates post validators to have correct messages.
   *
   * @param sfValidatorBase $validator The post validator
   */
  protected function updatePostValidators($validator)
  {
    if (!$validator)
    {
      return;
    }
    
  	if ($validator instanceof sfValidatorAnd || $validator instanceof sfValidatorOr)
  	{
  	  return $this->updatePostValidators($validator->getValidators());
  	}
  	
  	if (is_array($validator))
  	{
  	  foreach ($validator as $val)
  	  {
  	  	$this->updatePostValidators($val);
  	  }
  	  
  	  return;
  	}
  	
	  $keys = array_map(create_function('$v', 'return \'%\'.$v.\'%\'; '), array_keys($this->labels));
	  foreach ($validator->getMessages() as $name => $message)
	  {
	    $updated_message = $validator->getMessage($name);
	    foreach ($validator->getOptions() as $option => $value)
	    {
	      if (is_array($value))
	      {
      	  $value = implode(', ', array_map(create_function('$v', 'return \'%\'.$v.\'%\'; '), $value));
	      }
	      elseif (is_object($value) && method_exists($value, '__toString'))
	      {
	        $value = '%'.$value->__toString().'%';
	      }
	      else
	      {
	        $value = '%'.$value.'%';
	      }
	      
	      $updated_message = str_replace('%'.$option.'%', $value, $updated_message);
	    }
	    
	    $validator->setMessage($name, str_replace($keys, $this->labels, $updated_message));
	  }
  }
  
  /**
   * Process the message with the field.
   *
   * @param string $field   The validator field
   * @param string $message The message to process
   */
  protected function processMessage($field, $message)
  {
  	return str_replace('%field%', $this->labels[$field], $message);
  }
}
