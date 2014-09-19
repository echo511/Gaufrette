<?php

namespace Echo511\Gaufrette\Adapter;

/**
 * Adapter providing direct file url by key.
 * 
 * @author Nikolas Tsiongas
 */
interface Uploadable
{

	/**
	 * @param string $key
	 * @param string $tmpName
	 */
	function move($key, $tmpName);
}
