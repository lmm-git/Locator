<?php

function smarty_modifier_bool2pic($bool)
{
	$view = Zikula_View::getInstance();
	require_once $view->_get_plugin_filepath('function','img');

	if($bool)
		return smarty_function_img(array('modname' => 'core', 'set' => 'icons/extrasmall', 'src' => 'button_ok.png'), $view);
	
	return smarty_function_img(array('modname' => 'core', 'set' => 'icons/extrasmall', 'src' => 'button_cancel.png'), $view);
}
