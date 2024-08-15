<?php

echo "Delete matching files in common from project\n";

$iterator = new \RecursiveIteratorIterator(
	new \RecursiveDirectoryIterator(__DIR__ . '\\src', \RecursiveDirectoryIterator::SKIP_DOTS),
	\RecursiveIteratorIterator::SELF_FIRST
);

foreach ($iterator as $item)
	{
	$file = __DIR__ . '/../bicycleclubwebsite2023/' . $iterator->getSubPathName();
	$file = \str_replace('\\', '/', $file);
	$file = \str_replace('//', '/', $file);

	if (! $item->isDir())
		{
		unlink($file);
		}
	}

