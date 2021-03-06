<?php

/************************************************************/
/*                       CLASS IMPORT                       */
/************************************************************/
/*

Author: Ozan UYKUN
Site: http://www.zntr.net
Copyright 2012-2015 zntr.net - Tüm hakları saklıdır.

*/
/******************************************************************************************
* CONTROLLER CLASS                                                                        *
*******************************************************************************************
| Dahil(Import) Edilirken : Dahil edilmeye ihtiyaç duymaz.     							  |
| Sınıfı Kullanırken      :	import::, $this->import, zn::$use->import, this()->import     |
| 																						  |
| Genel Kullanım:																          |
| Kütüphane, araç, bileşen veya model sınıflarını dahil etmek için kullanılır.			  |
|																						  |
******************************************************************************************/	
class Import
{
	/* Is Import Değişkeni
	 *  
	 * Bir sınıfın daha önce dahil edilip edilmediği
	 * bilgisini tutması için oluşturulmuştur.
	 *
	 */
	private static $is_import = array();
	
	/******************************************************************************************
	* LIBRARY                                                                                 *
	*******************************************************************************************
	| Genel Kullanım: Libraries veya System/Libraries dizinlerinde yer alan kütüphaneleri	  |
	| dahil etmek için kullanılır.										  					  |
	|															                              |
	| Parametreler: Tek dizi parametresi vardır.                                              |
	| 1. array/args var @libraries => Parametre olarak sıralı kütüphaneler veya dizi içinde	  |
	| eleman olarak kullanılan kütüphaneleri dahil etmek için kullanılır.					  |
	|          																				  |
	| Örnek Kullanım: import::library('k1', 'k2' ... 'kN');        							  |
	| Örnek Kullanım: import::library(array('k1', 'k2' ... 'kN'));        					  |
	|          																				  |
	******************************************************************************************/
	public static function library()
	{	
		$arguments = func_get_args();
		
		if( isset($arguments[0]) && is_array($arguments[0]) )
		{
			$arguments = $arguments[0];
		}
		
		if( ! empty($arguments) ) foreach(array_unique($arguments) as $class)
		{
			if( is_array($class) ) 
			{
				$class = '';
			}
			
			is_imported($class);
		}	
	}
	
	/******************************************************************************************
	* COMPONENT                                                                               *
	*******************************************************************************************
	| Genel Kullanım: System/Components dizininde yer alan bileşenleri				   	      |
	| dahil etmek için kullanılır.										  					  |
	|															                              |
	| Parametreler: Tek dizi parametresi vardır.                                              |
	| 1. array/args var @components => Parametre olarak sıralı kütüphaneler veya dizi içinde  |
	| eleman olarak kullanılan kütüphaneleri dahil etmek için kullanılır.					  |
	|          																				  |
	| Örnek Kullanım: import::component('c1', 'c2' ... 'cN');        						  |
	| Örnek Kullanım: import::component(array('c1', 'c2' ... 'cN'));        				  |
	|          																				  |
	******************************************************************************************/
	public static function component()
	{
		return self::library(func_get_args());	
	}
	
	/******************************************************************************************
	* MODEL                                                                                   *
	*******************************************************************************************
	| Genel Kullanım: Model dizinlerinde yer alan dosyaları dahil etmek için kullanılır. 	  |
	|															                              |
	| Parametreler: Tek dizi parametresi vardır.                                              |
	| 1. array/args var @models => Parametre olarak sıralı model dosyalarını veya dizi içinde |
	| eleman olarak kullanılan model dosyalarını dahil etmek için kullanılır.				  |
	|          																				  |
	| Örnek Kullanım: import::model('k1', 'k2' ... 'kN');        							  |
	| Örnek Kullanım: import::model(array('k1', 'k2' ... 'kN'));        					  |
	|          																				  |
	******************************************************************************************/
	public static function model()
	{
		return self::library(func_get_args());
	}
	
