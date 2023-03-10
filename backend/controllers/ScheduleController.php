<?php

namespace backend\controllers;

use common\models\entity\Holiday;
use common\models\entity\Order;
use Yii;
use common\models\entity\Schedule;
use common\models\entity\ScheduleMenu;
use common\models\search\ScheduleSearch;
use kartik\mpdf\Pdf;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\IntegrityException;

/**
 * ScheduleController implements the CRUD actions for Schedule model.
 */
class ScheduleController extends Controller
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
                    'delete-all' => ['POST'],
                    'delete-order' => ['POST'],
                    'reset' => ['POST'],
                    'accept' => ['POST'],
                    'reject' => ['POST'],
                    'accept-all' => ['POST'],
                    'reject-all' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Schedule models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ScheduleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Schedule model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if ($post = Yii::$app->request->post()) {
            $ids = [];
            foreach ($post['quota'] as $key => $value) {
                if ($value > 0) {
                    $scheduleMenu = ScheduleMenu::findOne(['schedule_id' => $id, 'menu_id' => $key]);
                    if (!$scheduleMenu) {
                        $scheduleMenu = new ScheduleMenu();
                        $scheduleMenu->schedule_id = $id;
                        $scheduleMenu->menu_id = $key;
                    }
                    $scheduleMenu->quota = $value;
                    $scheduleMenu->description = $post['description'][$key];
                    if (!$scheduleMenu->save()) Yii::$app->session->addFlash('error', \yii\helpers\Json::encode($scheduleMenu->errors));
                    $ids[] = $scheduleMenu->id;
                }
            }
            ScheduleMenu::deleteAll([
                'and',
                ['schedule_id' => $id],
                ['not in', 'id', $ids],
            ]);
            return $this->redirect(['view', 'id' => $id]);
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Schedule model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Schedule();

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
     * Updates an existing Schedule model.
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
     * Deletes an existing Schedule model.
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

    public function actionDeleteAll()
    {
        try {
            $models = Schedule::find()->all();
            foreach ($models as $model) {
                $model->delete();
            }
            return $this->redirect(['index']);
        } catch (IntegrityException $e) {
            throw new \yii\web\HttpException(500,"Integrity Constraint Violation. This data can not be deleted due to the relation.", 405);
        }
    }

    /**
     * Finds the Schedule model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Schedule the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Schedule::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionDeleteOrder($order_id)
    {
        $order = Order::findOne($order_id);
        $order->delete();
        return $this->redirect(['view', 'id' => $order->schedule_id]);
    }

    public function actionReset($order_id)
    {
        $order = Order::findOne($order_id);
        $order->review_status = Order::REVIEW_STATUS_WAITING;
        $order->reviewed_at = time();
        $order->reviewed_by = Yii::$app->user->id;
        $order->save();
        return $this->redirect(['view', 'id' => $order->schedule_id]);
    }

    public function actionAccept($order_id)
    {
        $order = Order::findOne($order_id);
        $order->review_status = Order::REVIEW_STATUS_ACCEPTED;
        $order->reviewed_at = time();
        $order->reviewed_by = Yii::$app->user->id;
        $order->save();
        return $this->redirect(['view', 'id' => $order->schedule_id]);
    }

    public function actionReject($order_id)
    {
        $order = Order::findOne($order_id);
        $order->review_status = Order::REVIEW_STATUS_REJECTED;
        $order->reviewed_at = time();
        $order->reviewed_by = Yii::$app->user->id;
        $order->save();
        return $this->redirect(['view', 'id' => $order->schedule_id]);
    }

    public function actionAcceptAll($id)
    {
        $orders = Order::findAll(['schedule_id' => $id]);
        foreach ($orders as $order) {
            $order->review_status = Order::REVIEW_STATUS_ACCEPTED;
            $order->reviewed_at = time();
            $order->reviewed_by = Yii::$app->user->id;
            $order->save();
        }
        return $this->redirect(['view', 'id' => $order->schedule_id]);
    }

    public function actionRejectAll($id)
    {
        $orders = Order::findAll(['schedule_id' => $id]);
        foreach ($orders as $order) {
            $order->review_status = Order::REVIEW_STATUS_REJECTED;
            $order->reviewed_at = time();
            $order->reviewed_by = Yii::$app->user->id;
            $order->save();
        }
        return $this->redirect(['view', 'id' => $order->schedule_id]);
    }

    public function actionReportByMenu($id, $to_pdf = 1)
    {
        $model  = $this->findModel($id);
        $title  = $model->date.' '.$model->shift->name.' '.$model->description;
        $view   = 'report-by-menu';
        $pre_params = [
            'model'  => $model,
            'title'  => $title,
            'view'   => $view,
            'to_pdf' => $to_pdf,
        ];
        $params = array_merge($pre_params, ['params' => $pre_params]);

        if ($to_pdf)
        return $this->generatePdf($title, $view, $params, 0);

        return $this->render($view, $params);
    }

    public function actionReportByUnit($id, $to_pdf = 1)
    {
        $model  = $this->findModel($id);
        $title  = $model->date.' '.$model->shift->name.' '.$model->description;
        $view   = 'report-by-unit';
        $pre_params = [
            'model'  => $model,
            'title'  => $title,
            'view'   => $view,
            'to_pdf' => $to_pdf,
        ];
        $params = array_merge($pre_params, ['params' => $pre_params]);

        if ($to_pdf)
        return $this->generatePdf($title, $view, $params, 0);

        return $this->render($view, $params);
    }

    public function generatePdf($title, $view, $params = []) {
        $format = 'A4';
        $pdf = new Pdf([
            'mode'         => Pdf::MODE_CORE,
            'format'       => $format,
            'orientation'  => 'P',
            'marginTop'    => '30',
            'marginBottom' => '10',
            // 'marginBottom' => '0',
            'marginLeft'   => '10',
            'marginRight'  => '10',
            'filename'     => $title,
            'options'      => [
                'title'             => $title,
                'defaultheaderline' => 0,
                'defaultfooterline' => 0,
            ],
            'content'      => $this->renderPartial($view, $params),
            'methods'      => [
                'SetHeader' => '<table class="table-report-header" width="100%" style="margin-bottom:0">
                                    <tr>
                                        <td style="padding:0">
                                            <div style="margin:0;"><b><big><big><big><big>'. Yii::$app->name .'</big></big></big></big></b>
                                                <br><small>' . $params['title'] . '</small>
                                            </div>
                                            <hr style="margin:8px">
                                        </td>
                                    </tr>
                                </table>',
                // 'SetFooter' => \backend\helpers\ReportHelper::footer($params).'<span class="pull-right">Hal.{PAGENO}/{nbpg}</span>',
                // 'SetFooter' => ['Print date: ' . date('d/m/Y') . '||Page {PAGENO} of {nbpg}'],
                'SetFooter' => '|page {PAGENO} / {nbpg}|',
            ],
            'cssInline' => '
                body, 
                .printable, 
                .table-report, 
                .table-report td, 
                .table-report th,
                table { font-size: 11pt !important }
                .table-report { margin-bottom:10px }
                .table-report td { border-bottom:1px solid #ccc; vertical-align:top; padding:4px 8px }
                .table-report tr.thead td { vertical-align:bottom; padding:2px 10px }
                .table-report tr.thead td { font-weight: bold; border-bottom:2px solid #ccc; border-top:none }
                thead { display: table-header-group }
                .table-report-footer td { border:none; padding:0px 5px }
                tr.thead td { font-weight: bold; border-top:none }
                tr.tfoot td { font-weight: bold; border-bottom:none !important}
                .condensed { width:1px; white-space: nowrap }
            ',
        ]);
        return $pdf->render();
    }

    public function actionGenerate()
    {
        $model = new Schedule();

        if ($post = Yii::$app->request->post()) {
            
            $isValid = 1;
            if ($post['generator_date_start'] > $post['generator_date_end']) {
                $isValid = 0;
                Yii::$app->session->addFlash('error', 'Tanggal Mulai harus sebelum Tanggal Selesai.');
            }
            if ($post['generator_order_start'] < $post['generator_order_end']) {
                $isValid = 0;
                Yii::$app->session->addFlash('error', 'Mulai Pemesanan harus lebih lama dari Selesai Pemesanan.');
            }
            $times = explode(':', $post['generator_time']);
            if (!isset($times[1]) || isset($times[3]) || $times[0] >= 24 || $times[1] >= 60) {
                $isValid = 0;
                Yii::$app->session->addFlash('error', 'Jam Makan tidak valid.');
            }

            if (!$isValid) return $this->redirect(Yii::$app->request->referrer);

            $date = $post['generator_date_start'];
            while ($date <= $post['generator_date_end']) {
                $schedule                       = new Schedule();
                $schedule->date                 = $date;
                $schedule->shift_id             = $post['generator_shift_id'];
                $schedule->datetime_start_order = date('Y-m-d H:i', strtotime('-'.$post['generator_order_start'].' hours', strtotime($date.' '.$post['generator_time'])));
                $schedule->datetime_end_order   = date('Y-m-d H:i', strtotime('-'.$post['generator_order_end'].' hours', strtotime($date.' '.$post['generator_time'])));
                $schedule->is_generated         = 1;
                $schedule->save();

                $date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
            }

            
        } else if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_form-generate', [
                'model' => $model
            ]);
        }
        return $this->redirect(['index']);
    }
}
