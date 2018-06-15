<?php
namespace Twitter\Auth;



/**
 * @class Auth
 *
 * This class authenticates the user and performs authorziation functions. Meant to be subclassed for specific
 * login needs.
 */
abstract class Auth {



	/**
	 * Check if a user is logged in
	 */
	abstract public function isLoggedIn();



	/**
	 * Login the user
	 */
	abstract public function login();



	/**
	 * Logout the user
	 */
	abstract public function logout();



	/**
	 * Get username of the logged in user
	 */
	abstract public function getUserName();



	/**
	 * Perform any special authorization
	 */
	abstract public function specialAuthorization();
}