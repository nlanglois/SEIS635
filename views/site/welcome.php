<?php
/**
 * Created by PhpStorm.
 * User: nlangloi10
 * Date: 4/23/15
 * Time: 1:42 PM
 */

use app\models\LogSearch;
use yii\grid\GridView;
use yii\helpers\Html;


?>

<h2>Hello, <?= Yii::$app->user->identity->firstName . ' ' . Yii::$app->user->identity->lastName; ?>!</h2>



<?php //$this->beginContent('@app/views/layouts/main.php'); ?>
    <div class="container">

        <div class="col-sm-3">
            <p>
                <?= Html::a('View your accounts', ['account/'], ['class' => 'btn btn-success']) ?>
            </p>

            <p>
                <?= Html::a('Deposit funds', ['log/deposit'], ['class' => 'btn btn-success']) ?>
            </p>

            <p>
                <?= Html::a('Withdrawal funds', ['log/withdrawal'], ['class' => 'btn btn-success']) ?>
            </p>
        </div>


        <div class="col-sm-8">

            <h3>Your last 5 transactions</h3>
            <?php

            $total = 0;

            $searchModel = new LogSearch();
            $dataProvider = $searchModel->last5ofLoggedInUser(Yii::$app->request->queryParams);
            //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'showOnEmpty' => false,
                    'emptyText' => "None found yet",

                    'columns' => [
                        //['class' => 'yii\grid\SerialColumn'],

                        [
                            'attribute' => 'transactionType',
                            'contentOptions' =>[
                                //'class' => 'uppercase',
                                'style'=>'text-transform: uppercase;'
                            ],
                            'format' => 'raw',
                            'footer' => '<a href="./log">all transactions</a>',
                        ],
                        'amount:currency',
                        [
                            'attribute' => 'dateTime',
                            //'format' => ['raw', 'Y-m-d H:i:s'],
                            'format' =>  ['date', 'php:F jS, Y @ g:i a'],
                            'options' => ['width' => '200'],
                        ],
                        [
                            'attribute' => 'accountName',
                            'value' => 'account.name',
                            'options' => ['width' => '200'],
                        ],

                        //['class' => 'yii\grid\ActionColumn'],
                    ],
                    'showFooter' => TRUE,
                ]);
            ?>

        </div>

    </div>
<?php //$this->endContent();