<?php
/**
 * PHP Mikrotik Billing (https://ibnux.github.io/phpmixbill/)
 * @copyright	Copyright (C) 2014-2015 PHP Mikrotik Billing
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 **/
_admin();
$ui->assign('_title', $_L['Dashboard'] . ' - ' . $config['CompanyName']);
$admin = Admin::_info();
$ui->assign('_admin', $admin);

if ($admin['user_type'] != 'Admin' and $admin['user_type'] != 'Sales' and $admin['user_type'] != 'Regular' and $admin['user_type'] != 'POS') {
    r2(U . "home", 'e', $_L['Do_Not_Access']);
}


if ($admin['user_type'] == 'Admin' or $admin['user_type'] == 'Sales') {

    $fdate = date('Y-m-01');
    $tdate = date('Y-m-t');
    //first day of month
    $first_day_month = date('Y-m-01');
    $mdate = date('Y-m-d');
    $month_n = date('n');

    $iday = ORM::for_table('tbl_transactions')->where('recharged_on', $mdate)->sum('price');
    if ($iday == '') {
        $iday = '0.00';
    }
    $ui->assign('iday', $iday);

    $imonth = ORM::for_table('tbl_transactions')->where_gte('recharged_on', $first_day_month)->where_lte('recharged_on', $mdate)->sum('price');
    if ($imonth == '') {
        $imonth = '0.00';
    }
    $ui->assign('imonth', $imonth);

    $u_act = ORM::for_table('tbl_user_recharges')->where('status', 'on')->count();
    if ($u_act == '') {
        $u_act = '0';
    }
    $ui->assign('u_act', $u_act);

    $u_all = ORM::for_table('tbl_user_recharges')->count();
    if ($u_all == '') {
        $u_all = '0';
    }
    $ui->assign('u_all', $u_all);
    //user expire
    $expire = ORM::for_table('tbl_user_recharges')->where('expiration', $mdate)->order_by_desc('id')->find_many();
    $ui->assign('expire', $expire);


    $latest_expired = ORM::for_table('tbl_user_recharges')->where_lt('expiration', $mdate)->limit(25)->order_by_desc('expiration')->find_many();
    $ui->assign('latest_expired', $latest_expired);


    $batch_recharged = ORM::for_table('batch_recharged')->raw_query("SELECT tbl_voucher.batch,batch_recharged.nas, COUNT(code) AS 'total_generated_for', SUM(CASE WHEN radacct.username = tbl_voucher.code THEN 1 ELSE 0 END) AS 'matching_codes' FROM tbl_voucher LEFT JOIN radacct ON tbl_voucher.code = radacct.username RIGHT JOIN batch_recharged ON tbl_voucher.batch = batch_recharged.batch GROUP BY tbl_voucher.generated_for ORDER BY total_generated_for DESC ")->limit(5)->find_many();
    $ui->assign('batch_recharged', $batch_recharged);

    //voucher number calculation:

    $voucher_no = ORM::for_table('tbl_voucher')->count();
    $ui->assign('voucher_no', $voucher_no);


    //user number calculation:

    $user_no = ORM::for_table('tbl_user_recharges')->where('type', 'PPPOE')->count();
    $ui->assign('user_no', $user_no);


    // SELECT generated_for, COUNT(generated_for) 
// FROM tbl_voucher GROUP BY generated_for HAVING COUNT(generated_for) > 1 

    // $pos = ORM::for_table('tbl_voucher')->group_by('generated_for')->count('generated_for');
// $gen = "generated_for";
// $pos = ORM::for_table('tbl_voucher')->distinct('generated_for')->find_array();



    // var_dump($pos['generated_by']);

    // $key = array_search('admin', $pos['']);
// var_dump($key);

    $pos = ORM::for_table('tbl_voucher')
        ->raw_query("
        SELECT 
        t.generated_for,
        v.total_generated_for,
        COUNT(DISTINCT CASE WHEN r.username = t.code THEN r.username ELSE NULL END) AS 'matching_codes',
        SUM(CASE WHEN t.expired = 1 THEN 1 ELSE 0 END) AS 'expired_codes' 
    FROM tbl_voucher t 
    LEFT JOIN radacct r ON t.code = r.username 
    JOIN (
        SELECT generated_for, COUNT(*) AS total_generated_for 
        FROM tbl_voucher 
        GROUP BY generated_for
    ) v ON t.generated_for = v.generated_for 
    WHERE t.generated_for NOT IN ('duplicate')
    GROUP BY t.generated_for 
    ORDER BY v.total_generated_for DESC")
        ->find_array();

    // $vouch = $pos['generated_for']->count();
// $pos2 = implode($pos);
// echo $pos2;
// die();
// $pos = ORM::for_table('tbl_voucher')->raw_query("SELECT radacct.username, tbl_voucher.generated_for,COUNT(generated_for)
// FROM tbl_voucher JOIN radacct ON tbl_voucher.code = radacct.username GROUP BY generated_for HAVING COUNT(generated_for) >= 1 ORDER BY COUNT(generated_for) DESC")->limit(5)->find_array();


    // $pos = ORM::for_table('tbl_voucher')->group_by('generated_for')->having_gte('generated_for',1)->find_many();

    $ui->assign('pos', $pos);

    $allocated = ORM::for_table('tbl_voucher')->raw_query("SELECT 
        t.allocation,
        COUNT(distinct(code)) AS count, MIN(id) AS first_id, MAX(id) AS last_id,
        COUNT(DISTINCT r.username) AS 'matching_users'
        FROM tbl_voucher t 
        LEFT JOIN radacct r ON t.code = r.username 
        WHERE allocation <> '0'
        GROUP BY t.allocation 
        ORDER BY matching_users DESC;")->find_many();

    
    $ui->assign('allocated', $allocated);

    
    // var_dump($pos);
// die();



    //activity log
    $dlog = ORM::for_table('tbl_logs')->limit(6)->order_by_desc('id')->find_many();
    $ui->assign('dlog', $dlog);
    $log = ORM::for_table('tbl_logs')->count();
    $ui->assign('log', $log);


    // For Active PPP Users Count

    //     require 'class.mikrotik.php';

    //     $mkrouters = ORM::for_table('tbl_routers')->find_many();

    //     $count = 0;

    //     foreach ($mkrouters as $mkrouter) {
//         $mikrotik = new Mikrotik($mkrouter->ip_address, $mkrouter->username, $mkrouter->password);
//         $mikrotik->write("/ppp/active/print");
//         $totalusers = $mikrotik->read();
//         $count += count($totalusers);
//     }

    //     $maincount = $count;
//     $ui->assign('maincount', $maincount);

    //     // For Active Hotspot Users Count

    //     require 'class.mikrotik.php';

    // $mkrouters = ORM::for_table('tbl_routers')->find_many();

    // $count2 = 0;

    // foreach ($mkrouters2 as $mkrouter2) {
//     $mikrotik = new Mikrotik($mkrouter2->ip_address, $mkrouter2->username, $mkrouter2->password);
//     $mikrotik2->write("/ip/hotspot/active/print");
//     $totalusers2 = $mikrotik2->read();
//     $count2 += count($totalusers2);
// }

    // $maincount2 = $count2;
// $ui->assign('maincount2', $maincount2);

    require 'class.mikrotik.php';

    $mkrouters = ORM::for_table('tbl_routers')->where_not_equal('ip_address', '172.22.22.7')->find_many();

    $ppp_count = 0;
    $hotspot_count = 0;

    foreach ($mkrouters as $mkrouter) {
        $mikrotik = new Mikrotik($mkrouter->ip_address, $mkrouter->username, $mkrouter->password);

        // Get the count of active PPPoE users
        $mikrotik->write("/ppp/active/print");
        $ppp_users = $mikrotik->read();
        $ppp_count += count($ppp_users);

        // Get the count of active hotspot users
        $mikrotik->write("/ip/hotspot/active/print");
        $hotspot_users = $mikrotik->read();
        $hotspot_count += count($hotspot_users);
    }

    // Assign the counts to the template variables
    $ui->assign('ppp_count', $ppp_count);
    $ui->assign('hotspot_count', $hotspot_count);


    $ui->display('dashboard.tpl');

} else {
    $sadmin = $_SESSION['adname'];

    $user_no = ORM::for_table('tbl_customers')->where('generated_for', $sadmin)->count();
    $ui->assign('user_no', $user_no);

    $user_no_ppp = ORM::for_table('tbl_user_recharges')->where('type', 'PPPOE')->count();
    $ui->assign('user_no_ppp', $user_no_ppp);

    $voucher_no = ORM::for_table('tbl_voucher')->where('generated_for', $sadmin)->count();
    $ui->assign('voucher_no', $voucher_no);

    //showing total used vouchers
    // $pos = array();
    $pos = ORM::for_table('tbl_voucher')->raw_query("SELECT tbl_voucher.generated_for, COUNT(generated_for) AS 'total_generated_for', 
    COUNT(DISTINCT CASE WHEN radacct.username = tbl_voucher.code THEN radacct.username ELSE NULL END) AS 'matching_codes',
    SUM(CASE WHEN tbl_voucher.expired = 1 THEN 1 ELSE 0 END) AS 'expired_codes' 
    FROM tbl_voucher 
    LEFT JOIN radacct ON tbl_voucher.code = radacct.username 
    WHERE tbl_voucher.generated_for = '$sadmin'
    GROUP BY tbl_voucher.generated_for 
    ORDER BY total_generated_for DESC; ")->find_array();
    // showing total hotsot and ppoe users
    // if(empty($pos)) {
    // $pos[0]['matching_codes'] = '0000';
    // }
    $ui->assign('pos', $pos);
    // $ui->assign('pos[0]["matching_codes"]', $pos[0]['matching_codes']);

    require 'class.mikrotik.php';

    $mkrouters = ORM::for_table('tbl_routers')->where_not_equal('ip_address', '172.22.22.7')->find_many();

    $ppp_count = 0;
    $hotspot_count = 0;

    foreach ($mkrouters as $mkrouter) {
        $mikrotik = new Mikrotik($mkrouter->ip_address, $mkrouter->username, $mkrouter->password);

        // Get the count of active PPPoE users
        $mikrotik->write("/ppp/active/print");
        $ppp_users = $mikrotik->read();
        $ppp_count += count($ppp_users);

        // Get the count of active hotspot users
        $mikrotik->write("/ip/hotspot/active/print");
        $hotspot_users = $mikrotik->read();
        $hotspot_count += count($hotspot_users);
    }

    // Assign the counts to the template variables
    $allocated = ORM::for_table('tbl_voucher')->raw_query("SELECT 
    t.allocation,
    COUNT(DISTINCT(code)) AS count, MIN(id) AS first_id, MAX(id) AS last_id,
    COUNT(DISTINCT r.username) AS 'matching_users'
    FROM tbl_voucher t 
    LEFT JOIN radacct r ON t.code = r.username 
    WHERE allocation <> '0' AND generated_for = '$sadmin'
    GROUP BY t.allocation 
    ORDER BY matching_users DESC;")->find_many();
    
    $ui->assign('allocated', $allocated);    $ui->assign('allocated',$allocated);
    $ui->assign('ppp_count', $ppp_count);
    $ui->assign('hotspot_count', $hotspot_count);


    $ui->assign('sadmin', $sadmin);
    $ui->display('pos.tpl');
}