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
        $admin = $_SESSION['adname'];
        $allocated = ORM::for_table('tbl_voucher')->raw_query("SELECT 
        t.allocation,
        COUNT(distinct(code)) AS count, MIN(id) AS first_id, MAX(id) AS last_id,
        COUNT(DISTINCT r.username) AS 'matching_users'
        FROM tbl_voucher t 
        LEFT JOIN radacct r ON t.code = r.username 
        WHERE allocation <> '0' AND generated_for = '$admin'
        GROUP BY t.allocation 
        ORDER BY matching_users DESC;")->find_many();
        $d = ORM::for_table('tbl_voucher')->find_many();
		$ui->assign('allocated',$allocated);
        $ui->display('allocate_voucher.tpl');
        break;

    case 'search':
        echo "In Process of developing";

        break;

    case 'add-post':
        $vou_collector = $_POST['vou_collector'];
        $id_start = $_POST['id_start'];
        $id_end = $_POST['id_end'];
        $padmin = $_SESSION['adname'];

        $array = [];
        for ($i = $id_start; $i <= $id_end; $i++) {
            $array[] = $i;
        }

        print_r($array);

        // Fetch the vouchers within the specified range
        $tbl_voucher = ORM::for_table('tbl_voucher')->where_id_in($array)->find_many();

        // Check for allocations other than 0
        $alreadyAllocated = false;
        foreach ($tbl_voucher as $voucher) {
            if($voucher->generated_for != $padmin){
                $msg = "You cannot allocate vouchers of others.";
                r2(U . 'allocate/register_voucher' . $id, 'e', $msg);
            }else{
                if ($voucher->allocation != 0) {
                    $alreadyAllocated = true;
                    break; // Exit the loop as soon as we find an allocated value
                }
            }
            
        }

        // Display a message based on the result
        if ($alreadyAllocated) {
            $msg = "Some vouchers in the specified range are already allocated.";
            r2(U . 'allocate/register_voucher' . $id, 'e', $msg);
        } else {

            foreach ($tbl_voucher as $voucher) {
                $voucher->allocation = $vou_collector;
                $voucher->save();
            }
            
            r2(U . 'allocate/register_voucher', 's', "Voucher Allocated Successfully");
        }


        

        break;

    default:
		echo 'action not defined';
}