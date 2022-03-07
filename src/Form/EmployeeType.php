<?php
namespace App\Form;

use App\Entity\Employee;
use App\Entity\Job;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Firstname',
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Lastname',
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
            ])
            ->add('job', EntityType::class, [
                'class' => Job::class,
                'label' => 'Job',
                'choice_label' => 'name'
            ])
            ->add('dailyCost', IntegerType::class, [
                'label' => 'Cost(€)'
            ])
            ->add('hiringDate', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employee::class,
        ]);
    }
}