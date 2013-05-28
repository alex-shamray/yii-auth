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
	 * Logs in the user.
	 * @return boolean whether login is successful
	 */
	public function login();
	/**
	 * @return string the permalink URL for this user's profile
	 */
	public function getProfileUrl();
	/**
	 * Returns a value indicating whether the user is active.
	 * @return boolean whether the current application user is active.
	 */
	public function getIsActive();
	/**
	 * Finds a single active record with the specified username.
	 * @param string $username username value.
	 * @return IUser the record found. Null if none is found.
	 */
	public function findByUsername($username);
	public function changePassword($password);
	public function updateActivationKey();
}