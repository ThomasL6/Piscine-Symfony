<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class NotesType extends AbstractType
{
	public function buildForm(
		FormBuilderInterface $builder,
		array $options
	): void
	{
		$builder
			->add('message', TextareaType::class, [
				'constraints' => [
					new NotBlank()
				]
			])
			->add('timestamp', ChoiceType::class, [
				'choices' => [
					'Yes' => 'yes',
					'No' => 'no'
				]
			])
			->add('submit', SubmitType::class);
	}
}