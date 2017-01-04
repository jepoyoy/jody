<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "employee".
 *
 * @property integer $employee_id
 * @property string $email
 * @property string $fname
 * @property string $lname
 * @property string $password
 * @property string $mobile
 * @property string $activation_key
 * @property boolean $is_admin
 *
 * @property RouteReceipts[] $routeReceipts
 * @property TripEmployee[] $tripEmployees
 */
class Employee extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employee';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'password', 'is_admin'], 'required'],
            [['email'], 'string', 'max' => 150],
            [['fname', 'lname'], 'string', 'max' => 100],
            [['password'], 'string', 'max' => 15],
            [['mobile'], 'string', 'max' => 30],
            [['activation_key'], 'string', 'max' => 50]
        ];
    }

    public function getFullname(){
        return  $this->fname.' '. $this->lname;
    }

    public function isAdmin(){
        return $this->is_admin;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'employee_id' => 'Employee ID',
            'email' => 'Email',
            'fname' => 'First Name',
            'lname' => 'Last Name',
            'password' => 'Password',
            'mobile' => 'Mobile Number',
            'is_admin' => 'Is employee an admin?',
            'activation_key' => 'Activation Key (for registration)',
        ];
    }

    public function getUsername(){
        return $this->email;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRouteReceipts()
    {
        return $this->hasMany(RouteReceipts::className(), ['employee_id' => 'employee_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTripEmployees()
    {
        return $this->hasMany(TripEmployee::className(), ['employee_id' => 'employee_id']);
    }

     public static function checkLogin($email, $password)
      {
        $identity = static::findOne(['email' => $email, 'password' => $password]);
        if($identity){
            return true;
        }

        return false;
      }

    /**
     * @inheritdoc
     * @return EmployeeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EmployeeQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
          return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }


    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->employee_id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
}
