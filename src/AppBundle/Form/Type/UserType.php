<?php
/**
 * Created by IntelliJ IDEA.
 * User: Edgar
 * Date: 20/11/2016
 * Time: 11:19
 */

namespace AppBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('plainPassword');
        $builder->add('croppedDataUrl');
        $builder->add('gRecaptchaResponse');
        $builder->add('picFileName');
        $builder->add('nom');
        $builder->add('prenom');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\User',
            'csrf_protection' => false
        ]);
    }
}