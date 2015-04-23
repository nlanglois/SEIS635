<?php
/**
 * Created by PhpStorm.
 * User: nlangloi10
 * Date: 4/23/15
 * Time: 1:42 PM
 */

?>

Hello, <?= Yii::$app->user->identity->firstName . ' ' . Yii::$app->user->identity->lastName; ?>!