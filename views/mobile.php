<?php
//Get from index.php, get_device_single_data function
$device_single_data=$device_single_data_resp['device_single_data'];
$device_id = $device_single_data['device_id'];
if($device_id>0) {
	$meta_title = $device_single_data['d_meta_title'];
	$meta_desc = $device_single_data['d_meta_desc'];
	$meta_keywords = $device_single_data['d_meta_keywords'];

	//$main_title = "SELL YOUR ".$device_single_data['device_title'];
	$main_sub_title = $device_single_data['device_sub_title'];
	$description = $device_single_data['description'];

	//Header section
	include("include/header.php");
} else {
	$main_title = ($active_page_data['show_title']?$active_page_data['title']:'');
	$main_sub_title = '';
	$description = $active_page_data['content'];
	/*if($active_page_data['image']) {
		$main_img = '<img class="image" src="'.SITE_URL.'images/pages/'.$active_page_data['image'].'" alt="'.$active_page_data['title'].'">';
	}*/
}

//Fetching data from model
require_once('models/mobile.php'); 

//missing device detail email send by nazcloak
if(isset($_POST['submit'])){

	if(!empty($_POST['brand']) && !empty($_POST['series']) && !empty($_POST['scrnsize']) && !empty($_POST['mobile']) && !empty($_POST['model']) && !empty($_POST['storage']) && !empty($_POST['name']) && !empty($_POST['email'])){

		//sanitize_data
		$brand = strip_tags($_POST['brand']);
		$series = strip_tags($_POST['series']);
		$scrnSize = strip_tags($_POST['scrnsize']);
		$mobile = strip_tags($_POST['mobile']);
		$model = strip_tags($_POST['model']);
		$storage = strip_tags($_POST['storage']);
		$name = strip_tags($_POST['name']);
		$email = strip_tags($_POST['email']);

		$emailBody = '<html>
		<head>
		<style>
			table {
				border: solid black 1px;
				min-width: 350px;
				max-width: 600px;
			}
			td{
				padding:px;
			}
		</style>
		</head>
		<body>
		<div style="margin-bottom:20px;">
		<p>Nombre del cliente: '.$name.'</p>
		<p>Correo electrónico del cliente: '.$email.'</p>
		<p>Número de teléfono móvil: '.$mobile.'</p>
		</div>
		<table>
		<tbody>
			<tr>
				<td>Marca</td>
				<td>: '.$brand.'</td>
			</tr>
			<tr>
				<td>Serie</td>
				<td>: '.$series.'</td>
			</tr>
			<tr>
				<td>Tamaño de pantalla</td>
				<td>: '.$scrnSize.'</td>
			</tr>
			<tr>
				<td>Modelo</td>
				<td>: '.$model.'</td>
			</tr>
			<tr>
				<td>Almacenamiento</td>
				<td>: '.$storage.'</td>
			</tr>
			<tr>
				<td>Nombre</td>
				<td>: '.$name.'</td>
			</tr>
			<tr>
				<td>Email</td>
				<td>: '.$email.'</td>
			</tr>
		</tbody>
		</body></html>';
		$from = 'info@tasaciones-labrujita.online';
		//email filter sanitize
		$email = filter_var($email, FILTER_SANITIZE_EMAIL);
		if(!empty($email)){
			$to_email = 'hola@tasaciones-labrujita.online';
			$subject ='Solicitud de cliente de Cashmovil Dispositivo no listado';
			$message =  $emailBody;//'This mail is sent using the PHP mail function';
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
			$headers .='From: '.$from."\r\n".
			'Reply-To: '.$from."\r\n" .
			'X-Mailer: PHP/' . phpversion();
			mail($to_email,$subject,$message,$headers);
			//mail('nazcloak@gmail.com',$subject,$message,$headers);
			$formsubmit = 1;
		}else{
			$formsubmit = 'e1';
		}
	}else{
		$formsubmit = 'e2';
	}

} 

