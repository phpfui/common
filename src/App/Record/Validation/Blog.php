<?php

namespace App\Record\Validation;

/**
 * Autogenerated. File will not be changed by oneOffScripts\generateValidators.php.  Delete and rerun if you want.
 */
class Blog extends \PHPFUI\ORM\Validator
	{
	/** @var array<string, string[]> */
	public static array $validators = [
		'blogId' => ['integer'],
		'count' => ['required', 'integer'],
		'name' => ['required', 'maxlength'],
	];
	}
