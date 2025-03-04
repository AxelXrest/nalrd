{include file="sections/user-header.tpl"}

					<div class="row">
						<div class="col-md-6">
							<div class="panel panel-default">
							<div class="panel-heading">{$_L['Welcome']}, {$_user['fullname']}</div>
							<div class="panel-body" style="height:296px;max-height:296px;overflow:scroll;">
								<p>{$_L['Welcome_Text_User']}</p>
									<ul>
										<li> {$_L['Account_Information']}</li>
										<li> <a href="{$_url}accounts/change-password">{$_L['Change_Password']}</a></li>
									</ul>
							</div>
							</div>
						</div>
						<div class="col-md-6">
							<br class="visible-xs-inline visible-sm-inline">
							<div class="panel panel-default">
							<div class="panel-heading">Offers</div>
							<div class="panel-body" style="height:296px;max-height:296px;overflow:scroll;">
								No offers at the moment.
							</div>
							</div>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-sm-6">
							<div class="panel panel-default table-condensed">
								<div class="panel-heading">{$_L['Account_Information']}</div>
								<table class="table table-striped table-bordered">
									<tr>
										<td class="small text-success text-uppercase text-normal">{$_L['Username']}</td>
										<td>{$ds['users']}</td>
									</tr>
									<tr>
										<td class="small text-primary text-uppercase text-normal">{$_L['Plan_Name']}</td>
										<td>{$ds['profile']}</td>
									</tr>
									<tr>
										<td class="small text-info text-uppercase text-normal">{$_L['Created_On']}</td>
										<td>{$ds['created']}</td>
									</tr>
									<tr>
										<td class="small text-danger text-uppercase text-normal">Batch ID</td>
										<td>{$ds['batch']}</td>
									</tr>
									<tr>
										<td class="small text-danger text-uppercase text-normal">Data Usage</td>
										<td>{number_format(($ds['download']/1048576), 2)}/{number_format(($ds['upload']/1048576), 2)}
										MB</td>
									</tr>
									<tr>
										<td class="small text-danger text-uppercase text-normal">MAC Address</td>
										<td>{$ds['callingstationid']}</td>
									</tr>
									<tr>
										<td class="small text-danger text-uppercase text-normal">First Login</td>
										<td>{$ds['acctstarttime']}</td>
									</tr>
									<tr>
										<td class="small text-danger text-uppercase text-normal">Expiry Date</td>
									<td>
										{if ($ds['validity_unit'] eq 'h')}
											{assign var="acctstarttime" value=$ds['acctstarttime']}
											{assign var="modified_date" value=$acctstarttime|strtotime}
											{assign var="modified_date" value=$modified_date+$ds['validity']*60*60}
											<!-- add 7 days -->
											{if empty($ds['acctstarttime'])}

											{else}
												{$modified_date|date_format:"%Y-%m-%d %H:%M:%S"}
											{/if}
										{else}
											{assign var="acctstarttime" value=$ds['acctstarttime']}
											{assign var="modified_date" value=$acctstarttime|strtotime}
											{assign var="modified_date" value=$modified_date+$ds['validity']*24*60*60}
											<!-- add 7 days -->
											{if empty($ds['acctstarttime'])}

											{else}
												{$modified_date|date_format:"%Y-%m-%d %H:%M:%S"}
											{/if}
										{/if}
									</td>


									<tr>
									<td>Status</td>
									<td>
										{if ($ds['validity_unit'] eq 'h')}
											{assign var="acctstarttime" value=$ds['acctstarttime']}
											{assign var="modified_date" value=$acctstarttime|strtotime}
											{assign var="modified_date" value=$modified_date+$ds['validity']*60*60}
											{$current_time = time()}
											<!-- add 7 days -->
											{if empty($ds['acctstarttime'])}
												<p style="text-align:center;color:green">Active</p>
											{elseif $modified_date > $current_time}
												<p style="text-align:center;color:orange">Used</p>
											{else}
												<p style="text-align:center;color:red">Expire</p>
											{/if}
										{else}
											{assign var="acctstarttime" value=$ds['acctstarttime']}
											{assign var="modified_date" value=$acctstarttime|strtotime}
											{assign var="modified_date" value=$modified_date+$ds['validity']*24*60*60}
											<!-- add 7 days -->
											{$current_time = time()}
											{if empty($ds['acctstarttime'])}
												<p style="text-align:center;color:green">Active</p>
											{elseif $modified_date > $current_time}
												<p style="text-align:center;color:orange">Used</p>
											{else}
												<p style="text-align:center;color:red">Expire</p>
											{/if}
										{/if}
									</td>
									</tr>

									</tr>
								</table>
							</div>
						</div>
						<div class="col-sm-6">
							<br class="visible-xs-inline visible-sm-inline">
							<div class="panel panel-primary panel-hovered panel-stacked mb30">
								<div class="panel-heading">{$_L['Voucher_Activation']}</div>
								<div class="panel-body">
									<form class="form-horizontal" method="post" role="form" action="#" >
										<div class="form-group">
											<label class="col-md-4 control-label">{$_L['Code_Voucher']}</label>
											<div class="col-md-6">
												<input type="text" class="form-control" id="code" name="code" placeholder="{$_L['Enter_Voucher_Code']}" readonly>
											</div>
										</div>
										
										<div class="form-group">
											<div align="center">
												<button class="btn btn-success waves-effect waves-light" type="submit">{$_L['Recharge']}</button> 
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>

{include file="sections/user-footer.tpl"}
