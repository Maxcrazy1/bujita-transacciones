<section class="<?=$active_page_data['css_page_class']?>">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="block head pb-0 mb-0 border-line text-center clearfix">
			<?php
			if($active_page_data['show_title'] == '1') { ?>
            	<h1 class="h1 border-line clearfix">CONDICIONES DE SERVICIO</h1>
			<?php
			} ?>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="block pb-5 mb-5 clearfix">
            <?=$general_setting_data['terms']?>
          </div>
        </div>
      </div>
    </div>
</section>

