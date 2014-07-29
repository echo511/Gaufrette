<?php

namespace Echo511\Gaufrette\Assets;

use Echo511\Gaufrette\Filesystem;
use Exception;
use Gaufrette\Adapter;
use Nette\Utils\Strings;

/**
 * Handles assets of one specific compiler extension class 
 * that has implemented IAssetsProvider.
 * 
 * When asked asset is copied from its source folder to an accessible
 * public directory. Url is then served from the public directory.
 * 
 * @author Nikolas Tsiongas
 */
class ExtensionFilesystem extends Filesystem
{

	/** @var string */
	private $namespace;

	/** @var Filesystem */
	private $public;

	public function __construct($namespace, Adapter $adapter, Filesystem $public)
	{
		parent::__construct($adapter);
		$this->namespace = Strings::webalize($namespace);
		$this->public = $public;
	}



	/**
	 * Sync files between internal folder and public filesystem.
	 */
	public function sync()
	{
		$keys = $this->public->listKeys();
		foreach ($keys['keys'] as $key) {
			$this->public->delete($key);
		}

		foreach ($this->public->keys() as $key) {
			$this->public->delete($key);
		}

		$keys = $this->listKeys();
		foreach ($keys['keys'] as $key) {
			$nkey = $this->namespace . '/' . $key;
			$this->public->write($nkey, $this->adapter->read($key), true);
		}
	}



	public function getUrl($key)
	{
		$nkey = $this->namespace . '/' . $key;

		if (!$this->adapter->exists($key)) {
			throw new Exception("File $key not found.");
		}

		if (!$this->public->has($nkey)) {
			$this->public->write($nkey, $this->adapter->read($key));
		}

		if ($this->adapter->mtime($key) > $this->public->mtime($nkey)) {
			$this->public->write($nkey, $this->adapter->read($key), true);
		}

		return $this->public->getUrl($nkey);
	}



	public function delete($key)
	{
		$this->error();
	}



	public function rename($sourceKey, $targetKey)
	{
		$this->error();
	}



	public function write($key, $content, $overwrite = false)
	{
		$this->error();
	}



	protected function error()
	{
		throw new Exception("Extension filesystem is read-only.");
	}



}
