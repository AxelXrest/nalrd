<?php
/**
* PHP Mikrotik Billing (https://ibnux.github.io/phpmixbill/)


* @copyright	Copyright (C) 2014-2015 PHP Mikrotik Billing
* @license		GNU General Public License version 2 or later; see LICENSE.txt

**/
_admin();
$ui->assign('_title', $_L['Dashboard'].' - '. $config['CompanyName']);
$admin = Admin::_info();
$ui->assign('_admin', $admin);

if($admin['user_type'] != 'Admin'){
	r2(U."home",'e',$_L['Do_Not_Access']);
}



$d = ORM::for_table('wallet')->find_many();
$ad = ORM::for_table('wallet')->where('username','admin')->find_many();

$ui->assign('d',$d);

$ui->display('adminwallet.tpl');
