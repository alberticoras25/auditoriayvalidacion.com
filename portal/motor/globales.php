<?php
	date_default_timezone_set('America/Mazatlan');
	
	function obtenerMes($valor)
	{
		switch($valor){
			case "01": $mes = "Enero"; break;
			case "02": $mes = "Febrero"; break;
			case "03": $mes = "Marzo"; break;
			case "04": $mes = "Abril"; break;
			case "05": $mes = "Mayo"; break;
			case "06": $mes = "Junio"; break;
			case "07": $mes = "Julio"; break;
			case "08": $mes = "Agosto"; break;
			case "09": $mes = "Septiembre"; break;
			case "10": $mes = "Octubre"; break;
			case "11": $mes = "Noviembre"; break;
			case "12": $mes = "Diciembre"; break;
		}
		return($mes);
	}
	
	function normalize_date($dateNormalize)
	{ 
		$dateNormalize=date("d-m-Y",strtotime($dateNormalize));		   
		return $dateNormalize;		  
	}

	function normalize_date_text($dateNormalize)
	{
		$fecha = $dateNormalize;
		$numeroDia = date('d', strtotime($fecha));
		$dia = date('l', strtotime($fecha));
		$mes = date('F', strtotime($fecha));
		$anio = date('Y', strtotime($fecha));
		$dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
		$dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
		$nombredia = str_replace($dias_EN, $dias_ES, $dia);
		$meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
		$meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
		$nombreMes = str_replace($meses_EN, $meses_ES, $mes);
		return $nombredia." ".$numeroDia." de ".$nombreMes." del ".$anio;
	}

	function normalize_date_filtro($dateNormalize)
	{
		$dateNormalize = date("d/m/Y", strtotime($dateNormalize));
		return $dateNormalize;
	}

	function normalize_date2($dateNormalize2)
	{
		$dateNormalize2 = str_replace('/', '-', $dateNormalize2);
		$dateNormalize2 = implode("-", array_reverse(explode("-", $dateNormalize2)));
		//$dateNormalize2 = date("Y-m-d", strtotime($dateNormalize2));
		return $dateNormalize2;
	}
	
	function normalize_date_complete($dateNormalize)
	{ 
		$dateNormalize=date("d-m-Y H:i:s",strtotime($dateNormalize));
		return $dateNormalize;		  
	}
	
	function normalize_date_complete2($dateNormalize)
	{ 
		$dateNormalize=date("Y-m-d H:i:s",strtotime($dateNormalize));
		return $dateNormalize;		  
	}
	
	function normalize_time($timeNormalize)
	{ 
		$timeNormalize=date("H:i",strtotime($timeNormalize));
		return $timeNormalize;		  
	}

	function normalize_time_fil($timeNormalize)
	{
		$timeNormalize=date("H:i:s", strtotime($timeNormalize));
		return $timeNormalize;
	}

	function normalize_time_ampm($timeNormalize)
	{
		$timeNormalize = date("H:i A", strtotime($timeNormalize));
		return $timeNormalize;
	}

	function normalize_time_cap($timeNormalize)
	{
		$timeNormalize=date("H:i",strtotime($timeNormalize));
		return $timeNormalize;
	}

	function diffDays_rageDate($date1, $date2)
	{
		$date1 = new DateTime($date1);
		$date2 = new DateTime($date2);

		return $diff = $date2->diff($date1)->format("%a");
	}

	function diffWeeks_rageDate($date1, $date2)
	{
		$datefrom = new DateTime($date1);
		$dateto = new DateTime($date2);
		$interval = $datefrom->diff($dateto);
		$week_total = $interval->format('%a')/7;
		return $diff = floor($week_total);
	}

	function addRangeDate($date, $sign, $number, $tipo)
	{
		$nextDate = strtotime(date("Y-m-d", strtotime($date)) . $sign.$number." ".$tipo);
		$nextDate = date("Y-m-d",$nextDate);
		return $nextDate;
	}

	function firstDayOf($period, DateTime $date = null)
	{
		$period = strtolower($period);
		$validPeriods = array('year', 'quarter', 'month', 'week');

		if ( ! in_array($period, $validPeriods))
			throw new InvalidArgumentException('Period must be one of: ' . implode(', ', $validPeriods));

		$newDate = ($date === null) ? new DateTime() : clone $date;

		switch ($period) {
			case 'year':
				$newDate->modify('first day of january ' . $newDate->format('Y'));
				break;
			case 'quarter':
				$month = $newDate->format('n') ;
				switch($month)
				{
					case 1:$nameMonth = "january";break;
					case 2:$nameMonth = "february";break;
					case 3:$nameMonth = "march";break;
					case 4:$nameMonth = "april";break;
					case 5:$nameMonth = "may";break;
					case 6:$nameMonth = "june";break;
					case 7:$nameMonth = "july";break;
					case 8:$nameMonth = "august";break;
					case 9:$nameMonth = "september";break;
					case 10:$nameMonth = "october";break;
					case 11:$nameMonth = "november";break;
					case 12:$nameMonth = "december";break;
				}

				$newDate->modify('first day of '.$nameMonth . $newDate->format('Y'));
				break;
			case 'month':
				$newDate->modify('first day of this month');
				break;
			case 'week':
				$newDate->modify(($newDate->format('w') === '0') ? 'monday last week' : 'monday this week');
				break;
		}

		return $newDate;
	}

	function lastDayOf($period, DateTime $date = null)
	{
		$period = strtolower($period);
		$validPeriods = array('year', 'quarter', 'month', 'week');

		if ( ! in_array($period, $validPeriods))
			throw new InvalidArgumentException('Period must be one of: ' . implode(', ', $validPeriods));

		$newDate = ($date === null) ? new DateTime() : clone $date;

		switch ($period)
		{
			case 'year':
				$newDate->modify('last day of december ' . $newDate->format('Y'));
				break;
			case 'quarter':
				$month = $newDate->format('n') ;
				switch($month)
				{
					case 1:$nameMonth = "january";break;
					case 2:$nameMonth = "february";break;
					case 3:$nameMonth = "march";break;
					case 4:$nameMonth = "april";break;
					case 5:$nameMonth = "may";break;
					case 6:$nameMonth = "june";break;
					case 7:$nameMonth = "july";break;
					case 8:$nameMonth = "august";break;
					case 9:$nameMonth = "september";break;
					case 10:$nameMonth = "october";break;
					case 11:$nameMonth = "november";break;
					case 12:$nameMonth = "december";break;
				}

				$newDate->modify('last day of '.$nameMonth . $newDate->format('Y'));
				break;
			case 'month':
				$newDate->modify('last day of this month');
				break;
			case 'week':
				$newDate->modify(($newDate->format('w') === '0') ? 'now' : 'sunday this week');
				break;
		}

		return $newDate;
	}

	function todayComplete()
	{
		return date("Y-m-d H:i:s");
	}
	
	//GEOLOCALIZADOR
	function mqw_iplocation_func($ip) 
	{
 		$default = 'L&eacute;on';
		 
        if (!is_string($ip) || strlen($ip) < 1 || $ip == '127.0.0.1' || $ip == 'localhost')
            $ip = '8.8.8.8';
 
        $curlopt_useragent = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6 (.NET CLR 3.5.30729)';
 
        $url = 'http://ipinfodb.com/ip_locator.php?ip=' . urlencode($ip);
        $ch = curl_init();
 
        $curl_opt = array(
            CURLOPT_FOLLOWLOCATION  => 1,
            CURLOPT_HEADER      => 0,
            CURLOPT_RETURNTRANSFER  => 1,
            CURLOPT_USERAGENT   => $curlopt_useragent,
            CURLOPT_URL       => $url,
            CURLOPT_TIMEOUT         => 1,
            CURLOPT_REFERER         => 'http://' . $_SERVER['HTTP_HOST'],
        );
 
        curl_setopt_array($ch, $curl_opt);
 
        $content = curl_exec($ch);
 
        if (!is_null($curl_info)) {
            $curl_info = curl_getinfo($ch);
        }
 
        curl_close($ch);
 
        if ( preg_match('{<li>City : ([^<]*)</li>}i', $content, $regs) )  
		{
            $city = $regs[1];
        }
		if ( preg_match('{<li>Latitude : ([^<]*)</li>}i', $content, $regs) )  
		{
            $latitud = $regs[1];
        }
		if ( preg_match('{<li>Longitude : ([^<]*)</li>}i', $content, $regs) )  
		{
            $longitud = $regs[1];
        }
        /*if ( preg_match('{<li>State/Province : ([^<]*)</li>}i', $content, $regs) )  
		{
            $state = $regs[1];
        }
        if ( preg_match('{<li>Country : ([^<]*)</li>}i', $content, $regs) )  
		{
            $country = $regs[1];
        }*/
 
        if( $city!='')
		{
          $location = $city.','.$latitud.','.$longitud;
          return $location;
        }
		else
		{
          return $default; 
        }
	}
	
	//RECORTADOR DE PALABRAS
	function recortar_texto($texto, $limite=100)
   	{  
	  	$texto = trim($texto);
	  	$texto = strip_tags($texto);
	  	$tamano = strlen($texto);
	  	$resultado = '';
	  	if($tamano <= $limite)
		{
		  	return $texto;
	  	}
		else
		{
		  	$texto = substr($texto, 0, $limite);
		  	$palabras = explode(' ', $texto);
		  	$resultado = implode(' ', $palabras);
		  	$resultado .= '...';
	  	}  
	  	return $resultado;
	 }
	 
	 //DAR FORMATO DE MONEDA
	 function format_moneda($simbolo, $cantidad)
	 {
		 $formatMoneda = $simbolo.number_format($cantidad,2); 
		 return $formatMoneda;		 
	 }	
	 
	 //Simple mail function with HTML header
	function sendmail($from, $subject, $message, $to) 
	{
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
		$headers .= 'From: ' . $from . "\r\n";		
		$result = mail($to,$subject,$message,$headers);		
		if ($result) return 1;
		else return 0;
	}
	
	//Mail whith adjuntos
	function mail_attachment($filename, $path, $mailto, $from_mail, $from_name, $replyto, $subject, $message, $consulta)
	{
		$true = true;
		$false = false;
		$file = $path.$filename;
		$file_size = filesize($file);
		$handle = fopen($file, "r");
		$content = fread($handle, $file_size);
		fclose($handle);
		$content = chunk_split(base64_encode($content));
		$uid = md5(uniqid(time()));
		$name = basename($file);
		$header = "From: ".$from_name." <".$from_mail.">\r\n";
		$header .= "Reply-To: ".$replyto."\r\n";
		$header .= "MIME-Version: 1.0\r\n";
		$header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
		$header .= "This is a multi-part message in MIME format.\r\n";
		$header .= "--".$uid."\r\n";
		$header .= "Content-type:text/plain; charset=iso-8859-1\r\n";
		$header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
		$header .= $message."\r\n\r\n";
		$header .= "--".$uid."\r\n";
		$header .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n"; // use different content types here
		$header .= "Content-Transfer-Encoding: base64\r\n";
		$header .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
		$header .= $content."\r\n\r\n";
		$header .= "--".$uid."--";
		if (mail($mailto, $subject, "", $header)) 
		{
			return $true;
		} 
		else 
		{
			return $false;
		}
	}
	
	function convertMayus($variable) 
	{
		$variable = strtr(strtoupper($variable),"àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");
		return $variable;
	}
	
	function multiplo3($num)
	{
        if(($num % 3) == 0)
            $retorno = 1;
        else
            $retorno = 0;
    }
	
	function insertSlashes($cadena)
	{
		$cadena = utf8_decode(addslashes($cadena));
		return $cadena;
	}
	
	function selectSlashes($cadena)
	{
		$cadena = utf8_encode(stripslashes($cadena));
		return $cadena;
	}
	
	function getUltimoDiaMes($elAnio,$elMes) 
	{
  		return date("d",(mktime(0,0,0,$elMes+1,1,$elAnio)-1));
	}

	function utf8_desconvert($string)
	{
		if (mb_detect_encoding($string, 'utf-8', true)) {
			$string = utf8_decode($string);
		}

		return $string;
	}

	function utf8_convert($string)
	{
		if (!mb_detect_encoding($string, 'utf-8', true)) {
			$string = utf8_encode($string);
		}

		return $string;
	}

	function firstDay()
	{
		// First day of the month.
		return date('Y-m-01');
	}

	function lastDay()
	{
		// Last day of the month.
		return date('Y-m-t');
	}

	function array_sort($array, $on, $order=SORT_ASC)
	{
		$new_array = array();
		$sortable_array = array();

		if (count($array) > 0) {
			foreach ($array as $k => $v) {
				if (is_array($v)) {
					foreach ($v as $k2 => $v2) {
						if ($k2 == $on) {
							$sortable_array[$k] = $v2;
						}
					}
				} else {
					$sortable_array[$k] = $v;
				}
			}

			switch ($order) {
				case SORT_ASC:
					asort($sortable_array);
					break;
				case SORT_DESC:
					arsort($sortable_array);
					break;
			}

			foreach ($sortable_array as $k => $v) {
				$new_array[$k] = $array[$k];
			}
		}

		return $new_array;
	}

	function formatNumberZero($value, $numZeros)
	{
		return str_pad($value, $numZeros, '0', STR_PAD_LEFT);
	}

	function diff($start,$end = false)
	{
		/*
		* For this function, i have used the native functions of PHP. It calculates the difference between two timestamp.
		*
		* Author: Toine
		*
		* I provide more details and more function on my website
		*/

		// Checks $start and $end format (timestamp only for more simplicity and portability)
		if(!$end) { $end = time(); }
		if(!is_numeric($start) || !is_numeric($end)) { return false; }
		// Convert $start and $end into EN format (ISO 8601)
		$start  = date('Y-m-d H:i:s',$start);
		$end    = date('Y-m-d H:i:s',$end);
		$d_start    = new DateTime($start);
		$d_end      = new DateTime($end);
		$diff = $d_start->diff($d_end);
		// return all data
		$this->year    = $diff->format('%y');
		$this->month    = $diff->format('%m');
		$this->day      = $diff->format('%d');
		$this->hour     = $diff->format('%h');
		$this->min      = $diff->format('%i');
		$this->sec      = $diff->format('%s');
		return true;
	}

	function getMmPx($value)
	{
		return ($value * 3.78);
	}

	function sign($number)
	{
		return ( $number > 0 ) ? 1 : ( ( $number < 0 ) ? -1 : 0 );
	}

	function compareTime($time1, $time2)
	{
		$time1 = new DateTime($time1);
		$time2 = new DateTime($time2);
		$time1->format("%H:%I:%S");
		$time2->format("%H:%I:%S");

		if($time1 == $time2)
		{
			return 0;
			exit;
		}

		if($time1 < $time2)
		{
			return 1;
			exit;
		}

		if($time1 > $time2)
		{
			return 2;
			exit;
		}
	}

	function compareDate($date1, $date2)
	{
		$date1 = new DateTime($date1);
		$date2 = new DateTime($date2);

		if($date1 == $date2)
		{
			return 0;
			exit;
		}

		if($date1 < $date2)
		{
			return 1;
			exit;
		}

		if($date1 > $date2)
		{
			return 2;
			exit;
		}
	}

	/*function intcmp($a,$b)
	{
		return (int) $a > (int) $b ? 1 : (int) $a == (int) $b ? 0 : -1;
	}*/

	function in_multiarray($elem, $array,$field)
	{
		$top = sizeof($array) - 1;
		$bottom = 0;
		while($bottom <= $top)
		{
			if($array[$bottom][$field] == $elem)
				return true;
			else
				if(is_array($array[$bottom][$field]))
					if(in_multiarray($elem, ($array[$bottom][$field])))
						return true;

			$bottom++;
		}
		return false;
	}

	function multiSearch(array $array, array $pairs)
	{
		$found = array();
		foreach ($array as $aKey => $aVal)
		{
			$coincidences = 0;
			foreach ($pairs as $pKey => $pVal)
			{
				if (array_key_exists($pKey, $aVal) && $aVal[$pKey] == $pVal)
				{
					$coincidences++;
				}
			}
			if ($coincidences == count($pairs))
			{
				$found[$aKey] = $aVal;
			}
		}

		return $found;
	}

	function lineBreak($text, $charNum)
	{
		return wordwrap($text, $charNum, "<br />", true);
	}

	function scripttag($address)
	{
		$scriptReturn = '<script type="text/javascript" src="'.$address.'?v='.uniqid().'"></script>';
		return $scriptReturn;
	}

	function linktag($address)
	{
		$cssReturn = '<link rel="stylesheet" type="text/css" href="'.$address.'?v='.uniqid().'"/>';
		return $cssReturn;
	}

	function currentDate()
	{
		return date("Y-m-d");
	}

	function currentDateComplate()
	{
		return date("Y-m-d H:i:s");
	}

	function currentDateComplateNS()
	{
		return date("Y-m-d H:i");
	}

	function currentTime()
	{
		return date("H:i:s");
	}

	function currentTimeNS()
	{
		return date("H:i");
	}

	function timezoneList()
	{
		$timezoneIdentifiers = DateTimeZone::listIdentifiers();
		$utcTime = new DateTime('now', new DateTimeZone('UTC'));

		$tempTimezones = array();
		foreach ($timezoneIdentifiers as $timezoneIdentifier)
		{
			$currentTimezone = new DateTimeZone($timezoneIdentifier);

			$tempTimezones[] = array('offset' => (int)$currentTimezone->getOffset($utcTime), 'identifier' => $timezoneIdentifier);
		}

		// Sort the array by offset,identifier ascending
		usort($tempTimezones, function($a, $b)
		{
			return ($a['offset'] == $b['offset']) ? strcmp($a['identifier'], $b['identifier']) : $a['offset'] - $b['offset'];
		});

		$timezoneList = array();
		foreach ($tempTimezones as $tz)
		{
			$sign = ($tz['offset'] > 0) ? '+' : '-';
			$offset = gmdate('H:i', abs($tz['offset']));
			$timezoneList[] = array('valUTC' => $sign.$offset, 'identifier' => '(UTC '.$sign.$offset.') '.$tz['identifier']);
		}

		return $timezoneList;
	}

	function slugify($text)
	{
		// replace non letter or digits by -
		$text = preg_replace('~[^\pL\d]+~u', '-', $text);

		// transliterate
		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

		// remove unwanted characters
		$text = preg_replace('~[^-\w]+~', '', $text);

		// trim
		$text = trim($text, '-');

		// remove duplicate -
		$text = preg_replace('~-+~', '-', $text);

		// lowercase
		$text = strtolower($text);

		if (empty($text))
		{
			return 'n-a';
		}

		return $text;
	}

	function genCode($length)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++)
			$randomString .= $characters[rand(0, $charactersLength - 1)];

		return $randomString;
	}

	function searchArrayKeyVal($sKey, $id, $array)
	{
		foreach ($array as $key => $val)
		{
			if ($val[$sKey] == $id)
			{
				return $key;
			}
		}
		return false;
	}

	function getVarUrl($var)
	{
		$matchVar = ( isset($var) && trim($var) != '');
		$matchVar = $matchVar ? trim ($var) : '';
		return $matchVar;
	}

	function url_encode($string)
	{
		return urlencode(utf8_encode($string));
	}

	function url_decode($string)
	{
		return utf8_decode(urldecode($string));
	}

	function eliminar_tildes($cadena)
	{
		//$cadena = preg_replace("/[^a-zA-Z0-9\_\-]+/", "", $cadena);
		//Codificamos la cadena en formato utf8 en caso de que nos de errores
		//$cadena = utf8_encode($cadena);

		//Ahora reemplazamos las letras
		$cadena = str_replace(
			array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
			array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
			$cadena
		);

		$cadena = str_replace(
			array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
			array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
			$cadena );

		$cadena = str_replace(
			array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
			array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
			$cadena );

		$cadena = str_replace(
			array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
			array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
			$cadena );

		$cadena = str_replace(
			array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
			array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
			$cadena );

		$cadena = str_replace(
			array('ñ', 'Ñ', 'ç', 'Ç'),
			array('n', 'N', 'c', 'C'),
			$cadena
		);

		return $cadena;
	}

	function createCookie($name, $value='', $maxage=0, $path='', $domain='', $secure=false, $HTTPOnly=false)
	{
		$ob = ini_get('output_buffering');

		// Abort the method if headers have already been sent, except when output buffering has been enabled
		if ( headers_sent() && (bool) $ob === false || strtolower($ob) == 'off' )
			return false;

		if ( !empty($domain) )
		{
			// Fix the domain to accept domains with and without 'www.'.
			if ( strtolower( substr($domain, 0, 4) ) == 'www.' ) $domain = substr($domain, 4);
			// Add the dot prefix to ensure compatibility with subdomains
			if ( substr($domain, 0, 1) != '.' ) $domain = '.'.$domain;

			// Remove port information.
			$port = strpos($domain, ':');

			if ( $port !== false ) $domain = substr($domain, 0, $port);
		}

		// Prevent "headers already sent" error with utf8 support (BOM)
		//if ( utf8_support ) header('Content-Type: text/html; charset=utf-8');

		header('Set-Cookie: '.rawurlencode($name).'='.rawurlencode($value)
			.(empty($domain) ? '' : '; Domain='.$domain)
			.(empty($maxage) ? '' : '; Max-Age='.$maxage)
			.(empty($path) ? '' : '; Path='.$path)
			.(!$secure ? '' : '; Secure')
			.(!$HTTPOnly ? '' : '; HttpOnly'), false);

		return true;
	}

	function thousandsCurrencyFormat($num)
	{
		$x = round($num);
		$x_number_format = number_format($x);
		$x_array = explode(',', $x_number_format);
		$x_parts = array('k', 'm', 'b', 't');
		$x_count_parts = count($x_array) - 1;
		$x_display = $x;
		$x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
		$x_display .= $x_parts[$x_count_parts - 1];

		return $x_display;
	}

	function SignData($text, $privateKeyFile)
	{

		$private_cert = $privateKeyFile;

		$f = fopen($private_cert,"r+");

		if($f)
			$private_key = fread( $f, filesize($private_cert) );
		else
			return "";

		fclose($f);

		$private_key = openssl_get_privatekey($private_key);

		if(openssl_private_encrypt(md5($text), $crypt_text, $private_key))
		{
			return base64_url_encode($crypt_text) . "\n";
		}

		return "";
	}

	function VerifyData($crypt_text, $plaintext, $publicKeyFile)
	{
		$public_cert = $publicKeyFile;

		$s = fopen($public_cert,"r+");

		if($s)
			$public_key = fread( $s, filesize($publicKeyFile));
		else
			return false;

		fclose($s);

		$res = openssl_get_publickey($public_key);

		if(openssl_public_decrypt(base64_url_decode($crypt_text), $decrypt, $res))
		{
			if($decrypt == md5($plaintext))
				return true;
			else
				return false;
		}

		return false;
	}

	function base64_url_encode($input) {
		return strtr(base64_encode($input), '+/=', '-_,');
	}

	function base64_url_decode($input) {
		return base64_decode(strtr($input, '-_,', '+/='));
	}

	function sanear_string($string)
	{
		$string = trim($string);

		$string = str_replace(
			array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
			array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
			$string
		);

		$string = str_replace(
			array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
			array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
			$string
		);

		$string = str_replace(
			array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
			array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
			$string
		);

		$string = str_replace(
			array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
			array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
			$string
		);

		$string = str_replace(
			array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
			array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
			$string
		);

		$string = str_replace(
			array('ñ', 'Ñ', 'ç', 'Ç'),
			array('n', 'N', 'c', 'C',),
			$string
		);

		//Esta parte se encarga de eliminar cualquier caracter extraño
		/*$string = str_replace(
			array("\", "¨", "º", "-", "~",
				 "#", "@", "|", "!", """,
				 "·", "$", "%", "&", "/",
				 "(", ")", "?", "'", "¡",
				 "¿", "[", "^", "<code>", "]",
				 "+", "}", "{", "¨", "´",
				 ">", "< ", ";", ",", ":",
				 ".", " "),
			'',
			$string
		);*/


		return $string;
	}

	function getIsoWeeksInYear($year)
	{
		$date = new DateTime;
		$date->setISODate($year, 53);
		return ($date->format("W") === "53" ? 53 : 52);
	}

	function getStartAndEndDate($week, $year, $dayNum)
	{
		$dto = new DateTime();
		$ret['week_start'] = $dto->setISODate($year, $week, $dayNum)->format('Y-m-d');
		$ret['week_end'] = $dto->modify('+6 days')->format('Y-m-d');
		return $ret;
	}

	function weekOfMonth($date)
	{
		//Get the first day of the month.
		$firstOfMonth = strtotime(date("Y-m-01", $date));
		//Apply above formula.
		return intval(date("W", $date)) - intval(date("W", $firstOfMonth)) + 1;
	}