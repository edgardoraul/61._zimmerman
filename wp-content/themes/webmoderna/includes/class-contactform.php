<?php
/**
 * This is a class that implements a basic Contact Form for WordPress 2.8+
 * @author Julio Flores <contacto@jfastudios.com> Twitter: @JulioRFA
 * @version 0.1
 * @since Wordpress 2.8+
 *
 * http://jfastudios.com
 * 
 */

class ContactForm
{
	//Private properties
	private $id;
	private $keywords = array('%name%','%email%','%message%','%bloginfo%');
	
	//Public properties
	public $captcha;
	public $honeypot;
	public $name;
	public $email;
	public $telephone;
	public $ciudad;
	public $provincia;
	public $personas;
	public $fechaIn;
	public $fechaOut;
	public $message;
	public $copy;
	public $config = array(
			'setCaptcha'	=> true,
			'setHoneypot'	=> true,
			'setSendCopy'	=> true
			);
	public $fields = array(
			'name'		=> 'contactName',
			'email'		=> 'contactEmail',
			'telephone'	=> 'phone', // Por mi
			'ciudad' 	=> 'contactCiudad', // Por mi
			'provincia' => 'contactProvincia', // Por mi
			'personas'	=> 'contactPersonas', // Por mi
			'fechaIn'	=> 'dateIn', // Por mi
			'fechaOut'	=> 'dateOut', // Por mi


			'message'	=> 'contactMessage',
			'copy'		=> 'sendCopy',
			'captcha'	=> 'cCode',
			'honeypot'	=> 'ageCheck'
			);
	public $errors = array();
	public $error_description = array(
			'Codigo inválido', #captcha [0]
			'Este campo no debe ser llenado', #honeypot
			'Olvidaste escribir tu nombre', #name
			'Olvidaste escribir tu email', #email
			'Esta dirección email no es válida', #email
			'Olvidaste escribir tu mensaje', #message
			);

	public function __construct($config = '', $fromPOST = true)
	{
		if(is_array($config))
		{
			$this->config = $config;
		}
		
		if(isset($_SESSION['contactFormId']))
		{
			$this->id = $_SESSION['contactFormId'];
		}
		else if(function_exists('the_ID'))
		{
			$this->id = get_the_ID();
			$_SESSION['contactFormId'] = $this->id;
		}

		$this->run($fromPOST);

	} #end __constructor()

	public function send()
	{
		//Include libraries PhpMailer & SMTP from WP directory "wp-include"
		include_once ABSPATH . WPINC . '/class-phpmailer.php';
		include_once ABSPATH . WPINC . '/class-smtp.php';
		$replace = array($this->name, $this->email, $this->telephone, $this->message, get_bloginfo());

		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPAuth	= true;
		$mail->SMTPSecure = "ssl";
		$mail->Host			= get_post_meta($this->id, "mailHost", true); #smtp.domain.com
		$mail->Port			= get_post_meta($this->id, "mailPort", true); #25/465 (port)
		$mail->Username	= get_post_meta($this->id, "mailUsername", true); #contact@yourdomain.com
		$mail->Password	= get_post_meta($this->id, "mailPassword", true); #password

		$mail->From			= get_post_meta($this->id, "mailFrom", true); #from@yourdomain.com
		$mail->FromName	= str_replace($this->keywords, $replace, get_post_meta($this->id, "mailFromName", true)); #Display name
		$mail->Subject		= str_replace($this->keywords, $replace, get_post_meta($this->id, "mailSubject", true)); #Subject
		$mail->AltBody		= str_replace($this->keywords, $replace, get_post_meta($this->id, "mailText", true)); #Plain text email

		$mail->MsgHTML(str_replace($this->keywords, $replace, get_post_meta($this->id, "mailHTML", true))); #HTML email
		$mail->AddBCC(get_post_meta($this->id, "mailUsername", true), get_bloginfo());

		if($this->sendCopy == true)
			$mail->AddAddress($this->email, $this->name);

		$mail->AddReplyTo($this->email, $this->name);
		//Tells PHPMailer we'll send html format email
		$mail->IsHTML(true);
		$mail->AddCustomHeader('Mime-Version: 1.0\r\n');

		return $mail->Send();
	}

