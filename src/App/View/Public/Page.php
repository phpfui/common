<?php

namespace App\View\Public;

class Page extends \App\View\Page implements \PHPFUI\Interfaces\NanoClass
	{
	use PageTrait;

	private readonly \App\View\Content $content;

	public function __construct(\PHPFUI\Interfaces\NanoController $controller)
		{
		parent::__construct($controller); // @phpstan-ignore argument.type
		$this->content = new \App\View\Content($this);
		$this->setPublic();
		}

	public function custom() : void
		{
		$url = \strtolower(\str_replace('/' . \App\Model\Session::csrf(), '', $this->getBaseUrl()));
		$publicPageTable = new \App\Table\PublicPage();
		$publicPageTable->setWhere(new \PHPFUI\ORM\Condition('url', $url . '%', new \PHPFUI\ORM\Operator\Like()));
		$publicPageCursor = $publicPageTable->getRecordCursor();

		if (! \count($publicPageCursor))
			{
			$this->addPageContent("Page {$url} is not defined");

			return;
			}

		$publicPage = $publicPageCursor->current();

		$this->setPublic(\App\Enum\Admin\PublicPageVisibility::MEMBER_ONLY != $publicPage->hidden);

		if ($publicPage->banner)
			{
			$this->addBanners();
			}

		if ($publicPage->header)
			{
			$this->addHeader($publicPage->name, banner:$publicPage->banner);
			}

		if ($publicPage->blog)
			{
			$this->addPageContent($this->content->getDisplayCategoryHTML($publicPage->name));
			}

		if ($method = $publicPage->method)
			{
			$this->addPageContent($this->{$method}());
			}

		if ($publicPage->blogAfter)
			{
			$this->addPageContent($this->content->getDisplayCategoryHTML($publicPage->blogAfter));
			}
		}

	public function emailBoardMember(\App\Record\BoardMember $boardMember = new \App\Record\BoardMember(), string $csrf = '') : void
		{
		$this->addBanners();

		if (! $boardMember->empty() && $csrf == \App\Model\Session::csrf())
			{
			$this->addPageContent(new \App\View\Email\Member($this, $boardMember->member, 'Board Member'));
			}
		else
			{
			$this->addPageContent(new \PHPFUI\Header('Contact Us'));
			$boardMemberTable = new \App\Table\BoardMember();
			$this->addPageContent(new \App\View\Public\ContactUs($this, $boardMemberTable->getBoardMembers()));
			}
		}

	public function getUniqueLink(\App\Record\PublicPage $publicPage) : string
		{
		$baseLink = $publicPage->url ?? '';

		if (\App\Enum\Admin\PublicPageVisibility::NO_OUTSIDE_LINKS == $publicPage->hidden)
			{
			return $baseLink . '/' . \App\Model\Session::csrf();
			}

		return $baseLink;
		}
	}
