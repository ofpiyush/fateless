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
final class fateless
{
	public static $run = true;
	private static $lazyPaths = array();
	private static $resolver;
	private static $bot;
	private static $config;
	private static $log;
	private static $actions;

	private function __construct(){}
	
	public static function run()
	{
		require_once(FATELESS_BASEPATH.'config.php');
		self::$lazyPaths	= $lazyPaths;
		spl_autoload_register(array(__CLASS__, 'autoload' ));
		$config['actions']	= self:: $actions = array('join','part','ping','quit','mode');
		self::$config		= new config($config);
		self::$resolver		= new commandResolver();
		self::$bot			= new fatelessBot(self::$config);
		logger::setLogsDir(self::$config->logsDir);
		self::$log			= new logger();
		if(is_array($admins) && count($admins) > 0)
			foreach($admins as $admin)
				self::$bot->addAdmin($admin['nick'],$admin['user']);
		if(is_array($admins) && count($admins) > 0)
			foreach($admins as $admin)
				self::$bot->addAdmin($admin['nick'],$admin['user']);
		
		unset($config,$lazyPaths);
		do{
			self::handleRequest();
		}while(self::$run);
	}
	public static function handleRequest()
	{
		$request = new request(self::$bot->read());
		if( $request->action == 'privmsg'
			&& !is_null($request->cmd)
			&& !in_array($request->cmd,self::$actions) )
		{
			self::$resolver->getCommand($request->cmd)->execute($request, self::$bot);
		}
		elseif(!is_null($request->action) && in_array($request->action,self::$actions))
		{
			if(self::checkRequire($request->action,FATELESS_ENGINEPATH.'actions/'))
				self::$resolver->getCommand($request->action)->execute($request, self::$bot);
		}
		self::log($request);
		unset($request);
		flush();
	}
	public static function log($request)
	{
		if(!is_null($request->channel))
			self::$log->line($request->author['nick'].':'.$request->raw['msg'], $request->channel);
		elseif(!is_null($request->author)
			&& array_key_exists('user',$request->author)
			&& !in_array($request->author['nick'],array('NickServ',self::$config->nick)))
			self::$log->line($request->author['nick'].':'.$request->raw['msg'], $request->author['nick']);
		else
			self::$log->line($request->raw['msg']);
	}
	public static function autoload($class)
	{
		if(class_exists($class))
			return true;
		foreach(self::$lazyPaths as $path)
			if(self::checkRequire($class,$path))
				return true;
		return false;
	}
	public static function checkRequire($class,$path)
	{
		if(file_exists($path.$class.'.php'))
			{
				require_once($path.$class.'.php');
				return true;
			}
			return false;
	}
	public static function addLazyPath($path)
	{
		$path = rtrim(realpath($path),'/').'/';
		if($path!='/')
			self::$lazyPaths[]=$path;
		unset($path);
	}

}
