<?php
/**
 * Created by PhpStorm.
 * User: nlangloi10
 * Date: 4/23/15
 * Time: 1:42 PM
 */

use app\models\Log;
use app\models\LogSearch;

use yii\helpers\Html;
use yii\grid\GridView;


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

                $searchModel = new LogSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'showOnEmpty' => false,
                    'emptyText' => "None found yet",
                    'columns' => [
                        //['class' => 'yii\grid\SerialColumn'],

                        //'id',
                        ['attribute'=>'transactionType',
                            'contentOptions' =>[
                                //'class' => 'uppercase',
                                'style'=>'text-transform: uppercase;'
                            ],
                        ],
                        'amount',
                        //'dateTime',
                        [
                            'attribute' => 'dateTime',
                            //'format' => ['raw', 'Y-m-d H:i:s'],
                            'format' =>  ['date', 'php:F jS, Y @ g:i a'],
                            'options' => ['width' => '200'],
                        ],
                        //'accountId',
                        //'accountName',
                        //'$data->Account->name',
                        [
                            'attribute' => 'name',
                            'value' => 'account.name',
                            //'value' => 'accountName',
                            //'value' => '$data->Account->name',
                        ],


                        //['class' => 'yii\grid\ActionColumn'],

                    ],
                ]);
            ?>

        </div>

    </div>
<?php //$this->endContent();