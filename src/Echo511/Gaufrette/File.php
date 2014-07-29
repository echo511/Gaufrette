<?php

namespace Echo511\Gaufrette;

use Echo511\Gaufrette\Adapter\Linkable;
use Gaufrette\File as GFile;

/**
 * File with linkable support.
 * 
 * @author Nikolas Tsiongas
 */
class File extends GFile
{

	/**
	 * @return string
	 */
	public function getUrl()
	{
		if ($this->filesystem->getAdapter() instanceof Linkable) {
			return $this->filesystem->getUrl($this->key);
		}
	}



}
