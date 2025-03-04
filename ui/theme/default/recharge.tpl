{include file="sections/header.tpl"}

<div class="row">
	<div class="col-sm-12 col-md-12">
		<div class="panel panel-default panel-hovered panel-stacked mb30">
			<div class="panel-heading" style="color:black; ">{$_L['Recharge_Account']}
				<div style="height:3px; width:100%; background:#003164; margin-top:10px;"></div>
				<div class="panel-body">
					<form class="form-horizontal" method="post" role="form" action="{$_url}prepaid/recharge-post">
						<div class="form-group">
							<label class="col-md-2 control-label">{$_L['Select_Account']}</label>
							<div class="col-md-6">
								<select id="personSelect" name="id_customer" style="width: 100%"
									data-placeholder="{$_L['Select_Customer']}...">
									<option></option>
									{foreach $c as $cs}
										<option value="{$cs['id']}">{$cs['username']}</option>
									{/foreach}
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">{$_L['Type']}</label>
							<div class="col-md-6">
								<input type="radio" id="Hot" name="type" value="Hotspot"> {$_L['Hotspot_Plans']}
								<input type="radio" id="POE" name="type" value="PPPOE"> {$_L['PPPOE_Plans']}
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">{$_L['Routers']}</label>
							<div class="col-md-6">
								<select id="server" name="server" class="form-control">
									<option value=''>{$_L['Select_Routers']}</option>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label">{$_L['Service_Plan']}</label>
							<div class="col-md-6">
								<select id="plan" name="plan" class="form-control">
									<option value=''>{$_L['Select_Plans']}</option>
								</select>
							</div>
						</div>

						<div class="form-group">
							<div class="col-lg-offset-2 col-lg-10">
								<button class="btn  waves-effect waves-light"
									type="submit" style="background:#008BA1;color:white">{$_L['Recharge']}</button>&nbsp;&nbsp;
								<a class="btn waves-effect waves-light"
									style="background:#FF0000;text-transform:none;color:white;"
									href="{$_url}customers/list">Cancel</a>

							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

{include file="sections/footer.tpl"}