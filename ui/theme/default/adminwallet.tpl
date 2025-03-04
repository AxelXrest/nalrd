{include file="sections/header.tpl"}

{if ($_admin['user_type']) eq 'Admin' || ($_admin['user_type']) eq 'Sales' || ($_admin['user_type']) eq 'Regular'}
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

	<h4 style="text-align:left; font-weight:bold; margin-top:20px "> Company Admin Wallet</h4>
	<div style="height:3px; width:100%; background:#003164; margin-top:5px;"></div>

	<div class="row" style="margin-top:15px">

		<div class="col-md-4 col-sm-7" style="">
			<div class="panel panel-default mb20 mini-box panel-hovered"
				style="margin-left:20px; border-radius:5px;border:none">
				<form method="POST" action="{$_url}hotspot/batch_process">
					<div class="panel-body"
						style="border-radius:5px;background:conic-gradient(from 180deg at 50% 50%, #005E90 -169.9deg, #003164 184.48deg, rgba(0, 49, 100, 0) 189.95deg, #005E90 190.1deg, #003164 544.48deg);height:200px">





						<label style="color:white;font-weight:700;font-size:17px;margin-left:-15px">1111 **** **** 2222
						</label>
						<label style="color:white;font-weight:700;font-size:18px;margin-left:20%">Active</label>
						<br>
						<label style="color:white;font-weight:700;font-size:15px;margin-left:-15px">Bank Account
							Number</label>
						<label style="color:white;font-weight:700;font-size:15px;margin-left:22%">Status</label>
						<br><br><br>
						<label style="color:white;font-weight:700;font-size:18px;margin-left:-15px">Rs.
							{$comp['account_balance']} </label>
						<label style="color:white;font-weight:700;font-size:18px;margin-left:20%">Rs.
							{$comp['balance_to_collect']} </label>
						<br>
						<label style="color:white;font-weight:700;font-size:15px;margin-left:-15px">Account Balance</label>
						<label style="color:white;font-weight:700;font-size:15px;margin-left:22%">Credit Balance</label>


					</div>

				</form>
			</div>
		</div>

		{* load wallet *}

		<div class="col-md-4 col-sm-7">
			<div class="panel panel-default mb20 mini-box panel-hovered"
				style="margin-left:20px; border-radius:5px;border:none">

				<form method="POST" action="{$_url}wallet/load">
					<div class="panel-body"
						style="height:200px;padding:0px;border-radius:5px;font-weight:bold;background: conic-gradient(from 180deg at 50% 50%, #005E90 0deg, #9747FF 0.04deg, #005E90 266.25deg, #005E90 358.13deg, #005E90 360deg);">


						<label style="margin-left:33%;color:white;font-size:24px"> Load Wallet </label>
						<br>


						<div class="form-group" style="width:100%">
							<span style="color:white; margin-left:15px;float:right;margin-right:45px"> Load Balance
								&nbsp;&nbsp;<input type="integer" name="creditBalance"
									style="width:165px;height:30px;border-radius:5px;color:black">
							</span>
						</div>
						<br>
						<div class="form-group" style="width:100%">
							<span style=" color:white;margin-left:15px;float:right;margin-right:45px "> POS User
								&nbsp;&nbsp; <select type="text" name="pos"
									style="width:165px;height:30px;border-radius:5px;color:black">

									{foreach $pos as $prs}
										<option value='{$prs['username']}'>{$prs['username']} </option>

									{/foreach}
								</select>
							</span>
						</div>
						<br>
						<div class="form-group" style="width:100%">
							<span style="color:white;margin-left:15px;float:right;margin-right:45px"> Loaded By
								&nbsp;&nbsp; <select type="text" name="loadedBy"
									style="width:165px;height:30px;border-radius:5px;color:black">

									{foreach $ad as $rs}
										<option value='{$rs['username']}'>{$rs['username']} </option>

									{/foreach}
								</select>
							</span>
						</div>

						<input type="submit" value="LOAD"
							style="margin-left:40%;margin-top:15px;width:85px;background:conic-gradient(from 180deg at 50% 50%, #005E90 0deg, #9747FF 0.04deg, #013d5e 266.25deg, #053a57 358.13deg, #22698f 360deg);color:white;border:1px solid white;border-radius:5px ">

						<br><br>

					</div>

				</form>
			</div>
		</div>


		<div class="col-md-4 col-sm-7">
			<div class="panel panel-default mb20 mini-box panel-hovered"
				style="margin-left:20px; border-radius:5px;border:none">

				<form method="POST" action="{$_url}wallet/register">
					<div class="panel-body"
						style="height:200px;padding:0px;border-radius:5px;font-weight:bold;background: linear-gradient(180deg, #00B696 8.91%, #005E90 18.35%);">


						<label style="margin-left:20%;color:white;font-size:24px"> Payment Collection </label>
						<br>


						<div class="form-group" style="width:100%">
							<span style="color:white; margin-left:15px;float:right;margin-right:30px"> Balance Received
								&nbsp;&nbsp;<input type="integer" name="creditBalance"
									style="width:160px;height:30px;border-radius:5px;color:black">
							</span>
						</div>
						<br>
						<div class="form-group" style="width:100%">
							<span style=" color:white;margin-left:15px;float:right;margin-right:30px "> POS User
								&nbsp;&nbsp; <select type="text" name="pos"
									style="width:160px;height:30px;border-radius:5px;color:black">

									{foreach $pos as $prs}
										<option value='{$prs['username']}'>{$prs['username']} </option>

									{/foreach}
								</select>
							</span>
						</div>
						<br>
						<div class="form-group" style="width:100%">
							<span style="color:white;margin-left:15px;float:right;margin-right:30px"> Collected By
								&nbsp;&nbsp; <select type="text" name="collectedBy"
									style="width:160px;height:30px;border-radius:5px;color:black">

									{foreach $pos as $drs}
										<option value='{$drs['username']}'>{$drs['username']} </option>

									{/foreach}
								</select>
							</span>
						</div>

						<input type="submit" value="REGISTER"
							style="margin-left:45%;margin-top:15px;width:85px;background:linear-gradient(180deg, #00B696 8.91%, #005E90 18.35%);color:white;border:1px solid white;border-radius:5px ">

						<br><br>

					</div>

				</form>
			</div>
		</div>
	</div>





	<h4 style="text-align:left; font-weight:bold; margin-top:20px "> POS Hotspot Status</h4>
	<div style="height:3px; width:100%; background:#003164; margin-top:5px;"></div>
	<br>

	<div class="row">






		{foreach $d as $ds}



			<div class="col-md-4 col-sm-7" style="">
				<div class="panel panel-default mb20 mini-box panel-hovered"
					style="margin-left:20px; border-radius:5px;border:none">
					{* <form method="POST" action="{$_url}hotspot/batch_process"> *}
					<div class="panel-body"
						style="border-radius:5px;background: radial-gradient(52.67% 265.79% at 102.67% 100%, #00B696 99.99%, #81DC7D 100%);height:150px">

						<div class="form-group" style="width:100%">
						<form method="POST"  action="{$_url}wallet/profiledata">
						<input  type="hidden" value="{$ds['generated_for']}" name="posname">
							<input type="submit"
								style="background:transparent;border:none;color:white;font-weight:700;font-size:20px;text-align:center;width:100%" value="{$ds['generated_for']}" readonly >
						</form>
						</div>

						<div class="form-group" style="width:100%">
							<label style="color:white;font-weight:700;font-size:16px;margin-left:5px">Credit
								Balance</label>
							<label style="color:white;font-weight:700;font-size:16px;float:right">{$ds['total_price']}
							</label>
						</div>

						<div class="form-group" style="width:100%">
							<label style="color:white;font-weight:700;font-size:16px;margin-left:5px">Available
								Balance</label>
							<label
								style="color:white;font-weight:700;font-size:16px;float:right">{$ds['available_balance']}</label>
						</div>

					</div>

					{* </form> *}
				</div>
			</div>


		{/foreach}
	</div>

	<h4 style="text-align:left; font-weight:bold; margin-top:20px "> POS PPPOE Status</h4>
	<div style="height:3px; width:100%; background:#003164; margin-top:5px;"></div>
	<br>
	<div class="row">






		{foreach $pd as $pds}



			<div class="col-md-4 col-sm-7" style="">
				<div class="panel panel-default mb20 mini-box panel-hovered"
					style="margin-left:20px; border-radius:5px;border:none">
					{* <form method="POST" action="{$_url}hotspot/batch_process"> *}
					<div class="panel-body"
						style="border-radius:5px;background: radial-gradient(52.67% 265.79% at 102.67% 100%, #00B696 99.99%, #81DC7D 100%);height:150px">

						<div class="form-group" style="width:100%">
						<form method="POST"  action="{$_url}wallet/profiledata2">
						<input  type="hidden" value="{$pds['method']}" name="posname">
							<input type="submit"
								style="background:transparent;border:none;color:white;font-weight:700;font-size:20px;text-align:center;width:100%" value="{$pds['method']}" readonly >
						</form>
						</div>

						<div class="form-group" style="width:100%">
							<label style="color:white;font-weight:700;font-size:16px;margin-left:5px">Credit
								Balance</label>
							<label style="color:white;font-weight:700;font-size:16px;float:right">{$pds['total_price']}
							</label>
						</div>


					</div>

					{* </form> *}
				</div>
			</div>


		{/foreach}
	</div>



{/if}

{include file="sections/footer.tpl"}