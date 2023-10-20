<?php
//Header Image
if($active_page_data['image'] != "") { ?>
	<section>
	  <div class="row">
		<?php
		if($active_page_data['image_text'] != "") {
			echo '<h2>'.$active_page_data['image_text'].'</h2>';
		} ?>
		<img src="<?=SITE_URL.'images/pages/'.$active_page_data['image']?>" alt="<?=$active_page_data['title']?>" width="100%">
	  </div>
	</section>
<?php
} ?>
                  
  <section>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="block head pb-0 mb-0 border-line text-center clearfix">
			<?php
		  	if($active_page_data['show_title'] == '1') { ?>
			<h1 class="h1 border-line clearfix"><?=$active_page_data['title']?></h1>
			<?php
			} ?>
          </div>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="block content bulk-sale-form text-center clearfix">
            <?=($active_page_data['content']?$active_page_data['content']:'')?>
            <form class="pb-5 mb-5" action="controllers/bulk_order_form.php" method="post" id="bulk_order_form">
              <div class="form-group">
                <label for="name">NOMBRE</label>
                <input type="text" name="name" id="name" placeholder="" class="form-control" />
              </div>
              <div class="form-group">
                <label for="email">EMAIL</label>
                <input type="text" name="email" id="email" placeholder="" class="form-control" />
              </div>
              <div class="form-group">
                <label for="phone">TELEFONO</label>
                <input type="text" name="phone" id="phone" placeholder="" class="form-control" />
              </div>
              <div class="form-group">
                <label for="company_name">EMPRESA (si es aplicable)</label>
                <input type="text" name="company_name" id="company_name" placeholder="" class="form-control" />
              </div>
              <div class="form-group">
                <label for="content">COMENTARIO</label>
				<textarea name="content" class="form-control" rows="3"></textarea>
              </div>
			  <?php
			  if($bulk_order_form_captcha == '1') { ?>
			  <div class="form-group">
				<div id="g_form_gcaptcha"></div>
				<input type="hidden" id="g_captcha_token" name="g_captcha_token" value=""/>
			  </div>
			  <?php
			  } ?>
              <div class="clearfix"></div>
              <button type="submit" class="btn btn-primary float-right">ENVIAR</button>
			  <input type="hidden" name="submit_form" id="submit_form" />
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
				
<script>
<?php
if($bulk_order_form_captcha == '1') { ?>
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
		$('#bulk_order_form').bootstrapValidator({
			fields: {
				name: {
					validators: {
						stringLength: {
							min: 1,
						},
						notEmpty: {
							message: 'Por favor, introduzca su nombre'
						}
					}
				},
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
				phone: {
					validators: {
						stringLength: {
							min: 1,
						},
						notEmpty: {
							message: 'Por favor, introduzca su telefono'
						}
					}
				}/*,
				city: {
					validators: {
						stringLength: {
							min: 1,
						},
						notEmpty: {
							message: 'Please enter your city'
						}
					}
				},
				zip_code: {
					validators: {
						notEmpty: {
							message: 'Please select zip code'
						}
					}
				},
				title: {
					validators: {
						notEmpty: {
							message: 'Please enter your title'
						}
					}
				}*/,
				content: {
					validators: {
						notEmpty: {
							message: 'Por favor, introduzca su mensaje'
						}
					}
				}
			}
		}).on('success.form.bv', function(e) {
            $('#bulk_order_form').data('bootstrapValidator').resetForm();

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