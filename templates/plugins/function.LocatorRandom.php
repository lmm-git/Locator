<?php

/**
 * Generates a random number between 100000 and 999999.
 */
function smarty_function_LocatorRandom($params, Zikula_View $view)
{
	$result =  mt_rand(100000, 999999);

	if (isset($params['assign'])) {
		$view->assign ($params['assign'], $result);
	} else {
		return $result;
	}
}
