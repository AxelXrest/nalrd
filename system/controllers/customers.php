<?php

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

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
	case 'list':
		if ($admin['user_type'] == 'Admin' || $admin['user_type'] == 'Sales') {
			$ui->assign('xfooter', '<script type="text/javascript" src="ui/lib/c/customers.js"></script>');
			$username = _post('username');
			if ($username != '') {
				$paginator = Paginator::bootstrap('tbl_customers', 'username', '%' . $username . '%');
				$d = ORM::for_table('tbl_customers')->where_like('username', '%' . $username . '%')->offset($paginator['startpoint'])->limit($paginator['limit'])->order_by_desc('id')->find_many();
			} else {
				$paginator = Paginator::bootstrap('tbl_customers', 'username', '%' . $username . '%');
				// $d = ORM::for_table('tbl_customers')->offset($paginator['startpoint'])->limit($paginator['limit'])->order_by_desc('id')->find_many();
				$d = ORM::for_table('tbl_customers')->raw_query("SELECT tbl_customers.id, tbl_customers.username AS users, tbl_customers.fullname, tbl_customers.address, tbl_customers.phonenumber, sum(radacct.acctinputoctets) AS download, sum(radacct.acctoutputoctets) AS upload FROM tbl_customers
				LEFT JOIN radacct ON tbl_customers.username = radacct.username GROUP BY tbl_customers.id, tbl_customers.username, tbl_customers.fullname, tbl_customers.address, tbl_customers.phonenumber
				ORDER BY tbl_customers.id DESC LIMIT 10")->find_many();
			}
			$ui->assign('d', $d);
			// $ui->assign('paginator', $paginator);
			$ui->display('customers.tpl');


			// Connect to database
			// $host = "localhost";
			// $user = "root";
			// $password = "8080";
			// $dbname = "nalrd";
			// $conn = mysqli_connect($host, $user, $password, $dbname);

			// Get data from HTML table
			// $data = $_POST['data'];

			// Process data and insert into database
			// foreach ($data as $row) {
			// 	$sql = "INSERT INTO table_name (username, profile, batch) VALUES ('$data[0]', '$data[1]', '$data[2]')";
			// 	mysqli_query($conn, $sql);
			// }

			// Close database connection
			// mysqli_close($conn);
			// 
			// <script>
			// 	var tableData = []; // Get data from HTML table and put it in an array
			// 	$.ajax({
			// 		url: "customers.php",
			// 		type: "POST",
			// 		data: { data: tableData },
			// 		success: function (response) {
			// 			console.log(response); // Output success or error message
			// 		}
			// 	});


		} else {
			$pos = $_SESSION['adname'];
			$ui->assign('xfooter', '<script type="text/javascript" src="ui/lib/c/customers.js"></script>');
			$username = _post('username');
			if ($username != '') {
				$paginator = Paginator::bootstrap('tbl_customers', 'username', '%' . $username . '%');
				$d = ORM::for_table('tbl_customers')->where_like('username', '%' . $username . '%')->offset($paginator['startpoint'])->limit($paginator['limit'])->order_by_desc('id')->find_many();
			} else {
				$paginator = Paginator::bootstrap('tbl_customers');
				// $d = ORM::for_table('tbl_customers')->offset($paginator['startpoint'])->limit($paginator['limit'])->order_by_desc('id')->find_many();
				$d = ORM::for_table('tbl_customers')->raw_query("SELECT tbl_customers.id, tbl_customers.username AS users, tbl_customers.fullname, tbl_customers.address, tbl_customers.phonenumber, sum(radacct.acctinputoctets) AS download, sum(radacct.acctoutputoctets) AS upload FROM tbl_customers
				LEFT JOIN radacct ON tbl_customers.username = radacct.username where generated_by ='$POS' GROUP BY tbl_customers.id, tbl_customers.username, tbl_customers.fullname, tbl_customers.address, tbl_customers.phonenumber
				ORDER BY tbl_customers.id DESC LIMIT 10")->find_many();
			}
			$ui->assign('d', $d);
			$ui->assign('paginator', $paginator);
			$ui->display('customers.tpl');
		}
		break;


	case 'customers_details':

		if ($admin['user_type'] == 'Admin' || $admin['user_type'] == 'Sales') {
			$ui->assign('xfooter', '<script type="text/javascript" src="ui/lib/c/customers.js"></script>');
			$username = _post('username');
			if ($username != '') {
				$paginator = Paginator::bootstrap('tbl_customers', 'username', '%' . $username . '%');
				$d = ORM::for_table('tbl_customers')->where_like('username', '%' . $username . '%')->offset($paginator['startpoint'])->limit($paginator['limit'])->order_by_desc('id')->find_many();
			} else {
				$paginator = Paginator::bootstrap('tbl_customers', 'username', '%' . $username . '%');
				// $d = ORM::for_table('tbl_customers')->offset($paginator['startpoint'])->limit($paginator['limit'])->order_by_desc('id')->find_many();
				$d = ORM::for_table('tbl_customers')->raw_query("SELECT * FROM tbl_customers
				GROUP BY tbl_customers.id, tbl_customers.username, tbl_customers.fullname, tbl_customers.address, tbl_customers.phonenumber
				ORDER BY tbl_customers.id DESC LIMIT 10")->find_many();
			}
			$ui->assign('d', $d);
			// $ui->assign('paginator', $paginator);
			$ui->display('customers-details.tpl');

		} else {
			$pos = $_SESSION['adname'];
			$ui->assign('xfooter', '<script type="text/javascript" src="ui/lib/c/customers.js"></script>');
			$username = _post('username');
			if ($username != '') {
				$paginator = Paginator::bootstrap('tbl_customers', 'username', '%' . $username . '%');
				$d = ORM::for_table('tbl_customers')->where_like('username', '%' . $username . '%')->offset($paginator['startpoint'])->limit($paginator['limit'])->order_by_desc('id')->find_many();
			} else {
				$paginator = Paginator::bootstrap('tbl_customers');
				// $d = ORM::for_table('tbl_customers')->offset($paginator['startpoint'])->limit($paginator['limit'])->order_by_desc('id')->find_many();
				$d = ORM::for_table('tbl_customers')->raw_query("SELECT * FROM tbl_customers
				where generated_by ='$POS'
				ORDER BY tbl_customers.id DESC LIMIT 10")->find_many();
			}
			$ui->assign('d', $d);
			$ui->assign('paginator', $paginator);
			$ui->display('customers-details.tpl');
		}

		break;
	case 'search_users':

		$ui->display('search-user.tpl');

		break;
	case 'customers_data':

		if ($admin['user_type'] == 'Admin' || $admin['user_type'] == 'Sales') {
			$ui->assign('xfooter', '<script type="text/javascript" src="ui/lib/c/customers.js"></script>');
			$username = _post('username');
			if ($username != '') {
				$paginator = Paginator::bootstrap('radacct', 'username', '%' . $username . '%');
				$d = ORM::for_table('radacct')->where_like('username', '%' . $username . '%')->offset($paginator['startpoint'])->limit($paginator['limit'])->order_by_desc('id')->find_many();
			} else {
				$paginator = Paginator::bootstrap('radacct', 'username', '%' . $username . '%');
				// $d = ORM::for_table('tbl_customers')->offset($paginator['startpoint'])->limit($paginator['limit'])->order_by_desc('id')->find_many();
				$d = ORM::for_table('radacct')->raw_query("SELECT username,callingstationid,acctstarttime,sum(radacct.acctinputoctets) AS download, sum(radacct.acctoutputoctets) AS upload FROM radacct
				GROUP BY radacct.username
				ORDER BY acctstarttime DESC LIMIT 10")->find_many();
			}
			$ui->assign('d', $d);
			// $ui->assign('paginator', $paginator);
			$ui->display('customers-data.tpl');

		} else {
			$pos = $_SESSION['adname'];
			$ui->assign('xfooter', '<script type="text/javascript" src="ui/lib/c/customers.js"></script>');
			$username = _post('username');
			if ($username != '') {
				$paginator = Paginator::bootstrap('radacct', 'username', '%' . $username . '%');
				$d = ORM::for_table('radacct')->where_like('username', '%' . $username . '%')->offset($paginator['startpoint'])->limit($paginator['limit'])->order_by_desc('id')->find_many();
			} else {
				$paginator = Paginator::bootstrap('radacct');
				// $d = ORM::for_table('tbl_customers')->offset($paginator['startpoint'])->limit($paginator['limit'])->order_by_desc('id')->find_many();
				$d = ORM::for_table('radacct')->raw_query("SELECT * FROM radacct
				where username IN (SELECT username from tbl_customers where generated_by ='$POS')
				ORDER BY acctstarttime DESC LIMIT 10")->find_many();
			}
			$ui->assign('d', $d);
			$ui->assign('paginator', $paginator);
			$ui->display('customers-data.tpl');
		}

		break;

		break;
	case 'manage':


		if ($_POST['myBut'] == "my1") {

			$del = $_POST['delete_id'];
			$del_all = implode(',', $del);
			// echo $del_all;
			// $arr = array(1, 2, 3);
			// var_dump($arr);
			$array = explode(",", $del_all);
			// var_dump($array);
			$delete = ORM::for_table('tbl_customers')->where_id_in($array)->find_many();

			try {
				$delete->delete();
				r2(U . 'customers/customers_details', 's', $_L['User_Delete_Ok']);
			} catch (Exception $e) {
				r2(U . 'customers/customers_details', 'e', $_L['delete_problem']);
			}
		} elseif ($_POST['myBut'] == "my2") {
			echo "Activate" . $del_all;
		} elseif ($_POST['myBut'] == "my3") {
			echo "Deactivate" . $del_all;
		} elseif ($_POST['myBut'] == "searchname") {
			$ui->assign('xfooter', '<script type="text/javascript" src="ui/lib/c/customers.js"></script>');
			$username = _post('username');
			$username = "'%" . $username . "%'";
			if ($username != '') {
				$paginator = Paginator::bootstrap('tbl_customers', 'username', '%' . $username . '%');
				// $d = ORM::for_table('tbl_customers')->where_like('username', '%' . $username . '%')->offset($paginator['startpoint'])->limit($paginator['limit'])->order_by_desc('id')->find_many();
				$d = ORM::for_table('tbl_customers')->raw_query("SELECT * , tbl_customers.username AS users,sum(radacct.acctinputoctets) AS download, sum(radacct.acctoutputoctets) AS upload FROM tbl_customers
				LEFT JOIN radacct ON tbl_customers.username = radacct.username where tbl_customers.username LIKE $username OR tbl_customers.batch LIKE $username   GROUP BY tbl_customers.username
				ORDER BY id DESC;			
				")->find_many();
			} else {
				$paginator = Paginator::bootstrap('tbl_customers');
				// $d = ORM::for_table('tbl_customers')->offset($paginator['startpoint'])->limit($paginator['limit'])->order_by_desc('id')->find_many();
				$d = ORM::for_table('tbl_customers')->raw_query("SELECT * FROM tbl_customers,sum(radacct.acctinputoctets) AS download, sum(radacct.acctoutputoctets) AS upload
				LEFT JOIN radacct ON tbl_customers.username = radacct.username
				ORDER BY id DESC")->limit($paginator['limit'])->find_many();
			}

			$ui->assign('d', $d);
			$ui->assign('paginator', $paginator);
			$ui->display('customers.tpl');
		} elseif ($_POST['myBut'] == "searchid") {
			$ui->assign('xfooter', '<script type="text/javascript" src="ui/lib/c/customers.js"></script>');
			$username = _post('username');
			$number = intval($username);
			$username = "'%" . $username . "%'";
			if ($username != '') {
				$paginator = Paginator::bootstrap('tbl_customers', 'username', '%' . $username . '%');
				// $d = ORM::for_table('tbl_customers')->where_like('username', '%' . $username . '%')->offset($paginator['startpoint'])->limit($paginator['limit'])->order_by_desc('id')->find_many();
				$d = ORM::for_table('tbl_customers')->raw_query("
                SELECT 
                    *,
                    tbl_customers.username AS users,
                    SUM(radacct.acctinputoctets) AS download,
                    SUM(radacct.acctoutputoctets) AS upload
                FROM tbl_customers
                LEFT JOIN radacct ON tbl_customers.username = radacct.username
                LEFT JOIN tbl_voucher ON tbl_customers.username = tbl_voucher.code
                WHERE tbl_voucher.id = $number
                GROUP BY tbl_customers.username
                ORDER BY tbl_customers.id DESC;

						
				")->find_many();
			} else {
				$paginator = Paginator::bootstrap('tbl_customers');
				// $d = ORM::for_table('tbl_customers')->offset($paginator['startpoint'])->limit($paginator['limit'])->order_by_desc('id')->find_many();
				$d = ORM::for_table('tbl_customers')->raw_query("SELECT * FROM tbl_customers,sum(radacct.acctinputoctets) AS download, sum(radacct.acctoutputoctets) AS upload
				LEFT JOIN radacct ON tbl_customers.username = radacct.username
				ORDER BY id DESC")->limit($paginator['limit'])->find_many();
			}

			$ui->assign('d', $d);
			$ui->assign('paginator', $paginator);
			$ui->display('customers.tpl');
		} elseif ($_POST['myBut'] == "recharge") {
			$del = $_POST['delete_id'];
			$del_all = implode(',', $del);
			// echo $del_all;
			// $arr = array(1, 2, 3);
			// var_dump($arr);
			$array = explode(",", $del_all);

			// $id = $routes['2'];
			$id = $array[0];
			$ui->assign('id', $id);

			$c = ORM::for_table('tbl_customers')->where('id', $id)->find_many();
			$ui->assign('c', $c);
			$tuser = ORM::for_table('tbl_users')->find_many();
			$ui->assign('tuser', $tuser);
			if ($admin['user_type'] == 'Admin') {
				$p = ORM::for_table('tbl_plans')->find_many();
				$ui->assign('p', $p);
			} else {
				$va = 0;
				$p = ORM::for_table('tbl_plans')->where('access_control', $va)->find_many();
				$ui->assign('p', $p);
			}
			$r = ORM::for_table('tbl_routers')->find_many();
			$ui->assign('r', $r);

			$ui->display('recharge-user.tpl');
		} elseif ($_POST['myBut'] == "edit") {
			$del = $_POST['delete_id'];
			$del_all = implode(',', $del);
			// echo $del_all;
			// $arr = array(1, 2, 3);
			// var_dump($arr);
			$array = explode(",", $del_all);

			$d = ORM::for_table('tbl_customers')->find_one($array);
			if ($d) {
				$ui->assign('d', $d);
				$ui->display('customers-edit.tpl');
			} else {
				r2(U . 'customers/customers_details', 'e', $_L['Account_Not_Found']);
			}
		} elseif ($_POST['myBut'] == "mac") {
			$del = $_POST['delete_id'];
			$del_all = implode(',', $del);
			// echo $del_all;
			// $arr = array(1, 2, 3);
			// var_dump($arr);
			$array = explode(",", $del_all);

			$d = ORM::for_table('tbl_customers')->find_one($array);
			if ($d) {
				$ui->assign('d', $d);
				$ui->display('mac_change.tpl');
			} else {
				r2(U . 'customers/customers_details', 'e', $_L['Account_Not_Found']);
			}
		}
		break;

	case 'add':
		$tuser = ORM::for_table('tbl_users')->find_many();
		$ui->assign('tuser', $tuser);
		$ui->display('customers-add.tpl');
		break;

	case 'edit':
		$id = $routes['2'];
		$d = ORM::for_table('tbl_customers')->find_one($id);
		if ($d) {
			$ui->assign('d', $d);
			$ui->display('customers-edit.tpl');
		} else {
			r2(U . 'customers/customers_details', 'e', $_L['Account_Not_Found']);
		}
		break;

	case 'delete':
		$id = $routes['2'];

		$d = ORM::for_table('tbl_customers')->find_one($id);
		if ($d) {
			$c = ORM::for_table('tbl_user_recharges')->where('username', $d['username'])->find_one();
			if ($c) {
				$mikrotik = Router::_info($c['routers']);
				if ($c['type'] == 'Hotspot') {
					try {
						$client = new RouterOS\Client($mikrotik['ip_address'], $mikrotik['username'], $mikrotik['password']);
					} catch (Exception $e) {
						die('Unable to connect to the router.');
					}
					$printRequest = new RouterOS\Request('/ip/hotspot/user/print');
					$printRequest->setArgument('.proplist', '.id');
					$printRequest->setQuery(RouterOS\Query::where('name', $c['username']));
					$id = $client->sendSync($printRequest)->getProperty('.id');

					$setRequest = new RouterOS\Request('/ip/hotspot/user/remove');
					$setRequest->setArgument('numbers', $id);
					$client->sendSync($setRequest);

					//remove hotspot active
					$onlineRequest = new RouterOS\Request('/ip/hotspot/active/print');
					$onlineRequest->setArgument('.proplist', '.id');
					$onlineRequest->setQuery(RouterOS\Query::where('user', $c['username']));
					$id = $client->sendSync($onlineRequest)->getProperty('.id');

					$removeRequest = new RouterOS\Request('/ip/hotspot/active/remove');
					$removeRequest->setArgument('numbers', $id);
					$client->sendSync($removeRequest);
				} else {

					try {
						$client = new RouterOS\Client($mikrotik['ip_address'], $mikrotik['username'], $mikrotik['password']);
					} catch (Exception $e) {
						die('Unable to connect to the router.');
					}
					$printRequest = new RouterOS\Request('/ppp/secret/print');
					$printRequest->setArgument('.proplist', '.id');
					$printRequest->setQuery(RouterOS\Query::where('name', $c['username']));
					$id = $client->sendSync($printRequest)->getProperty('.id');

					$setRequest = new RouterOS\Request('/ppp/secret/remove');
					$setRequest->setArgument('numbers', $id);
					$client->sendSync($setRequest);

					//remove pppoe active
					$onlineRequest = new RouterOS\Request('/ppp/active/print');
					$onlineRequest->setArgument('.proplist', '.id');
					$onlineRequest->setQuery(RouterOS\Query::where('name', $c['username']));
					$id = $client->sendSync($onlineRequest)->getProperty('.id');

					$removeRequest = new RouterOS\Request('/ppp/active/remove');
					$removeRequest->setArgument('numbers', $id);
					$client->sendSync($removeRequest);
				}
				try {
					$d->delete();
				} catch (Exception $e) {
				}
				try {
					$c->delete();
				} catch (Exception $e) {
				}
			} else {
				try {
					$d->delete();
				} catch (Exception $e) {
				}
				try {
					$c->delete();
				} catch (Exception $e) {
				}
			}

			r2(U . 'customers/customers_details', 's', $_L['User_Delete_Ok']);
		}
		break;

	case 'add-post':
		$username = _post('username');
		$fullname = _post('fullname');
		$password = _post('password');
		$cpassword = _post('cpassword');
		$address = _post('address');
		$phonenumber = _post('phonenumber');
		$owner = $_SESSION['adname'];
		$on_behalf_of = _post('on_behalf_of');

		if ($owner == "admin" || $owner == $on_behalf_of) {


			$msg = '';
			// if (Validator::Length($username, 35, 2) == false) {
			// 	$msg .= 'Username should be between 3 to 55 characters' . '<br>';
			// }
			if (Validator::Length($fullname, 36, 2) == false) {
				$msg .= 'Full Name should be between 3 to 25 characters' . '<br>';
			}
			if (!Validator::Length($password, 35, 2)) {
				$msg .= 'Password should be between 3 to 35 characters' . '<br>';
			}
			if ($password != $cpassword) {
				$msg .= 'Passwords does not match' . '<br>';
			}

			$d = ORM::for_table('tbl_customers')->where('username', $username)->find_one();
			if ($d) {
				$msg .= $_L['account_already_exist'] . '<br>';
			}

			if ($msg == '') {
				$d = ORM::for_table('tbl_customers')->create();
				$d->username = $username;
				$d->password = $password;
				$d->fullname = $fullname;
				$d->address = $address;
				$d->generated_for = $on_behalf_of;
				$d->generated_by = $owner;
				$d->phonenumber = $phonenumber;
				$d->save();


				r2(U . 'customers/customers_details', 's', $_L['account_created_successfully']);
			} else {
				r2(U . 'customers/add', 'e', $msg);
			}
		} else {
			$msg4 = "You cannot create users for another User";
			r2(U . 'customers/add', 'e', $msg4);
		}

		break;

	case 'edit-post':
		$username = _post('username');
		$fullname = _post('fullname');
		$password = _post('password');
		$cpassword = _post('cpassword');
		$address = _post('address');
		$phonenumber = _post('phonenumber');

		$msg = '';

		if ($password != '') {
			if (!Validator::Length($password, 31, 2)) {
				$msg .= 'Password should be between 3 to 30 characters' . '<br>';
			}
			if ($password != $cpassword) {
				$msg .= 'Passwords does not match' . '<br>';
			}
		}

		$id = _post('id');
		$d = ORM::for_table('tbl_customers')->find_one($id);
		if ($d) {
		} else {
			$msg .= $_L['Data_Not_Found'] . '<br>';
		}

		// if ($d['username'] != $username) {
		// 	$c = ORM::for_table('tbl_customers')->where('username', $username)->find_one();
		// 	if ($c) {
		// 		$msg .= $_L['account_already_exist'] . '<br>';
		// 	}
		// }

		if ($msg == '') {
			$c = ORM::for_table('tbl_customers')->where('username', $username)->find_one();
			if ($c) {
				// $mikrotik = Router::_info($c['routers']);
				// if ($c['type'] == 'Hotspot') {
				// 	try {
				// 		$client = new RouterOS\Client($mikrotik['ip_address'], $mikrotik['username'], $mikrotik['password']);
				// 	} catch (Exception $e) {
				// 		die('Unable to connect to the router.');
				// 	}
				// 	$printRequest = new RouterOS\Request('/ip/hotspot/user/print');
				// 	$printRequest->setArgument('.proplist', '.id');
				// 	$printRequest->setQuery(RouterOS\Query::where('name', $c['username']));
				// 	$id = $client->sendSync($printRequest)->getProperty('.id');

				// 	$setRequest = new RouterOS\Request('/ip/hotspot/user/set');
				// 	$setRequest->setArgument('numbers', $id);
				// 	$setRequest->setArgument('password', $password);
				// 	$client->sendSync($setRequest);

				// 	//remove hotspot active
				// 	$onlineRequest = new RouterOS\Request('/ip/hotspot/active/print');
				// 	$onlineRequest->setArgument('.proplist', '.id');
				// 	$onlineRequest->setQuery(RouterOS\Query::where('user', $c['username']));
				// 	$id = $client->sendSync($onlineRequest)->getProperty('.id');

				// 	$removeRequest = new RouterOS\Request('/ip/hotspot/active/remove');
				// 	$removeRequest->setArgument('numbers', $id);
				// 	$client->sendSync($removeRequest);

				// 	$d->password = $password;
				// 	$d->save();



				// } else {
				// 	try {
				// 		$client = new RouterOS\Client($mikrotik['ip_address'], $mikrotik['username'], $mikrotik['password']);
				// 	} catch (Exception $e) {
				// 		die('Unable to connect to the router.');
				// 	}
				// 	$printRequest = new RouterOS\Request('/ppp/secret/print');
				// 	$printRequest->setArgument('.proplist', '.id');
				// 	$printRequest->setQuery(RouterOS\Query::where('name', $c['username']));
				// 	$id = $client->sendSync($printRequest)->getProperty('.id');

				// 	$setRequest = new RouterOS\Request('/ppp/secret/set');
				// 	$setRequest->setArgument('numbers', $id);
				// 	$setRequest->setArgument('password', $password);
				// 	$client->sendSync($setRequest);

				// 	//remove pppoe active
				// 	$onlineRequest = new RouterOS\Request('/ppp/active/print');
				// 	$onlineRequest->setArgument('.proplist', '.id');
				// 	$onlineRequest->setQuery(RouterOS\Query::where('name', $c['username']));
				// 	$id = $client->sendSync($onlineRequest)->getProperty('.id');

				// 	$removeRequest = new RouterOS\Request('/ppp/active/remove');
				// 	$removeRequest->setArgument('numbers', $id);
				// 	$client->sendSync($removeRequest);

				// 	$d->password = $password;
				// 	$d->save();
				// }

				if ($password != '') {
					$d->password = $password;
				}
				$d->fullname = $fullname;
				$d->address = $address;
				$d->phonenumber = $phonenumber;
				$d->save();

				$radius = ORM::for_table('radcheck')->where('username', $username)->find_one();
				if ($radius) {
					$radius->attribute = "Cleartext-Password";
					$radius->value = $password;
					$radius->save();
				}
			} else {
				$d->username = $username;
				if ($password != '') {
					$d->password = $password;
				}
				$d->fullname = $fullname;
				$d->address = $address;
				$d->phonenumber = $phonenumber;
				$d->save();
			}
			r2(U . 'customers/customers_details', 's', 'User Updated Successfully');
		} else {
			r2(U . 'customers/edit/' . $id, 'e', $msg);
		}
		break;
	case 'edit-mac':

		$username = $_POST['username'];
		$new_mac = $_POST['new_mac'];
		$id = $_POST['id'];

		$msg = '';

		$d = ORM::for_table('radacct')->where('username', $username)->find_many();
		if ($d) {
		} else {
			$msg .= $_L['Data_Not_Found'] . '<br>';
		}

		if ($msg == '') {

			$d = ORM::for_table('radacct')->raw_query("UPDATE radacct SET callingstationid='$new_mac' where username='$username'")->find_many();

			r2(U . 'customers/customers_details', 's', 'User Updated Successfully');
		} else {

			r2(U . 'customers/edit/' . $id, 'e', $msg);
		}
		break;
	default:
		echo 'action not defined';
}
