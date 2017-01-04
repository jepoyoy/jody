<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RouteReceipts;

/**
 * RouteReceiptsSearch represents the model behind the search form about `app\models\RouteReceipts`.
 */
class RouteReceiptsSearch extends RouteReceipts
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['trip_receipt_id', 'employee_id', 'schedule_id'], 'integer'],
            [['created_date'], 'safe'],
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
        $query = RouteReceipts::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'trip_receipt_id' => $this->trip_receipt_id,
            'employee_id' => $this->employee_id,
            'schedule_id' => $this->schedule_id,
            'created_date' => $this->created_date,
        ]);

        return $dataProvider;
    }
}
