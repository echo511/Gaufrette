<?php

namespace Echo511\Gaufrette;

use Echo511\Gaufrette\Adapter\Linkable;
use Exception;
use Gaufrette\Filesystem as GFilesystem;

/**
 * Filesystem with linkable support.
 * 
 * @author Nikolas Tsiongas
 */
class Filesystem extends GFilesystem
{

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



}
