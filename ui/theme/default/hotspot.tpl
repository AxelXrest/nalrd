{include file="sections/header.tpl"}

<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-hovered mb20 panel-default">
			<div class="panel-heading" style="color:black">{$_L['Hotspot_Plans']}</div>
			<div class="panel-body">
				<form method="POST" action="{$_url}hotspot/delete">
					<div class="md-whiteframe-z1 mb20 text-center" style="height:180px;padding:15px">
						<div class="col-md-4" style="width:182px">
							<a href="{$_url}services/add" class="btn btn-primary btn-block waves-effect"
								style="background: #003164; border-radius:5px; "><i class="ion ion-android-add"> </i>
								{$_L['add_hotspot']}</a>
						</div>
						<div class="col-md-4" style="width:100px">
							<a href="{$_url}customers/add" class="btn btn-primary btn-block waves-effect"
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
								<form id="site-search" method="post" action="{$_url}services/hotspot/">
									<div class="input-group">
										<div class="input-group-addon" style="background:#003164">
											<span class="fa fa-search"></span>
										</div>
										<input type="text" name="name" style="margin-left:0px;width:200px"
											class="form-control" placeholder="{$_L['Search_by_Username']}...">
										<div class="input-group-btn">
											<button class="btn"
												style="background:#003164; color:white; ">{$_L['Search_by_Name']}</button>
										</div>
									</div>
								</form>

							</div>








						</div>

						<table class="table table-striped table-bordered" style="margin-top:62px" ;>
							<thead>
								<tr>
									<th> <input type="checkbox"></th>
									<th>{$_L['SN']}</th>
									<th>{$_L['Plan_Name']}</th>
									<th>{$_L['Plan_Type']}</th>
									<th>{$_L['Bandwidth_Plans']}</th>
									<th>{$_L['Data_Limit']}</th>
									<th>{$_L['Plan_Validity']}</th>
									<th>{$_L['Plan_Price']}</th>
									<th>{$_L['Time_Limit']}</th>
									<th>{$_L['api_nas']}</th>

								</tr>
							</thead>
							<tbody>
								{$no = 1}
								{foreach $d as $ds}
									<tr>
										<td> <input type="checkbox" name="delete_id[]" value="{$ds['id']}"></td>
										<td>{$no++}</td>
										<td>{$ds['name_plan']}</td>
										<td>{$ds['typebp']}</td>
										<td>{$ds['name_bw']}</td>
										<td>{$ds['data_limit']} {$ds['data_unit']}</td>
										<td>{$ds['validity']} {$ds['validity_unit']}</td>
										<td>{$ds['price']}</td>
										<td>{$ds['time_limit']} {$ds['time_unit']}</td>
										<td>{$ds['routers']}</td>

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