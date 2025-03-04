<?php
/**
 * PHP Mikrotik Billing (https://ibnux.github.io/phpmixbill/)
 * @copyright	Copyright (C) 2014-2015 PHP Mikrotik Billing
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 **/
_admin();
$ui->assign('_title', $_L['Wallet'] . ' - ' . $config['CompanyName']);
$ui->assign('_system_menu', 'adminwallet');
$admin = Admin::_info();
$ui->assign('_admin', $admin);

if ($admin['user_type'] != 'Admin') {
	r2(U . "home", 'e', $_L['Do_Not_Access']);
}

$compid = 1;
$comp = ORM::for_table('walletCompany')->find_one();
$ui->assign('comp', $comp);

$d = ORM::for_table('tbl_voucher')
	->raw_query("
	SELECT t.generated_for, SUM(p.price * COALESCE(c.matching_codes, 0)) AS total_price, COUNT(DISTINCT c.username) AS matching_codes, w.available_balance FROM tbl_customers t LEFT JOIN ( SELECT username, COUNT(DISTINCT username) AS matching_codes FROM radacct GROUP BY username ) c ON t.username = c.username JOIN tbl_plans p ON t.profile = p.name_plan JOIN wallet w ON w.username = t.generated_for GROUP BY t.generated_for, w.available_balance ORDER BY matching_codes DESC; 		")
	->find_array();
// $d = ORM::for_table('wallet')->find_many();
$ui->assign('d', $d);


$pd = ORM::for_table('tbl_voucher')
	->raw_query("
	SELECT tbl_transactions.method, SUM(tbl_plans.price) AS total_price FROM tbl_transactions INNER JOIN tbl_plans ON tbl_transactions.plan_name = tbl_plans.name_plan WHERE tbl_transactions.type = 'PPPOE' AND tbl_transactions.method IS NOT NULL GROUP BY tbl_transactions.method; 		")
	->find_array();
// $d = ORM::for_table('wallet')->find_many();
$ui->assign('pd', $pd);


$pos = ORM::for_table('tbl_users')->find_many();
$ui->assign('pos', $pos);
$ad = ORM::for_table('wallet')->where('username', 'admin')->find_many();
$ui->assign('ad', $ad);

$ui->display('adminwallet.tpl');