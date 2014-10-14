<?php

require_once __DIR__ . '/bootstrap.php';

$dataDir = __DIR__ . '/data';
$basePath = 'http://localhost/gaufrette/';

@\Nette\Utils\FileSystem::delete($dataDir);
@\Nette\Utils\FileSystem::createDir($dataDir);

$adapter = new \Echo511\Gaufrette\Adapter\Local($dataDir, $basePath);
$filesystem = new \Echo511\Gaufrette\Filesystem($adapter);

///// Write a file and check existence, data
$key = '/library/movies/movie.nfo';
$data = 'The Rush (2013)';
$filesystem->write($key, $data);
\Tester\Assert::true($filesystem->has($key));
\Tester\Assert::equal($data, $filesystem->read($key));

///// Get subsystem
\Tester\Assert::true($filesystem->getSubsystem('/library')->has('/movies/movie.nfo'));
\Tester\Assert::true($filesystem->getSubsystem('/library')->getSubsystem('/movies')->has('movie.nfo'));

///// Check expected url
$expectedUrl = rtrim($basePath, '/') . '/' . ltrim($key, '/');
\Tester\Assert::equal($expectedUrl, $filesystem->getUrl($key));
\Tester\Assert::equal($expectedUrl, $filesystem->getSubsystem('/library')->getUrl('/movies/movie.nfo'));

///// Move a file
$tmpKey = '/tmpFile';
$tmpData = 'tmpData';
$targetKey = '/library/uploaded/file.nfo';
$filesystem->write($tmpKey, $tmpData);
$filesystem->move($targetKey, $dataDir . $tmpKey);
\Tester\Assert::true($filesystem->has($targetKey));

@\Nette\Utils\FileSystem::delete($dataDir);
