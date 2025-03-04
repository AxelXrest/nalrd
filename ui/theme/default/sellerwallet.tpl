{include file="sections/header.tpl"}

{if ($_admin['user_type']) eq 'Admin' || ($_admin['user_type']) eq 'Sales' || ($_admin['user_type']) eq 'Regular' || ($_admin['user_type']) eq 'POS'}
	<div class="row hidden">
		<div class="col-md-12">
			<div class="dash-head clearfix mt15 mb20">
				<div class="left">
					<h4 class="mb5 text-light">Dashboard</h4>
					<p class="small"></p>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		{* <div class="col-md-9 col-sm-7">
			<div class="panel panel-default mb20 mini-box panel-hovered" style="margin-left:260px; border-radius:25px;">
				<div class="panel-body">
					<div class="clearfix">
						<h3 class="bg-info" style="text-align:center; padding:7px;">Seller Wallet</h3>
						<div class="info left" style="padding:15px;">
							<h5 class="text-light mb0">{$_L['wallet_limit']} : <b> {$d['credit_limit']}</h5>
							<h5 class="text-light mb0">{$_L['wallet_credit']} : <b> {$d['credit_balance']}</h5>
							<h5 class="text-light mb0">{$_L['wallet_available']} : <b> {$d['available_balance']}</h5>
						</div>
						<div class="right fa fa-rupee icon"></div>
					</div>
				</div>

				<div class="panel-footer clearfix panel-footer-sm panel-footer-info">
					<p class="mt0 mb0 right"><a class="text-putih" href="{$_url}prepaid/list">{$_L['View_All']}</a></p>
				</div>
			</div>
		</div> *}

		<h4 style="text-align:left; font-weight:bold; "> POS Hotspot Status</h4>
		<div style="height:3px; width:100%; background:#003164; margin-top:5px;"></div>
		<br>
		<div class="row">
			<div class="col-md-4 col-sm-7" style="">
				<div class="panel panel-default mb20 mini-box panel-hovered"
					style="margin-left:20px; border-radius:5px;border:none">
					{* <form method="POST" action="{$_url}hotspot/batch_process"> *}
					<div class="panel-body"
						style="border-radius:5px;background: radial-gradient(52.67% 265.79% at 102.67% 100%, #00B696 99.99%, #81DC7D 100%);height:150px">

						<div class="form-group" style="width:100%">
							<label
								style="color:white;font-weight:700;font-size:20px;text-align:center;width:100%">{$d['generated_for']}{"'s wallet"}
							</label>
						</div>

						<div class="form-group" style="width:100%">
							<label style="color:white;font-weight:700;font-size:16px;margin-left:5px">Credit
								Balance</label>
							<label style="color:white;font-weight:700;font-size:16px;float:right">{$d['total_price']}
							</label>
						</div>

						<div class="form-group" style="width:100%">
							<label style="color:white;font-weight:700;font-size:16px;margin-left:5px">Available
								Balance</label>
							<label
								style="color:white;font-weight:700;font-size:16px;float:right">{$d['available_balance']}</label>
						</div>

					</div>

					{* </form> *}
				</div>
			</div>

		</div>

		<h4 style="text-align:left; font-weight:bold; margin-top:20px "> POS PPPOE Status</h4>
		<div style="height:3px; width:100%; background:#003164; margin-top:5px;"></div>
		<br>
		<div class="row">
			<div class="col-md-4 col-sm-7" style="">
				<div class="panel panel-default mb20 mini-box panel-hovered"
					style="margin-left:20px; border-radius:5px;border:none">
					{* <form method="POST" action="{$_url}hotspot/batch_process"> *}
					<div class="panel-body"
						style="border-radius:5px;background: radial-gradient(52.67% 265.79% at 102.67% 100%, #00B696 99.99%, #81DC7D 100%);height:150px">

						<div class="form-group" style="width:100%">
							<label
								style="color:white;font-weight:700;font-size:20px;text-align:center;width:100%">{$id}
							</label>
						</div>

						<div class="form-group" style="width:100%">
							<label style="color:white;font-weight:700;font-size:16px;margin-left:5px">Credit
								Balance</label>
							<label style="color:white;font-weight:700;font-size:16px;float:right">{$pd['total_price']}
							</label>
						</div>


					</div>

					{* </form> *}
				</div>
			</div>
		</div>
	{/if}
{include file="sections/footer.tpl"}