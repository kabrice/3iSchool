<?php
/**
 * Created by IntelliJ IDEA.
 * User: MS
 * Date: 01/01/2017
 * Time: 13:05
 */

namespace AppBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titre');
        $builder->add('description');
        $builder->add('imageRoot');
        $builder->add('contenuRoot');
        $builder->add('imgB64');
        $builder->add('listeGroupes');
        $builder->add('listeNiveaux');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Contenu',
            'csrf_protection' => false
        ]);
    }
}