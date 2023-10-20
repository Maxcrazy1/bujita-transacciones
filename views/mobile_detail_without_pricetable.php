<?php
//Url params
$req_model_id=$url_third_param;
$req_storage=$url_four_param;

//Fetching data from model
require_once('models/mobile.php');

//Get data from models/mobile.php, get_single_model_data function
$model_data = get_single_model_data($req_model_id);

$meta_title = $model_data['meta_title'];
$meta_desc = $model_data['meta_desc'];
$meta_keywords = $model_data['meta_keywords'];

$model_price = $model_data['price'];
$unlock_price = $model_data['unlock_price'];

$storage_list = get_models_storage_data($req_model_id);
$condition_list = get_models_condition_data($req_model_id);
$network_list = get_models_networks_data($req_model_id);
$color_list = get_models_color_data($req_model_id);
$accessories_list = get_models_accessories_data($req_model_id);
$miscellaneous_list = get_models_miscellaneous_data($req_model_id);

$f_model_price = $model_price;

//Header section
include("include/header.php");

$edit_item_id = $_REQUEST['item_id'];
$order_item_data = array();
if($edit_item_id>0) {
	$order_item_data = get_order_item($edit_item_id,'');
	$order_item_data = $order_item_data['data'];
}
?>

<section id="item-steps">
	<div class="container">
		<?php
		//Order steps
		$order_steps = 1;
		include("include/steps.php"); ?>
	</div>
</section>

