{include file="sections/header.tpl"}

{if ($_admin['user_type']) eq 'Admin' || ($_admin['user_type']) eq 'Sales' }
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
		<div class="col-md-3 col-sm-6">
			<div class="panel panel-default mb20 mini-box panel-hovered" style="background:#005E90;">
				<div class="panel-body">
					<div class="clearfix">
						<div class="info left">
							<h5 class="text-bold mb0" style="color:black;">{$_L['total_voucher']}</h5>
							<h4 class="mt0 text-primary text-bold" style="color:black;">{$voucher_no}</h4>
						</div>
						<div class="right ion ion-card icon"></div>
					</div>
				</div>
				<div class="panel-footer clearfix panel-footer-sm" style="background:#005E90;">
					<p class="mt0 mb0 right"><a class="text-putih" href="{$_url}reports/by-date">{$_L['View_Reports']}</a>
					</p>
				</div>
			</div>
		</div>

		<div class="col-md-3 col-sm-6">
			<div class="panel panel-default mb20 mini-box panel-hovered" style="background:#008BA1;">
				<div class="panel-body">
					<div class="clearfix">
						<div class="info left">
							<h5 class="text-bold mb0" style="color:black;">Active Hotspot</h5>
							<h4 class="mt0 text-primary text-bold" style="color:black;">{$hotspot_count}</h4>
						</div>
						<div class="right ion ion-unlocked icon"></div>
					</div>
				</div>
				<div class="panel-footer clearfix panel-footer-sm" style="background:#008BA1;">
					<p class="mt0 mb0 right"><a class="text-putih" href="{$_url}reports/by-date">{$_L['View_Reports']}</a>
					</p>
				</div>
			</div>
		</div>

		<div class="col-md-3 col-sm-6">
			<div class="panel panel-default mb20 mini-box panel-hovered" style="background:#FF0000;">
				<div class="panel-body">
					<div class="clearfix">
						<div class="info left">
							<h5 class="text-bold mb0" style="color:black;">{$_L['used_expired_voucher']}</h5>
							<h4 class="mt0 text-primary text-bold" style="color:black;">
							{$in = 0}
							{foreach $pos as $pp}
							{$in = $in + $pp['matching_codes']}
							{{/foreach}}
							{$in}
							</h4>
						</div>
						<div class="right ion ion-locked icon"></div>
					</div>
				</div>
				<div class="panel-footer clearfix panel-footer-sm" style="background:#FF0000;">
					<p class="mt0 mb0 right"><a class="text-putih" href="{$_url}reports/by-date">{$_L['View_Reports']}</a>
					</p>
				</div>
			</div>
		</div>

		<div class="col-md-3 col-sm-6">
			<div class="panel panel-default mb20 mini-box panel-hovered" style="background:#81DC7D;">
				<div class="panel-body">
					<div class="clearfix">
						<div class="info left">
							<h5 class="text-bold mb0" style="color:black; ">{$_L['damage_returned_voucher']}</h5>
							<h4 class="mt0 text-primary text-bold" style="color:black;">0000</h4>
						</div>

					</div>
				</div>
				<div class="panel-footer clearfix panel-footer-sm" style="background:#81DC7D;">
					<p class="mt0 mb0 right"><a class="text-putih" href="{$_url}reports/by-date">{$_L['View_Reports']}</a>
					</p>
				</div>
			</div>
		</div>


		<div style="height:5px; width:100%; background:#003164; margin-top:145px;">
		</div>

		<div class="col-md-3 col-sm-6">
			<div class="panel panel-default mb20 mini-box panel-hovered" style="background:#005E90;">
				<div class="panel-body">
					<div class="clearfix">
						<div class="info left">
							<h5 class="text-bold mb0" style="color:black;">Total PPPOE Users</h5>
							<h4 class="mt0 text-primary text-bold" style="color:black;">{$user_no}</h4>
						</div>
						<div class="right ion ion-ios-people icon"></div>
					</div>
				</div>
				<div class="panel-footer clearfix panel-footer-sm" style="background:#005E90;">
					<p class="mt0 mb0 right"><a class="text-putih" href="{$_url}reports/by-date">{$_L['View_Reports']}</a>
					</p>
				</div>
			</div>
		</div>

		<div class="col-md-3 col-sm-6">
			<div class="panel panel-default mb20 mini-box panel-hovered" style="background:#008BA1;">
				<div class="panel-body">
					<div class="clearfix">
						<div class="info left">
							<h5 class="text-bold mb0" style="color:black;">Active PPPOE </h5>
							<h4 class="mt0 text-primary text-bold" style="color:black;">{$ppp_count}</h4>
						</div>
						<div class="right ion ion-ios-eye icon"></div>
					</div>
				</div>
				<div class="panel-footer clearfix panel-footer-sm" style="background:#008BA1;">
					<p class="mt0 mb0 right"><a class="text-putih" href="{$_url}reports/by-date">{$_L['View_Reports']}</a>
					</p>
				</div>
			</div>
		</div>

		<div class="col-md-3 col-sm-6">
			<div class="panel panel-default mb20 mini-box panel-hovered" style="background:#FF0000;">
				<div class="panel-body">
					<div class="clearfix">
						<div class="info left">
							<h5 class="text-bold mb0" style="color:black;">{$_L['expired_user']}</h5>
							<h4 class="mt0 text-primary text-bold" style="color:black;">0000</h4>
						</div>
						<div class="right ion ion-trash-b icon"></div>
					</div>
				</div>
				<div class="panel-footer clearfix panel-footer-sm" style="background:#FF0000;">
					<p class="mt0 mb0 right"><a class="text-putih" href="{$_url}reports/by-date">{$_L['View_Reports']}</a>
					</p>
				</div>
			</div>
		</div>

		<div class="col-md-3 col-sm-6">
			<div class="panel panel-default mb20 mini-box panel-hovered" style="background:#81DC7D;">
				<div class="panel-body">
					<div class="clearfix">
						<div class="info left">
							<h5 class="text-bold mb0" style="color:black;">{$_L['disabled_user']}</h5>
							<h4 class="mt0 text-primary text-bold" style="color:black;">0000</h4>
						</div>
						<div class="right ion ion-eye-disabled icon"></div>
					</div>
				</div>
				<div class="panel-footer clearfix panel-footer-sm" style="background:#81DC7D;">
					<p class="mt0 mb0 right"><a class="text-putih" href="{$_url}reports/by-date">{$_L['View_Reports']}</a>
					</p>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default mb20 panel-hovered project-stats table-responsive">
				<div class="panel-heading" style="font-size:18px;background: #003164;color:white; text-align:right;">POS
					User &nbsp;&nbsp;</div>
				<div class="panel-body">
					<table class="table">
						<thead>
							<tr>
								<th>Seller</th>
								<th>Voucher</th>
								<th>Used</th>
								<th>Stock</th>
								<th>Damage/Return</th>
							</tr>
						</thead>
						<tbody style="font-weight:bold;color:#A3A2A2">
							{$no = 1}
							{foreach $pos as $ps}
								<tr>
									<td>{$ps['generated_for']}</td>
									<td>{$ps['total_generated_for']}</td>
									<td>{$ps['matching_codes']}</td>
									<td>{{$ps['total_generated_for']}-{$ps['matching_codes']}-{$ps['expired_codes']}}</td>
									<td style="color:red">{$ps['expired_codes']}</td>

								</tr>

							{/foreach}
						</tbody>
					</table>
				</div>
			</div>
			<div class="panel panel-default mb20 panel-hovered project-stats table-responsive">
			</div>
		</div>


		<div class="col-md-12">
			<div class="panel panel-default mb20 panel-hovered project-stats table-responsive">
				<div class="panel-heading" style="font-size:18px; background: #003164;color:white; text-align:right">Voucher Allocation
					Summary &nbsp;&nbsp;</div>
				<div class="panel-body">
					<a href="{$_url}allocate/register_voucher" style="color:black;font-weight:bold;font-size:16px; border:1px solid black; padding:3px">Allocate Voucher</a>
					<br><br>
					<table class="table table-striped table-bordered" style="margin-top:0px">
							<thead>
								<tr>
									<th> <input type="checkbox"></th>
									<th>{$_L['SN']}</th>
									<th>Voucher Collector</th>
									<th>Total Voucher</th>
                                    <th>Used Voucher</th>
                                    <th>Unused Voucher</th>
									<th>Id Start At</th>
									<th>Id End At</th>
								</tr>
							</thead>
							<tbody>
								{$no = 1}
								{foreach $allocated as $ds}
									<tr>
										<td> <input type="checkbox" name="delete_id[]" value="{$ds['id']}"></td>
										<td>{$no++}</td>
										<td>{$ds['allocation']}</td>
										<td>{$ds['count']}</td>
										<td>{$ds['matching_users']}</td>
										<td>{{$ds['count']}-{$ds['matching_users']}}</td>
										<td>{$ds['first_id']}</td>
										<td>{$ds['last_id']}</td>
									</tr>
								{/foreach}
							</tbody>
						</table>
				</div>
			</div>
			<div class="panel panel-default mb20 panel-hovered project-stats table-responsive">
			</div>
		</div>

		{* <div class="col-md-7">
			<div class="panel panel-default mb20 panel-hovered project-stats table-responsive">
				<div class="panel-heading" style="font-size:18px;background: #003164;color:white;  text-align:center">Batch
					Recharged</div>
				<div class="panel-body">
					<table class="table">
						<thead>
							<tr>
								<th>S.No.</th>
								<th>Batch</th>
								<th>NAS</th>
								<th>Recharged On</th>
								<th>Total vouchers</th>
							</tr>
						</thead>
						<tbody style="font-weight:bold;color:#A3A2A2">
							{$no = 1}
							{foreach $batch_recharged as $brec}
								<tr>
									<td>{$no++}</td>
									<td>{$brec['batch']}</td>
									<td>{$brec['nas']}</td>
									<td>{$brec['recharged_on']}</td>
									<td>{$brec['total_vouchers']}</td>

								</tr>
							</tbody>
						{/foreach}

					</table>
				</div>
			</div>
			<div class="panel panel-default mb20 panel-hovered project-stats table-responsive">
			</div>
		</div> *}

		<div class="col-md-5">
			<div class="panel panel-default panel-hovered mb20 activities">
				<div class="panel-heading">{$_L['Activity_Log']}</div>
				<div class="panel-body">
					<ul class="list-unstyled">
						{foreach $dlog as $dlogs}
							<li class="primary">
								<span class="point"></span>
								<span class="time small text-muted">{time_elapsed_string($dlogs['date'],true)}</span>
								<p>{$dlogs['description']}</p>
							</li>
						{/foreach}
					</ul>
				</div>
			</div>
			{* 	 <div class="panel panel-default panel-hovered mb20 activities">
								<div class="panel-heading">Nepal Airlink</div>
								<div class="panel-body">
									{$_L['Welcome_Text_Admin']}
								</div>
							</div> *}
		</div>

	</div>
{/if}



{include file="sections/footer.tpl"}