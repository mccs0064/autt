<?php

class APIController extends Controller {

    public function _sendResponse($status = 200, $body = '', $content_type = 'application/json')
    {
        $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
        header($status_header);
        if (Yii::app()->user->hasState('new_token'))
        {
            header('New-Token: ' . Yii::app()->user->new_token);
        }

        if (Yii::app()->user->hasState('new_token'))
        {
            Yii::app()->user->setState('new_token',null);
        }

        header('Content-type: ' . $content_type);

        if ($body != '')
        {
            echo $body;
            exit;
        } else
        {
            $message = '';

            switch ($status) {
                case 401:
                    $message = 'You must be authorized to view this page.';
                    break;
                case 404:
                    $message = 'The requested URL ' . $_SERVER['REQUEST_URI'] . ' was not found.';
                    break;
                case 500:
                    $message = 'The server encountered an error processing your request.';
                    break;
                case 501:
                    $message = 'The requested method is not implemented.';
                    break;
            }

            $signature = ($_SERVER['SERVER_SIGNATURE'] == '') ? $_SERVER['SERVER_SOFTWARE'] . ' Server at ' . $_SERVER['SERVER_NAME'] . ' Port ' . $_SERVER['SERVER_PORT'] : $_SERVER['SERVER_SIGNATURE'];
            $body = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
                        <html>
                            <head>
                                <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
                                <title>' . $status . ' ' . $this->_getStatusCodeMessage($status) . '</title>
                            </head>
                            <body>
                                <h1>' . $this->_getStatusCodeMessage($status) . '</h1>
                                <p>' . $message . '</p>
                                <hr />
                                <address>' . $signature . '</address>
                            </body>
                        </html>';

            echo $body;
            exit;
        }
    }

    public function _getStatusCodeMessage($status)
    {

        $codes = Array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => '(Unused)',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported'
        );

        return (isset($codes[$status])) ? $codes[$status] : '';
    }

    public function _checkAuth()
    {
        $headers = $_SERVER;

        if (!isset($headers['HTTP_TOKEN']))
        {
            $this->_sendResponse(401, CJSON::encode(array("message" => "You are not authorized to perform this operation")));
        } else
        {
            $access_token = $headers['HTTP_TOKEN'];
            $driver = Driver::model()->findByAttributes(array('access_token' => $access_token));
            if ($driver)
            {
                if (Yii::app()->helper->isTokenExpired($driver->id))
                {
                    $new_token = crypt(Yii::app()->getSecurityManager()->generateRandomString(40, false)) . $driver->id;
                    $driver->access_token = $new_token;
                    $currentDate = date('Y-m-d H:i:s');
                    $driver->token_expiry = date('Y-m-d H:i:s', strtotime($currentDate . ' + 7 days'));
                    $driver->update();
                    Yii::app()->user->setState('new_token', $new_token);
                    return true;
                } else
                {
                    return true;
                }
            } else
            {
                $this->_sendResponse(401, CJSON::encode(array("message" => "You are not authorized to perform this operation")));
            }
        }
    }

    public function _getUser()
    {
        if ($this->_checkAuth())
        {
            $headers = $_SERVER;
            $user_id = Yii::app()->helper->getUserFromToken($headers['HTTP_TOKEN']);
            return $user_id;
        } else
        {
            return false;
        }
    }

    public function sendError($errorMessage,$code=400)
    {
        $this->_sendResponse($code, CJSON::encode(array("status"=>false,"error" => $errorMessage)));
    }

    public function sendData($data,$code=200)
    {
        $this->_sendResponse($code, CJSON::encode(array("status"=>true,"data" => $data)));

    }

}