<?php

function smarty_function_LocatorReplaceRand($params, Zikula_View $view)
{
	$vars = $view->get_template_vars();
	return str_replace('%RAND%', $vars['rand'], $params['javascript']);
}
