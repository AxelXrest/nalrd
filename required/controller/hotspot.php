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
    case 'packages':

        $p = ORM::for_table('tbl_plans')->find_many();
        $ui->assign('p', $p);

		$ui->display('packages.tpl');
        break;
    
        case 'find_pack':
            $serv = $_POST['serve'];
            $type = "Hotspot";

            $p = ORM::for_table('tbl_plans')->find_many();
        $ui->assign('p', $p);
            
            $d = ORM::for_table('tbl_plans')->where('routers',$serv)->where('type',$type)->find_many();

    
            $ui->assign('d', $d);

            $ui->display('findpack.tpl');
            break;

    case 'print':
        
        // $plan = $_POST['plan'];
        $plan = $_POST['plan_id'];
        $server = $_POST['server'];
        $price = $_POST['price'];
        $numbervoucher = $_POST['numbervoucher'];
        $batch = $_POST['batch'];
        $type = $_POST['type'];
        $lengthcode = $_POST['lengthcode'];

        $generated_by=$_SESSION['adname'];

        // echo $plan.$routername.$price.$voucherNum;
        // // $ui->display('packages.tpl');

        $msg = '';
        
        if (Validator::UnsignedNumber($numbervoucher) == false) {
            $msg .= 'The Number of Vouchers must be a number' . '<br>';
        }
        if ($msg == '') {
            for ($i = 0; $i < $numbervoucher; $i++) {
                $code = strtoupper(substr(md5(time() . rand(10000, 99999)), 0, $lengthcode)).$batch;

                $d = ORM::for_table('tbl_voucher')->create();
                $d->type = $type;
                $d->routers = $server;
                $d->id_plan = $plan;
                $d->code = $code;
                $d->user = '0';
                $d->status = '0';
                $d->generated_by=$generated_by;
                $d->save();

                $k = ORM::for_table('tbl_customers')->create();
                $k->username = $code;
                $k->password = $code;
                $k->fullname = $code;
                $k->save();

               // $l = ORM::for_table('tbl_customers')->where('username',$code)->find_one();
                $c = ORM::for_table('tbl_customers')->where('username',$code)->find_one();

               // echo $l['username'];
                $id_customer = $c['id'];
                $method = $_SESSION['adname'];

                $date_now = date("Y-m-d H:i:s");
                $date_only = date("Y-m-d");
                $time = date("H:i:s");

                $b = ORM::for_table('tbl_user_recharges')->where('customer_id', $id_customer)->find_one();
                $w = ORM::for_table('wallet')->where('username',$method)->find_one();
                $p = ORM::for_table('tbl_plans')->where('id', $plan)->find_one();

                $mikrotik = Router::_info($server);
            $date_exp = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") + $p['validity'], date("Y")));


                $recharge = $p['price'];
            
            $updated_credit_balance = $w['credit_balance']+$recharge;
            $updated_available_balance = $w['available_balance']-$recharge;

        // practice ends

            //recharge user account

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

                if($w){
                $w->credit_balance=$updated_credit_balance;
                $w->available_balance=$updated_available_balance;
                $w->save();
                }else{
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

                if($w){
                    $w->credit_balance=$updated_credit_balance;
                    $w->available_balance=$updated_available_balance;
                    $w->save();
                    }else{
                        echo "Problem Here Bro at 2";
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

        $myId = ORM::for_table('tbl_voucher')->find_many();
        $myBest = count($myId);
        $numId = $myBest-$numbervoucher;
        

            $from_id = $numId;
            $planid = $plan;
            $pagebreak = 3;
            $limit = 30;


        

        if ($pagebreak < 1) $pagebreak = 6;

        if ($limit < 1) $limit = $pagebreak * 2;

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
        break;
            
		
		default:
        echo 'action not defined';
}



