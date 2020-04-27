<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace backend\controllers;

use backend\models\LoginModel;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * Description of EvaluationController
 *
 * @author User
 */
class EvaluationController extends \yii\web\Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['update-parameters', 'run-evaluation', 'test'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
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
        ];
    }

    public function actionUpdateParameters() {
        $model = \backend\models\ConfigurationModel::findOne(['id' => 'main']);

        if ($model->load(Yii::$app->request->post()))
            if (!$model->save())
                Yii::$app->session->addFlash("parameters-error", "Error saving parameters");

        return $this->render('update-parameters', [
                    'model' => $model,
        ]);
    }

    public function actionRunEvaluation() {
        $imagesValue = \backend\models\ConfigurationModel::findOne(['id' => 'main'])->image;
        $imagesCountSql = "SELECT COUNT(*) AS i_count FROM sale_image "
                . "WHERE sale_id IN (SELECT id FROM house WHERE site_id = :site_id) "
                . "GROUP BY sale_id "
                . "ORDER BY i_count DESC";
        
        $updateSql = "UPDATE house SET rank = calc_abs_img_rank(house.id, :max_count, :image_value) "
        . "WHERE site_id = :site";

        //Revolico evaluation
        $maxImages = \Yii::$app->db->createCommand($imagesCountSql, [":site_id" => "Revolico"])->queryScalar();
        \Yii::$app->db->createCommand($updateSql, [
            ':max_count' => $maxImages,
            ':image_value' => $imagesValue,
            ':site' => "Revolico"
            ])->execute();
        
         //Cubisima evaluation
        $maxImages = \Yii::$app->db->createCommand($imagesCountSql, [":site_id" => "Cubisima"])->queryScalar();
        \Yii::$app->db->createCommand($updateSql, [
            ':max_count' => $maxImages,
            ':image_value' => $imagesValue,
            ':site' => "Cubisima"
            ])->execute();
        
         //Detras fachada
        $maxImages = \Yii::$app->db->createCommand($imagesCountSql, [":site_id" => "Detras de la Fachada"])->queryScalar();
        \Yii::$app->db->createCommand($updateSql, [
            ':max_count' => $maxImages,
            ':image_value' => $imagesValue,
            ':site' => "Detras de la Fachada"
            ])->execute();
        
        
        return $this->redirect("update-parameters");
        
    }
    
    public function actionTest(){
        $params = \backend\models\ConfigurationModel::findOne(['id' => 'main']);
        $command = "SET @price_pivot := {$params->price_pivot}, @r_price := {$params->r_price}";
        
        \Yii::$app->db->createCommand($command)->execute();
        return \Yii::$app->db->createCommand("SELECT @price_pivot")->queryScalar();
    }

}
