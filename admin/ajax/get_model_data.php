<?php 
include("../_config/config.php");
include("../include/functions.php");

$item_id = $post['item_id'];

$query=mysqli_query($db,"SELECT * FROM order_items WHERE id='".$item_id."'");
$order_items_data=mysqli_fetch_assoc($query);

$b_query=mysqli_query($db,"SELECT * FROM brand WHERE published=1 ORDER BY id DESC");

$em_query=mysqli_query($db,"SELECT m.*, d.title AS device_title, d.device_img, d.sef_url, b.title AS brand_title, b.id AS brand_id FROM mobile AS m LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE m.id='".$order_items_data['model_id']."' ORDER BY m.id DESC");
$exist_model_data=mysqli_fetch_assoc($em_query);

//$d_query=mysqli_query($db,"SELECT * FROM devices WHERE published=1 AND brand_id='".$exist_model_data['brand_id']."'");
$d_query=mysqli_query($db,"SELECT d.id, d.title FROM mobile AS m LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE m.brand_id='".$exist_model_data['brand_id']."' GROUP BY m.device_id ORDER BY d.id DESC");

$m_query=mysqli_query($db,"SELECT m.*, d.title AS device_title, d.device_img, d.sef_url, b.title AS brand_title, b.id AS brand_id FROM mobile AS m LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE m.device_id='".$exist_model_data['device_id']."' ORDER BY m.id DESC");
?>

<div class="row">
	<article class="span6 data-block">
		<section>
			<div class="row-fluid">
				<div class="control-group">
					<label class="control-label" for="input">Brand: </label>
					<div class="controls">
					  <select name="quote_make" id="quote_make" onchange="getWhatWrongDevice(this.value);" required="required">
						<option value="">Choose Brand</option>
						<?php
						while($brand_list=mysqli_fetch_assoc($b_query)) { ?>
							<option value="<?=$brand_list['id']?>" <?php if($brand_list['id'] == $exist_model_data['brand_id']){echo 'selected="selected"';}?>><?=$brand_list['title']?></option>
						<?php
						} ?>
					  </select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input">Device: </label>
					<div class="controls">
						<select class="add-quote-device2" name="quote_device" id="quote_device2" onchange="getWhatWrongModel(this.value);" required="required">
							<option value="">Choose Device</option>
							<?php
							while($device_list=mysqli_fetch_assoc($d_query)) { ?>
								<option value="<?=$device_list['id']?>" <?php if($device_list['id'] == $exist_model_data['device_id']){echo 'selected="selected"';}?>><?=$device_list['title']?></option>
							<?php
							} ?>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input">Model: </label>
					<div class="controls">
						<select class="add-quote-model2" name="quote_model" id="quote_model2" required="required" onchange="getModelDetails(this.value,'');">
							<option value="">Choose Model</option>
							<?php
							while($top_search_data=mysqli_fetch_assoc($m_query)) { ?>
								<option value="<?=$top_search_data['id']?>" <?php if($top_search_data['id'] == $exist_model_data['id']){echo 'selected="selected"';}?>><?=$top_search_data['title']?></option>
							<?php
							} ?>
						</select>
					</div>
				</div>
				
				<div id="quote_model_details" style="margin-top:15px;"></div>
			</div>
		</section>
	</article>
</div>

<script>
function getWhatWrongDevice(val)
{
	var brand_id = val.trim();
	if(brand_id) {
		post_data = "brand_id="+brand_id+"&token=<?=get_unique_id_on_load()?>";
		jQuery(document).ready(function($){
			$.ajax({
				type: "POST",
				url:"ajax/get_quote_device.php",
				data:post_data,
				success:function(data) {
					if(data!="") {
						$('#quote_device2').html(data);
						$('#quote_model2').html('<option value="">Choose Model</option>');
						$('#quote_model_details').html('');
					} else {
						alert('Something wrong so please try again...');
						return false;
					}
				}
			});
		});
	}
}

function getWhatWrongModel(val)
{
	var device_id = val.trim();
	if(device_id) {
		post_data = "device_id="+device_id+"&token=<?=get_unique_id_on_load()?>";
		jQuery(document).ready(function($){
			$.ajax({
				type: "POST",
				url:"ajax/get_quote_model.php",
				data:post_data,
				success:function(data) {
					if(data!="") {
						$('#quote_model2').html(data);
						$('#quote_model_details').html('');
					} else {
						alert('Something wrong so please try again...');
						return false;
					}
				}
			});
		});
	}
}

function getModelDetails(val,mode)
{
	var model_id = val.trim();
	if(model_id) {
		//if(mode == "onload") {
			post_data = "model_id="+model_id+"&item_id=<?=$item_id?>&token=<?=get_unique_id_on_load()?>";
		//} else {
			//post_data = "model_id="+model_id+"&token=<?=get_unique_id_on_load()?>";
		//}
		jQuery(document).ready(function($){
			$.ajax({
				type: "POST",
				url:"ajax/get_quote_model_details.php",
				data:post_data,
				success:function(data) {
					if(data!="") {
						$('#quote_model_details').html(data);
					} else {
						alert('Something wrong so please try again...');
						return false;
					}
				}
			});
		});
	}
}

getModelDetails('<?=$exist_model_data['id']?>','onload');
</script>