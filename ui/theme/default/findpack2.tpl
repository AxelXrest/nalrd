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
	<h4 style="text-align:left; font-weight:bold; "> Batch User Generate</h4>
	<div style="height:3px; width:100%; background:#003164; margin-top:5px;"></div>

	<div class="row">

		<br>


		{foreach $d as $ds}


			<div class="row" style="margin-left:1px; margin-right:1px;">
				<div class="col-md-3 col-sm-6" style="border-radius:5px;font-weight:bold;">
					<div class="panel panel-default mb20 mini-box panel-hovered" style="border:none;border-radius:5px;">
						<form method="POST" action="{$_url}hotspot/print2">
							<div class="panel-body" style="padding:0px;border-radius:5px;font-weight:bold;">
								<div class="clearfix" style="border-radius:5px;">


									{* <input type="text" name="plan"
								style="text-align:center;font-size:24px;color:white; width:100%;height:80px; background-color:#003164; border-radius:5px;"
								value="{$ds['name_plan']}">
								Rs. <input type="text" value=" {$ds['price']}" readonly name="price" style=" background-color:#003164;">
								 *}

									<div class="up"
										style="font-weight:bold;text-align:center;white;background-color:#003164;height:80px;border-top-left-radius:5px;border-top-right-radius:5px;">
										<input type="text" name="plan"
											style="text-align:center;font-size:24px;border:none;color:white; width:100%;height:50px; background-color:#003164;border-top-left-radius:5px;border-top-right-radius:5px; "
											value="{$ds['name_plan']}">
										<input type="hidden" value="{$ds['price']}" name="price">
										<input type="hidden" value="6" name="lengthcode">

										<span style="color:white;text-size:16px;font-weight:bold"> Rs. {$ds['price']} /
											Voucher </span>
									</div>



									<br>
									<div class="info left" style="color:#005E90;display:inline-block">

										<input type="hidden" value="{$ds['id']}" name="plan_id">
										<input type="hidden" value="Hotspot" name="type">
										<input type="hidden" value="6" readonly name="lengthcode">
										<br><span style="width:50px;margin-left:15px"> No of Voucher : <span>
												<input placeholder="" type="integer" name="numbervoucher" class="text-light mb0"
													style="margin-left:10px; border:1px solid #005E90; border-radius:5px;width:110px;float:right">
												<br>

												<br><span style="width:50px; margin-left:15px"> Batch ID :</span> <input
													type="text" name="batch" class="text-light mb0"
													style="margin-left:40px;border:1px solid #005E90;border-radius:5px;width:110px;float:right">
												<br>
												<br>
												<span style="width:50px; margin-left:15px"> POS :</span> <select type="text"
													name="generated_for" class="text-light mb0"
													style="margin-left:40px;border:1px solid #005E90;border-radius:5px;width:110px;float:right">
												{foreach $user as $us}
													<option> {$us['username']} </option>
												{/foreach}
												</select>


									</div>

								</div>
							</div>
							<br>
							<div class="panel-footer clearfix panel-footer-sm "
								style="border-bottom-left-radius:5px;border-bottom-right-radius:5px; background-color:#005E90; ">
								<span class="fa fa-print" style="margin-left:20%;height:5px;color:white;font-size:24px"></span>
								<input type="submit" class="text-putih"
									style=" border:none; color:white;font-size:24px;padding:5px;background:transparent;width:110px;border-bottom-left-radius:5px;border-bottom-right-radius:5px;"
									value="Generate">&nbsp&nbsp&nbsp

							</div>
						</form>
					</div>
				</div>
			

		{/foreach}






	</div>

	<h4 style="text-align:left; font-weight:bold; "> Batch User Recharge</h4>
	<div style="height:3px; width:100%; background:#003164; margin-top:5px;"></div>
	<br>

	<div class="row" style="margin-left:1px; margin-right:1px;">
		<div class="col-md-3 col-sm-6" style="border-radius:5px;font-weight:bold;">
			<div class="panel panel-default mb20 mini-box panel-hovered" style="border:none;border-radius:5px;">
				<form method="POST" action="{$_url}hotspot/batch_process">
					<div class="panel-body" style="padding:0px;border-radius:5px;font-weight:bold;">
						<div class="clearfix" style="border-radius:5px;">

							<div class="up"
								style="font-weight:bold;text-align:center;white;background-color:#003164;height:80px;border-top-left-radius:5px;border-top-right-radius:5px;">
								<input type="text" name="plan"
									style="text-align:center;font-size:24px;border:none;color:white; width:100%;height:50px; background-color:#003164;border-top-left-radius:5px;border-top-right-radius:5px; "
									value="Batch Recharge">

								<span style="color:white;text-size:16px;font-weight:bold">In case of API specific NAS
								</span>
							</div>
							<br>


							<div class="info left" style="color:#005E90;display:inline-block">
								<span style="width:50px; margin-left:15px"> NAS :</span> <select type="text" name="nas"
									class="text-light mb0"
									style="margin-left:40px;border:1px solid #005E90;border-radius:5px;width:110px;float:right">
									{foreach $rout as $rs}
										<option value='{$rs['name']}'>{$rs['name']} </option>

									{/foreach}
								</select>
								<br>

								<br><span style="width:50px; margin-left:15px"> Batch ID :</span> <input type="text"
									name="batch" class="text-light mb0"
									style="margin-left:40px;border:1px solid #005E90;border-radius:5px;width:110px;float:right">
								<br>
								<br>



							</div>




						</div>
					</div>
					<div class="panel-footer clearfix panel-footer-sm "
						style="border-bottom-left-radius:5px;border-bottom-right-radius:5px; background-color:#005E90; ">
						<span class="fa fa-print" style="margin-left:20%;height:5px;color:white;font-size:24px"></span>
						<input type="submit" class="text-putih"
							style=" border:none; color:white;font-size:24px;padding:5px;background:transparent;width:110px;border-bottom-left-radius:5px;border-bottom-right-radius:5px;"
							value="Recharge">&nbsp&nbsp&nbsp

					</div>
				</form>
			</div>
		</div>
	</div>

{/if}

{include file="sections/footer.tpl"}