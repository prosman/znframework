<?php
/************************************************************/
/*                     TOOL BUILDER                         */
/************************************************************/
/*

Author: Ozan UYKUN
Site: http://www.zntr.net
Copyright 2012-2015 zntr.net - Tüm hakları saklıdır.

*/

/******************************************************************************************
* ATTRIBUTES                                                                              *
*******************************************************************************************
| Genel Kullanım: Html nesnelerine ait özellik ve değer çifti belirtmek için kullanılır.  |
|															                              |
| Parametreler: Tek dizi parametresi vardır.                                              |
| 1. array var @attributes => Özellik ve değer çiftlerini içerecek dizi parametresi.	  |
|          																				  |
| Örnek Kullanım: attributes(array('name' => 'ornek', 'id' => 'zntr'));        			  |
| // name="ornek" id="zntr"       														  |
|          																				  |
******************************************************************************************/	
if( ! function_exists('attributes') )
{
	function attributes($attributes = '')
	{
		$attribute = '';
		if( is_array($attributes) )
		{
			foreach($attributes as $key => $values)
			{
				if( is_numeric($key) )
				{
					$key = $values;
				}
				$attribute .= ' '.$key.'="'.$values.'"';
			}	
		}
		
		return $attribute;	
	}
}

/******************************************************************************************
* XML BUILDER                                                                             *
*******************************************************************************************
| Genel Kullanım: Xml belgesi oluşturmak için kullanılır. 								  |
|																						  |
| Parametreler: 5 parametresi vardır.                                              		  |
| 1. string var @element => Eleman ismi.						     	  				  |
| 2. string var @content => Elemanın içeriği.		      								  |
| 3. array var @attribute => Özellik eklemek içindir.									  |
| 4. [ string var @version ] => Oluşturulacak belgenin sürümü. Varsayılan:1.0    		  |
| 5. [ string var @encoding ] => Oluşturulacak belgenin karakter seti. Varsayılan:utf-8   |
|          																				  |
| Örnek Kullanım:         																  |
| echo xml_builder																		  |
| (																						  |
|	'node=medya', 	 // 1. Parametre Eleman adı: node=medya.							  |
|       xml_builder	 // 2. Parametre İçerik.											  |
|       (																			      |
|           'vidyo', 'Vidyo Elementi', array('xml:id' => 'vidyo')						  |
|       ).																				  |
|       xml_builder																		  |
|       (																				  |
|           'resim', 'Resim Elementi', array('xml:id' => 'resim')						  |
|       ),																				  |
|       array('xml:id' => 'node')  // 3. Parametre Özellikler.							  |
| ); 																					  |
|																						  |
******************************************************************************************/	
if( ! file_exists('xml_builder') )
{
	function xml_builder($elements = '', $content = '', $attribute = '', $version = '1.0', $encoding = 'utf-8')
	{		
		if( ! is_string($elements) || empty($elements) ) 
		{
			return false;		
		}
		if( ! is_value($content) ) 
		{
			$content = '';	
		}
		if( ! is_string($version) ) 
		{
			$version = '1.0';
		}
		if( ! is_string($encoding) ) 
		{
			$encoding = 'utf-8';
		}

		if( strstr($elements, "node") )
		{
			$elements_ex = explode("=", $elements);
			$elements = trim($elements_ex[1]);
			$str = '<?xml version="'.$version.'" encoding="'.$encoding.'"?>';
		}		
		else
		{
			$str = '';
		}
		
		$str .= ln().'<'.$elements.attributes($attribute).'>'.$content.'</'.$elements.'>'.ln();
		return $str;
	}	
}

/******************************************************************************************
* LIST BUILDER                                                                            *
*******************************************************************************************
| Genel Kullanım: Liste oluşturmak için kullanılır. 							     	  |
|																						  |
| Parametreler: 5 parametresi vardır.                                              		  |
| 1. array var @elements => Listeyi oluşturacak seçenekler.						     	  |
| 2. array var @attributes => Listeye özellik eklemek için.		      					  |
| 3. string var @type => Liste türü. Varsayılan:ul   									  |
|          																				  |
| Örnek Kullanım:         																  |
| echo list_builder(array('a', 'b', 'c'), array('name' => 'liste'), 'ol');                |
|																						  |
******************************************************************************************/	
if( ! function_exists('list_builder') )
{
	function list_builder($elements = '', $attributes = '', $type = 'ul')
	{
		if( ! is_array($elements) || empty($elements) ) 
		{
			return false;
		}
		
		if( ! is_string($type) ) 
		{
			$type = 'ul';
		}
		
		$list = '<'.$type.attributes($attributes).'>'.ln();
		
		$i = 0;
		
		foreach($elements as $k => $values)
		{
			$list .= "\t".'<li>'.$values.'</li>'.ln();
			$i++;
		}
		
		$list .= '</'.$type.'>'.ln();
		
		return $list;
	}
}

/******************************************************************************************
* TABLE BUILDER                                                                           *
*******************************************************************************************
| Genel Kullanım: Tablo oluşturmak için kullanılır. 							     	  |
|																						  |
| Parametreler: 2 parametresi vardır.                                              		  |
| 1. array var @elements => Tabloya oluşturacak satır ve sütunlar.				     	  |
| 2. array var @attributes => Tabloya özellik eklemek için.		      					  |
|          																				  |
| Örnek Kullanım:         																  |
| $elemanlar = array(																	  |
|     array("1", "2", "3" => array("colspan" => "3")), 									  |
|     array("6", "7", "8", "9", "10")													  |
| );																					  |
|																						  |
| $ozellikler = array(																      |
|    "border" => "1", 																	  |
|    "width" => "300", 																      |
|    "height" => "100"																	  |
| );																					  |
|																						  |
| echo table_builder($elemanlar, $ozellikler);											  |
|																						  |
******************************************************************************************/	
if( ! file_exists('table_builder') )
{
	function table_builder($elements = '', $attributes = '')
	{
		if( ! is_array($elements) || empty($elements) ) 
		{
			return false;
		}
		
		$table = '<table '.attributes($attributes).'>';
		$colno = 1;
		$rowno = 1;
		
		foreach($elements as $key => $element)
		{
			$table .= ln()."\t".'<tr>'.ln();
			
			if( is_array($element) ) foreach($element as $k => $v)
			{
				$val = $v;
				$attr = '';
				
				if( is_array($v) )
				{
					$attr = attributes($v);
					$val = $k;
				}
			
				$table .= "\t\t".'<td'.$attr.'>'.$val.'</td>'.ln();	
				$colno++;
			}
		
			$table .= "\t".'</tr>'.ln();
			$rowno++;
		}
		$table .= '</table>';
		
		return $table;
	}
}