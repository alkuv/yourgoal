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
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
          // echo $this->username;
         // echo  $this->password;
		$user = Admin::model()->findByAttributes(array('email' => $this->username));
             //   echo '<pre>'; print_r($user);
               // die("eddie");
		if($user===null)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		 else if($user->password !== $this->password)
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
		{
			$this->_id=$user->id;
			$this->username=$user->username;
			$this->errorCode=self::ERROR_NONE;
                        $this->setState('user_id', $user->id);
		}
		return $this->errorCode==self::ERROR_NONE;
	}

	/**
	 * @return integer the ID of the user record
	 */
	public function getId()
	{
		return $this->_id;
	}
}