<?php
$network_list = array();
$storage_list = array();
$color_list = array();
$accessories_list = array();

$n_i = 0;
$n_i_array = array();
if (!empty($watchtype_list)) {
	$n_i = $n_i + 1;
	$n_i_array['type'] = $n_i . '.';
}
if (!empty($network_list)) {
	$n_i = $n_i + 1;
	$n_i_array['network'] = $n_i . '.';
}
if (!empty($storage_list)) {
	$n_i = $n_i + 1;
	$n_i_array['storage'] = $n_i . '.';
}
if (!empty($case_material_list)) {
	$n_i = $n_i + 1;
	$n_i_array['case_material'] = $n_i . '.';
}
if (!empty($case_size_list)) {
	$n_i = $n_i + 1;
	$n_i_array['case_size'] = $n_i . '.';
}
if (!empty($color_list)) {
	$n_i = $n_i + 1;
	$n_i_array['color'] = $n_i . '.';
}
if (!empty($condition_list)) {
	$n_i = $n_i + 1;
	$n_i_array['condition'] = $n_i . '.';
}
if (!empty($accessories_list)) {
	$n_i = $n_i + 1;
	$n_i_array['accessories'] = $n_i . '.';
}

$first_section_nm = array_keys($n_i_array)[0];
$last_section_nm = key(array_slice($n_i_array, -1, 1, true));

$n_i_array = array();
?>

