<?php

/**
 * cut given string by length
 * @param $string
 * @param $max_length
 * @param bool|true $dot
 * @return string
 */
function str_stop($string, $max_length, $dot = TRUE)
{
	return mb_strimwidth($string, 0, $max_length, $dot ? '...' : '', 'UTF-8');
}

/**
 * convert array to json data and print it
 * @param $jsondata
 * @param $die
 * @echo json
 */
function echoj($jsondata, $die = TRUE)
{
	header('Content-Type: application/json');
	echo json_encode($jsondata);
	if ($die) {
		die();
	}
}

/**
 * Translate English number to persian and reverse
 * @param $str
 * @param bool $en
 * @return string|string[]
 */
function number_translator($str, $en = TRUE)
{
	if ($en) {
		$newstring = str_replace(array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), $str);
	}
	if (!$en) {
		$newstring = str_replace(array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'), array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), $str);
	}
	return $newstring;
}



/**
 * close unclosed html tags
 * @param $html
 * @return string
 */
function closetags($html): string
{
	#put all opened tags into an array
	preg_match_all("#<([a-z]+)( .*)?(?!/)>#iU", $html, $result);
	$openedtags = $result[1];
	#put all closed tags into an array
	preg_match_all("#</([a-z]+)>#iU", $html, $result);
	$closedtags = $result[1];
	$len_opened = count($openedtags);
	# all tags are closed
	if (count($closedtags) == $len_opened) {
		return $html;
	}
	$openedtags = array_reverse($openedtags);
	# close tags
	for ($i = 0; $i < $len_opened; $i++) {
		if (!in_array($openedtags[$i], $closedtags)) {
			if ($openedtags[$i] != 'br') {
				
				$html .= "</" . $openedtags[$i] . ">";
			}
		} else {
			unset ($closedtags[array_search($openedtags[$i], $closedtags)]);
		}
	}
	return $html;
}

/**
 * Validate user name
 * @param $str
 * @return bool
 */
function ValidateUsername($str)
{
	if (empty($str)) {
		return FALSE;
	}
	$allowed = array(".", "-", "_"); // you can add here more value, you want to allow.
	if (ctype_alnum(str_replace($allowed, '', $str)) && preg_match('/^[a-zA-Z0-9._-]{3,}$/', $str)) {
		return TRUE;
	} else {
		return FALSE;
	}
}


/**
 * Validate email
 * @param $str
 * @return bool
 */
function ValidateEmail($str)
{
	if (empty($str)) {
		return FALSE;
	}
	$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
	if (!preg_match($regex, $str)) {
		return FALSE;
	} else {
		return TRUE;
	}
}

/**
 * validate password
 * @param $str
 * @return bool
 */
function ValidatePassword($str)
{
	if (empty($str)) {
		return FALSE;
	}
	if (strlen($str) < 6 || strlen($str) > 30) {
		return FALSE;
	} else {
		return TRUE;
	}
}


/**
 * validate mobile number
 * @param $number
 * @return bool
 */
function ValidateMobile($number)
{
	if (strlen($number) != 11 || !is_numeric($number)) {
		return FALSE;
	} else {
		return TRUE;
	}
}



/**
 * remove exact query string from url given
 * @param $url
 * @param $varname
 * @return string
 */
function removeQueryStringParameter($url, $varname)
{
	$parsedUrl = parse_url($url);
	$query     = array();
	if (isset($parsedUrl['query'])) {
		parse_str($parsedUrl['query'], $query);
		unset($query[$varname]);
	}
	
	$path  = isset($parsedUrl['path']) ? $parsedUrl['path'] : '';
	$query = !empty($query) ? '?' . http_build_query($query) : '';
	
	return $parsedUrl['scheme'] . '://' . $parsedUrl['host'] . $path . $query;
}


/**
 * convert string size to bytes
 * @param $Size
 * @return float|int
 */
function StringSizeToBytes($Size)
{
	$Unit     = strtolower($Size);
	$Unit     = preg_replace('/[^a-z]/', '', $Unit);
	$Value    = intval(preg_replace('/[^0-9]/', '', $Size));
	$Units    = array('b' => 0, 'kb' => 1, 'mb' => 2, 'gb' => 3, 'tb' => 4);
	$Exponent = isset($Units[$Unit]) ? $Units[$Unit] : 0;
	return ($Value * pow(1024, $Exponent));
}


/**
 * convert byte size to b kb mb gb
 * @param $bytes
 * @return string
 */
