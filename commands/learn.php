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
	function execute(request $request)
	{
		if(is_null(self::$ran))
			$this->setup(self::$bot->config->cacheDir);
		if(!is_null($request->msg))
		{
			$term = $request->explode(' ',utf8_encode($request->msg),array('term','msg'));
			if(array_key_exists('term',$term)
				&& array_key_exists('msg',$term)
				&& strlen(trim($term['msg'])) > 0)
			{
				self::$terms[$term['term']] = trim($term['msg']);
				$this->saveCache();
				self::reply($request,'/me is getting wiser',false);
			}
			else
				self::reply($request,'thats gibberish!');
		}
	}
	public static function callback(request $request)
	{
		$cmd = utf8_encode($request->cmd);
		if(array_key_exists($cmd,self::$terms))
			self::reply($request,self::$terms[$cmd]);
	}
	public function saveCache()
	{
		$fp = fopen(self::$file,"w");
		fwrite($fp,serialize(self::$terms));
		fclose($fp);
		unset($fp);
	}
	public function loadCache()
	{
		if(file_exists(self::$file))
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
