<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Vich\UploaderBundle\Form\Type\VichImageType;

class SliderType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type1', TextType::class, array(
                'attr'  => array(
                    'class' => 'form-control',
                    'autocomplete'  => 'off',
                )
          ))
            ->add('type2', TextType::class, array(
                'attr'  => array(
                    'class' => 'form-control',
                    'autocomplete'  => 'off',
                )
          ))
            ->add('legende', TextType::class, array(
                'attr'  => array(
                    'class' => 'form-control',
                    'autocomplete'  => 'off',
                )
          ))
            ->add('datedebut', TextType::class, array(
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
            //->add('imageName')->add('imageSize')->add('updatedAt')->add('slug')->add('publiePar')->add('modifiePar')->add('publieLe')->add('modifieLe')
            ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Slider'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_slider';
    }


}