<script>

	// dependencies modules
	const dependencies_keys = {'type':'watchtype','network':'networks','screen_size':'screen_size','screen_resolution':'screen_resolution','lyear':'lyear','processor':'processor','storage':'storage', 'ram':'ram', 'color':'color', 'condition':'conditions','accessories':'accessories'};	
	var current_dependency = null;
	var dependencies = '<?php echo json_encode($dependencies_list); ?>';
	dependencies = JSON.parse(dependencies);
	
	var assigned_dependencies = {};

	var first_section_nm = '<?=$first_section_nm?>';
	var last_section_nm = '<?=$last_section_nm?>';

	$(document).ready(function() {

				$(window).resize(responsive_height);
		function responsive_height() {
			console.log(window.innerHeight);
			if(window.innerWidth < 768){
				var h = $(".block.phone-details.condition .custom-control .custom-control-input:checked ~ .custom-control-label .condition-block").height();

				console.log(h);

				if(h){
					h = h + 100 + "px";
					$(".step-navigation").css("padding-top", h);	
					return;
				}
					
					
				
			}

			$(".step-navigation").css("padding-top", "10px");			
			
		}	
		$("#prevBtn").hide();
		$("#getOfferBtn").hide();
		$(".phone-details:first").show();
        
        // Fixing for ghosting at the beginning
		$("#nextBtn").removeClass("hideButtons");
		$("#prevBtn").removeClass("hideButtons");
		$("#getOfferBtn").removeClass("hideButtons");
        
		var current_step = $(".phone-details:visible");
		var current_id = $(current_step).attr("id");
		if(current_id == last_section_nm) {
			$('#getOfferBtn').show();
			$('#nextBtn').hide();
		}
		
		$("#nextBtn").click(function() {
			var current_step = $(".phone-details:visible");
			var current_id = $(current_step).attr("id");
			if (current_id == "type") {
				if (!$("input[name='check_watchtype']").is(':checked')) {
					$("#type_error_msg").show().text('Please select type');
					return false;
				}
			}
			if (current_id == "network") {
				var network_name = $("input[name='check_network']:checked").attr("data-nw_name");
				if (!$("input[name='check_network']").is(':checked')) {
					$("#network_error_msg").show().text('Please select a network carrier');
					return false;
				}
				if (!$("input[id='network_price_unlock']").is(':checked') && !$("input[id='network_price_lock']").is(':checked') && !network_name.match(/\unlock/)) {
					$("#network_price_mode_error_msg").show().text('Please select an option');
					return false;
				}
			}
			if (current_id == "storage") {
				if (!$("input[name='check_capacity']").is(':checked')) {
					$("#capacity_error_msg").show().text('Please select a capacity');
					return false;
				}
			}
			if (current_id == "case_material") {
				if (!$("input[name='check_case_material']").is(':checked')) {
					$("#case_material_error_msg").show().text('Please select a case style');
					return false;
				}
			}
			if (current_id == "case_size") {
				if (!$("input[name='check_case_size']").is(':checked')) {
					$("#case_size_error_msg").show().text('Please select a case size');
					return false;
				}
			}
			if (current_id == "color") {
				if (!$("input[name='check_color']").is(':checked')) {
					$("#color_error_msg").show().text('Please select a color');
					return false;
				}
			}
			if (current_id == "condition") {
				if (!$("input[name='check_condition']").is(':checked')) {
					$("#condition_error_msg").show().text('Please select a condition');
					return false;
				}
			}
			
			var next_step = $(".phone-details:visible").next(".phone-details");
			var next_id = $(next_step).attr("id");
			// dependencies logic
			var available_keys = [];
			for (var i = dependencies.length - 1; i >= 0; i--) {
				let one = dependencies[i];
				

				let rule = one[dependencies_keys[next_id]];
				rule = rule.split(',');
				console.log(next_id, rule);
				
				 				
				const keys = Object.keys(assigned_dependencies);
				for(const key of keys){
					let temp = one[key].split(',');
					if(temp == "") continue;
					console.log("temp",temp);
					console.log("assigned_dependencies", assigned_dependencies);
					
					if(Array.isArray(assigned_dependencies[key]))
					{
						for(const itemx of assigned_dependencies[key])
						{
							if(temp.includes(itemx))
							{
								if(rule[0] != "")
								{
									available_keys = available_keys.concat(rule);
									console.log("found depens",available_keys);
								}
							}	
						}	
					}else{
						if(temp.includes(assigned_dependencies[key]))
						{
							if(rule[0] != "")
							{
								available_keys = available_keys.concat(rule);
								console.log("found depens",available_keys);
							}
						}	
					}
					
				}

			}

						console.log("available_keys",available_keys);

			if(available_keys.length > 0){
				$('#'+next_id+" .custom-radio").each(
					function(){
						$(this).hide();
					}
				);
				for(const i of available_keys){
					$('#depen_'+next_id+i).show();	
				}
			}else{
				$('#'+next_id+" .custom-radio").each(
					function(){
						$(this).show();
					}
				);
			}


			
			var enable_network = $("input[name='check_watchtype']:checked").attr("data-enable_network");
			if (enable_network == '0' && next_id == "network") {
				next_step = $(".phone-details:visible").next().next(".phone-details");
				next_id = $(next_step).attr("id");
			}

			if (next_id == 'get-offer') {
				$('.step-navigation').hide();
			}

			if (next_id == last_section_nm) {
				$('#getOfferBtn').show();
				$('#nextBtn').hide();
			}

			if (next_step.length != 0) {
				$(".phone-details").hide();
				next_step.show();
			}

			$("#prevBtn").show();
			$("#step-dada").show();
			responsive_height();
		});

		$("#getOfferBtn").click(function() {
		
			<?php
			if($n_i == '1') { ?>
			var current_step = $(".phone-details:visible");
			var current_id = $(current_step).attr("id");
			if (current_id == "type") {
				if (!$("input[name='check_watchtype']").is(':checked')) {
					$("#type_error_msg").show().text('Please select type');
					return false;
				}
			}
			if (current_id == "network") {
				var network_name = $("input[name='check_network']:checked").attr("data-nw_name");
				if (!$("input[name='check_network']").is(':checked')) {
					$("#network_error_msg").show().text('Please select a network carrier');
					return false;
				}
				if (!$("input[id='network_price_unlock']").is(':checked') && !$("input[id='network_price_lock']").is(':checked') && !network_name.match(/\unlock/)) {
					$("#network_price_mode_error_msg").show().text('Please select an option');
					return false;
				}
			}
			if (current_id == "storage") {
				if (!$("input[name='check_capacity']").is(':checked')) {
					$("#capacity_error_msg").show().text('Please select a capacity');
					return false;
				}
			}
			if (current_id == "case_material") {
				if (!$("input[name='check_case_material']").is(':checked')) {
					$("#case_material_error_msg").show().text('Please select a case style');
					return false;
				}
			}
			if (current_id == "case_size") {
				if (!$("input[name='check_case_size']").is(':checked')) {
					$("#case_size_error_msg").show().text('Please select a case size');
					return false;
				}
			}
			if (current_id == "color") {
				if (!$("input[name='check_color']").is(':checked')) {
					$("#color_error_msg").show().text('Please select a color');
					return false;
				}
			}
			if (current_id == "condition") {
				if (!$("input[name='check_condition']").is(':checked')) {
					$("#condition_error_msg").show().text('Please select a condition');
					return false;
				}
			}			
			<?php
			} ?>
			
			var next_step = $(".phone-details:visible").next(".phone-details");
			var next_id = $(next_step).attr("id");
			if (next_step.length != 0) {
				$(".phone-details").hide();
				next_step.show();
			}
			if (next_id == 'get-offer') {
				$('.step-navigation').hide();
			}
		});

		$("#prevBtn").click(function() {
			
			// dependencies module

			var current_id = $(".phone-details:visible").attr('id');
			assigned_dependencies[dependencies_keys[current_id]] = "";
			 $("#"+current_id+" input:checked").prop('checked',false);
			console.log(assigned_dependencies);

			var prev_step = $(".phone-details:visible").prev(".phone-details");
			var prev_id = $(prev_step).attr("id");

			var enable_network = $("input[name='check_watchtype']:checked").attr("data-enable_network");
			if (enable_network == '0' && prev_id == "network") {
				prev_step = $(".phone-details:visible").prev().prev(".phone-details");
				prev_id = $(prev_step).attr("id");
			}

			if (prev_step.length != 0) {
				$(".phone-details").hide();
				prev_step.show();
			}

			if (prev_id != last_section_nm) {
				$('#getOfferBtn').hide();
				$('#nextBtn').show();
			}

			if (prev_id == first_section_nm) {
				$("#prevBtn").hide();
				$("#step-dada").hide();
			}
			responsive_height();
		});

		$("#prevBtnCart").click(function() {
			var prev_step = $(".phone-details:visible").prev(".phone-details");
			var prev_id = $(prev_step).attr("id");

			if (prev_step.length != 0) {
				$(".phone-details").hide();
				prev_step.show();
			}

			$('.step-navigation').show();

			if (prev_id != last_section_nm) {
				$('#getOfferBtn').hide();
				$('#nextBtn').show();
			}
		});
		
		$("#prevBtnCart_1").click(function() {
			var prev_step = $(".phone-details:visible").prev(".phone-details");
			var prev_id = $(prev_step).attr("id");

			if (prev_step.length != 0) {
				$(".phone-details").hide();
				prev_step.show();
			}

			$('.step-navigation').show();

			if (prev_id != last_section_nm) {
				$('#getOfferBtn').hide();
				$('#nextBtn').show();
			}
		});		
		
		$("#device_terms").click(function() {
			$("#device_terms_error_msg").hide();
		});
		
		$(".check_watchtype").click(function() {
			$("#type_error_msg").hide();
			network_cal('watchtype');
		});

		$(".check_case_material").click(function() {
			network_cal('case_material');
		});

		$(".check_case_size").click(function() {
			network_cal('case_size');
		});

		$(".check_network").click(function() {
			/*var network_name = $(this).attr("data-nw_name");
			if (network_name.match(/\unlock/) || network_name == "") {
				$(".network_price_mode_section_showhide").hide();
			} else {
				$(".network_price_mode_section_showhide").show();
			}*/

			$("#network_error_msg").hide();
			network_cal('network');
		});

		$(".network_price_mode").click(function() {
			$("#network_price_mode_error_msg").hide();

			/*if ($("input[id='network_price_lock']").is(':checked')) {
				$(".network_price_lock_warning_showhide").show();
			} else {
				$(".network_price_lock_warning_showhide").hide();
			}*/

			network_cal('nwk_price_mode');
		});

		$(".check_capacity").click(function() {
			$("#capacity_error_msg").hide();
			network_cal('capacity');
		});

		$(".check_color").click(function() {
			$("#color_error_msg").hide();
			network_cal('color');
		});

		$(".check_condition").click(function() {
			responsive_height();

			$("#condition_error_msg").hide();
			network_cal('condition');
		});

		$(".check_accessories").click(function() {
			network_cal('accessories');
		});

		$(".getOfferBtn").click(function() {
			network_cal('getoffer');
		});
	});

	function network_cal(type) {
		jQuery(document).ready(function($) {
			var watchtype_id = '';
			var network_id = '';
			var network_price_mode = '';
			var capacity_id = '';
			var case_material_id = '';
			var case_size_id = '';
			var color_id = '';
			var condition_id = '';
			var accessories_ids = [];
	var sessionStorageSelected = JSON.parse(sessionStorage.getItem("post-data-selected"));
			
			if ($("input[name='check_watchtype']").is(':checked')) {
				var watchtype_id = $("input[name='check_watchtype']:checked").val();
			}

			if ($("input[name='check_case_material']").is(':checked')) {
				var case_material_id = $("input[name='check_case_material']:checked").val();
			}

			if ($("input[name='check_case_size']").is(':checked')) {
				var case_size_id = $("input[name='check_case_size']:checked").val();
			}

			if ($("input[name='check_condition']").is(':checked')) {
				var condition_id = $("input[name='check_condition']:checked").val();
			}

			if ($("input[name='check_network']").is(':checked')) {
				var network_id = $("input[name='check_network']:checked").val();
				var network_price_mode = $("input[name='network_price_mode']:checked").val();

				var network_name = $("input[name='check_network']:checked").attr("data-nw_name");
				if (network_name.match(/\unlock/) || network_name == "") {
					$(".network_price_mode_section_showhide").hide();
				} else {
					$(".network_price_mode_section_showhide").show();
				}
				
				if ($("input[id='network_price_lock']").is(':checked')) {
					$(".network_price_lock_warning_showhide").show();
				} else {
					$(".network_price_lock_warning_showhide").hide();
				}
			}

			if ($("input[name='check_color']").is(':checked')) {
				var color_id = $("input[name='check_color']:checked").val();
			}

			$('.check_accessories').each(function(index) {
				if (this.checked == true) {
					accessories_ids[index] = this.value;
				}
			});

			if ($("input[name='check_capacity']").is(':checked')) {
				var capacity_id = $("input[name='check_capacity']:checked").val();
			}
			
			
			if(sessionStorageSelected){
			    if(sessionStorageSelected.storage_id!='<?= $req_model_id ?>'){
                    sessionStorage.removeItem('post-data-selected');
        			sessionStorage.removeItem('redirect-uris');
                }else{
			    watchtype_id=sessionStorageSelected.watchtype_id;
			    case_material_id=sessionStorageSelected.case_material_id;
			    case_size_id=sessionStorageSelected.case_size_id;
			    capacity_id=sessionStorageSelected.storage_id;
				condition_id=sessionStorageSelected.condition_id;
				network_id=sessionStorageSelected.network_id;
				color_id=sessionStorageSelected.color_id;
				accessories_ids=sessionStorageSelected.accessories_ids;
				network_price_mode=sessionStorageSelected.network_price_mode;
				type=sessionStorageSelected.step_type;
			
				
				model_id = sessionStorageSelected.model_id;
			    fields_cat_type = sessionStorageSelected.fields_cat_type;
			    $("#type").hide();
			    $("#case_material").hide();
			    $("#condition").hide();
			    $(".step-navigation").hide();
			    $("#case_size").hide();
			    $("#get-offer").show();
                }
			 //   
			 //   get-offer
			}else{
			   model_id = '<?= $req_model_id ?>';
			   fields_cat_type = '<?= $fields_cat_type ?>';
			}

			post_data = {
				model_id: model_id,
				fields_cat_type: fields_cat_type,
				watchtype_id: watchtype_id,
				case_material_id: case_material_id,
				case_size_id: case_size_id,
				storage_id: capacity_id,
				condition_id: condition_id,
				network_id: network_id,
				color_id: color_id,
				accessories_ids: accessories_ids,
				network_price_mode: network_price_mode,
				step_type: type
			}

						//console.log("aaaa",post_data);


			assigned_dependencies['storage'] = capacity_id;
			assigned_dependencies['conditions'] = condition_id;
			assigned_dependencies['networks'] = network_id;
			assigned_dependencies['color'] = color_id;
			assigned_dependencies['watchtype'] = watchtype_id;

			assigned_dependencies['case_material'] = case_material_id;
			assigned_dependencies['case_size'] = case_size_id;



		
			assigned_dependencies['accessories'] = accessories_ids;

			if(type == "getoffer") {
				//$(".addtocart_spining_icon").html('<i class="fas fa-spinner fa-pulse" style="font-size:128px; padding:25px;"></i>');
				$(".addtocart_spining_icon").html('<span>Calculating Offer Value...</span><br><img src="<?=SITE_URL?>images/spining-icon.svg">');
				$(".addtocart_spining_icon").show();
				$(".get_offer_section_showhide").hide();
				$("#addToCart").attr("disabled", true);
				$(".get_offer_section_showhide_1").hide();
				$(".get_offer_section_showhide").removeClass("hideButtons");
				$(".get_offer_section_showhide_1").removeClass("hideButtons");				
			}
			$.ajax({
				type: "POST",
				url: "<?= SITE_URL ?>ajax/get_model_price.php?token=<?= get_unique_id_on_load() ?>",
				data: post_data,
				success: function(data) {
					if (data != "") {
						var resp_data = JSON.parse(data);
						$(".device_name").html(resp_data.device_name);
						if (type == "getoffer") {
							setTimeout(function() {
							    if (resp_data.payment_amt != "0"){
    								$("#payment_amt").val(resp_data.payment_amt);
    								//if(resp_data.user_state){
    								    $(".show_final_amt").html(resp_data.show_final_amt);
    								    sessionStorage.removeItem('post-data-selected');
    								    sessionStorage.removeItem('redirect-uris');
    								    $("#addToCart").show();
    								    $("#addToCart").attr("disabled", false);
    								/*}else{
    								    $(".price_non_user").html('<button onclick="sessionProduct();" type="button" class="btn btn-primary">Iniciar sesión o Egistrarse</button></a><br> para ver el precio');
    								    $("#addToCart").hide();
    								}*/
                                    $(".get_offer_section_showhide").removeClass("hideButtons");
    								$(".addtocart_spining_icon").html('');
    								$(".addtocart_spining_icon").hide();
    								$(".get_offer_section_showhide").show();
    								$("#addToCart").attr("disabled", false);
							    } else {
							        $(".addtocart_spining_icon").html('');
								    $(".addtocart_spining_icon").hide();
							        $(".get_offer_section_showhide_1").show();
							        $(".get_offer_section_showhide_1").removeClass("hideButtons");
							        
							    }  
							}, 2000);
						}
					}
				}
			});
		});
	}
	
	function sessionProduct(){
		sessionStorage.setItem('redirect-uris', window.location.href);
		sessionStorage.setItem('post-data-selected', JSON.stringify(post_data));
		
		window.location.replace("/login");
	}
	
	
	function sendMail(){
	    if($('#device_terms').is(':checked')){
	      $.ajax({
				type: "POST",
				url: "<?= SITE_URL ?>ajax/get_model_price_send_mail.php?token=<?= get_unique_id_on_load() ?>",
				data: post_data,
				success: function(data) {
				},
	        
	    });  
	    }
	}
