<?php
/************************************************************/
/*                     HTML COMPONENT                       */
/************************************************************/
/*

Author: Ozan UYKUN
Site: http://www.zntr.net
Copyright 2012-2015 zntr.net - Tüm hakları saklıdır.

*/
namespace Html;

require_once(COMPONENTS_DIR.'Html/Common.php');

use Html\ComponentHtmlCommon;
/******************************************************************************************
* HTML                                                                                    *
*******************************************************************************************
| Dahil(Import) Edilirken : CHtml              							     			  |
| Sınıfı Kullanırken      :	$this->chtml->     	     								      |
| 																						  |
| Kütüphanelerin kısa isimlendirmelerle kullanımı için. Config/Libraries.php bakınız.     |
******************************************************************************************/
class CHtml extends ComponentHtmlCommon
{
	/******************************************************************************************
	* ELEMENT                                                                                 *
	*******************************************************************************************
	| Genel Kullanım: Hangi html elemanının kullanılacağı belirtilir.					 	  |
	|															                              |
	| Parametreler: 2 parametresi vardır.                                                     | 
	| 1. string var @element => Eleman.					      	  				  			  |
	| 2. [ string var @content ] => Elemanın içeriği.					      	  			  |
	|          																				  |
	| Örnek Kullanım: ->element('b')         											  	  |
	|          																				  |
	******************************************************************************************/
	public function element($element = '', $content = '')
	{
		if( ! empty($element) )
		{
			$this->link['element'] = $element;
		}
		
		if( ! empty($content) )
		{
			$this->link['content'] = $content;
		}
		
		return $this;
	}
	
	/******************************************************************************************
	* CREATE                                                                                  *
	*******************************************************************************************
	| Genel Kullanım: Html nesnesini oluşturmak için kullanılan son yöntemdir.		          |
	|															                              |
	| Parametreler: 2 parametresi vardır.                                              	      | 
	| 1. string var @element => Oluşturulacak html nesnesi.					      	  		  |
	| 2. boolean var @closing => </x> tagı ile kapatılsı mı?. Varsayılan: true				  |
	|          																				  |
	| Örnek Kullanım: ->create('<br>', false);        								          |
	|          																				  |
	******************************************************************************************/
	public function create($element = '', $closing = true)
	{
		if( ! empty($element) )
		{
			$this->element($element);
		}
		
		$attr = ( isset($this->link['attr']) )
				? $this->link['attr']
				: '';
		
		$element = ( isset($this->link['element']) )
				   ? $this->link['element']
				   : '';
		
		$content = ( isset($this->link['content']) )
				   ? $this->link['content']
				   : '';
		
		// Html nesnesi oluşturuluyor... ----------------------------
		if( ! is_array($element) )
		{
			$create  = '<'.$element.$this->_attributes($attr).'>';
			
			if( $closing === true )
			{
				$create .= $content;
				$create .= '</'.$element.'>';
			}
		}
		else
		{
			$open  = '';
			$close = '';
			$att   = '';
				
			foreach($element as $k => $v)
			{
				if( ! is_numeric($k) )
				{
					$element = $k;	
					
					if( ! is_array($v) )
					{
						$att = ' '.$v;
					}
					else
					{
						$att = $this->_attributes($v);	
					}
				}
				else
				{
					$element = $v;	
				}
				
				$open .= '<'.$element.$att.'>';
				$close = '</'.$element.'>'.$close;
			}
			
			$create = $open.$content.$close;
		}
		// ----------------------------------------------------------
		
		return $create;
	}
}