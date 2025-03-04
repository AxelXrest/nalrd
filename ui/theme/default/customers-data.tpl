{include file="sections/header.tpl"}

<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-hovered mb20 panel-default">
			<div class="panel-heading">{$_L['Manage_Accounts']}</div>
			<div class="panel-body">
				<form method="POST" action="{$_url}customers/manage">
					{* <div class="md-whiteframe-z1 mb20 text-center" style="padding: 0px; height:1000px;"> *}

					<div class="col-md-4" style="width:132px">
						<a href="{$_url}customers/add" class="btn btn-primary btn-block waves-effect"
							style="background: #003164; border-radius:5px; "><i class="ion ion-android-add"> </i>
							{$_L['Add_Contacts']}</a>
					</div>
					<div class="col-md-4" style="width:185px">
						<button type="submit" value="edit" name="myBut" class="btn btn-primary btn-block waves-effect"
							style="background: #005E90; border-radius:5px"><i class="ion ion-android-add"> </i>
							{'Change Password'}</button>
					</div>
					<div class="col-md-4" style="width:125px">
						<button type="submit" value="my1" name="myBut" class="btn btn-primary btn-block waves-effect"
							style="background: #FF0000; border-radius:5px"><i class="ion ion-android-add"> </i>
							{$_L['Disable_Contact']}</button>
					</div>
					<div class="col-md-4" style="width:125px">
						<button type="submit" value="my2" name="myBut" class="btn btn-primary btn-block waves-effect"
							style="background: #008BA1; border-radius:5px"><i class="ion ion-android-add"> </i>
							{$_L['Activate_Contacts']}</button>
					</div>
					<div class="col-md-4" style="width:142px">
						<button type="submit" value="my3" name="myBut" class="btn btn-primary btn-block waves-effect"
							style="background: #FF0000; border-radius:5px"><i class="ion ion-android-add"> </i>
							{$_L['Deactivate_Contacts']}</button>
					</div>
					<div class="col-md-4" style="width:135px">
						{* <a href="{$_url}prepaid/recharge-user" class="btn btn-primary btn-block waves-effect"
							style="background: #005E90; border-radius:5px"><i class="ion ion-android-add"> </i>
							{$_L['Recharge_Contacts']}</a> *}
						<button type="submit" value="recharge" name="myBut"
							class="btn btn-primary btn-block waves-effect"
							style="background: #005E90; border-radius:5px"><i class="ion ion-android-add"> </i>
							Recharge</button>
					</div>
					<div class="col-md-4" style="width:155px">
						<button type="submit" value="mac" name="myBut" class="btn btn-primary btn-block waves-effect"
							style="background: #02830d; border-radius:5px"><i class="ion ion-android-add"> </i>
							Change MAC</button>
					</div><br>

					<div style="height:3px; width:100%; background:#003164; margin-top:25px;">

						<div class="col-md-4" style="margin-top:15px">

							<div class="input-group">
								<div class="input-group-addon" style="background:#003164">
									<span class="fa fa-search"></span>
								</div>
								<input type="text" name="username" style="margin-left:0px;" class="form-control"
									placeholder="{$_L['Search_by_Username']}...">
								<div class="input-group-btn">
									<button class="btn" type="submit" name="myBut" value="searchname"
										style="background:#003164; color:white; ">{$_L['Search']}</button>
										<button class="btn" type="submit" name="myBut" value="searchid"
										style="background:#5991cc; color:white; ">Search By ID</button>
								</div>
							</div>
						</div>
					</div>
					<table class="table table-bordered table-striped" style="margin-top:76px">
						<thead>
							<tr>

								<th style="width:10px">{$_L['SN']}</th>
								<th>{$_L['Username']}</th>
								<th>{$_L['Login_date']}</th>
								<th>{$_L['Expire_date']}</th>
								<th>MAC Address</th>
                                <th>NAS IP Address</th>
								<th>{$_L['Uses']}</th>
							</tr>
						</thead>
						<tbody style="padding:0px;font-size:12px;color:#A3A2A2;font-weight:bold">
							{$no = 1}
							{foreach $d as $ds}
								<tr>
									<td><input type="checkbox" name="delete_id[]" value="{$ds['id']}"></td>
									<td>{$ds['username']}</td>
									<td>{$ds['acctstarttime']}</td>
									<td>{$ds['acctstarttime']}</td>	
									<td>{$ds['callingstationid']}</td>
                                    <td>{$ds['nasipaddress']}</td>
									<td>{number_format(($ds['download']/1048576), 2)}/{number_format(($ds['upload']/1048576), 2)}
										MB</td>
								</tr>
							{/foreach}
						</tbody>
					</table>
					{* {$paginator['contents']} *}
				</form>
			</div>

		</div>
	</div>
</div>


{include file="sections/footer.tpl"}