<?php

namespace App\Cron\Job;

class MemberNotices extends \App\Cron\BaseJob
	{
	public function getDescription() : string
		{
		return 'Send out member notices';
		}

	/** @param array<string, string> $parameters */
	public function run(array $parameters = []) : void
		{
		$memberNoticeTable = new \App\Table\MemberNotice();
		$whereCondition = new \PHPFUI\ORM\Condition('summary', 0, new \PHPFUI\ORM\Operator\GreaterThan());
		$memberNoticeTable->setWhere($whereCondition);

		$memberTable = new \App\Table\Member();
		$memberTable->addJoin('membership');

		foreach ($memberNoticeTable->getRecordCursor() as $notice)
			{
			$dayOffsets = \explode(',', $notice->dayOffsets);

			$summaryTable = new \PHPFUI\Table();
			$summaryTable->setHeaders(['Name', 'email', 'Date']);

			foreach ($dayOffsets as $days)
				{
				$dayInt = (int)$days;

				if ($dayInt == $days)	// eliminates non integers that evaluate to 0
					{
					// positive number is number of days after the date, so 1 means we look for yesterday (today - 1)
					// negative number is number of days before the date, so -1 we look for tomorrow (today + 1)
					// so reverse what the user gives us
					$dayInt = 0 - $dayInt;

					$startDate = \App\Tools\Date::todayString($dayInt);
					$endDate = \App\Tools\Date::todayString($dayInt + 1);

					if ('abandoned' == $notice->field)
						{
						$condition = new \PHPFUI\ORM\Condition('member.verifiedEmail', 9, new \PHPFUI\ORM\Operator\LessThan());
						$condition->and('member.verifiedEmail', 0, new \PHPFUI\ORM\Operator\GreaterThan());
						$condition->and('membership.expires', null, new \PHPFUI\ORM\Operator\IsNull());
						$condition->and('member.lastLogin', $startDate . ' 00:00:00', new \PHPFUI\ORM\Operator\GreaterThanEqual());
						$condition->and('member.lastLogin', $endDate . ' 00:00:00', new \PHPFUI\ORM\Operator\LessThan());
						}
					else
						{
						$condition = new \PHPFUI\ORM\Condition($notice->field, $startDate, new \PHPFUI\ORM\Operator\GreaterThanEqual());
						$condition->and($notice->field, $endDate, new \PHPFUI\ORM\Operator\LessThan());
						}
					$memberTable->setWhere($condition);

					foreach ($memberTable->getDataObjectCursor() as $member)
						{
						if ($member->emailAnnouncements || $notice->overridePreferences)
							{
							$memberRecord = new \App\Record\Member($member);

							if ($notice->summary < 3)
								{
								$email = new \App\Model\Email\Notice($notice, new \App\Model\Email\Member($memberRecord));
								$email->setToMember($memberRecord->toArray());
								$email->bulkSend();
								}

							if ($notice->summary > 1)
								{
								$summaryTable->addRow(['Name' => $memberRecord->fullName(), 'email' => $member->email, 'Date' => $member[$notice->field]]);
								}
							}
						}
					}
				}

			if (\count($summaryTable))
				{
				$summaryEmail = new \App\Tools\EMail();
				$summaryEmail->addToMember($notice->member->toArray());
				$summaryEmail->setBody($summaryTable);
				$summaryEmail->setSubject("Member Notification Summary for: {$notice->title}");
				$summaryEmail->setHtml();
				$summaryEmail->send();
				}
			}
		}

	public function willRun() : bool
		{
		return $this->controller->runAt(9, 30);
		}
	}
