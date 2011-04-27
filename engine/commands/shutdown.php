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
class shutdown extends baseCommand
{
	function execute(request $request, fatelessBot $bot)
	{
		if($bot->isMaster($request->author['nick'],$request->author['user'])
			|| $bot->isAdmin($request->author['nick'],$request->author['user']) ) 
		{
			$bot->write('QUIT :Help make fateless better http://github.com/piyushmishra/fateless');
			fateless::$run = false;
		}
		else
		{
			if(!is_null($request->channel))
				$bot->privmsg($request->channel,$request->author['nick'].' : '.$bot->config->authErrorMsg);
			elseif(!is_null($request->author))
				$bot->privmsg($request->author['nick'],$bot->config->authErrorMsg);
		}
	}

}
