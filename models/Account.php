<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Account".
 *
 * @property integer $accountID
 * @property string $Name
 * @property string $Amount
 * @property integer $userID
 */
class Account extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Account';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Name', 'Amount', 'userID'], 'required'],
            [['Amount'], 'number'],
            [['userID'], 'integer'],
            [['Name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'accountID' => 'Account ID',
            'Name' => 'Name',
            'Amount' => 'Amount',
            'userID' => 'User ID',
        ];
    }
}
