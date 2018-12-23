<?php
/*
Compare a translation you have with a machine translation. By https://smartlation.com


By https://smartlation.com
The following parameters should be sent to the script (as POST or GET) :

"src_txt" - Source text to be compared to a machine translation
"lang_from" - Source language code
"lang_to" - Destination language code
"dst_txt" - Translated  text to be compared to a machine translation
"token" - Token

Example:
  		"src_txt"	=>	"Today is a beautiful day. Let's go party!",
  		"lang_from"	=>  "en-us",
		"lang_to"	=>  "pt-br",
		"dst_txt"	=>  "Hoje está um lindo dia. Vamos comemorar!",
		"token"	=>  "p+C}jK2ov]7kiuO#e&b3*q=i[z-E'd"
*/

      $parameters= array
      (
        "src_txt"	=>	"Today is a beautiful day. Let's go party!",
        "lang_from"	=>  "en-us",
		"lang_to"	=>  "pt-br",
		"dst_txt"	=>  "Hoje está um lindo dia. Vamos comemorar!",
		"token"	=>  "p+C}jK2ov]7kiuO#e&b3*q=i[z-E'd"
      );

	  //echo http_build_query($parameters);
	  $url="INSER HERE URL OF COMPARATOR";
	  $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
      curl_setopt($ch, CURLOPT_HEADER, FALSE);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      $result=curl_exec($ch);
      curl_close($ch);
	  echo $result
	  //var_dump($result);
?>
