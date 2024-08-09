<?php

namespace App\Table;

class Reservation extends \PHPFUI\ORM\Table
	{
	protected static string $className = '\\' . \App\Record\Reservation::class;

	public static function getEmails(int $eventId, int $unpaidOnly) : \PHPFUI\ORM\ArrayCursor
		{
		$sql = 'select coalesce(nullif(p.email,""),r.reservationemail) email,coalesce(p.firstName,r.reservationFirstName) firstName,coalesce(p.lastName,r.reservationLastName) lastName
			from reservation r
			left join reservationPerson p on p.reservationId=r.reservationId
			where r.eventId=?';

		if (1 == $unpaidOnly)
			{
			$sql .= ' and r.paymentId is not null';
			}
		elseif (2 == $unpaidOnly)
			{
			$sql .= ' and r.paymentId is null';
			}

		return \PHPFUI\ORM::getArrayCursor($sql, [$eventId]);
		}

	public function getLatestReservation() : \App\Record\Reservation
		{
		$this->addOrderBy('reservationId', 'desc');
		$this->setLimit(1);

		return $this->getRecordCursor()->current();
		}

	public function setReservationsCursor(\App\Record\Event $event) : static
		{
		$this->setWhere(new \PHPFUI\ORM\Condition('reservation.eventId', $event->eventId));
		$this->addJoin('reservationPerson');
		$this->addJoin('payment');

		return $this;
		}
	}
