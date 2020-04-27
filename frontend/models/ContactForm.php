<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [[ 'body'], 'required'],
            // email has to be a valid email address
            //['email', 'email'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Nombre',
            'body' => 'Mensaje',
            'verifyCode' => 'Verification Code',
        ];
    }
    
    public function saveMessage(){
        return Yii::$app->db->createCommand()->insert('contact', ['text' => $this->body, 'created_at' => time()])->execute();
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param  string  $email the target email address
     * @return boolean whether the email was sent
     */
    public function sendEmail($email)
    {
        return Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom($this->email)
            ->setSubject($this->subject)
            ->setTextBody($this->body)
            ->send();
    }
}
