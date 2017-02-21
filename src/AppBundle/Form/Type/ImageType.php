<?php
/**
 * Created by IntelliJ IDEA.
 * User: Edgar
 * Date: 06/02/2017
 * Time: 17:19
 */

namespace AppBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('userID');
        $builder->add('name');
        $builder->add('imgB64');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Image',
            'csrf_protection' => false
        ]);
    }
}