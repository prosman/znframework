<?php
/************************************************************/
/*                    CAPTCHA COMPONENT                     */
/************************************************************/
/*

Author: Ozan UYKUN
Site: http://www.zntr.net
Copyright 2012-2015 zntr.net - Tüm hakları saklıdır.

*/
namespace Captcha;

use Config;
/******************************************************************************************
* CAPTCHA                                                                                 *
*******************************************************************************************
| Dahil(Import) Edilirken : CCaptcha            							     		  |
| Sınıfı Kullanırken      :	$this->ccaptcha->     									      |
| 																						  |
| Kütüphanelerin kısa isimlendirmelerle kullanımı için. Config/Libraries.php bakınız.     |
******************************************************************************************/
class CCaptcha
{
	/* Settings Değişkeni
	 *  
	 * Güvenlik kodu nesnesine ait
	 * ayarlar bilgilerini tutması
	 * için oluşturulumuştur.
	 */
	protected $sets = array();
	
	/******************************************************************************************
	* WIDTH                                                                                   *
	*******************************************************************************************
	| Genel Kullanım: Güvenlik kodu nesnesinin genişlik değeri belirtilir.					  |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. numeric var @param => Güvenlik kod nesnesinin genişliği.					          |
	|          																				  |
	| Örnek Kullanım: ->width(100)         													  |
	|          																				  |
	******************************************************************************************/
	public function width($param = 0)
	{
		if( ! is_numeric($param) )
		{
			return $this;	
		}
		
		if( ! empty($param) )
		{
			$this->sets['width'] = $param;
		}
		
		return $this;
	}
	
	/******************************************************************************************
	* HEIGHT                                                                                  *
	*******************************************************************************************
	| Genel Kullanım: Güvenlik kodu nesnesinin yükseklik değeri belirtilir.					  |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. numeric var @param => Güvenlik kod nesnesinin yüksekliği.					          |
	|          																				  |
	| Örnek Kullanım: ->height(20)         													  |
	|          																				  |
	******************************************************************************************/
	public function height($param = 0)
	{
		if( ! is_numeric($param) )
		{
			return $this;	
		}
		
		if( ! empty($param) )
		{
			$this->sets['height'] = $param;
		}
		
		return $this;
	}
	
	/******************************************************************************************
	* SIZE                                                                                    *
	*******************************************************************************************
	| Genel Kullanım: Güvenlik kodu nesnesinin genişlikk ve yükseklik değeri belirtilir.      |
	|															                              |
	| Parametreler: 2 parametresi vardır.                                                     |
	| 1. numeric var @width => Güvenlik kod nesnesinin genişliği.					          |
	| 2. numeric var @height => Güvenlik kod nesnesinin yüksekliği.					          |
	|          																				  |
	| Örnek Kullanım: ->size(100, 20)         												  |
	|          																				  |
	******************************************************************************************/
	public function size($width = 0, $height = 0)
	{
		$this->width($width);
		$this->height($height);
		
		return $this;
	}
	
	/******************************************************************************************
	* LENGTH                                                                                  *
	*******************************************************************************************
	| Genel Kullanım: Güvenlik kodu nesnesinin kaç karakterden olacağı belirtilir.		      |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. numeric var @param => Güvenlik kod nesnesinin karakter uzunluğu.	     	          |
	|          																				  |
	| Örnek Kullanım: ->length(6)            												  |
	|          																				  |
	******************************************************************************************/
	public function length($param = 0)
	{
		if( ! is_numeric($param) )
		{
			return $this;	
		}
		
		if( ! empty($param) )
		{
			$this->sets['char_count'] = $param;
		}
		
		return $this;
	}
	