	/******************************************************************************************
	* PAGE                                                                                    *
	*******************************************************************************************
	| Genel Kullanım: Views dosyası dahil etmek için kullanılır.						      |
	|															                              |
	| Parametreler: 3 parametresi vardır.                                                     |
	| 1. string var @page => Dahil edilecek dosyanın yolu.								      |
	| 2. array var @data => Dahil edilecen sayfaya gönderilecek veriler.				      |
	| 3. boolean var @ob_get_contents => İçeriğin kullanımıyla ilgilidir..		              |
	|          																				  |
	| Örnek Kullanım: import::page('OrnekSayfa');        	  								  |
	|          																				  |
	******************************************************************************************/
	public static function page($page = '', $data = '', $ob_get_contents = false)
	{
		if( ! is_string($page) )
		{
			return false;
		}
		
		if( is_array($data) )
		{
			extract($data, EXTR_OVERWRITE, 'extract');
		}
		
		if( $ob_get_contents === false )
		{
			if( ! is_file_exists(PAGES_DIR.suffix($page,".php")) ) 
			{
				return false;
			}
			require(PAGES_DIR.suffix($page,".php")); 
		}
		
		if( $ob_get_contents === true )
		{
			if( ! is_file_exists(PAGES_DIR.suffix($page,".php")) ) 
			{
				return false;
			}
			
			ob_start(); 
			require(PAGES_DIR.suffix($page,".php")); 
			$content = ob_get_contents(); 
			ob_end_clean(); 
			
			return $content ; 
		}
	
	}
	
	/******************************************************************************************
	* VIEW                                                                                    *
	*******************************************************************************************
	| Genel Kullanım: Views dosyası dahil etmek için kullanılır.						      |
	|															                              |
	| Parametreler: 3 parametresi vardır.                                                     |
	| 1. string var @page => Dahil edilecek dosyanın yolu.								      |
	| 2. array var @data => Dahil edilecen sayfaya gönderilecek veriler.				      |
	| 3. boolean var @ob_get_contents => İçeriğin kullanımıyla ilgilidir..		              |
	|          																				  |
	| Örnek Kullanım: import::page('OrnekSayfa');        	  								  |
	|          																				  |
	******************************************************************************************/
	public static function view($page = '', $data = '', $ob_get_contents = false)
	{
		return self::page($page, $data, $ob_get_contents);
	}
	
	/******************************************************************************************
	* TOOL                                                                                    *
	*******************************************************************************************
	| Genel Kullanım: Tools veya System/Tools dizinlerinde yer alan araçları		   	      |
	| dahil etmek için kullanılır.										  					  |
	|															                              |
	| Parametreler: Tek dizi parametresi vardır.                                              |
	| 1. array/args var @tools => Parametre olarak sıralı araçları veya dizi içinde	          |
	| eleman olarak kullanılan araçları dahil etmek için kullanılır.					      |
	|          																				  |
	| Örnek Kullanım: import::tool('t1', 't2' ... 'tN');        						  	  |
	| Örnek Kullanım: import::tool(array('t1', 't2' ... 'tN'));        				          |
	|          																				  |
	******************************************************************************************/
	public static function tool()
	{
		$config_tool = array_unique(config::get('Autoload','tool'));
		
		$arguments = func_get_args();
		
		if( isset($arguments[0]) && is_array($arguments[0]) )
		{
			$arguments = $arguments[0];
		}
		
		if( ! empty($arguments))foreach(array_unique($arguments) as $tool)
		{
			if( is_array($tool )) 
			{
				$tool = '';
			}
			
			if( ! in_array($tool, $config_tool) )
			{
				$tool_path = suffix($tool,".php");
				$path      = TOOLS_DIR.$tool_path;
				
				if( is_file_exists($path ) && ! is_import($path) ) 
				{
					require_once($path);				
				}
				elseif( is_file_exists(SYSTEM_TOOLS_DIR.$tool_path) && ! is_import(SYSTEM_TOOLS_DIR.$tool_path) ) 
				{			
					require_once(SYSTEM_TOOLS_DIR.$tool_path);				
				}
				else
				{
					return false;
				}
			}
		}
	}
	
