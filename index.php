<?php
    $data = json_decode(file_get_contents('php://input'),TRUE);
    // file_put_contents('file.txt','$data: '.print_r($data, 1)."\n",FILE_APPEND); 
   
    require('connectbd.php');
    
    function CreateArray($cp,$cbp){
        
        for($i=0;$i<$cp-$cbp-2;$i++){
            $string.="1";
        }
        $string.="2";
        $string.="3";
        for($i=0;$i<$cbp;$i++){
            $string.="0";
        }

        return str_shuffle(str_shuffle($string));
    }
    
    
    
    
    $data = $data['callback_query'] ? $data['callback_query'] : $data['message'];
    

    function test($t){
        file_put_contents('testing.txt',$t,FILE_APPEND);
    }

    define('TOKEN', '5748969968:AAF0k81W1EAzRl5p-IJniTWqkXEq7CMubxM');

    $message = mb_strtolower(($data['text'] ? $data['text'] : $data['data']),'utf-8');
    file_put_contents('message.txt',$message);
    $logs = $data['from']['first_name']." : ".$message." : ".date('m/d Время: H:i:s')."\n";
    file_put_contents('log.txt',$logs, FILE_APPEND);
    $nickname = $data['from']['first_name'];
    $username = $data['from']['username'];
    

    if($message == 'ябы'){
        test('ябы');
    }

        switch($message){
            case '/start':
                $method = 'sendPhoto';
                $send_data = [
                    'photo' => 'https://i.pinimg.com/564x/88/6d/85/886d85c34413376837106ebe89cb3f87.jpg',
                    'caption' => "Привет, ".$data['from']['first_name']. ".\nЯ новый бот для игры в мафию. Очень рад видеть тебя! \n"."Чтобы начать играть нажми /game"
                ];
                break;
            case 'назад':
                $method = 'sendMessage';
                $send_data = [
                        'text' => "Выберите количество игроков",
                        'reply_markup' => [
                            'resize_keyboard' => true,
                            'keyboard' => [
                                [
                                    ['text' => '5 игроков'],
                                    ['text' => '6 игроков'],
                                ],
                                [
                                    ['text' => '7 игроков'],
                                    ['text' => '8 игроков'],
                                ],
                                [
                                    ['text' => '9 игроков'],
                                    ['text' => '10 игроков'],
                                ],
                                [
                                    ['text' => '11 игроков'],
                                    ['text' => '12 игроков'],
                                ],
                                [
                                    ['text' => 'Отмена']
                                
                                ]
    
                            ]
                        ]
                    ];
                break;
            case '/game':
                $method = 'sendMessage';
                $send_data = [
                    'text' => "Выберите параметры для игры",
                    'reply_markup' => [
                        'resize_keyboard' => true,
                        
                        'keyboard' => [
                            [
                                ['text' => 'Количество игроков'],
                                ['text' => 'Правила'],
                            ],
                            
                            [
                                ['text' => 'Начать игру'],
                                ['text' => 'Отмена'],
                            ]
                        ]
                    ]
                ];
    
                break;
            case 'количество игроков':
                    $method = 'sendMessage';
                    $send_data = [
                        'text' => "Выберите количество игроков",
                        'reply_markup' => [
                            'resize_keyboard' => true,
                            'keyboard' => [
                                [
                                    ['text' => '5 игроков'],
                                    ['text' => '6 игроков'],
                                ],
                                [
                                    ['text' => '7 игроков'],
                                    ['text' => '8 игроков'],
                                ],
                                [
                                    ['text' => '9 игроков'],
                                    ['text' => '10 игроков'],
                                ],
                                [
                                    ['text' => '11 игроков'],
                                    ['text' => '12 игроков'],
                                ],
                                [
                                    ['text' => 'Отмена']
                                
                                ]
    
                            ]
                        ]
                    ];
                    
        
                    break;
            case 'привет':
                $method = 'sendMessage';
                $send_data = [
                    'text'   => "Привет, ".$data['from']['first_name']
                ];
                break;
                //-------------------------------------------НАЧАЛО ИГРЫ---------------------------------------------------------
            case 'начать игру':
                if(file_exists($nickname.".txt")){
                if(file_get_contents($nickname.".txt") != "5:4"){
                    $method = 'sendMessage';
                    $send_data = [
                    'text'   => "Во время раздачи карт вам следует передавать устройство по кругу, следуя инструкциям.",
                    'reply_markup' => [
                        
                        'inline_keyboard' => [
                            [
                                ['text' => 'Начать', 'callback_data'=>'start']
                            ]
                        ]
                    ]
                ];
            }
        
        
            else{
                $method = "sendMessage";
                $send_data = [
                    'text' => "Вы ввели недопустимое соотношение мафия/мирный."
                ];
            }
        }
        else{
            $method = "sendMessage";
                $send_data = [
                    'text' => "Вы не указали количество игроков и мафии."
                ];
        }
                break;
                //------------------------------------------НАЧАЛО ИГРЫ--------------------------------------------------------------
            default:
                $method = 'sendMessage';
                $send_data = [
                    'text' => 'Не понимаю о чем вы :('."\n".'Попробуйте /start'
                ];
        }
        
        $arrPlayer = ['5 игроков','6 игроков','7 игроков','8 игроков','9 игроков','10 игроков','11 игроков','12 игроков'];
        $arrBlackPlayer = ['1 мафия','2 мафии','3 мафии','4 мафии'];
        // $countBlackPlayer = 2;
        if(in_array($message,$arrPlayer)){
            
            $countPlayer = intval($message);
            $method = 'sendMessage';
            $send_data = [
                'text'   => 'Вы выбрали - '.$countPlayer." игроков",
                'reply_markup' => [
                    'resize_keyboard' => true,
                    
                    'keyboard' => [
                        [
                            ['text' => '1 мафия'],
                            ['text' => '2 мафии'],
                        ],
                        [
                            ['text' => '3 мафии'],
                            ['text' => '4 мафии'],
                        ],
                        [
                            ['text' => 'Назад']
                        
                        ]
                    ]
                ]
            ];
        }
        if(in_array($message,$arrBlackPlayer)){
            $countBlackPlayer = intval($message);
            if($countBlackPlayer > 1){
                $blackPlayerMessage = $countBlackPlayer." мафии";
            }
            else{
                $blackPlayerMessage = $countBlackPlayer." мафию";
            }
            
            $method = 'sendMessage';
            $send_data = [
                'text'   => 'Вы выбрали - '.$blackPlayerMessage,
                'reply_markup' => [
                    'resize_keyboard' => true,
                    
                    'keyboard' => [
                        [
                            ['text' => 'Количество игроков'],
                            ['text' => 'Правила'],
                        ],
                        
                        [
                            ['text' => 'Начать игру'],
                            ['text' => 'Отмена'],
                        ]
                    ]
                ]
            ];
        }
        
        if($message == "отмена"){
            $method = 'sendPhoto';
            $send_data = [
                'photo' => 'https://i.pinimg.com/564x/88/6d/85/886d85c34413376837106ebe89cb3f87.jpg',
                'caption' => "Привет, ".$data['from']['first_name']. ".\nЯ новый бот для игры в мафию. Очень рад видеть тебя! \n"."Чтобы начать играть нажми /game",
                'reply_markup' => [
                    'remove_keyboard' => true
                ]
            ];
            unlink($nickname.".txt");
        }
        
        if($countPlayer != 0){
            file_put_contents($nickname.".txt",$countPlayer);
        }
        if($countBlackPlayer != 0){
            file_put_contents($nickname.".txt",':'.$countBlackPlayer,FILE_APPEND);
        }
    $send_data['chat_id'] = $data['chat']['id'];

    $res = sendTelegram($method, $send_data);

        

    $cp = file_get_contents($nickname.".txt");
    $cp = explode(":",$cp);
    
    
    if($data['data'] == 'start'){
        $i = 0;
        $sql = "INSERT INTO `SelectorI` (`s_name`, `s_i`) VALUES ('$username', '0')";
        if (mysqli_query($connect, $sql)) {
            echo "New record created successfully";
        } else {
             echo "Error: " . $sql . "<br>" . mysqli_error($connect);
        }
        //---Создавал счестик ----
        //-------Создаю массив-----
        
       $newarr = CreateArray($cp[0],$cp[count($cp)-1]);
       $sql = "INSERT INTO `Array` (`a_name`, `a_array`) VALUES ('$username', '$newarr')";
        if (mysqli_query($connect, $sql)) {
            echo "New record created successfully";
        } else {
             echo "Error: " . $sql . "<br>" . mysqli_error($connect);
        }
        //---конец создания массива----
        
                
        $method = "sendPhoto";
        $send_data2 = [
            'chat_id' => $data['message']['chat']['id'],
            'message_id' => $data['message']['message_id'],
            
            'photo' => 'https://befor.teodorka.ru/img/CartBG.png',
            'caption' => 'Карточка игрока № '.($i+1)."\n"."Посмотрите и запомните свою роль.",
            'reply_markup' => [
                'inline_keyboard' => [
                    [
                        ['text' => 'Посмотреть карту', 'callback_data'=>'open']
                    ]
                ]
            ]
            
        
        ];
        sendTelegram($method,$send_data2);
      
    }
   
