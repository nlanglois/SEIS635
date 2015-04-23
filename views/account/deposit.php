<?php
/**
 * Created by PhpStorm.
 * User: nlangloi10
 * Date: 4/22/15
 * Time: 7:36 PM
 */


?>


<div class="account-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Amount')->textInput(['maxlength' => 15]) ?>

    <?= $form->field($model, 'Amount')->textInput(['maxlength' => 9]) ?>

    <?= $form->field($model, 'Description')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
