<?php

interface IUser
{
	/**
	 * Checks if the given password is correct.
	 * @param string the password to be validated
	 * @return boolean whether the password is valid
	 */
	public function validatePassword($password);
	/**
	 * Checks if the given activation key is correct.
	 * @param string the activation key to be validated
	 * @return boolean whether the activation key is valid
	 */
	public function validateActivationKey($key);
	/**
	 * Activates a user.
	 */
	public function activate();
	/**
	 * Returns a value indicating whether the user is active.
	 * @return boolean whether the current application user is active.
	 */
	public function getIsActive();
	/**
	 * Finds a single active record with the specified username.
	 * See {@link find()} for detailed explanation about $condition and $params.
	 * @param mixed $username username value.
	 * @param mixed $condition query condition or criteria.
	 * @param array $params parameters to be bound to an SQL statement.
	 * @return IUser the record found. Null if none is found.
	 */
	public function findByUsername($username,$condition='',$params=array());
	public function changePassword($password);
	public function updateActivationKey();
}