<?php

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
