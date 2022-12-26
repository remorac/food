<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\entity\User;

/**
 * UserSearch represents the model behind the search form about `common\models\entity\User`.
 */
class UserSearchUnit extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'otp_expired_at', 'must_change_password', 'confirmed_at', 'status', 'unit_id', 'supplier_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['phone', 'email', 'username', 'auth_key', 'password_hash', 'password_reset_token', 'verification_token', 'one_time_password', 'name'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = User::find();

        // add conditions that should always apply here
        $query->where(['is not', 'user.unit_id', null]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'otp_expired_at' => $this->otp_expired_at,
            'must_change_password' => $this->must_change_password,
            'confirmed_at' => $this->confirmed_at,
            'status' => $this->status,
            'unit_id' => $this->unit_id,
            'supplier_id' => $this->supplier_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'verification_token', $this->verification_token])
            ->andFilterWhere(['like', 'one_time_password', $this->one_time_password])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
