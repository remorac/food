<?php

namespace backend\controllers;

use common\models\entity\Menu;
use Yii;
use common\models\entity\Order;
use common\models\search\OrderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\IntegrityException;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'set' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Order model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Order();

        if ($model->load(Yii::$app->request->post())) {
            if (!$model->save()) Yii::$app->session->addFlash('error', \yii\helpers\Json::encode($model->errors));
        } else if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_form', [
                'model' => $model
            ]);
        }
        return $this->redirect(['index']);
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if (!$model->save()) Yii::$app->session->addFlash('error', \yii\helpers\Json::encode($model->errors));
        } else if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_form', [
                'model' => $model
            ]);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        try {
            $this->findModel($id)->delete();
            return $this->redirect(['index']);
        } catch (IntegrityException $e) {
            throw new \yii\web\HttpException(500,"Integrity Constraint Violation. This data can not be deleted due to the relation.", 405);
        }
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSetOrder($schedule_id)
    {
        $model = Order::find()->where([
            'user_id' => Yii::$app->user->id,
            'schedule_id' => $schedule_id,
        ])->one();
        if (!$model) {
            $model = new Order();
        }
        $model->user_id = Yii::$app->user->id;
        $model->schedule_id = $schedule_id;
        $model->review_status = Order::REVIEW_STATUS_WAITING;
        $model->reviewed_at = null;
        $model->reviewed_by = null;
        
        if ($model->load(Yii::$app->request->post())) {
            if (Menu::isAvailable($model->menu_id, $model->schedule->date, $model->schedule->shift_id, $model->schedule_id)) {
                if (!$model->save()) Yii::$app->session->addFlash('error', \yii\helpers\Json::encode($model->errors));
            } else {
                Yii::$app->session->addFlash('error', '<b>'.$model->menu->name.'</b> sudah tidak tersedia.');
            }
        } else if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_form', [
                'model' => $model
            ]);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionSet($schedule_id, $menu_id)
    {
        if (!Yii::$app->request->post('location_id')) {
            Yii::$app->session->addFlash('error', 'Gagal menyimpan pemesanan. <br><b>Lokasi Pengantaran</b> harus diisi.');
            return $this->redirect(['index']);
        }

        $model = Order::find()->where([
            'user_id' => Yii::$app->user->id,
            'schedule_id' => $schedule_id,
        ])->one();
        if (!$model) {
            $model = new Order();
        }

        if ($model->menu_id != $menu_id) {
            $model->user_id = Yii::$app->user->id;
            $model->schedule_id = $schedule_id;
            $model->menu_id = $menu_id;
            $model->location_id = Yii::$app->request->post('location_id');
            $model->review_status = Order::REVIEW_STATUS_WAITING;
            $model->reviewed_at = null;
            $model->reviewed_by = null;
            
            if (Menu::isAvailable($model->menu_id, $model->schedule->date, $model->schedule->shift_id, $model->schedule_id)) {
                if (!$model->save()) Yii::$app->session->addFlash('error', \yii\helpers\Json::encode($model->errors));
            } else {
                Yii::$app->session->addFlash('error', '<b>'.$model->menu->name.'</b> sudah tidak tersedia.');
            }
        }
        
        return $this->redirect(['index']);
    }
}
