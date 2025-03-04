

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
                        <div class="col-md-6 col-sm-7">
							<div class="panel panel-default mb20 mini-box panel-hovered" style="margin-left:20px; border-radius:20px;" >
								<div class="panel-body">
									<div class="clearfix">
                                    <h3 class="bg-info" style="text-align:center; padding:2px;">Admin Wallet</h3>
										<div class="info left" style="padding:15px;">
											
                                            <h5 class="text-light mb0">{$_L['wallet_credit']}</h5>
											<h5 class="text-light mb0">{$_L['wallet_to_collect']}</h5>
										</div>
										<div class="right fa fa-rupee icon"></div>
									</div>
								</div>
								<div class="panel-footer clearfix panel-footer-sm panel-footer-info">
									<p class="mt0 mb0 right"><a class="text-putih" href="{$_url}prepaid/list">{$_L['View_All']}</a></p>
								</div>
							</div>
						</div>

						<div class="col-md-6 col-sm-7">
							<div class="panel panel-default mb20 mini-box panel-hovered" style="margin-left:30px; border-radius:20px;">
								<div class="panel-body ">
									<div class="clearfix ">
                                    <h3 class="bg-success" style="text-align:center; ">Load Wallet</h3>
										<div class="info left">
											<form method=POST action="{$_url}wallet/load">
                                            
                                           Credit Balance : <input type="integer" name="creditBalance" > <br><br>
                                           Remaining Balance : <input type="integer" name="remainingBalance" > <br><br>
                                            <label> Seller </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <select name="seller"  > 
											{foreach $d as $ds}
                                                <option value="{$ds['id']}" >{$ds['username']}</option>												
                                                 {/foreach}
                                            </select> 
                                            <br>
                                            <input type="submit" class="bg-success" value="Load" style=" color:white; padding:5px; border-radius:10px; width:100px; margin-left:180px;">
                                            
											</form>
										</div>
																				<div class="right fa fa-rupee icon"></div>

									</div>
								</div>
								<div class="panel-footer clearfix panel-footer-sm panel-footer-success">
									<p class="mt0 mb0 right"><a class="text-putih" href="{$_url}prepaid/list">{$_L['View_All']}</a></p>
								</div>
							</div>
						</div>
                    </div>
					
 <h2 style="text-align:center; font-weight:bold; "> Recharger Account </h2>
<br>
			{foreach $d as $ds}
					<div class="row" style="margin-left:1px; margin-right:1px;" >
						<div class="col-md-3 col-sm-6">
							<div class="panel panel-default mb20 mini-box panel-hovered" style="border-radius:30px;">
								<div class="panel-body">
									<div class="clearfix">
                                     <h3 style="text-align:center; background-color:#ff6f00; border-radius:30px;" >{$ds['username']}</h3>
										<div class="info left">
											<h5 class="text-light mb0">{$_L['wallet_limit']}  : <b> {$ds['credit_limit']}</b></h5>
                                            <h5 class="text-light mb0">{$_L['wallet_credit']}  : <b>  {$ds['credit_balance']}</b></h5>
											<h5 class="text-light mb0">{$_L['wallet_available']}  : <b>  {$ds['available_balance']}</b></h5>
										</div>
										<div class="right fa fa-rupee icon"></div>
									</div>
								</div>
								<div class="panel-footer clearfix panel-footer-sm " style="background-color:#ff6f00;">
									<p class="mt0 mb0 right"><a class="text-putih" href="{$_url}reports/by-date">{$_L['View_Reports']}</a></p>
								</div>
							</div>
						</div>
			{/foreach}
						

						
			
                  
                     <div class="row">
                        
                    </div>
						

						
					
{/if}

{include file="sections/footer.tpl"}
