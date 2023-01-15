<?php

namespace backend\controllers;

use Yii;
use common\models\entity\Unit;
use common\models\entity\User;
use common\models\search\UnitSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\IntegrityException;

/**
 * UnitController implements the CRUD actions for Unit model.
 */
class UnitController extends Controller
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
                ],
            ],
        ];
    }

    /**
     * Lists all Unit models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UnitSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Unit model.
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
     * Creates a new Unit model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Unit();

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
     * Updates an existing Unit model.
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
     * Deletes an existing Unit model.
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
     * Finds the Unit model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Unit the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Unit::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionUserCreate($id)
    {
        $unit = $this->findModel($id);

        $model = new User();
        $model->unit_id = $unit->id;

        if ($post = Yii::$app->request->post()) {
            $model->load($post);
            $model->username = Yii::$app->security->generateRandomString();

            if ($post['User']['password']) {
                $model->setPassword($model->password);
                $model->generateAuthKey();
            }
            if (!$model->save()) Yii::$app->session->addFlash('error', \yii\helpers\Json::encode($model->errors));
        }  else if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_form-user', [
                'model' => $model,
            ]);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionUserUpdate($user_id)
    {
        $model = User::findOne($user_id);

        if ($post = Yii::$app->request->post()) {
            $model->load($post);
            $model->username = Yii::$app->security->generateRandomString();

            if ($post['User']['password']) {
                $model->setPassword($model->password);
                $model->generateAuthKey();
            }
            if (!$model->save()) Yii::$app->session->addFlash('error', \yii\helpers\Json::encode($model->errors));
        }  else if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_form-user', [
                'model' => $model,
            ]);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionUserDelete($user_id)
    {
        try {
            $model = User::findOne($user_id);
            $model->delete();
            return $this->redirect(['view', 'id' => $model->unit_id]);
        } catch (IntegrityException $e) {
            throw new \yii\web\HttpException(500,"Integrity Constraint Violation. This data can not be deleted due to the relation.", 405);
        }
    }
}
