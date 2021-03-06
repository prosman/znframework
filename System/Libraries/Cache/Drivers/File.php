<?php
/************************************************************/
/*                  FILE DRIVER LIBRARY                     */
/************************************************************/
/*

Author: Ozan UYKUN
Site: http://www.zntr.net
Copyright 2012-2015 zntr.net - Tüm hakları saklıdır.

*/
/******************************************************************************************
* FILE DRIVER		                                                                      *
*******************************************************************************************
| Dahil(Import) Edilirken : Dahil Edilemez.  							                  |
| Sınıfı Kullanırken      :	Kullanılamaz.												  |
| 																						  |
| NOT: Ön bellekleme kütüphanesi için oluşturulmuş yardımcı sınıftır.                     |
******************************************************************************************/	
class FileDriver
{
	/* Path Değişkeni
	 *  
	 * Ön bellekleme dizin bilgisini
	 * tutması için oluşturulmuştur.
	 *
	 */
	protected $path;
	
	/******************************************************************************************
	* CONSTRUCT YAPICISI                                                                      *
	******************************************************************************************/
	public function __construct()
	{
		$this->path = APP_DIR.'Cache/';
		
		if( ! is_dir_exists($this->path) )
		{
			library('Folder', 'create', array($this->path, 0777));	
		}	
	}
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
		$data = $this->_select($key);

		return ( is_array($data) ) 
			   ? $data['data'] 
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
	public function insert($key, $var, $time = 60, $compressed = false)
	{
		$datas = array
		(
			'time'	=> time(),
			'ttl'	=> $time,
			'data'	=> $var
		);
		
		if( file::write($this->path.$key, serialize($datas)) )
		{
			chmod($this->path.$key, 0640);
			return true;
		}
		
		return false;
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
		return ( file_exists($this->path.$key) )
		 	   ? unlink($this->path.$key) 
			   : false;
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
		$data = $this->_select($key);
		
		if( $data === false )
		{
			$data = array('data' => 0, 'ttl' => 60);
		}
		elseif( ! is_numeric($data['data']) )
		{
			return false;
		}
		
		$new_value = $data['data'] + $increment;
		
		return ( $this->insert($key, $new_value, $data['ttl']) )
			   ? $new_value
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
		$data = $this->_select($key);
		
		if ($data === FALSE)
		{
			$data = array('data' => 0, 'ttl' => 60);
		}
		elseif ( ! is_numeric($data['data']))
		{
			return FALSE;
		}
		
		$new_value = $data['data'] - $decrement;
		
		return $this->insert($key, $new_value, $data['ttl'])
			   ? $new_value
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
		return folder::delete($this->path);
	}
	
	/******************************************************************************************
	* INFO                                                                                    *
	*******************************************************************************************
	| Genel Kullanım: Ön bellekleme hakkında bilgi edinmek için kullanılır. 		          |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. string var @type => Bilgi alınacak kullanıcı türü.							 	 	  |
	|																						  |
	| Örnek Kullanım: ->info('user');			        		     					      |
	|          																				  |
	******************************************************************************************/
	public function info($type = NULL)
	{
		return folder::file_info($this->path);
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
		if( ! file_exists($this->path.$key) )
		{
			return false;
		}
		
		$data = unserialize(file_get_contents($this->path.$key));
		
		if( is_array($data) )
		{
			$mtime = filemtime($this->path.$key);
			
			if ( ! isset($data['ttl']))
			{
				return false;
			}
			
			return array
			(
				'expire' => $mtime + $data['ttl'],
				'mtime'	 => $mtime
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
		return is_writable($this->path);
	}
	
	/******************************************************************************************
	* PROTECTED SELECT	                                                                      *
	******************************************************************************************/
	protected function _select($key)
	{
		if ( ! file_exists($this->path.$key))
		{
			return false;
		}
		
		$data = unserialize(file_get_contents($this->path.$key));
		
		if( $data['ttl'] > 0 && time() > $data['time'] + $data['ttl'] )
		{
			unlink($this->path.$key);
			
			return false;
		}
		
		return $data;
	}
}