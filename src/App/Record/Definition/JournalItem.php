<?php

namespace App\Record\Definition;

/**
 * Autogenerated. Do not modify. Modify SQL table, then generate with \PHPFUI\ORM\Tool\Generate\CRUD class.
 *
 * @property ?string $body MySQL type mediumtext
 * @property int $journalItemId MySQL type int
 * @property \App\Record\JournalItem $journalItem related record
 * @property ?int $memberId MySQL type int
 * @property \App\Record\Member $member related record
 * @property string $timeSent MySQL type datetime
 * @property ?string $title MySQL type char(100)
 */
abstract class JournalItem extends \PHPFUI\ORM\Record
	{
	protected static bool $autoIncrement = true;

	/** @var array<string, array<mixed>> */
	protected static array $fields = [
		// MYSQL_TYPE, PHP_TYPE, LENGTH, ALLOWS_NULL, DEFAULT
		'body' => ['mediumtext', 'string', 16777215, true, ],
		'journalItemId' => ['int', 'int', 0, false, ],
		'memberId' => ['int', 'int', 0, true, ],
		'timeSent' => ['datetime', 'string', 20, false, null, ],
		'title' => ['char(100)', 'string', 100, true, ],
	];

	/** @var array<string> */
	protected static array $primaryKeys = ['journalItemId', ];

	protected static string $table = 'journalItem';
	}
