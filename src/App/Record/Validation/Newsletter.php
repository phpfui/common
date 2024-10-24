<?php

namespace App\Record\Validation;

/**
 * Autogenerated. File will not be changed by oneOffScripts\generateValidators.php.  Delete and rerun if you want.
 */
class Newsletter extends \PHPFUI\ORM\Validator
	{
	/** @var array<string, string[]> */
	public static array $validators = [
		'date' => ['required', 'maxlength', 'date'],
		'dateAdded' => ['required', 'maxlength', 'date'],
		'html' => ['maxlength'],
		'newsletterId' => ['integer'],
		'size' => ['integer'],
	];
	}
