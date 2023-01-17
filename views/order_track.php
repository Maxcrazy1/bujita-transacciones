<?php
$order_id = $_SESSION['track_order_id'];
$order_data = get_order_data($order_id);
if($order_id!="") {
	unset($_SESSION['track_order_id']);
}

$error_message = $_SESSION['error_message'];
if($error_message!="") {
	unset($_SESSION['error_message']);
}

//Header Image
if($active_page_data['image'] != "") {
	if($active_page_data['image_text'] != "") {
		echo '<h2>'.$active_page_data['image_text'].'</h2>';
	}
	echo '<img src="'.SITE_URL.'images/pages/'.$active_page_data['image'].'" alt="'.$active_page_data['title'].'" width="100%">';
}

if(!empty($order_data)) { ?>
  <section>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="block head pb-0 mb-0 border-line text-center clearfix">
            <h1 class="h1 border-line clearfix">Sistema de Localizacion</h1>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="block text-center tracking-status clearfix">
            <h2>OFERTA #<?=$order_data['order_id']?></h2>
            <!-- SVG Icon start -->
            <!-- <object type="image/svg+xml" data="images/tracking_icons/Awaiting Shipment.svg" class="icon"></object> -->
            <!-- <object type="image/svg+xml" data="images/tracking_icons/Shipped.svg" class="icon"></object> -->
            <!-- <object type="image/svg+xml" data="images/tracking_icons/Cancelled.svg" class="icon"></object> -->
            <!-- <object type="image/svg+xml" data="images/tracking_icons/Completed.svg" class="icon"></object> -->
            <!-- <object type="image/svg+xml" data="images/tracking_icons/Expired.svg" class="icon"></object> -->
            <!-- <object type="image/svg+xml" data="images/tracking_icons/Problem.svg" class="icon"></object> -->
            <!-- <object type="image/svg+xml" data="images/tracking_icons/Processing.svg" class="icon"></object> -->
            <!-- <object type="image/svg+xml" data="images/tracking_icons/Shipped.svg" class="icon"></object> -->
            <!-- //SVG Icon start -->
            
            <!-- PNG icon Start -->
			<?php
			$desc = "";
			$order_status = $order_data['status'];
			if($order_status == "awaiting_shipment") {
            	echo '<img src="images/tracking_icons/png/Awaiting Shipment.png" class="icon" alt="Awaiting Shipment">';
				$desc = "Su etiqueta de envio prepagada aun debe ser escaneada en la oficina de correos.";
			}
			if($order_status == "cancelled") {
           		echo '<img src="images/tracking_icons/png/Cancelled.png" class="icon" alt="Cancelled">';
				$desc = "Su oferta fue cancelada.";
			}
			if($order_status == "completed") {
            	echo '<img src="images/tracking_icons/png/Completed.png" class="icon" alt="Completed">';
				$desc = "Su oferta ha sido pagada.";
			}
			if($order_status == "delivered") {
            	echo '<img src="images/tracking_icons/png/Delivered.png" class="icon" alt="Delivered">';
				$desc = "Su(s) dispositivo(s) ha(n) sido recibido(s) en nuestra oficina y el procesamiento comenzara en breve.";
			}
			if($order_status == "expired") {
            	echo '<img src="images/tracking_icons/png/Expired.png" class="icon" alt="Expired">';
				$desc = "Su(s) dispositivo(s) no fue(n) recibido(s) 21 dias despues de haber hecho una oferta.";
			}
			if($order_status == "problem") {
            	echo '<img src="images/tracking_icons/png/Problem.png" class="icon" alt="Problem">';
				$desc = "Su oferta requiere una revision inmediata. Nos pondremos en contacto con usted en breve.";
			}
			if($order_status == "processing") {
            	echo '<img src="images/tracking_icons/png/Processing.png" class="icon" alt="Processing">';
				$desc = "Su(s) dispositivo(s) esta(n) siendo inspeccionado(s) por un tecnico.";
			}
			if($order_status == "shipped") {
           		echo '<img src="images/tracking_icons/png/Shipped.png" class="icon" alt="Shipped">';
				$desc = "Ynuestro(s) dispositivo(s) esta(n) de camino a nuestra oficina.";
			}
			if($order_status == "returned_to_sender") {
           		echo '<img src="images/tracking_icons/png/Returned To Sender.png" class="icon" alt="Returned To Sender">';
				$desc = "Su envio ha sido devuelto.";
			}
			if($order_status == "shipment_problem") {
           		echo '<img src="images/tracking_icons/png/Shipping Problem.png" class="icon" alt="Shipment Problem">';
				$desc = "Ha habido un problema con su envio. Nos pondremos en contacto con usted.";
			}
			if($order_status == "submitted") {
           		echo '<img src="images/tracking_icons/png/Awaiting Shipment.png" class="icon" alt="Submitted">';
				$desc = "Su oferta sera revisada en breve.";
			} ?>
            <!-- //PNG icon Start -->

            <h3><?=strtoupper(ucwords(str_replace("_"," ",$order_status)))?></h3>
            <p><?=$desc?></p>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php
} else { ?>
  <section id="tracking">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="block head pb-0 mb-0 border-line text-center clearfix">
            <h1 class="h1 border-line clearfix">Sistema de Localizacion</h1>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="block tracking-text-block clearfix">
            <h2>Cual es el estado de mi oferta?</h2>
            <p>Utiliza nuestro exclusivo sistema de seguimiento para controlar el progreso de tu oferta.</p><p>Ingresa la direccion de correo electronico utilizada en el pago y tu numero de oferta para ver el estado de tu oferta..</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="block tracking-form clearfix">
            <form action="controllers/order_track.php" method="post" id="contact_form">
			
			  <?php
			  if($error_message!="") { ?>
				<div class="form-group">
					<div class="alert alert-danger alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><?=$error_message?>
					</div>
				</div>
			  <?php
			  } ?>
		  
			  <?php
			  /*if(!empty($order_data)) { ?>
				<div class="form-group">
					<h4><strong>Email:</strong> <?=$order_data['email']?></h4>
					<h4><strong>Order ID:</strong> <?=$order_data['order_id']?></h4>
					<h4><strong>Your Order Status Is:</strong> <?=ucwords(str_replace("_"," ",$order_status))?></h4>
					<a href="<?=SITE_URL?>order-track" class="btn btn-primary">Retry</a>
				</div>
			  <?php
			  } else {*/ ?>
				  <div class="form-group">
					<label class="text-uppercase" for="exampleInputEmail1">Email</label>
					<input type="email" name="email" id="email" class="form-control" value="<?=$user_email?>"/>
				  </div>
				  <div class="form-group">
					<label class="text-uppercase" for="exampleInputEmail1">Numero de Pedido</label>
					<input type="text" name="order_id" id="order_id" class="form-control" />
				  </div>
				  <?php
				  if($order_track_form_captcha == '1') { ?>
						<div class="form-group">
							<div id="g_form_gcaptcha"></div>
							<input type="hidden" id="g_captcha_token" name="g_captcha_token" value=""/>
						</div>
				  <?php
				  } ?>
				  <button type="submit" class="btn btn-primary">PISTA</button>
				  <input type="hidden" name="submit_form" id="submit_form" />
			<?php
			//} ?>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

<script>
<?php
if($order_track_form_captcha == '1') { ?>
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

//window.onSubmitForm = onSubmitForm;
<?php
} ?>

(function( $ ) {
	$(function() {
		$('#contact_form').bootstrapValidator({
			fields: {
				email: {
					validators: {
						notEmpty: {
							message: 'Por favor, introduzca la direccion de correo electronico'
						},
						emailAddress: {
							message: 'Por favor, introduzca una direccion de correo electronico valida'
						}
					}
				},
				order_id: {
					validators: {
						notEmpty: {
							message: 'Por favor, introduzca el numero de pedido'
						}
					}
				}
			}
		}).on('success.form.bv', function(e) {
            $('#contact_form').data('bootstrapValidator').resetForm();

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
<?php
} ?>