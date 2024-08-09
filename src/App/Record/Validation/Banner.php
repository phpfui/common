<?php

namespace App\Record\Validation;

class Banner extends \PHPFUI\ORM\Validator
	{
	/** @var array<string, array<string>> */
	public static array $validators = [
		'css' => ['maxlength'],
		'description' => ['maxlength'],
		'endDate' => ['required', 'date', 'gte_field:startDate'],
		'fileNameExt' => ['maxlength'],
		'html' => ['maxlength'],
		'js' => ['maxlength'],
		'pending' => ['required', 'integer'],
		'startDate' => ['required', 'date', 'lte_field:endDate'],
		'url' => ['maxlength', 'website|istarts_with:/istarts_with:#', 'required'],
	];

	public function __construct(\App\Record\Banner $record)
		{
		parent::__construct($record);
		}
	}
