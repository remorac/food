<?php

namespace backend\controllers;

use Box\Spout\Common\Type;
use Box\Spout\Reader\ReaderFactory;
use common\models\entity\Group;
use Yii;
use common\models\entity\GroupShift;
use common\models\entity\Shift;
use common\models\search\GroupShiftSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\IntegrityException;
use yii\web\UploadedFile;

/**
 * GroupShiftController implements the CRUD actions for GroupShift model.
 */
class GroupShiftController extends Controller
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
     * Lists all GroupShift models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GroupShiftSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single GroupShift model.
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
     * Creates a new GroupShift model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GroupShift();

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
     * Updates an existing GroupShift model.
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
     * Deletes an existing GroupShift model.
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
     * Finds the GroupShift model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GroupShift the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GroupShift::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionImport() 
    {
        if ($post = Yii::$app->request->post()) {
            $packageFile    = UploadedFile::getInstanceByName('package-file');
            $reader         = ReaderFactory::create(Type::XLSX);
            $reader->open($packageFile->tempName);

            $unsaved_rows = [];
            $saved_count = 0;

            Yii::$app->db->createCommand("
                SET foreign_key_checks = 0;
                TRUNCATE TABLE `discount`;
                TRUNCATE TABLE `item`;
                TRUNCATE TABLE `item_price_sell`;
                TRUNCATE TABLE `item_quantity_adjustment`;
                TRUNCATE TABLE `item_storage`;
            ")->execute();
            
            foreach ($reader->getSheetIterator() as $sheet) {
                $rowCount = 0;
                foreach ($sheet->getRowIterator() as $row) {
                    $rowCount++;
                    if ($rowCount >= 2) {

                        for ($i = 1; $i <= 3; $i++) {
                            $group_name = $row[$i] ? trim((string)$row[$i]) : null;
                            if ($group_name) {
                                $group           = Group::findOne(['name' => trim((string)$row[$i])]);
                                $model           = new GroupShift();
                                $model->date     = $row[0];
                                $model->group_id = $group->id;
                                $model->shift_id = $i;
                                
                                if ($model->save()) {
                                    $saved_count++;
                                } else {
                                    Yii::$app->session->addFlash('error', $rowCount .': '. \yii\helpers\Json::encode($model->errors));
                                    $unsaved_rows[] = $rowCount;
                                }
                            }
                        }
                    } 
                }
            }
            $reader->close();
            $unsaved_rows_str = implode(', ', $unsaved_rows);
            if ($unsaved_rows) Yii::$app->session->setFlash('warning', 
                $saved_count.' rows has been imported. 
                <br>You may want to re-check the following unsaved rows : '.$unsaved_rows_str);
            return $this->redirect(['index']);
        } else {
            return $this->render('import');
        }
    }
}
