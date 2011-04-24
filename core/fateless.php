<?php
if ( ! defined('FATELESS_BASEPATH')) exit('No direct script access allowed');
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
	private static $lazyPaths = array();
	
	private function __construct(){}
	
	public static function run()
	{
		require_once(FATELESS_BASEPATH.'config.php');
		self::$lazyPaths = $lazyPaths;
		spl_autoload_register(array(__CLASS__, 'autoload' ));
		$bot = new fatelessBot(new config($config), new logger($config['logsDir']));
		unset($config,$lazyPaths);
		$bot->connect();
		$bot->login();
		$bot->joinChannels();
		$bot->loop();
	}
	
	public static function autoload($class)
	{
		if(class_exists($class))
			return ;
		foreach(self::$lazyPaths as $path)
			if(file_exists($path.$class.'.php'))
			{
				require_once($path.$class.'.php');
				return true;
			}
	}

	public static function addLazyPath($path)
	{
		$path = rtrim(realpath($path),'/').'/';
		if($path!='/')
			self::$lazyPaths[]=$path;
		unset($path);
	}

}
