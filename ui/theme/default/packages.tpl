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
	<h4 style="text-align:left; font-weight:bold; "> Voucher Sales</h4>
	<div style="height:3px; width:100%; background:#003164; margin-top:5px;"></div>
	<br>

	<form>
		<input type="radio" onclick="showSelect()"> <b>Specific API NAS</b>

		<div id="routers" style="display:none;margin-top:15px;border-radius:5px">
			<label class=" control-label">{$_L['nas']}</label> &nbsp;

			<select id="selnas" name="routers" onchange="showData()"
				style="color:#BDBDBD;width:25%;height:32px;border:1px solid #BDBDBD; border-radius:5px">
				<option value="0" selected enabled hidden>Select a NAS</option>
				{foreach $r as $rs}	
					<option value="{$rs['name']}">{$rs['name']}</option>
				{/foreach}
			</select>

			{* <label for="selectedDataInput">Selected Data:</label>
			<input type="text" id="selectedDataInput" style="color:black"> *}
		</div>


	</form>

	<div style="height:3px; width:100%; background:#003164; margin-top:15px;"></div>

	<br>
	<div class="row">

		{foreach $voucher as $ds}



			<div class="col-md-3 col-sm-6" style="border-radius:5px;font-weight:bold;">
				<div class="panel panel-default mb20 mini-box panel-hovered" style="border:none;border-radius:5px;">
					<form class="form-vertical" method="POST" action="{$_url}hotspot/print">
						<div class="panel-body" style="padding:0px;border-radius:5px;font-weight:bold;">
							<div class="clearfix" style="border-radius:5px;">


								{* <input type="text" name="plan"
											style="text-align:center;font-size:24px;color:white; width:100%;height:80px; background-color:#003164; border-radius:5px;"
											value="{$ds['name_plan']}">
											Rs. <input type="text" value=" {$ds['price']}" readonly name="price" style=" background-color:#003164;">
											 *}

								<div class="up"
									style="font-weight:bold;text-align:center;white;background-color:#003164;height:80px;border-top-left-radius:5px;border-top-right-radius:5px;">
									<input type="hidden" name="plan_id" value="{$ds['id']}">
									<input type="hidden" name="price" value="{$ds['price']}">
									<input type="text" name="plan"
										style="text-align:center;font-size:24px;border:none;color:white; width:100%;height:50px; background-color:#003164;border-top-left-radius:5px;border-top-right-radius:5px; "
										value="{$ds['name_plan']}">

									<span style="color:white;text-size:16px;font-weight:bold"> Rs. {$ds['price']} /
										Voucher </span>
								</div>



								<br>
								<div class="info left" style="color:#005E90;display:inline-block">

									<input type="hidden" value="{$ds['id']}" name="plan_id">
									<select name="rout" style="display:none">
										<option id="selectedData"></option>
									</select>
									<input type="hidden" value="Hotspot" name="type">
									<input type="hidden" value="6" readonly name="lengthcode">

									<span style="width:50px;margin-left:15px"> No of Voucher : <span>
											<input type="integer" name="numbervoucher" class="text-light mb0"
												style="margin-left:10px; border:1px solid #005E90; border-radius:5px;width:95px;float:right">
											<br>
											<br><span style="width:50px; margin-left:15px"> Batch ID :</span> <input type="text"
												name="batch" class="text-light mb0"
												style="margin-left:40px;border:1px solid #005E90;border-radius:5px;width:95px;float:right">
											<br> <br><span style="width:50px; margin-left:15px"> Generated For :</span>

											<select name="generated_for"
												style="margin-left:40px;color:#005E90;width:95px;height:32px; border:1px solid #005E90;border-radius:5px;float:right">
												{foreach $usr as $ur}
													<option value="{$ur['username']}">{$ur['username']}</option>
												{/foreach}
											</select>


								</div>

							</div>
						</div>
						<br>
						<div class="panel-footer clearfix panel-footer-sm "
							style="border-bottom-left-radius:5px;border-bottom-right-radius:5px; background-color:#005E90; ">
							<span class="fa fa-print" style="margin-left:29%;height:5px;color:white;font-size:24px"></span>
							<input type="submit" class="text-putih"
								style=" border:none; color:white;font-size:24px;padding:5px;background:transparent;width:70px;border-bottom-left-radius:5px;border-bottom-right-radius:5px;"
								value="Print">&nbsp&nbsp&nbsp

						</div>
					</form>
				</div>
			</div>


		{/foreach}
	</div>
	</form>



	<br>



{/if}

{include file="sections/footer.tpl"}

{literal}
	<script>
		// function showSelect() {
		// 	document.getElementById("routers").style.display = "block";
		// }

		function showSelect(id) {
				var e = document.getElementById("routers");
				if (e.style.display == '') e.style.display = 'none';
				else e.style.display = '';
			}

		function showData() {
			var e = document.getElementById("selnas");
			var selectedData = e.options[e.selectedIndex].text;
			document.getElementById("selectedData").innerHTML = selectedData;
		}
	</script>
{/literal}