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
 * Module configuration
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-2011 Ruslan R. Fazlyev <rrf@x-cart.com>. All rights reserved
 * @license    http://www.x-cart.com/license.php X-Cart license agreement
 * @version    $Id: config.php,v 1.25.2.2 2011/04/22 12:14:17 aim Exp $
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_START') ) { header('Location: ../../'); die('Access denied'); }
/**
 * Global definitions for News Management module
 */

if (defined('QUICK_START'))
    return false;

$css_files['News_Management'][] = array();

if (defined('TOOLS')) {
    $tbl_keys['newslist_subscription.listid'] = array(
        'keys' => array('newslist_subscription.listid' => 'newslists.listid'),
        'fields' => array('email')
    );
    $tbl_keys['newsletter.listid'] = array(
        'keys' => array('newsletter.listid' => 'newslists.listid'),
        'fields' => array('newsid','subject')
    );
    $tbl_demo_data['News_Management'] = array(
        'newsletter' => '',
        'newslist_subscription' => '',
        'newslists' => ''
    );
}

$_module_dir  = $xcart_dir . XC_DS . 'modules' . XC_DS . 'News_Management';
/*
 Load module functions
*/
if (!empty($include_func))
    require_once $_module_dir . XC_DS . 'func.php';
?>
