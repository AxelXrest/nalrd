

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
 <h2 style="text-align:center; font-weight:bold; "> Batch Recharge</h2>
<br>


  <div class="row">
                        

					
<br>
			


			
					<div class="row" style="margin-left:10px; margin-right:1px;" >
						<div class="col-md-3 col-sm-6">
							<div class="panel panel-default mb20 mini-box panel-hovered" style="border-radius:30px;">
								<form method="POST" action="{$_url}hotspot/batch_process">
								<div class="panel-body">
									<div class="clearfix">
									
                                     <input type="text" style="text-align:center;font-size:18px; background-color:#ff6f00; border-radius:30px;" value="{$_L['batch_recharge']}"> <br>
										<br><div class="info left">
										Select A NAS: <br> <select  name="nas" class="form-control" style="width:200px; ">
                                        {foreach $p as $ps}
                                                    <option value='{$ps['name']}'>{$ps['name']} </option>

                                                                {/foreach}
                                                                </select>
                            
                                        <br>	Batch No.  : <input type="text" name="batch" class="text-light mb0"> 
										

										</div>
										
									</div>
								</div>
								<div class="panel-footer clearfix panel-footer-sm " style="border-radius:30px; background-color:#ff6f00; ">
									<input type="submit" class="text-putih" style=" margin-left:55px; color:white;font-size:16px;padding:5px;background:green;width:100px; border-radius:10px;" value="Print">&nbsp&nbsp&nbsp
								</form>
								</div>
							</div>
						</div>
			
						
						
			
                  
                    
						

						
					
{/if}

{include file="sections/footer.tpl"}
