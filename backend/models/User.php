<?php
/**
 * Created by PhpStorm.
 * User: El Teta
 * Date: 03/03/2017
 * Time: 23:39
 */

namespace backend\models;


class User extends \common\models\User{
    /**
     * @inheritdoc
     */
    public static function findIdentity($name) {
        return static::findOne(['username' => $name, 'status' => self::STATUS_ADMIN]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return User
     */
    public static function findByUsername($username, $status = 1)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token) {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ADMIN,
        ]);
    }
} 