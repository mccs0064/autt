<?php

class Commons extends CApplicationComponent {

    const GCM_KEY = "AIzaSyC1yjcLdxFzLGCsvCSDaQLK2B4bSfbCSvE";
    const PASSPHRASE = "";
    const SANDBOX_URL = "ssl://gateway.sandbox.push.apple.com:2195";
    const PRODUCTION_URL = "ssl://gateway.push.apple.com:2195";


    public function getLocationFromCord($longitude,$latitude){
        $geolocation = $latitude.','.$longitude;
        $request = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.$geolocation.'&sensor=false';
        $file_contents = @file_get_contents($request);
        $json_decode = json_decode($file_contents);
        if(isset($json_decode->results[0])) {
            $response = array();
            foreach($json_decode->results[0]->address_components as $addressComponet) {
                if(in_array('political', $addressComponet->types)) {
                    $response[] = $addressComponet->long_name;
                }
            }

            if(isset($response[0])){ $first  =  $response[0];  } else { $first  = 'null'; }
            if(isset($response[1])){ $second =  $response[1];  } else { $second = 'null'; }
            if(isset($response[2])){ $third  =  $response[2];  } else { $third  = 'null'; }
            if(isset($response[3])){ $fourth =  $response[3];  } else { $fourth = 'null'; }
            if(isset($response[4])){ $fifth  =  $response[4];  } else { $fifth  = 'null'; }

            if( $first != 'null' && $second != 'null' && $third != 'null' && $fourth != 'null' && $fifth != 'null' ) {
                return $first.", ".$second." ".$fourth." ".$fifth;
            }
            else if ( $first != 'null' && $second != 'null' && $third != 'null' && $fourth != 'null' && $fifth == 'null'  ) {
                return $first.", ".$second." ".$third." ".$fourth;
            }
            else if ( $first != 'null' && $second != 'null' && $third != 'null' && $fourth == 'null' && $fifth == 'null' ) {
                return $first.", ".$second." ".$third;
            }
            else if ( $first != 'null' && $second != 'null' && $third == 'null' && $fourth == 'null' && $fifth == 'null'  ) {
                return $first.", ".$second;
            }
            else if ( $first != 'null' && $second == 'null' && $third == 'null' && $fourth == 'null' && $fifth == 'null'  ) {
                return $first;
            }
        }
        else
        {
            return '';
        }
    }

    public function getLongLatFromLocation($address)
    {
        $url = "http://maps.google.com/maps/api/geocode/json?address=".urlencode($address)."&sensor=false&region=India";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);

