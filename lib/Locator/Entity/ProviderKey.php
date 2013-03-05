<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * Keys entity class.
 *
 * Annotations define the entity mappings to database.
 *
 * @ORM\Entity
 * @ORM\Table(name="Locator_ProviderKey")
 */
class Locator_Entity_ProviderKey extends Zikula_EntityAccess
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
	 * The following are annotations which define the mapType field.
	 *
	 * @ORM\Column(type="string")
	 */
	private $mapType;

	/**
	 * The following are annotations which define the providerKey field.
	 *
	 * @ORM\Column(type="string")
	 */
	private $providerKey;

	/**
	 * The following are annotations which define the providerKey2 field.
	 *
	 * @ORM\Column(type="string")
	 */
	private $providerKey2;

	//getting section
	public function getId()
	{
		return $this->id;
	}

	public function getMapType()
	{
		return $this->mapType;
	}

	public function getProviderKey()
	{
		return $this->providerKey;
	}

	public function getProviderKey2()
	{
		return $this->providerKey2;
	}


	//setting section
	public function setMapType($v)
	{
		$this->mapType = $v;
	}

	public function setProviderKey($v)
	{
		$this->providerKey = $v;
	}

	public function setProviderKey2($v)
	{
		$this->providerKey2 = $v;
	}
}
