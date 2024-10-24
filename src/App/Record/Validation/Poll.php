<?php

namespace App\Record\Validation;

/**
 * Autogenerated. File will not be changed by oneOffScripts\generateValidators.php.  Delete and rerun if you want.
 */
class Poll extends \PHPFUI\ORM\Validator
	{
	/** @var array<string, string[]> */
	public static array $validators = [
		'emailConfirmation' => ['integer'],
		'endDate' => ['required', 'date', 'gte_field:startDate'],
		'memberId' => ['integer'],
		'membershipOnly' => ['integer'],
		'pollId' => ['integer'],
		'question' => ['maxlength'],
		'required' => ['integer'],
		'startDate' => ['required', 'date', 'lte_field:endDate'],
		'storyId' => ['integer'],
	];
	}