	/******************************************************************************************
	* BORDER                                                                                  *
	*******************************************************************************************
	| Genel Kullanım: Güvenlik kodu nesnesinin çerçevesinin olup olmayacağı olacaksa da hangi.|		      
	| hangi renkte olacağı belirtilir.												          |
	|															                              |
	| Parametreler: 2 parametresi vardır.                                                     |
	| 1. boolean var @is => Çerçeve olsun mu? True ayarlanması durumunda çerçeve oluşturulur. |
	| 2. string var @color => Çerçeve rengi belirtilir. RGB standartına uygun renk değerleri 
	| yazılır. Örnek 255|10|180 gibi renkler yazılırken aralarına dik çizgi(|) ilave edilir.  |
	|          																				  |
	| Örnek Kullanım: ->border(true, '255|10|180')            								  |
	|          																				  |
	******************************************************************************************/
	public function border($is = true, $color = '')
	{
		if( ! ( is_bool($is) && is_string($color) ) )
		{
			return $this;	
		}
		
		$this->sets['border'] = $is;
		
		if( ! empty($color) )
		{
			$this->sets['border_color'] = $color;
		}
		
		return $this;
	}
	
	/******************************************************************************************
	* BORDER COLOR                                                                            *
	*******************************************************************************************
	| Genel Kullanım: Güvenlik kodu çerçeve rengini ayarlamak için kullanılır.				  |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 2. string var @color => Çerçeve rengi belirtilir. RGB standartına uygun renk değerleri  |
	| yazılır. Örnek 255|10|180 gibi renkler yazılırken aralarına dik çizgi(|) ilave edilir.  |
	|          																				  |
	| Örnek Kullanım: ->border_color('255|10|180')            								  |
	|          																				  |
	******************************************************************************************/
	public function border_color($color = '')
	{
		if( ! is_string($color) )
		{
			return $this;	
		}

		if( ! empty($color) )
		{
			$this->sets['border_color'] = $color;
		}
		
		return $this;
	}
	
	/******************************************************************************************
	* BACKGROUND COLOR                                                                        *
	*******************************************************************************************
	| Genel Kullanım: Güvenlik kodu arkaplan rengini ayarlamak için kullanılır.				  |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. string var @color => Arkaplan rengi belirtilir. RGB standartına uygun renk değerleri |
	| yazılır. Örnek 255|10|180 gibi renkler yazılırken aralarına dik çizgi(|) ilave edilir.  |
	|          																				  |
	| Örnek Kullanım: ->bgcolor('255|10|180')            								      |
	|          																				  |
	******************************************************************************************/
	public function bgcolor($color = '')
	{
		if( ! is_string($color) )
		{
			return $this;	
		}
		
		if( ! empty($color) )
		{
			$this->sets['bg_color'] = $color;
		}
		
		return $this;
	}
	
	/******************************************************************************************
	* BACKGROUND IMAGE                                                                        *
	*******************************************************************************************
	| Genel Kullanım: Güvenlik kodu arkaplan resimleri ayarlamak için kullanılır.			  |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 2. string/array var @image => Arkplana resimler eklemek için kullanılır. Tek bir resim  |
	| resim eklenecekse string türde parametre girilebilir. Ancak çoklu resim eklenmesi       |
	| isteniyorsa bu durumda dizi türünde parametre girilir.  								  |
	|          																				  |
	| Örnek Kullanım: ->bgcolor('255|10|180')            								      |
	|          																				  |
	******************************************************************************************/
	public function bgimage($image = array())
	{
		if( ! empty($image) )
		{
			if( is_string($image) )
			{
				$this->sets['background'] = array($image);
			}
			elseif( is_array($image) )
			{
				$this->sets['background'] = $image;	
			}
		}
		
		return $this;
	}
	
