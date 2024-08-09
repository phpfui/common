<?php

namespace App\Report;

/**
 * public functions
 *
 * sizeOfText($text, $larg)
 * addVendor($name, $address)
 * addDate($date)
 * addClient($ref)
 * addPageNumber($page)
 * addClientAddress($address)
 * addPaymentInfo($mode)
 * addDateOrdered($date)
 * addCols($tab)
 * addLineFormat($tab)
 * addLine($line, $tab)
 * addWatermark($text)
 */
class Invoice extends \FPDF
	{
	private int $angle = 0;

	/**
	 * @var array<string,int>
	 */
	private array $columns = [];

	/**
	 * @var array<string,string>
	 */
	private array $format = [];

	public function __construct()
		{
		parent::__construct('P', 'mm', 'Letter');
		}

	// private functions
	public function _endpage() : void
		{
		if (0 != $this->angle)
			{
			$this->angle = 0;
			$this->_out('Q');
			}
		parent::_endpage();
		}

	public function addClient(string $ref) : void
		{
		$this->addRoundedBox((int)\round($this->w) - 31, 17, 19, 'Client #', $ref);
		}

	public function addClientAddress(string $address) : void
		{
		$x = $this->w - 80;
		$y = 30;
		$this->SetXY($x, $y);
		$this->MultiCell(60, 4, \App\Tools\TextHelper::unhtmlentities($address));
		}

	/**
	 * @param array<string,int> $tab
	 */
	public function addCols(array $tab) : void
		{
		$x = 10;
		$width = $this->w - ($x * 2);
		$y = 100;
		$height = $this->h - 50 - $y;
		$this->SetXY($x, $y);
		$this->Rect($x, $y, $width, $height, 'D');
		$this->Line($x, $y + 6, $x + $width, $y + 6);
		$colX = $x;
		$this->columns = $tab;
		$i = 0;
		$this->SetFont('Arial', 'B', 10);

		foreach ($tab as $lib => $pos)
			{
			++$i;
			$this->SetXY($colX, $y + 2);
			$this->Cell($pos, 1, $lib, 0, 0, 'C');
			$colX += $pos;

			if ($i < \count($tab)) // don't print the last column line, off by a bit
				{
				$this->Line($colX, $y, $colX, $y + $height);
				}
			}
		}

	public function addDate(string $date) : void
		{
		$this->addRoundedBox((int)\round($this->w) - 61, 17, 30, 'Date Printed', $date);
		}

	// Mode of payment
	public function addDateOrdered(string $date) : void
		{
		$this->addRoundedBox(140, 70, 30, 'Date Ordered', $date);
		}

	public function addDateShipped(string $date) : void
		{
		$this->addRoundedBox(175, 70, 30, 'Date Shipped', $date);
		}

	// Mode of payment
	public function addInstructions(?string $text) : void
		{
		if (! $text)
			{
			return;
			}
		$this->addRoundedBox(10, 85, 196, 'Special Instructions', $text);
		}

	public function addInvoiceNumber(int $invoiceId) : void
		{
		$this->addRoundedBox((int)\round($this->w) - 80, 17, 19, 'Invoice #', (string)$invoiceId);
		}

	/**
	 * @param array<string,string> $tab
	 */
	public function addLine(int $line, array $tab) : int
		{
		$offset = 10;
		$maxSize = $line;
		\reset($this->columns);

		foreach ($this->columns as $lib => $pos)
			{
			$longCell = $pos - 2;
			$text = $tab[$lib];
			$formText = $this->format[$lib];
			$this->SetXY($offset, $line - 1);
			$this->MultiCell($longCell, 4, $text, 0, $formText);

			if ($maxSize < ($this->GetY()))
				{
				$maxSize = $this->GetY();
				}
			$offset += $pos;
			}

		return $maxSize - $line;
		}

	/**
	 * @param string[] $tab
	 */
	public function addLineFormat(array $tab) : void
		{
		/** @noinspection PhpUnusedLocalVariableInspection */
		foreach ($this->columns as $lib => $junk)
			{
			if (isset($tab[$lib]))
				{
				$this->format[$lib] = $tab[$lib];
				}
			}
		}

	public function addPaymentInfo(string $mode) : void
		{
		$this->addRoundedBox(10, 70, 125, 'Method Of Payment', $mode);
		}

	// add a line to the invoice/estimate
	public function addTotals(\App\Record\Invoice $invoice) : void
		{
		$x = (int)($this->w - 80);
		$width = $x + 70;
		$y = (int)($this->h - 47);
		$height = $y + 35;
		$this->RoundedRect($x, $y, ($width - $x), ($height - $y), 2.5, 'D');
		$y++;
		$this->SetXY($x, $y);
		$this->SetFont('Arial', 'B', 10);
		$this->Cell(50, 4, 'Total', 0, 0, 'L');
		$this->SetFont('Arial', '', 10);
		$this->Cell(20, 4, '$' . \number_format($invoice->totalPrice ?? 0.0, 2), 0, 0, 'R');
		$y += 4;
		$this->SetXY($x, $y);
		$this->SetFont('Arial', 'B', 10);
		$this->Cell(50, 4, 'Shipping', 0, 0, 'L');
		$this->SetFont('Arial', '', 10);
		$this->Cell(20, 4, '$' . \number_format($invoice->totalShipping ?? 0.0, 2), 0, 0, 'R');
		$y += 4;
		$this->SetXY($x, $y);
		$this->SetFont('Arial', 'B', 10);
		$this->Cell(50, 4, 'Tax', 0, 0, 'L');
		$this->SetFont('Arial', '', 10);
		$this->Cell(20, 4, '$' . \number_format($invoice->totalTax ?? 0, 2), 0, 0, 'R');
		$y += 4;
		$this->SetXY($x, $y);
		$this->SetFont('Arial', 'B', 10);
		$this->Cell(50, 4, 'Grand Total', 0, 0, 'L');
		$this->SetFont('Arial', '', 10);
		$this->Cell(20, 4, '$' . \number_format($invoice->total(), 2), 0, 0, 'R');
		$y += 4;
		$this->SetXY($x, $y);
		$this->SetFont('Arial', 'B', 10);
		$this->Cell(50, 4, 'Paid In Cash', 0, 0, 'L');
		$this->SetFont('Arial', '', 10);
		$this->Cell(20, 4, '$' . \number_format($invoice->paypalPaid ?? 0.0, 2), 0, 0, 'R');
		$y += 4;

		if ($invoice->pointsUsed)
			{
			$this->SetXY($x, $y);
			$this->SetFont('Arial', 'B', 10);
			$this->Cell(50, 4, 'Volunteer Points Redeemed', 0, 0, 'L');
			$this->SetFont('Arial', '', 10);
			$this->Cell(20, 4, '$' . \number_format($invoice->pointsUsed, 2), 0, 0, 'R');
			$y += 4;
			}

		if ($invoice->discount)
			{
			$this->SetXY($x, $y);
			$this->SetFont('Arial', 'B', 10);
			$this->Cell(50, 4, 'Discount', 0, 0, 'L');
			$this->SetFont('Arial', '', 10);
			$this->Cell(20, 4, '$' . \number_format($invoice->discount, 2), 0, 0, 'R');
			$y += 4;
			}

		$this->SetXY($x, $y);
		$this->SetFont('Arial', 'B', 10);
		$this->Cell(50, 4, 'Net Due', 0, 0, 'L');
		$this->SetFont('Arial', '', 10);
		$due = $invoice->unpaidBalance();

		if ($due <= 0.0)
			{
			$due = 0;
			$this->addWatermark('PAID IN FULL');
			}
		$this->Cell(20, 4, '$' . \number_format($due, 2), 0, 0, 'R');
		}

	public function addVendor(string $name, string $address, string $image = '') : void
		{
		$x1 = 10;
		$y = 8;
		$this->SetXY($x1, $y);

		if ($image && \file_exists($image) && ! \is_dir($image))
			{
			$info = \getimagesize($image);

			if (\is_array($info))
				{
				$width = $info[0];
				$height = $info[1];
				$maxWidth = 116;

				if ($width > $maxWidth)
					{
					$height = $height * $maxWidth / $width;
					$width = $maxWidth;
					}
				$maxHeight = 44;

				if ($height > $maxHeight)
					{
					$width = $width * $maxHeight / $height;
					$height = $maxHeight;
					}
				$this->Image($image, null, null, $width, $height);
				$y += $height + 2;
				$this->SetXY($x1, $y);
				}
			}
		$this->SetFont('Arial', 'B', 12);
		$length = $this->GetStringWidth($name);
		$this->Cell($length, 2, $name);
		$this->SetXY($x1, $y + 4);
		$this->SetFont('Arial', '', 10);
		$length = $this->GetStringWidth($address) + 1;
		$this->MultiCell($length, 4, $address);
		}

	public function addWatermark(string $text) : void
		{
		$this->SetFont('Arial', 'B', 70);
		$this->SetTextColor(203, 203, 203);
		$this->Rotate(45, 55, 190);
		$this->Text(55, 190, $text);
		$this->Rotate(0);
		$this->SetTextColor(0, 0, 0);
		$this->SetFont('Arial', '', 10);
		}

	public function sizeOfText(string $text, int $largeur) : float
		{
		$index = 0;
		$nb_lines = 0;
		$loop = true;

		while ($loop)
			{
			$pos = \strpos((string)$text, "\n");

			if (! $pos)
				{
				$loop = false;
				$line = $text;
				}
			else
				{
				$line = \substr((string)$text, $index, $pos);
				$text = \substr((string)$text, $pos + 1);
				}
			$length = \floor($this->GetStringWidth($line));
			$res = 1 + \floor($length / $largeur);
			$nb_lines += $res;
			}

		return $nb_lines;
		}

	// Company
	private function _Arc(float $x1, float $y, float $x2, float $y2, float $x3, float $y3) : void
		{
		$h = $this->h;
		$this->_out(\sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c ', $x1 * $this->k, ($h - $y) * $this->k, $x2 * $this->k, ($h - $y2) * $this->k, $x3 * $this->k, ($h - $y3) * $this->k));
		}

	private function addRoundedBox(?int $column, int $row, int $length, ?string $title, ?string $text) : void
		{
		$x = (int)$column;
		$width = $x + $length;
		$y = $row;
		$height = $y + 10;
		$mid = $y + (($height - $y) / 2);
		$this->RoundedRect($x, $y, ($width - $x), ($height - $y), 2.5, 'D');
		$this->Line($x, $mid, $width, $mid);
		$this->SetXY($x + ($width - $x) / 2 - 5, $y + 1);
		$this->SetFont('Arial', 'B', 10);
		$this->Cell(10, 4, $title ?? '', 0, 0, 'C');
		$this->SetXY($x + ($width - $x) / 2 - 5, $y + 5);
		$this->SetFont('Arial', '', 10);
		$this->Cell(10, 5, $text ?? '', 0, 0, 'C');
		}

	// add a watermark (temporary estimate, DUPLICATA...)
	// call this method first

	private function Rotate(int $angle, int $x = -1, int $y = -1) : void
		{
		if (-1 == $x)
			{
			$x = $this->x;
			}

		if (-1 == $y)
			{
			$y = $this->y;
			}

		if (0 != $this->angle)
			{
			$this->_out('Q');
			}
		$this->angle = $angle;

		if (0 != $angle)
			{
			$angle *= M_PI / 180;
			$c = \cos($angle);
			$s = \sin($angle);
			$cx = $x * $this->k;
			$cy = ($this->h - $y) * $this->k;
			$this->_out(\sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm', $c, $s, -$s, $c, $cx, $cy, -$cx, -$cy));
			}
		}

	// public functions
	private function RoundedRect(int $x, int $y, int $w, int $h, float $r, string $style = '') : void
		{
		$k = $this->k;
		$hp = $this->h;

		if ('F' == $style)
			{
			$op = 'f';
			}
		elseif ('FD' == $style || 'DF' == $style)
			{
			$op = 'B';
			}
		else
			{
			$op = 'S';
			}
		$MyArc = 4 / 3 * (\sqrt(2) - 1);
		$this->_out(\sprintf('%.2F %.2F m', ($x + $r) * $k, ($hp - $y) * $k));
		$xc = $x + $w - $r;
		$yc = $y + $r;
		$this->_out(\sprintf('%.2F %.2F l', $xc * $k, ($hp - $y) * $k));
		$this->_Arc($xc + $r * $MyArc, $yc - $r, $xc + $r, $yc - $r * $MyArc, $xc + $r, $yc);
		$xc = $x + $w - $r;
		$yc = $y + $h - $r;
		$this->_out(\sprintf('%.2F %.2F l', ($x + $w) * $k, ($hp - $yc) * $k));
		$this->_Arc($xc + $r, $yc + $r * $MyArc, $xc + $r * $MyArc, $yc + $r, $xc, $yc + $r);
		$xc = $x + $r;
		$yc = $y + $h - $r;
		$this->_out(\sprintf('%.2F %.2F l', $xc * $k, ($hp - ($y + $h)) * $k));
		$this->_Arc($xc - $r * $MyArc, $yc + $r, $xc - $r, $yc + $r * $MyArc, $xc - $r, $yc);
		$xc = $x + $r;
		$yc = $y + $r;
		$this->_out(\sprintf('%.2F %.2F l', ($x) * $k, ($hp - $yc) * $k));
		$this->_Arc($xc - $r, $yc - $r * $MyArc, $xc - $r * $MyArc, $yc - $r, $xc, $yc - $r);
		$this->_out($op);
		}
	}
