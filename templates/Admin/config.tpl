{include file='Admin/Header.tpl' icon='config' __title='Configuration'}
{form cssClass='z-form'}
	{formvalidationsummary}
	{formsetinitialfocus inputId='bool'}
	<fieldset>
		<legend>{gt text='Geocoding'}</legend>
		<h4 class="z-formnote">Nominatim</h4>
		<div class="z-formrow">
			{formlabel for='nominatim_mail_address' __text='Email adress'}
			{formemailinput id='nominatim_mail_address' group='config'}
			<em class="z-sub z-formnote">{gt text='Read the Nominatim usage policy for further details!'} <a href="http://wiki.openstreetmap.org/wiki/Nominatim_usage_policy" title="http://wiki.openstreetmap.org/wiki/Nominatim_usage_policy">http://wiki.openstreetmap.org/wiki/Nominatim_usage_policy</a></em>
		</div>
	</fieldset>

	<div class="z-buttons z-formbuttons">
		{formbutton commandName='save' __text='Update configuration' class='z-bt-save'}
		{formbutton commandName='cancel' __text='Cancel' class='z-bt-cancel'}
	</div>
{/form}
{include file='Admin/Footer.tpl'}
