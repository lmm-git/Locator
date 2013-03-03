<div class="z-formrow">
    {formlabel for='latitude' __text='Latitude'}
    {formtextinput id='latitude' group='data' mandatory=true maxLength=30}
    {contentlabelhelp __text='(a comma-separated numeral that has a precision to 6 decimal places. For example, 40.714728)'}
</div>

<div class="z-formrow">
    {formlabel for='longitude' __text='Longitude'}
    {formtextinput id='longitude' group='data' mandatory=true maxLength=30}
    {contentlabelhelp __text='(a comma-separated numeral that has a precision to 6 decimal places. For example, 40.714728)'}
</div>

<div class="z-formrow">
    {formlabel for='zoom' __text='Zoom level'}
    {formtextinput id='zoom' group='data' mandatory=true maxLength=2}
    {contentlabelhelp __text='(from 0 for the entire world to 19 for individual buildings)'}
</div>

<div class="z-formrow">
    {formlabel for='height' __text='Height of the displayed map in pixels'}
    {formtextinput id='height' group='data' mandatory=true maxLength=30}
    {contentlabelhelp __text='(below 350 pixels the navigation controls will be small)'}
</div>

<div class="z-formrow">
    {formlabel for='text' __text='Description to be shown below the map'}
    {formtextinput id='text' group='data' maxLength=255}
</div>
