<?php
/* vim: set ts=4 sw=4 sts=4 et: */
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| X-Cart                                                                      |
| Copyright (c) 2001-2011 Ruslan R. Fazlyev <rrf@x-cart.com>                  |
| All rights reserved.                                                        |
+-----------------------------------------------------------------------------+
| PLEASE READ  THE FULL TEXT OF SOFTWARE LICENSE AGREEMENT IN THE "COPYRIGHT" |
| FILE PROVIDED WITH THIS DISTRIBUTION. THE AGREEMENT TEXT IS ALSO AVAILABLE  |
| AT THE FOLLOWING URL: http://www.x-cart.com/license.php                     |
|                                                                             |
| THIS  AGREEMENT  EXPRESSES  THE  TERMS  AND CONDITIONS ON WHICH YOU MAY USE |
| THIS SOFTWARE   PROGRAM   AND  ASSOCIATED  DOCUMENTATION   THAT  RUSLAN  R. |
| FAZLYEV (hereinafter  referred to as "THE AUTHOR") IS FURNISHING  OR MAKING |
| AVAILABLE TO YOU WITH  THIS  AGREEMENT  (COLLECTIVELY,  THE  "SOFTWARE").   |
| PLEASE   REVIEW   THE  TERMS  AND   CONDITIONS  OF  THIS  LICENSE AGREEMENT |
| CAREFULLY   BEFORE   INSTALLING   OR  USING  THE  SOFTWARE.  BY INSTALLING, |
| COPYING   OR   OTHERWISE   USING   THE   SOFTWARE,  YOU  AND  YOUR  COMPANY |
| (COLLECTIVELY,  "YOU")  ARE  ACCEPTING  AND AGREEING  TO  THE TERMS OF THIS |
| LICENSE   AGREEMENT.   IF  YOU    ARE  NOT  WILLING   TO  BE  BOUND BY THIS |
| AGREEMENT, DO  NOT INSTALL OR USE THE SOFTWARE.  VARIOUS   COPYRIGHTS   AND |
| OTHER   INTELLECTUAL   PROPERTY   RIGHTS    PROTECT   THE   SOFTWARE.  THIS |
| AGREEMENT IS A LICENSE AGREEMENT THAT GIVES  YOU  LIMITED  RIGHTS   TO  USE |
| THE  SOFTWARE   AND  NOT  AN  AGREEMENT  FOR SALE OR FOR  TRANSFER OF TITLE.|
| THE AUTHOR RETAINS ALL RIGHTS NOT EXPRESSLY GRANTED BY THIS AGREEMENT.      |
|                                                                             |
| The Initial Developer of the Original Code is Ruslan R. Fazlyev             |
| Portions created by Ruslan R. Fazlyev are Copyright (C) 2001-2011           |
| Ruslan R. Fazlyev. All Rights Reserved.                                     |
+-----------------------------------------------------------------------------+
\*****************************************************************************/