</script>

<div class="col-md-8">
	<div id="step-dada" class="step-dada clearfix">
		<div class="h3"><?= $model_data['title'] ?>: <span class="device_name"></span></div>
	</div>
	<div class="step-details clearfix">

		<?php
		if (!empty($watchtype_list)) { ?>
			<div id="type" class="block phone-details storage m-0 p-0 clearfix">
				<h4 class="h4"><?= $n_i_array['type'] ?> <?= $type_title ?></h4>
				<div class="clearfix pb-3">
					<?php
					foreach ($watchtype_list as $wt_key => $watchtype_data) { ?>
						<div class="custom-control custom-radio" id="depen_type<?= $watchtype_data['id']?>">
							<input type="radio" id="check_watchtype<?= $wt_key ?>" name="check_watchtype" value="<?= $watchtype_data['id'] ?>" <?php if ($order_item_data['watchtype'] != "" && $order_item_data['watchtype'] == $watchtype_data['watchtype_name']) {
																																																																		echo 'checked="checked"';
																																																																	} ?> class="custom-control-input check_watchtype" data-enable_network="<?= intval($watchtype_data['disabled_network']) ?>">
							<label class="slider-v2" for="check_watchtype<?= $wt_key ?>" onclick=""></label>
							<label class="custom-control-label" for="check_watchtype<?= $wt_key ?>"><?= $watchtype_data['watchtype_name'] ?></label>
						</div>
					<?php
					} ?>
				</div>
				<div class="clearfix">
					<small id="type_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
				</div>
				<a class="suppot-ques" href="javascript:void();" data-toggle="modal" data-target="#TypeHelp"><?php echo $LANG["Not sure? Here's how to check"]; ?></a>

				<div class="modal fade" id="TypeHelp" tabindex="-1" role="dialog" aria-labelledby="notSureNwtwork" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel"><strong><?php echo $LANG['FIND YOUR WATCH TYPE']; ?></strong></h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<?= $category_data['tooltip_watchtype'] ?>
							</div>
						</div>
					</div>
				</div>

			</div>
		<?php
		}

		if (!empty($network_list)) { ?>
			<div id="network" class="block phone-details network m-0 p-0 clearfix">
				<h4 class="h4"><?= $n_i_array['network'] ?> <?= $network_title ?></h4>
				<div class="clearfix">
					<?php
					foreach ($network_list as $n_key => $network_data) { ?>
						<div class="custom-control custom-radio" id="depen_network<?= $network_data['id']?>">
							<input type="radio" name="check_network" class="custom-control-input check_network" id="<?= createSlug($network_data['network_name']) ?>" value="<?= $network_data['id'] ?>" <?php if ($order_item_data['network'] == $network_data['network_name']) {
																																																																																															echo 'checked="checked"';
																																																																																														} ?> data-nw_name="<?= strtolower($network_data['network_name']) ?>">
							<label class="slider-v2" for="<?= createSlug($network_data['network_name']) ?>" onclick=""></label>
							<label class="custom-control-label" for="<?= createSlug($network_data['network_name']) ?>">
								<?php
								if ($network_data['network_icon']) { ?>
									<img src="<?= SITE_URL . 'images/network/' . $network_data['network_icon'] ?>" alt="<?= $network_data['network_name'] ?>" title="<?= $network_data['network_name'] ?>">
								<?php
								} else {
									echo $network_data['network_name'];
								} ?>
							</label>
						</div>
					<?php
					} ?>
				</div>
				<div class="clearfix">
					<small id="network_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
				</div>

				<div class="network_price_mode_section_showhide  maxkyu-modified" style="display:none;">
					<h4 class="h4 pt-5"><?php echo $LANG['Has it been unlocked by carrier?']; ?></h4>
					<div class="clearfix pb-3">
						<div class="custom-control custom-radio">
							<input name="network_price_mode" class="custom-control-input network_price_mode" type="radio" id="network_price_unlock" value="unlock" <?php if($order_item_data['network_price_mode'] == "unlock"){echo 'checked="checked"';}?>>
							<label class="custom-control-label" for="network_price_unlock"><?php echo $LANG['YES']; ?></label>
						</div>
						<div class="custom-control custom-radio">
							<input name="network_price_mode" class="custom-control-input network_price_mode" type="radio" id="network_price_lock" value="lock" <?php if($order_item_data['network_price_mode'] == "lock"){echo 'checked="checked"';}?>>
							<label class="custom-control-label" for="network_price_lock"><?php echo $LANG['NO']; ?></label>
						</div>
					</div>
					<div class="clearfix">
						<small id="network_price_mode_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
					</div>
					<a class="suppot-ques" href="javascript:void();" data-toggle="modal" data-target="#NetworkHelp"><?php echo $LANG["Not sure? Here's how to check"]; ?></a>
					<div class="row info-section pt-5 network_price_lock_warning_showhide" style="display:none;">
						<div class="col-2 text-center">
							<i class="fas fa-exclamation-triangle"></i>
						</div>
						<div class="col-10">
							<!-- <p>A third-party unlocking fee ($50 - $150) will be deducted from your final offer. No offer will be made if the unlocking fee exceeds the value of your device. Unlock your device to the receive the best offer!</p> -->
							<p class="col-10-pad"><b><?php echo $LANG['No worries!']; ?></b> <?php echo $LANG['If your device is paid off, unlocking it is very easy. The best part is ... your offer will be much higher!']; ?>
							<a data-toggle="modal" data-target="#howToSell" href="javascript:void(0)"><b><?php echo $LANG["Here's how to request a sim unlock"]; ?></b></a>.
							<?php echo $LANG['A third party unlocking fee will be deducted from your offer if you trade in a sim-locked device.']; ?></p>
						</div>
					</div>
				</div>


				<div class="modal fade" id="NetworkHelp" tabindex="-1" role="dialog" aria-labelledby="notSureNwtwork" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel"><strong><?php echo $LANG['WATCH SIM LOCK STATUS']; ?></strong></h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<?= $category_data['tooltip_network'] ?>
							</div>
						</div>
					</div>
				</div>

			</div>
		<?php
		}

		if (!empty($storage_list)) { ?>
			<div id="storage" class="block phone-details storage m-0 p-0 clearfix">
				<h4 class="h4"><?= $n_i_array['storage'] ?> <?= $storage_title ?></h4>
				<div class="clearfix pb-3">
					<?php
					foreach ($storage_list as $s_key => $storage_data) {
						$s_storage_size = $storage_data['storage_size'] . $storage_data['storage_size_postfix']; ?>
						<div class="custom-control custom-radio" id="depen_storage<?= $storage_data['id']?>">
							<input type="radio" id="capacity<?= $s_storage_size ?>" name="check_capacity" value="<?= $storage_data['id'] ?>" <?php if ($order_item_data['storage'] != "" && $order_item_data['storage'] == $s_storage_size) {
																																																																	echo 'checked="checked"';
																																																																} ?> class="custom-control-input check_capacity">
							<label class="slider-v2" for="capacity<?= $s_storage_size ?>" onclick=""></label>
							<label class="custom-control-label" for="capacity<?= $s_storage_size ?>"><?= $s_storage_size ?></label>
						</div>
					<?php
					} ?>
				</div>
				<div class="clearfix">
					<small id="capacity_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
				</div>
				<a class="suppot-ques" href="javascript:void();" data-toggle="modal" data-target="#CapacityHelp"><?php echo $LANG["Not sure? Here's how to check"]; ?></a>

				<div class="modal fade" id="CapacityHelp" tabindex="-1" role="dialog" aria-labelledby="notSureNwtwork" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel"><strong><?php echo $LANG['FIND YOUR WATCH STORAGE CAPACITY']; ?></strong></h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<?= $category_data['tooltip_storage'] ?>
							</div>
						</div>
					</div>
				</div>

			</div>
		<?php
		}

		if (!empty($case_material_list)) { ?>
			<div id="case_material" class="block phone-details storage m-0 p-0 clearfix">
				<h4 class="h4"><?= $n_i_array['case_material'] ?> <?= $case_material_title ?></h4>
				<div class="clearfix pb-3">
					<?php
					foreach ($case_material_list as $csmt_key => $case_material_data) { ?>
						<div class="custom-control custom-radio" id="depen_case_material<?= $case_material_data['id']?>">
							<input type="radio" id="check_case_material<?= $csmt_key ?>" name="check_case_material" value="<?= $case_material_data['id'] ?>" <?php if ($order_item_data['case_material'] != "" && $order_item_data['case_material'] == $case_material_data['case_material_name']) {
																																																																									echo 'checked="checked"';
																																																																								} ?> class="custom-control-input check_case_material">
							<label class="slider-v2" for="check_case_material<?= $csmt_key ?>" onclick=""></label>
							<label class="custom-control-label" for="check_case_material<?= $csmt_key ?>"><?= $case_material_data['case_material_name'] ?></label>
						</div>
					<?php
					} ?>
				</div>
				<div class="clearfix">
					<small id="case_material_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
				</div>
				<a class="suppot-ques" href="javascript:void();" data-toggle="modal" data-target="#CaseMaterialHelp"><?php echo $LANG["Not sure? Here's how to check"]; ?></a>

				<div class="modal fade" id="CaseMaterialHelp" tabindex="-1" role="dialog" aria-labelledby="CaseMaterialHelp" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel"><strong><?php echo $LANG['FIND YOUR WATCH CASE FINISH']; ?></strong></h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<?= $category_data['tooltip_case_material'] ?>
							</div>
						</div>
					</div>
				</div>

			</div>
		<?php
		}

		if (!empty($case_size_list)) { ?>
			<div id="case_size" class="block phone-details storage m-0 p-0 clearfix">
				<h4 class="h4"><?= $n_i_array['case_size'] ?> <?= $case_size_title ?></h4>
				<div class="clearfix pb-3">
					<?php
					foreach ($case_size_list as $cs_key => $case_size_data) { ?>
						<div class="custom-control custom-radio" id="depen_case_size<?= $case_size_data['id']?>">
							<input type="radio" id="check_case_size<?= $cs_key ?>" name="check_case_size" value="<?= $case_size_data['id'] ?>" <?php if ($order_item_data['case_size'] != "" && $order_item_data['case_size'] == $case_size_data['case_size']) {
																																																																		echo 'checked="checked"';
																																																																	} ?> class="custom-control-input check_case_size">
							<label class="slider-v2" for="check_case_size<?= $cs_key ?>" onclick=""></label>
							<label class="custom-control-label" for="check_case_size<?= $cs_key ?>"><?= $case_size_data['case_size'] ?></label>
						</div>
					<?php
					} ?>
				</div>
				<div class="clearfix">
					<small id="case_size_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
				</div>
				<a class="suppot-ques" href="javascript:void();" data-toggle="modal" data-target="#CaseSizeHelp"><?php echo $LANG["Not sure? Here's how to check"]; ?></a>

				<div class="modal fade" id="CaseSizeHelp" tabindex="-1" role="dialog" aria-labelledby="CaseSizeHelp" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel"><strong><?php echo $LANG['FIND YOUR WATCH CASE SIZE']; ?></strong></h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<?= $category_data['tooltip_case_size'] ?>
							</div>
						</div>
					</div>
				</div>

			</div>
		<?php
		}

		if (!empty($color_list)) { ?>
			<div id="color" class="block phone-details phone-color m-0 p-0 clearfix maxkyu-modified">
				<h4 class="h4"><?= $n_i_array['color'] ?> <?= $color_title ?></h4>
				<?php
				foreach ($color_list as $cnc_key => $color_data) { ?>
					<div class="custom-control custom-radio" id="depen_color<?= $color_data['id']?>">
						<input type="radio" id="check_color<?= $cnc_key ?>" name="check_color" value="<?= $color_data['id'] ?>" <?php if ($order_item_data['color'] != "" && $order_item_data['color'] == $color_data['color_name']) {
																																																											echo 'checked="checked"';
																																																										} ?> class="check_color custom-control-input">
						<!-- <label class="slider-v2" for="check_color<?= $cnc_key ?>" onclick=""></label> -->
						<label class="custom-control-label" for="check_color<?= $cnc_key ?>">
							<span style="background:<?= $color_data['color_code'] ?>;"><i class="fas fa-check"></i></span> <?= $color_data['color_name'] ?>
						</label>
					</div>
				<?php
				} ?>
				<div class="clearfix">
					<small id="color_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
				</div>
			</div>
		<?php
		}

		if (!empty($condition_list)) { ?>
			<div id="condition" class="block phone-details condition m-0 p-0 pt-4">
				<h4 class="h4"><?= $n_i_array['condition'] ?> <?= $condition_title ?></h4>
				<div class="conditions clearfix">
					<?php
					$c = 0;
					foreach ($condition_list as $key => $condition_data) {
						$c = $c + 1; ?>
						<div class="custom-control custom-radio" id="depen_condition<?= $condition_data['id']?>">
							<input class="check_condition custom-control-input" type="radio" id="check_condition<?= $key ?>" data-key="<?= $key ?>" data-is_disabled_network="<?= $condition_data['disabled_network'] ?>" name="check_condition" value="<?= $condition_data['id'] ?>" <?php if ($order_item_data['condition'] != "" && $order_item_data['condition'] == $condition_data['condition_name']) {
																																																																																																																																					echo 'checked="checked"';
																																																																																																																																				} ?>>
							<label class="slider-v2" for="check_condition<?= $key ?>" onclick=""></label>
							<label class="custom-control-label" for="check_condition<?= $key ?>">
								<div class="condition-tab">
									<h5><?= $condition_data['condition_name'] ?></h5>
								</div>
								<div class="condition-block">
									<?= html_entity_decode($condition_data['condition_terms']) ?>
								</div>
							</label>
						</div>
					<?php
					} ?>
				</div>
				<div class="clearfix">
					<small id="condition_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
				</div>
			</div>
		<?php
		}

		if (!empty($accessories_list)) {
			$edit_accessories_array = array();
			if ($order_item_data['accessories'] != "") {
				$accessories = str_replace(": Yes", "", $order_item_data['accessories']);
				$edit_accessories_array = explode(", ", $accessories);
			} ?>
			<div id="accessories" class="block phone-details accessories m-0 p-0">
				<h4 class="h4"><?= $n_i_array['accessories'] ?> <?= $accessories_title ?></h4>
				<h3 class="h3"><?php echo $LANG['SELECT AS APPLICABLE']; ?></h3>
				<div class="accessories-block clearfix">
					<?php
					foreach ($accessories_list as $cnc_key => $accessories_data) { ?>
						<div class="custom-control custom-radio" id="depen_accessories<?= $accessories_data['id']?>">
							<input class="check_accessories custom-control-input" type="checkbox" id="check_accessories<?= $cnc_key ?>" name="check_accessories[]" value="<?= $accessories_data['id'] ?>" <?php if ($order_item_data['accessories'] != "" && in_array($accessories_data['accessories_name'], $edit_accessories_array)) {
																																																																																															echo 'checked="checked"';
																																																																																														} ?>>
							<label class="slider-v2" for="check_accessories<?= $cnc_key ?>" onclick=""></label>
							<label class="custom-control-label" for="check_accessories<?= $cnc_key ?>"><span class="span-active"></span><?= $accessories_data['accessories_name'] ?></label>
						</div>
					<?php
					} ?>
				</div>
			</div>
		<?php
		} ?>

		<div id="get-offer" class="block phone-details mt-0 pt-0 get-offer ml-0 mr-0 pl-0 pr-0 content phone-content">
			<div class="addtocart_spining_icon" style="display:none;"></div>
			<div class="get_offer_section_showhide hideButtons">
				<div class="row pt-3 pb-2">
					<div class="col-md-6">
						<h4 class="text-uppercase"><?php echo $LANG['Your Device is valued at']; ?></h4>
						<h4 class="total-price show_final_amt"></h4>
						<p class="price_non_user"></p>
						<p><?php echo $LANG['21 days price lock guarantee']; ?></p>
					</div>
					<div class="col-md-6 text-right">
						<img class="pb-4 sealed-logo" src="<?= SITE_URL ?>images/1GuyGadgetRibbon.png" alt="">
					</div>
				</div>
				<div class="row pt-4  border-divider">
					<div class="col-md-2 col-3 text-center">
						<i class="fas fa-exclamation-triangle"></i>
					</div>
					<div class="col-md-10 col-9">
						<ul>
							<li>
								<h3><?php echo $LANG['We do not buy lost or stolen devices.']; ?></h3>
								<a href="#" class="suppot-ques" data-toggle="modal" data-target="#IsMyDeviceBlackListed"><?php echo $LANG["Not sure? Here's how to check"]; ?></a>
							</li>
							<li>
								<h3><?php echo $LANG['We do not buy devices with unpaid bills or under financial contracts.']; ?></h3>
								<a href="#" class="suppot-ques" data-toggle="modal" data-target="#IsMyDevicePaidOff"><?php echo $LANG["Not sure? Here's how to check"]; ?></a>
							</li>
						</ul>
					</div>
				</div>
				<div class="custom-control custom-checkbox pt-4 pb-4">
					<input type="checkbox" class="custom-control-input" id="device_terms" value="1">
					<label class="custom-control-label" for="device_terms"><?php echo $LANG['My device does not violate the above warnings.']; ?></label>
					<div class="clearfix">
						<small id="device_terms_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<a href="javascript:void(0)" id="prevBtnCart" class="btn btn-secondary float-left text-uppercase"><?php echo $LANG['BACK']; ?></a>
						<button type="submit" onclick="sendMail()" id="addToCart" name="sell_this_device" class="btn float-right btn-success btn-lg text-uppercase"><strong><?php echo $LANG['Continue ']; ?></strong><i class="far fa-arrow-alt-circle-right"></i></button>
					</div>
				</div>
			</div>
			
                <div class="get_offer_section_showhide_1 hideButtons">

					<div class="row pt-4 ">
						<div class="col-md-2 col-3">
							<i style="color:#FF0000; padding-top:0px;" class="fas fa-exclamation-triangle text-center"></i>
						</div>
						<div class="col-md-10 col-9">
							<ul>
								<li>
									<h3><?php echo $LANG['Unfortunately, we cannot make an offer for your device at this time because our system found your device to have no value.']; ?></h3>
								</li>

							</ul>
						</div>
					</div>

					<div class="row">
						<div style="top:30px;margin-bottom:20px;" class="col-md-12">
							<a  href="javascript:void(0)" id="prevBtnCart_1" class="btn btn-secondary float-left text-uppercase"><?php echo $LANG['BACK']; ?></a>
						</div>
					</div>
				</div>			
			
		</div>

		<div class="step-navigation clearfix">
			<a href="javascript:void(0)" id="prevBtn" class="btn float-left btn-secondary btn-lg hideButtons"><?php echo $LANG['BACK']; ?></a>
			<a href="javascript:void(0)" id="nextBtn" class="btn float-right btn-primary btn-lg hideButtons"><?php echo $LANG['NEXT']; ?></a>
			<a href="javascript:void(0)" id="getOfferBtn" class="btn float-right btn-success btn-lg getOfferBtn hideButtons"><strong><?php echo $LANG['GET OFFER']; ?></strong></a>
		</div>
	</div>
