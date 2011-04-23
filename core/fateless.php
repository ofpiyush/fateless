<?php

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
