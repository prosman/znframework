<?php 
/************************************************************/
/*                        CLASS  CART                       */
/************************************************************/
/*

Author: Ozan UYKUN
Site: http://www.zntr.net
Copyright 2012-2015 zntr.net - Tüm hakları saklıdır.

*/
if( ! isset($_SESSION)) session_start();

/******************************************************************************************
* CART                                                                               	  *
*******************************************************************************************
| Dahil(Import) Edilirken : Cart     							                          |
| Sınıfı Kullanırken      :	cart::													      |
| 																						  |
| Kütüphanelerin kısa isimlendirmelerle kullanımı için. Config/Libraries.php bakınız.     |
******************************************************************************************/	
class Cart
{
	/* Items Dizi Değişkeni
	 *  
	 * Sepetteki güncel veri bilgisini tutuması
	 * için oluşturulmuştur.
	 *
	 */
	private static $items = array();
	
	/* Error Değişkeni
	 *  
	 * Sepet işlemlerinde oluşan hata bilgilerini
	 * tutması için oluşturulmuştur.
	 *
	 */
	private static $error;
	
	/******************************************************************************************
	* INSERT ITEM                                                                             *
	*******************************************************************************************
	| Genel Kullanım: Sepete ürün eklemek için kullanılır. Eklenecek ürünler dizi olarak	  |
	| belirtilir.														                      |
	|															                              |
	| Parametreler: Tek dizi parametresi vardır.                                              |
	| 1. array var @product => Eklenecek ürünlerin bilgisini tutar .					      |
	|          																				  |
	| Örnek Kullanım: array('id' => 1, 'price' => 5, quantity => 1, 'name' => 'Urun')         |
	|          																				  |
	| Ürün eklenirken belirtilmek zorunda olunan parametreler şunlardır.          			  |
	|          																				  |
	| 1-Fiyat Parametresi: price => fiyat bildirilirken price anahtar kelimesi kullanılır.    |
	| 2-Adet Parametresi: quantity => adet bildirilirken quantity anahtar kelime kullanılır.  |
	| bu anahtar kelime kullanılmazsa ürün adeti 1 kabul edilir. Bunların dışındaki        	  |
	| isimlendirmeler keyfidir. Yani isteğe bağlıdır.        								  |
	|          																				  |
	******************************************************************************************/
	public static function insert_item($product = array())
	{
		// Ürünün parametresinin boş olması durumunda rapor edilmesi istenmiştir.
		if( empty($product) )
		{
			self::$error = get_message('Cart', 'cart_insert_parameter_empty_error');
			report('Error', self::$error, 'CartLibrary');
			return false;	
		}
		
		// Ürünün parametresinin dizi olmaması durumunda rapor edilmesi istenmiştir.
		if( ! is_array($product))
		{
			self::$error = get_message('Cart', 'cart_array_parameter_error');
			report('Error', self::$error, 'CartLibrary');
			return false;	
		}
		
		// Ürünün adet parametresinin belirtilmemesi durumunda 1 olarak kabul edilmesi istenmiştir.
		if( ! isset($product['quantity']))
		{
			$product['quantity'] = 1;
		}
		
		// Sepettin daha önce oluşturulup oluşturulmadığına göre işlemler gerçekleştiriliyor.
		if( isset($_SESSION[md5('cart')]) )
		{
			self::$items = $_SESSION[md5('cart')];
			array_push(self::$items, $product);
			$_SESSION[md5('cart')] = self::$items;
		}
		else
		{
			array_push(self::$items, $product);
			$_SESSION[md5('cart')] = self::$items;
		}
		self::$items = $_SESSION[md5('cart')];
		
		return self::$items;
	}
	
