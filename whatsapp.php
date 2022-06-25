<?php
    // it team 201028879986-1560586609@g.us
    // shipping  201028879986-1538555660@g.us
    // ceo  201028879986-1624909257@g.us
    // new ops notifications 201094380861-1625997790@g.us
                require "encrypt.php";

    function send($vessel_id, $message, $receiver,$url){

                $instance ='instance289321';
                $token = 'jq8uqjau54shlok1';
                
                require "config.php";

                $idencode = encrypt($vessel_id,'1475963082Aa@@');

                $result1 = mysqli_query($con,"SELECT *  FROM vessels_log   where vessel_id = '$vessel_id' AND done = 0 ");
                $row = mysqli_fetch_assoc($result1);
                $vessel_name = $row['name']; 
                $vessel_client = $row['client']; 
                $vessel_type = $row['type']; 
                $vessel_qnt = $row['qnt']; 
                $vessel_quay = $row['quay']; 
                
                $vessel_phones = $row['phones']; 

                if($receiver == 'it') $chat_id =   "201028879986-1560586609@g.us";
                if($receiver == 'shipping') $chat_id =   "201094380861-1625997790@g.us";
                if($receiver == 'ceo') $chat_id =   "201028879986-1624909257@g.us";

                if($url == false){
                      $message.= "\r\n";
                      $message.= 'اسم الباخرة: *'.$vessel_name.'*';
                      if($receiver  != 'shipping'){
                        $message.= "\r\n";
                        $message.= ' العميل : *'.$vessel_client.'*';
                      }
	                    $message.= "\r\n";
	                    $message.= ' الصنف : *'.$vessel_type.'*';
	                    $message.= "\r\n";
	                    $message.= ' الكمية : '.$vessel_qnt;
	                    $message.= "\r\n";
	                    $message.= ' الرصيف : '.$vessel_quay;
                }elseif ($receiver  != 'client') {
                        $message.= 'http://marine-co.live/wa/shipping/?'.$idencode;
                }
                if($receiver  == 'client'){
                    if($vessel_phones != ''){
                        $phones = explode(',', urldecode($vessel_phones));
                        // $message.= "\r\n";
                        // $message.= 'http://marine-co.live/wa/shipping/client/?'.$idencode;
                        for($i=0;$i<count($phones);$i++){
                        $data = [
	                          "phone" => $phones[$i],
                            "body" => $message
                            ];
                        $json = json_encode($data); 
                        $url = 'https://api.chat-api.com/'.$instance.'/message?token='.$token;
                        /*$options = stream_context_create(['http' => [
                            'method'  => 'POST',
                            'header'  => 'Content-type: application/json',
                            'content' => $json
                            ]
                        ]);
                        file_get_contents($url, false, $options);*/
                        }
                      }
                }else {
                    $data = [
	                        "chatId" => $chat_id,
                            'body' => $message, 
                    ];
                    $json = json_encode($data);
                    $url = 'https://api.chat-api.com/'.$instance.'/message?token='.$token;
                    /*$options = stream_context_create(['http' => [
                    'method'  => 'POST',
                    'header'  => 'Content-type: application/json',
                    'content' => $json
                    ]
                    ]);

                    // Send a request
                    file_get_contents($url, false, $options);*/
                }            
    }

      
            
            
?>