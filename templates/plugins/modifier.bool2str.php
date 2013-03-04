<?php

function smarty_modifier_bool2str($bool)
{
	if($bool)
		return 'true';
	
	return 'false';
}
