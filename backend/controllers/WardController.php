<?php

namespace backend\controllers;

use Yii;
use yii\rest\Controller;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use common\models\Ward;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Response;
use yii\filters\VerbFilter;

class WardController extends Controller
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
                'index' => ['GET', 'HEAD'],
                'view'  => ['GET', 'HEAD'],
            ],
        ];

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];

        return $behaviors;
    }

    /**
     * Danh sách phường/xã + tìm kiếm + phân trang
     * Endpoint: GET /wards
     * Params: ?district_id=135 &province_id=3 &title=... &pageSize=...
     */
    public function actionIndex()
    {
        $query = Ward::find();

        $requestParams = Yii::$app->getRequest()->getQueryParams();

        // Lọc theo quận/huyện (phổ biến nhất khi load dropdown cấp 3)
        if (!empty($requestParams['district_id'])) {
            $query->andWhere(['district_id' => (int)$requestParams['district_id']]);
        }

        // Lọc theo tỉnh (nếu cần)
        if (!empty($requestParams['province_id'])) {
            $query->andWhere(['province_id' => (int)$requestParams['province_id']]);
        }

        // Tìm kiếm theo tên phường/xã
        if (!empty($requestParams['title'])) {
            $query->andWhere(['like', 'title', $requestParams['title']]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => !empty($requestParams['pageSize']) ? (int)$requestParams['pageSize'] : 100,
            ],
            'sort' => [
                'defaultOrder' => ['title' => SORT_ASC],
            ],
        ]);

        $models = $dataProvider->getModels();
        $totalCount = $dataProvider->getTotalCount();
        $pagination = $dataProvider->getPagination();

        $currentPage = $pagination->getPage() + 1;
        $pageSize = $pagination->getPageSize();
        $totalPages = $totalCount > 0 ? ceil($totalCount / $pageSize) : 0;

        if ($totalCount == 0) {
            return [
                'success' => true,
                'message' => 'Không tìm thấy phường/xã nào phù hợp.',
                'total' => 0,
                'page' => 1,
                'pageSize' => $pageSize,
                'totalPages' => 0,
                'items' => [],
            ];
        }

        return [
            'success' => true,
            'message' => 'Lấy danh sách phường/xã thành công.',
            'total' => (int)$totalCount,
            'page' => (int)$currentPage,
            'pageSize' => (int)$pageSize,
            'totalPages' => (int)$totalPages,
            'items' => $models,
        ];
    }

    /**
     * Chi tiết một phường/xã
     * Endpoint: GET /wards/{id} hoặc /wards/{api_id}
     */
    public function actionView($id)
    {
        if (is_numeric($id) && $id <= 20000) {
            $model = Ward::findOne(['api_id' => (int)$id]);
        } else {
            $model = $this->findModel($id);
        }

        if ($model === null) {
            throw new NotFoundHttpException('Phường/Xã không tồn tại.');
        }

        return $model;
    }

    protected function findModel($id)
    {
        if (($model = Ward::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Phường/Xã không tồn tại.');
    }
}