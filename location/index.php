<?php
    header('Content-type: Application/json');
    //Get Client IP Address
    $ip = $_SERVER['REMOTE_ADDR'];
    
    //Query API to get details 
    $data = file_get_contents('http://ip-api.com/php/'.$ip);
    
    //Trim to make it look good
    $info = ltrim($data, 'a:14:');
    
    //Trim left
    $left = ltrim($info, '{');
    
    //Trim Right
    $right = rtrim($left, '}');
    
    //Info to work with 
    $info = $right;
    
    //Split every ";"
    $split = explode(';', $info);
    
    $arr = array();
    
    $newLeft = array();
    
    $newRight = array();
    
    foreach($split as $value){
        //Left trim to remove "s:"
        $val = ltrim($value, 's:');
        
        //Explode to get values standing alone
        $div = explode(':', $val);
        
        //We don't need the left one -- contains string length
        $leftone = $div[0];
        
        //The right one is what we would work with
        $rightone = $div[1];
        
        //Trim Left to remove any ' " ' around value
        $trimLeftofRight = ltrim($rightone, '"');
        
        //Trim Right to remove any ' " ' around value
        $trimRightofRight = rtrim($trimLeftofRight, '"');
        
        //Push the string length(numbers) into this array
        array_push($newLeft, $div[0]);
        
        //Push the real data we would work with into newRight Array
        array_push($newRight, $trimRightofRight);
        
        array_push($arr, $val);
    }
    
    echo json_encode($newRight);
    
    echo '<br /><br />';
    
    $count = count($newRight);
    
    $countryP = null;
    $cityP = null;
    $countrycodeP = null;
    $zipP = null;
    $timezoneP = null;
    $ipP = null;
    $ispP = null;
    $asP = null;
    $orgP = null;
    $statusP = null;
    $regionP = null;
    $regionnameP = null;
    $lonP = null;
    $latP = null;
    
    
    for($i=0; $i<$count; $i++){
        if($newRight[$i]=='country'){
            $countryP = $i;
        }
        
        if($newRight[$i]=='regionName'){
            $regionnameP = $i;
        }
        
        if($newRight[$i]=='zip'){
            $zipP = $i;
        }
        
        if($newRight[$i]=='status'){
            $statusP = $i;
        }
        
        if($newRight[$i]=='query'){
            $ipP = $i;
        }
        
        if($newRight[$i]=='lon'){
            $lonP = $i;
        }
        
        if($newRight[$i]=='lat'){
            $latP = $i;
        }
        
        if($newRight[$i]=='city'){
            $cityP = $i;
        }
        
        if($newRight[$i]=='org'){
            $orgP = $i;
        }
        
        if($newRight[$i]=='countryCode'){
            $countrycodeP = $i;
        }
        
        if($newRight[$i]=='region'){
            $regionP = $i;
        }
        
        if($newRight[$i]=='timezone'){
            $timezoneP = $i;
        }
        
        if($newRight[$i]=='isp'){
            $ispP = $i;
        }
        
        if($newRight[$i]=='as'){
            $asP = $i;
        }
    }
    
    
    $country = $newRight[$countryP+1];
    $city = $newRight[$cityP+1];
    $countrycode = $newRight[$countrycodeP+1];
    $zip = $newRight[$zipP+1];
    $timezone = $newRight[$timezoneP+1];
    $ip = $newRight[$ipP+1];
    $isp = $newRight[$ispP+1];
    $as = $newRight[$asP+1];
    $org = $newRight[$orgP+1];
    $status = $newRight[$statusP+1];
    $region = $newRight[$regionP+1];
    $regionname = $newRight[$regionnameP+1];
    $lon = $newRight[$lonP+1];
    $lat = $newRight[$latP+1];
    
    $json = array('status'=>$status, 'ip'=>$ip, 'countryCode'=>$countrycode, 'country'=>$country, 'city'=>$city, 'zip'=>$zip, 'timezone'=>$timezone, 'regionName'=>$regionname, 'region'=>$region, 'isp'=>$isp, 'as'=>$as, 'org'=>$org, 'lon'=>$lon, 'lat'=>$lat);
    
    echo '<br /> <br />';
    
    echo json_encode($json);
    
    //echo $newRight[$countryP];
    //var_dump ($newRight);
    
    
?>