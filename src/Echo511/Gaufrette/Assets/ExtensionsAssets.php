<?php

namespace Echo511\Gaufrette\Assets;

use Echo511\Gaufrette\Adapter\Local;
use Echo511\Gaufrette\Filesystem;
use Exception;
use Nette\Object;

/**
 * Manages assets of all registered compiler extensions implementing IAssetsProvider.
 * 
 * @author Nikolas Tsiongas
 */
class ExtensionsAssets extends Object
{

	/** @var array [extensionClass => dataDir] */
	private $mapping;

	/** @var Filesystem */
	private $public;

	/** @var Filesystem[] */
	private $filesystems;

	public function __construct(array $mapping, Filesystem $public)
	{
		$this->mapping = $mapping;
		$this->public = $public;
	}



	/**
	 * Get filesystem of specific compiler extension class.
	 * 
	 * @param string $extensionClass
	 * @return ExtensionFilesystem
	 * @throws Exception
	 */
	public function getFilesystem($extensionClass)
	{
		if (!isset($this->mapping[$extensionClass])) {
			throw new Exception("Extension $extensionClass has not provided any data.");
		} elseif (!isset($this->filesystems[$extensionClass])) {
			$adapter = new Local($this->mapping[$extensionClass]);
			$this->filesystems[$extensionClass] = new ExtensionFilesystem($extensionClass, $adapter, $this->public);
		}
		return $this->filesystems[$extensionClass];
	}



	/**
	 * Assoc array extensionClass => filesystem
	 * 
	 * @return ExtensionFilesystem[]
	 */
	public function getFilesystems()
	{
		foreach ($this->mapping as $extensionClass => $dataDir) {
			$this->getFilesystem($extensionClass);
		}
		return $this->filesystems;
	}



}
