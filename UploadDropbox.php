<?php

class UploadDropbox
{
    const ACCESS_TOKEN = 'XXXXXXXXXXXXXXXXXXXXXX'; // 運用時にはここにDropboxのアクセストークンを入力する
    public function handle($filePath, $folder = '225tshirts')
    {
        $url = "https://content.dropboxapi.com/2/files/upload";

        $ch = curl_init();

        $basename = basename($filePath);
        $headers = array(
            'Authorization: Bearer ' . self::ACCESS_TOKEN, //取得したアクセストークン
            'Content-Type: application/octet-stream',
            'Dropbox-API-Arg: {"path":"/' . $folder . '/' . $basename . '", "mode":{".tag":"overwrite"}}', //上書きモード
        );

        $fp = fopen($filePath, "rb");
        $size = filesize($filePath);

        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => fread($fp, $size),
            CURLOPT_RETURNTRANSFER => true,
        );

        curl_setopt_array($ch, $options);

        $res = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (!curl_errno($ch) && $http_code == "200") {
            print_r("SUCCESS: File Uploaded." . PHP_EOL);
        } else {
            print_r("ERROR: Failed to access DropBox via API" . PHP_EOL);
            print_r(curl_error($ch) . PHP_EOL);
            var_dump($res);
        }

        fclose($fp);
        curl_close($ch);
    }
}
