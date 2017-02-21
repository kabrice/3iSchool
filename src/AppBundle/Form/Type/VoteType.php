<?php
/**
 * Created by IntelliJ IDEA.
 * User: Edgar
 * Date: 31/01/2017
 * Time: 09:30
 */

namespace AppBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('userID');
        $builder->add('ref');
        $builder->add('refID');
        $builder->add('valeur');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Vote',
            'csrf_protection' => false
        ]);
    }
}