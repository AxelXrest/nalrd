<?php
/**
 * PHP Mikrotik Billing (https://ibnux.github.io/phpmixbill/)
 * @copyright	Copyright (C) 2014-2015 PHP Mikrotik Billing
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 **/
_admin();
$ui->assign('_title', $_L['Customers'] . ' - ' . $config['CompanyName']);
$ui->assign('_system_menu', 'customers');

$action = $routes['1'];
$admin = Admin::_info();
$ui->assign('_admin', $admin);

use PEAR2\Net\RouterOS;

require_once 'system/autoload/PEAR2/Autoload.php';

if ($admin['user_type'] != 'Admin' and $admin['user_type'] != 'Sales' and $admin['user_type'] != 'Regular' and $admin['user_type'] != 'POS') {
	r2(U . "dashboard", 'e', $_L['Do_Not_Access']);
}

switch ($action) {
	case 'register_voucher':
        $d = ORM::for_table('tbl_voucher')->find_many();
		$ui->assign('d',$d);
        $ui->display('allocate_voucher.tpl');
        break;

    default:
		echo 'action not defined';
}