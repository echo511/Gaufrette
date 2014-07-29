<?php

namespace Echo511\Gaufrette\Adapter;

use Exception;
use Gaufrette\Adapter\Local as GLocal;
use Gaufrette\Exception\FileNotFound;

/**
 * Local adapter enhanced with linkable support.
 * 
 * @author Nikolas Tsiongas
 */
class Local extends GLocal implements Linkable
{

	/** @var string */
	private $basePath;

	/**
	 * @param string $directory System path. Ex. /var/www/domain/public
	 * @param string $basePath Browser path. Ex. http://domain.cz/public
	 * @param bool $create
	 * @param int $mode
	 */
	public function __construct($directory, $basePath = null, $create = false, $mode = 0777)
	{
		parent::__construct($directory, $create, $mode);
		$this->basePath = $basePath;
	}



	/**
	 * Get adapter that has access only to subdirectory of this adapter.
	 * 
	 * @param string $key
	 * @return Local
	 */
	public function getSubadapter($key)
	{
		$key = ltrim($key, '/');
		return new Local($this->directory . '/' . $key, $this->basePath . '/' . $key);
	}



	/**
	 * @param string $key
	 * @return string
	 * @throws Exception Thrown when base path was not provided.
	 * @throws FileNotFound
	 */
	public function getUrl($key)
	{
		if (!$this->basePath) {
			throw new Exception('Cannot link to file. No base path provided.');
		}

		if ($this->exists($key)) {
			return $this->basePath . '/' . $key;
		}

		throw new FileNotFound($key);
	}



}
