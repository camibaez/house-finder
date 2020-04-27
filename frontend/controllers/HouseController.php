<?php

namespace frontend\controllers;

use common\models\House;
use common\models\HouseSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * HouseController implements the CRUD actions for House model.
 */
class HouseController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'save-favs' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionSearch() {
        $searchModel = new HouseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $searchModel->saveSearch();

        return $this->render('index', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
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

    public function actionFavsIndex() {
        $this->layout = 'normal';

        $favs = isset($_COOKIE['favs-ids']) ? $_COOKIE['favs-ids'] : '';
        $favs = explode(",", $favs);

        $query = (new Query())->from("house_join");
        if ($favs)
            $query->where(['IN', 'id', $favs]);
        else {
            $query->where("1=0");
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 16,
            ],
        ]);

        return $this->render('favs_index', ['dataProvider' => $dataProvider]);
    }

    public function actionSaveFavs() {
        $model = new \common\models\SaveListForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $ids = isset($_COOKIE['favs-ids']) ? $_COOKIE['favs-ids'] : '';
            $ids = explode(",", $ids);
            $model->favs = $ids;
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('info', 'Tu lista de favoritos ha sido enviada a tu correo.');
            } else {
                Yii::$app->session->setFlash('error', 'Se produjo un error salvando la lista de favoritos. Comprueba tu correo');
            }
        }
        return $this->redirect('favs-index');
    }

    public function actionAddFav($id) {
        $user = \Yii::$app->user->id;
        return \Yii::$app->db->createCommand()->insert("fav_ads", ['username' => $user, 'house_id' => $id])->execute();
    }

    public function actionRemoveFav($id) {
        $user = \Yii::$app->user->id;
        return \Yii::$app->db->createCommand()->delete("fav_ads", ['username' => $user, 'house_id' => $id])->execute();
    }

    public function actionLocationsList($q = null) {
        $query = new Query();

        $query->select('name')
                ->from('locations_values')
                ->where('name LIKE "%' . $q . '%"');

        $command = $query->createCommand();
        $data = $command->queryAll();
        $out = [];
        foreach ($data as $d) {
            $out[] = ['value' => $d['name']];
        }
        echo Json::encode($out);
    }

    public function actionGraphics() {
        $searchModel = new HouseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $query = $dataProvider->query;

        $total = $query->count();

        $sitesDistribData = Query::create($query)
                        ->select(["site_id", "COUNT(id) AS h_count"])
                        ->orderBy("h_count DESC")
                        ->groupBy("site_id")->all();
        $sitesData = \yii\helpers\ArrayHelper::map($sitesDistribData, 'site_id', 'h_count');

        $pricesData = Query::create($query)
                        ->select(["p_price" => '(price DIV 10000)', ' r_price' => '(price DIV 10000 + 1) * 10', "c" => '(COUNT(id))'])
                        ->andWhere(['<=', 'price', 170000])
                        ->groupBy("p_price")
                        ->orderBy("")->all();
        $prices = \yii\helpers\ArrayHelper::map($pricesData, 'r_price', 'c');

        $datesData = Query::create($query)
                        ->select([
                            "COUNT(id) AS d_count",
                            "YEAR(FROM_UNIXTIME(created_at)) AS y",
                            "MONTH(FROM_UNIXTIME(created_at)) AS m",
                            "CONCAT(YEAR(FROM_UNIXTIME(created_at)), '/', MONTH(FROM_UNIXTIME(created_at))) AS s_date"
                        ])
                        //->andWhere(['>=', 'y', "2016"])
                        ->orderBy('y', 'm')
                        ->groupBy(['y', 'm'])->all();
        //->orderBy("y, m");
        $dates = $datesData;


        return $this->render('graphics', [
                    'total' => $total,
                    'sitesData' => $sitesData,
                    'prices' => $prices,
                    'searchModel' => $searchModel,
                    'dates' => $dates]);
    }
	
	public function actionRedirecter($url = null){
		if($url != null)
			return $this->redirect($url);
		else return $this->goHome();
	}

}