	/******************************************************************************************
	* LANGUAGE                                                                                *
	*******************************************************************************************
	| Genel Kullanım: Languages veya System/Languages dizinlerinde yer alan dil dosyalarını   |
	| dahil etmek için kullanılır.										  					  |
	|															                              |
	| Parametreler: Tek dizi parametresi vardır.                                              |
	| 1. array/args var @languages => Parametre olarak sıralı dil dosyalarını veya dizi içinde|
	| eleman olarak kullanılan dil dosyalarını dahil etmek için kullanılır.					  |
	|          																				  |
	| Örnek Kullanım: import::language('l1', 'l2' ... 'lN');        						  |
	| Örnek Kullanım: import::language(array('l1', 'l2' ... 'lN'));        				      |
	|          																				  |
	******************************************************************************************/
	public static function language()
	{
		$config_language = array_unique(config::get('Autoload','language'));
		
		global $lang;

		$current_lang = config::get('Language',get_lang());

		$arguments = func_get_args();
		
		if( isset($arguments[0]) && is_array($arguments[0]) )
		{
			$arguments = $arguments[0];
		}
		
		if( ! empty($arguments) )foreach(array_unique($arguments) as $language)
		{	
			if( is_array($language) ) 
			{
				$language = '';
			}
			
			if( ! in_array($language, $config_language) )
			{
				$lang_path = $current_lang.'/'.suffix($language,".php");
				
				$path = LANGUAGES_DIR.$lang_path;
							
				if( is_file_exists($path) && ! is_import($path) ) 
				{
					require_once($path);	
				}
				elseif( is_file_exists(SYSTEM_LANGUAGES_DIR.$lang_path)  && ! is_import(SYSTEM_LANGUAGES_DIR.$lang_path) )
				{
					require_once(SYSTEM_LANGUAGES_DIR.$lang_path);	
				}
			}		
		}
		
		require_once CORE_DIR.'Lang.php';
	}
	
