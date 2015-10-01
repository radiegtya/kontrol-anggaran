<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {

    private $_id; //set id untuk unique identifier

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */

    public function authenticate() {
        $user = User::model()->findByAttributes(array('username' => $this->username)); //inputan username dicari di database
        if ($user === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID; //jika tidak ada maka tampilkan error
        } else {
            if ($user->password !== $user->encrypt($this->password)) { //jika user password tidak sama
                $this->errorCode = self::ERROR_PASSWORD_INVALID; //maka tampilkan error
            } else {
                $this->_id = $user->id; //set id berdasarkan user_id
                if (null === $user->last_login_time) { //set last login time
                    $lastLogin = time();
                } else {
                    $lastLogin = strtotime($user->last_login_time);
                }
                $this->setState('lastLoginTime', $lastLogin); //setState agar dapat diakses di public var
                $this->errorCode = self::ERROR_NONE;
            }
        }
        return !$this->errorCode; //return error apabila ada
    }

    public function getId() {
        return $this->_id;
    }

}