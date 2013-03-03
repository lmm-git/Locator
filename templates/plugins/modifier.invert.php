<?php

function smarty_modifier_invert($bool)
{
	return (is_bool($bool)) ? !$bool : $bool;
}
