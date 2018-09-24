<?php 
namespace Custom_Reg;

interface FieldInterface {
  
  /**
   * Return the field id, used to name the request value and for the 'name' param of
   * html input field
   */
  public function getId();

  /**
   * Return the filter constant that must be used with
   * filter_input so get the value from request
   */
  public function getFilter();

  /**
   * Return true if the used value passed as argument should be accepted, false if not
   */
  public function isValid( $value = NULL );

  /**
   * Return true if field is required, false if not
   */
  public function isRequired();

  /**
   * Return the field input markup. The 'name' param must be output 
   * according to getId()
   */
  public function create( $value = '');};?>