{include file="sections/header.tpl"}

		<div class="row">
			<div class="col-sm-12 col-md-12">
				<div class="panel panel-default panel-hovered panel-stacked mb30">
					<div class="panel-heading">{$_L['Add_Router']}</div>
						<div class="panel-body">
						
                <form class="form-horizontal" method="post" role="form" action="{$_url}batch/add-post" >            
                    <div class="form-group">
						<label class="col-md-2 control-label">Voucher Collector</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="name" name="name">
						</div>
                    </div>
                    <div class="form-group">
						<label class="col-md-2 control-label">ID Start From :</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="ip_address" name="ip_address">
						</div>
                    </div>
                    <div class="form-group">
						<label class="col-md-2 control-label">ID End At :</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="username" name="username">
						</div>
                    </div>
					

					<div class="form-group">
						<div class="col-lg-offset-2 col-lg-10">
							<button class="btn waves-effect waves-light" style="color:white;border-radius:5px;background:#008BA1" type="submit">{$_L['Save']}</button>
							<a class="btn waves-effect waves-light" style="background:#FF0000;text-transform:none;color:white;border-radius:5px" href="{$_url}batch/register_batch">Cancel</a>
						</div>
					</div>
                </form>
				
					</div>
				</div>
			</div>
		</div>

{include file="sections/footer.tpl"}
