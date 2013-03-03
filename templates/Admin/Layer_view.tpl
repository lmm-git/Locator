{include file='Admin/Header.tpl' __title='Map layers' img='display.png'}

{pageaddvarblock}
<script type="text/javascript">
	function ConfirmDelete(layerName)
	{
		return confirm("{{gt text='Are you sure you want to delete the map layer'}} \"" + layerName + "\"?");
	}
</script>
{/pageaddvarblock}

<a href="{modurl modname='Locator' type='admin' func='edit' ot='layer'}">Add a layer</a>

<table class="z-datatable">
	<thead>
		<tr>
			<th><a href="{modurl modname='Locator' type='admin' func='view' ot='layer' sort='name' sortdir=$sdir}">{gt text='Name'}</a></th>
			<th><a href="{modurl modname='Locator' type='admin' func='view' ot='layer' sort='mapTypes' sortdir=$sdir}">{gt text='Provider'}</a></th>
			<th><a href="{modurl modname='Locator' type='admin' func='view' ot='layer' sort='url' sortdir=$sdir}">{gt text='Url'}</a></th>
			<th><a href="{modurl modname='Locator' type='admin' func='view' ot='layer' sort='license' sortdir=$sdir}">{gt text='License'}</a></th>
			<th><a href="{modurl modname='Locator' type='admin' func='view' ot='layer' sort='minZoom' sortdir=$sdir}">{gt text='Min Zoom'}</a></th>
			<th><a href="{modurl modname='Locator' type='admin' func='view' ot='layer' sort='maxZoom' sortdir=$sdir}">{gt text='Max Zoom'}</a></th>
			<th><a href="{modurl modname='Locator' type='admin' func='view' ot='layer' sort='opacity' sortdir=$sdir}">{gt text='Opacity'}</a></th>
			<th><a href="{modurl modname='Locator' type='admin' func='view' ot='layer' sort='selectable' sortdir=$sdir}">{gt text='Always on'}</a></th>
			<th><a href="{modurl modname='Locator' type='admin' func='view' ot='layer' sort='active' sortdir=$sdir}">{gt text='Active'}</a></th>
			<th>{gt text='Actions'}</th>
		</tr>
	</thead>
	<tbody>
		{foreach from=$items item='item'}
			<tr>
				<td>{$item.name}</td>
				<td>
					{foreach from=$item.mapTypes item='mapType'}
						{$mapType|getProviderNameFromId}<br />
					{/foreach}
				</td>
				<td>{$item.url}</td>
				<td>{$item.license|safehtml}</td>
				<td>{$item.minZoom}</td>
				<td>{$item.maxZoom}</td>
				<td>{$item.opacity}</td>
				<td>{$item.selectable|invert|bool2pic}</td>
				<td>{$item.active|bool2pic}</td>
				<td>
					<a href="{modurl modname='Locator' type='admin' func='edit' ot='layer' id=$item.id}">{icon type='edit'}</a>
					<a onclick="return ConfirmDelete('{$item.name}')" href="{modurl modname='Locator' type='admin' func='delete' ot='layer' id=$item.id}">{icon type='delete'}</a>
				</td>
			</tr>
		{foreachelse}
			<tr><td colspan="10">{gt text='No layer was found.'}</td></tr>
		{/foreach}
	</tbody>
</table>

{if isset($pager)}
	{pager limit=$pager.itemsperpage rowcount=$pager.numitems}
	<input type="hidden" value="{$currentPage}" />
{/if}

{include file='Admin/Footer.tpl'}
