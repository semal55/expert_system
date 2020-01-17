<?php

namespace App;

class State {

	public const HYPOTHESIS = 0;
	public const PRIOR = 1;
	public const NUMBER_OF_QUESTION = 2;
	public const PLUS = 3;
	public const MINUS = 4;

	private $state;

	public function __construct()
	{
		$this->state = self::HYPOTHESIS;
	}

	public function next() 
	{
		if ($this->state == self::MINUS) {
			$this->state = self::NUMBER_OF_QUESTION;
		} else {
			$this->state++;
		}
		return $this;
	}

	public function get()
	{
		return $this->state;
	}

	public function set($state)
	{
		$this->state = $state;
	}

	public function reset()
	{
		$this->state = self::HYPOTHESIS;
		return $this;
	}
}