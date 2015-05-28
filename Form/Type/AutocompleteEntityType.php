<?php

namespace Sunsetlabs\EcommerceResourceBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityManager;
use Sunsetlabs\EcommerceResourceBundle\Form\DataTransformer\EntityToIdTransformer;

class AutocompleteEntityType extends AbstractType
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new EntityToIdTransformer($this->em, $options['class']);
        $builder->addViewTransformer($transformer);

    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['update_route'] = $options['update_route'];
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'required' => false
        ));
        $resolver->setRequired(array('class', 'update_route'));
    }

    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'autocomplete_entity';
    }
}