<?php

namespace App\Record\Definition;

/**
 * Autogenerated. Do not modify. Modify SQL table, then generate with \PHPFUI\ORM\Tool\Generate\CRUD class.
 *
 * @property string $date MySQL type date
 * @property string $dateAdded MySQL type date
 * @property ?string $html MySQL type mediumtext
 * @property int $newsletterId MySQL type int
 * @property \App\Record\Newsletter $newsletter related record
 * @property ?int $size MySQL type int
 */
abstract class Newsletter extends \PHPFUI\ORM\Record
	{
	protected static bool $autoIncrement = true;

	/** @var array<string, array<mixed>> */
	protected static array $fields = [
		// MYSQL_TYPE, PHP_TYPE, LENGTH, ALLOWS_NULL, DEFAULT
		'date' => ['date', 'string', 10, false, ],
		'dateAdded' => ['date', 'string', 10, false, ],
		'html' => ['mediumtext', 'string', 16777215, true, ],
		'newsletterId' => ['int', 'int', 0, false, ],
		'size' => ['int', 'int', 0, true, ],
	];

	/** @var array<string> */
	protected static array $primaryKeys = ['newsletterId', ];

	protected static string $table = 'newsletter';
	}