<?php

namespace App\Record\Definition;

/**
 * Autogenerated. Do not modify. Modify SQL table, then generate with \PHPFUI\ORM\Tool\Generate\CRUD class.
 *
 * @property ?string $description MySQL type text
 * @property ?string $detailLine MySQL type char(100)
 * @property int $invoiceId MySQL type int
 * @property \App\Record\Invoice $invoice related record
 * @property ?float $price MySQL type decimal(5,2)
 * @property ?int $quantity MySQL type int
 * @property ?float $shipping MySQL type decimal(5,2)
 * @property int $storeItemDetailId MySQL type int
 * @property \App\Record\StoreItemDetail $storeItemDetail related record
 * @property int $storeItemId MySQL type int
 * @property \App\Record\StoreItem $storeItem related record
 * @property ?float $tax MySQL type decimal(7,2)
 * @property ?string $title MySQL type char(100)
 * @property int $type MySQL type int
 */
abstract class InvoiceItem extends \PHPFUI\ORM\Record
	{
	protected static bool $autoIncrement = false;

	/** @var array<string, array<mixed>> */
	protected static array $fields = [
		// MYSQL_TYPE, PHP_TYPE, LENGTH, ALLOWS_NULL, DEFAULT
		'description' => ['text', 'string', 65535, true, ],
		'detailLine' => ['char(100)', 'string', 100, true, ],
		'invoiceId' => ['int', 'int', 0, false, ],
		'price' => ['decimal(5,2)', 'float', 5, true, ],
		'quantity' => ['int', 'int', 0, true, ],
		'shipping' => ['decimal(5,2)', 'float', 5, true, ],
		'storeItemDetailId' => ['int', 'int', 0, false, ],
		'storeItemId' => ['int', 'int', 0, false, ],
		'tax' => ['decimal(7,2)', 'float', 7, true, ],
		'title' => ['char(100)', 'string', 100, true, ],
		'type' => ['int', 'int', 0, false, 0, ],
	];

	/** @var array<string> */
	protected static array $primaryKeys = ['invoiceId', 'storeItemId', 'storeItemDetailId', ];

	protected static string $table = 'invoiceItem';
	}