	/******************************************************************************************
	* BACKGROUND                                                                              *
	*******************************************************************************************
	| Genel Kullanım: Güvenlik kodu arkaplan rengini veya resimlerini ayarlamak için 		  |
	| kullanılır. Bgimage ve bgcolor yöntemlerinin alternatifidir.					  		  |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 2. string/array var @image => Arkplana resimler eklemek için kullanılır. Tek bir resim  |
	| resim eklenecekse string türde parametre girilebilir. Ancak çoklu resim eklenmesi       |
	| isteniyorsa bu durumda dizi türünde parametre girilir.  								  |
	|          																				  |
	| Örnek Kullanım: ->background('255|10|180') // Arkplan rengi          					  |
	| Örnek Kullanım: ->background('a/b.jpg') // Arkaplan resmi          					  |
	| Örnek Kullanım: ->background(array('a/b1.jpg', 'a/b2.jpg')) // Arkaplan resimleri       |
	|          																				  |
	******************************************************************************************/
	public function background($background = '')
	{
		if( is_string($background) && ! is_file($background) )
		{
			$this->bgcolor($background);
		}
		else
		{
			$this->bgimage($background);	
		}
		
		return $this;
	}
	
	/******************************************************************************************
	* TEXT SIZE                                                                   			  *
	*******************************************************************************************
	| Genel Kullanım: Güvenlik kodu metninin boyutunu ayarlamak içindir.	 				  |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. numeric var @size => Metnin boyutudur.  								  			  |
	|          																				  |
	| Örnek Kullanım: ->text_size(5)            								      		  |
	|          																				  |
	******************************************************************************************/
	public function text_size($size = 0)
	{
		if( ! is_numeric($size) )
		{
			return $this;
		}
		
		if( ! empty($size) )
		{
			$this->sets['image_string']['size'] = $size;
		}
		
		return $this;
	}
		
	/******************************************************************************************
	* CORDINATE                                                                        		  *
	*******************************************************************************************
	| Genel Kullanım: Güvenlik kodu metninin koordinatlarını ayarlamak için kullanılır.	      |
	|															                              |
	| Parametreler: 2 parametresi vardır.                                                     |
	| 1. numeric var @x => Metnin yatay düzlemdeki değeri.  								  |
	| 2. numeric var @y => Metnin dikey düzlemdeki değeri.  								  |
	|          																				  |
	| Örnek Kullanım: ->text_coordinate(60, 10)            								      |
	|          																				  |
	******************************************************************************************/
	public function text_coordinate($x = 0, $y)
	{
		if( ! is_numeric($x) || ! is_numeric($y) )
		{
			return $this;
		}

		if( ! empty($x) ) 
		{
			$this->sets['image_string']['x'] = $x;
		}
		
		if( ! empty($y) )
		{ 
		 	$this->sets['image_string']['y'] = $y;
		}
		
		return $this;
	}
	
	/******************************************************************************************
	* TEXT COLOR                                                                      		  *
	*******************************************************************************************
	| Genel Kullanım: Güvenlik kodu metninin rengini ayarlamak için kullanılır.	              |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. string var @color => Yazının rengi belirtilir. RGB standartına uygun renk değerleri  |
	| yazılır. Örnek 255|10|180 gibi renkler yazılırken aralarına dik çizgi(|) ilave edilir.  |
	| Örnek Kullanım: ->text_color('90|10|30')            								      |
	|          																				  |
	******************************************************************************************/
	public function text_color($color = '')
	{
		if( ! is_string($color) )
		{
			return $this;	
		}
		
		if( ! empty($color) )
		{
			$this->sets['font_color'] = $color;
		}
		
		return $this;
	}
	
	/******************************************************************************************
	* TEXT                                                                        			  *
	*******************************************************************************************
	| Genel Kullanım: Güvenlik kodu metninin boyutu x ve ye değerlerini ayarlamak içindir.	  |
	|															                              |
	| Parametreler: 3 parametresi vardır.                                                     |
	| 1. numeric var @size => Metnin boyutudur.  								  			  |
	| 2. numeric var @x => Metnin yatay düzlemdeki değeri.  								  |
	| 3. numeric var @y => Metnin dikey düzlemdeki değeri.  								  |
	| 4. string var @color => Metnin rengi.  								 			      |
	|          																				  |
	| Örnek Kullanım: ->text(5, 60, 10)            								      		  |
	|          																				  |
	******************************************************************************************/
	public function text($size = 0, $x = 0, $y = 0, $color = '')
	{
		if( ! is_numeric($size) || ! is_numeric($x) || ! is_numeric($y) )
		{
			return $this;
		}
		
		if( ! empty($size) )
		{
			$this->text_size($size);
		}
		
		if( ! empty($x) && ! empty($y) )
		{
			$this->text_coordinate($x, $y);
		}
		
		if( ! empty($color) )
		{
			$this->text_color($color);
		}
		
		return $this;
	}
	