	public function validate($fromPOST = true)
	{
		if($fromPOST)
		{
			if(isset($_POST['cf_submitted']))
			{
				$this->name			= $_POST[ $this->fields['name'] ];
				$this->email		= $_POST[ $this->fields['email'] ];
				$this->telephone	= $_POST[ $this->fields['telephone'] ];
				$this->ciudad		= $_POST[ $this->fields['ciudad'] ];
				$this->provincia	= $_POST[ $this->fields['provincia'] ];
				$this->personas		= $_POST[ $this->fields['personas'] ];
				$this->fechaIn		= $_POST[ $this->fields['fechaIn'] ];
				$this->fechaOut		= $_POST[ $this->fields['fechaOut'] ];
				$this->message		= $_POST[ $this->fields['message'] ];
				$this->sendCopy		= ($_POST[ $this->fields['copy'] ]) ? true:false;
				$this->captcha		= $_POST[ $this->fields['captcha'] ];
				$this->honeypot		= $_POST[ $this->fields['honeypot'] ];
			}
			else
				//POST data not sent (first load)
				return false;
		}
		//Validate CAPTCHA if avalible
		if($this->config['setCaptcha'])
		{
			$directory = dirname(__FILE__);
			include_once $directory . '/securimage/securimage.php';
			//Crea el objeto Securimage
			$securimage = new Securimage();
			if (false == $securimage->check($this->captcha))
			{
				$this->errors['captcha'] = $this->error_description[0];
			}
		}

		//Validate the honeypot is empty, if not, we got a BOT!. If avalible
		if($this->config['setHoneypot'])
		{
			if ($this->honeypot != '')
			{
				$this->errors['honeypot'] = $this->error_description[1];
			}
		}
		//Check if name is empty
		if ( $this->name === '')
		{
			$this->errors['name'] = $this->error_description[2];
		}
		else
			//Clean the name
			$this->name = htmlspecialchars(trim($_POST['contactName']));

		//Check for valid email
		if ($this->email === '')
		{
			$this->errors['email'] = $this->error_description[3];
		}
		else if (!is_email($this->email))
		{
			$this->errors['email'] = $this->error_description[4];
		}

		//Check for a message
		$this->message = trim($this->message);

		if ($this->message === '') {
			$this->errors['message'] = $this->error_description[5];
		}
		else
		{
			//Clean the message
			$this->message = htmlspecialchars($this->message);
		}
		
		return empty($this->errors);
	} #end validate
	