	/******************************************************************************************
	* SELECT ITEMS                                                                            *
	*******************************************************************************************
	| Genel Kullanım: Sepetteki tüm ürün bilgilerini dizi olarak döndürmek için kullanılır.	  |
	|															                              |
	| Parametreler: Herhangi bir parametresi yoktur.                                          |
	|          																				  |
	******************************************************************************************/
	public static function select_items()
	{
		if(isset($_SESSION[md5('cart')]))
		{
			self::$items = $_SESSION[md5('cart')];
			return self::$items;	
		}
		else
		{
			self::$error = get_message('Cart', 'cart_no_data_error');
			report('Error', self::$error, 'CartLibrary');
			return false;	
		}
	}
	
	/******************************************************************************************
	* SELECT ITEM                                                                             *
	*******************************************************************************************
	| Genel Kullanım: Sepet içerisindeki belirtilen ürün hakkında verilere ulaşmak için       |
	| kullanılır. Yani ürün seçmek için kullanılır.											  |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. mixed var @code => Seçilen ürüne ait ayırt edici bilgi parametre olarak girilir.	  |
	|        		  																		  |
	| Code parametresi 2 tür değişken türü içerir bunlar;                                     |
	|          																				  |
	| 1-String/Numeric  => bu tipte parametre için ürünün ayırt edici bilgisi kullanılır.     |	
	| Örnek: id, ürün kodu, seri numara gibi.                                                 |
	|																						  |   													
	| 2-Array => bu tipte parametre kullanımında ise hangi parametreye göre ürünün seçileceği |
	| belirtilir.    																		  |
	| Örnek: array('id' => 'id değeri').                                                      |
	|          																				  |
	******************************************************************************************/
	public static function select_item($code = '')
	{
		if( empty($code) ) 
		{
			return false;
		}
		
		self::$items = (isset($_SESSION[md5('cart')])) 
		               ? $_SESSION[md5('cart')] 
					   : '';
		
		if( empty(self::$items) ) 
		{
			return false;
		}
		
		foreach( self::$items as $row )
		{
			if( ! is_array($code) )
			{
				$key = array_search($code, $row);
			}
			else
			{
				if( isset($row[key($code)]) && $row[key($code)] == current($code) )
				{
					$key = $row;
				}
			}
			
			if( ! empty($key))
			{
				return (object)$row;
			}
		}
	}
	
	/******************************************************************************************
	* TOTAL ITEMS                                                                             *
	*******************************************************************************************
	| Genel Kullanım: Sepetteki toplam ürün adet bilgisine erişmek için kullanılır.			  |
	|															                              |
	| Parametreler: Herhangi bir parametresi yoktur.                                          |
	| NOT:Bu hesaplama ürün verileri içerisinde quantity parametresine göre yapılmaktadır.    |
	| Bu nedenle quantity dışında ürün adeti için farklı bir parametre kullanmayınız.         |
	|        																				  |
	******************************************************************************************/
	public static function total_items()
	{
		if( isset($_SESSION[md5('cart')]) )
		{
			self::$items = $_SESSION[md5('cart')];
			$total_items = 0;
			if( ! empty(self::$items))foreach(self::$items as $item)
			{
				$total_items += $item['quantity'];	
			}
			
			return $total_items;
		}
		else
		{
			self::$error = get_message('Cart', 'cart_no_data_error');
			report('Error', self::$error, 'CartLibrary');
			return 0;	
		}
	}
	
	
	/******************************************************************************************
	* TOTAL PRICES                                                                            *
	*******************************************************************************************
	| Genel Kullanım: Sepetteki ürünlerin toplam fiyat değerine erişmek için kullanılır.	  |
	|															                              |
	| Parametreler: Herhangi bir parametresi yoktur.                                          |
	| NOT:Bu hesaplama ürün verileri içerisinde quantity ve price parametrelerine göre        |
	| yapılmaktadır. Bu nedenle quantity dışında ürün adeti ve fiyat için farklı bir          |
	| parametre kullanmayınız.      														  |
	|     														  |
	******************************************************************************************/
	public static function total_prices()
	{
		self::$items = ( isset($_SESSION[md5('cart')]) ) 
				       ? $_SESSION[md5('cart')] 
					   : '';
		
		if( empty(self::$items) )
		{
			self::$error = get_message('Cart', 'cart_no_data_error');
			report('Error', self::$error, 'CartLibrary');
			return 0;	
		}
		
		$total = '';
		foreach(self::$items as $values)
		{
			$quantity = (isset($values['quantity'])) ? $values['quantity'] : 1;
			$total += $values['price'] * $quantity;
		}
		return $total;
	}
	