	/******************************************************************************************
	* GRID                                                                                    *
	*******************************************************************************************
	| Genel Kullanım: Güvenlik kodu nesnesinin ızgarasının olup olmayacağı olacaksa da hangi. |		      
	| hangi renkte olacağı belirtilir.												          |
	|															                              |
	| Parametreler: 2 parametresi vardır.                                                     |
	| 1. boolean var @is => Izgara olsun mu? True ayarlanması durumunda ızgara oluşturulur.   |
	| 2. string var @color => Izgara rengi belirtilir. RGB standartına uygun renk değerleri   |
	| yazılır. Örnek 255|10|180 gibi renkler yazılırken aralarına dik çizgi(|) ilave edilir.  |
	|          																				  |
	| Örnek Kullanım: ->grid(true, '255|10|180')            								  |
	|          																				  |
	******************************************************************************************/
	public function grid($is = true, $color = '')
	{
		if( ! ( is_bool($is) && is_string($color) ) )
		{
			return $this;	
		}

		$this->sets['grid'] = $is;
		
		if( ! empty($color) )
		{
			$this->sets['grid_color'] = $color;
		}
		
		return $this;
	}
	
	/******************************************************************************************
	* GRID COLOR                                                                              *
	*******************************************************************************************
	| Genel Kullanım: Güvenlik kodu ızgara rengini ayarlamak için kullanılır.				  |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 2. string var @color => Izgara rengi belirtilir. RGB standartına uygun renk değerleri   |
	| yazılır. Örnek 255|10|180 gibi renkler yazılırken aralarına dik çizgi(|) ilave edilir.  |
	|          																				  |
	| Örnek Kullanım: ->grid_color('255|10|180')            								  |
	|          																				  |
	******************************************************************************************/
	public function grid_color($color = '')
	{
		if( ! is_string($color) )
		{
			return $this;	
		}

		if( ! empty($color) )
		{		
			$this->sets['grid_color'] = $color;
		}
		
		return $this;
	}
	
	/******************************************************************************************
	* GRID SPACE                                                                      		  *
	*******************************************************************************************
	| Genel Kullanım: Güvenlik kodu ızgara boşluklarını ayarlamak için kullanılır.	          |
	|															                              |
	| Parametreler: 2 parametresi vardır.                                                     |
	| 1. numeric var @x => Izgaranın yatay düzlemdeki sayısı.  								  |
	| 2. numeric var @y => Izgaranın dikey düzlemdeki sayısı.  								  |
	|          																				  |
	| Örnek Kullanım: ->grid_space(4, 12)	            								      |
	|          																				  |
	******************************************************************************************/
	public function grid_space($x = 0, $y = 0)
	{
		if( ! is_numeric($x) || ! is_numeric($y) )
		{
			return $this;
		}

		if( ! empty($x) ) 
		{
			$this->sets['grid_space']['x'] = $x;
		}
		
		if( ! empty($y) )
		{ 
		 	$this->sets['grid_space']['y'] = $y;
		}
		
		return $this;
	}
	
