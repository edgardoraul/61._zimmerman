<?php 
namespace Custom_Reg;

class Custom_Reg {

  protected $form;
  
  protected $saver;
  
  function __construct( Form $form, Saver $saver ) {
    $this->form = $form;
    $this->saver = $saver;
  }
  
  /**
   * Check if the url to recognize is the one for the registration form page
   */
  function checkUrl() {
    $url_part = $this->getUrl();
    $nonce = urlencode( wp_create_nonce( 'registration_url' ) );
    if ( ( $url_part === $nonce ) ) {
      // do nothing if registration is not allowed or user logged
      if ( is_user_logged_in() || ! get_option('users_can_register') ) {
        wp_safe_redirect( home_url() );
        exit();
      }
      return TRUE;
    }
  }
  
  /**
   * Init the form, if submitted validate and save, if not just display it
   */
  function init() {
    if ( $this->checkUrl() !== TRUE ) return;
    do_action( 'custom_reg_form_init', $this->form );
    if ( $this->isSubmitted() ) {
      $this->save();
    }
    // don't need to create form if already saved
    if ( ! isset( $custom_reg_form_done ) || ! $custom_reg_form_done ) {
      $this->form->create();
    }
    load_template( $this->getTemplate() );
    exit();
  }
  
  protected function save() {
	global $custom_reg_form_error;
	$this->saver->setFields( $this->form->getFields() );
	if ( $this->saver->validate() === TRUE ) { // validate?
	  if ( $this->saver->save() ) { // saved?
		global $custom_reg_form_done;
		$custom_reg_form_done = TRUE;
	  } else { // saving error
		$err =  $this->saver->getErrorMessage(); 
		$custom_reg_form_error = $err ? : __( 'Error on save.', 'custom_reg_form' );
	  }
	} else { // validation error
	   $custom_reg_form_error = $this->saver->getErrorMessage();
	}
  }
  
  protected function isSubmitted() {
    $type = $this->form->getVerb() === 'GET' ? INPUT_GET : INPUT_POST;
    $sub = filter_input( $type, 'custom_reg_form', FILTER_SANITIZE_STRING );
    return ( ! empty( $sub ) && $sub === get_class( $this->form ) );
  }
  
  protected function getTemplate() {
    $base = $this->form->getTemplate() ? : FALSE;
    $template = FALSE;
    $default = dirname( __FILE__ ) . '/default_form_template.php';
    if ( ! empty( $base ) ) {
      $template = locate_template( $base );
    }
    return $template ? : $default;
  }
  
   protected function getUrl() {
    $home_path = trim( parse_url( home_url(), PHP_URL_PATH ), '/' );
    $relative = trim( str_replace( $home_path, '', add_query_arg( array() ) ), '/' );
    $parts = explode( '/', $relative );
    if ( ! empty( $parts ) && ! isset( $parts[1] ) ) {
      return $parts[0];
    }
  }
}