<?php
require_once("../../../admin/_config/config.php");
require_once("../../../admin/include/functions.php");

if(empty($_SESSION['is_admin']) || empty($_SESSION['admin_username'])) {
    echo 'Direct access not allowed';
	exit();
}

$order_id=$_REQUEST['order_id'];
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

$express_service = $order_detail['express_service'];
$express_service_price = $order_detail['express_service_price'];
$shipping_insurance = $order_detail['shipping_insurance'];
$shipping_insurance_per = $order_detail['shipping_insurance_per'];

$f_express_service_price = 0;
$f_shipping_insurance_price = 0;
if($express_service == '1') {
	$f_express_service_price = $express_service_price;
}
if($shipping_insurance == '1') {
	$f_shipping_insurance_price = ($sum_of_orders*$shipping_insurance_per/100);
}

$html = <<<EOF
<!-- EXAMPLE OF CSS STYLE -->
<style>
table,td{
  margin:0;
  padding:0;
}
.small-text{
  font-size:10px;
  text-align:center;
}
.block{
  width:45%;
}
.block-border{
  border:1px dashed #ddd;
}
.title{
  font-size:20px;
  font-weight:bold;
}
.tbl-border-radius{
border-radius:10px;
}
</style>
EOF;

$html.='
<table cell-padding="0" cell-spacing="0" border="0;" width="100%" style="padding:5px 0px 5px 0px;">
	<tbody>
	  <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td align="center"><img width="250" src="'.SITE_URL.'images/'.$general_setting_data['logo'].'"></td>
	  </tr>
	  <tr>
		<td colspan="3">
			Hola! , '.$order_detail['first_name'].' '.$order_detail['last_name'].',<br><br>
			Gracias por elegir convertir tu viejo móvil en efectivo con '.$company_name.'.<br>
			Esperamos que haya encontrado nuestro proceso en línea simple, rápido y amigable.
		</td>
	  </tr>
	  <tr style="padding-top:5px;">
		 <td colspan="3"><strong>Tu número de Pedido es: '.$order_id.'</strong><br>Indique el número de pedido anterior en cualquier comunicación.</td>
	  </tr>
	  <tr style="padding-top:5px;">
		 <td colspan="3"><strong>Has vendido el siguiente dispositivo (s):</strong></td>
	  </tr>
	</tbody>
</table>

<table cell-padding="0" cell-spacing="0" border="0;" width="100%" style="padding:5px 5px 5px 5px;background-color:#dddddd;" class="tbl-border-radius">
	<tbody>
		<tr>
			<th width="59%"><strong>Tipo de teléfono/dispositivo</strong></th>
			<th width="18%"><strong>Número IMEI</strong></th>
			<th width="8%"><strong>Cantidad</strong></th>
			<th width="15%"><strong>Precio</strong></th>
		</tr>';
		
		foreach($order_item_list as $order_item_list_data) {
			$order_item_data = get_order_item($order_item_list_data['id'],'print');
			$html.='<tr>';
				$html.='<td width="59%" valign="middle">'.$order_item_data['device_title'].'<br>'.$order_item_data['device_info'].'</td>';
				$html.='<td width="18%" valign="middle">'.$order_item_data['data']['imei_number'].'</td>';
				$html.='<td width="8%" valign="middle">'.$order_item_list_data['quantity'].'</td>';
				$html.='<td width="15%" valign="middle">'.amount_fomat($order_item_list_data['price']).'</td>';
			$html.='</tr>';
		}

		$html.='<tr>
			<td colspan="3" align="right"><strong>Sell Order Total:</strong></td>
			<td><strong>'.($sum_of_orders>0?amount_fomat($sum_of_orders):'').'</strong></td>
		</tr>';
	  
		if($promocode_amt>0 || $f_express_service_price>0 || $f_shipping_insurance_price>0) {
		  if($promocode_amt>0) {
		  $html.='<tr>
			<td colspan="3" align="right"><strong>'.$discount_amt_label.'</strong></td>
			<td><strong>'.amount_fomat($promocode_amt).'</strong></td>
		  </tr>';
		  }
		  if($f_express_service_price>0) {
		  $html.='<tr>
			<td colspan="3" align="right"><strong>Express Service</strong></td>
			<td><strong>-'.amount_fomat($f_express_service_price).'</strong></td>
		  </tr>';
		  }
		  if($f_shipping_insurance_price>0) {
		  $html.='<tr>
			<td colspan="3" align="right"><strong>Shipping Insurance</strong></td>
			<td><strong>-'.amount_fomat($f_shipping_insurance_price).'</strong></td>
		  </tr>';
		  }
		  
		  $html.='<tr>
			<td colspan="3" align="right"><strong>Total:</strong></td>
			<td><strong>'.amount_fomat(($total_of_order - $f_express_service_price - $f_shipping_insurance_price)).'</strong></td>
		  </tr>';
		}
	$html.='</tbody>
</table>
<table cell-padding="0" cell-spacing="0" border="0;" width="100%" style="padding:10px 0px 2px 0px;">
	<tbody>
		<tr style="padding-top:5px;">
		 <td colspan="3">
		 	El método de pago que ha elegido es: '.ucfirst($order_detail['payment_method']).'<br><br>
		 	<strong>Hemos adjuntado lo siguiente con esta carta:</strong> <br>
			&nbsp;&nbsp;1. Nota de entrega: imprima e incluya con su(s) dispositivo(s).<br>
			&nbsp;&nbsp;2. Etiqueta de devolución: imprima y adjunte al exterior de un sobre/caja acolchados<br><br>
<strong>¡Cuanto antes envíe sus artículos, antes recibirá el pago!</strong><br>

Don&#39;t Delay; sus artículos deben llegar a nosotros dentro de '.$order_expired_days.' días o el precio que te ofrecimos te podrías ir abajo.<br>
We&#39;ll enviarle un correo electrónico una vez que recibimos su artículo y siempre que cumpla con nuestros términos y condiciones,
we&#39;ll hacer el pago en el mismo día!<br><br>

<strong>Manteniéndote actualizado </strong><br>
Para realizar un seguimiento o ver el progreso de su pedido, simplemente haga clic en Mi cuenta e ingrese su correo electrónico y
Contraseña, o contáctenos en '.$site_email.' o llamar '.$site_phone.' durante los negocios horas.<br><br>

Saludos,<br>
Equipo '.$company_name.'

		 </td>
	  </tr>
	  <tr>
	  	<td align="center"><img width="250" src="'.SITE_URL.'images/'.$general_setting_data['logo'].'"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>';
$html.='</tbody>
</table>';

//echo $html;
//exit;

require_once(CP_ROOT_PATH.'/libraries/tcpdf/config/tcpdf_config.php');
require_once(CP_ROOT_PATH.'/libraries/tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF();

// set document information
$pdf->SetCreator($general_setting_data['from_name']);
$pdf->SetAuthor($general_setting_data['from_name']);
$pdf->SetTitle($general_setting_data['from_name']);

$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);

// add a page
$pdf->AddPage();

$pdf->writeHtml($html);

ob_end_clean();

$pdf->Output('pdf/free_post_label-'.date('Y-m-d-H-i-s').'.pdf', 'I');
?>

