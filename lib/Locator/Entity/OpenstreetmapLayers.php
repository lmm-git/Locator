<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * OpenstreetmapLayers entity class.
 *
 * Annotations define the entity mappings to database.
 *
 * @ORM\Entity
 * @ORM\Table(name="Locator_OpenstreetmapLayers")
 */
class Locator_Entity_OpenstreetmapLayers extends Zikula_EntityAccess
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
	 * The following are annotations which define the code field.
	 *
	 * @ORM\Column(type="text")
	 */
	private $code;

	/**
	 * The following are annotations which define the active field.
	 *
	 * @ORM\Column(type="boolean")
	 */
	private $active;


	//setting section

	public function getId()
	{
		return $this->id;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getCode()
	{
		return $this->code;
	}

	public function getActive()
	{
		return $this->active;
	}


	//getting section

	public function setName($v)
	{
		$this->name = $v;
	}

	public function setCode($v)
	{
		$this->code = $v;
	}

	public function setActive($v)
	{
		$this->active = $v;
	}
}
