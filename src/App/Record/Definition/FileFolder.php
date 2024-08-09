<?php

namespace App\Record\Definition;

/**
 * Autogenerated. Do not modify. Modify SQL table, then generate with \PHPFUI\ORM\Tool\Generate\CRUD class.
 *
 * @property string $folder MySQL type varchar(255)
 * @property int $folderId MySQL type int
 * @property ?int $parentFolderId MySQL type int
 * @property ?int $permissionId MySQL type int
 * @property \App\Record\Permission $permission related record
 */
abstract class FileFolder extends \PHPFUI\ORM\Record
	{
	protected static bool $autoIncrement = true;

	/** @var array<string, array<mixed>> */
	protected static array $fields = [
		// MYSQL_TYPE, PHP_TYPE, LENGTH, ALLOWS_NULL, DEFAULT
		'description' => ['varchar(255)', 'string', 255, false, '', ],
		'folderId' => ['int', 'int', 0, false, ],
		'parentFolderId' => ['int', 'int', 0, true, 0, ],
		'permissionId' => ['int', 'int', 0, true, ],
	];

	/** @var array<string> */
	protected static array $primaryKeys = ['folderId', ];

	protected static string $table = 'fileFolder';
	}