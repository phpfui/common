<?php

namespace App\Record\Validation;

/**
 * Autogenerated. File will not be changed by oneOffScripts\generateValidators.php.  Delete and rerun if you want.
 */
class PhotoComment extends \PHPFUI\ORM\Validator
	{
	/** @var array<string, string[]> */
	public static array $validators = [
		'memberId' => ['required', 'integer'],
		'photoComment' => ['required', 'maxlength'],
		'photoCommentId' => ['integer'],
		'photoId' => ['required', 'integer'],
		'timestamp' => ['required', 'maxlength', 'datetime'],
	];
	}
