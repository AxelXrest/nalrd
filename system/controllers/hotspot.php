<?php

/**
 * PHP Mikrotik Billing (https://ibnux.github.io/phpmixbill/)
 * @copyright	Copyright (C) 2014-2015 PHP Mikrotik Billing
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 **/
_admin();
$ui->assign('_title', $_L['Hotspot'] . ' - ' . $config['CompanyName']);
$ui->assign('_system_menu', 'hotspot');

$action = $routes['1'];
$admin = Admin::_info();
$ui->assign('_admin', $admin);

if ($admin['user_type'] != 'Admin' and $admin['user_type'] != 'Sales' and $admin['user_type'] != 'Regular' and $admin['user_type'] != 'POS') {
    r2(U . "dashboard", 'e', $_L['Do_Not_Access']);
}

use PEAR2\Net\RouterOS;

require_once 'system/autoload/PEAR2/Autoload.php';

switch ($action) {

    case 'plans':

        $d = ORM::for_table('tbl_bandwidth')->find_many();
        $ui->assign('d', $d);
        $r = ORM::for_table('tbl_routers')->find_many();
        $ui->assign('r', $r);

        $ui->display('plan-hotspot.tpl');
        break;

    case 'delete':


        $del = $_POST['delete_id'];
        $del_all = implode(',', $del);


        $array = explode(",", $del_all);
        $delete = ORM::for_table('tbl_plans')->where_id_in($array)->find_many();

        try {
            $delete->delete();
            r2(U . 'services/hotspot', 's', $_L['Delete_Successfully']);
        } catch (Exception $e) {
            r2(U . 'services/hotspot', 'e', $_L['delete_problem']);
        }

        break;

    case 'packages':
        $type = "Hotspot";
        $r = ORM::for_table('tbl_routers')->find_many();
        $ui->assign('r', $r);
        $usr = ORM::for_table('tbl_users')->find_many();
        $ui->assign('usr', $usr);
        $method = $_SESSION['adname'];
        // if($method =="admin" || $method =="ngima" ){


        if ($admin['user_type'] == 'Admin') {
            $voucher = ORM::for_table('tbl_plans')->where('type', $type)->find_many();
            $ui->assign('voucher', $voucher);
        } else {
            if ($admin['user_type'] == 'POS' && $admin['access_control'] == '1') {
                $voucher = ORM::for_table('tbl_plans')->where('type', $type)->find_many();
                $ui->assign('voucher', $voucher);
            } else {
                $va = 1;
                $voucher = ORM::for_table('tbl_plans')->where('type', $type)->where('access_control', $va)->find_many();
                $ui->assign('voucher', $voucher);
            }
        }

        // }else{
        //     $voucher = ORM::for_table('tbl_plans')->raw_query("SELECT * FROM tbl_plans where name_plan NOT IN ('May_EBC_Nepal','May_EBC_Foreigner') ")->find_many();
        // $ui->assign('voucher', $voucher);
        // }

        $ui->display('packages.tpl');

?>

        <script>
            // function toggle_visibility(id) {
            //       var e = document.getElementById(id);
            //      if (e.style.display == '') e.style.display = 'block';
            //          else e.style.display = '';

            //         }
        </script>
<?php

        break;

    case 'find_pack':
        $serv = $_POST['serve'];
        $type = "Hotspot";

        $p = ORM::for_table('tbl_routers')->find_many();
        $ui->assign('p', $p);

        $d = ORM::for_table('tbl_plans')->where('routers', $serv)->where('type', $type)->find_many();


        $ui->assign('d', $d);

        $ui->display('findpack.tpl');
        break;

    case 'add-post':
        $name = _post('name');
        $typebp = _post('typebp');
        $limit_type = _post('limit_type');
        $time_limit = _post('time_limit');
        $time_unit = _post('time_unit');
        $data_limit = _post('data_limit');
        $data_unit = _post('data_unit');
        $id_bw = _post('id_bw');
        $price = _post('pricebp');
        $sharedusers = _post('sharedusers');
        $validity = _post('validity');
        $validity_unit = _post('validity_unit');
        // $routers = _post('routers');


        $msg = '';
        if (Validator::UnsignedNumber($validity) == false) {
            $msg .= 'The validity must be a number' . '<br>';
        }
        if (Validator::UnsignedNumber($price) == false) {
            $msg .= 'The price must be a number' . '<br>';
        }
        // if ($name == '' OR $id_bw == '' OR $price == '' OR $validity == '' OR $routers == ''){
        if ($name == '' or $id_bw == '' or $price == '' or $validity == '') {

            $msg .= $_L['All_field_is_required'] . '<br>';
        }

        $d = ORM::for_table('tbl_plans')->where('name_plan', $name)->where('type', 'Hotspot')->find_one();
        if ($d) {
            $msg .= $_L['Plan_already_exist'] . '<br>';
        }

        if ($msg == '') {
            $b = ORM::for_table('tbl_bandwidth')->where('id', $id_bw)->find_one();
            if ($b['rate_down_unit'] == 'Kbps') {
                $unitdown = 'K';
            } else {
                $unitdown = 'M';
            }
            if ($b['rate_up_unit'] == 'Kbps') {
                $unitup = 'K';
            } else {
                $unitup = 'M';
            }
            $rate = $b['rate_up'] . $unitup . "/" . $b['rate_down'] . $unitdown;

            // $mikrotik = Router::_info($routers);
            // try {
            // 	$client = new RouterOS\Client($mikrotik['ip_address'], $mikrotik['username'], $mikrotik['password']);
            // } catch (Exception $e) {
            // 	die('Unable to connect to the router.');
            // }


            // 	$addRequest = new RouterOS\Request('/ip/hotspot/user/profile/add');
            // $client->sendSync($addRequest
            //     ->setArgument('name', $name)
            //     ->setArgument('shared-users', $sharedusers)
            // 	->setArgument('rate-limit', $rate)
            // 	->setArgument('on-login', '/system scheduler add name=$user interval='.$validity.'d on-event= "/ip hotspot cookie remove [find user=$user] ; /ip hotspot user remove [find name=$user] ; /ip hotspot active remove [find user=$user]; /system sche remove [find name=$user];";')
            // );

            $d = ORM::for_table('tbl_plans')->create();
            $d->name_plan = $name;
            $d->id_bw = $id_bw;
            $d->price = $price;
            $d->type = 'Hotspot';
            $d->typebp = $typebp;
            $d->limit_type = $limit_type;
            $d->time_limit = $time_limit;
            $d->time_unit = $time_unit;
            $d->data_limit = $data_limit;
            $d->data_unit = $data_unit;
            $d->validity = $validity;
            $d->validity_unit = $validity_unit;
            $d->shared_users = $sharedusers;
            // $d->routers = $routers;
            $d->save();

            //radius insert
            $bandy = ORM::for_table('tbl_bandwidth')->where('id', $id_bw)->find_one();
            $radius = ORM::for_table('radusergroup')->create();
            $radius->username = $name;
            $radius->groupname = $bandy['name_bw'];
            $radius->save();

            r2(U . 'hotspot/plans', 's', $_L['Created_Successfully']);
        } else {
            r2(U . 'hotspot/plans', 'e', $msg);
        }
        break;

    case 'print':

        $planname = $_POST['plan'];
        // $nas = $_POST['rout'];
        $plan = $_POST['plan_id'];

        $price = $_POST['price'];
        $numbervoucher = $_POST['numbervoucher'];
        $batch = $_POST['batch'];
        $type = $_POST['type'];
        $lengthcode = $_POST['lengthcode'];
        // $server = $_POST['rout'];
        $generated_by = $_SESSION['adname'];
        $generated_for = $_POST['generated_for'];
        $method = $_SESSION['adname'];

        if ($method == "admin" || $generated_by == $generated_for) {

            // echo $numbervoucher;
            // echo $batch;
            // echo $generated_for;
            // echo $planname;
            // echo"<br>";
            if (empty($_POST['rout'])) {
                $server = 0;
            } else {
                $server = $_POST['rout'];
            }

            $w = ORM::for_table('wallet')->where('username', $generated_for)->find_one();

            $total_bill = $price * $numbervoucher;

            if ($total_bill < $w['available_balance']) {

                // echo $plan.$routername.$price.$voucherNum;
                // // $ui->display('packages.tpl');

                $msg = '';

                if (Validator::UnsignedNumber($numbervoucher) == false) {
                    $msg .= 'The Number of Vouchers must be a number' . '<br>';
                }
                if ($msg == '') {
                    for ($i = 0; $i < $numbervoucher; $i++) {
                        $code = strtoupper(substr(md5(time() . rand(10000, 99999)), 0, $lengthcode));

                        $g = ORM::for_table('tbl_voucher')->where('code', $code)->find_one();
                        if ($g) {
                            continue;
                        }

                        $d = ORM::for_table('tbl_voucher')->create();
                        $d->type = $type;
                        $d->routers = $server;
                        $d->id_plan = $plan;
                        $d->code = $code;
                        $d->batch = $batch;
                        $d->user = '0';
                        $d->status = '0';
                        $d->generated_by = $generated_by;
                        $d->generated_for = $generated_for;
                        $d->save();

                        $vp = ORM::for_table('tbl_plans')->where('id', $plan)->find_one();
                        $k = ORM::for_table('tbl_customers')->create();
                        $k->username = $code;
                        $k->password = $code;
                        // $k->fullname = $code;
                        $k->profile = $planname;
                        $k->validity = $vp['validity'];
                        $k->validity_unit = $vp['validity_unit'];
                        $k->batch = $batch;
                        $k->generated_by = $generated_by;
                        $k->generated_for = $generated_for;
                        $k->save();

                        // $l = ORM::for_table('tbl_customers')->where('username',$code)->find_one();
                        $c = ORM::for_table('tbl_customers')->where('username', $code)->find_one();

                        // echo $l['username'];
                        $id_customer = $c['id'];


                        $date_now = date("Y-m-d H:i:s");
                        $date_only = date("Y-m-d");
                        $time = date("H:i:s");

                        $b = ORM::for_table('tbl_user_recharges')->where('customer_id', $id_customer)->find_one();
                        $w = ORM::for_table('wallet')->where('username', $generated_for)->find_one();
                        $p = ORM::for_table('tbl_plans')->where('id', $plan)->find_one();

                        $mikrotik = Router::_info($server);
                        $date_exp = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") + $p['validity'], date("Y")));


                        $recharge = $p['price'];

                        $updated_credit_balance = $w['credit_balance'] + $recharge;
                        $updated_available_balance = $w['available_balance'] - $recharge;

                        // practice ends

                        //recharge user account

                        if ($server == "0") {

                            // radius insert
                            $radius = ORM::for_table('radcheck')->create();
                            $radius->attribute = "Cleartext-Password";
                            $radius->username = $c['username'];
                            $radius->value = $c['username'];
                            $radius->save();

                            $radius = ORM::for_table('radcheck')->create();
                            $radius->attribute = "User-Profile";
                            $radius->username = $c['username'];
                            $radius->value = $p['name_plan'];
                            $radius->save();

                            $plan_use = ORM::for_table('tbl_plans')->where('id', $plan)->find_one();
                            $radius = ORM::for_table('radcheck')->create();
                            $radius->attribute = "Expire-After";
                            $radius->username = $c['username'];
                            $expire_after = $plan_use['validity'] * 24 * 60 * 60;
                            $radius->value = $expire_after;
                            $radius->save();

                            if ($plan_use['id'] != 5 && $plan_use['id'] != 6 && $plan_use['id'] != 8 && $plan_use['id'] != 20 && $plan_use['id'] != 35 && $plan_use['id'] != 29) {
                                $radius = ORM::for_table('radcheck')->create();
                                $radius->attribute = "Total-Volume-Limit";
                                $radius->username = $c['username'];
                                $data_usage_gb = $plan_use['data_usage_gb'] * 1024 * 1024 * 1024;
                                $radius->value = $data_usage_gb;
                                $radius->save();
                            }


                            if ($plan_use['daily_quota'] != 0) {
                                $daily_quota = $plan_use['daily_quota'] * 1024 * 1024 * 1024;
                                $radius->attribute = "Daily-Quota-Limit";
                                $radius->username = $c['username'];
                                $data_usage_gb = $daily_quota;
                                $radius->value = $data_usage_gb;
                                $radius->save();
                            }

                            // $MikrotikRateLimit = $data_limit.$data_unit;
                            $band = ORM::for_table('tbl_bandwidth')->where('id', $plan_use['id_bw'])->find_one();
                            $MikrotikRateLimit = $band['rate_up'] . "M" . "/" . $band['rate_down'] . "M";

                            $radius1 = ORM::for_table('radreply')->create();
                            $radius1->username = $c['username'];
                            $radius1->attribute = "Mikrotik-Rate-Limit";
                            $radius1->value = $MikrotikRateLimit;
                            $radius1->save();

                            if ($w) {
                                $w->credit_balance = $updated_credit_balance;
                                $w->available_balance = $updated_available_balance;
                                $w->save();
                            } else {
                                echo "Problem Here Bro at 1";
                            }
                        } else {


                            if ($b) {
                                try {
                                    $client = new RouterOS\Client($mikrotik['ip_address'], $mikrotik['username'], $mikrotik['password']);
                                } catch (Exception $e) {
                                    die('Unable to connect to the router.');
                                }

                                $printRequest = new RouterOS\Request(
                                    '/ip hotspot user print .proplist=name',
                                    RouterOS\Query::where('name', $c['username'])
                                );
                                $userName = $client->sendSync($printRequest)->getProperty('name');
                                $removeRequest = new RouterOS\Request('/ip/hotspot/user/remove');
                                $client(
                                    $removeRequest
                                        ->setArgument('numbers', $userName)
                                );
                                /* iBNuX Added:
                                 * 	Time limit to Mikrotik
                                 *	'Time_Limit', 'Data_Limit', 'Both_Limit'
                                 */
                                $addRequest = new RouterOS\Request('/ip/hotspot/user/add');
                                if ($p['typebp'] == "Limited") {
                                    if ($p['limit_type'] == "Time_Limit") {
                                        if ($p['time_unit'] == 'Hrs')
                                            $timelimit = $p['time_limit'] . ":00:00";
                                        else
                                            $timelimit = "00:" . $p['time_limit'] . ":00";
                                        $client->sendSync(
                                            $addRequest
                                                ->setArgument('name', $c['username'])
                                                ->setArgument('profile', $p['name_plan'])
                                                ->setArgument('password', $c['password'])
                                                ->setArgument('limit-uptime', $timelimit)
                                        );
                                        //Mikrotik Schedule
                                        //         $scheduleRequest = new RouterOS\Request('/system/scheduler/add');
                                        // $client->sendSync(
                                        //     $scheduleRequest
                                        //         ->setArgument('name', $c['username'])
                                        //         ->setArgument('interval',$p['validity'].'d')
                                        //         ->setArgument('on-event', "/ip/hotspot user set [find name=".$c['username']."] dis=yes; /ip/hotspot active remove [find name=".$c['username']."]; /system sche remove [find name=".$c['username']."];")
                                        // );


                                    } else if ($p['limit_type'] == "Data_Limit") {
                                        if ($p['data_unit'] == 'GB')
                                            $datalimit = $p['data_limit'] . "000000000";
                                        else
                                            $datalimit = $p['data_limit'] . "000000";
                                        $client->sendSync(
                                            $addRequest
                                                ->setArgument('name', $c['username'])
                                                ->setArgument('profile', $p['name_plan'])
                                                ->setArgument('password', $c['password'])
                                                ->setArgument('limit-bytes-total', $datalimit)
                                        );
                                        //Mikrotik Schedule
                                        // $scheduleRequest = new RouterOS\Request('/system/scheduler/add');
                                        // $client->sendSync(
                                        //     $scheduleRequest
                                        //         ->setArgument('name', $c['username'])
                                        //         ->setArgument('interval',$p['validity'].'d')
                                        //         ->setArgument('on-event', "/ip/hotspot user set [find name=".$c['username']."] dis=yes; /ip/hotspot active remove [find name=".$c['username']."]; /system sche remove [find name=".$c['username']."];")
                                        // );
                                    } else if ($p['limit_type'] == "Both_Limit") {
                                        if ($p['time_unit'] == 'Hrs')
                                            $timelimit = $p['time_limit'] . ":00:00";
                                        else
                                            $timelimit = "00:" . $p['time_limit'] . ":00";
                                        if ($p['data_unit'] == 'GB')
                                            $datalimit = $p['data_limit'] . "000000000";
                                        else
                                            $datalimit = $p['data_limit'] . "000000";
                                        $client->sendSync(
                                            $addRequest
                                                ->setArgument('name', $c['username'])
                                                ->setArgument('profile', $p['name_plan'])
                                                ->setArgument('password', $c['password'])
                                                ->setArgument('limit-uptime', $timelimit)
                                                ->setArgument('limit-bytes-total', $datalimit)
                                        );
                                        //Mikrotik Schedule
                                        // $scheduleRequest = new RouterOS\Request('/system/scheduler/add');
                                        // $client->sendSync(
                                        //     $scheduleRequest
                                        //         ->setArgument('name', $c['username'])
                                        //         ->setArgument('interval',$p['validity'].'d')
                                        //         ->setArgument('on-event', "/ip/hotspot user set [find name=".$c['username']."] dis=yes; /ip/hotspot active remove [find name=".$c['username']."]; /system sche remove [find name=".$c['username']."];")
                                        // );


                                    }
                                } else {
                                    $client->sendSync(
                                        $addRequest
                                            ->setArgument('name', $c['username'])
                                            ->setArgument('profile', $p['name_plan'])
                                            ->setArgument('password', $c['password'])
                                    );
                                    //Mikrotik Schedule
                                    // $scheduleRequest = new RouterOS\Request('/system/scheduler/add');
                                    // $client->sendSync(
                                    //     $scheduleRequest
                                    //         ->setArgument('name', $c['username'])
                                    //         ->setArgument('interval',$p['validity'].'d')
                                    //         ->setArgument('on-event', "/ip/hotspot user set [find name=".$c['username']."] dis=yes; /ip/hotspot active remove [find name=".$c['username']."]; /system sche remove [find name=".$c['username']."];")
                                    // );

                                }

                                $b->customer_id = $id_customer;
                                $b->username = $c['username'];
                                $b->plan_id = $plan;
                                $b->namebp = $p['name_plan'];
                                $b->recharged_on = $date_only;
                                $b->expiration = $date_exp;
                                $b->time = $time;
                                $b->status = "on";
                                $b->method = $method;
                                $b->routers = $server;
                                $b->type = "Hotspot";
                                $b->save();




                                // insert table transactions
                                $t = ORM::for_table('tbl_transactions')->create();
                                $t->invoice = "INV-" . _raid(5);
                                $t->username = $c['username'];
                                $t->plan_name = $p['name_plan'];
                                $t->price = $p['price'];
                                $t->recharged_on = $date_only;
                                $t->expiration = $date_exp;
                                $t->time = $time;
                                $t->method = $method;
                                $t->routers = $server;
                                $t->type = "Hotspot";
                                $t->save();


                                // radius insert
                                $radius = ORM::for_table('radcheck')->create();
                                $radius->attribute = "Cleartext-Password";
                                $radius->username = $c['username'];
                                $radius->value = $c['username'];
                                $radius->save();

                                $radius = ORM::for_table('radcheck')->create();
                                $radius->attribute = "User-Profile";
                                $radius->username = $c['username'];
                                $radius->value = $p['name_plan'];
                                $radius->save();

                                $plan_use = ORM::for_table('tbl_plans')->where('id', $plan)->find_one();
                                $radius = ORM::for_table('radcheck')->create();
                                $radius->attribute = "Expire-After";
                                $radius->username = $c['username'];
                                $expire_after = $plan_use['validity'] * 24 * 60 * 60;
                                $radius->value = $expire_after;
                                $radius->save();

                                $radius = ORM::for_table('radcheck')->create();
                                $radius->attribute = "Total-Volume-Limit";
                                $radius->username = $c['username'];
                                $data_usage_gb = $plan_use['data_usage_gb'] * 1024 * 1024 * 1024;
                                $radius->value = $data_usage_gb;
                                $radius->save();

                                if ($plan_use['daily_quota'] != 0) {
                                    $daily_quota = $plan_use['daily_quota'] * 1024 * 1024 * 1024;
                                    $radius->attribute = "Daily-Quota-Limit";
                                    $radius->username = $c['username'];
                                    $data_usage_gb = $daily_quota;
                                    $radius->value = $data_usage_gb;
                                    $radius->save();
                                }

                                // $MikrotikRateLimit = $data_limit . $data_unit;
                                $band = ORM::for_table('tbl_bandwidth')->where('id', $plan_use['id_bw'])->find_one();
                                $MikrotikRateLimit = $band['rate_up'] . "M" . "/" . $band['rate_down'] . "M";
                                $radius1 = ORM::for_table('radreply')->create();
                                $radius1->username = $c['username'];
                                $radius1->attribute = "Mikrotik-Rate-Limit";
                                $radius1->value = $MikrotikRateLimit;
                                $radius1->save();

                                if ($w) {
                                    $w->credit_balance = $updated_credit_balance;
                                    $w->available_balance = $updated_available_balance;
                                    $w->save();
                                } else {
                                    echo "Problem Here Bro at 1";
                                }
                            } else {
                                try {
                                    $client = new RouterOS\Client($mikrotik['ip_address'], $mikrotik['username'], $mikrotik['password']);
                                } catch (Exception $e) {
                                    die('Unable to connect to the router.');
                                }

                                /* iBNuX Added:
                                 * 	Time limit to Mikrotik
                                 *	'Time_Limit', 'Data_Limit', 'Both_Limit'
                                 */
                                $addRequest = new RouterOS\Request('/ip/hotspot/user/add');
                                if ($p['typebp'] == "Limited") {
                                    if ($p['limit_type'] == "Time_Limit") {
                                        if ($p['time_unit'] == 'Hrs')
                                            $timelimit = $p['time_limit'] . ":00:00";
                                        else
                                            $timelimit = "00:" . $p['time_limit'] . ":00";
                                        $client->sendSync(
                                            $addRequest
                                                ->setArgument('name', $c['username'])
                                                ->setArgument('profile', $p['name_plan'])
                                                ->setArgument('password', $c['password'])
                                                ->setArgument('limit-uptime', $timelimit)
                                        );
                                        //Mikrotik Schedule
                                        // $scheduleRequest = new RouterOS\Request('/system/scheduler/add');
                                        // $client->sendSync(
                                        //     $scheduleRequest
                                        //         ->setArgument('name', $c['username'])
                                        //         ->setArgument('interval',$p['validity'].'d')
                                        //         ->setArgument('on-event', "/ip/hotspot user set [find name=".$c['username']."] dis=yes; /ip/hotspot active remove [find name=".$c['username']."]; /system sche remove [find name=".$c['username']."];")
                                        // );

                                    } else if ($p['limit_type'] == "Data_Limit") {
                                        if ($p['data_unit'] == 'GB')
                                            $datalimit = $p['data_limit'] . "000000000";
                                        else
                                            $datalimit = $p['data_limit'] . "000000";
                                        $client->sendSync(
                                            $addRequest
                                                ->setArgument('name', $c['username'])
                                                ->setArgument('profile', $p['name_plan'])
                                                ->setArgument('password', $c['password'])
                                                ->setArgument('limit-bytes-total', $datalimit)
                                        );
                                        //Mikrotik Schedule
                                        // $scheduleRequest = new RouterOS\Request('/system/scheduler/add');
                                        // $client->sendSync(
                                        //     $scheduleRequest
                                        //         ->setArgument('name', $c['username'])
                                        //         ->setArgument('interval',$p['validity'].'d')
                                        //         ->setArgument('on-event', "/ip/hotspot user set [find name=".$c['username']."] dis=yes; /ip/hotspot active remove [find name=".$c['username']."]; /system sche remove [find name=".$c['username']."];")
                                        // );

                                    } else if ($p['limit_type'] == "Both_Limit") {
                                        if ($p['time_unit'] == 'Hrs')
                                            $timelimit = $p['time_limit'] . ":00:00";
                                        else
                                            $timelimit = "00:" . $p['time_limit'] . ":00";
                                        if ($p['data_unit'] == 'GB')
                                            $datalimit = $p['data_limit'] . "000000000";
                                        else
                                            $datalimit = $p['data_limit'] . "000000";
                                        $client->sendSync(
                                            $addRequest
                                                ->setArgument('name', $c['username'])
                                                ->setArgument('profile', $p['name_plan'])
                                                ->setArgument('password', $c['password'])
                                                ->setArgument('limit-uptime', $timelimit)
                                                ->setArgument('limit-bytes-total', $datalimit)
                                        );
                                        //Mikrotik Schedule
                                        // $scheduleRequest = new RouterOS\Request('/system/scheduler/add');
                                        // $client->sendSync(
                                        //     $scheduleRequest
                                        //         ->setArgument('name', $c['username'])
                                        //         ->setArgument('interval',$p['validity'].'d')
                                        //         ->setArgument('on-event', "/ip/hotspot user set [find name=".$c['username']."] dis=yes; /ip/hotspot active remove [find name=".$c['username']."]; /system sche remove [find name=".$c['username']."];")
                                        // );

                                    }
                                } else {
                                    $client->sendSync(
                                        $addRequest
                                            ->setArgument('name', $c['username'])
                                            ->setArgument('profile', $p['name_plan'])
                                            ->setArgument('password', $c['password'])
                                    );
                                    //Mikrotik Schedule
                                    // $scheduleRequest = new RouterOS\Request('/system/scheduler/add');
                                    // $client->sendSync(
                                    //     $scheduleRequest
                                    //         ->setArgument('name', $c['username'])
                                    //         ->setArgument('interval',$p['validity'].'d')
                                    //         ->setArgument('on-event', "/ip/hotspot user set [find name=".$c['username']."] dis=yes; /ip/hotspot active remove [find name=".$c['username']."]; /system sche remove [find name=".$c['username']."];")
                                    // );

                                }

                                $d = ORM::for_table('tbl_user_recharges')->create();
                                $d->customer_id = $id_customer;
                                $d->username = $c['username'];
                                $d->plan_id = $plan;
                                $d->namebp = $p['name_plan'];
                                $d->recharged_on = $date_only;
                                $d->expiration = $date_exp;
                                $d->time = $time;
                                $d->status = "on";
                                $d->method = $method;
                                $d->routers = $server;
                                $d->type = "Hotspot";
                                $d->save();

                                // insert table transactions
                                $t = ORM::for_table('tbl_transactions')->create();
                                $t->invoice = "INV-" . _raid(5);
                                $t->username = $c['username'];
                                $t->plan_name = $p['name_plan'];
                                $t->price = $p['price'];
                                $t->recharged_on = $date_only;
                                $t->expiration = $date_exp;
                                $t->time = $time;
                                $t->method = $method;
                                $t->routers = $server;
                                $t->type = "Hotspot";
                                $t->save();

                                // radius insert
                                $radius = ORM::for_table('radcheck')->create();
                                $radius->attribute = "Cleartext-Password";
                                $radius->username = $c['username'];
                                $radius->value = $c['username'];
                                $radius->save();

                                $radius = ORM::for_table('radcheck')->create();
                                $radius->attribute = "User-Profile";
                                $radius->username = $c['username'];
                                $radius->value = $p['name_plan'];
                                $radius->save();

                                $plan_use = ORM::for_table('tbl_plans')->where('id', $plan)->find_one();
                                $radius = ORM::for_table('radcheck')->create();
                                $radius->attribute = "Expire-After";
                                $radius->username = $c['username'];
                                $expire_after = $plan_use['validity'] * 24 * 60 * 60;
                                $radius->value = $expire_after;
                                $radius->save();

                                $radius = ORM::for_table('radcheck')->create();
                                $radius->attribute = "Total-Volume-Limit";
                                $radius->username = $c['username'];
                                $data_usage_gb = $plan_use['data_usage_gb'] * 1024 * 1024 * 1024;
                                $radius->value = $data_usage_gb;
                                $radius->save();

                                if ($plan_use['daily_quota'] != 0) {
                                    $daily_quota = $plan_use['daily_quota'] * 1024 * 1024 * 1024;
                                    $radius->attribute = "Daily-Quota-Limit";
                                    $radius->username = $c['username'];
                                    $data_usage_gb = $daily_quota;
                                    $radius->value = $data_usage_gb;
                                    $radius->save();
                                }

                                // $MikrotikRateLimit = $data_limit . $data_unit;
                                $band = ORM::for_table('tbl_bandwidth')->where('id', $plan_use['id_bw'])->find_one();
                                $MikrotikRateLimit = $band['rate_up'] . "M" . "/" . $band['rate_down'] . "M";
                                $radius1 = ORM::for_table('radreply')->create();
                                $radius1->username = $c['username'];
                                $radius1->attribute = "Mikrotik-Rate-Limit";
                                $radius1->value = $MikrotikRateLimit;
                                $radius1->save();

                                if ($w) {
                                    $w->credit_balance = $updated_credit_balance;
                                    $w->available_balance = $updated_available_balance;
                                    $w->save();
                                } else {
                                    echo "Problem Here Bro at 2";
                                }
                            }
                        }
                    }






                    // practice 

                    // $id_customer = _post('id_customer');








                    //printing the voucher
                    // if(empty($_POST)){
                    //     $from_id = 1;
                    //     // $planid = _post('planid') * 1;
                    //     $pagebreak = 3;
                    //     $limit = 30;
                    // }else{
                    //     $from_id = _post('from_id') * 1;
                    //     $planid = _post('planid') * 1;
                    //     $pagebreak = _post('pagebreak') * 1;
                    //     $limit = _post('limit') * 1;
                    // }

                    $myId = ORM::for_table('tbl_voucher')->max('id');

                    $numId = $myId - $numbervoucher;



                    $from_id = $numId;
                    $planid = $plan;
                    $pagebreak = 3;
                    $limit = 1000;





                    if ($pagebreak < 1)
                        $pagebreak = 6;

                    if ($limit < 1)
                        $limit = $pagebreak * 2;

                    if ($from_id > 0 && $planid > 0) {
                        $v = ORM::for_table('tbl_plans')
                            ->join('tbl_voucher', array('tbl_plans.id', '=', 'tbl_voucher.id_plan'))
                            ->where('tbl_voucher.status', '0')
                            ->where('tbl_plans.id', $planid)
                            ->where_gt('tbl_voucher.id', $from_id)
                            ->limit($limit)
                            ->find_many();
                        $vc = ORM::for_table('tbl_plans')
                            ->join('tbl_voucher', array('tbl_plans.id', '=', 'tbl_voucher.id_plan'))
                            ->where('tbl_voucher.status', '0')
                            ->where('tbl_plans.id', $planid)
                            ->where_gt('tbl_voucher.id', $from_id)
                            ->count();
                    } else if ($from_id == 0 && $planid > 0) {
                        $v = ORM::for_table('tbl_plans')
                            ->join('tbl_voucher', array('tbl_plans.id', '=', 'tbl_voucher.id_plan'))
                            ->where('tbl_voucher.status', '0')
                            ->where('tbl_plans.id', $planid)
                            ->limit($limit)
                            ->find_many();
                        $vc = ORM::for_table('tbl_plans')
                            ->join('tbl_voucher', array('tbl_plans.id', '=', 'tbl_voucher.id_plan'))
                            ->where('tbl_voucher.status', '0')
                            ->where('tbl_plans.id', $planid)
                            ->count();
                    } else if ($from_id > 0 && $planid == 0) {
                        $v = ORM::for_table('tbl_plans')
                            ->join('tbl_voucher', array('tbl_plans.id', '=', 'tbl_voucher.id_plan'))
                            ->where('tbl_voucher.status', '0')
                            ->where_gt('tbl_voucher.id', $from_id)
                            ->limit($limit)
                            ->find_many();
                        $vc = ORM::for_table('tbl_plans')
                            ->join('tbl_voucher', array('tbl_plans.id', '=', 'tbl_voucher.id_plan'))
                            ->where('tbl_voucher.status', '0')
                            ->where_gt('tbl_voucher.id', $from_id)
                            ->count();
                    } else {
                        $v = ORM::for_table('tbl_plans')
                            ->join('tbl_voucher', array('tbl_plans.id', '=', 'tbl_voucher.id_plan'))
                            ->where('tbl_voucher.status', '0')
                            ->limit($limit)
                            ->find_many();
                        $vc = ORM::for_table('tbl_plans')
                            ->join('tbl_voucher', array('tbl_plans.id', '=', 'tbl_voucher.id_plan'))
                            ->where('tbl_voucher.status', '0')
                            ->count();
                    }

                    $ui->assign('_title', $_L['Voucher_Hotspot'] . ' - ' . $config['CompanyName']);
                    $ui->assign('from_id', $from_id);
                    $ui->assign('pagebreak', $pagebreak);

                    $plans = ORM::for_table('tbl_plans')->find_many();
                    $ui->assign('plans', $plans);
                    $ui->assign('limit', $limit);
                    $ui->assign('planid', $planid);

                    $ui->assign('v', $v);
                    $ui->assign('vc', $vc);

                    //for counting pagebreak
                    $ui->assign('jml', 0);

                    $ui->display('print-voucher.tpl');
                } else {
                    r2(U . 'hotspot/packages' . $id, 'e', $msg);
                }
            } else {
                $msg = "You dont have sufficient balance in your Wallet";
                r2(U . 'hotspot/packages' . $id, 'e', $msg);
            }
        } else {
            $msg = "You cannot generatevoucher for others.";
            r2(U . 'hotspot/packages' . $id, 'e', $msg);
        }
        break;

    case 'batch_recharge':


        $type = "Hotspot";

        $p = ORM::for_table('tbl_routers')->find_many();
        $ui->assign('p', $p);


        // $d = ORM::for_table('tbl_voucher')->distinct('batch')->find_many();

        // $d = ORM::for_table('tbl_plans')->where('routers',$serv)->where('type',$type)->find_many();


        // $ui->assign('d', $d);

        $ui->display('batch-recharge.tpl');

        break;




    case 'packages2':

        $p = ORM::for_table('tbl_plans')->find_many();
        $ui->assign('p', $p);

        $ui->display('packages2.tpl');
        break;

    case 'find_pack2':

        $type = "Hotspot";

        $rout = ORM::for_table('tbl_routers')->find_many();
        $ui->assign('rout', $rout);

        $p = ORM::for_table('tbl_plans')->find_many();
        $ui->assign('p', $p);

        // $d = ORM::for_table('tbl_plans')->where('type',$type)->find_many();

        $bin = "0";
        $d = ORM::for_table('tbl_plans')->where('routers', $bin)->where('type', $type)->find_many();
        $ui->assign('d', $d);

        $user = ORM::for_table('tbl_users')->find_many();
        $ui->assign('user', $user);

        $ui->display('findpack2.tpl');
        break;


    case 'print2':

        // $plan = $_POST['plan'];
        // $plan = $_POST['plan_id'];
        $planname = $_POST['plan'];
        // $server = $_POST['server'];
        $price = $_POST['price'];
        $numbervoucher = $_POST['numbervoucher'];
        $batch = $_POST['batch'];
        $type = "Hotspot";
        $lengthcode = $_POST['lengthcode'];
        $generated_for = $_POST['generated_for'];

        $generated_by = $_SESSION['adname'];
        $method = $_SESSION['adname'];

        $w = ORM::for_table('wallet')->where('username', $generated_for)->find_one();
        $plandb = ORM::for_table('tbl_plans')->where('name_plan', $planname)->find_one();
        $plan = $plandb['id'];

        $total_bill = $price * $numbervoucher;
        // echo $price."<br>";
        // echo $numbervoucher."<br>";
        // echo $total_bill;
        // echo $method;
        // echo $w['available_balance'];
        // die();

        if ($total_bill < $w['available_balance']) {


            // echo $plan.$routername.$price.$voucherNum;
            // // $ui->display('packages.tpl');

            $msg = '';

            if (Validator::UnsignedNumber($numbervoucher) == false) {
                $msg .= 'The Number of Vouchers must be a number' . '<br>';
            }
            if ($msg == '') {
                for ($i = 0; $i < $numbervoucher; $i++) {
                    $code = strtoupper(substr(md5(time() . rand(10000, 99999)), 0, $lengthcode));

                    $g = ORM::for_table('tbl_voucher')->where('code', $code)->find_one();
                    if ($g) {
                        continue;
                    }

                    $d = ORM::for_table('tbl_voucher')->create();
                    $d->type = $type;
                    $d->id_plan = $plan;
                    $d->code = $code;
                    $d->batch = $batch;
                    $d->user = '0';
                    $d->status = '0';
                    $d->generated_by = $generated_by;
                    $d->generated_for = $generated_for;
                    $d->save();

                    $vp = ORM::for_table('tbl_plans')->where('id', $plan)->find_one();
                    $k = ORM::for_table('tbl_customers')->create();
                    $k->username = $code;
                    $k->password = $code;
                    $k->fullname = $code;
                    $k->batch = $batch;
                    $k->profile = $planname;
                    $k->validity = $vp['validity'];
                    $k->validity_unit = $vp['validity_unit'];
                    $k->generated_by = $generated_by;
                    $k->generated_for = $generated_for;
                    $k->save();

                    // radius insert
                    $plan_use = ORM::for_table('tbl_plans')->where('id', $plan)->find_one();

                    $radius = ORM::for_table('radcheck')->create();
                    $radius->attribute = "Cleartext-Password";
                    $radius->username = $code;
                    $radius->value = $code;
                    $radius->save();

                    $radius = ORM::for_table('radcheck')->create();
                    $radius->attribute = "User-Profile";
                    $radius->username = $code;
                    $radius->value = $plan_use['name_plan'];
                    $radius->save();

                    // $plan_use = ORM::for_table('tbl_plans')->where('id', $plan)->find_one();
                    $radius = ORM::for_table('radcheck')->create();
                    $radius->attribute = "Expire-After";
                    $radius->username = $code;
                    $expire_after = $plan_use['validity'] * 24 * 60 * 60;
                    $radius->value = $expire_after;
                    $radius->save();

                    $data_usage_gb = $plan_use['data_usage_gb'] * 1024 * 1024 * 1024;
                    $radius = ORM::for_table('radcheck')->create();
                    $radius->username = $c['username'];
                    $radius->attribute = "Total-Volume-Limit";
                    $radius->value = $data_usage_gb;
                    $radius->save();

                    if ($plan_use['daily_quota'] != 0) {
                        $daily_quota = $plan_use['daily_quota'] * 1024 * 1024 * 1024;
                        $radius->attribute = "Daily-Quota-Limit";
                        $radius->username = $c['username'];
                        $data_usage_gb = $daily_quota;
                        $radius->value = $data_usage_gb;
                        $radius->save();
                    }

                    // $MikrotikRateLimit = $plan_use['data_limit'] . $plan_use['data_unit'];
                    $band = ORM::for_table('tbl_bandwidth')->where('id', $plan_use['id_bw'])->find_one();
                    $MikrotikRateLimit = $band['rate_up'] . "M" . "/" . $band['rate_down'] . "M";
                    $radius1 = ORM::for_table('radreply')->create();
                    $radius1->username = $code;
                    $radius1->attribute = "Mikrotik-Rate-Limit";
                    $radius1->value = $MikrotikRateLimit;
                    $radius1->save();
                }
            } else {
                r2(U . 'hotspot/find_pack2' . $id, 'e', $msg);
            }
        } else {
            $msg = "You dont have sufficient balance in your Wallet";
            r2(U . 'hotspot/find_pack2' . $id, 'e', $msg);
        }

        r2(U . 'hotspot/find_pack2', 's', $_L['Created_Successfully']);

        break;

    case 'batch_process':


        $server = $_POST['nas'];
        $batch = $_POST['batch'];
        $vx = ORM::for_table('tbl_voucher')->where('batch', $batch)->find_many();

        foreach ($vx as $my) {
            $code = $my['code'];
            $plan = $my['id_plan'];


            $generated_by = $_SESSION['adname'];
            $method = $_SESSION['adname'];


            // $l = ORM::for_table('tbl_customers')->where('username',$code)->find_one();
            $c = ORM::for_table('tbl_customers')->where('username', $code)->find_one();

            // echo $l['username'];
            $id_customer = $c['id'];


            $date_now = date("Y-m-d H:i:s");
            $date_only = date("Y-m-d");
            $time = date("H:i:s");

            $b = ORM::for_table('tbl_user_recharges')->where('customer_id', $id_customer)->find_one();
            $w = ORM::for_table('wallet')->where('username', $method)->find_one();
            $p = ORM::for_table('tbl_plans')->find_one($plan);

            $vunit = $p['validity_unit'];
            // if($p['validity_unit'] == 'Days'){
            //     $vunit = 'd';
            //  }else{
            //     $vunit='h';
            //  }
            //  echo $vunit;
            //  die();

            $name = $p['name_plan'];
            $sharedusers = $p['shared_users'];
            $id_bw = $p['id_bw'];
            $validity = $p['validity'];

            $bw = ORM::for_table('tbl_bandwidth')->where('id', $id_bw)->find_one();
            if ($bw['rate_down_unit'] == 'Kbps') {
                $unitdown = 'K';
            } else {
                $unitdown = 'M';
            }
            if ($bw['rate_up_unit'] == 'Kbps') {
                $unitup = 'K';
            } else {
                $unitup = 'M';
            }
            $rate = $bw['rate_up'] . $unitup . "/" . $bw['rate_down'] . $unitdown;

            // $p->routers = $server;
            // $p->save();




            $mikrotik = Router::_info($server);
            $date_exp = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") + $p['validity'], date("Y")));


            $recharge = $p['price'];

            $updated_credit_balance = $w['credit_balance'] + $recharge;
            $updated_available_balance = $w['available_balance'] - $recharge;

            // practice ends

            //recharge user account

            if ($b) {
                try {
                    $client = new RouterOS\Client($mikrotik['ip_address'], $mikrotik['username'], $mikrotik['password']);
                } catch (Exception $e) {
                    die('Unable to connect to the router.');
                }

                //  Starting of Hotspot Plans   




                $profileRequest = new RouterOS\Request('/ip/hotspot/user/profile/add');
                $client->sendSync(
                    $profileRequest
                        ->setArgument('name', $name)
                        ->setArgument('shared-users', $sharedusers)
                        ->setArgument('rate-limit', $rate)
                        ->setArgument('on-login', '/system scheduler add name=$user interval=' . $validity . $vunit . ' on-event= "/ip hotspot cookie remove [find user=$user] ; /ip hotspot user remove [find name=$user] ; /ip hotspot active remove [find user=$user]; /system sche remove [find name=$user];";')
                );

                $printRequest = new RouterOS\Request(
                    '/ip hotspot user print .proplist=name',
                    RouterOS\Query::where('name', $c['username'])
                );
                $userName = $client->sendSync($printRequest)->getProperty('name');
                $removeRequest = new RouterOS\Request('/ip/hotspot/user/remove');
                $client(
                    $removeRequest
                        ->setArgument('numbers', $userName)
                );
                /* iBNuX Added:
                 * 	Time limit to Mikrotik
                 *	'Time_Limit', 'Data_Limit', 'Both_Limit'
                 */
                $addRequest = new RouterOS\Request('/ip/hotspot/user/add');
                if ($p['typebp'] == "Limited") {
                    if ($p['limit_type'] == "Time_Limit") {
                        if ($p['time_unit'] == 'Hrs')
                            $timelimit = $p['time_limit'] . ":00:00";
                        else
                            $timelimit = "00:" . $p['time_limit'] . ":00";
                        $client->sendSync(
                            $addRequest
                                ->setArgument('name', $c['username'])
                                ->setArgument('profile', $p['name_plan'])
                                ->setArgument('password', $c['password'])
                                ->setArgument('limit-uptime', $timelimit)
                        );
                        //Mikrotik Schedule
                        //         $scheduleRequest = new RouterOS\Request('/system/scheduler/add');
                        // $client->sendSync(
                        //     $scheduleRequest
                        //         ->setArgument('name', $c['username'])
                        //         ->setArgument('interval',$p['validity'].'d')
                        //         ->setArgument('on-event', "/ip/hotspot user set [find name=".$c['username']."] dis=yes; /ip/hotspot active remove [find name=".$c['username']."]; /system sche remove [find name=".$c['username']."];")
                        // );


                    } else if ($p['limit_type'] == "Data_Limit") {
                        if ($p['data_unit'] == 'GB')
                            $datalimit = $p['data_limit'] . "000000000";
                        else
                            $datalimit = $p['data_limit'] . "000000";
                        $client->sendSync(
                            $addRequest
                                ->setArgument('name', $c['username'])
                                ->setArgument('profile', $p['name_plan'])
                                ->setArgument('password', $c['password'])
                                ->setArgument('limit-bytes-total', $datalimit)
                        );
                        //Mikrotik Schedule
                        // $scheduleRequest = new RouterOS\Request('/system/scheduler/add');
                        // $client->sendSync(
                        //     $scheduleRequest
                        //         ->setArgument('name', $c['username'])
                        //         ->setArgument('interval',$p['validity'].'d')
                        //         ->setArgument('on-event', "/ip/hotspot user set [find name=".$c['username']."] dis=yes; /ip/hotspot active remove [find name=".$c['username']."]; /system sche remove [find name=".$c['username']."];")
                        // );
                    } else if ($p['limit_type'] == "Both_Limit") {
                        if ($p['time_unit'] == 'Hrs')
                            $timelimit = $p['time_limit'] . ":00:00";
                        else
                            $timelimit = "00:" . $p['time_limit'] . ":00";
                        if ($p['data_unit'] == 'GB')
                            $datalimit = $p['data_limit'] . "000000000";
                        else
                            $datalimit = $p['data_limit'] . "000000";
                        $client->sendSync(
                            $addRequest
                                ->setArgument('name', $c['username'])
                                ->setArgument('profile', $p['name_plan'])
                                ->setArgument('password', $c['password'])
                                ->setArgument('limit-uptime', $timelimit)
                                ->setArgument('limit-bytes-total', $datalimit)
                        );
                        //Mikrotik Schedule
                        // $scheduleRequest = new RouterOS\Request('/system/scheduler/add');
                        // $client->sendSync(
                        //     $scheduleRequest
                        //         ->setArgument('name', $c['username'])
                        //         ->setArgument('interval',$p['validity'].'d')
                        //         ->setArgument('on-event', "/ip/hotspot user set [find name=".$c['username']."] dis=yes; /ip/hotspot active remove [find name=".$c['username']."]; /system sche remove [find name=".$c['username']."];")
                        // );


                    }
                } else {
                    $client->sendSync(
                        $addRequest
                            ->setArgument('name', $c['username'])
                            ->setArgument('profile', $p['name_plan'])
                            ->setArgument('password', $c['password'])
                    );
                    //Mikrotik Schedule
                    // $scheduleRequest = new RouterOS\Request('/system/scheduler/add');
                    // $client->sendSync(
                    //     $scheduleRequest
                    //         ->setArgument('name', $c['username'])
                    //         ->setArgument('interval',$p['validity'].'d')
                    //         ->setArgument('on-event', "/ip/hotspot user set [find name=".$c['username']."] dis=yes; /ip/hotspot active remove [find name=".$c['username']."]; /system sche remove [find name=".$c['username']."];")
                    // );

                }

                $b->customer_id = $id_customer;
                $b->username = $c['username'];
                $b->plan_id = $plan;
                $b->namebp = $p['name_plan'];
                $b->recharged_on = $date_only;
                $b->expiration = $date_exp;
                $b->time = $time;
                $b->status = "on";
                $b->method = $method;
                $b->routers = $server;
                $b->type = "Hotspot";
                $b->save();




                // insert table transactions
                $t = ORM::for_table('tbl_transactions')->create();
                $t->invoice = "INV-" . _raid(5);
                $t->username = $c['username'];
                $t->plan_name = $p['name_plan'];
                $t->price = $p['price'];
                $t->recharged_on = $date_only;
                $t->expiration = $date_exp;
                $t->time = $time;
                $t->method = $method;
                $t->routers = $server;
                $t->type = "Hotspot";
                $t->save();

                // radius insert
                $planname = ORM::for_table('tbl_plans')->where('id', $plan)->find_one();

                $radius = ORM::for_table('radcheck')->create();
                $radius->attribute = "Cleartext-Password";
                $radius->username = $c['username'];
                $radius->value = $c['username'];
                $radius->save();

                $radius = ORM::for_table('radcheck')->create();
                $radius->attribute = "User-Profile";
                $radius->username = $c['username'];
                $radius->value = $planname['name_plan'];
                $radius->save();

                $plan_use = ORM::for_table('tbl_plans')->where('id', $plan)->find_one();
                $radius = ORM::for_table('radcheck')->create();
                $radius->attribute = "Expire-After";
                $radius->username = $c['username'];
                $expire_after = $plan_use['validity'] * 24 * 60 * 60;
                $radius->value = $expire_after;
                $radius->save();

                $data_usage_gb = $plan_use['data_usage_gb'] * 1024 * 1024 * 1024;
                $radius = ORM::for_table('radcheck')->create();
                $radius->username = $c['username'];
                $radius->attribute = "Total-Volume-Limit";
                $radius->value = $data_usage_gb;
                $radius->save();

                if ($plan_use['daily_quota'] != 0) {
                    $daily_quota = $plan_use['daily_quota'] * 1024 * 1024 * 1024;
                    $radius->attribute = "Daily-Quota-Limit";
                    $radius->username = $c['username'];
                    $data_usage_gb = $daily_quota;
                    $radius->value = $data_usage_gb;
                    $radius->save();
                }

                // $MikrotikRateLimit = $data_limit . $data_unit;
                $band = ORM::for_table('tbl_bandwidth')->where('id', $plan_use['id_bw'])->find_one();
                $MikrotikRateLimit = $band['rate_up'] . "M" . "/" . $band['rate_down'] . "M";
                $radius1 = ORM::for_table('radreply')->create();
                $radius1->username = $c['username'];
                $radius1->attribute = "Mikrotik-Rate-Limit";
                $radius1->value = $MikrotikRateLimit;
                $radius1->save();

                if ($w) {
                    $w->credit_balance = $updated_credit_balance;
                    $w->available_balance = $updated_available_balance;
                    $w->save();
                } else {
                    echo "Problem Here Bro at 1";
                }
            } else {
                try {
                    $client = new RouterOS\Client($mikrotik['ip_address'], $mikrotik['username'], $mikrotik['password']);
                } catch (Exception $e) {
                    die('Unable to connect to the router.');
                }

                /* iBNuX Added:
                 * 	Time limit to Mikrotik
                 *	'Time_Limit', 'Data_Limit', 'Both_Limit'
                 */
                $addRequest = new RouterOS\Request('/ip/hotspot/user/add');
                if ($p['typebp'] == "Limited") {
                    if ($p['limit_type'] == "Time_Limit") {
                        if ($p['time_unit'] == 'Hrs')
                            $timelimit = $p['time_limit'] . ":00:00";
                        else
                            $timelimit = "00:" . $p['time_limit'] . ":00";
                        $client->sendSync(
                            $addRequest
                                ->setArgument('name', $c['username'])
                                ->setArgument('profile', $p['name_plan'])
                                ->setArgument('password', $c['password'])
                                ->setArgument('limit-uptime', $timelimit)
                        );
                        //Mikrotik Schedule
                        // $scheduleRequest = new RouterOS\Request('/system/scheduler/add');
                        // $client->sendSync(
                        //     $scheduleRequest
                        //         ->setArgument('name', $c['username'])
                        //         ->setArgument('interval',$p['validity'].'d')
                        //         ->setArgument('on-event', "/ip/hotspot user set [find name=".$c['username']."] dis=yes; /ip/hotspot active remove [find name=".$c['username']."]; /system sche remove [find name=".$c['username']."];")
                        // );

                    } else if ($p['limit_type'] == "Data_Limit") {
                        if ($p['data_unit'] == 'GB')
                            $datalimit = $p['data_limit'] . "000000000";
                        else
                            $datalimit = $p['data_limit'] . "000000";
                        $client->sendSync(
                            $addRequest
                                ->setArgument('name', $c['username'])
                                ->setArgument('profile', $p['name_plan'])
                                ->setArgument('password', $c['password'])
                                ->setArgument('limit-bytes-total', $datalimit)
                        );
                        //Mikrotik Schedule
                        // $scheduleRequest = new RouterOS\Request('/system/scheduler/add');
                        // $client->sendSync(
                        //     $scheduleRequest
                        //         ->setArgument('name', $c['username'])
                        //         ->setArgument('interval',$p['validity'].'d')
                        //         ->setArgument('on-event', "/ip/hotspot user set [find name=".$c['username']."] dis=yes; /ip/hotspot active remove [find name=".$c['username']."]; /system sche remove [find name=".$c['username']."];")
                        // );

                    } else if ($p['limit_type'] == "Both_Limit") {
                        if ($p['time_unit'] == 'Hrs')
                            $timelimit = $p['time_limit'] . ":00:00";
                        else
                            $timelimit = "00:" . $p['time_limit'] . ":00";
                        if ($p['data_unit'] == 'GB')
                            $datalimit = $p['data_limit'] . "000000000";
                        else
                            $datalimit = $p['data_limit'] . "000000";
                        $client->sendSync(
                            $addRequest
                                ->setArgument('name', $c['username'])
                                ->setArgument('profile', $p['name_plan'])
                                ->setArgument('password', $c['password'])
                                ->setArgument('limit-uptime', $timelimit)
                                ->setArgument('limit-bytes-total', $datalimit)
                        );
                        //Mikrotik Schedule
                        // $scheduleRequest = new RouterOS\Request('/system/scheduler/add');
                        // $client->sendSync(
                        //     $scheduleRequest
                        //         ->setArgument('name', $c['username'])
                        //         ->setArgument('interval',$p['validity'].'d')
                        //         ->setArgument('on-event', "/ip/hotspot user set [find name=".$c['username']."] dis=yes; /ip/hotspot active remove [find name=".$c['username']."]; /system sche remove [find name=".$c['username']."];")
                        // );

                    }
                } else {
                    $client->sendSync(
                        $addRequest
                            ->setArgument('name', $c['username'])
                            ->setArgument('profile', $p['name_plan'])
                            ->setArgument('password', $c['password'])
                    );
                    //Mikrotik Schedule
                    // $scheduleRequest = new RouterOS\Request('/system/scheduler/add');
                    // $client->sendSync(
                    //     $scheduleRequest
                    //         ->setArgument('name', $c['username'])
                    //         ->setArgument('interval',$p['validity'].'d')
                    //         ->setArgument('on-event', "/ip/hotspot user set [find name=".$c['username']."] dis=yes; /ip/hotspot active remove [find name=".$c['username']."]; /system sche remove [find name=".$c['username']."];")
                    // );

                }

                $d = ORM::for_table('tbl_user_recharges')->create();
                $d->customer_id = $id_customer;
                $d->username = $c['username'];
                $d->plan_id = $plan;
                $d->namebp = $p['name_plan'];
                $d->recharged_on = $date_only;
                $d->expiration = $date_exp;
                $d->time = $time;
                $d->status = "on";
                $d->method = $method;
                $d->routers = $server;
                $d->type = "Hotspot";
                $d->save();

                // insert table transactions
                $t = ORM::for_table('tbl_transactions')->create();
                $t->invoice = "INV-" . _raid(5);
                $t->username = $c['username'];
                $t->plan_name = $p['name_plan'];
                $t->price = $p['price'];
                $t->recharged_on = $date_only;
                $t->expiration = $date_exp;
                $t->time = $time;
                $t->method = $method;
                $t->routers = $server;
                $t->type = "Hotspot";
                $t->save();

                // radius insert
                $planname = ORM::for_table('tbl_plans')->where('id', $plan)->find_one();

                $radius = ORM::for_table('radcheck')->create();
                $radius->attribute = "Cleartext-Password";
                $radius->username = $c['username'];
                $radius->value = $c['username'];
                $radius->save();

                $radius = ORM::for_table('radcheck')->create();
                $radius->attribute = "User-Profile";
                $radius->username = $c['username'];
                $radius->value = $planname['name_plan'];
                $radius->save();

                $plan_use = ORM::for_table('tbl_plans')->where('id', $plan)->find_one();
                $radius = ORM::for_table('radcheck')->create();
                $radius->attribute = "Expire-After";
                $radius->username = $c['username'];
                $expire_after = $plan_use['validity'] * 24 * 60 * 60;
                $radius->value = $expire_after;
                $radius->save();

                $data_usage_gb = $plan_use['data_usage_gb'] * 1024 * 1024 * 1024;
                $radius = ORM::for_table('radcheck')->create();
                $radius->username = $c['username'];
                $radius->attribute = "Total-Volume-Limit";
                $radius->value = $data_usage_gb;
                $radius->save();

                if ($plan_use['daily_quota'] != 0) {
                    $daily_quota = $plan_use['daily_quota'] * 1024 * 1024 * 1024;
                    $radius->attribute = "Daily-Quota-Limit";
                    $radius->username = $c['username'];
                    $data_usage_gb = $daily_quota;
                    $radius->value = $data_usage_gb;
                    $radius->save();
                }

                // $MikrotikRateLimit = $data_limit . $data_unit;
                $band = ORM::for_table('tbl_bandwidth')->where('id', $plan_use['id_bw'])->find_one();
                $MikrotikRateLimit = $band['rate_up'] . "M" . "/" . $band['rate_down'] . "M";
                $radius1 = ORM::for_table('radreply')->create();
                $radius1->username = $c['username'];
                $radius1->attribute = "Mikrotik-Rate-Limit";
                $radius1->value = $MikrotikRateLimit;
                $radius1->save();

                if ($w) {
                    $w->credit_balance = $updated_credit_balance;
                    $w->available_balance = $updated_available_balance;
                    $w->save();
                } else {
                    echo "Problem Here Bro at 2";
                }
            }
        }

        //adding data to batch_recharge table to see which batch are recharged where
        $status = 0;
        $recharged_on = date("Y-m-d h:i:s A");
        $tv = ORM::for_table('tbl_voucher')->where('batch', $batch)->count();
        $batch_recharge = ORM::for_table('batch_recharged')->create();
        $batch_recharge->nas = $server;
        $batch_recharge->batch = $batch;
        $batch_recharge->recharged_on = $recharged_on;
        $batch_recharge->total_vouchers = $tv;
        $batch_recharge->save();


        r2(U . 'hotspot/find_pack2', 's', $_L['Created_Successfully']);

        break;


    default:
        echo 'action not defined';
}
