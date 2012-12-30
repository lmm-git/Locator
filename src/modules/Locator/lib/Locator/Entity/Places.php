<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * Persons entity class.
 *
 * Annotations define the entity mappings to database.
 *
 * @ORM\Entity
 * @ORM\Table(name="Locator_Places")
 */
class Locator_Entity_Places extends Zikula_EntityAccess
{

	/**
	 * The following are annotations which define the id field.
	 *
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;


	/**
	 * The following are annotations which define the address field.
	 *
	 * @ORM\Column(type="string")
	 */
	private $address;

	/**
	 * The following are annotations which define the lon (longitude) field.
	 *
	 * @ORM\Column(type="string")
	 */
	private $lon;

	/**
	 * The following are annotations which define the lat (latitude) field.
	 *
	 * @ORM\Column(type="string")
	 */
	private $lat;

	/**
	 * The following are annotations which define the display_name field.
	 *
	 * @ORM\Column(type="string")
	 */
	private $display_name;

	/**
	 * The following are annotations which define the geocoder field.
	 *
	 * @ORM\Column(type="string")
	 */
	private $geocoder;

	/**
	 * The following are annotations which define the geocoder_output field.
	 *
	 * @ORM\Column(type="array")
	 */
	private $geocoder_output;

	/**
	 * The following are annotations which define the date field.
	 * @ORM\Column(type="datetime")
	 */
	private $date;


	//setting section

	public function getId()
	{
		return $this->id;
	}

	public function getAddress()
	{
		return $this->address;
	}

	public function getLon()
	{
		return $this->lon;
	}

	public function getLat()
	{
		return $this->lat;
	}

	public function getDisplay_name()
	{
		return $this->display_name;
	}

	public function getGeocoder()
	{
		return $this->geocoder;
	}

	public function getGeocoder_Output()
	{
		return $this->geocoder_output;
	}

	public function getDate()
	{
		return $this->date;
	}

	//getting section

	public function setAddress($v)
	{
		$this->address = $v;
	}

	public function setLon($v)
	{
		$this->lon = $v;
	}

	public function setLat($v)
	{
		$this->lat = $v;
	}

	public function setDisplay_name($v)
	{
		$this->display_name = $v;
	}

	public function setGeocoder($v)
	{
		$this->geocoder = $v;
	}

	public function setGeocoder_output($v)
	{
		$this->geocoder_output = $v;
	}

	public function setDate($v)
	{
		$this->date = new DateTime($v);
	}

}