/**
 * "ePDQ - MPI XML" payment module (credit card processor)
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Payment interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-2011 Ruslan R. Fazlyev <rrf@x-cart.com>
 * @license    http://www.x-cart.com/license.php X-Cart license agreement
 * @version    $Id: cc_epdq_xml.php,v 1.12.2.1 2011/01/10 13:12:06 ferz Exp $
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if (!defined('XCART_START')) { header("Location: ../"); die("Access denied"); }

x_load('payment', 'http', 'xml');
func_pm_load('cc_hsbc_common');

func_set_time_limit(100);

$pp_login    = $module_params['param01'];
$pp_pass    = $module_params['param02'];
$pp_client    = $module_params['param03'];
$pp_curr    = $module_params['param04'];
$pp_url     = "https://secure2.mde.epdq.co.uk:11500";

$pp_cc_expire   = substr($userinfo['card_expire'], 0, 2).'/'.substr($userinfo['card_expire'], 2, 2);
$pp_cvv2_ind    = empty($userinfo['card_cvv2']) ? 2 : 1;
$b_country      = func_cc_hsbc_country2code($userinfo['b_country']);
$s_country      = func_cc_hsbc_country2code($userinfo['s_country']);

$total_cost = func_cc_hsbc_format_price($cart['total_cost'], $pp_curr);

$xml = <<<XML
<?xml version="1.0" encoding="UTF-8" ?>
<EngineDocList>
 <DocVersion DataType="String">1.0</DocVersion>
 <EngineDoc>
  <ContentType DataType="String">OrderFormDoc</ContentType>
  <User>
   <Name DataType="String">$pp_login</Name>
   <Password DataType="String">$pp_pass</Password>
   <ClientId DataType="S32">$pp_client</ClientId>
  </User>
  <Instructions>
   <Pipeline DataType="String">PaymentNoFraud</Pipeline>
  </Instructions>
  <OrderFormDoc>
   <Mode DataType="String">$module_params[testmode]</Mode>
   <Consumer>
    <Email DataType="String">$userinfo[email]</Email>
    <BillTo>
     <Location>
      <TelVoice DataType="String">$userinfo[phone]</TelVoice>
      <TelFax DataType="String">$userinfo[fax]</TelFax>
      <Address>
       <Name DataType="String">$userinfo[b_firstname] $userinfo[b_lastname]</Name>
       <City DataType="String">$userinfo[b_city]</City>
       <Street1 DataType="String">$userinfo[b_address]</Street1>
       <Street2 DataType="String">$userinfo[b_address_2]</Street2>
       <StateProv DataType="String">$userinfo[b_state]</StateProv>
       <PostalCode DataType="String">$userinfo[b_zipcode]</PostalCode>
       <Country DataType="String">$b_country</Country>
      </Address>
     </Location>
    </BillTo>
    <ShipTo>
     <Location>
      <TelVoice DataType="String">$userinfo[phone]</TelVoice>
      <TelFax DataType="String">$userinfo[fax]</TelFax>
      <Address>
       <Name DataType="String">$userinfo[s_firstname] $userinfo[s_lastname]</Name>
       <City DataType="String">$userinfo[s_city]</City>
       <Street1 DataType="String">$userinfo[s_address]</Street1>
       <Street2 DataType="String">$userinfo[s_address_2]</Street2>
       <StateProv DataType="String">$userinfo[s_state]</StateProv>
       <PostalCode DataType="String">$userinfo[s_zipcode]</PostalCode>
       <Country DataType="String">$s_country</Country>
      </Address>
     </Location>
    </ShipTo>
    <PaymentMech>
     <CreditCard>
      <Number DataType="String">$userinfo[card_number]</Number>
      <Expires DataType="ExpirationDate" Locale="840">$pp_cc_expire</Expires>
      <Cvv2Val DataType="String">$userinfo[card_cvv2]</Cvv2Val>
      <Cvv2Indicator DataType="String">$pp_cvv2_ind</Cvv2Indicator>
     </CreditCard>
    </PaymentMech>
   </Consumer>
   <Transaction>
    <Type DataType="String">Auth</Type>
    <CurrentTotals>
     <Totals>
      <Total DataType="Money" Currency="$pp_curr">$total_cost</Total>
     </Totals>
    </CurrentTotals>
   </Transaction>
  </OrderFormDoc>
 </EngineDoc>
</EngineDocList>
XML;

list($a, $return) = func_https_request('POST', $pp_url, array("CLRCMRC_XML=".$xml));

$return = func_xml2hash($return);

$return = $return['EngineDocList']['EngineDoc'];

if ($return['MessageList']['Message'] === '') {

    $return = $return['OrderFormDoc']['Transaction'];
    $bill_output['code'] = ($return['CardProcResp']['Status'] == '1') ? 1 : 2;
    $bill_output['billmes'] = $return['CardProcResp']['CcReturnMsg']." (code: ".$return['CardProcResp']['CcErrCode'].")\n";

    if (!empty($return['AuthCode'])) {
        $bill_output['billmes'] .= "AuthCode: ".$return['AuthCode']."\n";
    }
    if (!empty($return['Id'])) {
        $bill_output['billmes'] .= "Id: ".$return['Id']."\n";
    }

} else {

    $return = $return['MessageList']['Message'];
    $bill_output['code'] = 2;

    if (!empty($return['Text'])) {
        $bill_output['billmes'] .= $return['Text']." (file: ".$return['FileName'].", line: ".$return['FileLine'].")";
    }
}
?>
