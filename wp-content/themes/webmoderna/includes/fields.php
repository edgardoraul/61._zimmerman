<?php
namespace Custom_Reg;

abstract class BaseField implements FieldInterface {

  protected function getType() {
    return isset( $this->type ) ? $this->type : 'text';
  }
  
  protected function getClass() {
    $type = $this->getType();
    if ( ! empty($type) ) return "{$type}-field";
  }
  
  public function getFilter() {
    return FILTER_SANITIZE_STRING;
  }
  
  public function isRequired() {
    return isset( $this->required ) ? $this->required : FALSE;
  }
  
  public function isValid( $value = NULL ) {
    if ( $this->isRequired() ) {
      return $value != '';
    }
    return TRUE;
  }
  
  public function create( $value = '' ) {
    $label = '<p><label>' . $this->getLabel() . '</label>';
    $format = '<input type="%s" name="%s" value="%s" class="%s"%s /></p>';
    $required = $this->isRequired() ? ' required' : '';
    return $label . sprintf(
      $format,
      $this->getType(), $this->getId(), $value, $this->getClass(), $required
    );
  }

  abstract function getLabel();
}


class FullName extends BaseField {

  protected $required = TRUE;
  
  public function getID() {
    return 'fullname';
  }
  
  public function getLabel() {
    return __( 'Full Name', 'custom_reg_form' );
  }

}

class Login extends BaseField {

  protected $required = TRUE;

  public function getID() {
    return 'login';
  }

  public function getLabel() {
    return __( 'Username', 'custom_reg_form' );
  }
}

class Email extends BaseField {

  protected $type = 'email';

  public function getID() {
    return 'email';
  }

  public function getLabel() {
    return __( 'Email', 'custom_reg_form' );
  }

  public function isValid( $value = NULL ) {
    return ! empty( $value ) && filter_var( $value, FILTER_VALIDATE_EMAIL );
  }
}

class Country extends BaseField {

  protected $required = FALSE;

  public function getID() {
    return 'country';
  }

  public function getLabel() {
    return __( 'Country', 'custom_reg_form' );
  }
}?>