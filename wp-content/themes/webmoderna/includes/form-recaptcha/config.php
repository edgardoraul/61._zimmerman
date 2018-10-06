<?php 
/*
	+-----------------------------------------------------+
	|* BY: GABRIEL CHAVEZ        (2018)             |
	|* SITE: https://gabrielchavez.me
	|* CONTACT: contacto@gabrielchavez.me							    |
	+-----------------------------------------------------+
	*/
	// INFORMACION DEL ENVIADOR
	// Definición de variables
	$host           = 'cz000021.ferozo.com';
	$senderEmail    = "espam@webmoderna.com.ar";
	$senderPassword = "Muerte77";
	$logo_uploader 	= of_get_option('logo_uploader', '');

	// INFORMACION DEL QUE RECIBE EL MENSAJE
	$receiverName   = get_bloginfo('name');
	$receiver       = "info@zimm.com.ar";
	//
	/*
	+-----------------------------------------------------+
	| PARAMETROS DE CONFIGURACION PARA GOOGLE RECAPTCHA                        |
	+-----------------------------------------------------+
	*/
	$yoursecretkey  = "6Lcbt3IUAAAAAMt_ZZogY94nb3CzK1SPMTZ0lfnd";
	$yourpublickey  = "6Lcbt3IUAAAAAECvTE-RJnSsgO-LeTAOhipQBe8t";
	//
	/*
	+-----------------------------------------------------+
	| YOUR CATEGORY FROM DATABASE                        |
	+-----------------------------------------------------+
	*/
?>
