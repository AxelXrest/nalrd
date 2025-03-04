{include file="sections/header.tpl"}

<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-default panel-hovered panel-stacked mb30">
            <div class="panel-heading">Change User's MAC Address
                <div style="height:3px; width:100%; background:#003164; margin-top:5px;"></div>
                <div class="panel-body">

                    <form class="form-horizontal" method="post" role="form" action="{$_url}customers/edit-mac">
                        <input type="hidden" name="id" value="{$d['id']}">
                        <div class="form-group">
                            <label class="col-md-2 control-label">Username</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="name" name="username"
                                    value="{$d['username']}" style="border-bottom: 1px solid black">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">New MAC Address</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control"  name="new_mac"
                                     style="border-bottom: 1px solid black">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-primary waves-effect waves-light"
                                    type="submit">{$_L['Submit']}</button>
                                <a class="btn waves-effect waves-light"
                                    style="background:#FF0000;text-transform:none;color:white;"
                                    href="{$_url}customers/list">Cancel</a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

{include file="sections/footer.tpl"}