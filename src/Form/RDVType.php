<?php

namespace App\Form;

use App\Entity\RDV;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class RDVType extends AbstractType
{
    private $medecin;
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->medecin = $options['medecin'];
        $builder
            ->add('creneau')
            ->add('medecin', ChoiceType::class, ['choices' => $this->medecin, 'choice_label' => 'nom'])
            ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RDV::class,
            'medecin' => null
        ]);
        $resolver->setRequired('medecin');
    }
}
