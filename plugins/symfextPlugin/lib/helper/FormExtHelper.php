<?php

/**
 * FormExtHelper
 *
 * @package    symfext
 * @subpackage helper
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */

function input_tag($name, $value = null, $attributes = array(), $errors = array())
{
  $input = new sfWidgetFormInput();
  return $input->render($name, $value, $attributes, $errors);
}

function input_hidden_tag($name, $value = null, $attributes = array(), $errors = array())
{
  $input = new sfWidgetFormInputHidden();
  return $input->render($name, $value, $attributes, $errors);
}

function input_date_tag($name, $value = null, $options = array(), $attributes = array(), $errors = array())
{
  $input = new sfWidgetFormDate($options);
  return $input->render($name, $value, $attributes, $errors);
}

function input_filter_tag($name, $value = null, $attributes = array(), $errors = array())
{
  $value = $value == '0' ? '' : get_filter_from_url($value);
  return input_tag($name, $value, $attributes, $errors);
}

function select_tag($name, $choices, $selected = null, $attributes = array(), $errors = array())
{
  $select = new sfWidgetFormSelect(array('choices' => $choices));
  return $select->render($name, $selected, $attributes, $errors);
}

function checkbox_tag($name, $value = '1', $checked = false, $attributes = array(), $errors = array())
{
  $chkbox = new sfWidgetFormInputCheckbox();
  return $chkbox->render($name, $value, $attributes, $errors);
}

function radiobutton_tag($name, $choices, $selected = null, $attributes = array(), $options = array(), $errors = array())
{
  $radio = new sfWidgetFormSelectRadio(array('choices' => $choices) + $options);
  return $radio->render($name, $selected, $attributes, $errors);
}
