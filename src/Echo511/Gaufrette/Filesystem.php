<?php

namespace Echo511\Gaufrette;

use Echo511\Gaufrette\Adapter\Linkable;
use Echo511\Gaufrette\Adapter\Subadapterable;
use Echo511\Gaufrette\Adapter\Uploadable;
use Exception;
use Gaufrette\File;
use Gaufrette\Filesystem as GFilesystem;

/**
 * Filesystem with linkable support.
 *
 * @author Nikolas Tsiongas
 */
class Filesystem extends GFilesystem
{

	/** @var DataFilesystem[] */
	private $subsystems = array();

	/**
	 * Get filesystem with access limited to a subfolder.
	 *
	 * @param string $key
	 * @return Filesystem
	 */
	public function getSubsystem($key)
	{
		if($this->adapter instanceof Subadapterable) {
			if (!isset($this->subsystems[$key])) {
				$this->subsystems[$key] = new Filesystem($this->adapter->getSubadapter($key, true));
			}
			return $this->subsystems[$key];
		}

		throw new Exception("Adapter must implement Subadapterable interface to provide getSubsystem method.");
	}



	/**
	 * @param string $key
	 * @return string
	 * @throws Exception
	 */
	public function getUrl($key)
	{
		if ($this->adapter instanceof Linkable) {
			return $this->adapter->getUrl($key);
		}

		throw new Exception("Adapter must implement Linkable interface to provide URLs.");
	}



	/**
	 * @param $key
	 * @param $tmpName
	 * @throws Exception
	 */
	public function move($key, $tmpName)
	{
		if ($this->adapter instanceof Uploadable) {
			return $this->adapter->move($key, $tmpName);
		}

		throw new Exception("Adapter must implement Uploadable interface to provide direct upload capability.");
	}



}
