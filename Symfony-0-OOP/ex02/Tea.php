<?php

class Tea extends HotBeverage {
	private string $description;
	private string $comment;

	public function __construct() {
		parent::__construct("Tea", 0.75, 0.2);
		$this->description = "A soothing beverage made from steeped tea leaves.";
		$this->comment = "Perfect for relaxation.";
	}

	public function getDescription(): string {
		return $this->description;
	}

	public function getComment(): string {
		return $this->comment;
	}

}