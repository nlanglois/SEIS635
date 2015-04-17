<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ATM".
 *
 * @property integer $id
 * @property string $address
 * @property string $storedAmount
 * @property integer $bankId
 */
class ATM extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ATM';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['address', 'bankId'], 'required'],
            [['storedAmount'], 'number'],
            [['bankId'], 'integer'],
            [['address'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'address' => 'Address',
            'storedAmount' => 'Stored Amount',
            'bankId' => 'Bank ID',
        ];
    }
}
