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
final class fateless
{
	private static $lazyPaths=array();
	private function __construct(){}
	public static function run()
	{
		
		$bot = new fatelessBot(new config(), new logger());
		$bot->connect();
		$bot->login();
		$bot->joinChannels();
		$bot->loop();
	}
	public static function autoload($class)
	{
		if(class_exists($class))
			return ;
		
	}
	public static function setlazyPaths($array)
	{
		self::$lazyPaths = $array;
	}
	public static function updateLazyPath($path,true)
	{
		$path = rtrim(realpath($path),'/').'/';
		if($path!='/')
			self::$lazyPaths[]=$path;
		unset($path);
	}
	public static function removeLazyPath($path)
	{
		if(array_key_exists($path,array_flip(self::$lazyPaths)))
			
	}
}
