<?php

echo "Copy common repo into project\n";

$directory = $argv[1] ?? 'bicycleclubwebsite2023';

$iterator = new \RecursiveIteratorIterator(
	new \RecursiveDirectoryIterator(__DIR__ . '\\src', \RecursiveDirectoryIterator::SKIP_DOTS),
	\RecursiveIteratorIterator::SELF_FIRST
);

foreach ($iterator as $item)
	{
	$file = __DIR__ . '/../' . $directory . '/' . $iterator->getSubPathName();
	$file = \str_replace('\\', '/', $file);
	$file = \str_replace('//', '/', $file);

	if (! $item->isDir())
		{
		copy('src\\' . $iterator->getSubPathName(), $file);
		}
	}

