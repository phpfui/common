<?php

namespace App\Record\Validation;

class OauthToken extends \PHPFUI\ORM\Validator
	{
	/** @var array<string, array<string>> */
	public static array $validators = [
		'client' => ['maxlength'],
		'expires' => ['required', 'datetime'],
		'oauthUserId' => ['integer'],
		'scopes' => ['maxlength'],
		'token' => ['maxlength'],
	];

	public function __construct(\App\Record\OauthToken $record)
		{
		parent::__construct($record);
		}
	}
