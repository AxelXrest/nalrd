



{include file="sections/header.tpl"}


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
        <div class="panel panel-default mb20 mini-box panel-hovered" style="background:#dd8818;">
            <div class="panel-body">
                <div class="clearfix">
                    <div class="info left">
                        <h5 class="text-bold mb0" style="color:black;">Used Voucher</h5>
                        <h4 class="mt0 text-primary text-bold" style="color:black;">{$pos[0]['matching_codes']}</h4>
                    </div>
                    <div class="right ion ion-locked icon"></div>
                </div>
            </div>
            <div class="panel-footer clearfix panel-footer-sm" style="background:#dd8818;">
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
                        <h5 class="text-bold mb0" style="color:black;">{$_L['total_user']}</h5>
                        <h4 class="mt0 text-primary text-bold" style="color:black;">{$user_no_ppp}</h4>
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
                        <h5 class="text-bold mb0" style="color:black;">Active PPOE</h5>
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

<h1 style="text-align:center;color:#005E90; ">Welcome {$sadmin}.</h1>


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


{include file="sections/footer.tpl"}