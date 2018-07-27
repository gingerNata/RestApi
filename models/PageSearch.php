<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Page;

/**
 * PageSearch represents the model behind the search form of `app\models\Page`.
 */
class PageSearch extends Page
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['_id', 'name', 'title', 'create', 'update', 'url', 'status', 'tags', 'metatags', 'content'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Page::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere(['=', '_id', $this->_id])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['=', 'title', $this->title])
            ->andFilterWhere(['=', 'create', $this->create])
            ->andFilterWhere(['=', 'update', $this->update])
            ->andFilterWhere(['=', 'url', $this->url])
            ->andFilterWhere(['=', 'status', $this->status])
            ->andFilterWhere(['in', 'tags', $this->tags])
            ->andFilterWhere(['=', 'metatags', $this->metatags]);

        return $dataProvider;
    }

    public function formName()
    {
        return '';
    }
}
