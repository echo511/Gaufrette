Plupload for Nette Framework
============================

Installation
------------

Install using composer:

```sh
$ composer require echo511/gaufrette:~1.0@dev
```

Register compiler extension using config.neon

```yml
extensions:
	gaufrette: Echo511\Gaufrette\DI\GaufretteExtension
```

Configure in config.neon

```yml
gaufrette:
	# Folder for asset copies
	assets:
		directory: '.../assets'
		web: '<basePath>/assets'

	# Data directory (uploaded photos/pdfs/etc.)
	data:
		directory: '.../data'
		web: '<basePath>/data'
```


Make sure your compiler extension class implements Echo511\Gaufrette\DI\IAssetsProvider.


Usage
-----

To access assets use Echo511\Gaufrette\Assets\ExtensionsAssets or macro Echo511\Gaufrette\Assets\AssetMacro.

To access data use Echo511\Gaufrette\Data\DataFilesystem.


Asset macro
-----------

In presenter:

```php
<?php

use Nette\Application\UI\Presenter;
use Echo511\Plupload\Entity\UploadQueue;

class HomePresenter extends Presenter
{

	/** @var AssetMacro @inject */
	public $assetMacro;


	public function createTemplate()
	{
		$template = parent::createTemplate();
		$this->assetMacro->register($template, 'asset', MyCompilerExtension::class);
		return $template;
	}

}
```

In templates then use:
```sh
<link href="{asset 'css/bootstrap.min.css'}" rel="stylesheet">
```
