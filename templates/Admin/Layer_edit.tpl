{if !$edit}
	{gt text='Add a layer' assign='title'}
	{assign var='img' value='filenew.png'}
{else}
	{gt text='Edit a layer' assign='title'}
	{assign var='img' value='edit.png'}
{/if}

{include file='Admin/Header.tpl' title=$title img=$img} 

{form cssClass='z-form'}
	{formvalidationsummary}
	<fieldset>
		<legend>{gt text='Information'}</legend>
		<div class="z-formrow">
			{formlabel __text='Name' for='name' mandatorysym=true}
			{formtextinput id='name' mandatory=true maxLength="255" text=$layer.name}
		</div>
		<div class="z-formrow">
			{formlabel __text='Provider' for='mapTypes' mandatorysym=true}
			{formdropdownlist id="mapTypes" items=$provider mandatory=true selectionMode='multiple' selectedValue=$layer.mapTypes}
		</div>
		<div class="z-formrow">
			{formlabel __text='Url' for='url' mandatorysym=true}
			{formtextinput id='url' mandatory=true maxLength="255" text=$layer.url}
			<em class="z-sub z-formnote">{gt text='Example'}: {literal}http://tile.example.com/${z}/${x}/${y}.png{/literal}</em>
		</div>
		<div class="z-formrow">
			{formlabel __text='License' for='license'}
			{formtextinput id='license' maxLength="255" text=$layer.license}
			<em class="z-sub z-formnote">{gt text='Example'}: &copy; example.com</em>
		</div>
		<div class="z-formrow">
			{formlabel __text='Minimal zoom level' for='minZoom'}
			{formintinput id='minZoom' minValue=1 maxValue=100 text=$layer.minZoom}
		</div>
		<div class="z-formrow">
			{formlabel __text='Maximal zoom level' for='maxZoom'}
			{formintinput id='maxZoom' minValue=1 maxValue=100 text=$layer.maxZoom}
		</div>
		<div class="z-formrow">
			{formlabel __text='Opacity' for='opacity' mandatorysym=true}
			{formfloatinput id='opacity' minValue=0 maxValue=1 text=$layer.opacity|default:1 mandatory=true}
		</div>
		<div class="z-formrow">
			{formlabel __text='Always on' for='alwaysOn'}
			{formcheckbox id='alwaysOn' checked=$layer.alwaysOn|default:false}
		</div>
		<div class="z-formrow">
			{formlabel __text='Active' for='active'}
			{formcheckbox id='active' checked=$layer.active|default:true}
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
