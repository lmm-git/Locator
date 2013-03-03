<?php

function smarty_modifier_array2br($array)
{
return "doof!";
	$out = '';
	
	if(is_array($array))
		foreach($array as $value)
			$out .= "$value<br />";
	
	return $out;
}
