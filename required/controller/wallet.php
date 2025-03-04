
<?php

$admin = Admin::_info();
$ui->assign('_admin', $admin);
$action = $routes['1'];
switch ($action) {
    case 'load':
		
        // $credit_balance = 0;
        $credit_limit =  _post('creditBalance');
        $last_loaded_date= date("Y-m-d H:i:s");
        $loaded_by = $_SESSION['adname'];
        $sellerID = _post('seller');
        $remainingbalance = _post('remainingBalance');
        $credit_balance = $remainingbalance;
       
        
   
    $d = ORM::for_table('wallet')->find_one($sellerID);
       $total_credit_limit = $d['available_balance']+$credit_limit;
       $available_balance = $total_credit_limit - $remainingbalance;

       

    if($d){
        $d->credit_limit = $total_credit_limit;
        $d->credit_balance = $credit_balance;
        $d->available_balance = $available_balance;
        $d->last_loaded_date = $last_loaded_date;
        $d->loaded_by = $loaded_by;

        $d->save();

			
        _log('['.$admin['username'].']: '.$_L['loaded_successfully'],'Admin',$admin['id']);
        r2(U . 'adminwallet', 's', $_L['loaded_successfully']);
    }else{
        echo "Problem Here";
    }
    break;
}

    ?>