<form action="<?=SITE_URL?>controllers/mobile.php" method="post" onSubmit="return check_form(this);">
  <section id="model-details">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="block title-border mb-0 pb-0">
            <h1><?=$model_data['title']?> <a href="javascript:void();" data-toggle="modal" data-target="#DeviceHelp"><i class="fa fa-question-circle" aria-hidden="true"></i></a></h1>
          </div>
        </div>
		
		<div class="modal fade HelpPopup" id="DeviceHelp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
			  <div class="modal-content">
				<div class="modal-header">
				  <h5 class="modal-title">Device Terms & Conditions</h5>
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
				</div>
				<div class="modal-body">
				  <div class="popUpInner">
					<?=$model_data['tooltip_device']?>
				  </div>
				</div>
			  </div>
			</div>
		</div>
      </div>

      <div class="row">
        <div class="col-md-3">
          <div class="block mobile-details clearfix">
            <?php
            if($model_data['model_img']) {
              $md_img_path = SITE_URL.'libraries/phpthumb.php?imglocation='.SITE_URL.'images/mobile/'.$model_data['model_img'].'&h=144'; ?>
              <div class="model-image">
                <img src="<?=$md_img_path?>">
              </div>
            <?php
            } ?>
            <div class="device-details">Capacity: <span class="storage_nm"></span></div>
			<div class="device-details">Condition: <span class="condition_nm"></span></div>
            <div class="device-details">Network: <span class="network_nm"></span></div>
          </div>
          <div class="block remove-icloud-android pt-3">
          	<h4>Remove All Accounts From Phone.</h4>
         	<p>e.g. Apple iCloud or Google Account</p>
          </div>
          <div class="block icloud-box py-0 clearfix" wfd-id="223">
            <div class="icolud-box-img pull-left" wfd-id="224">
              <img src="<?=SITE_URL?>/images/icloud.png" alt="">
              <h5>iCloud</h5>
            </div>
            <h4>Selling a iphone?</h4>
            <p>To remove iCloud form your iphone please follow <a href="https://support.apple.com/kb/ph2702?locale=en_US">these instruction</a></p>
          </div>
          <div class="block icloud-box py-0 clearfix" wfd-id="223">
            <div class="icolud-box-img pull-left" wfd-id="224">
              <img src="<?=SITE_URL?>/images/android.jpg" alt="">
              <h5>Android</h5>
            </div>
            <h4>Selling a android?</h4>
            <p>To remove your Google account for your android phone please follow <a href="https://support.google.com/android/answer/7664951?hl=en-GB&visit_id=636942936283715040-824960801&rd=1">these instruction</a></p>
          </div>
        </div>
		
        <div class="col-md-6">
          <div class="mobile-border">
		  <?php
		  if(!empty($storage_list) && $show_model_storage == "model_details") { ?>
			<div class="block mobile-box capacity-section condition-section clearfix">
			  <div class="h3">
				<strong>Select Capacity</strong>
				<a href="javascript:void();" data-toggle="modal" data-target="#CapacityHelp"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
			  </div>
			  <div class="btn-grp clearfix">
			    <?php
				foreach($storage_list as $s_key => $storage_data) { ?>
					<div class="custom-control custom-radio">
					  <input class="capacity custom-control-input" type="radio" id="capacity<?=$storage_data['storage_size']?>" name="capacity" value="<?=$storage_data['storage_size'].$storage_data['storage_size_postfix']?>::<?=($storage_data['storage_price']>0?$storage_data['storage_price']:0)?>::<?=$storage_data['plus_minus']?>::<?=$storage_data['fixed_percentage']?>" <?=($s_key==0?'checked="checked"':'')?>>
					  <label class="btn condition-btn working-btn" for="capacity<?=$storage_data['storage_size']?>"><i class="fas fa-check-circle first"></i><?=$storage_data['storage_size'].$storage_data['storage_size_postfix']?></label>
					</div>
				<?php
				} ?>
			  </div>
			</div>
			
			<div class="modal fade HelpPopup" id="CapacityHelp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
				  <div class="modal-content">
					<div class="modal-header">
					  <h5 class="modal-title">Capacity Terms & Conditions</h5>
					  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					  </button>
					</div>
					<div class="modal-body">
					  <div class="popUpInner">
						<?=$model_data['tooltip_storage']?>
					  </div>
					</div>
				  </div>
				</div>
			</div>
		  <?php
		  }
		  if(!empty($condition_list)) { ?>
          <div class="block mobile-box condition-section clearfix">
            <div class="h3">
              <strong>Select Condition</strong>
              <a href="javascript:void();" data-toggle="modal" data-target="#ConditionHelp"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
            </div>
            <div class="btn-grp clearfix">
              <?php
              $c=0;
              foreach($condition_list as $key=>$condition_data) {
                $c=$c+1; ?>
                <div class="custom-control custom-radio">
                  <input class="check_condition custom-control-input" type="radio" id="check_condition<?=$key?>" data-key="<?=$key?>" name="check_condition" value="<?=$condition_data['condition_name']?>::<?=($condition_data['condition_price']>0?$condition_data['condition_price']:0)?>::<?=$condition_data['disabled_network']?>::<?=$condition_data['plus_minus']?>::<?=$condition_data['fixed_percentage']?>" <?php if($order_item_data['condition']!="" && $order_item_data['condition']==$condition_data['condition_name']){echo 'checked="checked"';}elseif($order_item_data['condition']=="" && $c==1){echo 'checked="checked"';}?>>
                  <label class="btn condition-btn working-btn" for="check_condition<?=$key?>"><i class="fas fa-check-circle first"></i><?=$condition_data['condition_name']?></label>
                </div>
              <?php
              } ?>
            </div>
          </div>
		  <?php
		  }
		  if(!empty($network_list)) { ?>
          <div class="block mobile-box network-section clearfix">
            <div class="h3">
              <strong>Select Network</strong>
              <a href="javascript:void();" data-toggle="modal" data-target="#NetworkHelp"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
            </div>

            <div class="network-boxs">
			  <?php
			  if($unlock_price) {
				echo '<input type="hidden" name="unlock_price" id="unlock_price" value="'.$unlock_price.'" />'; ?>
				<div class="network-box">
					<input class="custom-input select_network" type="radio" name="network" id="unlocked" value="unlocked::<?=$unlock_price?>::+::fixed">
					<label class="custom-label" for="unlocked">
					  <img src="<?=SITE_URL?>images/network/unlocked.png" width="25" height="25" alt="Unlocked">
					</label>
        		</div>
			  <?php
			  }

              $n=1;
              foreach($network_list as $n_key=>$network_data) {
                $n = $n+1; ?>
				<div class="network-box">
					<input name="network" class="custom-input select_network" type="radio" id="<?=createSlug($network_data['network_name'])?>" data-model="<?php if($network_data['change_unlock']=='1' && $unlock_price>$network_data['network_price']){echo 'yes';}?>" value="<?=$network_data['network_name']?>::<?=$network_data['network_price']?>::<?=$network_data['plus_minus']?>::<?=$network_data['fixed_percentage']?>" <?php if($order_item_data['network']==$network_data['network_name']){echo 'checked="checked"';}/*elseif($order_item_data['network']=="" && $n==1){echo 'checked="checked"';}*/?>>
					<label class="custom-label" for="<?=createSlug($network_data['network_name'])?>">
					  <?php
					  if($network_data['network_icon']) { ?>
					  <img src="<?=SITE_URL?>images/network/<?=$network_data['network_icon']?>" width="25" height="25" alt="<?=$network_data['network_name']?>" title="<?=$network_data['network_name']?>">
					  <?php
					  } ?>
					</label>
				</div>
              <?php
              } ?>
            </div>
          </div>
		  
          <div class="modal fade HelpPopup" id="NetworkHelp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Network Terms & Conditions</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="popUpInner">
                    <?=(trim($model_data['tooltip_network'])!=""?$model_data['tooltip_network']:$model_data['d_tooltip_network'])?>
                  </div>
                </div>
              </div>
            </div>
          </div>
		  
		  <div class="modal fade" id="UnlockModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
			  <div class="modal-content">
				<div class="modal-header">
				  <h5 class="modal-title">UNLOCK an extra <span id="unlock_extra_price"></span>!</h5>
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
				</div>
				<div class="modal-body">
				  <div class="popUpInner">
					<h5 class="otwounlock"><i class="fa fa-unlock-alt" aria-hidden="true"></i> Unlock your <?=$model_data['title']?> and get <strong><span id="items_price_with_unlock_price"></span></strong> instead of <strong> <span id="clicked_net_price"></span></strong>.</h5>
				  </div>
				</div>
			  </div>
			</div>
		  </div>
      <?php 
      } ?>
	  
        <div class="block mobile-box capacity-section condition-section clearfix">
          <div class="form-group">
            <input type="text" class="form-control" id="imei_number" name="imei_number" placeholder="Enter IMEI number">
          </div>
        </div>
      </div>
       
		<div class="block block-pirce-box clearfix">
			<div class="form-inline" role="form">
				<input type="hidden" class="form-control" name="quantity" id="quantity" value="1">
			  <div class="form-group">
			  <strong class="show_final_amt_text">Guaranteed Value:</strong><strong class="price show_final_amt"><?=amount_fomat($total)?></strong> <button type="submit" class="btn btn-lg btn-primary" name="sell_this_device" id="sell_this_device">Sell this Device</button>
			  </div>
			</div>
			<p class="alert alert-warning"><small>Please Note: We do not pay for devices that have been reported lost or stolen.</small></p>
		</div>      
    </div>
	
	<div class="col-md-3">
	  <?php
	  foreach($condition_list as $ct_key=>$condition_data) { ?>
		<div class="block mobile-box condition-info condition_tips<?=$ct_key?>" style="display:none;">
			<div class="h4"><span><?=$condition_data['condition_name']?></span></div>
			<div class="description clearfix">
				<?=html_entity_decode($condition_data['condition_terms'])?>
			</div>
		</div>
	  <?php
	  } ?>
	</div>
      </div>
    </div>
  </section>

  <div class="modal fade HelpPopup" id="ConditionHelp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Condition Terms & Conditions</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="popUpInner">
            <?=(trim($model_data['tooltip_condition'])!=""?$model_data['tooltip_condition']:$model_data['d_tooltip_condition'])?>
          </div>
        </div>
      </div>
    </div>
  </div>
    
	<input type="hidden" name="device_id" id="device_id" value="<?=$model_data['device_id']?>"/>
	<input type="hidden" name="payment_amt" id="payment_amt" value="<?=$total?>"/>
	<input type="hidden" name="req_model_id" id="req_model_id" value="<?=$req_model_id?>"/>
	<input type="hidden" name="capacity_name" id="capacity_name"/>
	<?php
	if($edit_item_id>0) {
		echo '<input type="hidden" name="edit_item_id" id="edit_item_id" value="'.$edit_item_id.'"/>';
	} ?>
