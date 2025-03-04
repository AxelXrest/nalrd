<?php

$admin = Admin::_info();
$ui->assign('_admin', $admin);
$action = $routes['1'];
switch ($action) {
    case 'load':

        // $credit_balance = 0;
        $credit_balance = _post('creditBalance');
        $last_loaded_date = date("Y-m-d H:i:s");
        $loaded_by = _post('loadedBy');
        $sellername = _post('pos');
        // $remainingbalance = _post('remainingBalance');
        // $credit_balance = $remainingbalance;

        $d = ORM::for_table('wallet')->where('username', $sellername)->find_one();
        $updated_available_balance = $d['available_balance'] + $credit_balance;
        $updated_credit_balance = $d['credit_balance'] + $credit_balance;


        if ($d) {
            // $d->credit_limit = $total_credit_limit;
            $d->credit_balance = $updated_credit_balance;
            $d->available_balance = $updated_available_balance;
            $d->last_loaded_date = $last_loaded_date;
            $d->loaded_by = $loaded_by;
            $d->save();

            $mycom = ORM::for_table('walletCompany')->find_one();
            $updated_btc = $mycom['balance_to_collect'] + $credit_balance;
            $mycom->balance_to_collect = $updated_btc;
            $mycom->save();

            $log = ORM::for_table('tbl_logs')->create();
            $log->type = "wallet";
            $log->description = $sellername . " was loaded " . $credit_balance . " by " . $loaded_by . " on " . $last_loaded_date;
            $log->username = $sellername;
            $log->save();

            // _log('[' . $admin['username'] . ']: ' . $_L['loaded_successfully'], 'Admin', $admin['id']);
            r2(U . 'adminwallet', 's', $_L['loaded_successfully']);
        } else {
            echo "Problem Here";
        }
        break;

    case 'profiledata':

        $posname = $_POST['posname'];

        $d = ORM::for_table('tbl_customers')
            ->raw_query("
            SELECT 
    t.generated_for, 
    p.name_plan, 
    p.price AS individual_price,
    SUM(p.price * COALESCE(c.matching_codes, 0)) AS total_price, 
    COUNT(DISTINCT c.username) AS matching_codes, 
    w.available_balance 
FROM 
    tbl_customers t 
    LEFT JOIN (
        SELECT 
            username, 
            COUNT(DISTINCT username) AS matching_codes 
        FROM 
            radacct 
        GROUP BY 
            username
    ) c ON t.username = c.username 
    JOIN tbl_plans p ON t.profile = p.name_plan 
    JOIN wallet w ON w.username = t.generated_for 
WHERE 
    t.generated_for = '$posname'
GROUP BY 
    t.generated_for, 
    p.name_plan, 
    w.available_balance, 
    individual_price
ORDER BY 
    matching_codes DESC;

	")
            ->find_many();

        $ui->assign('d', $d);

        $ui->assign('posname', $posname);

        $ui->display('profile-list.tpl');


        break;

        case 'profiledata2':

            $posname = $_POST['posname'];
    
            $d = ORM::for_table('tbl_transactions')
                ->raw_query("
                SELECT tbl_plans.name_plan, tbl_transactions.method, tbl_plans.price AS individual_price, COUNT(DISTINCT tbl_transactions.username) AS num_users, COUNT(DISTINCT tbl_transactions.id) AS matching_codes, tbl_plans.price * COUNT( tbl_transactions.username) AS total_price
                FROM tbl_transactions
                INNER JOIN tbl_plans ON tbl_transactions.plan_name = tbl_plans.name_plan
                WHERE tbl_transactions.type = 'PPPOE' AND tbl_transactions.method='$posname'
                GROUP BY tbl_plans.name_plan, tbl_transactions.method, tbl_plans.price;
                
    
        ")
                ->find_many();
    
            $ui->assign('d', $d);
    
            $ui->assign('posname', $posname);
    
            $ui->display('profile-list.tpl');
    
    
            break;

    case 'register':

        // $credit_balance = 0;
        $received_balance = _post('creditBalance');
        $last_loaded_date = date("Y-m-d H:i:s");
        $collected = _post('collectedBy');
        $sellername = _post('pos');
        $registeredBy = $_SESSION['adname'];

        if ($collected == 'admin') {

            // $remainingbalance = _post('remainingBalance');
            // $credit_balance = $remainingbalance;

            $d = ORM::for_table('wallet')->where('username', $sellername)->find_one();

            $updated_credit_balance1 = $d['credit_balance'] - $received_balance;


            if ($d) {
                $d->credit_balance = $updated_credit_balance1;
                $d->last_collected_by = $collected;
                $d->last_registered_by = $registeredBy;
                $d->save();

                $mycom2 = ORM::for_table('walletCompany')->find_one();
                $updated_ab = $mycom2['account_balance'] + $received_balance;
                $mycom2->account_balance = $updated_ab;
                $mycom2->save();

                $log = ORM::for_table('tbl_logs')->create();
                $log->type = "wallet";
                $log->description = $sellername . " 's credit balance of  " . $received_balance . " was received by " . $collected . " on " . $last_loaded_date . " and was registered by " . $registeredBy;
                $log->username = $sellername;
                $log->save();

                // _log('[' . $admin['username'] . ']: ' . $_L['loaded_successfully'], 'Admin', $admin['id']);
                r2(U . 'adminwallet', 's', $_L['register_successfully']);
            } else {
                echo "Problem Here";
            }
        } else {
            // $remainingbalance = _post('remainingBalance');
            // $credit_balance = $remainingbalance;

            $d2 = ORM::for_table('wallet')->where('username', $sellername)->find_one();

            $salesman = ORM::for_table('wallet')->where('username', $collected)->find_one();

            $updated_credit_balance2 = $d2['credit_balance'] - $received_balance;

            $sales_updated_credit_balance = $salesman['credit_balance'] + $received_balance;


            if ($d2) {
                $d2->credit_balance = $updated_credit_balance2;
                $d2->last_collected_by = $collected;
                $d2->last_registered_by = $registeredBy;
                $d2->save();

                $salesman->credit_balance = $sales_updated_credit_balance;
                $salesman->save();

                $log2 = ORM::for_table('tbl_logs')->create();
                $log2->type = "wallet";
                $log2->description = $sellername . " 's credit balance of  " . $received_balance . " was received by " . $collected . " on " . $last_loaded_date . " and was registered by " . $registeredBy;
                $log2->username = $sellername;
                $log2->save();

                // _log('[' . $admin['username'] . ']: ' . $_L['loaded_successfully'], 'Admin', $admin['id']);
                r2(U . 'adminwallet', 's', $_L['register_successfully']);
            } else {
                echo "Problem Here";
            }

        }
        break;
}

?>