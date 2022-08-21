<?php
  $q=$_GET["q"];
  libxml_use_internal_errors(true);
  switch ($q) {
    case 'Clarin':
      read_entry("https://www.theverge.com/rss/frontpage");
      break;
    case 'LaNacion':
      read_channel_item("http://contenidos.lanacion.com.ar/herramientas/rss-origen=2");
      break;
    case 'Iprofesional':
      read_channel_item('https://www.iprofesional.com/rss/home');
      break;
    case 'Infobae':
      read_channel_item('http://www.infobae.com/argentina-rss.xml');
      break;
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    case 'LaVoz':
      read_channel_item('http://archivo.lavoz.com.ar/Rss/Rss.asp?origen=2');
      break;
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    case 'BBC':
      read_channel_item("http://feeds.bbci.co.uk/mundo/rss.xml");
      break;
    case 'CNN':
      read_channel_item('http://cnnespanol.cnn.com/author/cnn-espanol/feed/');
      break;
    case 'MuyInt':
      read_channel_item('http://feeds2.feedburner.com/Muyinteresantees');
      break;
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    case 'ClarinTecno':
      read_curl_info("https://www.clarin.com/rss/tecnologia/");
      break;
    case 'LaVozTecno':
      read_channel_item('http://srvc.lavoz.com.ar/taxonomy/term/23342/1/feed');
      break;
    case 'MuyComputer':
      read_channel_item('http://www.muycomputer.com/feed/');
      break;
    case 'TechCrunch':
      read_channel_item('https://techcrunch.com/feed/');
      break;
	  case 'FayerWayer':
      read_channel_item('http://feeds2.feedburner.com/fayerwayer');
      break;
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    case 'ClimaCba':
      read_channel_item_weather('http://xml.tutiempo.net/rss/42926.xml');
      break;
    case 'ClimaR4':
      read_channel_item_weather('http://xml.tutiempo.net/rss/31019.xml');
    break;
    case 'ClimaVT':
      read_channel_item_weather('http://xml.tutiempo.net/rss/43412.xml');
      break;
    case 'ClimaJN':
      read_channel_item_weather('http://xml.tutiempo.net/rss/43074.xml');
      break;
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    case 'ClarinFut':
      read_channel_item("http://www.clarin.com/rss/deportes/futbol/");
      break;
    case 'OLE':
      read_channel_item('http://www.ole.com.ar/rss/ultimas-noticias/');
      break;
  }


  function read_curl_info($url){
    $curl = curl_init();
 
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36');
    
    $html = curl_exec($curl);
    curl_close($curl);

    print_r($html);      
  }

  function read_channel_item($url){
    try {
      $xml = simplexml_load_file($url);
      $xml = new SimpleXMLElement($url, LIBXML_NOCDATA, true);
      foreach($xml->channel->item as $item) {
        echo $item;
        print_news($item->link, $item->title, $item->description);
      }
    } catch (Exception $e) {
      echo 'No se descargó XML de ' . $url;
    }
  }

  
  function read_entry($url){
    try {
      $xml = simplexml_load_file($url);
      $xml = new SimpleXMLElement($url, LIBXML_NOCDATA, true);
      echo $xml;
      #foreach($xml->channel->item as $item) {
      #  echo $item;
      #  print_news($item->link, $item->title, $item->description);
      #}
    } catch (Exception $e) {
      echo 'No se descargó XML de ' . $url;
    }
  }

  function read_channel_item_weather($url){
    try {
      $xml = new SimpleXMLElement($url, LIBXML_NOCDATA, true);
      foreach($xml->channel->item as $item) {
        print_news("", strstr($item->title, '-'), strstr($item->description, '<a', true));
      }
    } catch (Exception $e) {
      echo 'No se descargó XML de ' . $url;
    }
  }

  function print_news($link, $title, $description){
    echo '<hr />';
    echo '<a href="' . $link . '" target="_self" style="color:#000000;text-decoration:none"> <h3> ' . $title . ' </h3> </a>';
    echo '<p>' . $description . '</p>';
  }
?>