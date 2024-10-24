<?php

namespace App\Record\Validation;

/**
 * Autogenerated. File will not be changed by oneOffScripts\generateValidators.php.  Delete and rerun if you want.
 */
class VolunteerJobShift extends \PHPFUI\ORM\Validator
	{
	/** @var array<string, string[]> */
	public static array $validators = [
		'email' => ['maxlength', 'email'],
		'jobId' => ['integer'],
		'jobShiftId' => ['integer'],
		'memberId' => ['required', 'integer'],
		'notes' => ['required', 'maxlength'],
		'shiftLeader' => ['integer'],
		'signedUpDate' => ['required', 'maxlength', 'datetime'],
		'volunteerJobShiftId' => ['integer'],
		'worked' => ['required', 'integer'],
	];
	}