if(isset($_POST['submit'])){ ?>
	<div class="container">
		<div class="row">
			<div class="col">
				<div class="alert <?= ($formsubmit==1) ? 'alert-success':'alert-danger'; ?> alert-dismissible fade show" role="alert">
					<?= ($formsubmit==1) ? '<strong>formulario enviado con éxito.</strong> nos pondremos en contacto con usted pronto' : 'el envío del formulario falló. intente nuevamente si el error persiste, comuníquese con nosotros <a href="mailto:hola@tasaciones-labrujita.online">hola@tasaciones-labrujita.online</a>'; ?>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			</div>
		</div>
	</div>
<?php } ?>

  <section id="tell_us_phone" class="isok">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="block text-center tell-us-phone clearfix">
            <h1 class="h1 border-line"><?php echo $LANG["SELL YOUR "].$device_single_data['device_title'];?><!--Sell Your Phone--></h1>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="block brands pt-0 mt-0 pb-5 clearfix">
            <ul class="box-styled clearfix">
			<?php
			$brand_data_list = get_device_brands_data_list($device_id);
			if(count($brand_data_list)>1) {
				foreach($brand_data_list as $brand_data) { ?>
				  <li>
					<a href="<?=SITE_URL.$brand_data['device_sef_url'].'/'.$brand_data['brand_sef_url']?>">
						<?php
						if($brand_data['brand_img']) {
							$md_img_path = SITE_URL.'libraries/phpthumb.php?imglocation='.SITE_URL.'images/brand/'.$brand_data['brand_img'].'&h=150';
							echo '<div class="brand-image"><img src="'.$md_img_path.'" alt="'.$brand_data['brand_title'].'"></div>';
						} ?>
					  <h6 class="h6"><?=$brand_data['brand_title']?></h6>
					  <!--<p class="price">CASH IN UP TO $00</p>-->
					</a>
				  </li>
				<?php
				}
			} else {
				
				//Get data from models/mobile.php, get_model_data_list function
				$model_data_list = get_model_data_list($device_id, $devices_id, $cat_id);
				if(count($model_data_list)>0) {
					foreach($model_data_list as $model_list) { ?>
					  <li>
						<a href="<?=SITE_URL.$model_list['device_sef_url'].'/'.createSlug($model_list['title']).'/'.$model_list['id']?>">
							<?php
							if($model_list['model_img']) {
								$md_img_path = SITE_URL.'libraries/phpthumb.php?imglocation=https://tasaciones-labrujita.online/images/mobile/'.$model_list['model_img'].'&h=150';
								echo '<div class="brand-image"><img src="'.$md_img_path.'" alt="'.$model_list['title'].'"></div>';
							} ?>
						  <h6 class="h6"><?=$model_list['title']?></h6>
						  <!--<p class="price">CASH IN UP TO $00</p>-->
						</a>
					  </li>
					<?php
					}

					//START missing product section & quote request email...
					//echo 'hello sire';
					if($general_setting_data['missing_product_section']=='1') { ?>
					  <li>
						<a href="javascript:void(0);" data-toggle="modal" data-target="#MissingProduct">
						  <div class="brand-image"><img src="<?=SITE_URL.'libraries/phpthumb.php?imglocation=https://tasaciones-labrujita.online/images/iphone.png&h=150'?>" alt="Missing Product"></div>
						  <h6 class="h6"><?php echo $LANG['I dont see my Device']; ?></h6>
						  <p class="price"><?php echo $LANG['Missing Product']; ?></p>
						</a>
					  </li>
						
						<div class="editAddress-modal modal fade" id="MissingProduct" tabindex="-1" role="dialog" aria-labelledby="locationModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
							  <div class="modal-content">
								<div class="modal-header">
								  <h5 class="modal-title" id="locationModalLabel"><?php echo $LANG['Quote Request']; ?></h5>
								  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								  </button>
								</div>
								<form method="post" action="<?=SITE_URL?>controllers/mobile.php" id="req_quote_form">
									<div class="modal-body">
										<h2><?php echo $LANG['Can’t Find Your Item?']; ?></h2>
										<p><?php echo $LANG['If you want to find out how much your item is worth, please fill out the form below and we will reply to your email within 24 hours. Remember, the more information you include about the item(s) you are trying to sell, the easier it is for us to make you an offer. Please fill out a good contact number and email address in case we need to ask you a few more questions.']; ?></p>
										<div class="form-group">
											<input type="text" name="name" id="name" placeholder="<?php echo $LANG['Enter name']; ?>" class="form-control" />
										</div>
										<div class="form-group">
											<input type="tel" id="cell_phone" name="cell_phone" class="form-control" placeholder="">
											<input type="hidden" name="phone" id="phone" />
										</div>
										<div class="form-group">
											<input type="text" name="email" id="email" placeholder="<?php echo $LANG['Enter email']; ?>" class="form-control" />
										</div>
										<div class="form-group">
											<input type="text" name="item_name" id="item_name" placeholder="<?php echo $LANG['Enter name of your item']; ?>" class="form-control" />
										</div>
										<div class="form-group">
											<textarea name="message" id="message" placeholder="<?php echo $LANG['Enter message']; ?>" class="form-control"></textarea>
										</div>
										<?php
										if($missing_product_form_captcha == '1') { ?>
											<div class="form-group">
												<div id="g_form_gcaptcha"></div>
												<input type="hidden" id="g_captcha_token" name="g_captcha_token" value=""/>
											</div>
										<?php
										} ?>
									</div>
									<div class="modal-footer">
										<button type="submit" class="btn btn-primary"><?php echo $LANG['Submit']; ?></button>
										<input type="hidden" name="missing_product" id="missing_product" />
										<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $LANG['Close']; ?></button>
									</div>
								</form>
							  </div>
							</div>
						</div>
			
						<script>
						<?php
						if($missing_product_form_captcha == '1') { ?>
						var CaptchaCallback = function() {
							if(jQuery('#g_form_gcaptcha').length) {
								grecaptcha.render('g_form_gcaptcha', {
									'sitekey' : '<?=$captcha_key?>',
									'callback' : onSubmitForm,
								});
							}
						};
						
						var onSubmitForm = function(response) {
							if(response.length == 0) {
								jQuery("#g_captcha_token").val('');
							} else {
								//$(".sbmt_button").removeAttr("disabled");
								jQuery("#g_captcha_token").val('yes');
							}
						};
						<?php
						} ?>
													
						(function( $ ) {
							$(function() {
								var telInput = $("#cell_phone");
								telInput.intlTelInput({
								  initialCountry: "auto",
								  geoIpLookup: function(callback) {
									$.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
									  var countryCode = (resp && resp.country) ? resp.country : "";
									  callback(countryCode);
									});
								  },
								  utilsScript: "<?=SITE_URL?>js/intlTelInput-utils.js" //just for formatting/placeholders etc
								});
			
								// on keyup / change flag: reset
								telInput.on("keyup change", reset);
							});
						})(jQuery);
			
						(function( $ ) {
							$(function() {
								$('#req_quote_form').bootstrapValidator({
									fields: {
										name: {
											validators: {
												stringLength: {
													min: 1,
												},
												notEmpty: {
													message: 'Please enter name'
												}
											}
										},
										cell_phone: {
											validators: {
												callback: {
													message: 'Please enter valid phone number',
													callback: function(value, validator, $field) {
														var telInput = $("#cell_phone");
														$("#phone").val(telInput.intlTelInput("getNumber"));
														if(!telInput.intlTelInput("isValidNumber")) {
															return false;
														} else if(telInput.intlTelInput("isValidNumber")) {
															return true;
														}
													}
												}
											}
										},
										email: {
											validators: {
												notEmpty: {
													message: 'Please enter email address'
												},
												emailAddress: {
													message: 'Please enter valid email address'
												}
											}
										},
										item_name: {
											validators: {
												notEmpty: {
													message: 'Please enter item name'
												}
											}
										},
										message: {
											validators: {
												notEmpty: {
													message: 'Please enter your message'
												}
											}
										}
									}
								}).on('success.form.bv', function(e) {
									$('#req_quote_form').data('bootstrapValidator').resetForm();
			
									// Prevent form submission
									e.preventDefault();
			
									// Get the form instance
									var $form = $(e.target);
			
									// Get the BootstrapValidator instance
									var bv = $form.data('bootstrapValidator');
			
									// Use Ajax to submit form data
									$.post($form.attr('action'), $form.serialize(), function(result) {
										console.log(result);
									}, 'json');
								});
							});
						})(jQuery);
						</script>
					<?php } 
				} //END missing product section & quote request email...
				else { ?>
					<div class="text-center">
					  <div class="h3"><?php echo $LANG['Model not available']; ?></div>
					</div>
				<?php
				}
			} ?>

            </ul>
			<button class="btn btn-outline-danger btn-lg rounded mx-auto d-block mt-5" data-toggle="modal" data-target="#noDevice">¿No encuentras tu dispositivo?</button>
			<!-- Cashmovil no device found modal -->

				<!-- Modal -->
			<div class="modal fade" id="noDevice" data-keyboard="false" tabindex="-1" aria-labelledby="noDeviceLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered modal-xl">
					<div class="modal-content">
						<div class="modal-header text-light bg-primary-g">
							<p class="modal-title" id="noDeviceLabel">no puedo encontrar tu dispositivo</p>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<h4 class="modal-title text-left font-weight-bolder mb-3">Cuéntanos más sobre tu dispositivo.</h4>
							<form action="" method="post">
								<div class="form-row">
									<div class="col-12 col-lg-6 px-sm-3">
										<div class="mb-3">
											<label for="brand">Marca<span class="text-danger">*</span></label>
											<input class="form-control d-block" type="text" name="brand" id="" value="" required>
										</div>
										<div class="mb-3">
											<label for="series">Serie<span class="text-danger">*</span></label>
											<input class="form-control d-block" type="text" name="series" id="" value="" required>
										</div>
										<div class="mb-3">
											<label for="scrnsize">Tamaño de pantalla<span class="text-danger">*</span></label>
											<input class="form-control d-block" type="text" name="scrnsize" id="" value="" required>
										</div>
										<div class="mb-3">
											<label for="model">Número de teléfono móvil<span class="text-danger">*</span></label>
											<input class="form-control d-block" type="tel" name="mobile" id="" value="" required>
										</div>
									</div>
									<div class="col-12 col-lg-6 px-sm-3">
										<div class="mb-3">
											<label for="model">Modelo<span class="text-danger">*</span></label>
											<input class="form-control d-block" type="text" name="model" id="" value="" required>
										</div>
										<div class="mb-3">
											<label for="storage">Almacenamiento<span class="text-danger">*</span></label>
											<input class="form-control d-block" type="text" name="storage" id="" value="" required>
										</div>
										<div class="mb-3">
											<label for="name">Nombre<span class="text-danger">*</span></label>
											<input class="form-control d-block" type="text" name="name" id="" value="" required>
										</div>
										<div class="mb-3">
											<label for="model">Correo electrónico<span class="text-danger">*</span></label>
											<input class="form-control d-block" type="email" name="email" id="" value="" required>
										</div>
									</div>
									<div class="col-12 col-lg-6 px-sm-3 mb-3">
										<label for="model"><input type="checkbox" name="agree" id="" value="" required> Acepto los términos y condiciones<span class="text-danger">*</span></label>
									</div>
									<div class="col-12 px-sm-3">
										<button class="btn btn-lg btn-primary" type="submit" name="submit">enviar</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="about" class="pb-5 white-sec">
    <div class="container">
      <div class="row">
        <div class="col-md-8">
          <div class="block about-head pt-4 mt-5 mb-4 pb-4 clearfix">
            <div class="row">
              <div class="col-md-5">
                <!-- <img src="images/about.jpg" alt=""> -->
                <h1 class="text-uppercase text-center rating-head border-line"><?php echo $LANG['RATINGS']; ?></h1>
               <!--  <ul class="about_brand_logo clearfix">
                 <li>
                    <a target="_blank" href="https://offerup.co/profile/oneguygadget">
                      <img src="https://tasaciones-labrujita.online/images/offer-up.png" alt=""><br />
                      <span><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span>
                    </a>
                  </li>
                  <li>
                    <a target="_blank" href="https://www.5miles.com/s/1GuyGadget">
                      <img src="https://tasaciones-labrujita.online/images/5smile.png" alt=""><br />
                      <span><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span>
                    </a>
                  </li>
                  <li>
                    <a target="_blank" href="#">
                      <img src="<?=SITE_URL?>images/box_home.png" alt=""><br />
                      <span><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span>
                    </a>
                  </li>
                  <li>
                    <a target="_blank" href="https://letgo.onelink.me/O2PG?pid=af_app_invites&c=user-profile&af_siteid=web&af_channel=link&position=bottom&utm_medium=link&utm_source=web&utm_campaign=user-profile&af_sub4=bottom&af_web_dp=https%3A%2F%2Fus.letgo.com%2Fen%2Fu%2F1guygadget-llc_f0dbfe8e-a674-435f-b643-7fa680bc30b0&af_channel=link&utm_source=web&utm_campaign=user-profile&utm_content=button_bottom">
                      <img src="<?=SITE_URL?>images/letgo.png" alt=""><br />
                      <span><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span>
                    </a>
                  </li>
                </ul>-->
                <p class="text-center"><a class="trust_pilot" href="https://www.trustpilot.com"><img class="trust_pilot" src="https://tasaciones-labrujita.online/images/Trustpilot_logo.png" alt=""></a></p>
              </div>
              <div class="col-md-7">
			  	<?php
				$home_p_data = get_inbuild_page_data('home');
				if($home_p_data['title'] && $home_p_data['show_title'] == '1') {
				  echo '<div class="h1 border-line">'.$home_p_data['title'].'</div>';
				}
				if($home_p_data['content']) {
				  echo $home_p_data['content'];
				} ?>
                <?php /*?><div class="h1 border-line"><?=$main_sub_title?></div>
				<?=$description?><?php */?>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="block about-why pt-4 mt-5 mb-4 pb-4 clearfix">
            <div class="h1 border-line"><?php echo $LANG['WHY US']; ?></div>
            <ul>
              <li>
                <img src="https://tasaciones-labrujita.online/images/wepayfirst.png" alt="" class="pa-ws"><br />
                <div class="yel-line"></div>
                <p><?php echo $LANG['We Pay Fast']; ?></p>
              </li>
              <li>
                <img src="https://tasaciones-labrujita.online/images/bestoffer.png" alt="" class="pa-ws"><br />
                <div class="yel-line"></div>
                <p><?php echo $LANG['Best offer']; ?></p>
              </li>
              <li>
                <img src="https://tasaciones-labrujita.online/images/trust.png" alt=""><br />
                <!-- <div class="yel-line"></div> -->
                <!-- <p>Trust</p> -->
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>