</div>

<div class="modal fade" id="howToSell" tabindex="-1" role="dialog" aria-labelledby="howToSellTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="howToSellTitle"><i class="fas fa-info-circle"></i> <?php echo $LANG['Requesting a Device Unlock from a Carrier']; ?></h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p><?php echo $LANG['If we could, we would put in a device unlock request with your carrier on your behalf.']; ?> 
                <?php echo $LANG["Carriers only allow the origninal owner to request a device unlock. Don't worry, it will only take 10 -20 mins on average."]; ?>
                <?php echo $LANG['Here is how to do it for all 4 major carriers and others:']; ?>
                    <ul style="list-style-type:disc; margin:20px;">
                        <li><b>AT&T:</b> <?php echo $LANG['Unlock your AT&T device using']; ?> <a href="https://www.att.com/deviceunlock/#/" target="_blank"><?php echo $LANG["AT&T's online unlocking utility"]; ?></a>.</li>
                        <li><b>Sprint:</b> <?php echo $LANG['Call Sprint on']; ?> <b>1 (855) 639-4644</b> <?php echo $LANG['to request a device unlock.']; ?></li>
                        <li><b>T-mobile:</b> <?php echo $LANG['Call T-mobile on']; ?> <b>1 (877) 746-0909</b> <?php echo $LANG['to request a device unlock.']; ?></li>
                        <li><b>Verizon:</b> <?php echo $LANG['Call verizon on']; ?> <b>1 (888) 294-6804</b> <?php echo $LANG['to request a device unlock.']; ?></li>
                        <li><b><?php echo $LANG['Other Carriers']; ?>:</b> <?php echo $LANG['Call your customer service to request a device unlock.']; ?></li>
                    </ul>
                </p>
            </div>
        </div>
    </div>
</div>