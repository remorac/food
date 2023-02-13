<?php

namespace backend\controllers;

use Yii;
use common\models\entity\Menu;
use common\models\entity\MenuAvailability;
use common\models\entity\Shift;
use common\models\search\MenuSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\IntegrityException;
use yii\web\UploadedFile;

/**
 * MenuController implements the CRUD actions for Menu model.
 */
class MenuController extends Controller
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
     * Lists all Menu models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MenuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Menu model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id); 

        if ($post = Yii::$app->request->post()) {
            $day_of_weeks = range(0, 6);
            $shifts = Shift::find()->all();

            foreach ($day_of_weeks as $day_of_week) {
                foreach ($shifts as $shift) {
                    if (isset($post[$day_of_week.'-'.$shift->id])) {
                        $menuAvailability = MenuAvailability::find()->where([
                            'menu_id'     => $model->id,
                            'day_of_week' => $day_of_week,
                            'shift_id'    => $shift->id,
                        ])->one();
                        $menuAvailability->quota = $post[$day_of_week.'-'.$shift->id];
                        if (!$menuAvailability->quota) $menuAvailability->quota = 0;
                        $menuAvailability->save();
                    }
                }
            }
            Yii::$app->session->addFlash('success', 'Ketersediaan menu <b>'.$model->name.'</b> berhasil diperbarui.');
            return $this->redirect(['view', 'id' => $id]);
        }
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Menu();

        if ($model->load(Yii::$app->request->post())) {
            unset($model->file_image);
            if ($model->save()) {
                $model->generateAvailability();
                $uploadedFile = UploadedFile::getInstance($model, 'file_image');
                if ($uploadedFile) {
                    if (!uploadFile($model, 'file_image', $uploadedFile)) {
                        Yii::$app->session->addFlash('error', 'Error uploading file.');
                    }
                }
            } else {
                Yii::$app->session->addFlash('error', \yii\helpers\Json::encode($model->errors));
            }
        } else if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_form', [
                'model' => $model
            ]);
        }
        return $this->redirect(['index']);
    }

    /**
     * Updates an existing Menu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->post()) {
            $model->is_active_sunday    = 0;
            $model->is_active_monday    = 0;
            $model->is_active_tuesday   = 0;
            $model->is_active_wednesday = 0;
            $model->is_active_thursday  = 0;
            $model->is_active_friday    = 0;
            $model->is_active_saturday  = 0;
            $model->load(Yii::$app->request->post());
            if ($model->save()) {
                $uploadedFile = UploadedFile::getInstance($model, 'file_image');
                if ($uploadedFile) {
                    if (!uploadFile($model, 'file_image', $uploadedFile)) {
                        Yii::$app->session->addFlash('error', 'Error uploading file.');
                    }
                }
            } else {
                Yii::$app->session->addFlash('error', \yii\helpers\Json::encode($model->errors));
            }
        } else if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_form', [
                'model' => $model
            ]);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Deletes an existing Menu model.
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
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Menu::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionDownload($id, $field = 'file_image')
    {
        $model = $this->findModel($id);
        return downloadFile($model, $field);
    }

    public function actionGenerateAvailability()
    {
        $menus = Menu::find()->all();
        foreach ($menus as $menu) {
            $menu->generateAvailability();
        }
        return $this->redirect(['index']);
    }
}
