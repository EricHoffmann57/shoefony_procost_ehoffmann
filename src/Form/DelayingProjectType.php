<?php

namespace App\Form;

use App\Entity\Todo;
use App\Entity\Employee;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;


class DelayingProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        $builder
            ->add('devTime', IntegerType::class, ['label' => 'Development time'])
            ->add('employee', EntityType::class, [
                'class' => Employee::class,
                'label' => 'Employee',
                'choice_label' => function(?Employee $employee) {
                    $fullName = $employee->getId()  .". " .$employee->getFirstname() ." "  .$employee->getLastname();
                    return $employee ? $fullName  : '';
                }
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver):void
    {
        $resolver->setDefaults([
            'data_class' => Todo::class,
        ]);
    }
}