	/******************************************************************************************
	* UPDATE ITEM                                                                             *
	*******************************************************************************************
	| Genel Kullanım: Sepet içerisindeki belirtilen ürün bilgilerinin güncellenmesi için	  |
	| kullanılır.															                  |
	|															                              |
	| Parametreler: 2 parametresi vardır.                                                     |
	| 1. mixed var @code => Güncellenen ürüne ait ayırt edici bilgi parametre olarak girilir. |
	| 2. array var @data => Güncellenecek verileri dizi içerisinde anahtar değer çifti olarak |
	| girilmelidir.																			  |
	|																						  |
	| Code parametresi 2 tür değişken türü içerir bunlar;                                     |
	|          																				  |
	| 1-String/Numeric  => bu tipte parametre için ürünün ayırt edici bilgisi kullanılır.     |	
	| Örnek: id, ürün kodu, seri numara gibi.                                                 |
	|																						  |   													
	| 2-Array => bu tipte parametre kullanımında ise hangi parametreye göre ürünün seçileceği |
	| belirtilir.    																		  |
	| Örnek: array('id' => 'id değeri').                                                      |
	|          																				  |
	| Örnek Kullanım: update_item(array('id' => 10), array('price' => 5, 'name' => 'Urun1'))  |
	| Yukarıda yapılan id'si 10 olan ürünün fiyatını 5 ve isminide Urun1                      |
	| olarak güncelle işlemidir.         												      |
	|          																				  |
	******************************************************************************************/
	public static function update_item($code = '', $data = array())
	{	
		if( empty($code) )
		{
			self::$error = get_message('Cart', 'cart_update_code_error');
			report('Error', self::$error, 'CartLibrary');
			return false;	
		}
		
		if( empty($data) )
		{
			self::$error = get_message('Cart', 'cart_update_parameter_empty_error');
			report('Error', self::$error, 'CartLibrary');
			return false;	
		}
		
		if( ! is_array($data) )
		{
			self::$error = get_message('Cart', 'cart_update_array_parameter_error');
			report('Error', self::$error, 'CartLibrary');
			return false;	
		}	
		
		self::$items = (isset($_SESSION[md5('cart')])) 
		               ? $_SESSION[md5('cart')] 
					   : '';
		
		if( empty(self::$items) ) 
		{
			return false;
		}
		
		$i=0;
		
		foreach(self::$items as $row)
		{
			if(is_array($code)) 
			{
				if(isset($row[key($code)]) && $row[key($code)] == current($code))
				{
					$code = $row[key($code)];
				}
			}
			
			$key = array_search($code,$row);
			
			if( ! empty($key) )
			{
				array_splice(self::$items, $i, 1);
				if(count($data) !== count($row))
				{
					foreach($data as $k => $v)
					{
						$row[$k] = $v;	
					}
					array_push(self::$items, $row);
				}
				else
				{
					array_push(self::$items, $data);
				}
			}
		
			$i++;
		}
		
		$_SESSION[md5('cart')] = self::$items;
	}
	
