<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'label' => 'Your name',
                'attr' => ['placeholder' => 'name']
            ])
            ->add('firstname', null, [
                'label' => 'your firstname',
                'attr' => ['placeholder' => 'firstname']
            ])
            ->add('email', EmailType::class, [
                'label' => 'Your email',
                'attr' => ['placeholder' => 'email@email.com']
            ])
            ->add('picture', FileType::class, [
                'label' => 'Picture (jpeg, jpg, png file)'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Go !'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'attr' => ['novalidate' => 'novalidate'],
            'data_class' => User::class,
        ]);
    }
}
