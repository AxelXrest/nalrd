<?php
session_start();
include("includes/config.php");
$_SESSION['uid']=="";
date_default_timezone_set('Asia/Kolkata');
$ldate=date( 'd-m-Y h:i:s A', time () );
mysqli_query($bd, "UPDATE userlog  SET logout = '$ldate' WHERE id = '".$_SESSION['uid']."' ORDER BY id DESC LIMIT 1");
session_unset();

?>
<script language="javascript">
document.location="../index.html";
</script>
