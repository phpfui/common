<?php

namespace App\Record\Validation;

class Story extends \PHPFUI\ORM\Validator
	{
	/** @var array<string, array<string>> */
	public static array $validators = [
		'author' => ['maxlength'],
		'body' => ['maxlength'],
		'date' => ['date'],
		'endDate' => ['date', 'gte_field:startDate'],
		'headline' => ['maxlength'],
		'javaScript' => ['maxlength'],
		'lastEdited' => ['date'],
		'editorId' => ['integer'],
		'membersOnly' => ['integer'],
		'noTitle' => ['integer'],
		'onTop' => ['integer'],
		'showFull' => ['integer'],
		'startDate' => ['date', 'gte_field:date', 'lte_field:endDate'],
		'subhead' => ['maxlength'],
	];

	public function __construct(\App\Record\Story $record)
		{
		parent::__construct($record);
		}
	}
