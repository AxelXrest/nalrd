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
    case 'logs':
        $server = _post('server');
        $mikrotik = Router::_info($server);

        try {
            $client = new RouterOS\Client('172.22.22.1', 'admin', '');
           
            $gethosts = $client->sendSync(new RouterOS\Request('/log/print'));
            $myfinal = $gethosts->read();
            $columns = array_keys($myfinal[1]);

            ?>
            <table>
                <tr>
                    <th>id</th>
                    <th>Time</th>
                    <th>Buffer</th>
                    <th>Topics</th>
                    <th>Message</th>
                </tr>
                <tr>
                    <?php

            foreach ($gethosts as $host): ?>
            
                <td> <?php print_r($host); ?> </td>
                </tr>
            <?php 
            endforeach;

        
            

        } catch (Exception $e) {
            print($e);
            die('Unable to connect to the router.');
        }

            // $log = $client->comm("/log/print");
            break;
        
    default:
        echo 'action not defined';

}