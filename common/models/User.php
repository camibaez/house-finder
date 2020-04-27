<?php

namespace common\models;

use frontend\models\UserValidation;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string displayname
 * @property string $password write-only password
 * @property string $phone
 * @property string $first_name
 * @property string $last_name
 */
class User extends ActiveRecord implements IdentityInterface {
    const ADMIN_ROLE = 'admin';
    const DESIGNER_ROLE = 'designer';
    const USER_ROLE = 'user';


    const SCENARIO_SIGNUP = 'signup';
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    const SCENARIO_UPDATE_ADMIN = 'update-admin';

    const STATUS_DELETED = 0;
    const STATUS_ADMIN = 1;
    const STATUS_ACTIVE = 10;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'user';
    }


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'compare', 'compareValue' => self::STATUS_DELETED, 'operator' => '>='],
            ['status', 'compare', 'compareValue' => self::STATUS_ACTIVE, 'operator' => '<='],
        ];
    }



    /**
     * @inheritdoc
     */
    public static function findIdentity($name) {
        return static::findOne(['username' => $name, 'status' => self::STATUS_ACTIVE]);
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
    public static function findByUsername($username, $status = null)
    {
        $status = $status === null ? self::STATUS_ACTIVE : $status;
        return static::findOne(['username' => $username, 'status' => $status]);
    }

    public static function findByDisplayName($displayName) {
        return static::findOne(['displayname' => $displayName, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findByEmail($email){
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
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
                    'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token) {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }



    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    public function generateUsername(){
        $this->username = $this->email.time();
    }
    
    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken() {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken() {
        $this->password_reset_token = null;
    }

    public function assignRole($roleName) {
        $auth = Yii::$app->authManager;
        $authRole = $auth->getRole($roleName);
        return $auth->assign($authRole, $this->getId());
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * Populates the user model using the values in the validation model
     * @param $userValidationModel UserValidation
     */
    public function getValuesFromValidationModel($userValidationModel) {
        /*
        $array = $userValidationModel->toArray($userValidationModel->scenarios()[$userValidationModel->scenario]);
        $this->load($array);
        */

        $this->displayname = $userValidationModel->displayname;
        $this->email = $userValidationModel->email;
        $this->generatePasswordHash($userValidationModel->password);
        $this->generateAuthKey();

        if($userValidationModel->scenario == User::SCENARIO_CREATE) {
            $this->displayname = $userValidationModel->username;
            $this->setUsername($userValidationModel->username);
        }


    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function generatePasswordHash($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates the username adding the timestamp to it
     * @param $value The username value
     * @param bool $direct
     */
    public function setUsername($value, $direct = false){
        $this->username = $value.time();

    }

    public function getRoleName()
    {
        $assignments = Yii::$app->authManager->getAssignments($this->username);
        return array_keys($assignments)[0];
    }

    public function getStatusName(){
        return self::statusNameMap()[$this->status];
    }

    public static function statusNameMap()
    {
        return [
            self::STATUS_DELETED => "Deleted",
            self::STATUS_ACTIVE => "Active",
        ];
    }

 
}
