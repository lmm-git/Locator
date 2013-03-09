<?php

/**
 * Returns the provider name by id.
 */
function smarty_modifier_getProviderNameFromId($id)
{
	return Locator_Util::getProviderNameFromId($id);
}
