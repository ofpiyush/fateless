<?php
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
	private $socket;
	private $config;
	private $commands	= array();
	private $actions	= array();
	private $masters	= array();
	private function __construct($config,$logger)
	{
		$this->config	= $config;
		$this->log		= $logger;
	}
	public function addMaster($nick,$user)
	{
		$this->masters[$nick]=$user;
	}
	public function loop()
	{
		while(1)
		{
			
		}
	}
	public function connect()
	{
		$this->socket	= fsockopen($this->config->server, $this->config->port);
		$this->send(
			'USER '. $this->config->nick.' piyushmishra.com '.
			$this->config->nick.' : '.$this->config->name
			);
		$this->send('NICK '. $this->config->nick);
	}
	public function joinChannels()
	{
		if(count($this->config->channels))
			$this->join($this->config->channels);
	}
	public function login()
	{
		if(!is_null($this->config->pass))
		{
			$this->privmsg('nickserv',' identify '.$this->config->pass);
			sleep(10);
		}
	}
	private function privmsg($to, $msg)
	{
		$this->send('PRIVMSG '.$to.' :'.$msg);
	}
	private function join($channel)
	{
		if(is_array($channel))
			foreach($channel as $chan)
				$this->join($chan);
		else
			$this->send('JOIN '. $channel);
	}
	private function send($cmd) 
	{
		fputs($this->socket, $cmd."\r\n");
		$this->log->command($cmd);
	}
}
