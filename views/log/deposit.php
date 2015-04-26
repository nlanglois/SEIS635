<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Log */

$this->title = 'Create a Deposit';
$this->params['breadcrumbs'][] = ['label' => 'Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_deposit_withdrawal_form', [
        'model' => $model,
    ]) ?>

</div>
