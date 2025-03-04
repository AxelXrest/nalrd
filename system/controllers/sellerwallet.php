
<?php
_admin();
$ui->assign('_title', $_L['Dashboard'].' - '. $config['CompanyName']);
$admin = Admin::_info();
$ui->assign('_admin', $admin);

if($admin['user_type'] != 'Sales' and $admin['user_type'] != 'POS'){
	r2(U."home",'e',$_L['Do_Not_Access']);

}


$id = $_SESSION['adname'];
$ui->assign('id', $id);

// $d = ORM::for_table('wallet')->where('username',$id)->find_one();

$d = ORM::for_table('tbl_customers')
	->raw_query("
	SELECT t.generated_for, SUM(p.price * COALESCE(c.matching_codes, 0)) AS total_price, COUNT(DISTINCT c.username) AS matching_codes, w.available_balance FROM tbl_customers t LEFT JOIN (SELECT username, COUNT(DISTINCT username) AS matching_codes FROM radacct GROUP BY username) c ON t.username = c.username JOIN tbl_plans p ON t.profile = p.name_plan JOIN wallet w ON w.username = '$id' WHERE t.generated_for = '$id' GROUP BY t.generated_for, w.available_balance ORDER BY matching_codes DESC; 	")
	->find_one();
// $d = ORM::for_table('wallet')->find_many();
$ui->assign('d', $d);


$pd = ORM::for_table('tbl_user_recharges')
	->raw_query("
	SELECT tbl_user_recharges.method,SUM(tbl_plans.price) AS total_price FROM tbl_user_recharges INNER JOIN tbl_plans ON tbl_user_recharges.plan_id = tbl_plans.id WHERE tbl_user_recharges.type = 'PPPOE' AND tbl_user_recharges.method = '$id'; 
	")
	->find_one();
// $d = ORM::for_table('wallet')->find_many();
$ui->assign('pd', $pd);

// $ui->assign('d',$d);

$ui->display('sellerwallet.tpl');
