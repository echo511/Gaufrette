<?php

namespace Echo511\Gaufrette\Adapter;

use Echo511\Gaufrette\File;
use Exception;
use Gaufrette\Adapter\FileFactory;
use Gaufrette\Adapter\Local as GLocal;
use Gaufrette\Exception\FileNotFound;
use Gaufrette\Filesystem;

/**
 * Local adapter enhanced with linkable support.
 *
 * @author Nikolas Tsiongas
 */
class Local extends GLocal implements Linkable, Uploadable, Subadapterable, FileFactory
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
		$this->basePath = rtrim($basePath, '/');
	}



	/**
	 * Get adapter that has access only to subdirectory of this adapter.
	 *
	 * @param string $key
	 * @return Local
	 */
	public function getSubadapter($key, $create = true, $mode = 0777)
	{
		$key = ltrim($key, '/');
		return new Local($this->directory . '/' . $key, $this->getUrl($key, !$create), $create, $mode);
	}



	/**
	 * @param string $key
	 * @param bool $mustExist
	 * @return string
	 * @throws Exception Thrown when base path was not provided.
	 * @throws FileNotFound
	 */
	public function getUrl($key, $mustExist = true)
	{
		if (!$this->basePath) {
			throw new Exception('Cannot link to file. No base path provided.');
		}

		if ($this->exists($key) || !$mustExist) {
			$parts = explode('/', $key);
			foreach($parts as $pos => $part) {
				$parts[$pos] = rawurlencode($part);
			}
			$encodedKey = implode('/', $parts);
			return rtrim($this->basePath, '/') . '/' . ltrim($encodedKey, '/');
		}

		throw new FileNotFound($key);
	}



	/**
	 * @param string $key
	 * @param string $tmpName
	 */
	public function move($key, $tmpName)
	{
		$targetPath = $this->computePath($key);
		$this->ensureDirectoryExists(dirname($targetPath), true);

		if (!file_exists($targetPath)) {
			return rename($tmpName, $targetPath);
		}
	}



	/**
	 * @param string $key
	 * @param Filesystem $filesystem
	 * @return File|\Gaufrette\Adapter\File
	 */
	public function createFile($key, Filesystem $filesystem)
	{
		return new File($key, $filesystem);
	}



}
