<?php

namespace Message\Mothership\ControlPanel\ContextualHelp\Extension\Type;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\ValidatorInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Message\Cog\Validator\Extension\EventListener\ValidationListener;
use Message\Cog\HTTP\Session;

/**
 * @author Iris Schaffer <iris@message.co.uk>
 */
class ContextualHelpTypeExtension extends AbstractTypeExtension
{
	/**
	 * Adds the optional 'contextual_help'-option.
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setOptional(['contextual_help']);
	}

	/**
	 * Pass the 'contextual_help'-value to the view
	 *
	 * @param FormView $view
	 * @param FormInterface $form
	 * @param array $options
	 */
	public function buildView(FormView $view, FormInterface $form, array $options)
	{
		if (array_key_exists('contextual_help', $options)) {
			$view->vars['contextual_help'] = $options['contextual_help'];
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function getExtendedType()
	{
		return 'form';
	}
}
