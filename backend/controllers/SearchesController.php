<?php

namespace backend\controllers;

use Yii;
use backend\models\Searches;
use backend\models\SearchesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SearchesController implements the CRUD actions for Searches model.
 */
class SearchesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Searches models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $datesDataRaw = (new \yii\db\Query())->from('searches')
                        ->select([
                            "COUNT(id) AS d_count",
                            "YEAR(FROM_UNIXTIME(created_at)) AS y",
                            "MONTH(FROM_UNIXTIME(created_at)) AS m",
                            "CONCAT(YEAR(FROM_UNIXTIME(created_at)), '/', LPAD(MONTH(FROM_UNIXTIME(created_at)), 2, '0')) AS s_date"
                        ])
                        ->orderBy('s_date')
                        ->groupBy(['y', 'm'])->all();
        $datesData = (new \yii\db\Query())->from(['t_s' => "(SELECT * FROM searches GROUP BY hash)"])
                        ->select([
                            "COUNT(id) AS d_count",
                            "YEAR(FROM_UNIXTIME(created_at)) AS y",
                            "MONTH(FROM_UNIXTIME(created_at)) AS m",
                            "CONCAT(YEAR(FROM_UNIXTIME(created_at)), '/', LPAD(MONTH(FROM_UNIXTIME(created_at)), 2, '0')) AS s_date"
                        ])
                        ->orderBy('s_date')
                        ->groupBy(['y', 'm'])->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dates' => $datesData,
            'datesRaw' => $datesDataRaw
        ]);
    }

    /**
     * Displays a single Searches model.
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
     * Creates a new Searches model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Searches();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Searches model.
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
     * Deletes an existing Searches model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Searches model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Searches the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Searches::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
