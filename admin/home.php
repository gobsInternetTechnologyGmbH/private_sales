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
 * Home page interface
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Admin interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-2011 Ruslan R. Fazlyev <rrf@x-cart.com>
 * @license    http://www.x-cart.com/license.php X-Cart license agreement
 * @version    $Id: home.php,v 1.54.2.1 2011/01/10 13:11:45 ferz Exp $
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

require './auth.php';

if (!empty($login)) {

    require $xcart_dir.'/include/security.php';

}

if (
    !empty($login)
    && $user_account['flag'] != 'FS'
) {

    include './quick_menu.php';

    // Define data for the navigation within section

    $dialog_tools_data = array();

    $dialog_tools_data['left'][] = array(
        'link'  => '#menu', 
        'title' => func_get_langvar_by_name('lbl_quick_menu')
    );

    if (!isset($promo)) {

        $dialog_tools_data['left'][] = array(
            'link'  => '#orders', 
            'title' => func_get_langvar_by_name('lbl_last_orders_statistics')
        );

        $dialog_tools_data['left'][] = array(
            'link'  => '#topsellers', 
            'title' => func_get_langvar_by_name('lbl_top_sellers')
        );

        $dialog_tools_data['right'][] = array(
            'link'  => 'home.php?promo', 
            'title' => func_get_langvar_by_name('lbl_quick_start')
        );

    } else {

        $dialog_tools_data['left'][] = array(
            'link'  => '#qs', 
            'title' => func_get_langvar_by_name('lbl_quick_start_text')
        );

        $dialog_tools_data['right'][] = array(
            'link'  => 'home.php', 
            'title' => func_get_langvar_by_name('lbl_top_info')
        );

    }

    // Assign the section navigation data
    $smarty->assign('dialog_tools_data', $dialog_tools_data);

    if (isset($promo)) {

        $location[] = array(func_get_langvar_by_name('lbl_quick_start'), '');

        $smarty->assign('main', 'promo');

    } else {

        include './main.php';

        $smarty->assign('main', 'top_info');

    }

} else {

    $smarty->assign('main', '' === $login ? 'authentication' : 'home');

}

// Assign the current location line
if (!empty($login))
    $smarty->assign('location', $location);

if (
    file_exists($xcart_dir.'/modules/gold_display.php')
    && is_readable($xcart_dir.'/modules/gold_display.php')
) {
    include $xcart_dir.'/modules/gold_display.php';
}
func_display('admin/home.tpl', $smarty);
?>