	/******************************************************************************************
	* MASTERPAGE                                                                              *
	*******************************************************************************************
	| Genel Kullanım: Views/Pages/ dizini içinde yer alan herhangi bir sayfayı masterpage     |
	| olarak ayarlamak için kullanılır.										  				  |
	|															                              |
	| Parametreler: 2 parametresi vardır.                                                     |
	| 1. array var @data => Sayfanın body bölümüne veri göndermek için kullanılır. 		      |
	| 2. array var @head => Sayfanın head bölümüne veri göndermek için kullanılır. 			  |
	|          																				  |
	| Örnek Kullanım: import::masterpage();        						  					  |
	|          																				  |
	| NOT: Bir sayfayı masterpage olarak ayarlamak için Config/Masterpage.php dosyası		  |
	| kullanılır.	        															      |
	|          																				  |
	******************************************************************************************/
	public static function masterpage($data = array(), $head = array())
	{	
		//------------------------------------------------------------------------------------
		// Config/Masterpage.php dosyasından ayarlar alınıyor. <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
		//------------------------------------------------------------------------------------
		$masterpageset = config::get('Masterpage');
		
		//------------------------------------------------------------------------------------
		// Başlık ve vücud sayfaları alınıyor. <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
		//------------------------------------------------------------------------------------
		$page = 		( isset($head['body_page']) ) 
					    ? $head['body_page'] 
						: $masterpageset['body_page'];
		
		$head_page = 	( isset($head['head_page']) ) 
					    ? $head['head_page'] 
						: $masterpageset['head_page'];
		//------------------------------------------------------------------------------------
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		//------------------------------------------------------------------------------------
	
		if( ! is_file(PAGES_DIR.suffix($page,".php")) )
		{ 
			$page = ''; 
		}
		else
		{ 
			$page = PAGES_DIR.suffix($page,".php");
		}
		
		if( ! is_file(PAGES_DIR.suffix($head_page,".php")) ) 
		{
			$head_page = ''; 
		}
		else
		{ 
			$head_page = PAGES_DIR.suffix($head_page,".php");
		}
		
		/*>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>HTML START<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<*/
		
		$header  = config::get('Doctype', $masterpageset['doctype']).ln();
		$header	.= '<html xmlns="http://www.w3.org/1999/xhtml">'.ln();
		
		/*>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>HEAD START<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<*/
		
		$header .= '<head>'.ln();
		
		if( is_array($masterpageset["content_charset"]) )
		{
			foreach($masterpageset["content_charset"] as $v)
			{
				$header .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=$v\">".ln();	
			}
		}
		else
		{
			$header .= '<meta http-equiv="Content-Type" content="text/html; charset='.$masterpageset['content_charset'].'">'.ln();	
		}
		
		$header .= '<meta http-equiv="Content-Language" content="'.config::get('Masterpage','content_language').'">'.ln();
			
		//------------------------------------------------------------------------------------
		// Data ve Meta verileri alınıyor. <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
		//------------------------------------------------------------------------------------					
		$datas 		= $masterpageset['data'];
						
		$metas 		= $masterpageset['meta'];
						
		$title 		= ( isset($head['title']) ) 			
					  ? $head['title'] 		
					  : $masterpageset["title"];
		//------------------------------------------------------------------------------------
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		//------------------------------------------------------------------------------------
		
		if( ! empty($title) ) 			
		{
			$header .= '<title>'.$title.'</title>'.ln();	
		}
		
		//------------------------------------------------------------------------------------
		// Meta tagları dahil ediliyor. <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
		//------------------------------------------------------------------------------------
		if( isset($head['meta']) )
		{
			$metas = array_merge($metas, $head['meta']);
		}
		
		if( ! empty($metas) ) foreach($metas as $name => $content)
		{
			if( isset($head['meta'][$name]) )
			{
				$content = $head['meta'][$name];
			}
			
			if( ! empty($content) )
			{
				$nameex = explode("->", $name);
				
				$httporname = ( $nameex[0] === 'http' )
							  ? 'http-equiv'
							  : 'name';
				
				$name 		= ( isset($nameex[1]) )
							  ? $nameex[1]
							  : $nameex[0];
							  
				if( ! is_array($content) )
				{			  
					$header .= "<meta $httporname=\"$name\" content=\"$content\">".ln();
				}
				else
				{
					foreach($content as $key => $val)
					{
						$header .= "<meta $httporname=\"$name\" content=\"$val\">".ln();	
					}	
				}
			}
		}
		//------------------------------------------------------------------------------------
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		//------------------------------------------------------------------------------------
		
		//------------------------------------------------------------------------------------
		// Fontlar dahil ediliyor. <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
		//------------------------------------------------------------------------------------
		if( ! empty($masterpageset["font"]) )
		{					
			$header .= self::font($masterpageset["font"], true);
		}
		
		if( isset($head['font']) )
		{					
			$header .= self::font($head['font'], true);
		}
		//------------------------------------------------------------------------------------
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		//------------------------------------------------------------------------------------
		
		//------------------------------------------------------------------------------------
		// Javascript kodları dahil ediliyor. <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
		//------------------------------------------------------------------------------------
		if( is_array($masterpageset['script']) )
		{
			$header .= self::script($masterpageset['script'], true);
		}
		
		if( isset($head['script']) )
		{
			$header .= self::script($head['script'], true);
		}
		//------------------------------------------------------------------------------------
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		//------------------------------------------------------------------------------------
		
		//------------------------------------------------------------------------------------
		// Stiller dahil ediliyor. <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
		//------------------------------------------------------------------------------------
		if( is_array($masterpageset['style']) )
		{
			$header .= self::style($masterpageset['style'], true);
		}
		
		if( isset($head['style']) )
		{
			$header .= self::style($head['style'], true);
		}
		//------------------------------------------------------------------------------------
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		//------------------------------------------------------------------------------------
		
		if( ! empty($masterpageset['browser_icon']) ) 
		{
			$header .= '<link rel="shortcut icon" href="'.base_url($masterpageset['browser_icon']).'" />'.ln();
		}
		
		if( ! empty($head['page_image']) ) 
		{
			$header .= '<link rel="image_src" href="'.$head['page_image'].'" />'.ln();	
		}
		
		//------------------------------------------------------------------------------------
		// Farklı veriler dahil ediliyor. <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
		//------------------------------------------------------------------------------------
		if( isset($head['data']) )
		{
			$datas = array_merge($datas, $head['data']);
		}
		
		if( ! empty($datas) )
		{ 
			if( ! is_array($datas) )
			{ 
				$header .= $datas.ln(); 
			}
			else
			{
				foreach($datas as $v)
				{
					$header .= $v.ln();	
				}	
			}
		}
		//------------------------------------------------------------------------------------
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		//------------------------------------------------------------------------------------
		
		//------------------------------------------------------------------------------------
		// Başlık sayfası dahil ediliyor. <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
		//------------------------------------------------------------------------------------
		if( ! empty($head_page) )
		{
			ob_start(); 
			
			require_once($head_page); 
			
			$content = ob_get_contents();
			 
			ob_end_clean(); 
			
			$header .= $content.ln() ; 	
		}
		//------------------------------------------------------------------------------------
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		//------------------------------------------------------------------------------------
		
		$header .= '</head>'.ln();
		/*>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>HEAD END<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<*/
		
		/*>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>BODY START<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<*/
		
		//------------------------------------------------------------------------------------
		// Arkaplan resmi dahil ediliyor. <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
		//------------------------------------------------------------------------------------
		if( $masterpageset["bg_image"] ) 
		{
			$bg_image = " background='".base_url($masterpageset["bg_image"])."' bgproperties='fixed'"; 
		}
		else 
		{
			$bg_image = "";
		}
		//------------------------------------------------------------------------------------
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		//------------------------------------------------------------------------------------
		
		$header .= '<body'.$bg_image.'>'.ln();
	
		echo $header;
		
		if( is_array($data) ) 
		{
			extract($data, EXTR_OVERWRITE, 'extract');
		}
		
		if( ! empty($page) ) 
		{
			require($page);	
		}
		
		$footer  = ln().'</body>'.ln();
		/*>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>BODY END<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<*/
		
		$footer .= '</html>';
		/*>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>HTML END<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<*/
		
		//------------------------------------------------------------------------------------
		// Masterpage oluşturuluyor. <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
		//------------------------------------------------------------------------------------
		echo $footer;	
		//------------------------------------------------------------------------------------
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		//------------------------------------------------------------------------------------
	}	
	
