<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Matter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('user')
            ->add('student', EntityType::class, [
                    'class' => User::class,
                    'multiple' => true,
                    'expanded' => true,
                    'choice_label' => 'fullname' ]);
            // ->add("Inscription", SubmitType::class, [
            //     'attr' => ['class' => 'save'],
            // ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Matter::class,
        ]);
    }
}
