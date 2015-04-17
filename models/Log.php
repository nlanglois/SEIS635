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
            [['transactionType', 'amount', 'accountId'], 'required'],
            [['amount'], 'number'],
            [['dateTime'], 'safe'],
            [['accountId'], 'integer'],
            [['transactionType'], 'string', 'max' => 100]
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
}
