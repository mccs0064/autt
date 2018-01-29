<?php

class Helper extends CApplicationComponent {

    const GCM_KEY = "AIzaSyC1yjcLdxFzLGCsvCSDaQLK2B4bSfbCSvE";
    const PASSPHRASE = "Testing.com2$";
    const SANDBOX_URL = "ssl://gateway.sandbox.push.apple.com:2195";
    const PRODUCTION_URL = "ssl://gateway.push.apple.com:2195";

    public function getAccessToken($email)
    {
        $driver = Driver::model()->findByAttributes(array('autium_id' => $email));
        if (!$driver->access_token)
        {
            return $this->updateToken($driver->id);
        } else
        {
            if ($this->isTokenExpired($driver->id))
            {
                return $this->updateToken($driver->id);
            } else
            {
                return $driver->access_token;
            }
        }
    }

    public function updateToken($user_id)
    {
        $driver = Driver::model()->findByPk($user_id);
        $token = Yii::app()->getSecurityManager()->generateRandomString(75, false) . $user_id;
        $driver->access_token = $token;
        $currentDate = date('Y-m-d H:i:s');
        $driver->token_expiry = date('Y-m-d H:i:s', strtotime($currentDate . ' + 7 Years'));
        $driver->update();
        return $token;
    }


    public function isTokenExpired($user_id)
    {
        $driver = Driver::model()->findByPk($user_id);
        $today = date("Y-m-d");
        $expire = $driver->token_expiry;

        $today_time = strtotime($today);
        $expire_time = strtotime($expire);
        return $expire_time < $today_time;
    }

    public function getUserFromToken($token)
    {
        $user = Driver::model()->findByAttributes(array('access_token' => $token));
        if (!empty($user))
        {
            return $user->id;
        } else
        {
            return false;
        }
    }

    public function getModelErrors($modelErrors)
    {
        $validation_errors = array();
        foreach ($modelErrors as $error)
        {
            foreach ($error as $message)
            {
                array_push($validation_errors,$message);
            }
        }
        return $validation_errors[0];
    }


    public function getFileType($file)
    {
        //jpg,jpeg,gif,png,mp3,wav,wmv,avi,mov,mp4,flv,pdf,doc, docx, xls, xlsx, ppt, pptx, txt, rtf, odt
        $file_detail = explode(".", $file);
        $extension = end($file_detail);
        switch ($extension) {
            case 'jpg':
            case 'jpeg':
            case 'gif':
            case 'png':
                $type = "Image";
                break;
            case 'mp3':
            case 'wav':
                $type = "Audio";
                break;
            case 'wmv':
            case 'avi':
            case 'mov':
            case 'mp4':
            case 'flv':
                $type = "Video";
                break;
            case 'doc':
            case 'pdf':
            case 'docx':
            case 'xls':
            case 'xlsx':
            case 'ppt':
            case 'pptx':
            case 'txt':
            case 'rtf':
            case 'odt':
                $type = "Document";
                break;
            default :
                $type = "Other";
                break;
        }
        return $type;
    }


    public function pushNotify($user_id, $message)
    {
        $this->iOSNotify($user_id, $message);
    }


