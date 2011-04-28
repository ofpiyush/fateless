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
abstract class baseCommand
{
	protected static $log = null;
	protected static $bot = null;
	final function __construct()
	{
		if(is_null(self::$log))
			self::$log = new logger();
	}
	protected static function reply(request $request ,$message, $toAuthor = true )
	{
		$to = null;
		if(!is_null($request->channel))
		{
			$message	= (($toAuthor)? $request->author['nick'].': ' : '' ).$message;
			$to			= $request->channel;
		}
		elseif(!is_null($request->author))
			$to = $request->author['nick'];
		if(!is_null($to))
		{
			self::$bot->privmsg($to,$message);
			self::$log->line(self::$bot->config->nick.':'.$message, $to);
		}
	}
	public static function addBot(fatelessBot $bot)
	{
		if(is_null(self::$bot))
			self::$bot = $bot;
	}
	abstract function execute(request $request);
}
