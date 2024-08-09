<?php

namespace App\View\System;

class ReCAPTCHA
	{
	public function __construct(private readonly \PHPFUI\Page $page)
		{
		}

	public function edit() : \PHPFUI\Form
		{
		$submit = new \PHPFUI\Submit();
		$settingsSaver = new \App\Model\SettingsSaver();
		$form = new \PHPFUI\Form($this->page, $submit);
		$fieldSet = new \PHPFUI\FieldSet('Google ReCAPTCHA Keys');
		$link = new \PHPFUI\Link('https://www.google.com/recaptcha', 'here');
		$fieldSet->add("<b>Google ReCAPTCHA</b> is a free service to help avoid robots from filling out forms. You can get a free account {$link}.");

		$fields = [];
		$fields['ReCAPTCHAPublicKey'] = 'Site Key (leave blank to turn off)';
		$fields['ReCAPTCHAPrivateKey'] = 'Secret Key';

		$versions = ['V2', ]; // 'V3'];

		foreach ($versions as $version)
			{
			$versionFieldSet = new \PHPFUI\FieldSet('ReCAPTCHA ' . $version);

			if ('V2' == $version) // @phpstan-ignore if.alwaysTrue
				{
				$version = '';
				}

			foreach ($fields as $name => $text)
				{
				$versionFieldSet->add($settingsSaver->generateField($name . $version, $text, 'text', false));
				}
			$fieldSet->add($versionFieldSet);
			}
		$form->add($fieldSet);

		if ($form->isMyCallback())
			{
			$settingsSaver->save($_POST);
			$this->page->setResponse('Saved');
			}
		else
			{
			$form->add(new \App\UI\CancelButtonGroup($submit));
			}

		return $form;
		}
	}
