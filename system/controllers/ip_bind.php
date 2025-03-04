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
	case 'web':
        // $admin = $_SESSION['adname'];
        // $allocated = ORM::for_table('tbl_voucher')->raw_query("SELECT allocation, COUNT(*) AS count, MIN(id) AS first_id, MAX(id) AS last_id FROM tbl_voucher WHERE allocation <> '0' AND generated_for ='$admin' GROUP BY allocation;")->find_many();
        $d = ORM::for_table('tbl_routers')->find_many();
        $ip_bind = ORM::for_table('tbl_ip_binding')->find_many();
		$ui->assign('d',$d);
        $ui->assign('ip_bind',$ip_bind);
        $ui->display('ip_bind.tpl');
        break;

    case 'search':
        echo "In Process of developing";

        break;

    case 'add-post':
        $mac_address = $_POST['mac_address'];
        $address = $_POST['address'];
        $server = $_POST['routers'];
        $con_name = $_POST['con_name'];
        $admin = $_SESSION['adname'];

        $mikrotik = Router::_info($server);

        try {
            $client = new RouterOS\Client($mikrotik['ip_address'], $mikrotik['username'], $mikrotik['password']);
        } catch (Exception $e) {
            die('Unable to connect to the router: ' . $e->getMessage());
        }

        $all = 'all';
        $bypass = 'bypassed';

        try {

            $addRequest = new RouterOS\Request('/ip/hotspot/ip-binding/add');
            $client->sendSync(
                $addRequest
                    ->setArgument('mac-address', $mac_address)
                    ->setArgument('address', $address)
                    ->setArgument('to-address', $address)
                    ->setArgument('server',$all)
                    ->setArgument('type',$bypass)
            );

            $ip = ORM::for_table('tbl_ip_binding')->create();

            $ip->mac_address =  $mac_address;
            $ip->address = $address;
            $ip->nas = $server;
            $ip->consumer_name = $con_name;
            $ip->registered_by = $admin;
            $ip->save();

            r2(U . 'ip_bind/web', 's', $_L['Created_Successfully']);



        } catch (Exception $e) {
            r2(U . 'ip_bind/web', 'e', 'Data Not Registered.');
        }

            break;

    default:
		echo 'action not defined';
}