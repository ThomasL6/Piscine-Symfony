<?php

class Coffee extends HotBeverage {
	
	private string $description;

	private string $comment;

	public function __construct() {
		parent::__construct("Coffee", 1.00, 0.5);
		$this->description = "A hot beverage made from roasted coffee beans.";
		$this->comment = "Rich and aromatic.";
	}

	public function getDescription(): string {
		return $this->description;
	}

	public function getComment(): string {
		return $this->comment;
	}

}