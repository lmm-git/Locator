{include file='Admin/Header.tpl' __title='Manage layers' img='configure.png'} 

{ajaxheader ui=true}
{pageaddvarblock}
<script type="text/javascript">
	document.observe("dom:loaded", function() {
		Zikula.UI.Tooltips($$('.tooltips'));
	});
</script>
{/pageaddvarblock}

{form}
	{formerrormessage id='error'}
	{formvalidationsummary}

	<fieldset>
		<table class="z-datatable">
		<thead>
			<tr>
				<th>{gt text="Name of layer"}</th>
				<th>{gt text="Active"}</th>
				<th>{gt text="Actions"}</th>
			</tr>
		</thead>
		<tbody>
			{foreach from=$layerOSM item='item'}
				<tr class="{cycle values='z-odd,z-even'}">
					<td>{$item.name}</td>
					<td>{formcheckbox checked=$item.active id=$item.id}</td>
					<td>
						<a href="{modurl modname='Locator' type='admin' func='AddOpenStreetMapLayer' lid=$item.id}">{img modname=core src='xedit.png' set=icons/extrasmall __title="Edit `$item.name`" __alt='Edit' class='tooltips'}</a>
						<a href="{modurl modname='Locator' type='admin' func='RemoveOpenStreetMapLayer' lid=$item.id}" onclick="return confirm('{gt text='Are you sure to remove?'}')" >{img modname=core src='trashcan_empty.png' set=icons/extrasmall __title="Delete `$item.name`" __alt='Delete' class='tooltips'}</a>
					</td>
				</tr>
			{/foreach}
		</tbody>
		</table>

	</fieldset>
	
	<div class="z-buttons z-formbuttons">
		{formbutton commandName='register' __text='Save' class='z-bt-ok z-btgreen'}
		{formbutton commandName='cancel' __text='Cancel' class='z-bt-cancel z-btred'}
	</div>
	
{/form}

{include file='Admin/Footer.tpl'}
