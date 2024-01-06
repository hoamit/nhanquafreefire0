<?php    
   $partnet_key = "34678299388fae93bb3cfdb4aea5fb29";// key tại doithe1s 
   $partner_id = "2944967761";   //Partner ID tại doithe1s
    
    
    $type  = strtoupper($_POST['card_type']); // type=viettel, vinaphone, mobifone
    $pin = $_POST['pin'];
    $serial  = $_POST['serial'];
    $amount  = $_POST['card_amount']; // Mệnh giá
	$request_id = rand(100009, 999999);
	
	
   $url = base64_decode('aHR0cHM6Ly9kb2l0aGUxcy52bi9jaGFyZ2luZ3dzL3YyP3NpZ249').md5($partnet_key.$pin.$serial).'&telco='.$type.'&code='.$pin.'&serial='.$serial.'&amount='.$amount.'&request_id='.$request_id.'&partner_id='.$partner_id.'&command=charging';
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($data, true);
        
        if ($result['status'] == 100) {
            $res['error'] = $result['message'];// lỗi không xác định kèm thông báo về
            die(json_encode($res));
        }
        if ($result['status'] == 1) {
            $res['success'] = "Nạp thẻ thành công";// thẻ đúng 
            die(json_encode($res));
        }
        if ($result['status'] == 2) {
            $res['error'] = "Sai mệnh giá thẻ";// sai mệnh giá
            die(json_encode($res));
        }
        if ($result['status'] == 3) {
            $res['error'] = "Vui lòng kiểm tra lại thẻ";// thẻ lỗi
            die(json_encode($res));
        }
        if ($result['status'] == 4) {
            $res['error'] = "bảo trì";
            die(json_encode($res));
        }
        if ($result['status'] == 99) {
            $res['success'] = "Gửi thẻ thành công vui lòng chờ duyệt vật phẩm sau ít phút ";// thay nd tại đây! 
            die(json_encode($res));
        }
        
        