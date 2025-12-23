<?php

namespace backend\controllers;

use Yii;
use yii\rest\Controller;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use common\models\District;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Response;
use yii\filters\VerbFilter;

class DistrictController extends Controller
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
     * Danh sách quận/huyện + tìm kiếm + phân trang
     * Endpoint: GET /districts
     * Params: ?province_id=3 &title=... &pageSize=...
     */
    public function actionIndex()
    {
        $query = District::find();

        $requestParams = Yii::$app->getRequest()->getQueryParams();

        // Lọc theo tỉnh (rất hay dùng khi load dropdown phân cấp)
        if (!empty($requestParams['province_id'])) {
            $query->andWhere(['province_id' => (int)$requestParams['province_id']]);
        }

        // Tìm kiếm theo tên quận/huyện
        if (!empty($requestParams['title'])) {
            $query->andWhere(['like', 'title', $requestParams['title']]);
        }

        // Tìm kiếm theo tên tỉnh (nếu cần)
        if (!empty($requestParams['province_title'])) {
            $query->andWhere(['like', 'province_title', $requestParams['province_title']]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => !empty($requestParams['pageSize']) ? (int)$requestParams['pageSize'] : 50,
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
                'message' => 'Không tìm thấy quận/huyện nào phù hợp.',
                'total' => 0,
                'page' => 1,
                'pageSize' => $pageSize,
                'totalPages' => 0,
                'items' => [],
            ];
        }

        return [
            'success' => true,
            'message' => 'Lấy danh sách quận/huyện thành công.',
            'total' => (int)$totalCount,
            'page' => (int)$currentPage,
            'pageSize' => (int)$pageSize,
            'totalPages' => (int)$totalPages,
            'items' => $models,
        ];
    }

    /**
     * Chi tiết một quận/huyện
     * Endpoint: GET /districts/{id} hoặc /districts/{api_id}
     */
    public function actionView($id)
    {
        if (is_numeric($id) && $id <= 10000) { // api_id thường nhỏ hơn nhiều so với id nội bộ
            $model = District::findOne(['api_id' => (int)$id]);
        } else {
            $model = $this->findModel($id);
        }

        if ($model === null) {
            throw new NotFoundHttpException('Quận/Huyện không tồn tại.');
        }

        return $model;
    }

    protected function findModel($id)
    {
        if (($model = District::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Quận/Huyện không tồn tại.');
    }
}