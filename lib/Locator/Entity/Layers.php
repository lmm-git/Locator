<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * Layers entity class.
 *
 * Annotations define the entity mappings to database.
 *
 * @ORM\Entity
 * @ORM\Table(name="Locator_Layers")
 */
class Locator_Entity_Layers extends Zikula_EntityAccess
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
	 * The following are annotations which define the name field.
	 *
	 * @ORM\Column(type="string")
	 */
	private $name;

	/**
	 * The following are annotations which define the mapTypes field.
	 *
	 * @ORM\Column(type="array")
	 */
	private $mapTypes;

	/**
	 * The following are annotations which define the url field.
	 *
	 * @ORM\Column(type="string")
	 */
	private $url;

	/**
	 * The following are annotations which define the license field.
	 *
	 * @ORM\Column(type="string")
	 */
	private $license;

	/**
	 * The following are annotations which define the minZoom field.
	 *
	 * @ORM\Column(type="integer")
	 */
	private $minZoom;

	/**
	 * The following are annotations which define the maxZoom field.
	 *
	 * @ORM\Column(type="integer")
	 */
	private $maxZoom;

	/**
	 * The following are annotations which define the opacity field.
	 *
	 * @ORM\Column(type="float")
	 */
	private $opacity;

	/**
	 * The following are annotations which define the selectable field.
	 *
	 * @ORM\Column(type="boolean")
	 */
	private $selectable;

	/**
	 * The following are annotations which define the active field.
	 *
	 * @ORM\Column(type="boolean")
	 */
	private $active;

	//getting section
	public function getId()
	{
		return $this->id;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getMapTypes()
	{
		return $this->mapTypes;
	}

	public function getUrl()
	{
		return $this->url;
	}

	public function getLicense()
	{
		return $this->license;
	}

	public function getMinZoom()
	{
		return $this->minZoom;
	}

	public function getMaxZoom()
	{
		return $this->maxZoom;
	}

	public function getOpacity()
	{
		return $this->opacity;
	}

	public function getSelectable()
	{
		return $this->selectable;
	}

	public function getActive()
	{
		return $this->active;
	}


	//setting section
	public function setName($v)
	{
		$this->name = $v;
	}

	public function setMapTypes($v)
	{
		$this->mapTypes = $v;
	}

	public function setUrl($v)
	{
		$this->url = $v;
	}

	public function setLicense($v)
	{
		$this->license = $v;
	}

	public function setMinZoom($v)
	{
		$this->minZoom = $v;
	}

	public function setMaxZoom($v)
	{
		$this->maxZoom = $v;
	}

	public function setOpacity($v)
	{
		$this->opacity = $v;
	}

	public function setSelectable($v)
	{
		$this->selectable = $v;
	}

	public function setActive($v)
	{
		$this->active = $v;
	}
}
