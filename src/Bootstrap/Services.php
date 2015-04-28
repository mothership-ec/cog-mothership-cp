<?php

namespace Message\Mothership\ControlPanel\Bootstrap;

use Message\Mothership\ControlPanel;

use Message\Cog\Bootstrap\ServicesInterface;

use Message\Cog\ValueObject\Collection;

class Services implements ServicesInterface
{
	public function registerServices($services)
	{
		$this->registerStatistics($services);

		$services->extend('form.factory.builder', function($factory, $c) {
			$factory->addExtension(new ControlPanel\ContextualHelp\Extension\ContextualHelpExtension);

			return $factory;
		});

		$services->extend('form.templates.twig', function($templates, $c) {
			$templates[] = 'Message:Mothership:ControlPanel::form:twig:form_div_layout';
			$templates[] = 'Message:Mothership:ControlPanel::form:twig:cp_ext_div_layout';

			return $templates;
		});

		$services->extend('form.templates.php', function($templates, $c) {
			$templates[] = '::form:twig:php';

			return $templates;
		});

		$services->extend('user.groups', function($groups) {
			$groups->add(new ControlPanel\UserGroup\SuperAdmin);

			return $groups;
		});

		$services->extend('form.extensions', function($extensions, $c) {
			$extensions[] = $c['form.cp_extension'];

			return $extensions;
		});

		$services['form.cp_extension'] = function($c) {
			return new ControlPanel\Form\ControlPanelExtension;
		};

		$services->extend('field.collection', function ($fields, $c) {
			$fields->add(new ControlPanel\FieldType\Richtext($c['markdown.parser']));

			return $fields;
		});

		$services->extend('templating.globals', function ($globals, $c) {
			$globals->set('md_parser', function($c) {
				return $c['markdown.parser'];
			});

			return $globals;
		});
	}

	public function registerStatistics($services)
	{
		$services['statistics'] = function($c) {
			return (new Collection)
				->setType('Message\\Mothership\\ControlPanel\\Statistic\\AbstractDataset')
				->setKey(function($item) {
					return $item->getName();
				});
		};

		$services['statistics.counter'] = $services->factory(function($c) {
			return new ControlPanel\Statistic\Counter($c['db.query']);
		});

		$services['statistics.counter.key'] = $services->factory(function($c) {
			return new ControlPanel\Statistic\KeyCounter($c['db.query']);
		});

		$services['statistics.range.date'] = $services->factory(function($c) {
			return new ControlPanel\Statistic\DateRange($c['db.query']);
		});
	}
}