    private function iOSNotify($user_id, $message, $environment = "production")
    {
        $device_token = $this->getDeviceTokens($user_id, "iOS");
        if (!empty($device_token))
        {
            $ctx = stream_context_create();
            if ($environment == "sandbox")
            {
                $dev_certificate = Yii::getPathOfAlias('webroot') . '/protected/cert/development/ck.pem';
                stream_context_set_option($ctx, 'ssl', 'local_cert', $dev_certificate);
                stream_context_set_option($ctx, 'ssl', 'passphrase', self::PASSPHRASE);
                $fp = stream_socket_client(self::SANDBOX_URL, $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
            } else
            {
                $production_certificate = Yii::getPathOfAlias('webroot') . '/protected/cert/production/ck.pem';
                stream_context_set_option($ctx, 'ssl', 'local_cert', $production_certificate);
                stream_context_set_option($ctx, 'ssl', 'passphrase', self::PASSPHRASE);
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
                        'title' => $message,
                        'body' => $message,
                    ),
                    'sound' => 'default'
                );

                foreach ($device_token as $token)
                {
                    $payload = json_encode($body);
                    $msg = chr(0) . pack('n', 32) . pack('H*', $token) . pack('n', strlen($payload)) . $payload;
                    fwrite($fp, $msg, strlen($msg));
                    $i++;
                }
                fclose($fp);
            }
//            echo "Number of notifications sent: " . $i;
        }
    }

    private function getDeviceTokens($user_id, $device_type)
    {
        $user_devices = UserDevice::model()->findAllByAttributes(array('user_id' => $user_id, 'device_type' => $device_type));
        $device_token = array();
        if (!empty($user_devices))
        {
            foreach ($user_devices as $device)
            {
                array_push($device_token, $device['device_token']);
            }
        }
        return $device_token;
    }

    public function decodePassword($password)
    {
        $plain_password = base64_decode($password);
        return $plain_password;
    }


    function cryptString($string)
    {
        $key = Yii::app()->params['encryptionKey'];
        $iv = mcrypt_create_iv(
                mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC), MCRYPT_DEV_URANDOM
        );
        $encrypted = base64_encode(
                $iv .
                mcrypt_encrypt(
                        MCRYPT_RIJNDAEL_128, hash('sha256', $key, true), $string, MCRYPT_MODE_CBC, $iv
                )
        );
        return $encrypted;
    }

    function decryptString($encrypted)
    {
        $key = Yii::app()->params['encryptionKey'];
        $data = base64_decode($encrypted);
        $iv = substr($data, 0, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC));

        $decrypted = rtrim(
                mcrypt_decrypt(
                        MCRYPT_RIJNDAEL_128, hash('sha256', $key, true), substr($data, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC)), MCRYPT_MODE_CBC, $iv
                ), "\0"
        );
        return $decrypted;
    }

    function limitWords($string, $word_limit)
    {
        $words = explode(" ", $string);
        return implode(" ", array_splice($words, 0, $word_limit));
    }

    public function unsetKeys($obj,$keys)
    {
        if(!empty($keys))
        {
            foreach($keys as $key)
            {
                unset($obj[$key]);
            }
        }
        return $obj;
    }
    public function getDriverDetails($user_id)
    {
        $driver = Driver::model()->findbyPk($user_id);
        $driver_data=array();
        if (!empty($driver))
        {
            $driver_data['id'] = $driver->id;
            $driver_data['autium_id'] = $driver->autium_id;
            $driver_data['full_name'] = $driver->full_name;
            $driver_data['access_token'] = $driver->access_token;
            $driver_data['token_expiry'] = $driver->token_expiry;
            $driver_data['full_name']=$driver->full_name;
            $driver_data['policy_number']=$driver->policy_number;
            $driver_data['insurer']=$driver->insurer;
            $driver_data['driving_license']=$driver->driving_license;
            $driver_data['dob']=$driver->dob;
            $driver_data['vehicles']=$this->getDriverVehicles($driver->id);
            $driver_data['address']=$driver->address;
            $driver_data['status']=$driver->status;
        }
        return $driver_data;
    }
    private function getDriverVehicles($driver_id)
    {
        $vehiclesDrivers=VehicleDriver::model()->findAllByAttributes(array('driver_id'=>$driver_id));
        $response=array();
        if(!empty($vehiclesDrivers))
        {
            foreach($vehiclesDrivers as $vh)
            {
                $response[]=self::getVehicleDetailsData($vh['vehicle_id']);
            }
        }
        return $response;
    }

    public function getVehicleDetailsData($vehicle_id)
    {
        $vehicle=Vehicle::model()->findByPk($vehicle_id);
        $v=array();
        $v['id']=$vehicle['id'];
        $v['vehicle_reg']=$vehicle['vehicle_reg'];
        $v['make']=$vehicle['make'];
        $v['model']=$vehicle['model'];
        $v['vehicle_type']=$vehicle['vehicle_type'];
        $v['inspection_template']=self::getInspectionTemplateDetails($vehicle['inspection_template_id']);
        return $v;
    }

    public function getInspectionTemplateDetails($template_id)
    {
        $inspection=InspectionTemplate::model()->findByPk($template_id);
        $response=array();
        if(!empty($inspection))
        {
            $response['id']=$inspection->id;
            $response['template_name']=$inspection->template_name;
            $response['created_at']=$inspection->created_at;
            $response['defect_items']=self::getTemplateDefects($inspection->id);
        }
        return $response;
    }

    public function getTemplateDefects($template_id)
    {
        $defects=InspectionTemplateItems::model()->findAllByAttributes(array('template_id'=>$template_id,'visible'=>'1'));
        $response=array();
        if(!empty($defects))
        {
            foreach($defects as $item)
            {
                $dfItem=array();
                $dfItem['id']=$item['id'];
                $dfItem['name']=$item['name'];
                $response[]=$dfItem;
            }
        }
        return $response;
    }

    public function getVehicleTypeById($vehicle_reg)
    {
        $vehicle=Vehicle::model()->findByAttributes(array('vehicle_reg'=>$vehicle_reg));
        if(!empty($vehicle))
        {
            return $vehicle->vehicle_type;
        }
        return null;
    }
    public function getAccidentDetails($id)
    {
        $accident=Accident::model()->findByPk($id);
        $response=array();
        $myVehicleImages=array();
        $otherVehicleImages=array();
        $audios=array();
        $police_record=array();
        $eyewitness=array();
        $otherVehicles=array();
        if(!empty($accident))
        {
            $response['id']=$accident['id'];
            $response['longitude']=$accident['longitude'];
            $response['latitude']=$accident['latitude'];
            $response['location']=$accident['location'];
            $response['make']=$accident['make'];
            $response['model']=$accident['model'];
            $response['weather_condition']=$accident['weather_condition'];
            $response['vehicle_reg']=$accident['vehicle_reg'];
            $response['vehicle_type']=self::getVehicleTypeById($accident['vehicle_reg']);
            $response['occured_at']=$accident['occured_at'];
            $response['driver']=Yii::app()->helper->getDriverDetails($accident['driver_id']);
        }
        $accidentMedia=$accident->accidentMedias;
        if(!empty($accidentMedia))
        {
            foreach($accidentMedia as $media)
            {
                $mediaItem=array();
                $mediaItem['id']=$media['id'];
                $mediaItem['path']=Yii::app()->request->getBaseUrl(true) . "/uploads/" . $media['directory_name'] . "/" . rawurlencode($media['filename']);
                if($media['media_type']=='Image')
                {
                    if($media['image_type']=='Self')
                    {
                        array_push($myVehicleImages,$mediaItem);
                    }
                    else
                    {
                        array_push($otherVehicleImages,$mediaItem);
                    }

                }
                else
                {
                    array_push($audios,$mediaItem);
                }
            }
        }
        $policeRecords=$accident->accidentPolices;
        if(!empty($policeRecords))
        {
            foreach($policeRecords as $police)
            {
                $policeRecord=array();
                $policeRecord['id']=$police['id'];
                $policeRecord['officer_name']=$police['officer_name'];
                $policeRecord['police_station']=$police['police_station'];
                $policeRecord['phone_number']=$police['phone_number'];
                $policeRecord['batch_number']=$police['batch_number'];
                array_push($police_record,$policeRecord);
            }
        }
        $involvedVehicles=$accident->involvedVehicles;
        if(!empty($involvedVehicles))
        {
            foreach($involvedVehicles as $vehicle)
            {
                $vehicle_obj=array();
                $vehicle_obj['id']=$vehicle['id'];
                $vehicle_obj['vehicle_reg']=$vehicle['vehicle_reg'];
                $vehicle_obj['number_of_pessengers']=$vehicle['number_of_pessengers'];
                $vehicle_obj['driver_name']=$vehicle['driver_name'];
                $vehicle_obj['insurer']=$vehicle['insurer'];
                $vehicle_obj['phone_number']=$vehicle['phone_number'];
                $vehicle_obj['address']=$vehicle['address'];
                array_push($otherVehicles,$vehicle_obj);
            }
        }
        $otherDriver=AccidentDriver::model()->findByAttributes(array('accident_id'=>$accident->id));
        $otherDriverDetails=array();
        if(!empty($otherDriver))
        {
            $otherDriverDetails['id']=$otherDriver['id'];
            $otherDriverDetails['driver_name']=$otherDriver['driver_name'];
            $otherDriverDetails['address']=$otherDriver['address'];
            $otherDriverDetails['phone_number']=$otherDriver['phone_number'];
            $otherDriverDetails['insurer']=$otherDriver['insurer'];
            $otherDriverDetails['reg']=$otherDriver['reg'];
            $otherDriverDetails['accident_id']=$otherDriver['accident_id'];
        }
        $response['driver_vehicle_images']=$myVehicleImages;
        $response['other_vehicle_images']=$otherVehicleImages;
        $response['other_driver']=$otherDriverDetails;
        $response['audio_recordings']=$audios;
        $response['police_involvement']=$police_record;
        $response['involved_vehicles']=$otherVehicles;
        return $response;
    }

    public function getVehicleDetails($vehicle_id,$reg=null)
    {
        $response=array();
        if(empty($reg)&&!empty($vehicle_id))
        {
            $vehicle=Vehicle::model()->findByPk($vehicle_id);
            if(!empty($vehicle))
            {
                $response['id']=$vehicle['id'];
                $response['make']=$vehicle['make'];
                $response['model']=$vehicle['model'];
                $response['vehicle_reg']=$vehicle['vehicle_reg'];
                $response['vehicle_type']=$vehicle['vehicle_type'];
            }
        }
        else{
            $response['id']=null;
            $response['make']=null;
            $response['model']=null;
            $response['vehicle_reg']=$reg;
            $response['vehicle_type']=null;
        }
        return $response;
    }
}
