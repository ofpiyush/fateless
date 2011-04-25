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
class config
{
	private static $conf = array();
	function __construct($array)
	{
		//load default values
		self::$conf = $array;
		unset($array);
	}
	public function __get($key)
	{
		if(array_key_exists($key,self::$conf))
			return self::$conf[$key];
		return false;
	}
	public function __set($key,$val)
	{
		if($key == 'channels')
			$this->updateChannels($key,$val);
		else
			self::$conf[$key] = $value;	
	}
	private function updateChannels($channel,$delete=false)
	{
		$channels = array_flip(self::$conf['channels']);
		if(array_key_exists($channel,$channels) && $delete)
		{
			if($delete)	
			{
				unset($channels[$channel]);
				self::$conf['channels'] = array_flip($channels);
			}
		}
		else
			array_push(self::$conf['channels'],$channel);
		unset($channels);
	}
}
