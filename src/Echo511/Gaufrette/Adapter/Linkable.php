<?php

namespace Echo511\Gaufrette\Adapter;

/**
 * Adapter providing direct file url by key.
 * 
 * @author Nikolas Tsiongas
 */
interface Linkable
{

	/**
	 * @param string $key
	 */
	function getUrl($key);
}
