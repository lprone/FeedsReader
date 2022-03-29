<?php
  $q=$_GET["q"];
  libxml_use_internal_errors(true);
  switch ($q) {
    case 'Clarin':
      read_channel_item("http://www.clarin.com/rss/lo-ultimo/");
      break;
    case 'LaNacion':
      read_entry("http://contenidos.lanacion.com.ar/herramientas/rss-origen=2");
      break;
    case 'Iprofesional':
      read_channel_item('https://www.iprofesional.com/rss/home');
      break;
    case 'Infobae':
      read_channel_item('http://www.infobae.com/argentina-rss.xml');
      break;
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    case 'LaVoz':
      read_channel_item('http://srvc.lavoz.com.ar/rss.xml');
      break;
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    case 'BBC':
      read_channel_item("http://feeds.bbci.co.uk/mundo/rss.xml");
      break;
    case 'LaNacionMundo':
      read_entry('http://contenidos.lanacion.com.ar/herramientas/rss-categoria_id=7');
      break;
    case 'CNN':
      read_channel_item('http://cnnespanol.cnn.com/author/cnn-espanol/feed/');
      break;
    case 'MuyInt':
      read_channel_item('http://feeds2.feedburner.com/Muyinteresantees');
      break;
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    case 'ClarinTecno':
      read_channel_item("https://www.clarin.com/rss/tecnologia/");
      break;
    case 'LaNacionTecno':
      read_entry("http://contenidos.lanacion.com.ar/herramientas/rss-categoria_id=432");
      break;
    case 'LaVozTecno':
      read_channel_item('http://srvc.lavoz.com.ar/taxonomy/term/23342/1/feed');
      break;
    case 'MuyComputer':
      read_channel_item('http://www.muycomputer.com/feed/');
      break;
    case 'Ticbeat':
      read_channel_item('http://www.ticbeat.com/feed/');
      break;
	  case 'FayerWayer':
      read_fawerWayer('http://feeds2.feedburner.com/fayerwayer');
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
    case 'LaNacionDepo':
      read_entry('http://contenidos.lanacion.com.ar/herramientas/rss-categoria_id=131');
      break;
    case 'ClarinFut':
      read_channel_item("http://www.clarin.com/rss/deportes/futbol/");
      break;
    case 'OLE':
      read_channel_item('http://www.ole.com.ar/rss/ultimas-noticias/');
      break;
  }

  function read_channel_item($url){
    try {
      $context  = stream_context_create(array('http' => array('header' => 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.110 Safari/537.36')));
      $response = file_get_contents($url, false, $context);
      $xmlObject = simplexml_load_string($response);
      $xml = new SimpleXMLElement($response, LIBXML_NOCDATA, true) or die($url." not loading");
      echo $xml;
      foreach($xml->channel->item as $item) {
        print_news($item->link, $item->title, $item->description);
      }
    } catch (Exception $e) {
      echo 'No se descargó XML de ' . $url;
    }
  }

  function read_entry($url){
    try {
      $xml = new SimpleXMLElement($url, LIBXML_NOCDATA, true) or die($url." not loading");
      foreach ($xml->entry as $entry) {
        print_news($entry->link['href'], $entry->title, $entry->content->div);
      }
    } catch (Exception $e) {
      echo 'No se descargó XML de ' . $url;
    }
  }

  function read_fawerWayer($url){
    try {
      $xml = new SimpleXMLElement($url, LIBXML_NOCDATA, true) or die($url." not loading");
      foreach($xml->channel->item as $item) {
        print_news($item->link, $item->title, $item->description);
        echo '<br><br><br><br><br><br>';
      }
    } catch (Exception $e) {
      echo 'No se descargó XML de ' . $url;
    }

  }
  function read_channel_item_weather($url){
    try {
      $xml = new SimpleXMLElement($url, LIBXML_NOCDATA, true) or die($url." not loading");
      foreach($xml->channel->item as $item) {
        echo '<hr />';
        echo '<a style="color:#000000;text-decoration:none"> <h3> ' . strstr($item->title, '-') . ' </h3> </a>';
        echo '<p>' . strstr($item->description, '<a', true) . '</p>';
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