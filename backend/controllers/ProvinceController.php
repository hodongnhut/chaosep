<?php

namespace backend\controllers;

use Yii;
use yii\rest\Controller;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use common\models\Province;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Response;
use yii\filters\VerbFilter;

class ProvinceController extends Controller
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
     * Danh sách tỉnh/thành phố + tìm kiếm + phân trang
     * Endpoint: GET /provinces
     * Params: ?title=... &pageSize=...
     */
    public function actionIndex()
    {
        $query = Province::find();

        $requestParams = Yii::$app->getRequest()->getQueryParams();

        // Tìm kiếm theo tên tỉnh (like)
        if (!empty($requestParams['title'])) {
            $query->andWhere(['like', 'title', $requestParams['title']]);
        }

        // Tìm kiếm theo SolrID (ví dụ: /ha-noi)
        if (!empty($requestParams['solr_id'])) {
            $query->andWhere(['solr_id' => $requestParams['solr_id']]);
        }

        // Lọc theo số doanh nghiệp (min/max nếu cần)
        if (!empty($requestParams['min_enterprises'])) {
            $query->andWhere(['>=', 'total_doanh_nghiep', (int)$requestParams['min_enterprises']]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => !empty($requestParams['pageSize']) ? (int)$requestParams['pageSize'] : 20,
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
                'message' => 'Không tìm thấy tỉnh/thành phố nào phù hợp.',
                'total' => 0,
                'page' => 1,
                'pageSize' => $pageSize,
                'totalPages' => 0,
                'items' => [],
            ];
        }

        return [
            'success' => true,
            'message' => 'Lấy danh sách tỉnh/thành phố thành công.',
            'total' => (int)$totalCount,
            'page' => (int)$currentPage,
            'pageSize' => (int)$pageSize,
            'totalPages' => (int)$totalPages,
            'items' => $models,
        ];
    }

    /**
     * Chi tiết một tỉnh/thành phố
     * Endpoint: GET /provinces/{id} hoặc /provinces/{api_id}
     * Hỗ trợ lấy theo api_id (ID từ thongtindoanhnghiep.co) hoặc id nội bộ
     */
    public function actionView($id)
    {
        // Nếu $id là số nhỏ (1-64) → coi là api_id từ API gốc
        if (is_numeric($id) && $id <= 100) {
            $model = Province::findOne(['api_id' => (int)$id]);
        } else {
            $model = $this->findModel($id);
        }

        if ($model === null) {
            throw new NotFoundHttpException('Tỉnh/Thành phố không tồn tại.');
        }

        return $model;
    }

    /**
     * Tìm model theo id nội bộ
     */
    protected function findModel($id)
    {
        if (($model = Province::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Tỉnh/Thành phố không tồn tại.');
    }
}