<?php
/**
 * Good formated text and links
 * @author Krzysztof Wilczek
 */
class GoodText {

	/**
	 * Dispaly good formated text
	 * @param String $text
	 * @param Integer $max_length
	 * @return String
	 */
	public static function formated($text, $max_length = null)
    {
    	if (!$text)
		{
			return null;
		}
    	
		// Add additional dots
    	if ($max_length)
    	{
    		if ($max_length < strlen($text))
			{
				$text = substr($text, 0, $max_length) . '...';
    		}
    	}
    	
		$text = stripslashes($text);

		// Process TextTile parser
		$textile = new Textile();
		$text = $textile->TextileThis($text);
		
		// Add non-breaking spaces
		$text = str_replace(
			array(' w ', ' z ', ' o ', ' i ', ' a ', ' u ', ' I ', ' W ', ' Z ', ' O '), 
			array('  w&nbsp;', ' z&nbsp;', ' o&nbsp;', ' i&nbsp;', ' a&nbsp;', ' u&nbsp;', ' I&nbsp;', ' W&nbsp;', ' Z&nbsp;'. ' O&nbsp;'), 
		$text);

		return $text;
    }
	
    /**
     * 
     * Prepare good (SEO) links
     * @param String $link
     * @return String
     */
	public static function seolink($link)
	{
    	$bad = array(' ','#','@','$','%','^','&','*','(',')','ą','ć','ę','ł','ń','ó','ś','ź','ż','Ą','Ć','Ę','Ł','Ń','Ó','Ś','Ź','Ż','/','.');
    	$good = array('_','','','','','','','','','','a','c','e','l','n','o','s','z','z','A','C','E','L','N','O','S','Z','Z','_','_');
    	return str_replace($bad,$good,mb_strtolower($link));	
	}
	
	public static function displayErrors($field, $errors)
	{
		if (!is_array($errors)|| empty($field))
		{
			return;
		}
		if (array_key_exists($field, $errors))
		{
			switch ($field)
			{
				case 'title':
					$name = 'Tytuł';
				break;
				default:
					$name = 'Rekord';
				break;
			}
			$error_log = '<div class="text-error">';
			foreach ($errors[$field] as $error)
			{
				switch ($error)
				{
					case 'not_empty':
						$error_log .= $name.' nie może być pusty';
					break;
					case 'min_length':
						$error_log .= $name.' jest za krótkie';
					break;
					case 'matches':
						$error_log .= $name.' nie pasuje do orygniału';
					break;
					case 'email':
						$error_log .= $name.' musi być adresem e-mail';
					break;
				}
			}
			return $error_log.'</div>';
		}
	
	}
}