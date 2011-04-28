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
	var $action		= null;
	var $cmd		= null;
	var $extra		= null;
	var $msg		= null;
	var $raw		= null;
	function __construct($string)
	{
		$this->raw = $this->explode(':',$string,array('base','msg'));
		$this->processBase();
		if(array_key_exists('msg',$this->raw) && in_array($this->action , array('privmsg','join','quit')))
			$this->process($this->raw['msg']);
	}
	public function setAuthor($user)
	{
		if(array_key_exists('nick',$user) && array_key_exists('user',$user))
			$this->author = $user;
	}
	public function process($msg)
	{
		$parts = $this->explode(" ",$msg,array('command','message'));
		if(array_key_exists('command',$parts) && $parts['command'][0] == '!')
		{
			$this->cmd = substr($parts['command'],1);
			if(array_key_exists('message',$parts))
				$this->msg = $parts['message'];
		}
		else
			$this->msg = $msg;
		unset($parts);
	}
	public function explode($exploder,$string,$keys)
	{
		$parts	= explode($exploder,$string);
		$return	= array();
		$last	= array_pop($keys);
		foreach($keys as $key)
		{
			if(is_array($parts))
				$return[$key] = array_shift($parts);
		}
		if(is_array($parts))
			$return[$last] = implode($exploder,$parts);
		unset($parts,$last);
		return $return;
	}
	private function processBase()
	{
		$parts = $this->explode(" ",$this->raw['base'],array('sender','action','receiver','extra'));
		if($parts['sender'] == "PING")
		{
			$this->action = "ping";
			return ;
		}
		$user = $this->explode('!',$parts['sender'],array('nick','user'));
		if(array_key_exists('nick',$user)
			&& array_key_exists('user',$user)
			&& substr($user['nick'],-12) != "freenode.net")
		{
			$this->author = $user;
			$this->action = strtolower($parts['action']);
			if(array_key_exists('receiver',$parts) && $parts['receiver'][0] == '#')
				$this->channel = $parts['receiver'];
			if(array_key_exists('extra',$parts))
				$this->extra = $parts['extra'];
			unset($parts,$user);
		}
		
	}
	

}
