<?php
require_once("../../../admin/_config/config.php");
require_once("../../../admin/include/functions.php");

if(empty($_SESSION['is_admin']) || empty($_SESSION['admin_username'])) {
    echo 'Direct access not allowed';
	exit();
}

$order_id=$_REQUEST['order_id'];

//Get order batch data, path of this function (get_order_data) admin/include/functions.php
$order_detail = get_order_data($order_id);
if(empty($order_detail)) {
	echo 'Direct access not allowed';
	exit();
}

//Get order price based on orderID, path of this function (get_order_price) admin/include/functions.php
$sum_of_orders=get_order_price($order_id);

//Get order item list based on orderID, path of this function (get_order_item_list) admin/include/functions.php
$order_item_list = get_order_item_list($order_id);

if($order_detail['promocode_id']>0 && $order_detail['promocode_amt']>0) {
	$promocode_amt = $order_detail['promocode_amt'];
	$discount_amt_label = "Surcharge:";
	if($order_detail['discount_type']=="percentage")
		$discount_amt_label = "Surcharge (".$order_detail['discount']."% of Initial Quote):";

	$total_of_order = $sum_of_orders+$order_detail['promocode_amt'];
	$is_promocode_exist = true;
} else {
	$total_of_order = $sum_of_orders;
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Print Order</title>
<link rel="stylesheet" type="text/css" title="stylesheet" href="<?=SITE_URL?>css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" title="stylesheet" href="<?=SITE_URL?>css/style.css">
<link rel="stylesheet" type="text/css" title="stylesheet" href="<?=SITE_URL?>css/print.css" media="print,screen">
<script src="<?=SITE_URL?>js/jquery.min.js" type="text/javascript"></script>
</head>
<body>
  <section class="print" style="padding-top:50px; margin-bottom:50px;">
    <div class="container">
      <div class="row hide_button">
        <div class="col-md-6">
          <input name="cancelButton" type="button" value="Back to My Order" id="cancelButton" class="btn btn-link" onClick="window.close();" />
        </div>
        <div class="col-md-6">
          <input name="checkout" type="button" value="Print Order" id="checkoutButton" class="btn btn-link pull-right" onClick="javascript:printit()" style="float:right;" />
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
           <table>
             <tr>
               <td class="divider" style="height:10px;"></td>
             </tr>
           </table>
        </div>
      </div>
		  <div class="row">
  			<div class="col-md-12">
          <table class="table table-address">
            <tr>
              <td class="block content-block" align="left">
                  <p><strong><?=$order_detail['first_name'].' '.$order_detail['last_name']?></strong><br />
                  <?=$order_detail['address']?><br />
                  <?=($order_detail['address2']?$order_detail['address2'].',<br>':'')?>
				  <?=$order_detail['city'].' '.$order_detail['state'].' '.$order_detail['postcode'].'<br>'?>
				  <?=($order_detail['country']?$order_detail['country'].'<br>':'')?>
                  <?=($order_detail['phone']?'+'.$order_detail['phone']:'')?></p>
              </td>
              <td class="divider"></td>
              <td class="block content-block" align="right">
			  	  <img width="150" src="<?=SITE_URL?>images/<?=$general_setting_data['logo']?>" style="margin-bottom:10px;">
                  <p><?php /*?><strong><?=$general_setting_data['company_name']?></strong><br />
                  <?=$general_setting_data['company_address']?><br />
                  <?=$general_setting_data['company_city']?><br />
                  <?=$general_setting_data['company_state']?><br />
                  <?=$general_setting_data['company_zipcode']?><br />
                  <?=$general_setting_data['company_country']?><br />
                  <?=$general_setting_data['company_phone']?></p><?php */?>
				  <?='<b>'.$general_setting_data['company_name'].'</b><br>
          '.$general_setting_data['company_address'].',<br>
		  '.$general_setting_data['company_city'].' '.$general_setting_data['company_state'].' '.$general_setting_data['company_zipcode'].'<br>
		  '.$general_setting_data['company_country'].'<br>
          '.$general_setting_data['company_phone']?></p>
                </td>
            </tr>
			<tr>
      </tr>
          </table>
		  
          <div class="alert alert-warning">
            IMPORTANT: Please enclose this delivery note with your mobile phone(s)/device(s) into the <?=$general_setting_data['site_name']?> FREEPOST bag.
          </div>
          <table cell-padding="0" cell-spacing="0" border="0;" width="100%">
		  	<tr>
				<td colspan="6" align="center"><h3>Delivery Note</h3></td>
			</tr>
		</table>
		<?php /*?><table cell-padding="0" cell-spacing="0" border="0;" width="100%">
			  <tr style="padding-top:5px;">
				 <td colspan="6"><strong>Your order number is: <?=$order_id?></strong><br><br>You have sold the following device (s):</td>
			  </tr>
			 </table><?php */?>
			 <table class="table table-bordered">
            <tr>
              <td align="left" valign="middle"><strong>Order No: </strong><?=$order_id?></td>
          	  <td align="left" valign="middle"><strong>Order Status: </strong><?=ucwords(str_replace('_',' ',$order_detail['status']))?></td>
              <td align="left" valign="middle"><strong>Order Date: </strong><?=date("m-d-Y",strtotime($order_detail['date']))?></td>
              <td align="left" valign="middle"><strong>Approved Date: </strong><?=($order_detail['approved_date']=="0000-00-00 00:00:00"?'--':date("m-d-Y",strtotime($order_detail['approved_date'])))?></td>
              <td align="left" valign="middle"><strong> Expires Date: </strong><?=($order_detail['expire_date']!="0000-00-00 00:00:00"?date("m-d-Y",strtotime($order_detail['expire_date'])):'--')?></td>
              <td align="left" valign="middle"><strong>Payment Method: </strong><?=ucfirst($order_detail['payment_method'])?></td>
            </tr>
          </table>
          <div class="sell-item-table clearfix">
            <table class="table">
              <tr>
              	<td width="2%" align="left" valign="middle"><strong>#</strong></td>
                <td width="62%" align="left" valign="middle"><strong>Handset/Device Type</strong></td>
				<td width="18%" align="left" valign="middle"><strong>IMEI Number</strong></td>
            	<td width="8%" align="left" valign="middle"><strong>Quantity</strong></td>
                <td width="10%" align="left" valign="middle"><strong>Price</strong></td>
              </tr>
              <?php
              foreach($order_item_list as $order_item_list_data) {
                $order_item_data = get_order_item($order_item_list_data['id'],'print'); ?>
				<tr>
				   <td class="divider" colspan="5" style="height:10px;"></td>
				</tr>
				<tr>
				   <td width="2%" align="left" valign="middle"><?=$n=$n+1?></td>
				   <td width="62%" align="left" valign="middle"><?=$order_item_data['device_title'].'<br>'.$order_item_data['device_info']?></td>
				   <td width="18%" align="left" valign="middle"><?=$order_item_data['data']['imei_number']?></td>
				   <td width="8%" align="left" valign="middle"><?=$order_item_list_data['quantity']?></td>
				   <td width="10%" align="left" valign="middle"><?=amount_fomat($order_item_list_data['price'])?></td>
				</tr>
              <?php
              } ?>
            </table>
          </div>
          <div class="sell-item-table-total">
            <div class="pull-right">
              <div class="button-row text-right clearfix">
                <div class="btn"><strong>Sell Order Total:</strong></div>
				<div class="btn btn-price"><strong><?=($sum_of_orders>0?amount_fomat($sum_of_orders):'')?></strong></div>
              </div>
              <?php
              if($promocode_amt>0) { ?>
				  <div class="button-row text-right clearfix">
					<div class="btn"><strong><?=$discount_amt_label?></strong></div>
					<div class="btn btn-price"><strong><?=amount_fomat($promocode_amt)?></strong></div>
				  </div>
				  <div class="button-row text-right clearfix">
					<div class="btn"><strong>Total:</strong></div>
					<div class="btn <?php /*?>btn-grand-total<?php */?> btn-price"><strong><?=amount_fomat($total_of_order)?></strong></div>
				  </div>
              <?php
              } ?>
            </div>
          </div>
		  
		  <table cell-padding="0" cell-spacing="0" border="0;" width="100%" style="padding:10px 0px 2px 0px;">
	<tbody>
		<tr style="padding-top:10px;">
		 <td colspan="3">
		 	<?php /*?>The payment method you have chosen is: <?=ucfirst($order_detail['payment_method'])?><br><br><?php */?>
			<strong>Please include following.</strong><br> 
			&nbsp;&nbsp;1. Device(s) Selected<br>
			&nbsp;&nbsp;2. This Delivery Note<br><br>

		 	<strong>Please help our testers process your phone quicker (optional)</strong> <br>
			Please Reset Lock codes, or supply your user Lock code: ........................<br><br>
<strong>The Sooner you send your item(s), the sooner you get paid!</strong><br>

Don&#39;t Delay; your items need to reach to us within <?=$order_expired_days?> days or the price we offered you could go
down.<br><br>
We&#39;ll email you once we received your item and provided, they meet our terms and conditions,
we&#39;ll make payment on the very same day!<br><br>

If you need any further support, please do not hesitate to contact us at <?=$site_email?> or call <?=$site_phone?> during business hours.<br><br>

Regards,<br>
Team Sellyourmobiles.com

		 </td>
	  </tr>
	  <tr>
	  	<td align="left"><img width="150" src="<?=SITE_URL.'images/'.$general_setting_data['logo']?>"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
</tbody>
</table>


        </div>
      </div>
    </div>
  </section>
</body>
</html>

<script type="text/javascript">
function printit(){
	jQuery('.hide_button').hide();
	if(window.print) {
		window.print() ;
	}

	if(window.close) {
		jQuery('.hide_button').show();
	}
}
</script>