	/******************************************************************************************
	* CREATE                                                                        		  *
	*******************************************************************************************
	| Genel Kullanım: Güvenlik kodunu oluşturma yöntemidir.	Zincirin en son halkasıdır.		  |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. boolean var @img => Kod bir <img> nesnesi ile mi kullanılsın yoksa sadece url mi?	  |
	| üretsin? True olması durumunda img nesnesi içerisinde bir resim olarak görüntülenecektir|
	|          																				  |
	| Örnek Kullanım: ->create();	            								     		  |
	|          																				  |
	******************************************************************************************/
	public function create($img = false)
	{
		if( ! isset($_SESSION) ) 
		{
			session_start();
		}
		
		$set = config::get("Captcha");
		
		if( isset($this->sets["char_count"])) $set["char_count"] = $this->sets["char_count"];
		
		$_SESSION[md5('captcha_code')] = substr(md5(rand(0,999999999999999)),-($set["char_count"]));	
		
		if( isset($_SESSION[md5('captcha_code')]) )
		{
			if( isset($this->sets["width"])) $set["width"] 									= $this->sets["width"];
			if( isset($this->sets["height"])) $set["height"] 								= $this->sets["height"];		
			if( isset($this->sets["font_color"])) $set["font_color"] 						= $this->sets["font_color"];
			if( isset($this->sets["bg_color"])) $set["bg_color"] 							= $this->sets["bg_color"];
			if( isset($this->sets["border"]))$set["border"] 								= $this->sets["border"];
			if( isset($this->sets["border_color"])) $set["border_color"] 					= $this->sets["border_color"];
			if( isset($this->sets["image_string"]["size"]))$set["image_string"]["size"] 	= $this->sets["image_string"]["size"];
			if( isset($this->sets["image_string"]["x"]))$set["image_string"]["x"] 			= $this->sets["image_string"]["x"];
			if( isset($this->sets["image_string"]["y"]))$set["image_string"]["y"] 			= $this->sets["image_string"]["y"];
			if( isset($this->sets["grid"]))$set["grid"] 									= $this->sets["grid"]; 
			if( isset($this->sets["grid_space"]["x"]))$set["grid_space"]["x"] 				= $this->sets["grid_space"]["x"]; 
			if( isset($this->sets["grid_space"]["y"]))$set["grid_space"]["y"] 				= $this->sets["grid_space"]["y"]; 
			if( isset($this->sets["grid_color"]))$set["grid_color"]						    = $this->sets["grid_color"];
			if( isset($this->sets["background"]))$set["background"]						    = $this->sets["background"];
			
			// 0-255 arasında değer alacak renk kodları için
			// 0|20|155 gibi bir kullanım için aşağıda
			// explode ile ayırma işlemleri yapılmaktadır.
			
			// SET FONT COLOR
			$set_font_color = explode("|",$set["font_color"]);
			
			// SET BG COLOR
			$set_bg_color	= explode("|",$set["bg_color"]);
			
			// SET BORDER COLOR
			$set_border_color	= explode("|",$set["border_color"]);
			
			// SET GRID COLOR
			$set_grid_color	= explode("|",$set["grid_color"]);
			
			
			$file = @imagecreatetruecolor($set["width"], $set["height"]);	  
				  
			$font_color 	= @imagecolorallocate($file, $set_font_color[0], $set_font_color[1], $set_font_color[2]);
			$color 			= @imagecolorallocate($file, $set_bg_color[0], $set_bg_color[1], $set_bg_color[2]);
			
			// ARKAPLAN RESMI--------------------------------------------------------------------------------------
			if( ! empty($set["background"]) )
			{
				if( is_array($set["background"]) )
				{
					$set["background"] = $set["background"][rand(0, count($set["background"]) - 1)];
				}
				/***************************************************************************/
				// Arkaplan resmi için geçerli olabilecek uzantıların kontrolü yapılıyor.
				/***************************************************************************/	
				if( strtolower(pathinfo($set["background"], PATHINFO_EXTENSION)) === 'png' )
				{
					$file = imagecreatefrompng($set["background"]);
				}
				if( strtolower(pathinfo($set["background"], PATHINFO_EXTENSION)) === 'jpeg' )
				{	
					$file = imagecreatefromjpeg($set["background"]);
				}
				if( strtolower(pathinfo($set["background"], PATHINFO_EXTENSION)) === 'jpg' )
				{	
					$file = imagecreatefromjpeg($set["background"]);
				}
				if( strtolower(pathinfo($set["background"], PATHINFO_EXTENSION)) === 'gif' )
				{	
					$file = imagecreatefromgif($set["background"]);
				}
			}
			else
			{
				// Arkaplan olarak resim belirtilmemiş ise arkaplan rengini ayarlar.
				@imagefill($file, 0, 0, $color);
			}
			//-----------------------------------------------------------------------------------------------------
			
			// Resim üzerinde görüntülenecek kod bilgisi.
			@imagestring($file, $set["image_string"]["size"], $set["image_string"]["x"], $set["image_string"]["y"],  $_SESSION[md5('captcha_code')], $font_color);
			
			// GRID --------------------------------------------------------------------------------------
			if( $set["grid"] === true )
			{
				$grid_interval_x  = $set["width"] / $set["grid_space"]["x"];
				
				if( ! isset($set["grid_space"]["y"]) )
				{
					$grid_interval_y  = (($set["height"] / $set["grid_space"]["x"]) * $grid_interval_x / 2);
					
				} 
				else 
				{
					$grid_interval_y  = $set["height"] / $set["grid_space"]["y"];
				}
				
				$grid_color 	= @imagecolorallocate($file, $set_grid_color[0], $set_grid_color[1], $set_grid_color[2]);
				
				for($x = 0 ; $x <= $set["width"] ; $x += $grid_interval_x)
				{
					@imageline($file,$x,0,$x,$set["height"] - 1,$grid_color);
				}
				
				for($y = 0 ; $y <= $set["width"] ; $y += $grid_interval_y)
				{
					@imageline($file,0,$y,$set["width"],$y,$grid_color);
				}
				
			}
			// ---------------------------------------------------------------------------------------------	
			
			// BORDER --------------------------------------------------------------------------------------
			if( $set["border"] === true )
			{
				$border_color 	= @imagecolorallocate($file, $set_border_color[0], $set_border_color[1], $set_border_color[2]);
				
				@imageline($file, 0, 0, $set["width"], 0, $border_color); // UST
				@imageline($file, $set["width"] - 1, 0, $set["width"] - 1, $set["height"], $border_color); // SAG
				@imageline($file, 0, $set["height"] - 1, $set["width"], $set["height"] - 1, $border_color); // ALT
				@imageline($file, 0, 0, 0, $set["height"] - 1, $border_color); // SOL
			}
			// ---------------------------------------------------------------------------------------------
			
			$file_path = FILES_DIR.'capcha';
			
			if( function_exists('imagepng') )
			{
				$extension = '.png';
				imagepng($file, $file_path.$extension);
			}
			elseif( function_exists('imagejpg'))
			{
				$extension = '.jpg';
				imagepng($file, $file_path.$extension);		
			}
			else
			{
				return false;
			}
			
			$file_path .= $extension;
			
			if( $img === true )
			{	
				$captcha = '<img src="'.base_url($file_path).'">';
			}
			else
			{
				$captcha = base_url($file_path);
			}
			
			imagedestroy($file);
			
			$this->sets = NULL;
			
			return $captcha;
		}		
	}
	
	/******************************************************************************************
	* GET CODE                                                                        		  *
	*******************************************************************************************
	| Genel Kullanım: Oluşturulan güvenlik kodunu öğrenmek için kullanılır.		 		      |															       
	|          																				  |
	| Örnek Kullanım: ->get_code();	//f923f5            								      |
	|          																				  |
	******************************************************************************************/
	public function get_code()
	{
		if( ! isset($_SESSION) ) 
		{
			session_start();
		}
		
		return $_SESSION[md5('captcha_code')];	
	}
}