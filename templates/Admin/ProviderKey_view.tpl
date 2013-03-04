{include file='Admin/Header.tpl' __title='Provider keys' img='display.png'}

{pageaddvarblock}
<script type="text/javascript">
	function ConfirmDelete(mapType)
	{
		return confirm("{{gt text='Are you sure you want to delete your key for'}} \"" + mapType + "\"?");
	}
</script>
{/pageaddvarblock}

{checkpermissionblock component='Locator:ProviderKey:' instance='::' level=ACCESS_ADD}
	<a href="{modurl modname='Locator' type='admin' func='edit' ot='providerKey'}">Add a provider key</a>
{/checkpermissionblock}

<table class="z-datatable">
	<thead>
		<tr>
			<th><a href="{modurl modname='Locator' type='admin' func='view' ot='providerKey' sort='mapType' sortdir=$sdir}">{gt text='Map provider'}</a></th>
			<th><a href="{modurl modname='Locator' type='admin' func='view' ot='providerKey' sort='providerKey' sortdir=$sdir}">{gt text='Key one'}</a></th>
			<th><a href="{modurl modname='Locator' type='admin' func='view' ot='providerKey' sort='providerKey2' sortdir=$sdir}">{gt text='Key two'}</a></th>
			<th>{gt text='Actions'}</th>
		</tr>
	</thead>
	<tbody>
		{foreach from=$items item='item'}
			<tr>
				<td>{$item.mapType|getProviderNameFromId}</td>
				<td>{$item.providerKey}</td>
				<td>{$item.providerKey2}</td>
				<td>
					{checkpermissionblock component='Locator:ProviderKey:' instance='::' level=ACCESS_EDIT}
						<a href="{modurl modname='Locator' type='admin' func='edit' ot='providerKey' id=$item.id}">{icon type='edit'}</a>
					{/checkpermissionblock}
					{checkpermissionblock component='Locator:ProviderKey:' instance='::' level=ACCESS_DELETE}
						<a onclick="return ConfirmDelete('{$item.mapType}')" href="{modurl modname='Locator' type='admin' func='delete' ot='providerKey' id=$item.id}">{icon type='delete'}</a>
					{/checkpermissionblock}
				</td>
			</tr>
		{foreachelse}
			<tr><td colspan="4">{gt text='No provider key was found.'}</td></tr>
		{/foreach}
	</tbody>
</table>

{if isset($pager)}
	{pager limit=$pager.itemsperpage rowcount=$pager.numitems}
	<input type="hidden" value="{$currentPage}" />
{/if}

{include file='Admin/Footer.tpl'}
