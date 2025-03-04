<?php

/**
 * PHP Mikrotik Billing (https://ibnux.github.io/phpmixbill/)
 * @copyright	Copyright (C) 2014-2015 PHP Mikrotik Billing
 * @license		GNU General Public License version 2 or later; see LICENSE.txt

 **/
_admin();
$ui->assign('_title', $_L['Recharge_Account'] . ' - ' . $config['CompanyName']);
$ui->assign('_system_menu', 'monitornas');

$action = $routes['1'];
$admin = Admin::_info();
$ui->assign('_admin', $admin);


if ($admin['user_type'] != 'Admin' and $admin['user_type'] != 'Sales' and $admin['user_type'] != 'Regular') {
    r2(U . "dashboard", 'e', $_L['Do_Not_Access']);
}

use PEAR2\Net\RouterOS;
require_once 'system/autoload/PEAR2/Autoload.php';




switch ($action) {

   case 'nas':

            $p = ORM::for_table('tbl_routers')->find_many();
            $ui->assign('p', $p);
    
            $ui->display('nas.tpl');
            break;
        

   case 'logs':

    $serve = $_POST['serve'];
    $nas = Router::_info($serve);
    
    // echo $nas['ip_address'];

    require 'class.mikrotik.php' ;
    $mikrotik = new Mikrotik($nas['ip_address'], $nas['username'], $nas['password']);

    $mikrotik2 = new Mikrotik($nas['ip_address'], $nas['username'], $nas['password']);
    $mikrotik2->write("/ip/hotspot/active/print");
    $totalusers = $mikrotik2->read();

    $mikrotik->write("/log/print");
    $logs = $mikrotik->read();
    $columns = array_keys($logs[1]);


        $p = ORM::for_table('tbl_routers')->find_many();
        $ui->assign('p', $p);
        $ui->display('monitornas.tpl');

        ?>
<h2 style="text-align:center">Total Active Users in <?php echo $serve.' is : <b style="color:green">'. count($totalusers) .'</b>';?></h2>
<table style="margin-left:230px">
        <tr>
            <?php
                foreach ($columns as $column): ?>
                    <td style="width:300px; padding:10px; border:1px solid black;background:gray;color:white"><?php echo strtoupper($column); ?></td>
                <?php endforeach; ?>
        </tr>
        <?php for($i=0;$i<count($logs);$i++): ?>
            <tr>
                <?php  foreach($columns as $column): ?>
                    <td style="background:rgb(160, 151, 151);text-align:center;color:black;border-bottom: 1px solid black"> <?php echo $logs[$i][$column]; ?> </td>
                    <?php endforeach; ?>
                </tr>
            <?php  endfor; ?>
    </table>
            <?php

    break;
        
    default:
        echo 'action not defined';

}
