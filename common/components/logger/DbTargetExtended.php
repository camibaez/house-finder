<?php
/**
 * Created by PhpStorm.
 * User: El Teta
 * Date: 28/11/2016
 * Time: 22:01
 */

namespace common\components\logger;


use Yii;

class DbTargetExtended extends \yii\log\DbTarget
{
    public $views = [];

    /**
     * Stores log messages to DB.
     */
    public function export()
    {

        $tableName = $this->db->quoteTableName($this->logTable);
        $sql = "INSERT INTO $tableName ([[level]], [[category]], [[log_time]], user, ip, [[message]])
                VALUES (:level, :category, :log_time, :user, :ip, :message)";
        $command = $this->db->createCommand($sql);
        foreach ($this->messages as $message) {
            list($text, $level, $category, $timestamp) = $message;

            if (!is_string($text)) {
                // exceptions may not be serializable if in the call stack somewhere is a Closure
                if ($text instanceof \Exception) {
                    $text = (string)$text;
                } else {
                    $text = VarDumper::export($text);
                }
            }

            if ($category == 'application')
                continue;
            if (strpos($category, 'statistics\views') == 0) {

                //$text = substr($text, strpos($text, "|") + 1);
                
            }


            $command->bindValues([
                ':level' => $level,
                ':category' => $category,
                ':log_time' => $timestamp,
                ':user' => $this->getUserId(),
                ':message' => $text,
                ':ip' => Yii::$app->request->getUserIP()
            ])->execute();
        }
    }

    public function getUserId()
    {
        /* @var $user \yii\web\User */
        $user = Yii::$app->has('user', true) ? Yii::$app->get('user') : null;
        if ($user && ($identity = $user->getIdentity(false))) {
            $userID = $identity->getId();
        } else {
            $userID = '-';
        }
        return $userID;
    }
}