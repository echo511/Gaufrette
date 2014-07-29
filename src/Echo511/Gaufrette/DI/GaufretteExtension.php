<?php

namespace Echo511\Gaufrette\DI;

use Echo511\Gaufrette\Assets\AssetMacro;
use Echo511\Gaufrette\Assets\ExtensionsAssets;
use Echo511\Gaufrette\Assets\WarmCommand;
use Echo511\Gaufrette\LocalFilesystemFactory;
use Kdyby\Console\DI\ConsoleExtension;
use Nette\DI\CompilerExtension;

/**
 * Registers extension into Nette's DI container.
 * 
 * @author Nikolas Tsiongas
 */
class GaufretteExtension extends CompilerExtension
{

	private $config = array(
	    'assets' => array(
		'directory' => null,
		'web' => null
	    ),
	    'data' => array(
		'directory' => null,
		'web' => null,
		'class' => 'Echo511\Gaufrette\Data\DataFilesystem'
	    )
	);

	public function loadConfiguration()
	{
		$config = $this->getConfig($this->config);

		$this->containerBuilder->addDefinition('echo511.gaufrette.localFilesystemFactory')
			->setClass('Echo511\Gaufrette\LocalFilesystemFactory');

		// Assets
		$this->containerBuilder->addDefinition('echo511.gaufrette.extensionsAssets')
			->setClass('Echo511\Gaufrette\Assets\ExtensionsAssets')
			->setArguments(array($this->getExtensionsAssetsMapping(), '@echo511.gaufrette.assetsFilesystem'));

		$this->containerBuilder->addDefinition('echo511.gaufrette.assetsFilesystem')
			->setClass('Echo511\Gaufrette\Filesystem')
			->setFactory('@echo511.gaufrette.localFilesystemFactory::create', $config['assets']);

		$this->containerBuilder->addDefinition('echo511.gaufrette.assetMacro')
			->setClass('Echo511\Gaufrette\Assets\AssetMacro');

		$this->containerBuilder->addDefinition('echo511.gaufrette.warmCommand')
			->setClass('Echo511\Gaufrette\Assets\WarmCommand')
			->addTag(ConsoleExtension::COMMAND_TAG);

		// Data
		$this->containerBuilder->addDefinition('echo511.gaufrette.dataFilesystem')
			->setClass('Echo511\Gaufrette\Data\DataFilesystem')
			->setFactory('@echo511.gaufrette.localFilesystemFactory::create', $config['data']);
	}



	protected function getExtensionsAssetsMapping()
	{
		$mapping = array();
		foreach ($this->compiler->getExtensions('Echo511\Gaufrette\DI\IAssetsProvider') as $extension) {
			$mapping[get_class($extension)] = $extension->getDataDirectory();
		}
		return $mapping;
	}



}
