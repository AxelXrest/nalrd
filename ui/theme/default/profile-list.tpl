{include file="sections/header.tpl"}

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-hovered mb20 panel-default">
            <div class="panel-heading" style="color:black;font-size:18px;text-align:center">{$posname}{"'s Profile Activity"}</div>
            <div style="height:3px; width:100%; background:#003164; margin-top:25px;"> </div>
            <div class="panel-body">

                <table class="table table-striped table-bordered" style="margin-top: 12px;">
                    <thead>
                        <tr>
                            <th>{$_L['SN']}</th>
                            <th>Profile</th>
                            <th>Total Used</th>
                            <th>Per Price</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
								{$no = 1}
                                {foreach $d as $ds}
									<tr>
										<td>{$no++}</td>
										<td>{$ds['name_plan']}</td>
										<td>{$ds['matching_codes']}</td>
										<td>{$ds['individual_price']}</td>
                                        <td>{$ds['total_price']}</td>
									</tr>
                                {{/foreach}}
							</tbody>
                </table>

            </div>
        </div>
    </div>
    </div>

{include file="sections/footer.tpl"}