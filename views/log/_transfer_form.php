<?php

use app\models\Account;
use kartik\money\MaskMoney;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $withdrawal app\models\Log */
/* @var $deposit app\models\Log */
/* @var $form yii\widgets\ActiveForm */


print "<pre>";
print_r($deposit->attributes);
print_r($withdrawal->attributes);
print "</pre>";
?>

<div class="log-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($withdrawal, 'transactionType')->hiddenInput()->hide() ?>
    <?= $form->field($deposit, 'transactionType')->hiddenInput()->hide() ?>


    <?php
    echo $form->field($withdrawal, 'amount')->widget(MaskMoney::classname(), [
            'pluginOptions' => [
                'prefix' => '$ ',
                'suffix' => '',
                'allowNegative' => false
            ]
        ]
    );
    ?>

    <?= $form->field($withdrawal, 'dateTime')->hiddenInput()->hide() ?>
    <?= $form->field($deposit, 'dateTime')->hiddenInput()->hide() ?>

    <?php
    //$from = ($model->transactionType == "deposit") ? "Into" : "From";

    $accountsList = ArrayHelper::map(Account::find()
        ->where('userId = :userId', [':userId' => Yii::$app->user->identity->id])
        ->asArray()
        ->all(),
        'id',
        function ($element) {
            return $element['name'] . " (" . Yii::$app->formatter->asCurrency($element['amount']) . ")";
        }
    );


    echo $form->field($withdrawal, 'accountId')->dropDownList($accountsList, ['prompt' => '-Choose an account-'])
        ->label('from this account');
    ?>



    <?php
    $choices = ["mine" => "one of my own", "another" => "or another user's"];
    echo "and put it into " . Html::radioList('choice', null, $choices) . "accounts:";
    ?>



    <div class="myOwnAccount">
        <?php
        $myAccountDepositList = ArrayHelper::map(Account::find()
            ->where('userId = :userId', [':userId' => Yii::$app->user->identity->id])
            //->andWhere('Account.id != :selectedAccountId', [':selectedAccountId' => $withdrawal->accountId])
            ->asArray()
            ->all(),
            'id',
            function ($element) {
                return $element['name'] . " (" . Yii::$app->formatter->asCurrency($element['amount']) . ")";
            }
        );

        echo $form->field($deposit, 'accountId')
            ->dropDownList($myAccountDepositList, ['prompt' => '-Choose one of your accounts to transfer money to-'])
            ->label('into this account');
        ?>
    </div>


    <div class="otherAccount">
        <? //= $form->field($deposit, 'accountId')->textInput(['maxlength' => 9])->label("Other user's account ID") ?>
    </div>


    <div class="form-group">
        <?= Html::submitButton($withdrawal->isNewRecord ? 'Create' : 'Update', ['class' => $withdrawal->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>