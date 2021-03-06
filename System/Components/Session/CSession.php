<?php
/************************************************************/
/*                    SESSION COMPONENT                     */
/************************************************************/
/*

Author: Ozan UYKUN
Site: http://www.zntr.net
Copyright 2012-2015 zntr.net - Tüm hakları saklıdır.

*/
namespace Session;

use Config;

config::iniset(config::get('Session','settings'));

if(!isset($_SESSION)) session_start();
/******************************************************************************************
* SESSION                                                                                 *
*******************************************************************************************
| Dahil(Import) Edilirken : CSession          							     			  |
| Sınıfı Kullanırken      :	$this->csession->       									  |
| 																						  |
| Kütüphanelerin kısa isimlendirmelerle kullanımı için. Config/Libraries.php bakınız.     |
******************************************************************************************/
class CSession
{
	protected $name;
	protected $value;
	protected $regenerate = true;
	protected $encode = array();
	protected $error;
	
	public function name($name = '')
	{
		if( ! is_char($name))
		{
			return $this;		
		}
		
		$this->name = $name;
		
		return $this;
	}
	
	public function encode($name = '', $value = '')
	{
		if( ! ( is_hash($name) || is_hash($value) ))
		{
			return $this;		
		}
		
		$this->encode['name'] = $name;
		$this->encode['value'] = $value;
		
		return $this;
	}
	
	public function decode($hash = '')
	{
		if( ! is_hash($hash))
		{
			return $this;	
		}
		
		$this->encode['name'] = $hash;
		
		return $this;
	}
	
	public function value($value = '')
	{
		$this->value = $value;
		
		return $this;
	}

	public function regenerate($regenerate = true)
	{
		if( ! is_bool($regenerate))
		{
			return $this;		
		}
		
		$this->regenerate = $regenerate;
		
		return $this;
	}
	
	public function create($name = '', $value = '')
	{
		if( ! empty($name)) 
		{
			if( ! is_char($name))
			{
				return false;
			}
			
			$this->name($name);
		}
		
		if( ! empty($value))
		{
			$this->value($value);	
		}
		
		if( ! empty($this->encode) )
		{
			if(isset($this->encode['name']))
			{
				if(is_hash($this->encode['name']))
				{
					$this->name = hash($this->encode['name'], $this->name);		
				}		
			}
			
			if(isset($this->encode['value']))
			{
				if(is_hash($this->encode['value']))
				{
					$this->value = hash($this->encode['value'], $this->value);	
				}
			}
		}
		
		$session_config = config::get("Session");
	
		if( ! isset($this->encode['name']))
		{
			if($session_config["encode"] === true)
			{
				$this->name = md5($this->name);
			}
		}
		
		$_SESSION[$this->name] = $this->value;
		
		if($_SESSION[$this->name])
		{
			if($this->regenerate === true)
			{
				session_regenerate_id();	
			}
			
			$this->_default_variable();
			
			return true;	
		}
		else
		{
			return false;
		}
	} 
	
	public function select($name = '')
	{
		if( ! is_value($name))
		{
			return false;	
		}
		
		if(empty($name)) 
		{
			$name = $this->name;
			$this->name = NULL;	
		}
		
		if(empty($name)) 
		{
			return $_SESSION;
		}
		
		if(isset($this->encode['name']))
		{
			if(is_hash($this->encode['name']))
			{
				$name = hash($this->encode['name'], $name);		
				$this->encode = array();	
			}		
		}
		else
		{
			if(config::get("Session", "encode") === true)
			{
				$name = md5($name);
			}
		}
		
		if(isset($_SESSION[$name]))
		{
			return $_SESSION[$name];
		}
		else
		{
			return false;	
		}
	}
	
	public function delete($name = '')
	{
		if( ! is_value($name))
		{
			return false;	
		}
	
		if(empty($name)) 
		{
			$name = $this->name;
			$this->name = NULL;	
		}
	
		if(empty($name)) 
		{
			if(isset($_SESSION))
			{
				session_destroy();
			}
		}	
		
		$session_config = config::get("Session");
		
		if(isset($this->encode['name']))
		{
			if(is_hash($this->encode['name']))
			{
				$name = hash($this->encode['name'], $name);	
				$this->encode = array();	
			}		
		}
		else
		{
			if($session_config["encode"] === true)
			{
				$name = md5($name);
			}
		}
		
		if(isset($_SESSION[$name]))
		{ 	
			unset($_SESSION[$name]);
		}
		else
		{ 
			return false;		
		}
	}
	
	public function error()
	{
		return $this->error;
	}
	
	protected function _default_variable()
	{
		if( ! empty($this->name)) 	  $this->name 	  	= NULL;
		if( ! empty($this->value)) 	  $this->value 	  	= NULL;
		if($this->regenerate !== true)$this->regenerate  = true;
		if( ! empty($this->encode))   $this->encode   	= array();
	}
}