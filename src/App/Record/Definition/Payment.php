<?php

namespace App\Record\Definition;

/**
 * Autogenerated. Do not modify. Modify SQL table, then generate with \PHPFUI\ORM\Tool\Generate\CRUD class.
 *
 * @property ?float $amount MySQL type decimal(6,2)
 * @property string $dateReceived MySQL type date
 * @property ?int $enteringMemberNumber MySQL type int
 * @property ?int $invoiceId MySQL type int
 * @property \App\Record\Invoice $invoice related record
 * @property ?int $membershipId MySQL type int
 * @property \App\Record\Membership $membership related record
 * @property ?string $paymentDated MySQL type date
 * @property int $paymentId MySQL type int
 * @property \App\Record\Payment $payment related record
 * @property ?string $paymentNumber MySQL type varchar(50)
 * @property ?int $paymentType MySQL type int
 */
abstract class Payment extends \PHPFUI\ORM\Record
	{
	protected static bool $autoIncrement = true;

	/** @var array<string, array<mixed>> */
	protected static array $fields = [
		// MYSQL_TYPE, PHP_TYPE, LENGTH, ALLOWS_NULL, DEFAULT
		'amount' => ['decimal(6,2)', 'float', 6, true, ],
		'dateReceived' => ['date', 'string', 10, false, ],
		'enteringMemberNumber' => ['int', 'int', 0, true, ],
		'invoiceId' => ['int', 'int', 0, true, 0, ],
		'membershipId' => ['int', 'int', 0, true, ],
		'paymentDated' => ['date', 'string', 10, true, ],
		'paymentId' => ['int', 'int', 0, false, ],
		'paymentNumber' => ['varchar(50)', 'string', 50, true, ],
		'paymentType' => ['int', 'int', 0, true, ],
	];

	/** @var array<string> */
	protected static array $primaryKeys = ['paymentId', ];

	protected static string $table = 'payment';
	}