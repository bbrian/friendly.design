<?php

function parseRSS($url)
{ 
 
 	 //Facebook doesn't like much
    $ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.2.13) Gecko/20101206 Ubuntu/10.10 (maverick) Firefox/3.6.13'); // set the user agent here
		
	$data = curl_exec($ch);
 
	//PARSE RSS FEED
        //$feedeed = implode('', file($url));
        $parser = xml_parser_create();
        xml_parse_into_struct($parser, $data, $valueals, $index);
        xml_parser_free($parser);

 
	//CONSTRUCT ARRAY
        foreach($valueals as $keyey => $valueal){
            if($valueal['type'] != 'cdata') {
                $item[$keyey] = $valueal;
			}
        }
 			
        $i = 0;
 
        foreach($item as $key => $value){
 
            if($value['type'] == 'open') {
 
                $i++;
                $itemame[$i] = $value['tag'];
 
            } elseif($value['type'] == 'close') {
 
                $feed = $values[$i];
                $item = $itemame[$i];
                $i--;
 
 
 				/*echo "<pre>";
 					print_r($values);
 				echo "</pre>";*/
 
                if(count($values[$i])>1){
                    $values[$i][$item][] = $feed;
                } else {
                    $values[$i][$item] = $feed;
                }
 
            } else {
                $values[$i][$value['tag']] = $value['value'];  
            }
        }
        
		$updates_and_ids = array(); // array( 'ID' => 'UPDATE TEXT' )
        foreach( $values as $status_blocks )
        {
        
        	foreach($status_blocks as $indiv_status)
        	{
        		
        		if( is_array($indiv_status) )
        		{
        			if( array_key_exists('ITEM', $indiv_status) )
        			{
        				if( is_array($indiv_status['ITEM'] ))
        				{
        					foreach( $indiv_status['ITEM'] as $status_update )
        					{
        						$status_id = $status_update['GUID'];
        						$status_text = "";
        						if( array_key_exists('DESCRIPTION', $status_update) )
        							$status_text = $status_update['DESCRIPTION'];
        							
        						$updates_and_ids[$status_id] = $status_text;
        					}
        				}
        			}
        		}
        		
        	}
        
        }

        
	//RETURN ARRAY VALUES
    return $updates_and_ids;

} 

?>