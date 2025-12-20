<?php

namespace backend\controllers;

use Yii;
use yii\rest\Controller;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use common\models\Company;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Response;
use yii\filters\VerbFilter;

class CompanyController extends Controller
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

        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'index'  => ['GET', 'HEAD'],
                'view'   => ['GET', 'HEAD'],
                'create' => ['POST'],
                'update' => ['PUT', 'PATCH'],
                'delete' => ['DELETE'],
            ],
        ];

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];

        return $behaviors;
    }


    /**
     * Danh sách + tìm kiếm với response format chuẩn
     * Yêu cầu auth (theo cấu hình hiện tại của Sếp)
     */

    public function actionIndex()
    {
        $query = Company::find()->where(['is_active' => 1]);

        $requestParams = Yii::$app->getRequest()->getQueryParams();

        // Các filter tìm kiếm
        if (!empty($requestParams['tax_code'])) {
            $query->andWhere(['tax_code' => $requestParams['tax_code']]);
        }

        if (!empty($requestParams['company_name'])) {
            $query->andWhere(['like', 'company_name', $requestParams['company_name']]);
        }

        if (!empty($requestParams['phone'])) {
            $query->andWhere(['like', 'phone', $requestParams['phone']]);
        }

        if (!empty($requestParams['email'])) {
            $query->andWhere(['like', 'email', $requestParams['email']]);
        }

        if (!empty($requestParams['province'])) {
            $query->andWhere(['like', 'province', $requestParams['province']]);
        }

        if (!empty($requestParams['industry'])) {
            $query->andWhere(['like', 'industry', $requestParams['industry']]);
        }


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => !empty($requestParams['pageSize']) ? (int)$requestParams['pageSize'] : 20,
            ],
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
            ],
        ]);


        $models = $dataProvider->getModels();
        $totalCount = $dataProvider->getTotalCount();
        $pagination = $dataProvider->getPagination();

        $currentPage = $pagination->getPage() + 1; 
        $pageSize = $pagination->getPageSize();
        $totalPages = ceil($totalCount / $pageSize);


        if ($totalCount == 0) {
            return [
                'success' => true,
                'message' => 'Không tìm thấy doanh nghiệp nào phù hợp.',
                'total' => 0,
                'page' => 1,
                'pageSize' => $pageSize,
                'totalPages' => 0,
                'items' => [],
            ];
        }

        return [
            'success' => true,
            'message' => 'Lấy danh sách doanh nghiệp thành công.',
            'total' => (int)$totalCount,
            'page' => (int)$currentPage,
            'pageSize' => (int)$pageSize,
            'totalPages' => (int)$totalPages,
            'items' => $models,
        ];
    }

    /**
     * Override actionView để hỗ trợ tìm theo tax_code hoặc id
     */
    public function actionView($id)
    {
        // Nếu $id có dạng 10-14 ký tự và chỉ chứa số + dấu gạch → coi là tax_code
        if (preg_match('/^\d{10}(\-\d{3})?$/', $id)) {
            $model = Company::findOne(['tax_code' => $id, 'is_active' => 1]);
        } else {
            $model = $this->findModel($id);
        }

        if ($model === null) {
            throw new NotFoundHttpException('Doanh nghiệp không tồn tại hoặc đã ngừng hoạt động.');
        }

        return $model;
    }

    /**
     * Tìm model theo id (dùng cho update, delete)
     */
    protected function findModel($id)
    {
        if (($model = Company::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Doanh nghiệp không tồn tại.');
    }

    /**
     * Optional: Tạo mới với validation rõ ràng
     */
    public function actionCreate()
    {
        $model = new Company();

        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->save()) {
            Yii::$app->getResponse()->setStatusCode(201);
            return $model;
        }

        // Trả về lỗi validation chi tiết
        Yii::$app->getResponse()->setStatusCode(422);
        return ['errors' => $model->getErrors()];
    }

    /**
     * Optional: Update tương tự
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->save()) {
            return $model;
        }

        Yii::$app->getResponse()->setStatusCode(422);
        return ['errors' => $model->getErrors()];
    }
}