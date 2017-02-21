<?php
/**
 * Created by IntelliJ IDEA.
 * User: Edgar
 * Date: 19/11/2016
 * Time: 04:51
 */

namespace AppBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('libelle');
        $builder->add('description');
        $builder->add('anonyme');
        $builder->add('nombreVu');
        $builder->add('page', IntegerType::class , array('required' => false));
        $builder->add('ligne', IntegerType::class , array('required' => false));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Question',
            'csrf_protection' => false
        ]);
    }
}