{if !$edit}
	{gt text='Add a provider key' assign='title'}
	{assign var='img' value='filenew.png'}
{else}
	{gt text='Edit a provider key' assign='title'}
	{assign var='img' value='edit.png'}
{/if}

{include file='Admin/Header.tpl' title=$title img=$img} 

{form cssClass='z-form'}
	{formvalidationsummary}
	<fieldset>
		<legend>{gt text='Information'}</legend>
		<div class="z-formrow">
			{formlabel __text='Provider' for='mapType' mandatorysym=true}
			{formdropdownlist id="mapType" items=$provider mandatory=true selectedValue=$key.mapType}
		</div>

		<div class="z-formrow">
			{formlabel __text='Key' for='providerKey' mandatorysym=true}
			{formtextinput id='providerKey' mandatory=true maxLength="255" text=$key.providerKey}
			<em class="z-sub z-formnote">{gt text='Enter your provider key ("app-id") here.'}</em>
		</div>

		<div class="z-formrow">
			{formlabel __text='Nokia Auth-Token' for='providerKey2'}
			{formtextinput id='providerKey2' maxLength="255" text=$key.providerKey2}
			<em class="z-sub z-formnote">{gt text='That is only necessary for Nokia. Enter your "auth-token" here. Leave empty if you do not use Nokia as your provider.'}</em>
		</div>

	</fieldset>
	
	<div class="z-buttons z-formbuttons">
		{if !$edit}
			{formbutton commandName='add' __text='Add key' class='z-bt-ok z-btgreen'}
		{else}
			{formbutton commandName='edit' __text='Edit key' class='z-bt-ok z-btgreen'}
		{/if}
		{formbutton commandName='cancel' __text='Cancel' class='z-bt-cancel z-btred'}
	</div>
	
{/form}

{include file='Admin/Footer.tpl'}
