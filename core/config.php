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
class config
{
	private $conf = array();
	function __construct($array)
	{
		//load default values
		$this->conf = $array;
	}
	public function __get($key)
	{
		if(array_key_exists($key,$this->conf))
			return $this->conf[$key];
		return false;
	}
	public function __set($key,$val)
	{
		if($key == 'channels')
			$this->updateChannels($key,$val);
		else
			$this->conf[$key] = $value;	
	}
	private function updateChannels($channel,$delete=false)
	{
		$channels = array_flip($this->conf['channels']);
		if(array_key_exists($channel,$channels) && $delete)
		{
			if($delete)	
			{
				unset($channels[$channel]);
				$this->conf['channels'] = array_flip($channels);
			}
		}
		else
			$this->conf['channels'][]=$channel;
		unset($channels);
	}
}
