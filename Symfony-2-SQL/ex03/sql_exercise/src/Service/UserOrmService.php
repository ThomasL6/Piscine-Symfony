<?php

namespace App\Service;

use App\Entity\UserOrm;
use Doctrine\ORM\EntityManagerInterface;

class UserOrmService
{
	private EntityManagerInterface $entityManager;

	public function __construct(
		EntityManagerInterface $entityManager
	)
	{
		$this->entityManager = $entityManager;
	}

	public function save(UserOrm $user): bool
	{
		$existingUser = $this->entityManager
			->getRepository(UserOrm::class)
			->findOneBy([
				'username' => $user->getUsername(),
			]);

		$existingEmail = $this->entityManager
			->getRepository(UserOrm::class)
			->findOneBy([
				'email' => $user->getEmail(),
			]);

		if ($existingUser || $existingEmail)
		{
			return false;
		}

		$this->entityManager->persist($user);
		$this->entityManager->flush();

		return true;
	}

	public function getAll(): array
	{
		return $this->entityManager
			->getRepository(UserOrm::class)
			->findAll();
	}
}