

<?php
session_start();
include('include/config.php');
if(strlen($_SESSION['aid'])==0)
	{	
header('location:index.php');
}
elseif(isset($_GET['del']))
		  {
		  	mysqli_query($bd, "delete from category where id = '".$_GET['id']."'");
        	$_SESSION['delmsg']="Category deleted !!";
            header('location:category.php?del=delete');
		  }

          ?>