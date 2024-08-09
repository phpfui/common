<?php

namespace App\UI;

class Message implements \Stringable
	{
	public function __construct(protected string $name, protected string $title)
		{
		}

	public function __toString() : string
		{
		$settingTable = new \App\Table\Setting();
		$fieldSet = new \PHPFUI\FieldSet($this->title);
		$fieldSet->add($settingTable->value($this->name));

		return (string)$fieldSet;
		}
	}
