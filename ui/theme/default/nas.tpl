

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
 <h2 style="text-align:center; font-weight:bold; "> NAS Logs</h2>
<br>

<form class="form-vertical" method="POST" action="{$_url}monitornas/logs">
<h4>Select Your NAS:</h4> <select  name="serve" class="form-control" style="width:200px; margin-top:-35px; margin-left:180px;">
{foreach $p as $ps}
			<option value='{$ps['name']}'>{$ps['name']} </option>

						{/foreach}
						</select>
						<input type="submit" value="submit" style=" float:left; margin-top:-35px; background:blue; border-radius:6px; color:white; height:30px; margin-left:390px;">
</form>
<br>
  <div class="row">
                        

					
<br>
			


						
			
                  
                    
						

						
					
{/if}

{include file="sections/footer.tpl"}
