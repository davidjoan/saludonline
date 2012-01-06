<?php

/**
 * kcValidatorBuilder builds and assigns complex validators.
 *
 * @package    symfext
 * @subpackage validator
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class kcValidatorBuilder
{
  protected
    $types           = array(),
    $validatorSchema = null,
    $labels          = array();
    
  protected static
    $msgEmpty         = 'The \'%field%\' field can\'t be left blank.',
    $msgEmptyList     = 'Please, select at least an option in the \'%field%\' field.',
    $msgLong          = 'The \'%field%\' field is too long (%max_length% characters max).',
    $msgShort         = 'The \'%field%\' field is too short (%min_length% characters min).',
    $msgCombo         = 'Please, choose an option in the \'%field%\' field.',
    $msgComboInvalid  = 'The \'%field%\' field has an error in the chosen option.',
    $msgRegex         = 'The \'%field%\' field has forbidden characters: &nbsp; %chars%',
    $msgUrl           = 'Please, write a correct url in the \'%field%\' field.',
    $msgEmail         = 'Please, write a correct e-mail in the \'%field%\' field.',
    $msgDate          = 'Please, choose a correct date in the \'%field%\' field.',
    $msgMin           = 'The \'%field%\' must be greater or equal than %min%.',
    $msgMax           = 'The \'%field%\' must be less or equal than %max%.',
    $msgLength        = 'The \'%field%\' field length must be %length% characters.',
    $msgCaptcha       = 'The \'%field%\' field contains a wrong code.',
    
    $msgMaxSize       = 'The file in the \'%field%\' field is too large (max size: %max_size% bytes).',
    $msgMimeTypes     = 'The file in the \'%field%\' field has an invalid mime type (%mime_type%).',
    $msgPartialFile   = 'The file in the \'%field%\' field was only partially uploaded.',
    $msgNoTmpDir      = 'The file in the \'%field%\' field has a missing temporary folder.',
    $msgCantWrite     = 'The file in the \'%field%\' field can not be written to disk.',
    $msgFileExtension = 'The file in the \'%field%\' field was stopped by its extension.',
    
    $reAlphabet       = '/[^A-Za-z áéíóúÁÉÍÓÚñÑ,\.\'"_\* \\\ \/ # ]+/',
    $reAlphabetExt    = '/[^\w áéíóúÁÉÍÓÚñÑ\.,\-_:?¿!¡ %&\$\n\r\+ @\'"\* \\\ \/ # \(\)]+/',
    $reNumber         = '/[^\d+]+/',
    $reWikiText       = '/[^ƒ]+/',
    $rePassword       = '/[^A-Za-z áéíóúÁÉÍÓÚñÑ,\.\'"_\* \\\ \/ # ]+/',
    $reAlphaNumerical = '/[^\w]+/',
    $reUser           = '/[^\w.\-_]+/',
    $rePhone          = '/[^\(\)\d \-\* \\\ \/ # ]+/',
    $reCode           = '/[^A-Za-z0-9\-\_]+/',
    $reToken          = '/[^a-zA-Z0-9]+/';
	
	
  public function __construct($types, sfValidatorSchema $validatorSchema, $labels)
  {
  	$this->types           = $types;
  	$this->validatorSchema = $validatorSchema;
  	$this->labels          = $labels;
  }
  
  public function build()
  {
    foreach ($this->types as $field => $type)
    {
      if ($type == '=')
      {
      }
      elseif ($type == '-')
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
    
    $this->buildPostValidators($this->validatorSchema->getPostValidator());

    return $this->validatorSchema;
  }
  
  
  protected function setTypeCaptcha($field)
  {
  	$validator = $this->validatorSchema[$field];
  	
  	$validator->addMessage('max_length', $this->getMessage($field, self::$msgLong));
  	$validator->addMessage('min_length', $this->getMessage($field, self::$msgShort));
  	
  	$validator = new sfValidatorAnd
  	             (
  	               array
  	               (
  	                 $validator,
  	                 new kcValidatorCaptcha
  	                 (
  	                   array('length' => sfConfig::get('app_captcha_length', 5), 'required' => true), 
  	                   array
  	                   (
  	                     'length'  => $this->getMessage($field, self::$msgLength), 
  	                     'captcha' => $this->getMessage($field, self::$msgCaptcha),
  	                   )
  	                 )
  	               ),
  	               
  	               array('required' => $validator->getOption('required'), 'trim' => true),
  	               array('required' => $this->getMessage($field, self::$msgEmpty))
  	             );
  	             
    $this->validatorSchema[$field] = $validator;
  }
  
  
  protected function setTypeCode($field)
  {
  	$validator = $this->validatorSchema[$field];
  	
  	$validator->addMessage('max_length', $this->getMessage($field, self::$msgLong));
  	$validator->addMessage('min_length', $this->getMessage($field, self::$msgShort));
  	
  	$validator = new sfValidatorAnd
  	             (
  	               array
  	               (
  	                 $validator,
  	                 new sfValidatorMessageRegex
  	                 (
  	                   array('pattern' => self::$reCode),
  	                   array('invalid' => $this->getMessage($field, self::$msgRegex))
  	                 )
  	               ),
  	               
  	               array('required' => $validator->getOption('required'), 'trim' => true),
  	               array('required' => $this->getMessage($field, self::$msgEmpty))
  	             );
  	             
    $this->validatorSchema[$field] = $validator;
  }
  
  protected function setTypeName($field)
  {
  	$validator = $this->validatorSchema[$field];
  	
  	$validator->addMessage('max_length', $this->getMessage($field, self::$msgLong));
  	$validator->addMessage('min_length', $this->getMessage($field, self::$msgShort));
  	
  	$validator = new sfValidatorAnd
  	             (
  	               array
  	               (
  	                 $validator,
  	                 new sfValidatorMessageRegex
  	                 (
  	                   array('pattern' => self::$reAlphabet),
  	                   array('invalid' => $this->getMessage($field, self::$msgRegex))
  	                 )
  	               ),
  	               
  	               array('required' => $validator->getOption('required'), 'trim' => true),
  	               array('required' => $this->getMessage($field, self::$msgEmpty))
  	             );
  	             
    $this->validatorSchema[$field] = $validator;
  }
  protected function setTypeText($field)
  {
  	$validator = $this->validatorSchema[$field];
  	
  	$validator->addMessage('max_length', $this->getMessage($field, self::$msgLong));
  	$validator->addMessage('min_length', $this->getMessage($field, self::$msgShort));
  	
  	$validator = new sfValidatorAnd
  	             (
  	               array
  	               (
  	                 $validator,
  	                 new sfValidatorMessageRegex
  	                 (
  	                   array('pattern' => self::$reAlphabetExt),
  	                   array('invalid' => $this->getMessage($field, self::$msgRegex))
  	                 )
  	               ),
  	               
  	               array('required' => $validator->getOption('required'), 'trim' => true),
  	               array('required' => $this->getMessage($field, self::$msgEmpty))
  	             );
  	             
  	$this->validatorSchema[$field] = $validator;
  }
  protected function setTypeNumberFixed($field)
  {
  	$validator = $this->validatorSchema[$field];
  	
  	$validator->addMessage('max_length', $this->getMessage($field, self::$msgLong));
  	$validator->addMessage('min_length', $this->getMessage($field, self::$msgShort));
  	
  	$validator = new sfValidatorAnd
  	             (
  	               array
  	               (
  	                 $validator,
  	                 new sfValidatorMessageRegex
  	                 (
  	                   array('pattern' => self::$reNumber),
  	                   array('invalid' => $this->getMessage($field, self::$msgRegex))
  	                 )
  	               ),
  	               
  	               array('required' => $validator->getOption('required'), 'trim' => true),
  	               array('required' => $this->getMessage($field, self::$msgEmpty))
  	             );
  	             
  	$this->validatorSchema[$field] = $validator;
  }
  protected function setTypeWikiText($field)
  {
  	$validator = $this->validatorSchema[$field];
  	
  	$validator->addMessage('max_length', $this->getMessage($field, self::$msgLong));
  	$validator->addMessage('min_length', $this->getMessage($field, self::$msgShort));
  	
  	$validator = new sfValidatorAnd
  	             (
  	               array
  	               (
  	                 $validator,
  	                 new sfValidatorMessageRegex
  	                 (
  	                   array('pattern' => self::$reWikiText),
  	                   array('invalid' => $this->getMessage($field, self::$msgRegex))
  	                 )
  	               ),
  	               
  	               array('required' => $validator->getOption('required'), 'trim' => true),
  	               array('required' => $this->getMessage($field, self::$msgEmpty))
  	             );
  	             
  	$this->validatorSchema[$field] = $validator;
  }
  
  protected function setTypeUser($field)
  {
  	$validator = $this->validatorSchema[$field];
  	
  	$validator->addMessage('max_length', $this->getMessage($field, self::$msgLong));
  	$validator->addMessage('min_length', $this->getMessage($field, self::$msgShort));
  	
  	$validator = new sfValidatorAnd
  	             (
  	               array
  	               (
  	                 $validator,
  	                 new sfValidatorMessageRegex
  	                 (
  	                   array('pattern' => self::$reUser),
  	                   array('invalid' => $this->getMessage($field, self::$msgRegex))
  	                 )
  	               ),
  	               
  	               array('required' => $validator->getOption('required'), 'trim' => true),
  	               array('required' => $this->getMessage($field, self::$msgEmpty))
  	             );
  	             
  	$this->validatorSchema[$field] = $validator;
  }
  protected function setTypeToken($field)
  {
  	$validator = $this->validatorSchema[$field];
  	
  	$validator->addMessage('max_length', $this->getMessage($field, self::$msgLong));
  	$validator->addMessage('min_length', $this->getMessage($field, self::$msgShort));
  	
  	$validator = new sfValidatorAnd
  	             (
  	               array
  	               (
  	                 $validator,
  	                 new sfValidatorMessageRegex
  	                 (
  	                   array('pattern' => self::$reToken),
  	                   array('invalid' => $this->getMessage($field, self::$msgRegex))
  	                 )
  	               ),
  	               
  	               array('required' => $validator->getOption('required'), 'trim' => true),
  	               array('required' => $this->getMessage($field, self::$msgEmpty))
  	             );
  	             
  	$this->validatorSchema[$field] = $validator;
  }
  protected function setTypePassword($field)
  {
  	$validator = $this->validatorSchema[$field];
  	$validator->setMessage('max_length', $this->getMessage($field, self::$msgLong));
  	$validator->setMessage('min_length', $this->getMessage($field, self::$msgShort));
  	$validator->setOption('min_length', 1);
  	$validator->setOption('max_length', 15);
  	
  	$validator = new sfValidatorAnd
  	             (
  	               array
  	               (
  	                 $validator,
  	                 new sfValidatorMessageRegex
  	                 (
  	                   array('pattern' => self::$rePassword),
  	                   array('invalid' => $this->getMessage($field, self::$msgRegex))
  	                 )
  	               ),
  	               
  	               array('required' => $validator->getOption('required'), 'trim' => false),
  	               array('required' => $this->getMessage($field, self::$msgEmpty))
  	             );
  	             
    $this->validatorSchema[$field] = $validator;
  }
  
  protected function setTypeUrl($field)
  {
  	$validator = $this->validatorSchema[$field];
  	
  	$validator->addMessage('max_length', $this->getMessage($field, self::$msgLong));
  	$validator->addMessage('min_length', $this->getMessage($field, self::$msgShort));
  	
  	$validator = new sfValidatorAnd
  	             (
  	               array
  	               (
  	                 $validator,
  	                 new sfValidatorUrl
  	                 (
  	                   array(),
  	                   array('invalid' => $this->getMessage($field, self::$msgUrl))
  	                 )
  	               ),
  	               
  	               array('required' => $validator->getOption('required'), 'trim' => true),
  	               array('required' => $this->getMessage($field, self::$msgEmpty))
  	             );
  	             
  	$this->validatorSchema[$field] = $validator;
  }
  protected function setTypeUrlWeb($field)
  {
  	$validator = $this->validatorSchema[$field];
  	
  	$validator->addMessage('max_length', $this->getMessage($field, self::$msgLong));
  	$validator->addMessage('min_length', $this->getMessage($field, self::$msgShort));
  	
  	$validator = new sfValidatorAnd
  	             (
  	               array
  	               (
  	                 $validator,
  	                 new sfValidatorUrlWeb
  	                 (
  	                   array(),
  	                   array('invalid' => $this->getMessage($field, self::$msgUrl))
  	                 )
  	               ),
  	               
  	               array('required' => $validator->getOption('required'), 'trim' => true),
  	               array('required' => $this->getMessage($field, self::$msgEmpty))
  	             );
  	             
  	$this->validatorSchema[$field] = $validator;
  }
  protected function setTypeEmail($field)
  {
  	$validator = $this->validatorSchema[$field];
  	
  	$validator->addMessage('max_length', $this->getMessage($field, self::$msgLong));
  	$validator->addMessage('min_length', $this->getMessage($field, self::$msgShort));
  	
  	$validator = new sfValidatorAnd
  	             (
  	               array
  	               (
  	                 $validator,
  	                 new sfValidatorEmail
  	                 (
  	                   array(),
  	                   array('invalid' => $this->getMessage($field, self::$msgEmail))
  	                 )
  	               ),
  	               
  	               array('required' => $validator->getOption('required'), 'trim' => true),
  	               array('required' => $this->getMessage($field, self::$msgEmpty))
  	             );
  	             
  	$this->validatorSchema[$field] = $validator;
  }
  
  protected function setTypePhone($field)
  {
  	$validator = $this->validatorSchema[$field];
  	
  	$validator->addMessage('max_length', $this->getMessage($field, self::$msgLong));
  	$validator->addMessage('min_length', $this->getMessage($field, self::$msgShort));
  	
  	$validator = new sfValidatorAnd
  	             (
  	               array
  	               (
  	                 $validator,
  	                 new sfValidatorMessageRegex
  	                 (
  	                   array('pattern' => self::$rePhone),
  	                   array('invalid' => $this->getMessage($field, self::$msgRegex))
  	                 )
  	               ),
  	               
  	               array('required' => $validator->getOption('required'), 'trim' => true),
  	               array('required' => $this->getMessage($field, self::$msgEmpty))
  	             );
  	             
  	$this->validatorSchema[$field] = $validator;
  }
  protected function setTypeCombo($field, $options)
  {
  	$validator = $this->validatorSchema[$field];
  	
  	if ($validator instanceof sfValidatorDoctrineChoice)
  	{
  	  if (isset($options['query']))
  	  {
  	    $validator->setOption('query', $options['query']);
  	  }
  	  
  	  $validator->setMessage('required', $this->getMessage($field, self::$msgCombo));
  	  $validator->setMessage('invalid', $this->getMessage($field, self::$msgCombo));
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
  	                 'required' => $this->getMessage($field, self::$msgCombo),
  	                 'invalid'  => $this->getMessage($field, self::$msgComboInvalid)
  	               )
  	             );
  	             
  	$this->validatorSchema[$field] = $validator;
  }
  
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
  	                 'required' => $this->getMessage($field, self::$msgEmpty),
  	                 'invalid'  => $this->getMessage($field, self::$msgRegex),
  	                 'min'      => $this->getMessage($field, self::$msgMin),
  	                 'max'      => $this->getMessage($field, self::$msgMax)
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
  	                 'required' => $this->getMessage($field, self::$msgEmpty),
  	                 'invalid'  => $this->getMessage($field, self::$msgRegex),
  	                 'min'      => $this->getMessage($field, self::$msgMin),
  	                 'max'      => $this->getMessage($field, self::$msgMax)
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
  
  protected function setTypeDate($field, $options)
  {
  	$validator = $this->validatorSchema[$field];
  	
  	$validator->setMessage('required', $this->getMessage($field, self::$msgEmpty));
  	$validator->setMessage('invalid' , $this->getMessage($field, self::$msgDate));
  	
  	if (isset($options['min']))
  	{
  	  $validator->setOption('min', $options['min']);
  	  $validator->setMessage('min', $this->getMessage($field, $validator->getMessage('min')));
  	}
  	if (isset($options['max']))
  	{
  	  $validator->setOption('max', $options['max']);
  	  $validator->setMessage('max', $this->getMessage($field, $validator->getMessage('max')));
  	}
  	
    $this->validatorSchema[$field] = $validator;
  }
  protected function setTypeList($field)
  {
    $validator = $this->validatorSchema[$field];
    
    $validator->setMessage('required', $this->getMessage($field, self::$msgEmptyList));
    
    $this->validatorSchema[$field] = $validator;
  }
  
  protected function setTypePass($field, $options)
  {
  	$validator = new sfValidatorPass(array('required' => false));
  	
    $this->validatorSchema[$field] = $validator;
  }
  protected function setTypeDateTime()
  {
  }
  protected function setTypeFile($field, $options)
  {
  	$validator = $this->validatorSchema[$field];
  	
  	$validator->setMessage('required', $this->getMessage($field, self::$msgEmpty));
  	
  	$validator->setMessage('max_size'  , $this->getMessage($field, self::$msgMaxSize));
  	$validator->setMessage('mime_types', $this->getMessage($field, self::$msgMimeTypes));
  	$validator->setMessage('partial'   , $this->getMessage($field, self::$msgPartialFile));
  	$validator->setMessage('no_tmp_dir', $this->getMessage($field, self::$msgNoTmpDir));
  	$validator->setMessage('cant_write', $this->getMessage($field, self::$msgCantWrite));
  	$validator->setMessage('extension' , $this->getMessage($field, self::$msgFileExtension));
  	
    $this->validatorSchema[$field] = $validator;
  }
  
  protected function buildPostValidators($validator)
  {
    if (!$validator)
    {
      return;
    }
    
  	if ($validator instanceof sfValidatorAnd || $validator instanceof sfValidatorOr)
  	{
  	  return $this->buildPostValidators($validator->getValidators());
  	}
  	
  	if (is_array($validator))
  	{
  	  foreach ($validator as $val)
  	  {
  	  	$this->buildPostValidators($val);
  	  }
  	  
  	  return;
  	}
  	
	  $keys = array_map(create_function('$v', 'return \'%\'.$v.\'%\'; '), array_keys($this->labels));
	  foreach ($validator->getMessages() as $name => $message)
	  {
	    $updated_message = $validator->getMessage($name);
	    foreach ($validator->getOptions() as $option => $value)
	    {
	      $value = '';
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
  
  protected function getMessage($field, $msg)
  {
  	return str_replace('%field%', $this->labels[$field], $msg);
  }
  protected function getLabelFields($fields)
  {
  	$labels = array();
  	foreach ($fields as $field)
  	{
  	  if (isset($this->labels[$field]))
  	  {
  	    $labels[] = $this->labels[$field];
  	  }
  	  else
  	  {
  	  	$labels[] = $field;
  	  }
  	}
  	
  	return $labels;
  }
}
