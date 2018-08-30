<?php

namespace App\Form;

use App\Entity\MP3File;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Route;

class MP3FileType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {

      if($options ['modify_file'] == true )
      {
          $builder
          ->add('uploadedFile', FileType::class, array('label' => 'Adaugati un fisier mp3'));
      }
      else
          {
          $builder
          ->add('fullpath')
          ->add('basename');
      }

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MP3File::class,
            'modify_file'=>false
        ]);
    }

}
