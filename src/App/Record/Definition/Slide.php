<?php

namespace App\Record\Definition;

/**
 * Autogenerated. Do not modify. Modify SQL table, then generate with \PHPFUI\ORM\Tool\Generate\CRUD class.
 *
 * @property string $added MySQL type datetime
 * @property ?string $caption MySQL type varchar(255)
 * @property ?string $extension MySQL type varchar(10)
 * @property ?int $memberId MySQL type int unsigned
 * @property \App\Record\Member $member related record
 * @property ?int $photoId MySQL type int
 * @property \App\Record\Photo $photo related record
 * @property int $sequence MySQL type int
 * @property int $showCaption MySQL type int
 * @property int $slideId MySQL type int
 * @property \App\Record\Slide $slide related record
 * @property int $slideShowId MySQL type int
 * @property \App\Record\SlideShow $slideShow related record
 * @property ?string $updated MySQL type datetime
 * @property ?string $url MySQL type varchar(255)
 */
abstract class Slide extends \PHPFUI\ORM\Record
	{
	protected static bool $autoIncrement = true;

	/** @var array<string, array<mixed>> */
	protected static array $fields = [
		// MYSQL_TYPE, PHP_TYPE, LENGTH, ALLOWS_NULL, DEFAULT
		'added' => ['datetime', 'string', 20, false, null, ],
		'caption' => ['varchar(255)', 'string', 255, true, ],
		'extension' => ['varchar(10)', 'string', 10, true, ],
		'memberId' => ['int unsigned', 'int', 0, true, ],
		'photoId' => ['int', 'int', 0, true, ],
		'sequence' => ['int', 'int', 0, false, 0, ],
		'showCaption' => ['int', 'int', 0, false, 1, ],
		'slideId' => ['int', 'int', 0, false, ],
		'slideShowId' => ['int', 'int', 0, false, ],
		'updated' => ['datetime', 'string', 20, true, ],
		'url' => ['varchar(255)', 'string', 255, true, '', ],
	];

	/** @var array<string> */
	protected static array $primaryKeys = ['slideId', ];

	protected static string $table = 'slide';
	}
