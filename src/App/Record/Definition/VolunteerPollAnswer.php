<?php

namespace App\Record\Definition;

/**
 * Autogenerated. Do not modify. Modify SQL table, then generate with \PHPFUI\ORM\Tool\Generate\CRUD class.
 *
 * @property ?string $answer MySQL type varchar(100)
 * @property int $volunteerPollAnswerId MySQL type int
 * @property \App\Record\VolunteerPollAnswer $volunteerPollAnswer related record
 * @property int $volunteerPollId MySQL type int
 * @property \App\Record\VolunteerPoll $volunteerPoll related record
 */
abstract class VolunteerPollAnswer extends \PHPFUI\ORM\Record
	{
	protected static bool $autoIncrement = true;

	/** @var array<string, array<mixed>> */
	protected static array $fields = [
		// MYSQL_TYPE, PHP_TYPE, LENGTH, ALLOWS_NULL, DEFAULT
		'answer' => ['varchar(100)', 'string', 100, true, '', ],
		'volunteerPollAnswerId' => ['int', 'int', 0, false, ],
		'volunteerPollId' => ['int', 'int', 0, false, ],
	];

	/** @var array<string> */
	protected static array $primaryKeys = ['volunteerPollAnswerId', ];

	protected static string $table = 'volunteerPollAnswer';
	}
