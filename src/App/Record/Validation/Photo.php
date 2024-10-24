<?php

namespace App\Record\Validation;

/**
 * Autogenerated. File will not be changed by oneOffScripts\generateValidators.php.  Delete and rerun if you want.
 */
class Photo extends \PHPFUI\ORM\Validator
	{
	/** @var array<string, string[]> */
	public static array $validators = [
		'description' => ['maxlength'],
		'extension' => ['required', 'maxlength'],
		'folderId' => ['required', 'integer'],
		'memberId' => ['integer'],
		'photoId' => ['integer'],
		'public' => ['required', 'integer'],
		'taken' => ['maxlength', 'datetime'],
		'thumbnail' => ['required', 'integer'],
		'uploaded' => ['required', 'maxlength', 'datetime'],
	];
	}
