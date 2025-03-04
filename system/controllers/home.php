<?php
/**
* PHP Mikrotik Billing (https://ibnux.github.io/phpmixbill/)


* @copyright	Copyright (C) 2014-2015 PHP Mikrotik Billing
* @license		GNU General Public License version 2 or later; see LICENSE.txt

**/
_auth();
$ui->assign('_title', $_L['Dashboard'].' - '. $config['CompanyName']);

$user = User::_info();
$ui->assign('_user', $user);

//Client Page
// $bill = User::_billing();
// $ui->assign('_bill', $bill);

$sessid = $_SESSION['username'];

$ds = ORM::for_table('tbl_customers')->raw_query("SELECT tbl_customers.id, tbl_customers.username AS users,tbl_customers.profile AS profile, tbl_customers.created_at AS created, tbl_customers.batch,tbl_customers.validity,tbl_customers.validity_unit , sum(radacct.acctinputoctets) AS download, sum(radacct.acctoutputoctets) AS upload, radacct.callingstationid, radacct.acctstarttime FROM tbl_customers
				LEFT JOIN radacct ON tbl_customers.username = radacct.username
				 WHERE tbl_customers.username='$sessid'")->find_one();

$ui->assign('ds', $ds);

$ui->display('user-dashboard.tpl');