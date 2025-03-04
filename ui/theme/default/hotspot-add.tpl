{include file="sections/header.tpl"}

		<div class="row">
			<div class="col-sm-12 col-md-12">
				<div class="panel panel-default panel-hovered panel-stacked mb30">
					<div class="panel-heading" style="color:black">{$_L['Add_Plan']}
					<div style="height:3px; width:100%; background:#003164; margin-top:5px;"></div>
						<div class="panel-body">

                <form class="form-horizontal" method="post" role="form" action="{$_url}services/add-post" >            
                    <div class="form-group">
						<label class="col-md-2 control-label">{$_L['Plan_Name']}</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="name" name="name">
						</div>
                    </div>
                    <div class="form-group">
						<label class="col-md-2 control-label">{$_L['Plan_Type']}</label>
						<div class="col-md-10">
							<input type="radio" id="Unlimited" name="typebp" value="Unlimited" checked> {$_L['Unlimited']} 
							<input type="radio" id="Limited" name="typebp" value="Limited"> {$_L['Limited']} 
						</div>
                    </div>
					<div style="display:none;" id="Type">
						<div class="form-group">
							<label class="col-md-2 control-label">{$_L['Limit_Type']}</label>
							<div class="col-md-10">
								<input type="radio" id="Time_Limit" name="limit_type" value="Time_Limit" checked> {$_L['Time_Limit']} 
								<input type="radio" id="Data_Limit" name="limit_type" value="Data_Limit"> {$_L['Data_Limit']} 
								<input type="radio" id="Both_Limit" name="limit_type" value="Both_Limit"> {$_L['Both_Limit']} 
							</div>
						</div>
					</div>
					<div style="display:none;" id="TimeLimit">
						<div class="form-group">
							<label class="col-md-2 control-label">{$_L['Time_Limit']}</label>
							<div class="col-md-4">
								<input type="text" class="form-control" id="time_limit" name="time_limit" value="0">
							</div>
							<div class="col-md-2">
								<select class="form-control" id="time_unit" name="time_unit">
									<option value="Hrs">{$_L['Hrs']}</option>
									<option value="Mins">{$_L['Mins']}</option>
								</select>
							</div>
						</div>
					</div>
					<div style="display:none;" id="DataLimit">
						<div class="form-group">
							<label class="col-md-2 control-label">{$_L['Data_Limit']}</label>
							<div class="col-md-4">
								<input type="text" class="form-control" id="data_limit" name="data_limit" value="0">
							</div>
							<div class="col-md-2">
								<select class="form-control" id="data_unit" name="data_unit">
									<option value="MB">MBs</option>
									<option value="GB">GBs</option>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2 control-label">{$_L['BW_Name']}</label>
						<div class="col-md-6">
							<select id="id_bw" name="id_bw" class="form-control">
                                <option value="">{$_L['Select_BW']}...</option>
                                {foreach $d as $ds}
									<option value="{$ds['id']}">{$ds['name_bw']}</option>
                                {/foreach}
                            </select>
						</div>
                    </div>
                    <div class="form-group">
						<label class="col-md-2 control-label">{$_L['Plan_Price']}</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="pricebp" name="pricebp">
						</div>
                    </div>

					<div class="form-group">
						<label class="col-md-2 control-label">Data Usage (GB)</label>
						<div class="col-md-6">
							<input type="int" class="form-control" id="data_usage" name="data_usage">
						</div>
                    </div>

					<div class="form-group">
						<label class="col-md-2 control-label">Daily Quota (GB)</label>
						<div class="col-md-6">
							<input type="int" class="form-control" id="daily_quota" name="daily_quota">
						</div>
                    </div>

					<div class="form-group">
						<label class="col-md-2 control-label">{$_L['Shared_Users']}</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="sharedusers" name="sharedusers" value="1">
						</div>
                    </div>
                    <div class="form-group">
						<label class="col-md-2 control-label">{$_L['Plan_Validity']}</label>
						<div class="col-md-4">
							<input type="text" class="form-control" id="validity" name="validity">
						</div>
						<div class="col-md-2">
							<select class="form-control" id="validity_unit" name="validity_unit">
								<option value="d">{$_L['Days']}</option>
								<option value="h">{$_L['Hour']}</option>
								
							</select>
						</div>
                    </div>
					<div class="form-group">
						<div class="col-md-10">
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;
							<input type="radio" onclick="Javascript: toggle_visibility('hotspec-nas')"> {$_L['nas_type']} 
						</div>
                    </div>
					<div id="hotspec-nas" class="form-group" style="display:none;">
						<label class="col-md-2 control-label">{$_L['Router_Name']}</label>
						<div class="col-md-6">
							<select id="routers" name="routers" class="form-control">
                                {foreach $r as $rs}
									<option value="0" selected enabled hidden>Select a NAS</option>
									<option value="{$rs['name']}">{$rs['name']}</option>
                                {/foreach}
                            </select>
						</div>
                    </div> 
					
					<div class="form-group">
						<div class="col-lg-offset-2 col-lg-10">
							<button class="btn waves-effect waves-light" style="color:white;border-radius:5px;background:#008BA1" type="submit">{$_L['Save']}</button>
							<a class="btn waves-effect waves-light" style="background:#FF0000;text-transform:none;color:white;border-radius:5px" href="{$_url}services/hotspot">Cancel</a>
						</div>
					</div>
                </form>
				
					</div>
				</div>
			</div>
		</div>

{include file="sections/footer.tpl"}
