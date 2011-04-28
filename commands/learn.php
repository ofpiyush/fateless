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
class learn extends baseCommand
{
	public static $ran		= null;
	public static $terms	= array();
	public static $file	= null;
	function execute(request $request, fatelessBot $bot)
	{
		if(is_null(self::$ran))
			$this->setup($bot->config->cacheDir);
		if(!is_null($request->msg))
			$this->saveCache(utf8_encode($request->cmd),utf8_encode($request->msg));
	}
	public function callback(request $request,fatelessBot $bot)
	{
		$cmd = utf8_encode($request->cmd);
		if(array_key_exists($cmd,self::$terms))
			if(!is_null($request->channel))
				$bot->privmsg($request->channel,$request->author['nick'].' :'.self::$terms[$cmd]);
			elseif(!is_null($request->author) && array_key_exists('nick',$request->author))
				$bot->privmsg($request->author['nick'],self::$terms[$cmd]);
	}
	public function saveCache($term,$msg)
	{
		self::$terms[$term] = $msg;
		$fp = fopen(self::$file,"w");
		fwrite($fp,serialize(self::$terms));
		fclose($fp);
		unset($fp);
	}
	public function loadCache()
	{
		self::$terms = unserialize(file_get_contents(self::$file)); 
	}
	private function setup($dir)
	{
		$cmd = new defaultCommand();
		$cmd->addCallback(array($this,'callback'));
		self::$ran	= true;
		self::$file	= FATELESS_BASEPATH.$dir.'/learncache.txt';
		$this->loadCache();
	}
}
