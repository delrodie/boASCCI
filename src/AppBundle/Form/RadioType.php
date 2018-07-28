<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RadioType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lien', TextType::class, array(
                'attr'  => array(
                    'class' => 'form-control',
                    'autocomplete'  => 'off',
                    'placeholder'   => 'Coller le lien ici'
                ),
                'required' => true,
            ))
            ->add('statut')
            ->add('imageFile', VichImageType::class, array(
                'required' => false,
                'allow_delete' => true,
                'label' => 'Photo de couverture'
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Radio'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_radio';
    }


}
