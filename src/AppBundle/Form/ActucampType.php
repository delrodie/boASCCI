<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ActucampType extends AbstractType
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
            ->add('resume', null, array(
                'attr'  => array(
                    'class' => 'form-control',
                    'autocomplete'  => 'off',
                    //'placeholder' => 'Resumé de l\'article',
                    'rows' => '5'
                )
          ))
            ->add('contenu', CKEditorType::class)
            ->add('tag', null, array(
                'attr'  => array(
                    'class' => 'form-control tag-input',
                    'data-role' => "tagsinput",
                )
          ))
            ->add('statut')
            ->add('imageFile', VichImageType::class, array(
                  'required' => false,
                  'allow_delete' => true,
                  'label'   => 'Photo d\'illustration'
              ))
            //->add('imageName')->add('imageSize')->add('updatedAt')->add('slug')->add('publiePar')->add('modifiePar')->add('publieLe')->add('modifieLe')
            ->add('typerassemblement', null, array(
                'attr'  => array(
                    'class' => 'form-control',
                )
          ))
            ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Actucamp'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_actucamp';
    }


}