	/******************************************************************************************
	* DELETE ITEM                                                                             *
	*******************************************************************************************
	| Genel Kullanım: Sepet içerisindeki belirtilen ürünü silmek için kullanılır.             |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. mixed var @code => Seçilen ürüne ait ayırt edici bilgi parametre olarak girilir.	  |
	|        		  																		  |
	| Code parametresi 2 tür değişken türü içerir bunlar;                                     |
	|          																				  |
	| 1-String/Numeric  => bu tipte parametre için ürünün ayırt edici bilgisi kullanılır.     |	
	| Örnek: id, ürün kodu, seri numara gibi.                                                 |
	|																						  |   													
	| 2-Array => bu tipte parametre kullanımında ise hangi parametreye göre ürünün seçileceği |
	| belirtilir.    																		  |
	| Örnek: array('id' => 'id değeri').                                                      |
	|          																				  |
	******************************************************************************************/
	public static function delete_item($code = '')
	{		
		if( empty($code) )
		{
			self::$error = get_message('Cart', 'cart_delete_code_error');
			report('Error', self::$error, 'CartLibrary');
			return false;	
		}

		self::$items = ( isset($_SESSION[md5('cart')]) ) 
		               ? $_SESSION[md5('cart')] 
					   : '';
		
		if( empty(self::$items) ) 
		{
			return false;
		}
		
		$i=0;
		
		foreach(self::$items as $row)
		{	
			if(is_array($code)) 
			{
				if(isset($row[key($code)]) && $row[key($code)] == current($code))
				{
					$code = $row[key($code)];
				}
			}
			
			$key = array_search($code, $row);
			
			if( ! empty($key))
			{
				array_splice(self::$items, $i--, 1);
			}
		
			$i++;
		}
		
		$_SESSION[md5('cart')] = self::$items;		
	}
	
	/******************************************************************************************
	* DELETE ITEMS                                                                            *
	*******************************************************************************************
	| Genel Kullanım: Sepetteki tüm ürünleri silmek için kullanılır.	                      |
	|															                              |
	| Parametreler: Herhangi bir parametresi yoktur.                                          |
	|     														                              |
	******************************************************************************************/
	public static function delete_items()
	{
		if( isset($_SESSION[md5('cart')]) )
		{
				unset($_SESSION[md5('cart')]);
		}
	}
	
	/******************************************************************************************
	* MONEY FORMAT                                                                            *
	*******************************************************************************************
	| Genel Kullanım: Parametre olarak belirtilen sayısal veriyi para birimine çevirmek için. |
	| kullanılır.		                                                                      |
	|     														                              |
	| Parametreler: 2 parametresi vardır.                                                     |
	|     														                              |
	| 1. numeric var @money => Para biçimine çevrilmek istenen sayılsal veri.				  |
	| 2. string var @type => Sayısal verinin sonunda görüntülenmesi istenilen para birimidir. |
	|     														                              |
	| Örnek Kullanım: money_format(1200, '₺');  // Çıktı: 1.200,00 ₺     					  |
	| Örnek Kullanım: money_format(1000, '€');  // Çıktı: 1.000,00 €     					  |
	|     														                              |
	******************************************************************************************/
	public static function money_format($money = 0, $type = '')
	{
		if( ! is_numeric($money)) 
		{
			return false;
		}
		if( ! is_string($type)) 
		{
			$type = '';
		}
		
		$moneyFormat = '';
		
		$money = round($money, 2);
		
		$str_ex = explode(".",$money);
		
		$join = array();
		
		$str = strrev($str_ex[0]);
		
		for($i=0; $i<strlen($str); $i++)
		{
			if($i%3 === 0)
			{
				array_unshift($join, '.');
			}
			array_unshift($join, $str[$i]);
		}
		
		for($i=0; $i<count($join);$i++)
		{
			$moneyFormat .= $join[$i];	
		}
		$type = ($type) ? ' '.$type : '';
		
		$remaining = ( isset($str_ex[1]) ) 
					 ? $str_ex[1] 
					 : '00';
		
		if(strlen($remaining) === 1) 
		{
			$remaining .= '0';
		}
		
		$moneyFormat = substr($moneyFormat,0,-1).','.$remaining.$type;
		
		return $moneyFormat;
	}
	
	/******************************************************************************************
	* ERROR                                                                                   *
	*******************************************************************************************
	| Genel Kullanım: Sepet işlemlerinde oluşan hata bilgilerini tutması için oluşturulmuştur.|
	|     														                              |
	| Parametreler: Herhangi bir parametresi yoktur.                                          |
	|     														                              |
	******************************************************************************************/
	public static function error()
	{
		if( isset(self::$error) )
		{
			return self::$error;
		}
		else
		{
			return false;
		}
	}
}