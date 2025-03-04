<?php

/**
 * PHP Mikrotik Billing (https://ibnux.github.io/phpmixbill/)
 * @copyright	Copyright (C) 2014-2015 PHP Mikrotik Billing
 * @license		GNU General Public License version 2 or later; see LICENSE.txt

 **/
_admin();
$ui->assign('_title', $_L['Recharge_Account'] . ' - ' . $config['CompanyName']);
$ui->assign('_system_menu', 'prepaid');

$action = $routes['1'];
$admin = Admin::_info();
$ui->assign('_admin', $admin);

if ($admin['user_type'] != 'Admin' and $admin['user_type'] != 'Sales' and $admin['user_type'] != 'Regular') {
    r2(U . "dashboard", 'e', $_L['Do_Not_Access']);
}

use PEAR2\Net\RouterOS;

require_once 'system/autoload/PEAR2/Autoload.php';

switch ($action) {

        case 'latest_expired':
          
            $mdate = date('Y-m-d');


            $ui->assign('xfooter', '<script type="text/javascript" src="ui/lib/c/prepaid.js"></script>');

            $username = _post('username');
            if ($username != '') {
                $paginator = Paginator::bootstrap('tbl_user_recharges', 'username', '%' . $username . '%');
                $d = ORM::for_table('tbl_user_recharges')->where_like('username', '%' . $username . '%')->order_by_desc('id')->find_many();
            } else {
                $paginator = Paginator::bootstrap('tbl_user_recharges');
                $d = ORM::for_table('tbl_user_recharges')->where_lt('expiration',$mdate)->order_by_desc('expiration')->find_many();
            }




            // $d = ORM::for_table('tbl_user_recharges')->where_lt('expiration',$mdate)->offset($paginator['startpoint'])->limit($paginator['limit'])->order_by_desc('expiration')->find_many();

            $ui->assign('d', $d);
            $ui->display('latestExpire.tpl');
            break;

        default:
            echo 'action not defined';
    }