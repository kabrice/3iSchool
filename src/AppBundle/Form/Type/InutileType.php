<?php
/**
 * Created by IntelliJ IDEA.
 * User: Edgar
 * Date: 06/02/2017
 * Time: 21:40
 */

namespace AppBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InutileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('refID');
        $builder->add('userID');
        $builder->add('ref');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Inutile',
            'csrf_protection' => false
        ]);
    }
}