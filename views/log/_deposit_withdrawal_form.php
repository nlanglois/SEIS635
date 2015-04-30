<?php

use app\models\Account;
use kartik\money\MaskMoney;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


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
            //->select('id, name, amount')
            ->where('userId = :userId', [':userId' => Yii::$app->user->identity->id])
            ->asArray()
            ->all(),
            'id',
            function ($element) {
                return $element['name'] . " (" . Yii::$app->formatter->asCurrency($element['amount']) . ")";
            }
        );

    if ($_GET) {
        $model->accountId = $_GET['account'];
    }

        echo $form->field($model, 'accountId')->dropDownList($accountsList, ['prompt'=>'-Choose an account-'])
            ->label($from . ' this account');
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>