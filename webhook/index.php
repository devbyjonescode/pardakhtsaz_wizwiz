<?php
include_once '../config.php';

//ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');
//error_reporting(E_ALL);
$referenceNumber = intval($_GET['reference']);
$subject = $_GET['subject'];
$service = $_GET['service'];
$status = $_GET['status'];
if ($subject != 'order' ||
    $service != 'guest_pay' ||
    $status !='paid'
) {
    exit('access dined');
}

/*$array = [
    'GET' => $_GET,
    'POST' => $_POST,
    'SERVER' => $_SERVER
];
file_put_contents('callback' . date('Y-m-d_H-i-s') . '.' . rand(11111111, 99999999) . '.json', json_encode($array));*/
$stmt = $connection->prepare("SELECT * FROM `pays` WHERE `state`='pending' AND `reference` = ?");
$stmt->bind_param("i", $referenceNumber);
$stmt->execute();
$payInfo = $stmt->get_result()->fetch_assoc();

$stmt->close();
if (is_null($payInfo)) {
    exit('skip status');
}
$payid = $payInfo['payid'];
$payType = $payInfo['type'];
$price = $payInfo['price'];
//call check call back status api
$validateResponse = validateGuestPay($referenceNumber);
if (!in_array($validateResponse->data->content->status, ['paid', 'done']) || ($validateResponse->data->content->price / 10) != $price) {
    exit('wrong state in api call');
}
$stmt = $connection->prepare("UPDATE `pays` SET `state` = 'approved' WHERE `state`='pending' AND `reference` = ?");
$stmt->bind_param("s", $referenceNumber);
$stmt->execute();
$stmt->close();

