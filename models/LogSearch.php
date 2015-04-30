<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * LogSearch represents the model behind the search form about `app\models\Log`.
 */
class LogSearch extends Log
{

    public $accountName;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'accountId'], 'integer'],
            [['transactionType', 'dateTime', 'accountName'], 'safe'],
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

        /*
        $query = Log::find()
            ->select(['Log.transactionType', 'Log.amount', 'Log.dateTime', 'Account.name'])
            ->leftJoin('Account', 'Account.id = Log.accountId')
            ->leftJoin('User', 'User.id = Account.userId')
            //->with('accountOwner')
            ->where('User.id = :userId', [':userId' => Yii::$app->user->identity->id]);
        */

        $query = Log::find();
        $query->joinWith('user');
        $query->where('userId = :userId', [':userId' => Yii::$app->user->identity->id]);
        $query->orderBy([
            'dateTime' => SORT_DESC,
        ]);
        $query->all();


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['accountName'] = [
            'asc' => ['Account.name' => SORT_ASC],
            'desc' => ['Account.name' => SORT_DESC],
        ];


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
            //'accountId' => $this->accountId,
        ]);

        $query->andFilterWhere(['like', 'transactionType', $this->transactionType]);
        $query->andFilterWhere(['like', 'Account.name', $this->accountName]);

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
        $query->joinWith(['user']);
        $query->orderBy([
            'Log.dateTime' => SORT_DESC,
        ]);
        $query->where('User.id = :userId', [':userId' => Yii::$app->user->identity->id]);
        $query->limit(5);
        //$query->all();
        //echo $query->createCommand()->sql;


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        $dataProvider->sort->attributes['amount'] = [
            'asc' => ['Account.amount' => SORT_ASC],
            'desc' => ['Account.amount' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['accountName'] = [
            'asc' => ['Account.name' => SORT_ASC],
            'desc' => ['Account.name' => SORT_DESC],
        ];


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'Account.amount' => $this->amount,
            'dateTime' => $this->dateTime,
            //'accountId' => $this->accountId,
        ]);

        $query->andFilterWhere(['like', 'transactionType', $this->transactionType]);
        $query->andFilterWhere(['like', 'Account.name', $this->accountName]);

        return $dataProvider;
    }
}
