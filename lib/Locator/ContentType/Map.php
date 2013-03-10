<?php
/**
 * Locator google map plugin
 */
class Locator_ContentType_Map extends Content_AbstractContentType
{
	protected $zoom;
	protected $text;
	protected $height;
	protected $pid;
	protected $mapType;

	function getTitle()
	{
		return $this->__('Map');
	}
	function getDescription()
	{
		return $this->__('Displays a map.');
	}
	function isTranslatable()
	{
		return true;
	}
	function isActive()
	{
		return true;
	}
	function loadData(&$data)
	{
		$this->zoom = $data['zoom'];
		$this->text = $data['text'];
		$this->height = $data['height'];
		$this->pid = $data['pid'];
		$this->mapType = $data['mapType'];
	}
	function display()
	{
		$this->view->assign('pid', $this->pid);
		$this->view->assign('zoom', $this->zoom);
		$this->view->assign('height', $this->height);
		$this->view->assign('text', DataUtil::formatForDisplayHTML($this->text));
		$this->view->assign('contentId', $this->contentId);
		$this->view->assign('language', ZLanguage::getLanguageCode());
		$this->view->assign('mapType', $this->mapType);

		return $this->view->fetch($this->getTemplate());
	}
	function displayEditing()
	{
		return DataUtil::formatForDisplay($this->text);
	}
	function getDefaultData()
	{
		return array(
			'zoom' => 5,
			'text' => '',
			'height' => 300,
			'mapType' => 'googlev3');
	}
	function startEditing()
	{
		$provider = Locator_Util::getProviderForFormDropdown();
		
		if(isset($this->pid))
		{
			$place = ModUtil::apiFunc('Locator', 'Geocoding', 'getPlaceById', array('pid' => $this->pid));
			$this->view->assign('longitude', $place->getLon())
			           ->assign('latitude', $place->getLat())
			           ->assign('address', $place->getAddress());
		}
		else
		{
			$this->view->assign('longitude', 13.406091)
			           ->assign('latitude', 52.519171)
			           ->assign('address', 'Berlin');
		}
		$this->view->assign('provider', $provider);
	}
	function getSearchableText()
	{
		return html_entity_decode(strip_tags($this->text));
	}
	
	//Add place to database
	function isValid($data, &$message)
	{
		if(!parent::isValid($data, &$message))
			return false;
		
		$values = $this->view->getValues();
		$newAddress = $values['address'];
		$newLon = $values['longitude'];
		$newLat = $values['latitude'];

		$newPlace = false;
		if(isset($this->pid))
		{
			$place = ModUtil::apiFunc('Locator', 'Geocoding', 'getPlaceById', array('pid' => $values['data']['pid']));
			
			if($newAddress != $place->getAddress() || $newLon != $place->getLon() || $newLat != $place->getLat())
				$newPlace = true;
		}

		if(!isset($values['data']['pid']) || $newPlace == true) {
			$pid = ModUtil::apiFunc('Locator', 'Geocoding', 'addPlace', array(
					'geocoder' => 'Mapstraction_googlev3',
					'address' => $newAddress,
					'display_name' => $newAddress,
					'lat' => $newLat,
					'lon' => $newLon,
					'geocoder_output' => array(),
					'date' => date('r'))
			);
		
			$this->pid = $pid;
			
			$values['data']['pid'] = $pid;
			$values['longitude'] = $newLon;
			$values['latitude'] = $newLat;
			$this->view->assign('longitude', $newLon);
			$this->view->assign('latitude', $newLat);
			$this->view->setValues($values);
			
			$message = $this->__('Please click onto "Save" once again, your place is now saved in database!');
			return false;
		}
		return true;
	}
}
