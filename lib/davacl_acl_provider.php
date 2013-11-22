<?php

/*·************************************************************************
 * Copyright ©2007-2011 Pieter van Beek, Almere, The Netherlands
 * 		    <http://purl.org/net/6086052759deb18f4c0c9fb2c3d3e83e>
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
 * $Id: davacl_acl_provider.php 3364 2011-08-04 14:11:03Z pieterb $
 **************************************************************************/

/**
 * File documentation (who cares)
 * @package DAVACL
 */

/**
 * Some class.
 * @package DAVACL
 */
interface DAVACL_ACL_Provider {


/**
 * Return all ACL restrictions
 * 
 * @return array of predefined restrictions and (optionally) an array of
 *   required principals.
 */
public function user_prop_acl_restrictions();


/**
 * Return the principal of the currently logged in user
 * 
 * @return string path
 */
public function user_prop_current_user_principal();


/**
 * Return a set of URLs that identify the root collections that contain the principals that are available
 * 
 * @return array an array of paths
 */
public function user_prop_principal_collection_set();


/**
 * Return all privileges supported by this server
 * 
 * @return array of DAVACL_Element_supported_privilege objects.
 */
public function user_prop_supported_privilege_set();


}
