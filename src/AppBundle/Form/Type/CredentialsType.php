<?php
/**
 * Created by IntelliJ IDEA.
 * User: Edgar
 * Date: 20/11/2016
 * Time: 11:39
 */

namespace AppBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CredentialsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('login');
        $builder->add('password');
        $builder->add('gRecaptchaResponse');

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Credentials',
            'csrf_protection' => false
        ]);
    }
}