	/******************************************************************************************
	* FONT                                                                                    *
	*******************************************************************************************
	| Genel Kullanım: Harici font yüklemek için kullanılır. Yüklenmek istenen fontlar		  |
	| Views/Fonts/ dizinine atılır.										  				      |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. array/args var @fonts => Parametre olarak sıralı font dosyalarını veya dizi içinde   |
	| eleman olarak kullanılan font dosyalarını dahil etmek için kullanılır.			      |
	|          																				  |
	| Örnek Kullanım: import::font('f1', 'f2' ... 'fN');        						      |
	| Örnek Kullanım: import::font(array('f1', 'f2' ... 'fN'));        				          |
	|          																				  |
	******************************************************************************************/
	public static function font()
	{	
		$str = "<style type='text/css'>";
		
		$arguments = func_get_args();
		$args      = $arguments;
		
		if( isset($arguments[0]) && is_array($arguments[0]) )
		{
			$arguments = $arguments[0];
		}
		
		foreach(array_unique($arguments) as $font)
		{	
			if( is_array($font) ) 
			{
				$font = '';
			}
			
			$f = divide($font, "/", -1);
			// SVG IE VE MOZILLA DESTEKLEMIYOR
			if( is_file_exists(FONTS_DIR.$font.".svg") )
			{			
				$str .= '@font-face{font-family:"'.$f.'"; src:url("'.base_url(FONTS_DIR.$font.".svg").'") format("truetype")}'.ln();				
			}
			if( is_file_exists(FONTS_DIR.$font.".woff") )
			{			
				$str .= '@font-face{font-family:"'.$f.'"; src:url("'.base_url(FONTS_DIR.$font.".woff").'") format("truetype")}'.ln();		
			}
			// OTF IE VE CHROME DESTEKLEMIYOR
			if( is_file_exists(FONTS_DIR.$font.".otf") )
			{
				$str .= '@font-face{font-family:"'.$f.'"; src:url("'.base_url(FONTS_DIR.$font.".otf").'") format("truetype")}'.ln();			
			}
			
			// TTF IE DESTEKLEMIYOR
			if( is_file_exists(FONTS_DIR.$font.".ttf") )
			{		
				$str .= '@font-face{font-family:"'.$f.'"; src:url("'.base_url(FONTS_DIR.$font.".ttf").'") format("truetype")}'.ln();			
			}
			
			// FARKLI FONTLAR
			$differentset = config::get('Font', 'different_font_extensions');
			
			if( ! empty($differentset) )
			{			
				foreach($differentset as $of)
				{
					if( is_file_exists(FONTS_DIR.$font.prefix($of, '.')) )
					{		
						$str .= '@font-face{font-family:"'.$f.'"; src:url("'.base_url(FONTS_DIR.$font.prefix($of, '.')).'") format("truetype")}'.ln();			
					}
				}	
			}
			
			// EOT IE DESTEKLIYOR
			if( is_file_exists(FONTS_DIR.$font.".eot") )
			{
				$str .= '<!--[if IE]>';
				$str .= '@font-face{font-family:"'.$f.'"; src:url("'.base_url(FONTS_DIR.$font.".eot").'") format("truetype")}';
				$str .= '<![endif]-->';
				$str .= ln();
			}		
		}
		
		$str .= '</style>'.ln();
		
		if( ! empty($str) ) 
		{
			if( $args[count($args) - 1] === true )
			{
				return $str;
			}
			else
			{
				echo $str; 
			}
		}
		else
		{ 
			return false;
		}
	}
	
