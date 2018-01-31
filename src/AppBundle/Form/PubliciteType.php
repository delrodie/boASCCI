<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Vich\UploaderBundle\Form\Type\VichImageType;

class PubliciteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, array(
                'attr'  => array(
                    'class' => 'form-control',
                    'autocomplete'  => 'off',
                )
          ))
            ->add('datedeb', TextType::class, array(
                'attr'  => array(
                    'class' => 'form-control',
                    'autocomplete'  => 'off',
                )
          ))
            ->add('datefin', TextType::class, array(
                'attr'  => array(
                    'class' => 'form-control',
                    'autocomplete'  => 'off',
                )
          ))
            ->add('statut')
            ->add('imageFile', VichImageType::class, array(
                'required' => false,
                'allow_delete' => true,
            ))
            ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Publicite'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_publicite';
    }


}
