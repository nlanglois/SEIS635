<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'All of your Transactions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Deposit', ['deposit'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Create Withdrawal', ['withdrawal'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            ['attribute'=>'transactionType',
                'contentOptions' =>[
                    //'class' => 'uppercase',
                    'style'=>'text-transform: uppercase;'
                ],
            ],
            'amount',
            [
                'attribute' => 'dateTime',
                //'format' => ['raw', 'Y-m-d H:i:s'],
                'format' =>  ['date', 'php:F jS, Y @ g:i a'],
                'options' => ['width' => '200'],
            ],
            [
                'attribute' => 'accountName',
                'value' => 'account.name',
            ],

            //['class' => 'yii\grid\ActionColumn'],
            /*
            [
                'class' => 'yii\grid\ActionColumn',
                //'header'=>'Action',
                'headerOptions' => ['width' => '80'],
                'template' => '{update} {delete}',
            ],
            */

        ],
    ]); ?>

</div>
