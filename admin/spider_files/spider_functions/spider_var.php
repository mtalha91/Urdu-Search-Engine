<?php


	$page_value="";
	$data="";
	
	$entities = array
		(
		"&amp" => "&",
		"&apos" => "'",
		"&THORN;"  => "Þ",
		"&szlig;"  => "ß",
		"&agrave;" => "à",
		"&aacute;" => "á",
		"&acirc;"  => "â",
		"&atilde;" => "ã",
		"&auml;"   => "ä",
		"&aring;"  => "å",
		"&aelig;"  => "æ",
		"&ccedil;" => "ç",
		"&egrave;" => "è",
		"&eacute;" => "é",
		"&ecirc;"  => "ê",
		"&euml;"   => "ë",
		"&igrave;" => "ì",
		"&iacute;" => "í",
		"&icirc;"  => "î",
		"&iuml;"   => "ï",
		"&eth;"    => "ð",
		"&ntilde;" => "ñ",
		"&ograve;" => "ò",
		"&oacute;" => "ó",
		"&ocirc;"  => "ô",
		"&otilde;" => "õ",
		"&ouml;"   => "ö",
		"&oslash;" => "ø",
		"&ugrave;" => "ù",
		"&uacute;" => "ú",
		"&ucirc;"  => "û",
		"&uuml;"   => "ü",
		"&yacute;" => "ý",
		"&thorn;"  => "þ",
		"&yuml;"   => "ÿ",
		"&THORN;"  => "Þ",
		"&szlig;"  => "ß",
		"&Agrave;" => "à",
		"&Aacute;" => "á",
		"&Acirc;"  => "â",
		"&Atilde;" => "ã",
		"&Auml;"   => "ä",
		"&Aring;"  => "å",
		"&Aelig;"  => "æ",
		"&Ccedil;" => "ç",
		"&Egrave;" => "è",
		"&Eacute;" => "é",
		"&Ecirc;"  => "ê",
		"&Euml;"   => "ë",
		"&Igrave;" => "ì",
		"&Iacute;" => "í",
		"&Icirc;"  => "î",
		"&Iuml;"   => "ï",
		"&ETH;"    => "ð",
		"&Ntilde;" => "ñ",
		"&Ograve;" => "ò",
		"&Oacute;" => "ó",
		"&Ocirc;"  => "ô",
		"&Otilde;" => "õ",
		"&Ouml;"   => "ö",
		"&Oslash;" => "ø",
		"&Ugrave;" => "ù",
		"&Uacute;" => "ú",
		"&Ucirc;"  => "û",
		"&Uuml;"   => "ü",
		"&Yacute;" => "ý",
		"&Yhorn;"  => "þ",
		"&Yuml;"   => "ÿ"
		);
		
		
	//Apache multi indexes parameters
	$apache_indexes = array (  
		"N=A" => 1,
		"N=D" => 1,
		"M=A" => 1,
		"M=D" => 1,
		"S=A" => 1,
		"S=D" => 1,
		"D=A" => 1,
		"D=D" => 1,
		"C=N;O=A" => 1,
		"C=M;O=A" => 1,
		"C=S;O=A" => 1,
		"C=D;O=A" => 1,
		"C=N;O=D" => 1,
		"C=M;O=D" => 1,
		"C=S;O=D" => 1,
		"C=D;O=D" => 1);

	/////file extentions
	$ext = array
		(
		);

	$lines = @file('ext.txt');

	if (is_array($lines))
	{
		while (list($id, $word) = each($lines))
			$ext[] = trim($word);
	}
	
?>