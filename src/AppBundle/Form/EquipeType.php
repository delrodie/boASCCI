<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;

use Vich\UploaderBundle\Form\Type\VichImageType;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;

class EquipeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomcomplet', TextType::class, array(
                'attr'  => array(
                    'class' => 'form-control',
                    'autocomplete'  => 'off',
                )
          ))
            ->add('nom', TextType::class, array(
                'attr'  => array(
                    'class' => 'form-control',
                    'autocomplete'  => 'off',
                    'placeholder'  => 'Nom de famille et un seul prenom',
                )
          ))
            ->add('fonction', TextType::class, array(
                'attr'  => array(
                    'class' => 'form-control',
                    'autocomplete'  => 'off',
                )
            ))
            ->add('biographie', CKEditorType::class)
            ->add('tag', null, array(
                'attr'  => array(
                    'class' => 'form-control tag-input',
                    'data-role' => "tagsinput",
                )
            ))
            ->add('statut')
            ->add('cc', CheckboxType::class, array(
                'required'  => false,
            ))
            ->add('bn', CheckboxType::class, array(
                'required'  => false,
            ))
            ->add('cna', CheckboxType::class, array(
                'required'  => false,
            ))
            ->add('acn', CheckboxType::class, array(
                'required'  => false,
            ))
            ->add('si', CheckboxType::class, array(
                'required'  => false,
            ))
            ->add('lien')
            ->add('imageFile', VichImageType::class, array(
                'required' => false,
                'allow_delete' => true,
                'label' => 'Photo d\'identité du chef',
            ))
            //->add('imageName')->add('imageSize')->add('updatedAt')->add('slug')->add('publiePar')
            //->add('modifiePar')->add('publieLe')->add('modifieLe')
            ->add('departement', null, array(
                'attr'  => array(
                    'class' => 'form-control',
                )
          ))
            ->add('typefonction', null, array(
                'attr'  => array(
                    'class' => 'form-control',
                )
          ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Equipe'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_equipe';
    }


}
