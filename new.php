<?php header('Content-Type: text/html; charset=utf-8'); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html;" />
	<title>RSS Slideshow</title>
	<link rel="stylesheet" href="style.css" type="text/css" media="screen" />
</head>
<body>
    <div id="myslides">
    	<?php

        $rss = file_get_contents("https://www-rails.samfundet.no/rss");
        $rss = str_replace("&aring;", "aaringe",$rss);                          //super quick-fix for xml parse-error! burde gjøre så xml ikke bryr seg om data. se CDATA
    	$xml = simplexml_load_string($rss);

    	//Henter ut info fra RSS
        $i=0;
    	foreach($xml->channel->item as $event){
    		$title = $event->title;
    		$dato = strtotime($event->pubDate);										
            $location = $event->location;
            $tid = str_replace(".",":",$dato[4]);
    		$bilde = $event->link[1]["href"];
    		//$bilde = split("_",$bilde[0]);
    		//$bilde = $bilde[0].".jpg";
            $color = '#' . strtoupper(dechex(rand(100,200)).dechex(rand(100,200)).dechex(rand(100,200)));
    		echo("<!--"); print_r($bilde); echo("-->");

    		$out='<div class="bg" style="background: url('.$bilde.') no-repeat center center fixed;"/>
            ';
    		$out.='    <div class="container">
                    <div class="title" style="color:'.$color.';">'.$title."</div>
            ";
            $out .='        <div class="date">'.date("D j. M - H:i", $dato)." ".$location."</div>
            ";
    		$out .="    </div>
            </div>
            
            ";
    		echo($out); //skjempefint formatert kode! :D

            $i++;
            if($i>12)break; //ikke vis for mange arrangementer frem i tid, tar for mye minne for paiene.
    }		
    ?>
</div>

<script src="scripts/jquery-1.7.2.min.js" type="text/javascript"></script>
<script src="scripts/jquery.cycle.lite.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function(){
        animSpeed=1;
        if(window.location.hash.substr(1)>0)animSpeed+=parseInt(window.location.hash.substr(1));
        $('#myslides').cycle({
            fit: 1, pause: 1, timeout: 5000, speed:animSpeed
        });
    });
</script>

</body>
</html>

<!-- Utvikler: Nixo, VideoKomiteen, 2014 -->