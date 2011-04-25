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
$config = array
	( 
		'server'		=> 'chat.freenode.net',
		'port'			=> 6667,
		'channels'		=> array(),
		'name'			=> '',
		'nick'			=> '',
		'pass'			=> null,
		'readLength'	=> 512,
		'logsDir'		=> 'logs'
		'commandsDir'	=> 'commands'
	);
$lazyPaths = array
	(
		FATELESS_ENGINEPATH.'core/',
		FATELESS_BASEPATH.$config['commandsDir'],
		FATELESS_ENGINEPATH.'commands/'
	);
$admins = array();
$masters = array();
