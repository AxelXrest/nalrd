<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>{$_title} - {$_L['Login']}</title>
	<link rel="shortcut icon" href="{$_theme}/images/logo.png" type="image/x-icon" />
	
	<!-- Icons -->
	<link rel="stylesheet" href="{$_theme}/fonts/ionicons/css/ionicons.min.css">
	<link rel="stylesheet" href="{$_theme}/fonts/font-awesome/css/font-awesome.min.css">

	<!-- Plugins -->
	<link rel="stylesheet" href="{$_theme}/styles/plugins/waves.css">
	<link rel="stylesheet" href="{$_theme}/styles/plugins/perfect-scrollbar.css">
	
	<!-- Css/Less Stylesheets -->
	<link rel="stylesheet" href="{$_theme}/styles/bootstrap.min.css">
	<link rel="stylesheet" href="{$_theme}/styles/main.min.css">

 	<!-- <link href='http://fonts.googleapis.com/css?family=Roboto:400,500,700,300' rel='stylesheet' type='text/css'> -->
	<!-- Match Media polyfill for IE9 -->
	<!--[if IE 9]> <script src="{$_theme}/scripts/ie/matchMedia.js"></script>  <![endif]--> 

</head>
<body id="app" class="app off-canvas body-full">
	<div class="main-container clearfix" style="background-image: url('adminlogin.png');background-size: 100% 100%;background-repeat:no-repeat;width:100%;height:100%">
		<div class="content-container" id="content">
			<div class="page page-auth">
			<div class="form-head mb20" style="margin-left:58%;margin-top:6%">
						
					</div>
				<div class="auth-container" style="max-width: 350px;  margin: 50px 0;  float:right;margin-right:8%;background:#7095FF;border-radius: 10px;">
					
				{if isset($notify)}
					{$notify}
				{/if}
				<h1 class="site-logo h2 mb5 mt5 text-center text-bold" ><b style="color:#005ACC;font-size:38px">Nepal</b><b style="color:#6DFACD;font-size:38px"> Airlink</b></h1>
						{* <h5 class="text-normal h5 text-center">{$_L['Sign_In_Admin']}</h5> *}
					<div  style="color:white">
						<form class="form-horizontal" action="{$_url}admin/post" method="post">
							{* <div class="md-input-container md-float-label"> *}
							<br>
								<input type="text" name="username" class="md-input" placeholder="Username" style="font-size:16px;font-weight:bold;color:white;height:35px;border:1px solid white;border-radius:5px;background:transparent"> <br><br>
								{* <label>{$_L['Username']}</label> *}
							{* </div> *}

							{* <div class="md-input-container md-float-label" > *}
								<input type="password" name="password" placeholder="Password" class="md-input" style="font-size:16px;font-weight:bold;color:white;height:35px;border:1px solid white;border-radius:5px;background:transparent"><br><br>
								{* <label>{$_L['Password']}</label> *}
							{* </div> *}

							<div class="clearfix">
								<div class="ui-checkbox ui-checkbox-primary left">
									<label>
										<input type="checkbox"> 
										<span><b>Remember me</b></span>
									</label>
								</div>
							</div>
							<div class="btn-group btn-group-justified mb15">
								<div class="btn-group">
									<button type="submit" class="btn" style="background:#4777EE;width:100%;font-size:16px;border-radius:5px"><b>Sign In</b></button>
								</div>
							</div> 
						</form>
					</div>

				</div>
			</div>
		</div> 
	</div>
	<script src="scripts/vendors.js"></script>
</body>
</html>