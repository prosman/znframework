<?php
/************************************************************/
/*                       CLASS SEARCH                       */
/************************************************************/
/*

Author: Ozan UYKUN
Site: http://www.zntr.net
Copyright 2012-2015 zntr.net - Tüm hakları saklıdır.

*/
/******************************************************************************************
* SEARCH                                                                            	  *
*******************************************************************************************
| Dahil(Import) Edilirken : Search   							                          |
| Sınıfı Kullanırken      :	search::   							    				      |
| 																						  |
| Kütüphanelerin kısa isimlendirmelerle kullanımı için. Config/Libraries.php bakınız.     |
******************************************************************************************/
class Search
{
	/* Result Değişkeni
	 *  
	 * Arama sonucu verilerini tutaması
	 * için tanımlanmış dizi değişken
	 */
	private static $result;
	
	/* Filter Değişkeni
	 *  
	 * Aramayı başlatmadan önce filtre uygulamak için
	 * tanımlanmış dizi değişken
	 */
	private static $filter = array();
	
	// filter ve or_filter için.
	protected static function _filter($column = '', $value = '', $type)
	{
		// sütun adı veya operatör metinsel ifade içermiyorsa false değeri döndür.
		if( ! is_string($column) || ! is_string($column) ) 
		{
			return false;
		}
		
		// değer, metinsel veya sayısal değer içermiyorsa false değeri döndür.
		if( ! (is_string($value) || is_numeric($value)) ) 
		{
			return false;
		}
		
		// $filtre dizi değişkenine parametre olarak gönderilen değerleri string olarak ekle.
		self::$filter[] = "$column|$value|$type";
	}
	
	/******************************************************************************************
	* FILTER                                                                                  *
	*******************************************************************************************
	| Genel Kullanım: Aramaya filtre uygulamak için kullanılır.                               |
	|															                              |
	| Parametreler: 2 parametresi vardır.                                                     |
	| 1. string var @column => Filtre uygulanacak sütun ve operatör bilgisi.                  |
	| 2. string var @value  => Belirlenen sütunda filtrelenecek veri.                   	  |
	|          																				  |
	| Örnek Kullanım: filter('yas >', 15);        	  			  							  |
	| // where yas > 15         														      |
	|          																				  |
	| ÇOKLU FİLTRELEME         																  |
	| [VE] bağlacı ile yapılmak isteniyorsa filter() yöntemini kullanılır.        			  |
	| [VEYA] bağlacı ile yapılmak isteniyorsa or_filter() yöntemini kullanılır.        		  |
	|          																				  |
	******************************************************************************************/	
	public static function filter($column = '', $value = '')
	{
		self::_filter($column, $value, 'and');
	}
	
	/******************************************************************************************
	* OR FILTER                                                                               *
	*******************************************************************************************
	| Genel Kullanım: Aramaya birden fazla filtre uygulanacağı zamana ve kullanımda veya      |
	| bağlacı tercih edileceği zaman kullanılır.                                              |
	|															                              |
	| Parametreler: 2 parametresi vardır.                                                     |
	| 1. string var @column => Filtre uygulanacak sütun ve operatör bilgisi.                  |
	| 2. string var @value  => Belirlenen sütunda filtrelenecek veri.                   	  |
	|          																				  |
	| Örnek Kullanım: or_filter('yas >', 15);        	  			  						  |
	| // or where yas > 15         														      |
	|          																				  |
	******************************************************************************************/	
	public static function or_filter($column = '', $value = '')
	{
		self::_filter($column, $value, 'or');
	}
	
	/******************************************************************************************
	* GET                                                                                     *
	*******************************************************************************************
	| Genel Kullanım: Arama işlemini başlatır ve sonucu çıktılar.                             |
	|															                              |
	| Parametreler: 3 parametresi vardır.                                                     |
	| 1. array var @conditions => Arama yapılacak tablo adı ve tabloya ait sütun dizisidir.   |
	| 2. string var @word  => Belirtilen tablo ve sütunlarda aranacak veri.                   |
	| 3. string var @type  => Aranan kelimenin içinde geçen, ile başlayan ve ile biten durumu.|
	|          																				  |
	| Örnek Kullanım: 																		  |
	| get(																					  |	
	|	  array																				  |
	|	  (																					  |
	|		   'table1' => array('column1','column2') , 									  |
	|		   'table2' => array('column1','column2')										  |	
	|     ) 																			      |
	| );        	  			  							  						          |
	|          																				  |
	| 3. TYPE Parametresi 3 farklı değer alabilir        									  |
	| inside, starting, ending         														  |
	|          																				  |
	******************************************************************************************/	
	public static function get($conditions = array(), $word = '', $type = 'inside')
	{
		// Parametreler kontrol ediliyor. -----------------------------------------
		if( ! is_array($conditions) ) 
		{
			return false;
		}
		
		if( ! (is_string($word) || is_numeric($word)) ) 
		{
			return false;
		}
		
		if( ! is_string($type) ) 
		{
			$type = "inside";
		}
		// ------------------------------------------------------------------------

		$word = addslashes($word);
		
		$str = "";
		
		// Aramanın neye göre yapılacağı belirtiliyor. ----------------------------
		
		// İçerisinde Geçen
		if( $type === "inside" ) 
		{
			$str = '%'.$word.'%';
		}
		
		// İle Başlayan
		if( $type === "starting" ) 
		{
			$str = $word.'%';
		}
		
		// İle Biten
		if( $type === "ending" ) 
		{
			$str = '%'.$word;
		}
		// ------------------------------------------------------------------------
		
		$db = uselib('Database\Db');
		
		foreach($conditions as $key => $values)
		{
			// Tekrarlayan verileri engelle.
			$db->distinct();
			
			foreach($values as $keys)
			{	
				$db->where($keys.' like', $str);
				
				// Filter dizisi boş değilse
				// Filtrelere göre verileri çek
				if( ! empty(self::$filter) )
				{
					foreach(self::$filter as $val)
					{		
						$exval = explode("|", $val);
						
						// Ve bağlaçlı filter kullanılmışsa
						if( $exval[2] === "and" )
						{
							$db->where("and $exval[0] ", $exval[1]);	
						}
						
						// Veya bağlaçlı or_filter kullanılmışsa
						if( $exval[2] === "or" )
						{
							$db->where("or $exval[0] ", $exval[1]);
						}
					}	
				}
			}
			
			// Sonuçları getir.
			$db->get($key);
			
			// Sonuçları result dizisine yazdır.
			self::$result[$key] = $db->result();
		}
		
		$result = self::$result;
		
		$db->close();
		// Değişkenleri sıfırla
		self::$result = '';
		self::$filter = array();
		
		// Sonuçları object veri türünde döndür.
		return (object)$result;	
	}
}