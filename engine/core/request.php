<?php
if ( ! defined('FATELESS_ENGINEPATH')) exit('No direct script access allowed');
/**
 * fateless
 * Copyright (C) 2010-2011  Piyush Mishra
 *
 * License:
 * This file is part of fateless (http://github.com/piyushmishra/fateless)
 * 
 * fateless is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * fateless is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with fateless.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package fateless
 * @author Piyush Mishra <me[at]piyushmishra[dot]com>
 * @license http://www.gnu.org/licenses/gpl.html
 * @copyright 2010-2011 Piyush Mishra
 */
class request
{
	var $author		= null;
	var $channel	= null;
	var $baseCmd	= null;
	var $cmd		= null;
	var $msg		= null;
	var $raw		= null;
	function __construct($string)
	{
		$parts = explode(':',$string);
		$this->raw['base'] = array_shift($parts);
		if(is_array($parts))
			$this->raw['msg'] = implode(':',$parts);
		unset($string,$parts);
		$this->processBase();
		if(array_key_exists('msg',$this->raw) && $this->baseCmd == 'PRIVMSG')
			$this->process($this->raw['msg']);
	}
	public function process($msg)
	{
		$parts = explode(" ",$msg);
		//if()
	}
	private function processBase()
	{
		$parts = explode(" ",$this->raw['base']);
		if($parts[0] == "PING")
		{
			$this->cmd = 'ping';
			return ;
		}
		$sender = array_shift($parts);
		
	}
}
