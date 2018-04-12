<?php

namespace PartageBundle\Form;


use Symfony\Bundle\FrameworkBundle\Tests\Fixtures\Validation\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ReclamationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
         //   ->add('reclameur',TextType::class)


            ->add('contenu',TextareaType::class)
            ->add('Valider',SubmitType::class)

            //->add('Modifier',SubmitType::class)

            //->add('email',EmailType::class)



            //->add('Send Message',SubmitType::class)
            ->setMethod('POST');

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PartageBundle\Entity\Reclamation'
        ));
    }

    /**
     * {@inheritdoc}
     */
    /*public function getBlockPrefix()
    {
        return 'tmbundle_reclamation';
    }

    public function getReclameur()
    {         return 'Mail';    }*/


}
