<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\models;

/**
 * Description of SaveListForm
 *
 * @author User
 */
class SaveListForm extends \yii\base\Model {

    public $email;
    public $verifyCode;
    public $favs;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            // username and password are both required
            ['email', 'required'],
            ['email', 'email'],
            ['verifyCode', 'captcha'],
            //['favs', 'safe']
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param  string  $email the target email address
     * @return boolean whether the email was sent
     */
    public function sendEmail() {
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => House::find()->where(['IN', 'id', $this->favs])->limit(10)
        ]);
        return \Yii::$app->mailer->compose('favorites-list-html', ['dataProvider' => $dataProvider])
                        ->setTo($this->email)
                        ->setFrom(["noreply@venderor.com" => "Venderor.com"])
                        ->setSubject('Listado de favoritos')
                        ->send();
    }

}