	public function printForm()
	{
		//print the post content
		the_content();
?>
		<form class="hform formulario" action="<?php the_permalink(); ?>" id="contactForm" method="post" accept-charset="iso-8859-1">
			<h4><?php _e('Haga su consulta', 'casaflor');?></h4>

			<p>
				<input type="text" name="<?php echo $this->fields['name'] ?>" id="<?php echo $this->fields['name'] ?>" value="<?php echo $this->name ?>" class="required" placeholder="<?php _e('Apellido y Nombre', 'casaflor');?>" required />
				<?php if( isset($this->errors['name']) ): ?>
				<span class="error"><?php echo $this->errors['name'] ?></span>
				<?php endif; ?>
			</p>
			<p>
				<input type="email" name="<?php echo $this->fields['email'] ?>" id="<?php echo $this->fields['email'] ?>" value="<?php echo $this->email ?>" class="required email" placeholder="E-Mail" required />
				<?php if( isset($this->errors['email']) ): ?>
				<span class="error"><?php echo $this->errors['email'] ?></span>
				<?php endif; ?>
			</p>

			<p>
				<input type="tel" name="<?php echo $this->fields['telephone'] ?>" id="<?php echo $this->fields['telephone'] ?>" value="<?php echo $this->telephone ?>" class="required telephone" placeholder="Teléfono" required />
				<?php if( isset($this->errors['telephone']) ): ?>
				<span class="error"><?php echo $this->errors['telephone'] ?></span>
				<?php endif; ?>
			</p>
			<p>
				<input type="text" name="<?php echo $this->fields['ciudad'] ?>" id="<?php echo $this->fields['ciudad'] ?>" value="<?php echo $this->ciudad ?>" class="required ciudad" placeholder="Ciudad" />
				<?php if( isset($this->errors['ciudad']) ): ?>
				<span class="error"><?php echo $this->errors['ciudad'] ?></span>
				<?php endif; ?>
			</p>
			<p>
				<input type="text" name="<?php echo $this->fields['provincia'] ?>" id="<?php echo $this->fields['provincia'] ?>" value="<?php echo $this->provincia ?>" class="required provincia" placeholder="Provincia" />
				<?php if( isset($this->errors['provincia']) ): ?>
				<span class="error"><?php echo $this->errors['provincia'] ?></span>
				<?php endif; ?>
			</p>
			<p>
				<label for="personas">Cantidad de Personas:</label>
				<input type="number" min="0" max="99" name="<?php echo $this->fields['personas'] ?>" id="<?php echo $this->fields['personas'] ?>" value="<?php echo $this->personas ?>" class="required personas" required />
				<?php if( isset($this->errors['personas']) ): ?>
				<span class="error"><?php echo $this->errors['personas'] ?></span>
				<?php endif; ?>
			</p>
			<p>
				<label for="fechaIn">Fecha de ingreso:</label>
				<input type="date" name="<?php echo $this->fields['fechaIn'] ?>" id="<?php echo $this->fields['fechaIn'] ?>" value="<?php echo $this->fechaIn ?>" class="datepicker required fechaIn" required />
				<?php if( isset($this->errors['fechaIn']) ): ?>
				<span class="error"><?php echo $this->errors['fechaIn'] ?></span>
				<?php endif; ?>
			</p>
			<p>
				<label for="fechaOut">Fecha de egreso:</label>
				<input type="date" name="<?php echo $this->fields['fechaOut'] ?>" id="<?php echo $this->fields['fechaOut'] ?>" value="<?php echo $this->fechaOut ?>" class="datepicker required fechaOut" required />
				<?php if( isset($this->errors['fechaOut']) ): ?>
				<span class="error"><?php echo $this->errors['fechaOut'] ?></span>
				<?php endif; ?>
			</p>

			<p>
				<textarea name="<?php echo $this->fields['message'] ?>" id="<?php echo $this->fields['message'] ?>" class="requiredField" rows="6" placeholder="<?php _e('Mensaje', 'casaflor');?>" required><?php echo $this->message ?></textarea>
				<?php if( isset($this->errors['message']) ): ?>
				<span class="error"><?php echo $this->errors['message'] ?></span>
				<?php endif; ?>
			</p>

			<?php if($this->config['setSendCopy']): ?>
			
			<p class="screenReader">
				<!-- <input type="checkbox" name="<?php //echo $this->fields['copy'] ?>" id="<?php //echo $this->fields['copy'] ?>" value="true" <?php //echo ($this->copy) ? 'checked="checked"': '' ?> /> -->
				<input type="checkbox" name="<?php echo $this->fields['copy'] ?>" id="<?php echo $this->fields['copy'] ?>" value="true" checked="checked" />
				<label for="<?php echo $this->fields['copy'] ?>">Enviar una copia a tu email.</label>
			</p>
			<?php endif; ?>
			<?php if($this->config['setHoneypot']): ?>
			
			<p class="screenReader">
				<label for="<?php echo $this->fields['honeypot'] ?>" class="screenReader">Para enviar tu mensaje no llenes este campo</label><br />
				<input type="text" name="<?php echo $this->fields['honeypot'] ?>" id="<?php echo $this->fields['honeypot'] ?>" class="screenReader" value="<?php echo $this->honeypot ?>" />
			</p>
			
			<?php endif; ?>
			<?php if($this->config['setCaptcha']): ?>
			
			<p>
				<label for="<?php echo $this->fields['captcha'] ?>"><?php _e('Escribe el código siguiente:', 'casaflor');?></label><br />
				<img id="<?php echo $this->fields['captcha'] ?>-img" src="<?php bloginfo('template_url'); ?>/includes/securimage/securimage_show.php" alt="code" /><br /><br />
				<a class="boton orange" title="<?php _e('Recargar código', 'casaflor');?>" href="#" onclick="document.getElementById('<?php echo $this->fields['captcha'] ?>-img').src = '<?php bloginfo('template_url'); ?>/includes/securimage/securimage_show.php?' + Math.random(); return false"><i class="icon-loop2"> </i><?php //_e('Recargar código', 'casaflor');?></a><br />
				
				<input type="text" name="<?php echo $this->fields['captcha'] ?>" id="<?php echo $this->fields['captcha'] ?>" size="6" maxlength="6" required placeholder="<?php _e('Introducir código aquí');?>" /><br />
				<?php if( isset($this->errors['captcha']) ): ?>
				<span class="error"><?php echo $this->errors['captcha'] ?></span>
				<?php endif; ?>
			</p>
			
			<?php endif; ?>
			
			<p>
				<input type="hidden" name="cf_submitted" id="submitted" value="true" />
				<button type="submit" class="green gradient" name="submit"><i class="icon-checkmark-circle"> </i><?php _e('Enviar', 'casaflor');?></button>
				<button type="reset" class="orange gradient"><i class="icon-cancel-circle"> </i><?php _e('Limpiar', 'casaflor');?></button>
			</p>
		</form>
<?php
	} #end printForm

	public function printSuccessMessage()
	{
		$replace = array($this->name, $this->email, $this->message, get_bloginfo());
		echo str_replace($this->keywords, $replace, get_post_meta($this->id, "successMessage", true));
	}

	public function printFailMessage()
	{
		$replace = array($this->name, $this->email, $this->message, get_bloginfo());
		echo str_replace($this->keywords, $replace, get_post_meta($this->id, "failMessage", true));
	}

	public function run($fromPOST = true)
	{
		//If no data or invalid, print the contact form
		if(!$this->validate($fromPOST))
		{
			$this->printForm();
		}
		else
		{
			//Valid data, send the email, if success print message, else print fail
			if($this->send())
				$this->printSuccessMessage();
			else
				$this->printFailMessage();
		}

	}
} #end class