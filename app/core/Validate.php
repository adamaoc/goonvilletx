<?php

class Validate {
  private $_passed = false,
          $_errors = array(),
          $_data = null;

  public function __construct()
  {
    $this->_data = new Data;
  }

  public function check($source, $items = array())
  {
    foreach($items as $item => $rules) {
      foreach ($rules as $rule => $ruleValue) {
        // echo "{$item} {$rule} must be {$ruleValue} <br />";
        $value = trim($source[$item]);
        $item = escape($item);
        if ($rule === 'required' && empty($value)) {
          $this->addError("{$item} is required");
        } else if (!empty($value)) {
          switch ($rule) {
            case 'min':
              if (strlen($value) < $ruleValue) {
                $this->addError("{$item} must be a minimum of {$ruleValue} characters.");
              }
              break;
            case 'max':
              if (strlen($value) > $ruleValue) {
                $this->addError("{$item} must be a maximum of {$ruleValue} characters.");
              }
              break;
            case 'unique':
              if (!empty($this->_data->getUser($value))) {
                $this->addError("The {$item} ({$value}) already exists.");
              }
              break;

            default:
              // code...
              break;
          }
        }
      }
    }

    if (empty($this->_errors)) {
      $this->_passed = true;
    }

    return $this;
  }

  private function addError($error)
  {
    $this->_errors[] = $error;
  }

  public function errors()
  {
    return $this->_errors;
  }

  public function passed()
  {
    return $this->_passed;
  }
}
