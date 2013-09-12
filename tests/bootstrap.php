<?php
/**
 * Sets up an environment to emulate a webserver environment
 * 
 * Copyright ©2013 SURFsara b.v., Amsterdam, The Netherlands
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at <http://www.apache.org/licenses/LICENSE-2.0>
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * 
 * @package DAV
 * @subpackage tests
 */

require_once( dirname( dirname( __FILE__ ) ) . '/lib/bootstrap.php' );
DAV::$testMode = true; // Turn on test mode, so headers won't be sent, because sending headers won't work as all tests are run from the commandline

$_SERVER = array();
$_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.1';
$_SERVER['SCRIPT_NAME'] = 'bootstrap.php'; // Strange enough, PHPunit seems to use this, so let's set it to some value


/**
 * A copy of the key-value cache so the real DAV_Cache won't be loaded
 * 
 * This copy doesn't function and will always return NULL for each value. This
 * is useful for testing purposes
 * 
 * @internal
 * @package DAV
 * @subpackage tests
 */
class DAV_Cache {
  
  /**
   * @var  DAV_Cache  All created caches
   */
  private static $instance = null;
  
  
  /**
   * The constructor is private as part of the singleton pattern
   */
  private function __construct(){
  }
  
  
  /**
   * Returns always the only instance of this class
   * 
   * @param   string     $cacheName  The name of the cache
   * @return  DAV_Cache              The requested cache
   */
  public static function inst( $cacheName ) {
    if ( is_null( self::$instance ) ) {
      $class = get_called_class();
      self::$instance = new $class();
    }
    return self::$instance;
  }

  /**
   * Always returns NULL, as this class doesn't actually cache anything
   * 
   * @param   string  $key  The key to return the value for
   * @return  mixed         The value from cache or NULL when the key doesn't exist
   */
  public function get( $key ) {
    return null;
  }

  /**
   * Doesn't do anything
   * 
   * @param   string  $key    The key for which to set the value
   * @param   mixed   $value  The value to set
   * @return  void
   */
  public function set( $key, $value ) {
  }

} // DAV_Cache


class DAV_Test_Registry implements DAV_Registry {
  
  private $resourceClass = 'DAV_Resource';
  
  
  public function setResourceClass( $resource ) {
    $this->resourceClass = $resource;
  }
  

  public function resource( $path ) {
    return new $this->resourceClass( $path );
  }


  public function forget( $path ) {
  }


  public function shallowLock( $write_paths, $read_paths ) {
  }


  public function shallowUnlock() {
  }
  
} // DAV_Test_Registry
DAV::$REGISTRY = new DAV_Test_Registry();


class DAVACL_Test_ACL_Provider implements DAVACL_ACL_Provider {
  
  public function user_prop_acl_restrictions() {
    return array();
  }

  public function user_prop_current_user_principal() {
    return '/path/to/current/user';
  }

  public function user_prop_principal_collection_set() {
    return array( '/path/to/current/user' );
  }
  
  
  private $supportedPrivilegeSet = array();
  
  
  public function setSupportedPrivilegeSet( $supportedPrivilegeSet ) {
    $this->supportedPrivilegeSet = $supportedPrivilegeSet;
  }
  

  public function user_prop_supported_privilege_set() {
    return $this->supportedPrivilegeSet;
  }
  
} // DAVACL_Test_ACL_Provider
DAV::$ACLPROVIDER = new DAVACL_Test_ACL_Provider();

// End of file