<?php
/**
 * Created by IntelliJ IDEA.
 * User: Edgar
 * Date: 03/02/2017
 * Time: 20:07
 */

namespace AppBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserContenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nbreVue');
        $builder->add('aPublie');
        $builder->add('review');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\UserContenu',
            'csrf_protection' => false
        ]);
    }
}