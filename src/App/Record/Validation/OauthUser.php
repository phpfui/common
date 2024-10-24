<?php

namespace App\Record\Validation;

/**
 * Autogenerated. File will not be changed by oneOffScripts\generateValidators.php.  Delete and rerun if you want.
 */
class OauthUser extends \PHPFUI\ORM\Validator
	{
	/** @var array<string, string[]> */
	public static array $validators = [
		'lastLogin' => ['maxlength', 'datetime'],
		'memberId' => ['required', 'integer'],
		'oauthUserId' => ['integer'],
		'password' => ['maxlength'],
		'permissions' => ['maxlength'],
		'userName' => ['maxlength', 'required'],
	];
	}
