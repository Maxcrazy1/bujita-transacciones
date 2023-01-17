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
$user_id = $order_detail['user_id'];

//Get user data, path of this function (get_user_data) admin/include/functions.php
$user_data = get_user_data($user_id);

/*require_once(CP_ROOT_PATH."/libraries/BarcodeQR.php");

// set BarcodeQR object
$qr = new BarcodeQR();

$margin='3';

$qr->text($order_id);
$qr->draw(100,SITE_URL.'images/qrcode.png',$margin);*/

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
.divider{
  width:10%;
}
.hdivider{
  height:0px;
}
.title{
  font-size:18px;
  font-weight:bold;
}
</style>
EOF;

$html.='<table cell-padding="0" cell-spacing="0" border="0;" width="100%" style="">
<tr>
    <td colspan="3" class="small-text"></td>
  </tr>
  <tr>
    <td class="block small-text">
    </td>
    <td class="divider"></td>
    <td class="block small-text">
    </td>
  </tr>
<tr>
  <td class="block-border" width="46%"><table cell-padding="0" cell-spacing="0" border="0;" width="100%" style="padding:17.2px; border:1px solid #333">
      <tr>
    <td style="border:1px solid #333"><table cell-padding="0" cell-spacing="0" border="0;" width="100%"><tr>
        <td class="title">1ST CLASS</td>
    <td align="right"><img src="'.SITE_URL.'images/royal_mail_stamp.png" width="40"></td></tr>
    </table></td>
      </tr>
      <tr>
        <td style="border:1px solid #333;">Delivered by ROYAL MAIL Postage paid GB</td>
      </tr>
      <tr>
        <td style="border:1px solid #333; text-align:center;"><img src="'.SITE_URL.'images/royal_mail_postage_paid_logo.png" width="150"></td>
      </tr>
      <tr>
        <td class="small-text" style="border:1px solid #333; text-align:center;">
        <b>'.$general_setting_data['company_name'].'</b><br>
        '.$general_setting_data['company_address'].',<br>
    '.$general_setting_data['company_city'].' '.$general_setting_data['company_state'].' '.$general_setting_data['company_zipcode'].'<br>
		  '.$general_setting_data['company_country'].'<br>
        '.$general_setting_data['company_phone'].'
        </td>
      </tr>
      <tr>
        <td class="small-text" style="border:1px solid #333; text-align:center;">
        <b>Sender</b><br />
        '.$user_data['name'].'<br>
        '.$user_data['address'].',<br>
    '.($user_data['address2']?$user_data['address2'].',<br>':'').'
        '.$user_data['city'].' '.$user_data['state'].' '.$user_data['postcode'].'<br>
		'.($user_data['country']?$user_data['country'].'<br>':'').'
    '.($user_data['phone']?'+'.$user_data['phone']:'').'
        </td>
      </tr>
      <tr>
        <td style="border:1px solid #333; text-align:center;">Customer reference: <b>'.$order_id.'</b></td>
      </tr>
    </table>
  </td>
  <td width="6%" style="">&nbsp;</td>
  <td class="block-border" width="46%"><table cell-padding="0" cell-spacing="0" border="0;" width="100%"  style="padding:29.2px; border:1px solid #333">
      <tr>
        <td class="title">Special Delivery</td>
      </tr>
      <tr>
        <td style="border:1px solid #333;">POSTAGE TO BE PAID BY SENDER</td>
      </tr>
      <tr>
        <td class="small-text" style="border:1px solid #333;">
        <b>'.$general_setting_data['company_name'].'</b><br>
        '.$general_setting_data['company_address'].',<br>
    '.$general_setting_data['company_city'].' '.$general_setting_data['company_state'].' '.$general_setting_data['company_zipcode'].'<br>
		  '.$general_setting_data['company_country'].'<br>
        '.$general_setting_data['company_phone'].'
        </td>
      </tr>
      <tr>
        <td class="small-text" style="border:1px solid #333;">
        <b>Sender</b><br />
       '.$user_data['name'].'<br>
        '.$user_data['address'].',<br>
    '.($user_data['address2']?$user_data['address2'].',<br>':'').'
        '.$user_data['city'].' '.$user_data['state'].' '.$user_data['postcode'].'<br>
		'.($user_data['country']?$user_data['country'].'<br>':'').'
    '.($user_data['phone']?'+'.$user_data['phone']:'').'
        </td>
      </tr>
      <tr>
        <td style="text-align:center; border:1px solid #333;">
          Customer reference: <b>'.$order_id.'</b>
        </td>
      </tr>
    </table>
  </td>
</tr>
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
$pdf->SetFooterMargin(16);

$pdf->SetMargins(28.5, 12, 28.5, true); // set the margins 
// add a page
// $pdf->AddPage('L','A4');

$pdf->AddPage('L', 'A4', false, false);
// $pdf->AddPage('L', array(210,97));
//$pdf->Cell(0, 0, 'A4 PORTRAIT', 1, 1, 'C');

// $page_format= array('Rotate'=>-90); 
// $pdf->AddPage('P', $page_format, false, false); 
// $pdf->SetMargins(28.5, 16, 28.5, true); // set the margins 
$pdf->writeHtml($html);

ob_end_clean();

$pdf->Output('pdf/free_post_label-'.date('Y-m-d-H-i-s').'.pdf', 'I');
?>