	/******************************************************************************************
	* STYLE                                                                                   *
	*******************************************************************************************
	| Genel Kullanım: Harici stil yüklemek için kullanılır. Yüklenmek istenen stiller		  |
	| Views/Styles/ dizinine atılır.									  				      |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. array/args var @styles => Parametre olarak sıralı stil dosyalarını veya dizi içinde  |
	| eleman olarak kullanılan stil dosyalarını dahil etmek için kullanılır.			      |
	|          																				  |
	| Örnek Kullanım: import::style('s1', 's2' ... 'sN');        						      |
	| Örnek Kullanım: import::style(array('s1', 's2' ... 'sN'));        				      |
	|          																				  |
	******************************************************************************************/
	public static function style()
	{
		$str = '';
		
		$arguments = func_get_args();
		$args      = $arguments;
		
		if( isset($arguments[0]) && is_array($arguments[0]) )
		{
			$arguments = $arguments[0];
		}
		
		foreach(array_unique($arguments) as $style)
		{
			if( is_array($style) ) 
			{
				$style = '';
			}	
		
			if( ! in_array("style_".$style, self::$is_import) )
			{
				if( is_file_exists(STYLES_DIR.suffix($style,".css")) )
				{
					$str .= '<link href="'.base_url().STYLES_DIR.suffix($style,".css").'" rel="stylesheet" type="text/css" />'.ln();
				}
				self::$is_import[] = "style_".$style;
			}
		}
		
		if( ! empty($str) ) 
		{
			if( $args[count($args) - 1] === true )
			{
				return $str;
			}
			else
			{
				echo $str; 
			}
		}
		else
		{ 
			return false;
		}
		
	}	

	/******************************************************************************************
	* SCRIPT                                                                                  *
	*******************************************************************************************
	| Genel Kullanım: Harici js dosyası yüklemek için kullanılır. Yüklenmek istenen stiller	  |
	| Views/Scripts/ dizinine atılır.										  				  |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. array/args var @scripts => Parametre olarak sıralı js dosyalarını veya dizi içinde   |
	| eleman olarak kullanılan js dosyalarını dahil etmek için kullanılır.			     	  |
	|          																				  |
	| Örnek Kullanım: import::script('s1', 's2' ... 'sN');        						      |
	| Örnek Kullanım: import::script(script('s1', 's2' ... 'sN'));        				      |
	|          																				  |
	******************************************************************************************/
	public static function script()
	{
		$str = '';
		
		$arguments = func_get_args();
		$args      = $arguments;
		
		if( isset($arguments[0]) && is_array($arguments[0]) )
		{
			$arguments = $arguments[0];
		}
		
		foreach(array_unique($arguments) as $script)
		{
			if( is_array($script) ) 
			{
				$script = '';
			}
			
			if( ! in_array("script_".$script, self::$is_import) )
			{
				if( is_file_exists(SCRIPTS_DIR.suffix($script,".js")) )
				{
					$str .= '<script type="text/javascript" src="'.base_url().SCRIPTS_DIR.suffix($script,".js").'"></script>'.ln();
				}
				
				if( $script === 'Jquery' || $script === 'JqueryUi' )
				{
					$str .= '<script type="text/javascript" src="'.base_url().REFERENCES_DIR.'Jquery/'.suffix($script,".js").'"></script>'.ln();
				}
				
				self::$is_import[] = "script_".$script;
			}
		}
		
		if( ! empty($str) ) 
		{
			if( $args[count($args) - 1] === true )
			{
				return $str;
			}
			else
			{
				echo $str; 
			}
		}
		else
		{ 
			return false;
		}
		
	}
	
