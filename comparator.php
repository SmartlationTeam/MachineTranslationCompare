<?php

function clean_text($text)
  {
      $new_text = trim($text);
      $new_text = mb_strtolower($new_text);
      $new_text = preg_replace("[\，|\,|\.|\'|\"|\\|\/]"," ",$text);
      $new_text = preg_replace("[\n|\t]"," ",trim($new_text));
      $new_text = preg_replace('/(\s\s+)/', ' ', trim($new_text));
      //$new_text = preg_replace(',', ' ', trim($new_text));
      return $new_text;
  }
  
function get_shingle($text, $n=4)
  {
    $shingles = array();
    $text = clean_text($text);
    $elements = explode(' ',$text);
    
    for ($i=0;$i<(count($elements)-$n+1);$i++) 
    {
        $shingle = '';
        for ($j=0;$j<$n;$j++)
        {
            $shingle .= mb_strtolower(trim($elements[$i+$j]), 'UTF-8')." ";
        }
        
        if(strlen(trim($shingle)))
        {
          $shingles[$i] = trim($shingle, ' -');
        }
    }
    
    return $shingles;
  }
  
function check_it($first, $second)
  {
    if (!$first || !$second) {
        return 0;
    }

    if (strlen($first)>200000 || strlen($second)>200000) {
        return 0;
    }


          //for ($i=1;$i<5;$i++) {
      $first_shingles = array_unique(get_shingle($first));
      $second_shingles = array_unique(get_shingle($second));
      
      /*echo '<pre>';
      
      print_r($first_shingles);
      print_r($second_shingles);
      
      exit;*/
      

      $intersect = array_intersect($first_shingles,$second_shingles);

      $merge = array_unique(array_merge($first_shingles,$second_shingles));
      $count_merge = (count($merge) > 0) ? count($merge) : 1;

      $diff = (count($intersect)/$count_merge)/0.01;

      return round($diff, 2);
          //}*/
  }
  
function googletranslate($str, $lang_from, $lang_to)
  {
    $query_data = array(
      'client' => 'x',
      'q' => $str,
      'sl' => $lang_from,
      'tl' => $lang_to
    );
    $filename = 'http://translate.google.ru/translate_a/t';
    $options = array(
      'http' => array(
        'user_agent' => 'Mozilla/5.0 (Windows NT 6.0; rv:26.0) Gecko/20100101 Firefox/26.0',
        'method' => 'POST',
        'header' => 'Content-type: application/x-www-form-urlencoded',
        'content' => http_build_query($query_data)
      )
    );
    $context = stream_context_create($options);
    $response = file_get_contents($filename, false, $context);
    //print_r($response);exit;
    return json_decode($response);
  }

function textTransPercent($text_to_translate, $lang_from, $lang_to, $text, $retur_percent = true)
  {
    $trans = array('google');

    $percent = 0;

    $translate = '';
    
    $data = array();
    
    $lang_from_arr = explode('-',$lang_from);
    $lang_to_arr = explode('-',$lang_to);
    
    $lang_f = $lang_from_arr[0];
    $lang_t = $lang_to_arr[0];

    foreach($trans as $key=>$val)
    {
      $method = $val.'translate';
      
      if($val == 'yandex')
      {
        $lang_from = $lang_f;
        $lang_to = $lang_t;
      }

      $translate = $method($text_to_translate, $lang_from, $lang_to);
      
      //echo $text.'-'.$translate.' ('.$method.')<br>';exit;
      
      $_temp = $data[$val] = check_it($text, $translate);

      $percent = ($_temp > $percent) ? $_temp : $percent;
    }
    
    //print_r($data);exit;
 
    return (!$retur_percent) ? $data : $percent;
  }


$tkn=$_REQUEST['token']; 
if($tkn != "p+C}jK2ov]7kiuO#e&b3*q=i[z-E'd") {echo "wrong token"; exit();}
$src_txt=$_REQUEST['src_txt'];
$lang_from=$_REQUEST['lang_from'];
$lang_to=$_REQUEST['lang_to'];
$dst_txt=$_REQUEST['dst_txt'];
$out = textTransPercent($src_txt, $lang_from, $lang_to, $dst_txt, false);
echo $out['google'];


?>
