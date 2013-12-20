<?php
/**
 * DokuWiki Plugin authexternal (Auth Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  Pras Velagapudi <pkv@cs.cmu.edu>
 */

// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

class auth_plugin_authexternal extends DokuWiki_Auth_Plugin {

    /**
     * Constructor.
     */
    public function __construct() {
        parent::__construct(); // for compatibility

	// Set authentication capabilities.
        $this->cando['external']    = true; // this module does external auth checking.
        $this->cando['logout']      = false; // the user can't log out again.

        // Initialize the auth system and set success to true.
        $this->success = true;
    }

    /**
     * Do all authentication 
     *
     * @param   string  $user    Username
     * @param   string  $pass    Cleartext Password
     * @param   bool    $sticky  Cookie should not expire
     * @return  bool             true on successful auth
     */
    public function trustExternal($user, $pass, $sticky = false) {
        global $USERINFO;
        global $conf;

	$USERINFO['name'] = $_SERVER['PHP_AUTH_USER'];
    	$USERINFO['mail'] = $_SERVER['PHP_AUTH_USER'] . '@' . $_SERVER['HTTP_HOST'];
	$USERINFO['grps'] = array('user');
    	$_SERVER['REMOTE_USER'] = $user;
    	return true;
    }

    /**
     * Return user info
     *
     * Returns info about the given user needs to contain
     * at least these fields:
     *
     * name string  full name of the user
     * mail string  email addres of the user
     * grps array   list of groups the user is in
     *
     * @param   string $user the user name
     * @return  array containing user data or false
     */
    public function getUserData($user) {
        return false;
    }

    /**
     * Return case sensitivity of the backend
     *
     * When your backend is caseinsensitive (eg. you can login with USER and
     * user) then you need to overwrite this method and return false
     *
     * @return bool
     */
    public function isCaseSensitive() {
        return true;
    }

    /**
     * Sanitize a given username
     *
     * This function is applied to any user name that is given to
     * the backend and should also be applied to any user name within
     * the backend before returning it somewhere.
     *
     * This should be used to enforce username restrictions.
     *
     * @param string $user username
     * @return string the cleaned username
     */
    public function cleanUser($user) {
        return $user;
    }

    /**
     * Sanitize a given groupname
     *
     * This function is applied to any groupname that is given to
     * the backend and should also be applied to any groupname within
     * the backend before returning it somewhere.
     *
     * This should be used to enforce groupname restrictions.
     *
     * Groupnames are to be passed without a leading '@' here.
     *
     * @param  string $group groupname
     * @return string the cleaned groupname
     */
    public function cleanGroup($group) {
        return $group;
    }
}

// vim:ts=4:sw=4:et: