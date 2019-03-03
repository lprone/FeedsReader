<?php
  $q=$_GET["q"];
  echo "<hr />";
  switch ($q) {
    case 'Clarin':
      $xml=("http://www.clarin.com/rss/lo-ultimo/");
      $xml_data = new SimpleXMLElement($xml, LIBXML_NOCDATA, true);
      foreach ($xml_data->channel->item as $item) {
         echo '<a href="'.$item->link.'" target="_self" style="color:#000000;text-decoration:none"> <h3> '.$item->title.' </h3> </a>';
         echo "<p>" . $item->description . "</p>";
         echo "<hr />";
      };
      break;
    case 'Nacion':
      $xml=("http://contenidos.lanacion.com.ar/herramientas/rss-origen=2");
      $xml_data = new SimpleXMLElement($xml, LIBXML_NOCDATA, true);
      foreach ($xml_data->entry as $entry) {
         echo '<a href="'.$entry->link['href'].'" target="_self" style="color:#000000;text-decoration:none"> <h3> '.$entry->title.' </h3> </a>';
         echo "<p>" . $entry->content->div . "</p>";
         echo "<hr />";
      };
      break;
    case 'tn':
      $xml = file_get_contents('http://tn.com.ar/rss.xml');
      $xmlobj = new SimpleXMLElement($xml);
      foreach($xmlobj->channel->item as $item) {
        echo '<a href="'.$item->link.'" target="_self" style="color:#000000;text-decoration:none"> <h3> '.$item->title.' </h3> </a>';
        //echo "<p>" . $item->description . "</p>";
        echo "<hr />";
      };
      break;
    case 'infobae':
      //$xml = file_get_contents('http://cdn01.am.infobae.com/adjuntos/163/rss/ahora.xml');
	  libxml_use_internal_errors(true);
	  try {
         $xml = file_get_contents('http://www.infobae.com/argentina-rss.xml');
         $xmlobj = new SimpleXMLElement($xml);
         $aux = 'lalala';
         foreach($xmlobj->channel->item as $item) {
           if (strcmp($aux, $item->title) != 0) {
              echo '<a href="'.$item->link.'" target="_self" style="color:#000000;text-decoration:none"> <h3> '.$item->title.' </h3> </a>';
              echo "<p>" . $item->description . "</p>";
              echo "<hr />";
              $aux = $item->title;
           }
         }
	  } catch (Exception $e) {echo 'No se descargó XML de Infobae';}
      break;
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    case 'laVoz':
      //$xml = file_get_contents('http://www.lavoz.com.ar/rss.xml');
      $xml = file_get_contents('http://srvc.lavoz.com.ar/rss.xml');
      $xmlobj = new SimpleXMLElement($xml);
      foreach($xmlobj->channel->item as $item) {
        echo '<a href="'.$item->link.'" target="_self" style="color:#000000;text-decoration:none"> <h3> '.$item->title.' </h3> </a>';
        echo "<p>" . $item->description . "</p>";
        echo "<hr />";
      };
      break;
    case 'telediario':
      $xml = file_get_contents('http://feeds2.feedburner.com/telediariodigital');
      $xmlobj = new SimpleXMLElement($xml);
      foreach($xmlobj->channel->item as $item) {
        echo '<a href="'.$item->link.'" target="_self" style="color:#000000;text-decoration:none"> <h3> '.$item->title.' </h3> </a>';
        echo "<p>" . $item->description . "</p>";
        echo "<hr />";
      };
      break;
    case 'rio4info':
      $xml=("https://www.riocuartoinfo.com/feed");
      $xml_data = new SimpleXMLElement($xml, LIBXML_NOCDATA, true);
      foreach ($xml_data->channel->item as $item) {
         echo '<a href="'.$item->link.'" target="_self" style="color:#000000;text-decoration:none"> <h3> '.$item->title.' </h3> </a>';
         echo "<p>" . $item->description . "</p>";
         echo "<hr />";
      };
      break;
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    case 'BBC':
      $xml=("http://feeds.bbci.co.uk/mundo/rss.xml");
      $xml_data = new SimpleXMLElement($xml, LIBXML_NOCDATA, true);
      foreach ($xml_data->channel->item as $entry) {
        echo '<a href="'.$entry->link.'" target="_self" style="color:#000000;text-decoration:none"> <h3> '.$entry->title.' </h3> </a>';
        echo "<p>" . $entry->description . "</p>";
        echo "<hr />";
      };
      break;
    case 'cnn':
      $xml = file_get_contents('http://cnnespanol.cnn.com/author/cnn-espanol/feed/');
      $xmlobj = new SimpleXMLElement($xml);
      foreach($xmlobj->channel->item as $item) {
        echo '<a href="'.$item->link.'" target="_self" style="color:#000000;text-decoration:none"> <h3> '.$item->title.' </h3> </a>';
        echo "<p>" . $item->description . "</p>";
        echo "<hr />";
      };
      break;
    case 'NacionMundo':
      $xml= ('http://contenidos.lanacion.com.ar/herramientas/rss-categoria_id=7');
      $xmlobj = new SimpleXMLElement($xml, LIBXML_NOCDATA, true);
      foreach($xmlobj->entry as $item) {
        echo '<a href="'.$item->link['href'].'" target="_self" style="color:#000000;text-decoration:none"> <h3> '.$item->title.' </h3> </a>';
        echo "<p>" . $item->content->div  . "</p>";
        echo "<hr />";
      };
      break;
    case 'MuyInt':
      $xml = file_get_contents('http://feeds2.feedburner.com/Muyinteresantees');
      $xmlobj = new SimpleXMLElement($xml);
      foreach($xmlobj->channel->item as $item) {
        echo '<a href="'.$item->link.'" target="_self" style="color:#000000;text-decoration:none"> <h3> '.$item->title.' </h3> </a>';
        echo "<p>" . $item->description . "</p>";
        echo "<hr />";
      };
      break;
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    case 'ClarinTecno':
      //$xml=("http://www.clarin.com/rss/next/");
      $xml=("https://www.clarin.com/rss/tecnologia/");
      $xml_data = new SimpleXMLElement($xml, LIBXML_NOCDATA, true);
      foreach ($xml_data->channel->item as $item) {
         echo '<a href="'.$item->link.'" target="_self" style="color:#000000;text-decoration:none"> <h3> '.$item->title.' </h3> </a>';
         echo "<p>" . $item->description . "</p>";
         echo "<hr />";
      };
      break;
    case 'NacionTecno':
      $xml=("http://contenidos.lanacion.com.ar/herramientas/rss-categoria_id=432");
      $xml_data = new SimpleXMLElement($xml, LIBXML_NOCDATA, true);
      foreach ($xml_data->entry as $entry) {
         echo '<a href="'.$entry->link['href'].'" target="_self" style="color:#000000;text-decoration:none"> <h3> '.$entry->title.' </h3> </a>';
         echo "<p>" . $entry->content->div . "</p>";
         echo "<hr />";
      };
      break;
    case 'vozTecno':
      $xml = file_get_contents('http://srvc.lavoz.com.ar/taxonomy/term/23342/1/feed');
      $xmlobj = new SimpleXMLElement($xml);
      foreach($xmlobj->channel->item as $item) {
        echo '<a href="'.$item->link.'" target="_self" style="color:#000000;text-decoration:none"> <h3> '.$item->title.' </h3> </a>';
        echo "<p>" . $item->description . "</p>";
        echo "<hr />";
      };
      break;
    case 'muyComputer':
      $xml = file_get_contents('http://www.muycomputer.com/feed/');
      $xmlobj = new SimpleXMLElement($xml);
      foreach($xmlobj->channel->item as $item) {
        echo '<a href="'.$item->link.'" target="_self" style="color:#000000;text-decoration:none"> <h3> '.$item->title.' </h3> </a>';
        echo "<p>" . $item->description . "</p>";
        echo "<hr />";
      };
      break;
    case 'ticbeat':
      $xml = file_get_contents('http://www.ticbeat.com/feed/');
      $xmlobj = new SimpleXMLElement($xml);
      foreach($xmlobj->channel->item as $item) {
        echo '<a href="'.$item->link.'" target="_self" style="color:#000000;text-decoration:none"> <h3> '.$item->title.' </h3> </a>';
        echo "<p>" . $item->description . "</p>";
        echo "<hr />";
      };
      break;
	case 'fayerWayer':
      $xml = file_get_contents('http://feeds2.feedburner.com/fayerwayer');
      $xmlobj = new SimpleXMLElement($xml);
      foreach($xmlobj->channel->item as $item) {
        echo '<a href="'.$item->link.'" target="_self" style="color:#000000;text-decoration:none"> <h3> '.$item->title.' </h3> </a>';
        echo "<p>" . $item->description . "</p>";
		echo "<br><br><br><br><br><br>";
        echo "<hr />";
      };
      break;
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    case 'cliCba':
      $xml = file_get_contents('http://xml.tutiempo.net/rss/42926.xml');
      $xmlobj = new SimpleXMLElement($xml);
      foreach($xmlobj->channel->item as $item) {
           //echo print_r(explode('-', $item->title, -1));
           echo '<a style="color:#000000;text-decoration:none"> <h3> '.strstr($item->title, '-').' </h3> </a>';
           echo "<p>" . strstr($item->description, '<a', true) . "</p>";
           echo "<hr />";
      };
      break;
    case 'cliR4':
      $xml = file_get_contents('http://xml.tutiempo.net/rss/31019.xml');
      $xmlobj = new SimpleXMLElement($xml);
      foreach($xmlobj->channel->item as $item) {
           //echo print_r(explode('-', $item->title, -1));
           echo '<a style="color:#000000;text-decoration:none"> <h3> '.strstr($item->title, '-').' </h3> </a>';
           echo "<p>" . strstr($item->description, '<a', true) . "</p>";
           echo "<hr />";
      };
      break;
    case 'cliVT':
      $xml = file_get_contents('http://xml.tutiempo.net/rss/43412.xml');
      $xmlobj = new SimpleXMLElement($xml);
      foreach($xmlobj->channel->item as $item) {
           echo '<a style="color:#000000;text-decoration:none"> <h3> '.strstr($item->title, '-').' </h3> </a>';
           echo "<p>" . strstr($item->description, '<a', true) . "</p>";
           echo "<hr />";
      };
      break;
    case 'cliJN':
      $xml = file_get_contents('http://xml.tutiempo.net/rss/43074.xml');
      $xmlobj = new SimpleXMLElement($xml);
      foreach($xmlobj->channel->item as $item) {
           echo '<a style="color:#000000;text-decoration:none"> <h3> '.strstr($item->title, '-').' </h3> </a>';
           echo "<p>" . strstr($item->description, '<a', true) . "</p>";
           echo "<hr />";
      };
      break;
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    case 'NacionDepo':
      $xml= ('http://contenidos.lanacion.com.ar/herramientas/rss-categoria_id=131');
      $xmlobj = new SimpleXMLElement($xml, LIBXML_NOCDATA, true);
      foreach($xmlobj->entry as $item) {
        echo '<a href="'.$item->link['href'].'" target="_self" style="color:#000000;text-decoration:none"> <h3> '.$item->title.' </h3> </a>';
        echo "<p>" . $item->content->div  . "</p>";
        echo "<hr />";
      };
      break;
    case 'ClarinFut':
      $xml=("http://www.clarin.com/rss/deportes/futbol/");
      $xml_data = new SimpleXMLElement($xml, LIBXML_NOCDATA, true);
      foreach ($xml_data->channel->item as $item) {
         echo '<a href="'.$item->link.'" target="_self" style="color:#000000;text-decoration:none"> <h3> '.$item->title.' </h3> </a>';
         echo "<p>" . $item->description . "</p>";
         echo "<hr />";
      };
      break;
    case 'ole':
      $xml = file_get_contents('http://www.ole.com.ar/rss/ultimas-noticias/');
      $xmlobj = new SimpleXMLElement($xml);
      foreach($xmlobj->channel->item as $item) {
        echo '<a href="'.$item->link.'" target="_self" style="color:#000000;text-decoration:none"> <h3> '.$item->title.' </h3> </a>';
        echo "<p>" . $item->description . "</p>";
        echo "<hr />";
      };
      break;
  };
?>