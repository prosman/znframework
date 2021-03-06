<?php
/************************************************************/
/*                       AUTOLOADS                          */
/************************************************************/
/*

Author: Ozan UYKUN
Site: http://www.zntr.net
Copyright 2012-2015 zntr.net - Tüm hakları saklıdır.

/* DOĞRUDAN DEĞİŞKEN ERİŞİMİ KULLAN
 *
 * Static @var zn::use
 *
 */
 
zn::$use = using();

/* DORĞUDAN YÖNTEMSEL ERİŞİM KULLAN
 *
 * Global @func this()
 *
 */
function this()
{
	return zn::$use;
}

/* STARTING RUN *
 *
 * 
 * Sistem Başlatılıyor
 */
Starting::run();

/******************************************************************************************
* STARTING CLASS                                                                          *
*******************************************************************************************
| Sistem başlangıç sınıfıdır.    														  |
******************************************************************************************/
class Starting
{
	public static function run()
	{	
		// INI AYARLAR YAPILANDIRILIYOR...
		$iniset = config::get('Ini', 'settings');
		
		if( ! empty($iniset) ) 
		{
			config::iniset($iniset);
		}
		// ----------------------------------------------------------------------
		
				
		// HTACCESS DOSYASI OLUŞTURULUYOR... 	
		if( config::get('Htaccess','create_file') === true ) 
		{
			create_htaccess_file();
		}	
		// ----------------------------------------------------------------------
		
		// OTOMATİK YÜKLEMELER İŞLENİYOR...		
		$autoload = config::get('Autoload');
		
		// Kütüphaneleri otomatik yükle.
		if( ! empty($autoload['library']) )	
		{
			import::library($autoload['library']);
		}
		
		// Bileşenleri otomatik yükle.
		if( ! empty($autoload['component']) )	
		{
			import::component($autoload['component']);
		}
		
		// Araçları otomatik yükle.
		if( ! empty($autoload['tool']) )	
		{
			import::tool($autoload['tool']);
		}
		
		// Dil dosyalarını otomatik yükle.
		if( ! empty($autoload['language']) )	
		{
			import::language($autoload['language']);
		}
		
		// Model dosyalarını otomatik yükle.
		if( ! empty($autoload['model']) )	
		{
			import::model($autoload['model']);
		}	
		// ----------------------------------------------------------------------
		
		// COMPOSER AUTOLOAD		
		if( $autoload['composer'] === true )
		{
			( file_exists('vendor/autoload.php') )
			? require_once('vendor/autoload.php')
			: report('Error','vendor/autoload.php was not found.','AutoloadComposer');
		}
		elseif( file_exists($autoload['composer']) )
		{
			require_once($autoload['composer']);
		}
		elseif( ! empty($autoload['composer']) )
		{
			report('Error', $autoload['composer'].' was not found.','AutoloadComposer');
		}
		// ----------------------------------------------------------------------	
	}
}