$from_id = $payInfo['user_id'];
$stmt = $connection->prepare("SELECT * FROM `users` WHERE `userid`=?");
$stmt->bind_param("i", $from_id);
$stmt->execute();
$uinfo = $stmt->get_result();
$userInfo = $uinfo->fetch_assoc();
$stmt->close();
$first_name = $userInfo['name'];
$username = $userInfo['username'];
if ($payType == "INCREASE_WALLET") {
    $stmt = $connection->prepare("UPDATE `users` SET `wallet` = `wallet` + ? WHERE `userid` = ?");
    $stmt->bind_param("ii", $price, $from_id);
    $stmt->execute();
    $stmt->close();

    sendMessage("افزایش حساب شما با موفقیت تأیید شد\n✅ مبلغ " . number_format($price) . " تومان به حساب شما اضافه شد");
    sendMessage("✅ مبلغ " . number_format($price) . " تومان به کیف پول کاربر $from_id توسط درگاه ارزی ریالی اضافه شد", null, null, $admin);
}
elseif ($payType == "BUY_SUB") {
    $uid = $from_id;
    $fid = $payInfo['plan_id'];
    $volume = $payInfo['volume'];
    $days = $payInfo['day'];
    $description = $payInfo['description'];


    $acctxt = '';

    $stmt = $connection->prepare("SELECT * FROM `server_plans` WHERE `id`=?");
    $stmt->bind_param("i", $fid);
    $stmt->execute();
    $file_detail = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($volume == 0 && $days == 0) {
        $volume = $file_detail['volume'];
        $days = $file_detail['days'];
    }

    $date = time();
    $expire_microdate = floor(microtime(true) * 1000) + (864000 * $days * 100);
    $expire_date = $date + (86400 * $days);
    $type = $file_detail['type'];
    $protocol = $file_detail['protocol'];
    $price = $payInfo['price'];

    $server_id = $file_detail['server_id'];
    $netType = $file_detail['type'];
    $acount = $file_detail['acount'];
    $inbound_id = $file_detail['inbound_id'];
    $limitip = $file_detail['limitip'];
    $rahgozar = $file_detail['rahgozar'];
    $customPath = $file_detail['custom_path'];
    $customPort = $file_detail['custom_port'];
    $customSni = $file_detail['custom_sni'];

    $accountCount = $payInfo['agent_count'] != 0 ? $payInfo['agent_count'] : 1;
    $eachPrice = $price / $accountCount;
    if ($acount == 0 and $inbound_id != 0) {
        alert($mainValues['out_of_connection_capacity']);
        exit;
    }
    if ($inbound_id == 0) {
        $stmt = $connection->prepare("SELECT * FROM `server_info` WHERE `id`=?");
        $stmt->bind_param("i", $server_id);
        $stmt->execute();
        $server_info = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($server_info['ucount'] <= 0) {
            alert($mainValues['out_of_server_capacity']);
            exit;
        }
    }

    $stmt = $connection->prepare("SELECT * FROM `server_info` WHERE `id`=?");
    $stmt->bind_param("i", $server_id);
    $stmt->execute();
    $serverInfo = $stmt->get_result()->fetch_assoc();
    $serverTitle = $serverInfo['title'];
    $srv_remark = $serverInfo['remark'];
    $stmt->close();

    $stmt = $connection->prepare("SELECT * FROM `server_config` WHERE `id`=?");
    $stmt->bind_param("i", $server_id);
    $stmt->execute();
    $portType = $stmt->get_result()->fetch_assoc()['port_type'];
    $stmt->close();
    include '../phpqrcode/qrlib.php';

    for ($i = 1; $i <= $accountCount; $i++) {
        $uniqid = generateRandomString(42, $protocol);

        $savedinfo = file_get_contents('../settings/temp.txt');
        $savedinfo = explode('-', $savedinfo);
        $port = $savedinfo[0] + 1;
        $last_num = $savedinfo[1] + 1;

        if (isset($botState['remark']) && $botState['remark'] == "digits") {
            $rnd = rand(10000, 99999);
            $remark = "{$srv_remark}-{$rnd}";
        } else {
            $rnd = rand(1111, 99999);
            $remark = "{$srv_remark}-{$from_id}-{$rnd}";
        }
        if (!empty($description)) $remark = $description;
        if ($portType == "auto") {
            file_put_contents('../settings/temp.txt', $port . '-' . $last_num);
        } else {
            $port = rand(1111, 65000);
        }

        if ($inbound_id == 0) {
            $response = addUser($server_id, $uniqid, $protocol, $port, $expire_microdate, $remark, $volume, $netType, 'none', $rahgozar, $fid);
            if (!$response->success) {
                $response = addUser($server_id, $uniqid, $protocol, $port, $expire_microdate, $remark, $volume, $netType, 'none', $rahgozar, $fid);
            }
        } else {
            $response = addInboundAccount($server_id, $uniqid, $inbound_id, $expire_microdate, $remark, $volume, $limitip, null, $fid);
            if (!$response->success) {
                $response = addInboundAccount($server_id, $uniqid, $inbound_id, $expire_microdate, $remark, $volume, $limitip, null, $fid);
            }
        }

        if (is_null($response)) {
            sendMessage('❌ | 🥺 گلم ، اتصال به سرور برقرار نیست لطفا مدیر رو در جریان بزار ...');
            exit;
        }
        if ($response == "inbound not Found") {
            sendMessage("❌ | 🥺 سطر (inbound) با آیدی $inbound_id تو این سرور وجود نداره ، مدیر رو در جریان بزار ...");
            exit;
        }
        if (!$response->success) {
            sendMessage("خطای سرور {$serverInfo['title']}:\n\n" . ($response->msg), null, null, $admin);
            exit;
        }

        $token = RandomString(30);
        $subLink = $botState['subLinkState'] == "on" ? $botUrl . "settings/subLink.php?token=" . $token : "";

        $vraylink = getConnectionLink($server_id, $uniqid, $protocol, $remark, $port, $netType, $inbound_id, $rahgozar, $customPath, $customPort, $customSni);
        foreach ($vraylink as $vray_link) {
            $acc_text = "
        
😍 سفارش جدید شما
📡 پروتکل: $protocol
🔮 نام سرویس: $remark
🔋حجم سرویس: $volume گیگ
⏰ مدت سرویس: $days روز⁮⁮ ⁮⁮
" . ($botState['configLinkState'] != "off" ? "
💝 config : <code>$vray_link</code>" : "");

            if ($botState['subLinkState'] == "on") $acc_text .= "

🔋 Volume web: <code> $botUrl" . "search.php?id=" . $uniqid . "</code>


🌐 subscription : <code>$subLink</code>
        
        ";

            $file = RandomString() . ".png";
            $ecc = 'L';
            $pixel_Size = 10;
            $frame_Size = 10;

            QRcode::png($vray_link, '../' . $file, $ecc, $pixel_Size, $frame_Size);
            addBorderImage('../' . $file);
            sendPhoto($botUrl . $file, $acc_text, json_encode(['inline_keyboard' => [[['text' => $buttonValues['back_to_main'], 'callback_data' => "mainMenu"]]]]), "HTML", $uid);
            unlink('../' . $file);
        }

        $vray_link = json_encode($vraylink);
        $agentBought = $payInfo['agent_bought'];

        $stmt = $connection->prepare("INSERT INTO `orders_list` 
            (`userid`, `token`, `transid`, `fileid`, `server_id`, `inbound_id`, `remark`, `uuid`, `protocol`, `expire_date`, `link`, `amount`, `status`, `date`, `notif`, `rahgozar`, `agent_bought`)
            VALUES (?, ?, '', ?, ?, ?, ?, ?, ?, ?, ?, ?,1, ?, 0, ?, ?);");
        $stmt->bind_param("ssiiisssisiiii", $uid, $token, $fid, $server_id, $inbound_id, $remark, $uniqid, $protocol, $expire_date, $vray_link, $eachPrice, $date, $rahgozar, $agentBought);
        $stmt->execute();
        $order = $stmt->get_result();
        $stmt->close();
    }

    if ($userInfo['refered_by'] != null) {
        $stmt = $connection->prepare("SELECT * FROM `setting` WHERE `type` = 'INVITE_BANNER_AMOUNT'");
        $stmt->execute();
        $inviteAmount = $stmt->get_result()->fetch_assoc()['value'] ?? 0;
        $stmt->close();
        $inviterId = $userInfo['refered_by'];

        $stmt = $connection->prepare("UPDATE `users` SET `wallet` = `wallet` + ? WHERE `userid` = ?");
        $stmt->bind_param("ii", $inviteAmount, $inviterId);
        $stmt->execute();
        $stmt->close();

        sendMessage("تبریک یکی از زیر مجموعه های شما خرید انجام داد شما مبلغ " . number_format($inviteAmount) . " تومان جایزه دریافت کردید", null, null, $inviterId);
    }
    $keys = json_encode(['inline_keyboard' => [
        [
            ['text' => "بنازم خرید جدید ❤️", 'callback_data' => "wizwizch"]
        ],
    ]]);

    if ($inbound_id == 0) {
        $stmt = $connection->prepare("UPDATE `server_info` SET `ucount` = `ucount` - ? WHERE `id`=?");
        $stmt->bind_param("ii", $accountCount, $server_id);
        $stmt->execute();
        $stmt->close();
    } else {
        $stmt = $connection->prepare("UPDATE `server_plans` SET `acount` = `acount` - ? WHERE id=?");
        $stmt->bind_param("ii", $accountCount, $fid);
        $stmt->execute();
        $stmt->close();
    }
    $msg = str_replace(['SERVERNAME', 'TYPE', 'USER-ID', 'USERNAME', 'NAME', 'PRICE', 'REMARK', 'VOLUME', 'DAYS'],
        [$serverTitle, 'ارزی ریالی', $from_id, $username, $first_name, $price, $remark, $volume, $days], $mainValues['buy_new_account_request']);

    sendMessage($msg, $keys, "html", $admin);
}
elseif ($payType == "RENEW_ACCOUNT") {
    $oid = $payInfo['plan_id'];
    $stmt = $connection->prepare("SELECT * FROM `orders_list` WHERE `id` = ?");
    $stmt->bind_param("i", $oid);
    $stmt->execute();
    $order = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    $fid = $order['fileid'];
    $remark = $order['remark'];
    $uuid = $order['uuid'] ?? "0";
    $server_id = $order['server_id'];
    $inbound_id = $order['inbound_id'];
    $expire_date = $order['expire_date'];
    $expire_date = ($expire_date > $time) ? $expire_date : $time;

    $stmt = $connection->prepare("SELECT * FROM `server_plans` WHERE `id` = ? AND `active` = 1");
    $stmt->bind_param("i", $fid);
    $stmt->execute();
    $respd = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    $name = $respd['title'];
    $days = $respd['days'];
    $volume = $respd['volume'];
    $price = $payInfo['price'];

    if ($inbound_id > 0)
        $response = editClientTraffic($server_id, $inbound_id, $uuid, $volume, $days, "renew");
    else
        $response = editInboundTraffic($server_id, $uuid, $volume, $days, "renew");

    if (is_null($response)) {
        alert('🔻مشکل فنی در اتصال به سرور. لطفا به مدیریت اطلاع بدید', true);
        exit;
    }
    $stmt = $connection->prepare("UPDATE `orders_list` SET `expire_date` = ?, `notif` = 0 WHERE `id` = ?");
    $newExpire = $time + $days * 86400;
    $stmt->bind_param("ii", $newExpire, $oid);
    $stmt->execute();
    $stmt->close();
    $stmt = $connection->prepare("INSERT INTO `increase_order` VALUES (NULL, ?, ?, ?, ?, ?, ?);");
    $stmt->bind_param("iiisii", $uid, $server_id, $inbound_id, $remark, $price, $time);
    $stmt->execute();
    $stmt->close();

    sendMessage("✅سرویس $remark با موفقیت تمدید شد", getMainKeys());
    $keys = json_encode(['inline_keyboard' => [
        [
            ['text' => "به به تمدید 😍", 'callback_data' => "wizwizch"]
        ],
    ]]);

    $msg = str_replace(['TYPE', "USER-ID", "USERNAME", "NAME", "PRICE", "REMARK", "VOLUME", "DAYS"], ['کیف پول', $from_id, $username, $first_name, $price, $remark, $volume, $days], $mainValues['renew_account_request_message']);

    sendMessage($msg, $keys, "html", $admin);
}
elseif (preg_match('/^INCREASE_DAY_(\d+)_(\d+)/', $payType, $increaseInfo)) {
    $orderId = $increaseInfo[1];

    $stmt = $connection->prepare("SELECT * FROM `orders_list` WHERE `id` = ?");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $orderInfo = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    $server_id = $orderInfo['server_id'];
    $inbound_id = $orderInfo['inbound_id'];
    $remark = $orderInfo['remark'];
    $uuid = $orderInfo['uuid'] ?? "0";

    $planid = $increaseInfo[2];


    $stmt = $connection->prepare("SELECT * FROM `increase_day` WHERE `id` = ?");
    $stmt->bind_param("i", $planid);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    $price = $payInfo['price'];
    $volume = $res['volume'];


    if ($inbound_id > 0)
        $response = editClientTraffic($server_id, $inbound_id, $uuid, 0, $volume);
    else
        $response = editInboundTraffic($server_id, $uuid, 0, $volume);

    if ($response->success) {
        $stmt = $connection->prepare("UPDATE `orders_list` SET `expire_date` = `expire_date` + ?, `notif` = 0 WHERE `uuid` = ?");
        $newVolume = $volume * 86400;
        $stmt->bind_param("is", $newVolume, $uuid);
        $stmt->execute();
        $stmt->close();

        $stmt = $connection->prepare("INSERT INTO `increase_order` VALUES (NULL, ?, ?, ?, ?, ?, ?);");
        $newVolume = $volume * 86400;
        $stmt->bind_param("iiisii", $from_id, $server_id, $inbound_id, $remark, $price, $time);
        $stmt->execute();
        $stmt->close();

        sendMessage("✅$volume روز به مدت زمان سرویس شما اضافه شد", getMainKeys());

        $keys = json_encode(['inline_keyboard' => [
            [
                ['text' => "اخیش یکی زمان زد 😁", 'callback_data' => "wizwizch"]
            ],
        ]]);
        sendMessage("
🔋|💰 افزایش زمان با ( کیف پول )

▫️آیدی کاربر: $from_id
👨‍💼اسم کاربر: $first_name
⚡️ نام کاربری: $username
🎈 نام سرویس: $remark
⏰ مدت افزایش: $volume روز
💰قیمت: $price تومان
⁮⁮ ⁮⁮
", $keys, "html", $admin);

        exit;
    } else {
        alert("به دلیل مشکل فنی امکان افزایش حجم نیست. لطفا به مدیریت اطلاع بدید یا 5دقیقه دیگر دوباره تست کنید", true);
        exit;
    }
}
elseif (preg_match('/^INCREASE_VOLUME_(\d+)_(\d+)/', $payType, $increaseInfo)) {
    $orderId = $increaseInfo[1];

    $stmt = $connection->prepare("SELECT * FROM `orders_list` WHERE `id` = ?");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $orderInfo = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    $server_id = $orderInfo['server_id'];
    $inbound_id = $orderInfo['inbound_id'];
    $remark = $orderInfo['remark'];
    $uuid = $orderInfo['uuid'] ?? "0";

    $planid = $increaseInfo[2];

    $stmt = $connection->prepare("SELECT * FROM `increase_plan` WHERE `id` = ?");
    $stmt->bind_param("i", $planid);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    $price = $payInfo['price'];
    $volume = $res['volume'];

    if ($inbound_id > 0)
        $response = editClientTraffic($server_id, $inbound_id, $uuid, $volume, 0);
    else
        $response = editInboundTraffic($server_id, $uuid, $volume, 0);

    if ($response->success) {
        $stmt = $connection->prepare("UPDATE `orders_list` SET `notif` = 0 WHERE `uuid` = ?");
        $stmt->bind_param("s", $uuid);
        $stmt->execute();
        $stmt->close();
        $keys = json_encode(['inline_keyboard' => [
            [
                ['text' => "اخیش یکی حجم زد 😁", 'callback_data' => "wizwizch"]
            ],
        ]]);
        sendMessage("
🔋|💰 افزایش حجم با ( کیف پول )

▫️آیدی کاربر: $from_id
👨‍💼اسم کاربر: $first_name
⚡️ نام کاربری: $username
🎈 نام سرویس: $remark
⏰ مدت افزایش: $volume گیگ
💰قیمت: $price تومان
⁮⁮ ⁮⁮
", $keys, "html", $admin);
        sendMessage("✅$volume گیگ به حجم سرویس شما اضافه شد", getMainKeys());
        exit;


    } else {
        alert("به دلیل مشکل فنی امکان افزایش حجم نیست. لطفا به مدیریت اطلاع بدید یا 5دقیقه دیگر دوباره تست کنید", true);
        exit;
    }
}
elseif ($payType == "RENEW_SCONFIG") {
    $uid = $from_id;
    $fid = $payInfo['plan_id'];

    $stmt = $connection->prepare("SELECT * FROM `server_plans` WHERE `id`=?");
    $stmt->bind_param("i", $fid);
    $stmt->execute();
    $file_detail = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    $volume = $file_detail['volume'];
    $days = $file_detail['days'];

    $price = $payInfo['price'];
    $server_id = $file_detail['server_id'];
    $remark = $payInfo['description'];
    $inbound_id = $payInfo['volume'];

    if ($inbound_id > 0)
        $response = editClientTraffic($server_id, $inbound_id, $uuid, $volume, $days, "renew");
    else
        $response = editInboundTraffic($server_id, $uuid, $volume, $days, "renew");

    if (is_null($response)) {
        alert('🔻مشکل فنی در اتصال به سرور. لطفا به مدیریت اطلاع بدید', true);
        exit;
    }
    $stmt = $connection->prepare("INSERT INTO `increase_order` VALUES (NULL, ?, ?, ?, ?, ?, ?);");
    $stmt->bind_param("iiisii", $uid, $server_id, $inbound_id, $remark, $price, $time);
    $stmt->execute();
    $stmt->close();

}

editKeys(json_encode(['inline_keyboard' => [
    [['text' => "پرداخت انجام شد", 'callback_data' => "wizwizch"]]
]]));

function validateGuestPay($reference)
{
    global $paymentKeys;

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://pardakhtsaz.com/api/dev/orders/guestpay',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
    "reference" : "'.$reference.'"
}',
        CURLOPT_HTTPHEADER => array(
            'Secret-Id: ' . $paymentKeys['pardakhtSazId'],
            'Secret-Key: ' . $paymentKeys['pardakhtSazKey'],
            'Content-Type: application/json'
        ),
    ));
    $response = curl_exec($curl);

    curl_close($curl);
    return json_decode($response);
}