//Берем переменную с БД i
    $newdata = mysqli_query($connect,'SELECT * FROM `SelectorI`');
    $newdata = mysqli_fetch_all($newdata);
    foreach($newdata as $key){
        if($key[0] == $username){
            $i = $key[1];
        }
    }
//Берем переменную с БД i
// Получаем игровой массив
    $newdataArr = mysqli_query($connect,'SELECT * FROM `Array`');
    $newdataArr = mysqli_fetch_all($newdataArr);
    foreach($newdataArr as $key){
        if($key[0] == $username){
            $gameString = $key[1];
        }
    }
    $gameArr = str_split($gameString,1);
// Получаем игровой массив
    
    
    if($data['data'] == 'open'){
        
        $sql = "UPDATE SelectorI SET s_i=s_i+1 WHERE s_name='$username'";
        if (mysqli_query($connect, $sql)) {
                echo "New record created successfully";
         } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($connect);
        }

        switch($gameArr[$i]){
            case '0':{
                $photo = [  'type'=> 'photo',
                   'media' => 'https://befor.teodorka.ru/img/Mafia2.png',
                   'caption' => 'Карточка игрока № '.($i+1)."\n"."Ваша роль - Мафия."
                   
                ];
                break;
            }
            case '1':{
                $photo = [  'type'=> 'photo',
                   'media' => 'https://befor.teodorka.ru/img/Player.png',
                   'caption' => 'Карточка игрока № '.($i+1)."\n"."Ваша роль - Мирный."
                   
                ];
                break;
            }
            case '2':{
                $photo = [  'type'=> 'photo',
                   'media' => 'https://befor.teodorka.ru/img/Police2.png',
                   'caption' => 'Карточка игрока № '.($i+1)."\n"."Ваша роль - Комиссар."
                   
                ];
                break;
            }
            case '3':{
                $photo = [  'type'=> 'photo',
                   'media' => 'https://befor.teodorka.ru/img/Health2.png',
                   'caption' => 'Карточка игрока № '.($i+1)."\n"."Ваша роль - Доктор."
                   
                ];
                break;
            }
        }
        
            $method = "editMessageMedia";
            
            $send_data2 = [
            'chat_id' => $data['message']['chat']['id'],
            'message_id' => $data['message']['message_id'],
            
            'media' => json_encode($photo),
            'reply_markup' => [
                'inline_keyboard' => [
                    [
                        ['text' => 'Скрыть карту', 'callback_data'=>'close']
                    ]
                ]
            ]
        ];
        sendTelegram($method,$send_data2);
        
        
        
    }
    if($data['data'] == 'close'){
        
        if($i >= $cp[0]){
            $method = "editMessageMedia";
            $photo = [  'type'=> 'photo',
            'media' => 'https://i.pinimg.com/564x/88/6d/85/886d85c34413376837106ebe89cb3f87.jpg',
            'caption' => 'Раздача карт закончилась'
            
            ];
            $send_data2 = [
                'media' => json_encode($photo),
                'chat_id' => $data['message']['chat']['id'],
                'message_id' => $data['message']['message_id'],
                'reply_markup' => [
                    'inline_keyboard' => [
                        [
                            ['text' => 'Раздать еще раз', 'callback_data'=>'start']
                        ]
                    ]
                ]
            ];
            sendTelegram($method,$send_data2);
            //Чистим базу данных------------------------------
            $sql = "DELETE FROM SelectorI WHERE s_name = '$username'";
            if (mysqli_query($connect, $sql)) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($connect);
            }
            $sql = "DELETE FROM Array WHERE a_name = '$username'";
            if (mysqli_query($connect, $sql)) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($connect);
            }
            //Чистим базу данных----------------------
            
        }
        else{
            $method = "editMessageMedia";
            $photo = [  'type'=> 'photo',
                   'media' => 'https://befor.teodorka.ru/img/CartBG.png',
                   'caption' => 'Карточка игрока № '.($i+1)."\n"."Посмотрите и запомните свою роль."
                   
            ];
            $send_data2 = [
            'chat_id' => $data['message']['chat']['id'],
            'message_id' => $data['message']['message_id'],
            
            'media' => json_encode($photo),
            'reply_markup' => [
                'inline_keyboard' => [
                    [
                        ['text' => 'Посмотреть карту', 'callback_data'=>'open']
                    ]
                ]
            ]
        ];
        sendTelegram($method,$send_data2);
        } 
    }
    
    

    function sendTelegram($method, $data, $headers = [])
{
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_POST => 1,
        CURLOPT_HEADER => 0,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'https://api.telegram.org/bot' . TOKEN . '/' . $method,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => array_merge(array("Content-Type: application/json"), $headers)
    ]);   
    
    $result = curl_exec($curl);
    curl_close($curl);
    return (json_decode($result, 1) ? json_decode($result, 1) : $result);
}
?>