        $response_a = json_decode($response);
        if(!empty($response_a->results[0]))
        {
            $lat = $response_a->results[0]->geometry->location->lat;
            $long = $response_a->results[0]->geometry->location->lng;
        }
        else
        {
            $lat = '';
            $long = '';
        }
        return array('longitude'=>$long,'latitude'=>$lat);
    }

    public function sendPushNotifications($driver_id,$title,$message)
    {
        $this->iOSNotify($driver_id,$title,$message);
        return true;
    }

    private function iOSNotify($user_id, $title, $message, $environment = "production")
    {
        $device_token = $this->getDeviceTokens($user_id, "iOS");
        if (!empty($device_token))
        {
            $ctx = stream_context_create();

                $production_certificate = Yii::getPathOfAlias('webroot') . '/protected/cert/production/ck.pem';
                stream_context_set_option($ctx, 'ssl', 'local_cert', $production_certificate);
//                stream_context_set_option($ctx, 'ssl', 'passphrase', self::PASSPHRASE);
                $fp = stream_socket_client(self::PRODUCTION_URL, $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
            $i = 0;

//            if (!$fp)
//            {
//               echo "Failed to connect to device: {$err} {$errstr}.";
//            }
            if ($fp)
            {
                $body['aps'] = array(
                    'alert' => array(
                        'title' => $title,
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
                array_push($device_token, trim($device['device_token']));
            }
        }
        return $device_token;
    }

    public function getCountries() {
        return
            array(
                'Afghanistan' => 'Afghanistan',
                'Åland Islands' => 'Åland Islands',
                'Albania' => 'Albania',
                'Algeria' => 'Algeria',
                'American Samoa' => 'American Samoa',
                'Andorra' => 'Andorra',
                'Angola' => 'Angola',
                'Anguilla' => 'Anguilla',
                'Antigua and Barbuda' => 'Antigua and Barbuda',
                'Argentina' => 'Argentina',
                'Armenia' => 'Armenia',
                'Aruba' => 'Aruba',
                'Ascension Island' => 'Ascension Island',
                'Australia' => 'Australia',
                'Austria' => 'Austria',
                'Azerbaijan' => 'Azerbaijan',
                'Bahrain' => 'Bahrain',
                'Bangladesh' => 'Bangladesh',
                'Barbados' => 'Barbados',
                'Belarus' => 'Belarus',
                'Belgium' => 'Belgium',
                'Belize' => 'Belize',
                'Benin' => 'Benin',
                'Bermuda' => 'Bermuda',
                'Bhutan' => 'Bhutan',
                'Bolivia' => 'Bolivia',
                'Bosnia and Herzegovina' => 'Bosnia and Herzegovina',
                'Brazil' => 'Brazil',
                'British Virgin Islands' => 'British Virgin Islands',
                'Brunei' => 'Brunei',
                'Bulgaria' => 'Bulgaria',
                'Burkina Faso' => 'Burkina Faso',
                'Burundi' => 'Burundi',
                'Cambodia' => 'Cambodia',
                'Cameroon' => 'Cameroon',
                'Canada' => 'Canada',
                'Cape Verde' => 'Cape Verde',
                'Caribbean Netherlands' => 'Caribbean Netherlands',
                'Cayman Islands' => 'Cayman Islands',
                'Central African Republic' => 'Central African Republic',
                'Ceuta and Melilla' => 'Ceuta and Melilla',
                'Chad' => 'Chad',
                'Chile' => 'Chile',
                'China' => 'China',
                'Colombia' => 'Colombia',
                'Comoros' => 'Comoros',
                'Congo - Brazzaville' => 'Congo - Brazzaville',
                'Congo - Kinshasa' => 'Congo - Kinshasa',
                'Costa Rica' => 'Costa Rica',
                'Côte d’Ivoire' => 'Côte d’Ivoire',
                'Croatia' => 'Croatia',
                'Cuba' => 'Cuba',
                'Cyprus' => 'Cyprus',
                'Czech Republic' => 'Czech Republic',
                'Denmark' => 'Denmark',
                'Diego Garcia' => 'Diego Garcia',
                'Djibouti' => 'Djibouti',
                'Dominican Republic' => 'Dominican Republic',
                'Ecuador' => 'Ecuador',
                'Egypt' => 'Egypt',
                'Equatorial Guinea' => 'Equatorial Guinea',
                'El Salvador' => 'El Salvador',
                'Eritrea' => 'Eritrea',
                'Estonia' => 'Estonia',
                'Ethiopia' => 'Ethiopia',
                'Fiji' => 'Fiji',
                'Finland' => 'Finland',
                'France' => 'France',
                'Gabon' => 'Gabon',
                'Gambia' => 'Gambia',
                'Georgia' => 'Georgia',
                'Germany' => 'Germany',
                'Ghana' => 'Ghana',
                'Gibraltar' => 'Gibraltar',
                'Greece' => 'Greece',
                'Greenland' => 'Greenland',
                'Grenada' => 'Grenada',
                'Guadeloupe' => 'Guadeloupe',
                'Guatemala' => 'Guatemala',
                'Guernsey' => 'Guernsey',
                'Guinea' => 'Guinea',
                'Guyana' => 'Guyana',
                'Haiti' => 'Haiti',
                'Hong Kong SAR China' => 'Hong Kong SAR China',
                'Honduras' => 'Honduras',
                'Hungary' => 'Hungary',
                'Iceland' => 'Iceland',
                'India' => 'India',
                'Indonesia' => 'Indonesia',
                'Iran' => 'Iran',
                'Iraq' => 'Iraq',
                'Ireland' => 'Ireland',
                'Israel' => 'Israel',
                'Italy' => 'Italy',
                'Jamaica' => 'Jamaica',
                'Japan' => 'Japan',
                'Jordan' => 'Jordan',
                'Kazakhstan' => 'Kazakhstan',
                'Kenya' => 'Kenya',
                'Kiribati' => 'Kiribati',
                'KSA' => 'KSA',
                'Kosovo' => 'Kosovo',
                'Kuwait' => 'Kuwait',
                'Kyrgyzstan' => 'Kyrgyzstan',
                'Latvia' => 'Latvia',
                'Lebanon' => 'Lebanon',
                'Lesotho' => 'Lesotho',
                'Liberia' => 'Liberia',
                'Libya' => 'Libya',
                'Liechtenstein' => 'Liechtenstein',
                'Lithuania' => 'Lithuania',
                'Luxembourg' => 'Luxembourg',
                'Macedonia' => 'Macedonia',
                'Madagascar' => 'Madagascar',
                'Malawi' => 'Malawi',
                'Malaysia' => 'Malaysia',
                'Maldives' => 'Maldives',
                'Mali' => 'Mali',
                'Malta' => 'Malta',
                'Marshall Islands' => 'Marshall Islands',
                'Mauritania' => 'Mauritania',
                'Mauritius' => 'Mauritius',
                'Mayotte' => 'Mayotte',
                'Mexico' => 'Mexico',
                'Micronesia' => 'Micronesia',
                'Moldova' => 'Moldova',
                'Monaco' => 'Monaco',
                'Mongolia' => 'Mongolia',
                'Montenegro' => 'Montenegro',
                'Morocco' => 'Morocco',
                'Myanmar' => 'Myanmar',
                'Mozambique' => 'Mozambique',
                'Namibia' => 'Namibia',
                'Netherlands' => 'Netherlands',
                'Nepal' => 'Nepal',
                'New Caledonia' => 'New Caledonia',
                'New Zealand' => 'New Zealand',
                'Nicaragua' => 'Nicaragua',
                'Niger' => 'Niger',
                'Nigeria' => 'Nigeria',
                'Niue' => 'Niue',
                'Norway' => 'Norway',
                'North Korea' => 'North Korea',
                'Oman' => 'Oman',
                'Pakistan' => 'Pakistan',
                'Palau' => 'Palau',
                'Palestine' => 'Palestine',
                'Panama' => 'Panama',
                'Papua New Guinea' => 'Papua New Guinea',
                'Paraguay' => 'Paraguay',
                'Peru' => 'Peru',
                'Philippines' => 'Philippines',
                'Poland' => 'Poland',
                'Portugal' => 'Portugal',
                'Puerto Rico' => 'Puerto Rico',
                'Qatar' => 'Qatar',
                'Romania' => 'Romania',
                'Russia' => 'Russia',
                'Rwanda' => 'Rwanda',
                'Saint Barthélemy' => 'Saint Barthélemy',
                'Saint Helena' => 'Saint Helena',
                'Saint Kitts and Nevis' => 'Saint Kitts and Nevis',
                'Saint Lucia' => 'Saint Lucia',
                'Saint Pierre and Miquelon'=>'Saint Pierre and Miquelon',
                'Samoa' => 'Samoa',
                'Sao Tome and Principe' => 'Sao Tome and Principe',
                'Senegal' => 'Senegal',
                'Seychelles' => 'Seychelles',
                'Slovenia' => 'Slovenia',
                'Solomon Islands' => 'Solomon Islands',
                'Somalia' => 'Somalia',
                'South Africa' => 'South Africa',
                'Korea, South' => 'Korea, South',
                'Spain' => 'Spain',
                'Sri Lanka' => 'Sri Lanka',
                'Sudan' => 'Sudan',
                'Suriname' => 'Suriname',
                'Swaziland' => 'Swaziland',
                'Sweden' => 'Sweden',
                'Switzerland' => 'Switzerland',
                'Syria' => 'Syria',
                'Tajikistan' => 'Tajikistan',
                'Tanzania' => 'Tanzania',
                'Thailand' => 'Thailand',
                'Togo' => 'Togo',
                'Tonga' => 'Tonga',
                'Tunisia' => 'Tunisia',
                'Turkey' => 'Turkey',
                'Tuvalu' => 'Tuvalu',
                'United Arab Emirates'=>'United Arab Emirates',
                'United Kingdom' => 'United Kingdom',
                'United States' => 'United States',
                'Uganda' => 'Uganda',
                'Ukraine' => 'Ukraine',
                'Uruguay' => 'Uruguay',
                'Uzbekistan'=>'Uzbekistan',
                'Vanuatu'=>'Vanuatu',
                'Venezuela' => 'Venezuela',
                'Vietnam' => 'Vietnam',
                'Yemen' => 'Yemen',
                'Zambia' => 'Zambia',
                'Zimbabwe' => 'Zimbabwe',
            );
    }

    public function createIdInspection($id,$start)
    {
        $prepend='';
        $digits=strlen((string)$id);
        $prepend='000';
        return $start."-".$prepend.$id;
    }

    public function createId($id,$start)
    {
        $prepend='';
        $digits=strlen((string)$id);
        switch ($digits)
        {
            case 1:
                $prepend='0000000';
                break;
            case 2:
                $prepend='000000';
                break;
            case 3:
                $prepend='00000';
                break;
            case 4:
                $prepend='0000';
                break;
            case 5:
                $prepend='000';
                break;
            case 6:
                $prepend='00';
                break;
            case 7:
                $prepend='0';
                break;
            case 8:
            default:
                $prepend='';
                break;
        }
        return $start."-".$prepend.$id;

    }

    public function getResizedImage($path, $width, $height, $directory_name, $quality) {
        $filename = pathinfo($path, PATHINFO_FILENAME);
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        if(!empty($extension))
        {
            $existing_file = 'uploads/accidents_resized/' . $filename . '_' . $width . $height . '.' . $extension;
        }
        else
        {
            $existing_file = 'uploads/accidents_resized/' . $filename . '_' . $width . $height;
        }

        if (file_exists($existing_file)) {
            return Yii::app()->request->baseUrl . '/' . $existing_file;
        } else {
            if(!empty($extension))
            {
                $currentFile = $directory_name . $filename . '.' . $extension;
            }
            else
            {
                $currentFile = $directory_name . $filename;
            }

            if (file_exists($path)) {
                copy($currentFile, $existing_file);
                Yii::import('application.extensions.easyimage.*');
                $image = new EasyImage($existing_file);
                $image->resize($width, $height);
                $image->save($existing_file);
                $this->compressImage($existing_file, $existing_file, $quality);
                return Yii::app()->request->baseUrl . '/' . $existing_file;
            } else {
                return $path;
            }
        }
    }

    function compressImage($source_url, $destination_url, $quality) {
        $info = getimagesize($source_url);

        if ($info['mime'] == 'image/jpeg')
            $image = imagecreatefromjpeg($source_url);
        elseif ($info['mime'] == 'image/gif')
            $image = imagecreatefromgif($source_url);
        elseif ($info['mime'] == 'image/png')
            $image = imagecreatefrompng($source_url);

//save file
        if ($info['mime'] == 'image/jpeg') {
            imagejpeg($image, $destination_url, $quality);
        } else {
//Call some PNG compression function
            if ($quality > 90) {
                $quality = 90;
            }
            $this->compressPNG($source_url, $quality);
        }


//return destination file
        return $destination_url;
    }

    function compressPNG($path_to_png_file, $max_quality = 90) {
        if (!file_exists($path_to_png_file)) {
            throw new Exception("File does not exist: $path_to_png_file");
        }
        $min_quality = 60;
        $compressed_png_content = shell_exec("pngquant --quality=$min_quality-$max_quality - < " . escapeshellarg($path_to_png_file));

        if (!$compressed_png_content) {
            return $path_to_png_file;
//            throw new Exception("Conversion to compressed PNG failed. Is pngquant 1.8+ installed on the server?");
        }

        return $compressed_png_content;
    }
}
