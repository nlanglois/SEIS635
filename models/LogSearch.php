<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Log;

/**
 * LogSearch represents the model behind the search form about `app\models\Log`.
 */
class LogSearch extends Log
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'accountId'], 'integer'],
            [['transactionType', 'dateTime'], 'safe'],
            [['amount'], 'number'],
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
        $query = Log::find()
            ->select(['Log.transactionType', 'Log.amount', 'Log.dateTime', 'Account.name AS accountName'])
            ->leftJoin('Account', 'Account.id = Log.accountId')
            ->leftJoin('User', 'User.id = Account.userId')
            //->with('accountOwner')
            ->where('User.id = :userId', [':userId' => Yii::$app->user->identity->id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'amount' => $this->amount,
            'dateTime' => $this->dateTime,
            'accountId' => $this->accountId,
        ]);

        $query->andFilterWhere(['like', 'transactionType', $this->transactionType]);

        return $dataProvider;
    }



    /**
     * Creates data provider instance with search query applied, but only for
     * the 5 most recent of the currently-logged in user.
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function last5ofLoggedInUser($params)
    {
        $query = Log::find();
        //$query = Log::find()->where('accountId = :userId', [':userId' => Yii::$app->user->identity->id])->all();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'amount' => $this->amount,
            'dateTime' => $this->dateTime,
            'accountId' => $this->accountId,
        ]);

        $query->andFilterWhere(['like', 'transactionType', $this->transactionType]);

        return $dataProvider;
    }
}
