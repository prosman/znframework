<?php
/************************************************************/
/*                  WINCACHE DRIVER LIBRARY                 */
/************************************************************/
/*

Author: Ozan UYKUN
Site: http://www.zntr.net
Copyright 2012-2015 zntr.net - Tüm hakları saklıdır.

*/
/******************************************************************************************
* WINCACHE DRIVER		                                                                  *
*******************************************************************************************
| Dahil(Import) Edilirken : Dahil Edilemez.  							                  |
| Sınıfı Kullanırken      :	Kullanılamaz.												  |
| 																						  |
| NOT: Ön bellekleme kütüphanesi için oluşturulmuş yardımcı sınıftır.                     |
******************************************************************************************/	
class WincacheDriver
{
	/******************************************************************************************
	* SELECT                                                                                  *
	*******************************************************************************************
	| Genel Kullanım: Önbelleğe alınmış nesneyi çağırmak için kullanılır.				      |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. string var @key => Nesne anahtarı.							 	 			    	  |
	|          																				  |
	| Örnek Kullanım: ->get('nesne');			        									  |
	|          																				  |
	******************************************************************************************/
	public function select($key)
	{
		$success = false;
		
		if( function_exists('wincache_ucache_get') )
		{
			$data = wincache_ucache_get($key, $success);
		}
		else
		{
			return get_message('Cache', 'cache_unsupported', 'Wincache');
		}
		
		return ( $success ) 
			   ? $data 
			   : false;
	}
	
	/******************************************************************************************
	* INSERT                                                                                  *
	*******************************************************************************************
	| Genel Kullanım: Ön bellekte değişken saklamak için kullanılır.					      |
	|															                              |
	| Parametreler: 4 parametresi vardır.                                                     |
	| 1. string var @key => Nesne anahtarı.							 	 			    	  |
	| 2. variable var @var => Nesne.							 	 			    	 	  |
	| 3. numeric var @time => Saklanacağı zaman.							 	 			  |
	| 4. mixed var @compressed => Sıkıştırma.							 	 			  	  |
	|          																				  |
	| Örnek Kullanım: ->get('nesne');			        									  |
	|          																				  |
	******************************************************************************************/
	public function insert($key, $var, $time = 60, $expressed = false)
	{
		if( function_exists('wincache_ucache_set') )
		{
			return wincache_ucache_set($key, $var, $time);
		}
		else
		{
			return get_message('Cache', 'cache_unsupported', 'Wincache');
		}
	}
		
	/******************************************************************************************
	* DELETE                                                                                  *
	*******************************************************************************************
	| Genel Kullanım: Ön bellekten nesneyi silmek için kullanılır.					          |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. string var @key => Nesne anahtarı.							 	 			    	  |
	|																						  |
	| Örnek Kullanım: ->delete('nesne');			        							      |
	|          																				  |
	******************************************************************************************/
	public function delete($key)
	{
		if( function_exists('wincache_ucache_delete') )
		{
			return wincache_ucache_delete($key);
		}
		else
		{
			return get_message('Cache', 'cache_unsupported', 'Wincache');
		}
	}
	
	/******************************************************************************************
	* INCREMENT                                                                               *
	*******************************************************************************************
	| Genel Kullanım: Nesnenin değerini artımak için kullanılır.				              |
	|															                              |
	| Parametreler: 2 parametresi vardır.                                                     |
	| 1. string var @key => Nesne anahtarı.							 	 			    	  |
	| 2. numeric var @increment => Artırım miktarı.  				 	 			    	  |
	|																						  |
	| Örnek Kullanım: ->increment('nesne', 1);			        							  |
	|          																				  |
	******************************************************************************************/
	public function increment($key, $increment = 1)
	{
		$success = false;
		
		if( function_exists('wincache_ucache_inc') )
		{
			$value = wincache_ucache_inc($key, $increment, $success);
		}
		else
		{
			return get_message('Cache', 'cache_unsupported', 'Wincache');
		}
		
		return ( $success === true ) 
			   ? $value 
			   : false;
	}
	
	/******************************************************************************************
	* DECREMENT                                                                               *
	*******************************************************************************************
	| Genel Kullanım: Nesnenin değerini azaltmak için kullanılır.					          |
	|															                              |
	| Parametreler: 2 parametresi vardır.                                                     |
	| 1. string var @key => Nesne anahtarı.							 	 			    	  |
	| 2. numeric var @decrement => Azaltım miktarı.  				 	 			    	  |
	|																						  |
	| Örnek Kullanım: ->decrement('nesne', 1);			        							  |
	|          																				  |
	******************************************************************************************/
	public function decrement($key, $decrement = 1)
	{
		$success = false;
		
		if( function_exists('wincache_ucache_dec') )
		{
			$value = wincache_ucache_dec($key, $decrement, $success);
		}
		else
		{
			return get_message('Cache', 'cache_unsupported', 'Wincache');
		}
		
		return ( $success === true ) 
			   ? $value 
			   : false;
	}
	
	/******************************************************************************************
	* CLEAN                                                                                   *
	*******************************************************************************************
	| Genel Kullanım: Tüm önbelleği silmek için kullanılır.					                  |
	|          																				  |
	******************************************************************************************/
	public function clean()
	{
		if( function_exists('wincache_ucache_clear') )
		{
			return wincache_ucache_clear();
		}
		else
		{
			return get_message('Cache', 'cache_unsupported', 'Wincache');
		}
	}
	
	/******************************************************************************************
	* INFO                                                                                    *
	*******************************************************************************************
	| Genel Kullanım: Ön bellekleme hakkında bilgi edinmek için kullanılır. 		          |
	|          																				  |
	******************************************************************************************/
	public function info()
 	{
		if( function_exists('wincache_ucache_info') )
		{
			return wincache_ucache_info(true);
		}
		else
		{
			return get_message('Cache', 'cache_unsupported', 'Wincache');
		}
 	}
	
	/******************************************************************************************
	* GET METADATA                                                                            *
	*******************************************************************************************
	| Genel Kullanım: Ön bellekteki nesne hakkında bilgi almak için kullanılır. 		      |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. string var @key => Bilgi alınacak nesne.							 	 			  |
	|																						  |
	| Örnek Kullanım: ->get_metadata('nesne');			        		     				  |
	|          																				  |
	******************************************************************************************/
	public function get_metadata($key)
	{
		if( ! function_exists('wincache_ucache_info') )
		{
			return get_message('Cache', 'cache_unsupported', 'Wincache');
		}
		
		if( $stored = wincache_ucache_info(false, $key) )
		{
			$age 	  = $stored['ucache_entries'][1]['age_seconds'];
			$ttl 	  = $stored['ucache_entries'][1]['ttl_seconds'];
			$hitcount = $stored['ucache_entries'][1]['hitcount'];
			
			return array
			(
				'expire'	=> $ttl - $age,
				'hitcount'	=> $hitcount,
				'age'		=> $age,
				'ttl'		=> $ttl
			);
		}
		return false;
	}
	
	/******************************************************************************************
	* IS SUPPORTED                                                                            *
	*******************************************************************************************
	| Genel Kullanım: Sürücünün desteklenip desklenmediğini öğrenmek için kullanılır.         |
	|          																				  |
	******************************************************************************************/
	public function is_supported()
	{
		if ( ! extension_loaded('wincache') || ! ini_get('wincache.ucenabled') )
		{
			$report = get_message('Cache', 'cache_unsupported', 'Wincache');
			report('CacheUnsupported', $report, 'CacheLibary');
			return false;
		}
		
		return true;
	}
}