{include file='Admin/Header.tpl' __title='Add a layer (OpenStreetMap)' img='editcopy.png'} 

{form cssClass='z-form'}
	{formerrormessage id='error'}
	{formvalidationsummary}

	<fieldset>
		<legend>{gt text='Information'}</legend>
		<div class="z-formrow">
			{formlabel __text='Name of layer (title for end-user)' for='name' mandatorysym=true}
			{formtextinput id='name' maxLength='255' mandatory=true  text=$layer.name}
		</div>

		<div class="z-formrow">
			{formlabel __text='Layer code (Javascript)' for='code' mandatorysym=true}
			{formtextinput textMode='multiline' rows='5' id='code' mandatory=true text=$layer.code}
		</div>

		<div class="z-formrow">
			{formlabel __text='Activate this layer for end-user?' for='active' mandatorysym=true}
			{formcheckbox checked=$layer.active id='active'}
		</div>

	</fieldset>
	
	<div class="z-buttons z-formbuttons">
		{formbutton commandName='register' __text='Add layer' class='z-bt-ok z-btgreen'}
		{formbutton commandName='cancel' __text='Cancel' class='z-bt-cancel z-btred'}
	</div>
	
{/form}

{include file='Admin/Footer.tpl'}
