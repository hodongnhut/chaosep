<?php

namespace backend\controllers;  // Hoặc api\modules\v1\controllers nếu dùng module

use Yii;
use yii\rest\Controller;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Response;
use common\models\LoginForm;
use yii\filters\Cors;

class SiteController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['contentNegotiator'] = [
            'class' => \yii\filters\ContentNegotiator::class,
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];


        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'except' => ['login', 'index'],
        ];

        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['*'], 
                'Access-Control-Request-Method' => ['POST', 'GET', 'OPTIONS', 'PUT', 'PATCH', 'DELETE'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => true,
                'Access-Control-Max-Age' => 3600,
            ],
        ];

        return $behaviors;
    }

    /**
     * Homepage API - ví dụ trả info dashboard nếu logged in
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return ['message' => 'Welcome to API', 'logged_in' => false];
        }

        return [
            'message' => 'Dashboard',
            'user' => Yii::$app->user->identity->username,
        ];
    }

    /**
     * Login API: POST {username, password} → trả access_token
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->bodyParams, '') && $model->login()) {
  
            $user = Yii::$app->user->identity;
    
            $token = $user->generateAccessToken(30);
    
            return [
                'success' => true,
                'message' => 'Login successful!',
                'access_token' => $token,
                'expires_at' => $user->access_token_expire,
                'expires_in' => $user->access_token_expire - time(), // seconds
                'user' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                ],
            ];
        }
        Yii::$app->response->statusCode = 401;
        return [
            'success' => false,
            'message' => 'Invalid username/email or password',
            'errors' => $model->errors,
        ];
    }

    /**
     * Logout API: Xóa token
     */
    public function actionLogout()
    {
        $user = Yii::$app->user->identity;
        if ($user) {
            $user->access_token = null;
            $user->access_token_expire = null;  // Xóa luôn expire cho sạch
            $user->save(false);
        }

        // Optional: logout session (dù đã tắt session nhưng không sao)
        Yii::$app->user->logout();

        return [
            'success' => true,
            'message' => 'Logout successful! Token has been revoked.'
        ];
    }
}