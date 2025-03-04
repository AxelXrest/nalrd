
<?php
_admin();
$ui->assign('_title', $_L['Dashboard'].' - '. $config['CompanyName']);
$admin = Admin::_info();
$ui->assign('_admin', $admin);

if($admin['user_type'] != 'Sales'){
	r2(U."home",'e',$_L['Do_Not_Access']);

}


$id = $_SESSION['adname'];


$d = ORM::for_table('wallet')->where('username',$id)->find_one();

$ui->assign('d',$d);

$ui->display('sellerwallet.tpl');
