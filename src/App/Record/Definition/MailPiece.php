<?php

namespace App\Record\Definition;

/**
 * Autogenerated. Do not modify. Modify SQL table, then generate with \PHPFUI\ORM\Tool\Generate\CRUD class.
 *
 * @property ?string $email MySQL type char(100)
 * @property int $mailItemId MySQL type int
 * @property \App\Record\MailItem $mailItem related record
 * @property int $mailPieceId MySQL type int
 * @property \App\Record\MailPiece $mailPiece related record
 * @property ?int $memberId MySQL type int
 * @property \App\Record\Member $member related record
 * @property ?string $name MySQL type varchar(100)
 */
abstract class MailPiece extends \PHPFUI\ORM\Record
	{
	protected static bool $autoIncrement = true;

	/** @var array<string, array<mixed>> */
	protected static array $fields = [
		// MYSQL_TYPE, PHP_TYPE, LENGTH, ALLOWS_NULL, DEFAULT
		'email' => ['char(100)', 'string', 100, true, ],
		'mailItemId' => ['int', 'int', 0, false, ],
		'mailPieceId' => ['int', 'int', 0, false, ],
		'memberId' => ['int', 'int', 0, true, ],
		'name' => ['varchar(100)', 'string', 100, true, '', ],
	];

	/** @var array<string> */
	protected static array $primaryKeys = ['mailPieceId', ];

	protected static string $table = 'mailPiece';
	}