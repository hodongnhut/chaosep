<?php

namespace backend\controllers;

use Yii;
use yii\rest\Controller;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use common\models\Industry;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Response;
use yii\filters\VerbFilter;

class IndustryController extends Controller
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
     * Danh sách ngành nghề + tìm kiếm + phân trang
     * Endpoint: GET /industries
     * Params: 
     *   ?title=... 
     *   ?lv1=A (mã cấp 1)
     *   ?lv2=01 
     *   ?lv4=0111
     *   ?min_enterprises=10000 (lọc ngành có ít nhất N doanh nghiệp)
     *   ?pageSize=50
     */
    public function actionIndex()
    {
        $query = Industry::find();

        $requestParams = Yii::$app->getRequest()->getQueryParams();

        // Tìm kiếm theo tên ngành (like)
        if (!empty($requestParams['title'])) {
            $query->andWhere(['like', 'title', $requestParams['title']]);
        }

        // Lọc theo mã cấp 1 (ví dụ: A - Nông nghiệp)
        if (!empty($requestParams['lv1'])) {
            $query->andWhere(['lv1' => strtoupper($requestParams['lv1'])]);
        }

        // Lọc theo mã cấp 2
        if (!empty($requestParams['lv2'])) {
            $query->andWhere(['lv2' => $requestParams['lv2']]);
        }

        // Lọc theo mã cấp 3
        if (!empty($requestParams['lv3'])) {
            $query->andWhere(['lv3' => $requestParams['lv3']]);
        }

        // Lọc theo mã cấp 4 (rất hay dùng)
        if (!empty($requestParams['lv4'])) {
            $query->andWhere(['lv4' => $requestParams['lv4']]);
        }

        // Lọc theo mã cấp 5 (chi tiết nhất)
        if (!empty($requestParams['lv5'])) {
            $query->andWhere(['lv5' => $requestParams['lv5']]);
        }

        // Lọc ngành có số doanh nghiệp tối thiểu (tìm ngành hot cho campaign B2B)
        if (!empty($requestParams['min_enterprises'])) {
            $query->andWhere(['>=', 'total_doanh_nghiep', (int)$requestParams['min_enterprises']]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => !empty($requestParams['pageSize']) ? (int)$requestParams['pageSize'] : 50,
            ],
            'sort' => [
                'defaultOrder' => ['total_doanh_nghiep' => SORT_DESC, 'title' => SORT_ASC],
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
                'message' => 'Không tìm thấy ngành nghề nào phù hợp.',
                'total' => 0,
                'page' => 1,
                'pageSize' => $pageSize,
                'totalPages' => 0,
                'items' => [],
            ];
        }

        return [
            'success' => true,
            'message' => 'Lấy danh sách ngành nghề thành công.',
            'total' => (int)$totalCount,
            'page' => (int)$currentPage,
            'pageSize' => (int)$pageSize,
            'totalPages' => (int)$totalPages,
            'items' => $models,
        ];
    }

    /**
     * Chi tiết một ngành nghề
     * Endpoint: GET /industries/{id} hoặc /industries/{api_id}
     */
    public function actionView($id)
    {
        if (is_numeric($id) && $id <= 2000) { // api_id ngành thường nhỏ
            $model = Industry::findOne(['api_id' => (int)$id]);
        } else {
            $model = $this->findModel($id);
        }

        if ($model === null) {
            throw new NotFoundHttpException('Ngành nghề không tồn tại.');
        }

        return $model;
    }

    protected function findModel($id)
    {
        if (($model = Industry::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Ngành nghề không tồn tại.');
    }
}