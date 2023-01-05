<?php

namespace App\Form;

use App\Entity\Docteur;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Validator\Constraints\Regex;

class DocteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'constraints' =>
                [new Length(['min' => 4, 'minMessage' => "Le champ doit contenir au minimum 4 caractères"])]
            ])

            ->add('description')

            ->add('ville', TextType::class, [
                'constraints' =>
                [new Length(['min' => 4, 'minMessage' => "Le champ doit contenir au minimum 4 caractères"])]
            ])

            ->add('telephone', TelType::class, [
                'constraints' => [new Regex([
                    'pattern' => "/^[0-9]{10}$/",
                    "message" => "Il doit faire 10 caractères"
                ])]
            ])

            ->add('Ajouter', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Docteur::class,
        ]);
    }
}
