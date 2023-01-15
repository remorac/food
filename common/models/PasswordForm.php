<?php
    namespace common\models;
   
    use Yii;
    use yii\base\Model;
    use common\models\User;
   
    class PasswordForm extends Model
    {
        public $password_old;
        public $password_new;
        public $password_new_confirmation;
       
        public function rules(){
            return [
                [['password_old','password_new','password_new_confirmation'],'required'],
                [['password_old'], 'findPasswords'],
                [['password_new'], 'string', 'max' => 60, 'min' => 6],
                [['password_new_confirmation'],'compare','compareAttribute' => 'password_new'],
            ];
        }
       
        public function findPasswords($attribute, $params){
            $user = User::find()->where([
                'username'=>Yii::$app->user->identity->username
            ])->one();
            if(!$user->validatePassword($this->password_old))
                $this->addError($attribute,'Old password is incorrect');
        }
       
        public function attributeLabels(){
            return [
                'password_old'              => 'Password Saat Ini',
                'password_new'              => 'Password Baru',
                'password_new_confirmation' => 'Ulangi Password Baru',
            ];
        }
    }