<?php

namespace Echo511\Gaufrette\Adapter;

/**
 * Adaptar capable of creating new adapter handling subkey.
 *
 * @author Nikolas Tsiongas
 */
interface Subadapterable
{

	/**
	 * @param $key
	 * @param $create
	 * @param $mode
	 * @return mixed
	 */
	function getSubadapter($key, $create = false, $mode = 0777);
}