<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\entity\Order;

/**
 * OrderSearch represents the model behind the search form about `common\models\entity\Order`.
 */
class OrderSearch extends Order
{
    public $unit_id;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'schedule_id', 'user_id', 'menu_id', 'location_id', 'review_status', 'reviewed_at', 'reviewed_by', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['unit_id'], 'safe'],
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
        $query = Order::find();

        // add conditions that should always apply here
        $query->joinWith(['user.unit']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        $dataProvider->sort->attributes['unit_id'] = [
            'asc' => ['unit.name' => SORT_ASC],
            'desc' => ['unit.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'schedule_id' => $this->schedule_id,
            'user_id' => $this->user_id,
            'menu_id' => $this->menu_id,
            'location_id' => $this->location_id,
            'review_status' => $this->review_status,
            'reviewed_at' => $this->reviewed_at,
            'reviewed_by' => $this->reviewed_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'unit_id' => $this->unit_id,
        ]);

        return $dataProvider;
    }
}
