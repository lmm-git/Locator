<?php

/**
 * Converts a boolean value to a string.
 */
function smarty_modifier_bool2str($bool)
{
	if($bool)
		return 'true';
	
	return 'false';
}
