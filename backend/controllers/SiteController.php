<?php
namespace backend\controllers;

use common\models\entity\User;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use common\models\LoginForm;
use common\models\PasswordForm;
use common\models\PasswordResetRequestForm;
use common\models\ResetPasswordForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'request-password-reset', 'reset-password'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'change-password'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex($dashboard = 0)
    {
        if (!Yii::$app->user->isGuest) {
            if ($dashboard == 1) return $this->render('index');
            if (Yii::$app->user->identity->unit_id) return $this->redirect(['/order/index']);
            if (Yii::$app->user->identity->role == 'Koperasi') return $this->redirect(['/menu/index']);
            if (Yii::$app->user->identity->role == 'Administrator') return $this->redirect(['/user/index']);
        }
        
        return $this->redirect(['/site/login']);
        // Yii::$app->session->addFlash('error', 'Test');
        // return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        $model->password = '';
        
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionChangePassword(){
        $model     = new PasswordForm();
        $modelUser = User::findOne(Yii::$app->user->id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                try {
                    $password = $_POST['PasswordForm']['password_new'];
                    $modelUser->setPassword($password);
                    $modelUser->generateAuthKey();

                    if ($modelUser->save()) {
                        Yii::$app->session->addFlash('success','Password changed.');
                        return $this->redirect(['index']);
                    } else {
                        Yii::$app->session->addFlash('error','Password not changed: '. \yii\helpers\Json::encode($modelUser->errors));
                    }
                } catch (\Exception $e) {
                    Yii::$app->session->addFlash('error',"{$e->getMessage()}");
                }
            } else {
                Yii::$app->session->addFlash('error','Password not changed: '. \yii\helpers\Json::encode($model->errors));
            } 
        } else /* if (Yii::$app->request->isAjax) */ {
            // return $this->renderAjax('change-password', [
            return $this->render('change-password', [
                'model' => $model
            ]);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }
}
