<?php

namespace App\Record\Validation;

/**
 * Autogenerated. File will not be changed by oneOffScripts\generateValidators.php.  Delete and rerun if you want.
 */
class ReservationPerson extends \PHPFUI\ORM\Validator
	{
	/** @var array<string, string[]> */
	public static array $validators = [
		'comments' => ['required', 'maxlength'],
		'email' => ['maxlength'],
		'eventId' => ['integer'],
		'firstName' => ['maxlength'],
		'lastName' => ['maxlength'],
		'reservationId' => ['integer'],
		'reservationPersonId' => ['integer'],
	];
	}
