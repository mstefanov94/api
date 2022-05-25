<?php include "../parts/config.php";

    if(!empty($_GET["status"])){
      $stmt=$mysqli->prepare("UPDATE `sms_logs` SET `status`=?, `date`=? WHERE `phone`=?");
      $stmt->bind_param("isi", $_GET["status"], $_GET["date"], $_GET["phone"]);
      $stmt->execute();
      $stmt->close();
    }else{
      $phone='+359883265454';
      $text='Your text here!';
      $token='test_api';

      $data=[
        'user'=>'ZFLOW',
        'pass'=>'O~57fd#0}F',
    
        'phone'=>['phone'=>$phone],
        'sms'=>['message'=>$text]
      ];

      $stmt=$mysqli->prepare("INSERT INTO `sms_logs` (`phone`, `sms`, `token`) VALUES (?, ?, ?)");
      $stmt->bind_param("sss", $phone, $text, $token);
      $stmt->execute();
      $stmt->close();

      function send($url, $request){
        $ch=curl_init();
        $headers=['Accept: application/json','Content-Type: application/json'];
        $options=[
          CURLOPT_URL=>$url,
          CURLOPT_POST=>true,
          CURLOPT_POSTFIELDS=>$request,
          CURLOPT_FOLLOWLOCATION=>true,
          CURLOPT_RETURNTRANSFER=>true,
          CURLOPT_HEADER=>true,
          CURLOPT_HTTPHEADER=>$headers,
        ];
    
        curl_setopt_array($ch, $options);
        $response=curl_exec($ch);
        curl_close($ch);
        return $response;
      }echo send('https://gate.mobica.bg/send.php', json_encode($data));
    }

?>
