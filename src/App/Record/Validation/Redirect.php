<?php

namespace App\Record\Validation;

/**
 * Autogenerated. File will not be changed by oneOffScripts\generateValidators.php.  Delete and rerun if you want.
 */
class Redirect extends \PHPFUI\ORM\Validator
	{
	/** @var array<string, string[]> */
	public static array $validators = [
		'originalUrl' => ['required', 'maxlength', '!starts_with:/'],
		'redirectUrl' => ['required', 'maxlength', '!starts_with:/'],
	];
	}
