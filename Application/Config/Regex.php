<?php
/************************************************************/
/*                           REGEX                          */
/************************************************************/
/*

Author: Ozan UYKUN
Site: http://www.zntr.net
Copyright 2012-2015 zntr.net - Tüm hakları saklıdır.

/******************************************************************************************
* REGULAR EXPIRESSIONS                                                                    *
*******************************************************************************************
| Genel Kullanımı: Regex.php kütüphanesi ile ilgili ayarları içerir.					  |
******************************************************************************************/

/******************************************************************************************
* REGULAR EXPIRESSION CHARS                                                               *
*******************************************************************************************
| Genel Kullanımı: Düzenli ifadelerde yer alan özel karakterlerle ilgili aşağıdaki 		  |
| değişiklikler yapılmıştır.					  										  |
******************************************************************************************/
$config['Regex']['regex_chars'] = array
(
	'<non-numeric>' 	=> '\D',
	'<numeric>' 		=> '\d',
	'<schar>' 			=> '\W',
	'<non-schar>' 		=> '\w',
	'<char>' 			=> '.',
	'<non-space>' 		=> '\S',
	'<space>'			=> '\s',
	'<starting>'		=> '^',
	'<ending>'			=> '$',
	'<repeat-z>'		=> '*',
	'<repeat>'			=> '+',
	'<whether>'			=> '?',
	'<or>'				=> '|',
	'<perline-r>'		=> '\r',
	'<perline>'			=> '\n',
	'<tab>'				=> '\t',
	'<esc>'				=> '\e',
	'<hex>'				=> '\x'
);

/******************************************************************************************
* REGULAR EXPIRESSION SETTING CHARS                                                       *
*******************************************************************************************
| Genel Kullanımı: Düzenli ifadelerde oluşturulan desen sonuna konulan karakterlerle 	  |
| ilgili aşağıdaki değişiklikler yapılmıştır 											  |
******************************************************************************************/
$config['Regex']['setting_chars'] = array
(
	'<insens>' 			=> 'i',
	'<generic>' 		=> 'g',
	'<each>' 			=> 's',
	'<multiline>'		=> 'm', 
	'<inspace>' 		=> 'x'
);

/******************************************************************************************
* REGULAR EXPIRESSION SPECIAL CHARS                                                       *
*******************************************************************************************
| Genel Kullanımı: Düzenli ifadelerde yer alan özel karakterleri normal karakterler gibi  |
| kullanmak için aşağıdaki değişiklikler yapılmıştır.									  |
******************************************************************************************/
$config['Regex']['special_chars'] = array
(
	'.' 				=> '\.',
	'^' 				=> '\^',
	'$' 				=> '\$',
	'*' 				=> '\*',
	'+' 				=> '\+',
	'?' 				=> '\?',
	'|' 				=> '\|',
	'/' 				=> '\/'
);