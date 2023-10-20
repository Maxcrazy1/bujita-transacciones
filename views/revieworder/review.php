  <section id="content">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="block content mt-5 clearfix">
            <div class="row">
              <div class="col-md-12">

				<span id="qty_error_msg" style="display:none;"></span>
			  	<!--<small id="qty_error_msg" class="help-block m_validations_showhide" style="display:none;">We do not accept quanties greater than 10 per item. To sell larger quantities, please contact out customer service team.</small>-->

                <div class="block cart-page clearfix">
                  <h1 class="text-center"><?php echo $LANG["HERE'S YOUR CART"]; ?></h1>
                  <form id="submit_form" action="controllers/revieworder/review.php" method="post" onSubmit="return check_form(this);">
                    <table class="table">
                      <tr>
                        <th class="details"><?php echo $LANG["DETAILS"]; ?></th>
                        <th class="quantity"><?php echo $LANG["QUANTITY"]; ?></th>
                        <th class="price"><?php echo $LANG["VALUE"]; ?></th>
                      </tr>
                      <?php
                      $tid = 1;
                      foreach ($order_item_list as $order_item_list_data) {
                        $model_data = get_single_model_data($order_item_list_data['model_id']);
                        $mdl_details_url = SITE_URL . $model_data['sef_url'] . '/' . createSlug($model_data['title']) . '/' . $model_data['id'] . ($order_item_list_data['storage'] ? '/' . intval($order_item_list_data['storage']) : '');

                        //path of this function (get_order_item) admin/include/functions.php
                        $order_item_data = get_order_item($order_item_list_data['id'], 'list'); ?>
                        <tr>
                          <td class="details">
                            <div class="row">
                              <div style="padding-left: 0px; padding-right: 0px;" class="col-md-1 col-3">
                                <?php
                                if ($order_item_list_data['model_img']) {
                                  echo '<img src="' . SITE_URL . 'images/mobile/' . $order_item_list_data['model_img'] . '"/>';
                                } ?>
                              </div>
                              <div class="col-md-11  col-9">
                                <?php  
                                $translations = [ 'storage'=>'almacenamiento', 'condition'=>'estado', 'type'=>'tipo'];
                                if(!empty($translations)){
                                    foreach($translations as $en=>$es){
                                        $order_item_data['device_info'] = str_replace( strtolower($en), strtolower($es), strtolower($order_item_data['device_info']) );
                                    }
                                }
                                echo '<h3>' . $order_item_data['device_title'] . '</h3>';
                                if ($order_item_data['device_info']) {
                                  echo '<h4>' . $order_item_data['device_info'] . '</h4>';
                                }
                                if ($order_item_data['data']['imei_number']) {
                                  echo '<h4><span> IMEI:</span> ' . $order_item_data['data']['imei_number'] . '</h4>';
                                } ?>
                                <p><a href="<?= $mdl_details_url ?>?item_id=<?= $order_item_list_data['id'] ?>" class="btn btn-secondary btn-sm"><?php echo $LANG["EDIT"]; ?></a><a href="controllers/revieworder/review.php?rorder_id=<?= $order_item_list_data['id'] ?>" class="btn btn-sm btn-remove" onclick="return confirm('Are you sure you want to remove this item ?');"><?php echo $LANG["REMOVE"]; ?></a></p>
                              </div>
                            </div>
                          </td>
                          <td class="quantity">
                            <input type="number" min="1" max="10" class="form-control chng_qty" id="qty-<?= $tid ?>" name="qty[<?= $order_item_list_data['id'] ?>]" value="<?= $order_item_list_data['quantity'] ?>">
                          </td>
                          <td class="price">
                            <?= amount_fomat($order_item_list_data['price']) ?>
                          </td>
                        </tr>
                        <?php
                        $tid++;
                      } ?>
                    </table>
                    <div class="clearfix">
                      <button type="submit" name="empty_cart" class="btn btn-secondary btn-empty-cart btn-lg float-left"><?php echo $LANG["Empty Cart"]; ?></button>
                      <button type="submit" name="update_quantity" class="btn btn-secondary btn-update-quatity btn-lg float-right"><?php echo $LANG["UPDATE QUANTITY"]; ?></button>
                    </div>
                  </form>
                  <div class="divider clearfix"></div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="block head cart-saerch-page cart-order-page text-center clearfix">
                        <div class="h1 border-line mt-4"><?php echo $LANG["WANT TO SELL MORE?"]; ?></div>
                        <form class="form-inline" action="<?= SITE_URL ?>search" method="post">
                          <div class="form-group">
                            <input type="text" class="form-control srch_list_of_model" name="search" id="staticEmail2" placeholder="<?php echo $LANG["Search device here"]; ?>">
                          </div>
                          <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                        </form>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="block cart-summary clearfix">
                        <h3><?php echo $LANG["SUMMARY"]; ?></h3>
                        <div class="row">
                          <div class="col-md-6 col-6">
                            <h4><?php echo $LANG["PRIORITY SHIPPING"]; ?></h4>
                          </div>
                          <div class="col-md-6 col-6">
                            <span><?php echo $LANG["FREE"]; ?></span>
                          </div>
                        </div>
                        <div class="border-divider pb-3 clearfix"></div>
                        <div class="row">
                          <div class="col-md-6 col-6">
                            <h4><?php echo $LANG["TOTAL PAYMENT"]; ?></h4>
                          </div>
                          <div class="col-md-6 col-6">
                            <span class="totla-price"><?= amount_fomat($sum_of_orders) ?></span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <a class="btn btn-success btn-lg btn-checkout float-right" href="<?= SITE_URL ?>checkout"><?php echo $LANG["GET PAID"]; ?></a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="block head cart-saerch-page mobile-only text-center clearfix">
                        <div class="h1 border-line mt-4">Selling More Stuff?</div>
                        <form class="form-inline" action="<?= SITE_URL ?>search" method="post">
                          <div class="form-group">
                            <input type="text" class="form-control srch_list_of_model" name="search" id="staticEmail2" placeholder="<?php echo $LANG["Search device here"]; ?>">
                          </div>
                          <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  
<script>
jQuery(document).ready(function($) {
	$('.chng_qty').on('blur keyup change paste',function () {
		var this_data = $(this);
		if((this_data.val() < 1 || this_data.val() > 10) && this_data.val().length != 0) {
			var msg = "";
			if(this_data.val() < 1) {
				this_data.val(1);
				msg = "We do not accept quanties less than 1 per item. To sell larger quantities, please contact out customer service team.";
			}
			if(this_data.val() > 10) {
				this_data.val(10);
				msg = "We do not accept quanties greater than 10 per item. To sell larger quantities, please contact out customer service team.";
			}
			$('#qty_error_msg').show().html('<div class="alert alert-danger alert-dismissable help-block"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+msg+'</div>');
		}
	});

	$('input').each(function() {
   		$(window).keydown(function(event){
			if(event.keyCode == 13) {
			  return false;
			}
		  });
    });
});
</script>