<?php

namespace backend\controllers;

use backend\models\ConfigurationModel;
use common\components\matchmaker\MatchmakerDataTable;
use yii\base\ErrorException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;

class MatchmakerController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [

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


    public function actionMain()
    {
        $configModel = new ConfigurationModel();
        $configModel->loadData();
        if($configModel->load(\Yii::$app->request->post()) && $configModel->validate()){
            $configModel->updateData();
        }

        return $this->render('main', ['model' => $configModel]);
    }

    public function actionSetAlive($alive = true){
        MatchmakerDataTable::setMatchingDaemonRunning($alive);

        if($alive) $this->createDaemon();

        $this->redirect('main');


    }

    protected function createDaemon(){
        $pos = stripos(__DIR__, "backend");
        $path = substr(__DIR__, 0, $pos);
        $path .= "yii";
        $args = "manage/run-matching-agent";
        $command = "php $path $args";
        exec($command);


        /*
        $pid = pcntl_fork();
        if($pid == -1)
            throw new ErrorException("Error creando el demonio");
        if($pid == 0) {
            exec($command);
            exit;
        }
        */



    }



}
