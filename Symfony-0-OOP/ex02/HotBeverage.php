<?php

class HotBeverage
{
	private string $name;
	private float $price;
	private float $resistance;

	public function __construct(string $name, float $price, float $resistance)
	{
		$this->name = $name;
		$this->price = $price;
		$this->resistance = $resistance;
	}

	public function getName(): string
	{
		return $this->name;
	}
	public function getPrice(): float
	{
		return $this->price;
	}
	public function getResistance(): float
	{
		return $this->resistance;
	}
}