<?php

namespace App\UI;

/**
 * A simple way to display static text in some kind of ordered
 * way
 */
class Display extends \PHPFUI\GridX
	{
	private ?\PHPFUI\HTML5Element $labelElement = null;

	private string $text;

	private ?\PHPFUI\HTML5Element $textElement = null;

	/**
	 * A Display has a label and text to display
	 *
	 * @param string $label shown to user
	 * @param string | int $text or value of the field
	 */
	public function __construct(private string $label, string | float | int | null $text)
		{
		$this->text = (string)$text;
		parent::__construct();
		}

	public function getLabelElement() : \PHPFUI\HTML5Element
		{
		if ($this->labelElement)
			{
			return $this->labelElement;
			}
		$this->labelElement = new \PHPFUI\HTML5Element('label');
		$this->labelElement->addClass('name');

		return $this->labelElement;
		}

	public function getTextElement() : \PHPFUI\HTML5Element
		{
		if ($this->textElement)
			{
			return $this->textElement;
			}
		$this->textElement = new \PHPFUI\HTML5Element('label');

		return $this->textElement;
		}

	protected function getBody() : string
		{
		if (! $this->text)
			{
			return '';
			}

		$this->addClass('left');
		$labelElement = $this->getLabelElement();
		$textElement = $this->getTextElement();
		$class = $this->getClass();
		$labelElement->addClass($class);
		$textElement->addClass($class);
		$textElement->add($this->text);
		$labelElement->add($this->getToolTip($this->label));

		return "<div class='small-4 columns'>" . $labelElement . '</div>' . $textElement;
		}
	}
