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
class fatelessBot {
	public $config;
	private static $socket;
	private $masters	= array();
	private $admins	= array();
	public function __construct(config $config)
	{
		$this->config	= $config;
		$this->connect();
		$this->login();
		$this->joinChannels($this->config->channels);
	}
	public function read()
	{
		$read = fgets(self::$socket, $this->config->readLength);
		return str_replace(array(chr(10), chr(13)), '', ltrim($read,':'));
	}
	public function write($cmd)
	{
		$this->send($cmd);
	}
	public function connect()
	{
		self::$socket = fsockopen($this->config->server, $this->config->port);
		$this->send(
			'USER '. $this->config->nick.' piyushmishra.com '.
			$this->config->nick.' : '.$this->config->name
			);
		$this->send('NICK '. $this->config->nick);
	}
	public function disconect()
	{
		fclose(self::$socket);
	}
	public function login()
	{
		if(!is_null($this->config->pass))
		{
			$this->privmsg('NickServ',' identify '.$this->config->pass);
			sleep(10);
		}
	}
	public function joinChannel($channel)
	{
		$this->send('JOIN :'. $channel);
	}
	public function addMaster($nick,$user)
	{
		$this->masters[$nick] = $user;
	}
	public function addAdmin($nick,$user)
	{
		$this->admins[$nick] = $user;
	}
	public function isAdmin($nick,$user)
	{
		return $this->isUser($nick,$user,'admins');
	}
	public function isMaster($nick,$user)
	{
		return $this->isUser($nick,$user,'masters');
	}
	public function privmsg($to, $msg)
	{
		$this->send('PRIVMSG '.$to.' :'.$msg);
	}
	private function joinChannels($channels)
	{
		if(is_array($channels))
			foreach($channels as $chan)
				$this->joinChannel($chan);
		elseif(strlen($channels))
			$this->joinChannel($channels);
	}
	private function isUser($nick,$user,$type)
	{
		return (array_key_exists($nick,$this->$type) && $this->{$type}[$nick] == $user);
	}
	private function send($cmd)
	{
		fputs(self::$socket, $cmd."\r\n");
	}
}
