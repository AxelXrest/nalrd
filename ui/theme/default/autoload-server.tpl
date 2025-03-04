{if $user_type == 'Admin'}
	<option value="">Select Routers</option>
	{foreach $d as $ds}
		<option value="{$ds['name']}">{$ds['name']}</option>
	{/foreach}
	<option value="0">RADIUS</option>
{else}
    <option value="0">RADIUS</option>
{/if}