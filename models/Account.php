<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Account".
 *
 * @property integer $id
 * @property string $name
 * @property string $amount
 * @property integer $userId
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
            [['name', 'amount', 'userId'], 'required'],
            [['amount'], 'number'],
            [['userId'], 'integer'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Account ID',
            'name' => 'Name',
            'amount' => 'Amount',
            'userId' => 'User ID',
        ];
    }


    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }


}
