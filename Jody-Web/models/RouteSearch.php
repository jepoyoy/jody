<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Route;

/**
 * RouteSearch represents the model behind the search form about `app\models\Route`.
 */
class RouteSearch extends Route
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['route_id'], 'integer'],
            [['pointA', 'pointB', 'route_code'], 'safe'],
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
        $query = Route::find();

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
            'route_id' => $this->route_id,
        ]);

        $query->andFilterWhere(['like', 'pointA', $this->pointA])
            ->andFilterWhere(['like', 'pointB', $this->pointB])
            ->andFilterWhere(['like', 'route_code', $this->route_code]);

        return $dataProvider;
    }
}
