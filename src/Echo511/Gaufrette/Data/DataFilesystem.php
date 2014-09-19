<?php

namespace Echo511\Gaufrette\Data;

use Echo511\Gaufrette\Adapter\Uploadable;
use Echo511\Gaufrette\Filesystem;

/**
 * Data manipulation.
 * 
 * @author Nikolas Tsiongas
 */
class DataFilesystem extends Filesystem
{

	/** @var DataFilesystem[] */
	private $subsystems = array();

	/**
	 * Get filesystem with access limited to subfolder.
	 * 
	 * @param string $key
	 * @return DataFilesystem
	 */
	public function getSubsystem($key)
	{
		if (!isset($this->subsystems[$key])) {
			$this->subsystems[$key] = new DataFilesystem($this->adapter->getSubadapter($key));
		}
		return $this->subsystems[$key];
	}



	public function move($key, $tmpName)
	{
		if ($this->adapter instanceof Uploadable) {
			$this->adapter->move($key, $tmpName);
		}
	}



}
