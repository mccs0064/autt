<?php

class PushController extends Controller  {

    const GCM_KEY = "AIzaSyC1yjcLdxFzLGCsvCSDaQLK2B4bSfbCSvE";
    const PASSPHRASE = "";
    const SANDBOX_URL = "ssl://gateway.sandbox.push.apple.com:2195";
    const PRODUCTION_URL = "ssl://gateway.push.apple.com:2195";

    public function __construct()
    {
        parent::__construct($this->id);
    }

    public function actionIndex()
    {
        $environment ="production";
        $dT=Yii::app()->request->getPost('token', null);
        $tokens=array();
        array_push($tokens,trim($dT));

        $message=Yii::app()->request->getPost('message',"This is default text notification as no text was specified while calling the service");
        if (!empty($tokens))
        {
            try{

                $ctx = stream_context_create();
                if ($environment == "sandbox")
                {

                    $dev_certificate = Yii::getPathOfAlias('webroot') . '/protected/cert/development/ck.pem';
                    stream_context_set_option($ctx, 'ssl', 'local_cert', $dev_certificate);
//                    stream_context_set_option($ctx, 'ssl', 'passphrase', self::PASSPHRASE);
                    $fp = stream_socket_client(self::SANDBOX_URL, $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
                } else
                {

                    $production_certificate = Yii::getPathOfAlias('webroot') . '/protected/cert/production/ck.pem';
                    stream_context_set_option($ctx, 'ssl', 'local_cert', $production_certificate);
//                    stream_context_set_option($ctx, 'ssl', 'passphrase', self::PASSPHRASE);
                    $fp = stream_socket_client(self::PRODUCTION_URL, $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
                }
                $i = 0;

//            if (!$fp)
//            {
//               echo "Failed to connect to device: {$err} {$errstr}.";
//            }
                if ($fp)
                {
                    $body['aps'] = array(
                        'alert' => array(
                            'title' => trim($message),
                            'body' => trim($message)
                        ),
                        'sound' => 'default'
                    );

                    foreach ($tokens as $token)
                    {
                        $payload = json_encode($body);
                        $msg = chr(0) . pack('n', 32) . pack('H*', $token) . pack('n', strlen($payload)) . $payload;
                        fwrite($fp, $msg, strlen($msg));
                        $i++;
                    }
                    fclose($fp);
                }
            echo "Number of notifications sent: " . $i;
            }
            catch (Exception $exception)
            {
                echo $exception->getMessage();
            }

        }
    }



}
