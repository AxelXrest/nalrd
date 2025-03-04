<?php
session_start();
include('include/config.php');
if(strlen($_SESSION['aid'])==0)
  { 
header('location:index.php');
}
else{

 ?>
<script language="javascript" type="text/javascript">
function f2()
{
window.close();
}ser
function f3()
{
window.print(); 
}
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>User Profile</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="anuj.css" rel="stylesheet" type="text/css">
</head>
<body>

<div style="margin-left:50px;">
 <form name="updateticket" id="updateticket" method="post"> 
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<?php 


if(isset($_GET['use'])){
$ret1=mysqli_query($bd, "select * FROM tbl_users where username='".$_GET['use']."'");
while($row=mysqli_fetch_array($ret1))
{
?>

    
  
		
    <tr>
      <td colspan="2"><b><?php echo $row['fullname'];?>'s profile</b></td>
      
    </tr>
    
    
    <tr>
      <td  >&nbsp;</td>
      <td >&nbsp;</td>
    </tr>
    <tr height="50">
      <td><b>Reg Date:</b></td>
      <td><?php echo htmlentities($row['creationdate']); ?></td>
    </tr>
    <tr height="50">
      <td><b>Username :</b></td>
      <td><?php echo htmlentities($row['username']); ?></td>
    </tr>


      <tr height="50">
      <td><b>Last Login:</b></td>
      <td><?php echo htmlentities($row['last_login']); ?></td>
    </tr>
    


        
    
    <tr>
  
      <td colspan="2">   
      <input name="Submit2" type="submit" class="txtbox4" value="Close this window " onClick="return f2();" style="cursor: pointer;"  /></td>
    </tr>
   
    <?php } 

 
    
}else{
$ret2=mysqli_query($bd, "select * FROM tbl_customers where username='".$_GET['username']."'");
while($row=mysqli_fetch_array($ret2))
{
?>

    
  
		
    <tr>
      <td colspan="2"><b><?php echo $row['fullname'];?>'s profile</b></td>
      
    </tr>
    
    
    <tr>
      <td  >&nbsp;</td>
      <td >&nbsp;</td>
    </tr>
 
    <tr height="50">
      <td><b>username:</b></td>
      <td><?php echo htmlentities($row['username']); ?></td>
    </tr>


      <tr height="50">
      <td><b>User Contact no:</b></td>
      <td><?php echo htmlentities($row['phonenumber']); ?></td>
    </tr>
    


        <tr height="50">
      <td><b>Address:</b></td>
      <td><?php echo htmlentities($row['address']); ?></td>
    </tr>
    
    <tr height="50">
      <td><b>Created At:</b></td>
      <td><?php echo htmlentities($row['created_at']); ?></td>
    </tr>

        <tr height="50">
      <td><b>Last Login:</b></td>
      <td><?php echo htmlentities($row['last_login']); ?></td>
    </tr>

    
    
    <tr>
  
      <td colspan="2">   
      <input name="Submit2" type="submit" class="txtbox4" value="Close this window " onClick="return f2();" style="cursor: pointer;"  /></td>
    </tr>
   
    <?php } 

}
    ?>
 
</table>
 </form>
</div>

</body>
</html>

     <?php } ?>