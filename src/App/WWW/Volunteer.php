<?php

namespace App\WWW;

class Volunteer extends \App\View\WWWBase implements \PHPFUI\Interfaces\NanoClass
	{
	private readonly \PHPFUI\Button $volunteerPageButton;

	public function __construct(\PHPFUI\Interfaces\NanoController $controller)
		{
		parent::__construct($controller);
		$this->volunteerPageButton = new \PHPFUI\Button('Volunteer Page', '/Volunteer');
		}

	public function edit(\App\Record\JobEvent $jobEvent = new \App\Record\JobEvent()) : void
		{
		if ($this->page->addHeader('Volunteer Event Edit'))
			{
			if ($jobEvent->empty())
				{
				$this->page->redirect('/Volunteer/events');
				}
			$view = new \App\View\Volunteer\Event($this->page);
			$this->page->addPageContent($view->edit($jobEvent));
			}
		}

	public function editShift(\App\Record\Job $job = new \App\Record\Job()) : void
		{
		if ($this->page->addHeader('Job Shifts'))
			{
			$view = new \App\View\Volunteer\JobShifts($this->page);
			$this->page->addPageContent($view->output($job));
			}
		}

	public function editVolunteers(\App\Record\Job $job = new \App\Record\Job()) : void
		{
		if ($this->page->addHeader($text = 'Job Volunteers'))
			{
			$this->page->addPageContent(new \App\View\Volunteer\AssignedShifts($this->page, $job));
			}
		}

	public function emailAll(\App\Record\JobEvent $jobEvent = new \App\Record\JobEvent()) : void
		{
		if ($this->page->addHeader('Email All Volunteers'))
			{
			$email = new \App\View\Volunteer\Email($this->page);
			$this->page->addPageContent($email->allVolunteers($jobEvent));
			}
		}

	public function emailShift(\App\Record\Job $job = new \App\Record\Job()) : void
		{
		$vjs = new \App\Table\VolunteerJobShift();

		if ($this->page->addHeader('Email Job Volunteers', '', $vjs->isShiftLeader($job, \App\Model\Session::signedInMemberRecord())))
			{
			$email = new \App\View\Volunteer\Email($this->page);
			$this->page->addPageContent($email->job($job));
			}
		}

	public function events(int $year = 0) : void
		{
		if ($this->page->addHeader('Volunteer Events'))
			{
			$jobEventTable = new \App\Table\JobEvent();
			$oldest = $jobEventTable->getOldest();
			$earliest = (int)\App\Tools\Date::year(\App\Tools\Date::fromString($oldest['date'] ?? \App\Tools\Date::todayString()));

			$latest = $jobEventTable->getLatest();
			$current = (int)\App\Tools\Date::year(\App\Tools\Date::fromString($latest['date'] ?? \App\Tools\Date::todayString()));

			if (! $year)
				{
				$year = (int)\App\Tools\Date::year(\App\Tools\Date::today());
				}
			$subnav = new \App\UI\YearSubNav($this->page->getBaseURL(), $year, $earliest, $current);
			$this->page->addPageContent($subnav);
			$view = new \App\View\Volunteer\Event($this->page);
			$condition = new \PHPFUI\ORM\Condition('date', "{$year}-01-01", new \PHPFUI\ORM\Operator\GreaterThanEqual());
			$condition->and(new \PHPFUI\ORM\Condition('date', "{$year}-12-31", new \PHPFUI\ORM\Operator\LessThanEqual()));
			$jobEventTable->setWhere($condition);
			$this->page->addPageContent($view->list($jobEventTable));
			}
		}

	public function historyReport() : void
		{
		if ($this->page->addHeader('Volunteer History Report'))
			{
			if (isset($_POST['submit']) && 'Print' == $_POST['submit'] && \App\Model\Session::checkCSRF())
				{
				$report = new \App\Report\Volunteer($_POST);
				$report->generateVolunteerHistory();
				$this->page->done();
				}
			else
				{
				$view = new \App\View\Volunteer\Reports($this->page);
				$this->page->addPageContent($view->history());
				}
			}
		}

	public function jobEdit(\App\Record\Job $job = new \App\Record\Job()) : void
		{
		if ($this->page->addHeader('Edit A Job'))
			{
			$view = new \App\View\Volunteer\JobEdit($this->page);
			$this->page->addPageContent($view->output($job));
			}
		}

	public function jobs(\App\Record\JobEvent $jobEvent = new \App\Record\JobEvent()) : void
		{
		if ($this->page->addHeader('Jobs For Event'))
			{
			$view = new \App\View\Volunteer\Jobs($this->page);
			$this->page->addPageContent($view->list($jobEvent));
			}
		}

	public function myInfo() : void
		{
		$view = new \App\View\Member($this->page);
		$this->page->addPageContent($view->edit(\App\Model\Session::signedInMemberRecord()));
		}

	public function myJobs() : void
		{
		if ($this->page->addHeader('My Assignments'))
			{
			$volunteerJobShiftTable = new \App\Table\VolunteerJobShift();
			$view = new \App\View\Volunteer\JobShifts($this->page);
			$jobs = $volunteerJobShiftTable->getJobsForMember(\App\Model\Session::signedInMemberId());
			$hr = '';

			foreach ($jobs as $job)
				{
				$this->page->addPageContent($hr);
				$hr = '<hr>';
				$this->page->addPageContent($view->showJobShiftsFor(new \App\Record\Job($job['jobId']), new \App\Record\Member(\App\Model\Session::signedInMemberId())));
				}

			if (! \count($jobs))
				{
				$this->page->addPageContent(new \PHPFUI\Header('You have no assignments yet.', 4));
				$this->page->addPageContent(new \PHPFUI\Button('Sign up for one!', '/Volunteer/pickAJob'));
				}
			}
		}

	public function myPoints(\App\Record\Member $member = new \App\Record\Member(), int $year = 0) : void
		{
		if ($member->empty() || ! $this->page->isAuthorized('Outstanding Volunteer Points'))
			{
			$member = new \App\Record\Member(\App\Model\Session::signedInMemberId());
			}

		if ($this->page->addHeader('My Points'))
			{
			$view = new \App\View\Volunteer\Points($this->page);
			$this->page->addPageContent($view->display($member, $year));
			}
		}

	public function pickAJob(\App\Record\JobEvent $jobEvent = new \App\Record\JobEvent()) : void
		{
		if ($this->page->addHeader('Sign Up For A Job'))
			{
			$view = new \App\View\Volunteer\Volunteer($this->page);
			$this->page->addPageContent($view->output($jobEvent));
			$this->page->addPageContent($this->volunteerPageButton);
			}
		}

	public function pointHistory() : void
		{
		if ($this->page->addHeader('Point History'))
			{
			$view = new \App\View\Volunteer\Points($this->page);
			$this->page->addPageContent($view->searchHistory());
			}
		}

	public function points() : void
		{
		if ($this->page->addHeader('Outstanding Volunteer Points'))
			{
			if (isset($_POST['submit']) && \App\Model\Session::checkCSRF())
				{
				$report = new \App\Report\Finance();
				$report->downloadPoints($_POST);
				$this->page->done();
				}
			else
				{
				$view = new \App\View\Leader\Points($this->page);
				$this->page->addPageContent($view->Finance());
				}
			}
		}

	public function pointsDetail() : void
		{
		$memberId = $_GET['memberId'] ?? 0;

		if ($memberId != \App\Model\Session::signedInMemberId() || ! $this->page->isAuthorized('Outstanding Volunteer Points'))
			{
			$memberId = \App\Model\Session::signedInMemberId();
			}

		if ((int)($_GET['pointsAwarded'] ?? 0) > 0)
			{
			$callout = new \PHPFUI\Callout('success');
			$callout->add("Points {$_GET['pointsAwarded']} credited");
			}
		else
			{
			$callout = new \PHPFUI\Callout('warning');

			switch($_GET['table'] ?? '')
				{
				case \App\Table\SigninSheet::class:

					$callout->add('The Sign In Sheet has not been approved yet');

					break;

				case \App\Table\CueSheet::class:

					$callout->add('The Cue Sheet has not been approved yet');

					break;

				case \App\Table\VolunteerPoint::class:

					$callout->add('Shift was not marked as worked');

					break;

				case \App\Table\AssistantLeader::class:
				case \App\Table\Ride::class:

					$ride = new \App\Record\Ride($_GET['rideId'] ?? 0);

					if ($ride->loaded())
						{
						$model = new \App\Model\Volunteer();
						$assistantLeaders = $ride->assistantLeaders;
						$error = $model->validateRide($ride, $assistantLeaders);

						if ($error)
							{
							$callout->add($error);
							}
						}
					else
						{
						$callout->add('Ride not found');
						}

					break;

				default:
					$callout->add("Table {$_GET['table']} not found");
				}
			}
		$this->page->setRawResponse($callout, false);
		}

	public function pointsReport() : void
		{
		if ($this->page->addHeader($title = 'Volunteer Points Report'))
			{
			if (isset($_POST['submit']) && 'Download' == $_POST['submit'] && \App\Model\Session::checkCSRF())
				{
				$report = new \App\Report\Leader($title);
				$report->generatePoints($_POST);
				$this->page->done();
				}
			else
				{
				$view = new \App\View\Leader\Points($this->page);
				$this->page->addPageContent($view->reportSettings());
				}
			}
		}

	public function pointsSettings() : void
		{
		if ($this->page->addHeader($title = 'Volunteer Points Settings'))
			{
			$view = new \App\View\Leader\Points($this->page);
			$this->page->addPageContent($view->pointSettings());
			}
		}

	public function pollEdit(\App\Record\VolunteerPoll $volunteerPoll = new \App\Record\VolunteerPoll()) : void
		{
		if ($this->page->addHeader($text = 'Edit A Poll'))
			{
			$view = new \App\View\Volunteer\PollEdit($this->page);
			$this->page->addPageContent($view->output($volunteerPoll));
			}
		}

	public function polls(\App\Record\JobEvent $jobEvent = new \App\Record\JobEvent()) : void
		{
		if ($this->page->addHeader($text = 'Polls For Event'))
			{
			$this->page->addPageContent(new \App\View\Volunteer\Polls($this->page, $jobEvent));
			}
		}

	public function reports(\App\Record\JobEvent $jobEvent = new \App\Record\JobEvent()) : void
		{
		if ($this->page->addHeader('Volunteer Reports'))
			{
			if (isset($_POST['submit']) && \App\Model\Session::checkCSRF())
				{
				$report = new \App\Report\Volunteer($_POST);
				$report->generate($jobEvent);
				$this->page->done();
				}
			else
				{
				$view = new \App\View\Volunteer\Reports($this->page);
				$this->page->addPageContent($view->show($jobEvent));
				}
			}
		}

	public function schedule(\App\Record\JobEvent $jobEvent = new \App\Record\JobEvent()) : void
		{
		if ($this->page->addHeader('Volunteer Schedule'))
			{
			$view = new \App\View\Volunteer\Schedule($this->page, $jobEvent);
			$this->page->addPageContent($view->schedule());
			}
		}

	public function signup(\App\Record\Job $job = new \App\Record\Job(), \App\Record\Member $member = new \App\Record\Member()) : void
		{
		if ($this->page->addHeader('Sign Up For A Job'))
			{
			$this->page->addPageContent(new \App\View\Volunteer\Signup($this->page, $job, $member));
			}
		}
	}
