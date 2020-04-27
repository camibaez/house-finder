<?php
/**
 * Created by PhpStorm.
 * User: El Teta
 * Date: 02/01/2017
 * Time: 19:47
 */

namespace backend\controllers;


use common\components\dependent\ElementsListAction;
use common\models\Municipality;
use common\models\Neighborhood;
use common\models\SalePartial;
use Yii;
use yii\data\ActiveDataProvider;

class SalePartialController extends \common\controllers\SalePartialController
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'municipalities' => [
                'class' => ElementsListAction::className(),
                'tableName' => Municipality::tableName(),
                'parentAttr' => 'province_id'
            ],
            'neighborhoods' => [
                'class' => ElementsListAction::className(),
                'tableName' => Neighborhood::tableName(),
                'parentAttr' => 'municipality_id'
            ],
        ];
    }


    /**
     * Lists all SalePartial models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => SalePartial::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SalePartial model.
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
     * Creates a new SalePartial model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SalePartial();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionSendEmails()
    {
        $query = SalePartial::find()->where(['status' => SalePartial::NONE_STATUS])->andWhere(['not', ['email' => ""]]);
        $messages = [];
        foreach ($query->each(100) as $partial) {
            $message = \Yii::$app->mailer->compose(['html' => 'partialSales-html'], ['model' => $partial]);

            $message->setTo($partial->email)
                ->setSubject("Sevende - Registra tu casa")
                ->setFrom(\Yii::$app->params['usersSupportEmail']);
            $messages[] = $message;
        }
        \Yii::$app->mailer->sendMultiple($messages);
        Yii::$app->db->createCommand()->update(SalePartial::tableName(), ['status' => SalePartial::SENT_STATUS], ['status' => SalePartial::NONE_STATUS])->execute();

        return $this->redirect('index');
    }

    /**
     * Updates an existing SalePartial model.
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
} 