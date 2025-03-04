{include file="sections/header.tpl"}

<div class="row">
	<div class="col-sm-12 col-md-12">
		<div class="panel panel-default panel-hovered panel-stacked mb30">
			<div class="panel-heading">{$_L['Recharge_Account']}</div>
			<div class="panel-body">
				<form class="form-horizontal" method="post" role="form" action="{$_url}prepaid/recharge-post">
					{foreach $c as $cs}
						<input type="hidden" name="id_customer" value="{$cs['id']}">
					{/foreach}
					{* <div class="form-group">
								<label class="col-md-2 control-label">{$_L['Select_Account']}</label>
								<div class="col-md-6">
									<select id="personSelect" name="id_customer" style="width: 100%" data-placeholder="Select a customer...">
									<option></option>

											{if $id eq $cs['id']}
												<option value="{$cs['id']}" selected>{$cs['username']}</option>
											{else}
												<option value="{$cs['id']}">{$cs['username']}</option>
											{/if}

									</select>
								</div>

							</div> *}
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
								<option value=''>Select Routers</option>
								{* <option value='all_router'>RADIUS</option> *}
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-2 control-label">{$_L['Service_Plan']}</label>
						<div class="col-md-6">
							<select name="plan" class="form-control">
								<option value="">Select Plans</option>
								{foreach $p as $ps}
									<option value="{$ps['id']}">{$ps['name_plan']}</option>
								{/foreach}
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-2 control-label">On Behalf Of</label>
						<div class="col-md-6">
							<select name="on_behalf_of" class="form-control">
								<option value="">Select User</option>
								{foreach $tuser as $tu}
									<option value="{$tu['username']}">{$tu['username']}</option>
								{/foreach}
							</select>
						</div>
					</div>

					<div class="form-group">
						<div class="col-lg-offset-2 col-lg-10">
							<button class="btn btn-success waves-effect waves-light"
								type="submit">{$_L['Recharge']}</button>
							Or <a href="{$_url}customers/list">{$_L['Cancel']}</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


{include file="sections/footer.tpl"}