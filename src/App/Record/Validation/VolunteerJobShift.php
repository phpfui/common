<?php

namespace App\Record\Validation;

class VolunteerJobShift extends \PHPFUI\ORM\Validator
	{
	/** @var array<string, array<string>> */
	public static array $validators = [
		'email' => ['maxlength', 'email'],
		'jobId' => ['integer'],
		'jobShiftId' => ['integer'],
		'memberId' => ['required', 'integer'],
		'notes' => ['required', 'maxlength'],
		'shiftLeader' => ['integer'],
		'signedUpDate' => ['required', 'datetime'],
		'worked' => ['required', 'integer'],
	];

	public function __construct(\App\Record\VolunteerJobShift $record)
		{
		parent::__construct($record);
		}
	}
