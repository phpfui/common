<?php

namespace App\Model;

class DeleteRecord
	{
	/** @var ?callable */
	private $conditionalCallBack = null;

	private readonly \PHPFUI\AJAX $delete;

	/** @var array<string> */
	private array $primaryKeys;

	public function __construct(\PHPFUI\Interfaces\Page $page, \PHPFUI\Table $table, \PHPFUI\ORM\Table $dbTable, string $message = 'Are you sure you want to delete this row?')
		{
		$this->primaryKeys = $dbTable->getPrimaryKeys();
		$primaryKey = \implode('_', $this->primaryKeys);
		$functionName = 'delete_' . \ucfirst($primaryKey);
		$this->delete = new \PHPFUI\AJAX($functionName, $message);

		if (\PHPFUI\Session::checkCSRF() && ($_POST['action'] ?? '') == $functionName)
			{
			$record = $dbTable->getRecord();
			$values = \explode('_', $_POST[$primaryKey]);
			$record->setFrom(\array_combine($this->primaryKeys, $values));
			$record->delete();
			$page->setResponse($_POST[$primaryKey]);

			return;
			}

		$table->setRecordId($primaryKey);
		$this->delete->addFunction('success', '$("#' . $primaryKey . '-"+data.response).css("background-color","red").hide("fast").remove()');
		$page->addJavaScript($this->delete->getPageJS());
		}

	/**
	 * @param array<string,mixed> $row
	 */
	public function columnCallback(array $row) : string
		{
		if ($this->conditional($row))
			{
			$icon = new \PHPFUI\FAIcon('far', 'trash-alt', '#');
			$icon->addAttribute('onclick', $this->delete->execute($this->getPrimaryKeyValues($row)));

			return $icon;
			}

		return '';
		}

	public function setConditionalCallback(callable $callback) : static
		{
		$this->conditionalCallBack = $callback;

		return $this;
		}

	/**
	 * @param array<string,mixed> $row
	 */
	private function conditional(array $row) : bool
		{
		$cb = $this->conditionalCallBack;

		return $cb ? $cb($row) : true;
		}

	/**
	 * @param array<string,mixed> $row
	 *
	 * @return array<string,mixed> $row
	 */
	private function getPrimaryKeyValues(array $row) : array
		{
		$values = [];

		foreach ($this->primaryKeys as $key)
			{
			$values[$key] = $row[$key];
			}

		return [\implode('_', \array_keys($values)) => '"' . \implode('_', $values) . '"'];
		}
	}
