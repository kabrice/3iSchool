<?php
/**
 * Created by IntelliJ IDEA.
 * User: Edgar
 * Date: 19/11/2016
 * Time: 23:00
 */

namespace AppBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReponseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('libelle');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Reponse',
            'csrf_protection' => false
        ]);
    }
}