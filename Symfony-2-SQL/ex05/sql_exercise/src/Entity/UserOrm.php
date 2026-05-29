<?php

namespace App\Entity;

use App\Repository\UserOrmRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserOrmRepository::class)]
class UserOrm
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column(length: 255, unique: true)]
	#[Assert\NotBlank(message: 'Username is required.')]
	private ?string $username = null;

	#[ORM\Column(length: 255)]
	#[Assert\NotBlank(message: 'Name is required.')]
	private ?string $name = null;

	#[ORM\Column(length: 255, unique: true)]
	#[Assert\NotBlank(message: 'Email is required.')]
	#[Assert\Email(message: 'Invalid email format.')]
	private ?string $email = null;

	#[ORM\Column]
	private ?bool $enabled = false;

	#[ORM\Column]
	#[Assert\NotBlank(message: 'Birthdate is required.')]
	private ?\DateTimeImmutable $birthdate = null;

	#[ORM\Column(type: Types::TEXT)]
	#[Assert\NotBlank(message: 'Address is required.')]
	private ?string $address = null;

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getUsername(): ?string
	{
		return $this->username;
	}

	public function setUsername(?string $username): static
	{
		$this->username = $username;

		return $this;
	}

	public function getName(): ?string
	{
		return $this->name;
	}

	public function setName(?string $name): static
	{
		$this->name = $name;

		return $this;
	}

	public function getEmail(): ?string
	{
		return $this->email;
	}

	public function setEmail(?string $email): static
	{
		$this->email = $email;

		return $this;
	}

	public function isEnabled(): ?bool
	{
		return $this->enabled;
	}

	public function setEnabled(?bool $enabled): static
	{
		$this->enabled = $enabled;

		return $this;
	}

	public function getBirthdate(): ?\DateTimeImmutable
	{
		return $this->birthdate;
	}

	public function setBirthdate(
		?\DateTimeImmutable $birthdate
	): static
	{
		$this->birthdate = $birthdate;

		return $this;
	}

	public function getAddress(): ?string
	{
		return $this->address;
	}

	public function setAddress(?string $address): static
	{
		$this->address = $address;

		return $this;
	}
}