	/******************************************************************************************
	* SOMETHING                                                                               *
	*******************************************************************************************
	| Genel Kullanım: Herhangi bir dosya dahil etmek için kullanılır.						  |
	|															                              |
	| Parametreler: 3 parametresi vardır.                                                     |
	| 1. string var @page => Dahil edilecek dosyanın yolu.								      |
	| 2. array var @data => Dahil edilecen sayfaya gönderilecek veriler.				      |
	| 3. boolean var @ob_get_contents => İçeriğin kullanımıyla ilgilidir..		              |
	|          																				  |
	| Örnek Kullanım: import::something('Application/Views/Pages/OrnekSayfa.php');        	  |
	| Örnek Kullanım: import::something('Application/Views/Style/Stil.js');        	          |
	|          																				  |
	******************************************************************************************/
	public static function something($page = '', $data = '', $ob_get_contents = false)
	{
		if( ! is_string($page) ) 
		{
			return false;
		}

		if( extension($page) === 'js' )
		{
			if( ! is_file_exists($page) ) 
			{
				return false;
			}
			echo '<script type="text/javascript" src="'.base_url().$page.'"></script>'.ln();
		}
		elseif( extension($page) === 'css' )	
		{
			if( ! is_file_exists($page) ) 
			{
				return false;
			}
			echo '<link href="'.base_url().$page.'" rel="stylesheet" type="text/css" />'.ln();
		}
		else
		{
			if( is_array($data) )
			{
				extract($data, EXTR_OVERWRITE, 'extract');
			}
			
			$extension = ! extension($page)
						 ? '.php'
						 : '';
			
			$page .= $extension;
			
			if( $ob_get_contents === false )
			{
				if( ! is_file_exists($page) ) 
				{
					return false;
				}
				
				require($page); 
			}
			
			if( $ob_get_contents === true )
			{
				if( ! is_file_exists($page) ) 
				{
					return false;
				}
				
				ob_start(); 
				require($page); 
				$content = ob_get_contents(); 
				ob_end_clean();
				
				return $content ; 
			}
		}
	}
	
	/******************************************************************************************
	* PACKAGE                                                                                 *
	*******************************************************************************************
	| Genel Kullanım: Bir dizin içindeki dosyaları aynı anda dahil etmek için kullanılır.	  |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. string var @packages => Dahil edilecek dosyaların bulunduğu dizin.					  |
	|          																				  |
	| Örnek Kullanım: import::something('Application/Views/Pages/');        	              |
	|          																				  |
	******************************************************************************************/
	public static function package($packages = "", $different_extension = array() )
	{
		if( ! ( is_string($packages) || is_dir_exists($packages) || is_array($different_extension) ) ) 
		{
			return false;
		}
	
		if( folder::files($packages) ) 
		{
			foreach(folder::files($packages) as $val)
			{				
				if( extension($val) === "php" )
				{
					require_once (suffix($packages).$val);
				}
				elseif( extension($val) === "js" )
				{
					echo '<script type="text/javascript" src="'.base_url().suffix($packages).$val.'"></script>'.ln();
				}
				elseif( extension($val) === "css" )
				{
					echo '<link href="'.base_url().suffix($packages).$val.'" rel="stylesheet" type="text/css" />'.ln();
				}
				else
				{
					if( ! empty($different_extension) )
					{
						if( in_array(extension($val), $different_extension) )
						{
							require_once(suffix($packages).$val);	
						}
					}
				}
			}
		}
		else 
		{
			return false;
		}
	}
}