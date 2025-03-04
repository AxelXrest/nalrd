{include file="sections/header.tpl"}

					<div class="row">
						<div class="col-sm-12">
							<div class="panel panel-hovered mb20 panel-default">
								<div class="panel-heading">{$_L['Latest_Expired_Account']}</div>
								<div class="panel-body">
									<div class="md-whiteframe-z1 mb20 text-center" style="padding: 15px">
										<div class="col-md-8">
											<form id="site-search" method="post" action="{$_url}latestExpire/latest_expired/">
											<div class="input-group">
												<div class="input-group-addon">
													<span class="fa fa-search"></span>
												</div>
												<input type="text" name="username" class="form-control" placeholder="{$_L['Search_by_Username']}...">
												<div class="input-group-btn">
													<button class="btn btn-success">{$_L['Search']}</button>
												</div>
											</div>
											</form>
										</div>
										<div class="col-md-4">
											<a href="" class="btn btn-primary btn-block waves-effect"><i class="ion ion-android-"> </i> </a>
										</div>&nbsp;
									</div>

						<table id="datatable" class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>{$_L['Username']}</th>
									<th>{$_L['Plan_Name']}</th>
									<th>{$_L['Type']}</th>
									<th>{$_L['Created_On']}</th>
									<th>{$_L['Expires_On']}</th>
									<th>{$_L['Method']}</th>
									<th>{$_L['Routers']}</th>
									
								</tr>
							</thead>
							<tbody>
							{foreach $d as $ds}
								<tr>
									<td id="expireColor">{$ds['username']}</td>
									<td id="expireColor">{$ds['namebp']}</td>
									<td id="expireColor">{$ds['type']}</td>
									<td id="expireColor">{$ds['recharged_on']} {$ds['time']}</td>
									<td id="expireColor">{$ds['expiration']} {$ds['time']}</td>
									<td id="expireColor">{$ds['method']}</td>
									<td id="expireColor">{$ds['routers']}</td>
									
								</tr>
							{/foreach}
							</tbody>
						</table>
						
								</div>
							</div>
						</div>
					</div>


{include file="sections/footer.tpl"}
