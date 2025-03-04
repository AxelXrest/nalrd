

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
 <h2 style="text-align:center; font-weight:bold; "> Hotspot_Packages</h2>
<br>

<form class="form-vertical" method="POST" action="{$_url}hotspot/find_pack">
<h4>Select Your NAS:</h4> <select  name="serve" class="form-control" style="width:200px; margin-top:-35px; margin-left:180px;">
{foreach $p as $ps}
			<option value='{$ps['routers']}'>{$ps['routers']} </option>

						{/foreach}
						</select>
						<input type="submit" value="submit" style=" float:left; margin-top:-35px; background:blue; border-radius:6px; color:white; height:30px; margin-left:390px;">
</form>
<br>
  <div class="row">
                        

					
<br>
			

{foreach $d as $ds}

			
					<div class="row" style="margin-left:1px; margin-right:1px;" >
						<div class="col-md-3 col-sm-6">
							<div class="panel panel-default mb20 mini-box panel-hovered" style="border-radius:30px;">
								<form method="POST" action="{$_url}hotspot/print">
								<div class="panel-body">
									<div class="clearfix">
									
                                     <input type="text" name="plan" style="text-align:center;font-size:18px; background-color:#ff6f00; border-radius:30px;" value="{$ds['name_plan']}">
										<div class="info left">
											<h5 class="text-light mb0">NAS : </h5><b><input type="text" value="{$ds['routers']}" readonly name="server"> </b>
                                            <h5 class="text-light mb0">Price  : </h5><b> <input type="text" value="{$ds['price']}" readonly name="price"></b>
											<input type="hidden" value="{$ds['id']}" name="plan_id">
											<input type="hidden" value="Hotspot"  name="type">
											<input type="hidden" value="6" readonly name="lengthcode">
										<br>	No of Voucher  : <input type="number" name="numbervoucher" class="text-light mb0"> 
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
			
						
{/foreach}
						
			
                  
                    
						

						
					
{/if}

{include file="sections/footer.tpl"}
