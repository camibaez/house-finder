<?php

namespace backend\controllers;

use Yii;
use common\models\House;
use common\models\HouseSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * HouseController implements the CRUD actions for House model.
 */
class HouseController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionSearchUnsafe() {

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => (new \yii\db\Query())->from('house')->where(["<>", 'status', 2])
        ]);

        return $this->render('unsafe_index', ['dataProvider' => $dataProvider]);
    }

    public function actionSearch() {
        $searchModel = new \backend\models\HouseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, true);

        return $this->render('index', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
    }

    public function actionReview($id = null) {
        if ($id) {
            $model = \backend\models\House::findOne($id);
        } else {
            $model = \backend\models\House::find()->where(['reviewed' => 0])->orderBy("site_id DESC")->limit(1)->one();
        }


        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $post['House']['province_id'] = explode("|", $post['House']['province_id'])[0];
            $post['House']['municipality_id'] = explode("|", $post['House']['municipality_id'])[0];
            $post['House']['neighborhood_id'] = explode("|", $post['House']['neighborhood_id'])[0];

            $model->reviewed = 1;

            if ($model->load($post) && $model->save()) {
                House::saveThumb($model->id);
                return $this->redirect('review');
            } else {
                Yii::$app->session->addFlash("Error en review");
                return $this->redirect('review');
            }
        }
        return $this->render('review', ['model' => $model]);
    }

    public function actionLocations($q = null, $l = 1) {
        $query = new \yii\db\Query();
        $locs = [1 => 'province', 2 => 'municipality', 3 => 'neighborhood'];
        $query->from($locs[$l]);
        $query->select(['valname' => 'CONCAT(id, "|", name)'])->where('name LIKE "%' . $q . '%"');

        $command = $query->createCommand();
        $data = $command->queryAll();
        $out = [];
        foreach ($data as $d) {
            $out[] = ['value' => $d['valname']];
        }
        echo \yii\helpers\Json::encode($out);
    }

    /**
     * Displays a single House model.
     * @param integer $id
     * @param string $site
     * @return mixed
     */
    public function actionView($id, $site) {

        return $this->render('view', [
                    'model' => $this->findModel($id, $site),
        ]);
    }

    /**
     * Creates a new House model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new House();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'site_id' => $model->site_id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing House model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param string $site_id
     * @return mixed
     */
    public function actionUpdate($id, $site_id) {
        $model = $this->findModel($id, $site_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'site_id' => $model->site_id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing House model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param string $site_id
     * @return mixed
     */
    public function actionDelete($id, $site_id) {
        $this->findModel($id, $site_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the House model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param string $site_id
     * @return House the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $site_id) {
        if (($model = House::findOne(['id' => $id, 'site_id' => $site_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
