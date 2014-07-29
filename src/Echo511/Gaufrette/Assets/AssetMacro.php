<?php

namespace Echo511\Gaufrette\Assets;

use Latte\Macros\MacroSet;
use Nette\Bridges\ApplicationLatte\Template;
use Nette\Object;

/**
 * Latte macro providing urls for extensions' assets.
 * 
 * Usage: {asset 'css/bootstrap.min.css'}
 * 
 * Extension's compiler extension has to implement IAssetsProvider.
 * 
 * @author Nikolas Tsiongas
 */
class AssetMacro extends Object
{

	/** @var ExtensionsAssets */
	private $extensionsData;

	public function __construct(ExtensionsAssets $extensionsData)
	{
		$this->extensionsData = $extensionsData;
	}



	/**
	 * Register in base presenter.
	 * When registered it will provide url for assets belonging to 
	 * compiler extension class which has implemented IAssetsProvider.
	 * 
	 * @param Template $template
	 * @param string $name Name of the macro used in templates.
	 * @param string $extensionClass Compiler extension class
	 */
	public function register(Template $template, $name, $extensionClass)
	{
		$latte = $template->getLatte();

		$template->_echo511_assetlocator = $this->extensionsData;

		$set = new MacroSet($latte->getCompiler());
		$set->addMacro($name, function($node, $writer) use ($extensionClass) {
			return $writer->write('echo $_echo511_assetlocator->getFilesystem(\'' . $extensionClass . '\')->getUrl(\'' . trim($node->args, '"\'') . '\');');
		});
	}



}
