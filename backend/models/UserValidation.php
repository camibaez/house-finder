<?php
namespace backend\models;

use backend\models\User;
use Yii;


class UserValidation extends \yii\base\Model
{
    const userClassPath = '\common\models\User';
    public $username;
    public $password;
    public $password_repeat;

    public function rules()
    {

        return [
            [['password', 'username'], 'required'],
            ['username', 'string', 'min' => 3],
            ['password', 'string', 'min' => 4],

            ['password_repeat', 'required'],
            ['password_repeat', 'string', 'min' => 4],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'No coincide la verificación de la contraseña'],
        ];

    }

    public function signup()
    {
        if ($this->validate()) {;
            $user = $this->createUser();
            $transaction = Yii::$app->db->beginTransaction();

            if ($user->save()) {
                if (!$user->assignRole('admin')) {
                    $transaction->rollBack();
                    return null;
                }

                $transaction->commit();
                return $user;
            }

        }

        return null;
    }

    public function createUser()
    {
        $user = new User();
        $user->username = $this->username;
        $user->displayname = $this->username;
        $user->status = User::STATUS_ADMIN;


        $user->generatePasswordHash($this->password);
        $user->generateAuthKey();

        return $user;
    }
}