</form>

<?php
if($model_data['description']) { ?>
<section>
	<div class="container">
		<div class="row" style="margin-top:25px;margin-bottom:25px;">
			<div class="col-md-12">
				<div class="block clearfix">
					<div class="block-inner clearfix">
						<?=$model_data['description']?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php
} ?>

<!--START for review section-->
<?php
//Get review list
$review_list_data = get_review_list_data_random();
if(!empty($review_list_data)) { ?>
<section>
  <div class="container">
  <div class="row quota-trustpilot">
	<div class="col-md-12">
	  <div class="block clearfix">
		<div class="block-inner clearfix">
		  <span class="quota-icon"></span>
		  <h3><strong><?=$review_list_data['title']?></strong></h3>
		  <div class="text">
			<?php
			if($review_list_data['stars'] == '0.5' || $review_list_data['stars'] == '1') { ?>
				<i class="fa fa-star"></i>
			<?php
			} elseif($review_list_data['stars'] == '1.5' || $review_list_data['stars'] == '2') { ?>
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
			<?php
			} elseif($review_list_data['stars'] == '2.5' || $review_list_data['stars'] == '3') { ?>
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
			<?php
			} elseif($review_list_data['stars'] == '3.5' || $review_list_data['stars'] == '4') { ?>
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
			<?php
			} elseif($review_list_data['stars'] == '4.5' || $review_list_data['stars'] == '5') { ?>
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
			<?php
			} ?>
		  </div>
		  <div class="text">
			<p><?=$review_list_data['content']?></p>
		  </div>
		  <div class="arrow-down"></div>
		</div>
		<div class="trust-pilot-credits clearfix">
		  <p><?=$review_list_data['name']?><br /><span><?=($review_list_data['country']?$review_list_data['country'].', ':'').$review_list_data['state'].', '.$review_list_data['city']?></span><br /><span class="date"><?=date('m/d/Y',$review_list_data['date'])?></span></p>
		</div>
	  </div>
	</div>
  </div>
</div>
</section>
<?php
} ?>
<!--END for review section-->

