<?php

namespace App\Model;

/**
 * @property string $MembershipTerm
 * @property string $MembershipStartMonth
 * @property string $MembershipGraceMonth
 * @property string $MembershipType
 * @property string $PaidMembers
 * @property string $SubscriptionDues
 * @property string $MaxMembersOnMembership
 * @property string $MaxMembersSubscription
 * @property string $MaxRenewalYears
 * @property array $AnnualDues
 * @property array $AdditionalMemberDues
 * @property bool $disableDonations
 */
class MembershipDues
	{
	/** @var array<string,string|array<string|float>> */
	private array $fields = [
		'MembershipTerm' => '12 Months',
		'MembershipStartMonth' => '1',
		'MembershipGraceMonth' => '1',
		'MembershipType' => 'Manual',
		'PaidMembers' => 'Unlimited',
		'SubscriptionDues' => '0',
		'MaxMembersOnMembership' => '4',
		'MaxMembersSubscription' => '4',
		'MaxRenewalYears' => '9',
		'disableDonations' => false,
		'AnnualDues' => ['30'],
		'AdditionalMemberDues' => [],
	];

	private readonly \App\Table\Setting $settingTable;

	public function __construct(bool $load = true)
		{
		$this->settingTable = new \App\Table\Setting();

		if ($load)
			{
			$this->load();
			}
		}

	/**
	 * @return string | float | array<string|float> | null
	 */
	public function __get(string $field) : string | float | array | null
		{
		return $this->fields[$field] ?? null;
		}

	/**
	 * @param string | array<string|float> $value
	 */
	public function __set(string $field, string | array $value) : void
		{
		if (isset($this->fields[$field]))
			{
			$this->fields[$field] = $value;
			}
		}

	public function getAdditionalMemberPriceByYear(int $years) : float
		{
		$dues = $this->AdditionalMemberDues;

		// if no additional member dues, use normal member dues
		if (! \count($dues))
			{
			$dues = $this->AnnualDues;
			}

		$index = \min(\count($dues), $years) - 1;

		return (float)($dues[$index] ?? 0.0);
		}

	public function getAdditionalMembershipPrice(int $totalMembers, int $years = 1) : float
		{
		if ($years < 1)
			{
			return 0.0;
			}

		if ('Paid' == $this->PaidMembers)
			{
			if (--$totalMembers <= 0)
				{
				return 0.0;
				}
			}
		elseif ('Unlimited' == $this->PaidMembers)
			{
			return 0.0;
			}
		elseif ('Family' == $this->PaidMembers)
			{
			$totalMembers -= 2;

			if ($totalMembers <= 0)
				{
				return 0.0;
				}
			}
		$additionalMemberDues = $this->getAdditionalMemberPriceByYear($years);
		$price = $additionalMemberDues * $years * $totalMembers;

		return $price;
		}

	public function getMembershipPrice(int $totalMembers, int $years = 1) : float
		{
		if ($years < 1)
			{
			return 0.0;
			}

		if ('Paid' == $this->PaidMembers)
			{
			if ($this->getAdditionalMembershipPrice($totalMembers, $years))
				{
				$totalMembers = 1;
				}
			}
		elseif ('Unlimited' == $this->PaidMembers)
			{
			$totalMembers = 1;
			}
		elseif ('Family' == $this->PaidMembers)
			{
			$totalMembers = 1;
			}
		$duesPerYear = $this->getMembershipPriceByYear($years);

		$price = $duesPerYear * $years * $totalMembers;

		return $price;
		}

	public function getMembershipPriceByYear(int $years) : float
		{
		$dues = $this->AnnualDues;
		$index = \min(\count($dues), $years) - 1;

		return (float)($dues[$index] ?? 0.0);
		}

	public function getTotalMembershipPrice(int $totalMembers, int $years = 1) : float
		{
		return $this->getMembershipPrice($totalMembers, $years) + $this->getAdditionalMembershipPrice($totalMembers, $years);
		}

	public function load() : void
		{
		foreach ($this->fields as $field => $default)
			{
			$value = $this->settingTable->value($field) ?: $default;

			if (\is_array($default))
				{
				if ('[' != ($value[0] ?? ''))
					{
					$value = [$value];
					}
				else
					{
					$value = \json_decode($value);
					}
				}
			$this->fields[$field] = $value;
			}
		}

	/**
	 * @param array<string,string|array<float|string>> $post
	 */
	public function save(array $post) : void
		{
		foreach ($this->fields as $field => $default)
			{
			if (isset($post[$field]))
				{
				$data = $post[$field];

				if (\is_array($data))
					{
					foreach ($data as $index => $value)
						{
						if (empty($value))
							{
							$data = \array_slice($data, 0, $index);
							}
						}
					$data = \json_encode($data, JSON_THROW_ON_ERROR);
					}
				$this->settingTable->save($field, $data);
				}
			}
		}
	}
