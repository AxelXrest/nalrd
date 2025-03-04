
{include file="sections/header.tpl"}

{if ($_admin['user_type']) eq 'Admin' || ($_admin['user_type']) eq 'Sales' || ($_admin['user_type']) eq 'Regular'}
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
                        <div class="col-md-9 col-sm-7">
							<div class="panel panel-default mb20 mini-box panel-hovered" style="margin-left:260px; border-radius:25px;" >
								<div class="panel-body">
								   <div class="clearfix"> <h3 class="bg-info" style="text-align:center; padding:7px;">Seller Wallet</h3>
										<div class="info left" style="padding:15px;">
											<h5 class="text-light mb0">{$_L['wallet_limit']} : <b> {$d['credit_limit']}</h5>
                                            <h5 class="text-light mb0">{$_L['wallet_credit']} : <b> {$d['credit_balance']}</h5>
											<h5 class="text-light mb0">{$_L['wallet_available']} : <b> {$d['available_balance']}</h5>
										</div>
										<div class="right fa fa-rupee icon"></div>
									</div>
								</div>







								
							<div class="panel-footer clearfix panel-footer-sm panel-footer-info">
									<p class="mt0 mb0 right"><a class="text-putih" href="{$_url}prepaid/list">{$_L['View_All']}</a></p>
						</div>
					</div>
						
						{/if}
{include file="sections/footer.tpl"}