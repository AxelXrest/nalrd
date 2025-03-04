{include file="sections/header.tpl"}

<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-hovered mb20 panel-default">
			<div class="panel-heading" style="color:black">{$_L['PPPOE_Plans']}</div>
			<div class="panel-body">
				<form method="POST" action="{$_url}services/pppoe-delete">

					<div class="md-whiteframe-z1 mb20 text-center" style="padding: 15px">

						<div class="col-md-4" style="width:182px">
							<a href="{$_url}services/pppoe-add" class="btn btn-primary btn-block waves-effect"
								style="background: #003164; border-radius:5px; "><i class="ion ion-android-add"> </i>
								{$_L['New_Plan']}</a>
						</div>
						<div class="col-md-4" style="width:100px">
							<a href="{$_url}services/pppoe-add" class="btn btn-primary btn-block waves-effect"
								style="background: #005E90; border-radius:5px"><i class="ion ion-android-add"> </i>
								{$_L['Edit_Contacts']}</a>
						</div>
						<div class="col-md-4" style="width:125px">
							<button type="submit" name="myBut" class="btn btn-primary btn-block waves-effect"
								style="background: #FF0000; border-radius:5px"><i class="ion ion-android-add"> </i>
								{$_L['delete_hotspot']}</button>
						</div>
						<br>

						<div style="height:3px; width:100%; background:#003164; margin-top:25px;">

							<div class="col-md-4" style="margin-top:15px">
								<form id="site-search" method="post" action="{$_url}services/pppoe/">
									<div class="input-group">
										<div class="input-group-addon" style="background:#003164">
											<span class="fa fa-search"></span>
										</div>
										<input type="text" name="name" style="margin-left:0px;width:200px"
											class="form-control" placeholder="{$_L['Search']}...">
										<div class="input-group-btn">
											<button class="btn"
												style="background:#003164; color:white; ">{$_L['Search']}</button>
										</div>
									</div>
								</form>

							</div>


						</div>

						<table class="table table-striped table-bordered" style="margin-top:60px">
							<thead>
								<tr>
									<th> <input type="checkbox"></th>
									<th>{$_L['SN']}</th>
									<th>{$_L['Plan_Name']}</th>
									<th>{$_L['Bandwidth_Plans']}</th>
									<th>{$_L['Plan_Price']}</th>
									<th>{$_L['Plan_Validity']}</th>
									<th>{$_L['Pool']}</th>
									<th>{$_L['Routers']}</th>
									<th>{$_L['Manage']}</th>
								</tr>
							</thead>
							<tbody>
								{$no = 1}
								{foreach $d as $ds}
									<tr>
										<td> <input type="checkbox" name="delete_id[]" value="{$ds['id']}"></td>
										<td>{$no++}</td>
										<td>{$ds['name_plan']}</td>
										<td>{$ds['name_bw']}</td>
										<td>{$ds['price']}</td>
										<td>{$ds['validity']} {$ds['validity_unit']}</td>
										<td>{$ds['pool']}</td>
										<td>{$ds['routers']}</td>
										<td>
											<a href="{$_url}services/pppoe-edit/{$ds['id']}"
												class="btn btn-warning btn-sm">{$_L['Edit']}</a>
											<a href="{$_url}services/pppoe-delete/{$ds['id']}" id="{$ds['id']}"
												class="btn btn-danger btn-sm cdelete">{$_L['Delete']}</a>
										</td>
									</tr>
								{/foreach}
							</tbody>
						</table>
						{$paginator['contents']}
					</div>
				</form>
			</div>
		</div>
	</div>

{include file="sections/footer.tpl"}