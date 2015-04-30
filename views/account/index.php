<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AccountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Accounts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="account-index">

    <h2><?= Html::encode($this->title) ?></h2>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create new account', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name',
            'amount',
            //'userId',

            [
                'class' => 'yii\grid\ActionColumn',
                //'header'=>'Action',
                'headerOptions' => ['width' => '220'],
                'template' => '{update} {deposit} {withdrawal}',
                'buttons' => [
                    'deposit' => function ($url, $model) {
                        return Html::a(Html::encode("deposit"), $url, [
                            'title' => Yii::t('app', 'Make a new deposit into this account'),
                            'class' => 'btn btn-primary',
                        ]);
                    },
                    'withdrawal' => function ($url, $model) {
                        return Html::a(Html::encode("withdrawal"), $url, [
                            'title' => Yii::t('app', 'Make a new withdrawal from this account'),
                            'class' => 'btn btn-primary',
                        ]);
                    },
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    switch ($action) {
                        case "update":
                            $url = "account/update?id";
                            break;
                        case "deposit":
                            $url = "log/deposit?account";
                            break;
                        case "withdrawal":
                            $url = "log/withdrawal?account";
                            break;
                    }
                    return $url . "=" . $model->id;
                },
            ],
            //],
        ],
    ]); ?>

</div>
