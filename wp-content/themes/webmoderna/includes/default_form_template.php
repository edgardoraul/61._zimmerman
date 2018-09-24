<?php
get_header();

global $custom_reg_form_done, $custom_reg_form_error;

if ( isset( $custom_reg_form_done ) && $custom_reg_form_done ) {
  echo '<p class="success">';
  _e(
	  'Thank you, your registration was submitted, check your email.',
	  'custom_reg_form'
  );
  echo '</p>';
} else {
  if ( $custom_reg_form_error ) {
	  echo '<p class="error">' . $custom_reg_form_error  . '</p>';
  }
  do_action( 'custom_registration_form' );
}
get_sidebar();
get_footer();?>