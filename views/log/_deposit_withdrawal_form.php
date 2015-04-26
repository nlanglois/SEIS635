<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\money\MaskMoney;


use app\models\Account;


/* @var $this yii\web\View */
/* @var $model app\models\Log */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="log-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'transactionType')->hiddenInput()->hide() ?>

    <?//= $form->field($model, 'amount')->textInput(['maxlength' => 9]) ?>

    <?php
        echo $form->field($model, 'amount')->widget(MaskMoney::classname(), [
            'pluginOptions' => [
                'prefix' => '$ ',
                'suffix' => '',
                'allowNegative' => false
                ]
            ]
        );
    ?>

    <?= $form->field($model, 'dateTime')->hiddenInput()->hide() ?>

    <?php
        $from = ($model->transactionType == "deposit") ? "Into" : "From";

        $accountsList=ArrayHelper::map(Account::find()
            ->where('userId = :userId', [':userId' => Yii::$app->user->identity->id])
            ->asArray()
            ->all(), 'id', 'name');
        echo $form->field($model, 'accountId')->dropDownList($accountsList, ['prompt'=>'-Choose an account-'])
            ->label($from . ' this account');
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>