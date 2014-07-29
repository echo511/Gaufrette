<?php

namespace Echo511\Gaufrette\Assets;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Copies files from internal folder to public filesystem.
 * 
 * One should call this command to be sure all files (images referenced in css)
 * were copied to the public directory and are accessible.
 * 
 * @author Nikolas Tsiongas
 */
class WarmCommand extends Command
{

	/** @var ExtensionsAssets */
	private $extensionsData;

	public function __construct(ExtensionsAssets $extensionsData)
	{
		parent::__construct($name);
		$this->extensionsData = $extensionsData;
	}



	public function configure()
	{
		parent::configure();
		$this->setName('assets:warm')
			->setDescription('Copy assets to public folder.');
	}



	public function execute(InputInterface $input, OutputInterface $output)
	{
		foreach ($this->extensionsData->getFilesystems() as $filesystem) {
			$filesystem->sync();
		}
	}



}
