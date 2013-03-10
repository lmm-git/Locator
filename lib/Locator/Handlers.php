<?php

/**
 * Event handlers for the Locator module
 */
class Locator_Handlers 
{
	// deliver Content plugin for displaying maps
	public static function getTypes(Zikula_Event $event)
	{
		$types = $event->getSubject();
		$types->add('Locator_ContentType_Map');
	}
}
