<?php
/**
 * Created by PhpStorm.
 * User: El Teta
 * Date: 25/10/2016
 * Time: 23:38
 */

namespace backend\models;


use Yii;
use yii\base\Model;

class LoginModel extends Model
{

    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;


    public function rules()
    {

        return [
            [['password'], 'required'],
            ['password', 'string', 'min' => 4],

            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];

    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if($this->password != "sinqo2017venderor")
            $this->addError($attribute, 'Incorrect password.');
            
        
        
        
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername("admin");
        }

        return $this->_user;
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        return false;
    }


} 