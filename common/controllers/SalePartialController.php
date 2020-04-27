<?php

namespace common\controllers;

use common\components\dependent\ElementsListAction;
use common\models\Municipality;
use common\models\Neighborhood;
use Yii;
use common\models\SalePartial;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SalePartialController implements the CRUD actions for SalePartial model.
 */
class SalePartialController extends Controller
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
     * Deletes an existing SalePartial model.
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
     * Finds the SalePartial model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SalePartial the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SalePartial::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
