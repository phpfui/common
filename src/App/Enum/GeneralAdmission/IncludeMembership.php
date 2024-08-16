<?php

namespace App\Enum\GeneralAdmission;

enum IncludeMembership : int
	{
	use \App\Enum\Name;

	case NO = 0;
	case NEW_MEMBERS_ONLY = 1;
	case EXTEND_MEMBERSHIP = 2;
	case RENEW_MEMBERSHIP = 3;
	}
