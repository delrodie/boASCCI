<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProduitType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle', TextType::class,[
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'le libelle du produit'
                ]
            ])
            ->add('description', TextareaType::class,[
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 5
                ]
            ])
            ->add('prix', TextType::class,[
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Le prix du produit'
                ]
            ])
            ->add('statut', CheckboxType::class,[
                'required' => false
            ])
            ->add('tag', TextType::class,[
                'attr' => [
                    'class' => 'form-control tag-input',
                    'data-role' => "tagsinput",
                ]
            ])
            ->add('imageFile', VichImageType::class, array(
                'required' => false,
                'allow_delete' => true,
                'label' => 'Image principale',
            ))
            //->add('imageName')->add('imageSize')->add('updatedAt')->add('imageName2')->add('imageSize2')->add('updatedAt2')->add('imageName3')->add('imageSize3')->add('updatedAt3')->add('imageName4')->add('imageSize4')->add('updatedAt4')->add('slug')->add('publiePar')->add('modifiePar')->add('publieLe')->add('modifieLe')
            ->add('categorie', null, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Produit'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_produit';
    }


}
