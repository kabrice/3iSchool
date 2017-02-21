<?php
/**
 * Created by IntelliJ IDEA.
 * User: Edgar
 * Date: 21/02/2017
 * Time: 05:08
 */

namespace AppBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VisiteContenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('dateVisite');
        $builder->add('duree');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\VisiteContenu',
            'csrf_protection' => false
        ]);
    }
}