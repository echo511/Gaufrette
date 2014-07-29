<?php

namespace Echo511\Gaufrette;

use Echo511\Gaufrette\Adapter\Local;
use Nette\Http\Request;
use Nette\Object;
use Nette\Utils\Strings;

/**
 * Creates local filesystem accessible from web browser.
 * 
 * @author Nikolas Tsiongas
 */
class LocalFilesystemFactory extends Object
{

	/** @var Request */
	private $request;

	public function __construct(Request $request)
	{
		$this->request = $request;
	}



	/**
	 * Create local filesystem accessible from web browser.
	 * 
	 * Use constant <basePath> that is available in templates as $basePath.
	 * 
	 * @param string $directory System path
	 * @param string $web Browser path.
	 * @param string $class Default or descendant.
	 * @return \Echo511\Gaufrette\class
	 */
	public function create($directory, $web, $class = 'Echo511\Gaufrette\Filesystem')
	{
		$adapter = new Local($directory, Strings::replace($web, '/<basePath>/', $this->getBasePath()));
		return new $class($adapter);
	}



	/**
	 * Return base path from request.
	 * 
	 * Copied from Nette's sources.
	 * 
	 * @return string
	 */
	protected function getBasePath()
	{
		$baseUrl = rtrim($this->request->getUrl()->getBaseUrl(), '/');
		$basePath = preg_replace('#https?://[^/]+#A', '', $baseUrl);
		return $basePath;
	}



}
