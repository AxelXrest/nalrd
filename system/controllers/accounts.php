<?php

/**
 * PHP Mikrotik Billing (https://ibnux.github.io/phpmixbill/)


 * @copyright	Copyright (C) 2014-2015 PHP Mikrotik Billing
 * @license		GNU General Public License version 2 or later; see LICENSE.txt

 **/
_auth();
$ui->assign('_title', $_L['My_Account'] . '- ' . $config['CompanyName']);
$ui->assign('_system_menu', 'accounts');

$action = $routes['1'];
$user = User::_info();
$ui->assign('_user', $user);

use PEAR2\Net\RouterOS;

require_once 'system/autoload/PEAR2/Autoload.php';

switch ($action) {

	case 'change-password':
		$ui->display('user-change-password.tpl');
		break;

	case 'change-password-post':
		$password = _post('password');
		$cpass = _post('cnpass');

		if ($password == $cpass) {

			if ($password != '') {
				$d = ORM::for_table('tbl_customers')->where('username', $user['username'])->find_one();
				$d->password = $password;
				$d->save();

				$v = ORM::for_table('radcheck')->where('username', $user['username'])->where('attribute', 'Cleartext-Password')->find_one();
				if ($v) {
					$v->value = $password;
					$v->save();
				}

				r2(U . 'accounts/change-password', 's', 'Password Changed Successfully.');
			} else {
				r2(U . 'accounts/change-password', 'e', $_L['Incorrect_Current_Password']);
			}
		} else {
			r2(U . 'accounts/change-password', 'e', 'Password Didnt Matched.');
		}
		break;

	case 'profile':

		$id  = $_SESSION['uid'];
		$d = ORM::for_table('tbl_customers')->find_one($id);
		if ($d) {
			$ui->assign('d', $d);
			$ui->display('user-profile.tpl');
		} else {
			r2(U . 'accounts/users', 'e', $_L['Account_Not_Found']);
		}
		break;

	case 'edit-profile-post':
		$fullname = _post('fullname');
		$address = _post('address');
		$phonenumber = _post('phonenumber');

		$msg = '';
		if (Validator::Length($fullname, 31, 2) == false) {
			$msg .= 'Full Name should be between 3 to 30 characters' . '<br>';
		}
		if (Validator::UnsignedNumber($phonenumber) == false) {
			$msg .= 'Phone Number must be a number' . '<br>';
		}

		$id = _post('id');
		$d = ORM::for_table('tbl_customers')->find_one($id);
		if ($d) {
		} else {
			$msg .= $_L['Data_Not_Found'] . '<br>';
		}

		if ($msg == '') {
			$d->fullname = $fullname;
			$d->address = $address;
			$d->phonenumber = $phonenumber;
			$d->save();

			_log('[' . $user['username'] . ']: ' . $_L['User_Updated_Successfully'], 'User', $user['id']);
			r2(U . 'accounts/profile', 's', $_L['User_Updated_Successfully']);
		} else {
			r2(U . 'accounts/profile', 'e', $msg);
		}
		break;

	default:
		echo 'action not defined';
}
