    {include file="sections/header.tpl"}

    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="panel panel-default panel-hovered panel-stacked mb30">
                <div class="panel-heading" style="color:black; ">Allocate Vouchers
                    <div style="height:3px; width:100%; background:#003164; margin-top:5px;"></div>

                    <div class="panel-body">

                        <form class="form-horizontal" method="post" role="form" action="{$_url}allocate/add-post">
                            <div class="form-group">
                                <label class="col-md-2 control-label">Voucher Collector:</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="name" name="vou_collector">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">ID Start At:</label>
                                <div class="col-md-4">
                                    <input type="int" class="form-control" name="id_start">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">ID Start End:</label>
                                <div class="col-md-4">
                                    <input type="int" class="form-control" name="id_end">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <button class="btn waves-effect waves-light" style="background:#003164;color:white"
                                        type="submit">{$_L['Submit']}</button> &nbsp;
                                    <a class="btn waves-effect waves-light"
                                        style="background:#FF0000;text-transform:none;color:white;"
                                        href="{$_url}allocate/register_voucher">Cancel</a>
                                </div>
                            </div>
                        </form>


                        <div style="height:3px; width:100%; background:#003164; margin-top:25px;">

                                <div class="col-md-4" style="margin-top:15px">
                                    <form id="site-search" method="post" action="{$_url}allocate/search">
                                        <div class="input-group">
                                            <div class="input-group-addon" style="background:#003164">
                                                <span class="fa fa-search"></span>
                                            </div>
                                            <input type="text" name="allocator" style="margin-left:0px;" class="form-control"
                                                placeholder="Search Allocator...">
                                            <div class="input-group-btn">
                                                <button class="btn" type="submit" name="myBut" value="searchname"
                                                    style="background:#003164; color:white; ">{$_L['Search']}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>


					    </div>

                        <table class="table table-striped table-bordered" style="margin-top:0px">
                        <thead>
                            <tr>
                                <th> <input type="checkbox"></th>
                                <th>{$_L['SN']}</th>
                                <th>Voucher Collector</th>
                                <th>Total Voucher</th>
                                <th>Used Voucher</th>
                                <th>Unused Voucher</th>
                                <th>Id Start At</th>
                                <th>Id End At</th>
                            </tr>
                        </thead>
                        <tbody>
                            {$no = 1}
                            {foreach $allocated as $ds}
                                <tr>
                                    <td> <input type="checkbox" name="delete_id[]" value="{$ds['id']}"></td>
                                    <td>{$no++}</td>
                                    <td>{$ds['allocation']}</td>
                                    <td>{$ds['count']}</td>
                                    <td>{$ds['matching_users']}</td>
                                    <td>{{$ds['count']}-{$ds['matching_users']}}</td>
                                    <td>{$ds['first_id']}</td>
                                    <td>{$ds['last_id']}</td>
                                </tr>
                            {/foreach}
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

{include file="sections/footer.tpl"}