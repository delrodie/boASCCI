<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Vich\UploaderBundle\Form\Type\VichImageType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PhotoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->galerie = $options['galerie'];
        $galerie = $this->galerie;
        $builder
            ->add('imageFile', VichImageType::class, array(
                'required' => false,
                'allow_delete' => true,
                'label' => 'Telecharger la photo',
            ))
            ->add('galerie', EntityType::class, array(
                    'attr'  => array(
                        'class' => 'form-control',
                        'autocomplete'  => 'off'
                    ),
                    'class' => 'AppBundle:Galerie',
                    'query_builder' =>  function(EntityRepository $er) use($galerie){
                        return $er->findGalerie($galerie);
                    },
                    'choice_label'  => 'titre',
                )
            )
          //->add('imageName')->add('imageSize')->add('updatedAt')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Photo',
            'galerie' => null,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_photo';
    }


}
