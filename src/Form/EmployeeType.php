<?php
namespace App\Form;

use App\Entity\Employee;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
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
                'class' => Employee::class,
                'label' => 'Job',
            ])
            ->add('joined', DateType::class, array(
                'widget' => 'choice_label',
                'format' => 'dd/MM/yyyy',
                "required"=>true,
                'label' => "Hiring date"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employee::class,
        ]);
    }
}