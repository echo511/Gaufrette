<?php

namespace Echo511\Gaufrette\DI;

/**
 * Provide directory with assets.
 * 
 * Compiler extension class implementing this interface enables serving its
 * assets from within the source code folder.
 * 
 * Files are copied to a public directory.
 * 
 * @author Nikolas Tsiongas
 */
interface IAssetsProvider
{

	/**
	 * Get the directory where assets of your compiler extension class
	 * are stored.
	 * 
	 * @return string
	 */
	function getDataDirectory();
}
