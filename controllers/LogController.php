<?php

namespace app\controllers;

use app\models\Account;
use app\models\Log;
use app\models\Log2;
use app\models\LogSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * LogController implements the CRUD actions for Log model.
 */
class LogController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Log models, filterable.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Log model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the Log model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Log the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Log::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new Log model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Log();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Creates a new Log model for a deposit.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionDeposit()
    {
        $model = new Log();
        $model->transactionType = "deposit";

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $accountModel = Account::find()
                ->where('id = :accountId', [':accountId' => $model->accountId])
                ->one();
            $accountModel->amount += $model->amount;
            $accountModel->save();

            return $this->redirect(['index']);
            //return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('deposit', [
                'model' => $model,
            ]);
        }
    }



    /**
     * Creates a new Log model for a withdrawal.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionWithdrawal()
    {
        $model = new Log();
        $model->transactionType = "withdrawal";

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $accountModel = Account::find()
                ->where('id = :accountId', [':accountId' => $model->accountId])
                ->one();
            $accountModel->amount -= $model->amount;
            $accountModel->save();

            return $this->redirect(['index']);
            //return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('withdrawal', [
                'model' => $model,
            ]);
        }
    }


    /*
     * Creates a transfer, to move some funds from one account to another
     * http://www.yiiframework.com/forum/index.php/topic/53935-solved-subforms/page__p__248184#entry248184
     */
    public function actionTransfer()
    {

        $deposit = new Log();
        $deposit->transactionType = "deposit";

        $withdrawal = new Log2();
        $withdrawal->transactionType = "withdrawal";


        //$deposit->dateTime = $withdrawal->dateTime;


        if ($deposit->load(Yii::$app->request->post()) &&
            $withdrawal->load(Yii::$app->request->post())
        ) {
            //&& Model::validateMultiple([$deposit, $withdrawal])) {

            $deposit->amount = $withdrawal->amount;
            $deposit->save(false); // skip validation as model is already validated
            $withdrawal->save(false);


            $withdrawalAccountModel = Account::find()
                ->where('id = :accountId', [':accountId' => $withdrawal->accountId])
                ->one();
            $withdrawalAccountModel->amount -= $deposit->amount;
            $withdrawalAccountModel->save();

            $depositAccountModel = Account::find()
                ->where('id = :accountId', [':accountId' => $deposit->accountId])
                ->one();
            $depositAccountModel->amount += $withdrawal->amount;
            $depositAccountModel->save();

            return $this->redirect(['index']);

        } else {

            return $this->render('transfer', [
                'deposit' => $deposit,
                'withdrawal' => $withdrawal
            ]);

        }

    }

    /**
     * Updates an existing Log model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Log model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
}
