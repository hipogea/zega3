<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{

    private $_id;

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    public function authenticate()
    {
        $users = array(
            'demo1' => array('password'=>'demo1', 'id'=>11),
            'demo2' => array('password'=>'demo2', 'id'=>12),
            'demo3' => array('password'=>'demo3', 'id'=>13),
            'demo4' => array('password'=>'demo4', 'id'=>14),
            'admin' => array('password'=>'admin', 'id'=>1),
        );
        if (!isset($users[$this->username]))
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        else if ($users[$this->username]['password'] !== $this->password)
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        else
        {
            $this->_id = $users[$this->username]['id'];
            
            $this->setState('isAdmin', (int)($this->_id === 1));

            $this->errorCode = self::ERROR_NONE;
        }
        return!$this->errorCode;
    }

    /**
     * @return integer the ID of the user record
     */
    public function getId()
    {
        return $this->_id;
    }
}