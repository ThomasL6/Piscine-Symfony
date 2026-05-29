<?php

namespace App\Form;

use App\Entity\UserOrm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserOrmType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username')
            ->add('name')
            ->add('email')
            ->add('enabled')
            ->add('birthdate', null, [
                'widget' => 'single_text',
            ])
            ->add('address')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserOrm::class,
        ]);
    }
}
