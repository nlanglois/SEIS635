<?php $this->registerJsFile(Yii::$app->request->baseUrl . '/js/transfer.js',
    [
        'depends' => [\yii\web\JqueryAsset::className()]
    ]
); ?>

<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $ app\models\Log */

$this->title = 'Create a transfer';
$this->params['breadcrumbs'][] = ['label' => 'Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_transfer_form2', [
        'deposit' => $deposit,
        'withdrawal' => $withdrawal,
    ]) ?>

</div>
