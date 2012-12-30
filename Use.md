Use Locator
===========

Feel free to use this module! How? Read the instructions below:

Example implementation
----------------------
The module is devided in 2 main sections: The geocoding and the displaying of the map. First your module has to geocode a place with
```php
...
$place = ModUtil::apiFunc('Locator', 'geocoding', 'Nominatim', array('mixedAddress' => 'YOUR ADDRESS HERE'));
...
```
This command will return you a lot of information about your place. The most important information are (always as descriptor in the place-array):
* status: false if no valid places found or number of found places
* array: the decoded JSON return from OpenStreetMap.
* array->$i->pid: The most important because this pid you must pass back if you want to display a map with this place.

The complete returning you find here (the same as in the geocoding API-file)
```php
/**
 * @return string $result['status'] false If no place found, int $numOfPlaces If place(s) found
 * @return array  $result['array'] Returned json code of nominatim (array form)
 * @return array  $result['array'][$i] $i = 0 means first found place, $i = 1 means second...
 * @return int    $result['array'][$i]['lat'] Latitude of place
 * @return int    $result['array'][$i]['lon'] Longitude of place
 * @return string $result['array'][$i]['display_name'] Display name of place
 * @return int    $result['array'][$i]['place_id'] Place id by OpenStreetMap
 * @return string $result['array'][$i]['license'] License of OpenStreetMap
 * @return string $result['array'][$i]['osm_type'] see OpenStreetMap, e.g. 'way', 'node', 'relation'
 * @return int    $result['array'][$i]['osm_id'] Id, e.g. of the 'way', 'node', 'relation'
 * @return array  $result['array'][$i]['boundingbox'] Array with the nearest lat and lon around the place
 * @return string $result['array'][$i]['class'] see OpenStreetMap
 * @return string $result['array'][$i]['type'] see OpenStreetMap
 * @return string $result['array'][$i]['pid'] Place id of Locator. You must pass this id in case of display location.
 * 
 * @version 1.2
 */
```

Now we will come to the displaying of the map:
Your module must just call
```php
...
$map = ModUtil::apiFunc('Locator', 'Map', 'OpenStreetMap', array('pid' => 'YOUR PID FROM ABOVE', 'mode' => 'iframe', 'style' => 'YOUR STYLE FOR IFRAME HERE (inline style tag)'));
...
```
This will return a html string wich contain an iframe. So the site loading isn't slower because the map tiles.

All avaiable commands you find here (the same as in the map API-file)
```php
/**
 * @param int $args['pid'] PID of place.
 * @param string $args['style'] Style of the iframe (inline style).
 * @param string $args['mode'] Type of map. Currently only 'iframe' is supported.
 * @return string Iframe with map
 * @throws Zikula_Exception_Forbidden If $lon or $lat are missing
 * 
 * Currently there is just one method available:
 * - iframe: Generates an iframe including the map.
 * 
 * @version 1.1
 */
```