<script type="text/javascript">
  function check_form(){
    <?php
    if(!empty($condition_list)) { ?>
      var condition_spt = jQuery("input[name='check_condition']:checked").val().split('::');
      if(document.getElementById("select_network").value.trim()=="::0" && condition_spt[2]=='1') {
        alert('Please select your network');
        return false;
      }
    <?php
    } ?>

    if(document.getElementById("quantity").value<=0) {
      alert('Please enter quantity');
      return false;
    }
  }
</script>

<script type="text/javascript">
function network_cal(type) {
	var f_model_price = '<?=$f_model_price?>';
	var model_price = '<?=$model_price?>';
	var f_other_item_price = '<?=$f_model_price?>';

	var network_amt_spt = 0;
	var network_name = '';
	var network_amt = 0;
	
	var capacity_amt_spt = 0;
	var capacity_name = '';
	var capacity_amt = 0;
	
	var color_price = 0;
	var accessories_price = 0;
	var miscellaneous_price = 0;
	var storage_color_name = '';
	var accessories_name = '';
	var miscellaneous_name = '';

	var color_plus_minus = 0;
	var color_fixed_percentage = 0;
	var accessories_plus_minus = 0;
	var accessories_fixed_percentage = 0;
	var miscellaneous_plus_minus = 0;
	var miscellaneous_fixed_percentage = 0;
	
	var cond_amt_spt = jQuery("input[name='check_condition']:checked").val().split('::');
	var condition_name = cond_amt_spt[0];
	var cond_amt = cond_amt_spt[1];
	var is_network_show = cond_amt_spt[2];
	var condition_plus_minus = cond_amt_spt[3];
	var condition_fixed_percentage = cond_amt_spt[4];
	
	jQuery(".condition_nm").html(condition_name);
	var c_key = jQuery(jQuery("input[name='check_condition']:checked")).attr('data-key');
	jQuery(".condition-info").hide();
	jQuery(".condition_tips"+c_key).show();
	
	if(condition_fixed_percentage == '%') {
		var f_condition_price = (model_price*cond_amt)/100;
	} else {
		var f_condition_price = cond_amt;
	}

	if(condition_plus_minus == '-') {
		f_model_price = Number(f_model_price)-Number(f_condition_price);
		f_other_item_price = Number(f_other_item_price)-Number(f_condition_price);
	}
	if(condition_plus_minus == '+') {
		f_model_price = Number(f_model_price)+Number(f_condition_price);
		f_other_item_price = Number(f_other_item_price)+Number(f_condition_price);
	}

	if(is_network_show=='1') {
		var network = jQuery("input[name='network']:checked").val();
		if(typeof network === "undefined") {
			//If networks not choosed...
		} else {
			var network_amt_spt = network.split('::');
			var network_name = network_amt_spt[0];
			var network_amt = network_amt_spt[1];
			var network_plus_minus = network_amt_spt[2];
			var network_fixed_percentage = network_amt_spt[3];
	
			if(network_fixed_percentage == '%') {
				var f_network_price = (model_price*network_amt)/100;
			} else {
				var f_network_price = network_amt;
			}
	
			if(network_plus_minus == '-') {
				f_model_price = Number(f_model_price)-Number(f_network_price);
				f_other_item_price = Number(f_other_item_price)-Number(f_network_price);
			}
			if(network_plus_minus == '+') {
				f_model_price = Number(f_model_price)+Number(f_network_price);
				f_other_item_price = Number(f_other_item_price)+Number(f_network_price);
			}
			jQuery(".network_nm").html(network_name);
		}
		jQuery(".network-section").show();
	} else {
		jQuery(".network-section").hide();
	}

	<?php
	if(!empty($storage_list)) {
		if($show_model_storage == "models" && $req_storage!="") {
			$selected_storage_data = array();
			foreach($storage_list as $storage_data) {
				if($storage_data['storage_size']==trim(str_replace(' ','',$req_storage))) {
					$selected_storage_data = $storage_data;
				}
			} ?>

			var capacity_name = "<?=$selected_storage_data['storage_size'].$selected_storage_data['storage_size_postfix']?>";
			var capacity_amt = "<?=$selected_storage_data['storage_price']?>";
			var capacity_plus_minus = "<?=$selected_storage_data['plus_minus']?>";
			var capacity_fixed_percentage = "<?=$selected_storage_data['fixed_percentage']?>";
			jQuery(".storage_nm").html(capacity_name);
			jQuery("#capacity_name").val(capacity_name);
			
			if(capacity_fixed_percentage == '%') {
				var f_capacity_price = (model_price*capacity_amt)/100;
			} else {
				var f_capacity_price = capacity_amt;
			}
		
			if(capacity_plus_minus == '-') {
				f_model_price = Number(f_model_price)-Number(f_capacity_price);
				f_other_item_price = Number(f_other_item_price)-Number(f_capacity_price);
			}
			if(capacity_plus_minus == '+') {
				f_model_price = Number(f_model_price)+Number(f_capacity_price);
				f_other_item_price = Number(f_other_item_price)+Number(f_capacity_price);
			}
		<?php
		} else { ?>
			var select_capacity_spt = jQuery("input[name='capacity']:checked").val().split('::');
			var capacity_name = select_capacity_spt[0];
			var capacity_amt = select_capacity_spt[1];
			var capacity_plus_minus = select_capacity_spt[2];
			var capacity_fixed_percentage = select_capacity_spt[3];
			jQuery(".storage_nm").html(capacity_name);
			jQuery("#capacity_name").val(capacity_name);
			
			if(capacity_fixed_percentage == '%') {
				var f_capacity_price = (model_price*capacity_amt)/100;
			} else {
				var f_capacity_price = capacity_amt;
			}

			if(capacity_plus_minus == '-') {
				f_model_price = Number(f_model_price)-Number(f_capacity_price);
				f_other_item_price = Number(f_other_item_price)-Number(f_capacity_price);
			}
			if(capacity_plus_minus == '+') {
				f_model_price = Number(f_model_price)+Number(f_capacity_price);
				f_other_item_price = Number(f_other_item_price)+Number(f_capacity_price);
			}
		<?php
		}
	}

	if($color_list) { ?>
	jQuery('.color_price').each(function () {
		if(this.checked==true) {
			var price_cdt = this.value.split('::');
			color_price += parseFloat(price_cdt[1]);
			storage_color_name += price_cdt[0];
			color_plus_minus = price_cdt[2];
			color_fixed_percentage = price_cdt[3];

			if(color_fixed_percentage == '%') {
				var f_color_price = (model_price*price_cdt[1])/100;
			} else {
				var f_color_price = price_cdt[1];
			}

			if(color_plus_minus == '-') {
				f_model_price = Number(f_model_price)-Number(f_color_price);
				f_other_item_price = Number(f_other_item_price)-Number(f_color_price);
			}
			if(color_plus_minus == '+') {
				f_model_price = Number(f_model_price)+Number(f_color_price);
				f_other_item_price = Number(f_other_item_price)+Number(f_color_price);
			}
		}
	});
	<?php
	}
	if($accessories_list) { ?>
	jQuery('.accessories_price').each(function () {
		if(this.checked==true) {
			var price_adt = this.value.split('::');
			accessories_price += parseFloat(price_adt[1]);
			accessories_name += price_adt[0]+', ';
			accessories_plus_minus = price_adt[2];
			accessories_fixed_percentage = price_adt[3];

			if(accessories_fixed_percentage == '%') {
				var f_accessories_price = (model_price*price_adt[1])/100;
			} else {
				var f_accessories_price = price_adt[1];
			}

			if(accessories_plus_minus == '-') {
				f_model_price = Number(f_model_price)-Number(f_accessories_price);
				f_other_item_price = Number(f_other_item_price)-Number(f_accessories_price);
			}
			if(accessories_plus_minus == '+') {
				f_model_price = Number(f_model_price)+Number(f_accessories_price);
				f_other_item_price = Number(f_other_item_price)+Number(f_accessories_price);
			}
		}
	});
	<?php
	}
	if($miscellaneous_list) { ?>
	jQuery('.miscellaneous_price').each(function () {
		if(this.checked==true) {
			var price_mdt = this.value.split('::');
			miscellaneous_price += parseFloat(price_mdt[1]);
			miscellaneous_name += price_mdt[0]+':Yes, ';
			miscellaneous_plus_minus = price_mdt[2];
			miscellaneous_fixed_percentage = price_mdt[3];

			if(miscellaneous_fixed_percentage == '%') {
				var f_miscellaneous_price = (model_price*price_mdt[1])/100;
			} else {
				var f_miscellaneous_price = price_mdt[1];
			}

			if(miscellaneous_plus_minus == '-') {
				f_model_price = Number(f_model_price)-Number(f_miscellaneous_price);
				f_other_item_price = Number(f_other_item_price)-Number(f_miscellaneous_price);
			}
			if(miscellaneous_plus_minus == '+') {
				f_model_price = Number(f_model_price)+Number(f_miscellaneous_price);
				f_other_item_price = Number(f_other_item_price)+Number(f_miscellaneous_price);
			}
		}
	});
	<?php
	} ?>

	if(storage_color_name=="") {
		storage_color_name += '<?=$req_storage?>';
	}

	var final_accessories_name = '';
	if(accessories_name!="") {
		final_accessories_name = '<br /><strong>Accessories:</strong> '+removeLastComma(accessories_name);
	}

	var final_miscellaneous_name = '';
	if(miscellaneous_name!="") {
		final_miscellaneous_name = '<br /><strong>Miscellaneous:</strong> '+removeLastComma(miscellaneous_name);
	}

	if(f_model_price<0) {
		f_model_price = 0;
	}

	var final_model_amt = parseFloat(f_model_price);
	jQuery("#payment_amt").val(final_model_amt);

	var _final_model_amt=formatMoney(final_model_amt);
	var __final_model_amt=format_amount(_final_model_amt);
	
	if(type=="network") {
		var network = jQuery("input[name='network']:checked");
		var data_model = jQuery(network).data('model');
		if(data_model=="yes") {
			var unlock_price = jQuery("#unlock_price").val();

			var final_unlock_price = parseFloat(unlock_price)+parseFloat(f_other_item_price);
			var unlock_extra_price = (parseFloat(final_unlock_price) - parseFloat(f_model_price));
			
			var _final_unlock_price=formatMoney(final_unlock_price);
			var __final_unlock_price=format_amount(_final_unlock_price);
			
			var _unlock_extra_price=formatMoney(unlock_extra_price);
			var __unlock_extra_price=format_amount(_unlock_extra_price);
	
			jQuery("#unlock_extra_price").html(__unlock_extra_price);
			jQuery("#items_price_with_unlock_price").html(__final_unlock_price);
			jQuery("#clicked_net_price").html(__final_model_amt);
			jQuery('#UnlockModel').modal('show');
		}
	}
	
	jQuery(".show_final_amt").html(__final_model_amt);
	jQuery(".device_name").html('<?=addslashes_to_html($model_data['title'])?> ' +storage_color_name+' '+network_name+' ('+condition_name+')' +final_accessories_name+final_miscellaneous_name);
}

jQuery(document).ready(function($) {
	$(".check_condition").change(function() {
		network_cal('condition');
	});
	
	$(".select_network").change(function() {
		network_cal('network');
	});
	
	$(".color_price").click(function() {
		network_cal('color');
	});

	$(".accessories_price").click(function() {
		network_cal('accessories');
	});

	$(".miscellaneous_price").click(function() {
		network_cal('miscellaneous');
	});
	
	$(".capacity").click(function() {
		network_cal('capacity');
	});

});

<?php
//Trigger by onload page
echo 'network_cal(0);'; ?>
</script>
