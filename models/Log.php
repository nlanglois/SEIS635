<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Log".
 *
 * @property integer $id
 * @property string $transactionType
 * @property string $amount
 * @property string $dateTime
 * @property integer $accountId
 */
class Log extends \yii\db\ActiveRecord
{

    //$accountName = "";

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['transactionType', 'amount'], 'required'],
            [['amount'], 'double', 'min'=>0.01],
            [['dateTime'], 'safe'],
            ['accountId', 'integer'],
            ['accountId', 'required', 'message' => 'You must select one of your accounts.'],
            [['transactionType'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'transactionType' => 'Transaction Type',
            'amount' => 'Amount',
            'dateTime' => 'Date Time',
            'accountId' => 'Account ID',
        ];
    }


    public function getAccount()
    {
        return $this->hasOne(Account::classname(), ['id' => 'accountId']);
    }


    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userId'])->viaTable(Account::tableName(), ['id' => 'accountId']);
    }


}
