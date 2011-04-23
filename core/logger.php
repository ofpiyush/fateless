<?php

class logger
{
	private $dir;
	function __construct()
	{
		$this->dir = realpath(FATE_BASE'logs');
	}
}