function formatSizeUnits($bytes)
{
	if ($bytes >= 1073741824) {
		$bytes = number_format($bytes / 1073741824, 0) . ' گیگابایت';
	} elseif ($bytes >= 1048576) {
		$bytes = number_format($bytes / 1048576, 0) . ' مگابایت';
	} elseif ($bytes >= 1024) {
		$bytes = number_format($bytes / 1024, 0) . ' کیلوبایت';
	} elseif ($bytes > 1) {
		$bytes = $bytes . ' بایت';
	} elseif ($bytes == 1) {
		$bytes = $bytes . ' بایت';
	} else {
		$bytes = '0 بایت';
	}
	
	return $bytes;
}



/**
 * convert timestamp to relative time
 * @param $ptime
 * @return string
 */
function TimeElapsed($ptime)
{
	$etime = time() - $ptime;
	
	if ($etime < 60) {
		return 'هم اکنون';
	}
	
	$a = array(
		12 * 30 * 24 * 60 * 60 => 'سال',
		30 * 24 * 60 * 60      => 'ماه',
		24 * 60 * 60           => 'روز',
		60 * 60                => 'ساعت',
		60                     => 'دقیقه',
		1                      => 'ثانیه'
	);
	
	foreach ($a as $secs => $str) {
		$d = $etime / $secs;
		if ($d >= 1) {
			$r = round($d);
			if ($d >= 59) {
				return 'هم اکنون';
			} else {
				return $r . ' ' . $str . ' پیش';
			}
			
		}
	}
}


/**
 * Get File Extension
 * @param $FileName
 * @param string $Separator
 * @return array
 */
function GetFileExtension($FileName, $Separator = '.')
{
	$n         = strrpos($FileName, $Separator);
	$Extension = ($n === FALSE) ? "" : substr($FileName, $n + 1);
	$Name      = substr($FileName, 0, $n);
	return [$Name, $Extension];
}


/**
 * convert normal string to seo friendly url
 * @param $str string
 * @param array $options
 * @return string
 */
function UrlSlug($str, $options = array())
{
	// Make sure string is in UTF-8 and strip invalid UTF-8 characters
	$str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());
	
	$defaults = array(
		'delimiter'     => '-',
		'limit'         => null,
		'lowercase'     => TRUE,
		'replacements'  => array(),
		'transliterate' => FALSE,
	);
	
	// Merge options
	$options = array_merge($defaults, $options);
	
	$char_map = array(
		// Latin
		'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
		'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
		'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O',
		'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH',
		'ß' => 'ss',
		'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
		'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
		'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o',
		'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th',
		'ÿ' => 'y',
		// Latin symbols
		'©' => '(c)',
		// Greek
		'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
		'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
		'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
		'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
		'Ϋ' => 'Y',
		'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
		'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
		'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
		'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
		'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',
		// Turkish
		'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
		'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',
		// Russian
		'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
		'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
		'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
		'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
		'Я' => 'Ya',
		'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
		'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
		'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
		'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
		'я' => 'ya',
		// Ukrainian
		'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
		'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',
		// Czech
		'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
		'Ž' => 'Z',
		'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
		'ž' => 'z',
		// Polish
		'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z',
		'Ż' => 'Z',
		'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
		'ż' => 'z',
		// Latvian
		'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N',
		'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
		'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
		'š' => 's', 'ū' => 'u', 'ž' => 'z'
	);
	
	// Make custom replacements
	$str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);
	
	// Transliterate characters to ASCII
	if ($options['transliterate']) {
		$str = str_replace(array_keys($char_map), $char_map, $str);
	}
	
	// Replace non-alphanumeric characters with our delimiter
	$str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);
	
	// Remove duplicate delimiters
	$str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);
	
	// Truncate slug to max. characters
	$str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');
	
	// Remove delimiter from ends
	$str = trim($str, $options['delimiter']);
	
	return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
}


/**
 * Create a random string
 * @param $length : the length of the string to create
 * @return $str the string
 */
function randomString($length = 6): string
{
	$str        = "";
	$characters = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9'));
	$max        = count($characters) - 1;
	for ($i = 0; $i < $length; $i++) {
		$rand = mt_rand(0, $max);
		$str  .= $characters[$rand];
	}
	return $str;
}

/**
 * Insert string at specified position
 * @param $str
 * @param $pos
 * @param $insertstr
 * @return string
 */
function stringInsert($str, $pos, $insertstr): string
{
	if (!is_array($pos)) {
		$pos = array($pos);
	} else {
		asort($pos);
	}
	$insertionLength = strlen($insertstr);
	$offset          = 0;
	foreach ($pos as $p) {
		$str    = substr($str, 0, $p + $offset) . $insertstr . substr($str, $p + $offset);
		$offset += $insertionLength;
	}
	return $str;
}


/**
 * check if string ends with given word or character
 * @param $haystack
 * @param $needle
 * @return bool
 */
function endsWith($haystack, $needle)
{
	$length = strlen($needle);
	if (!$length) {
		return TRUE;
	}
	return substr($haystack, -$length) === $needle;
}
