<?php

//
// Open Web Analytics - An Open Source Web Analytics Framework
//
// Copyright 2006 Peter Adams. All rights reserved.
//
// Licensed under GPL v2.0 http://www.gnu.org/copyleft/gpl.html
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.
//
// $Id$
//

/**
 * OWA Configuration
 * 
 * @author      Peter Adams <peter@openwebanalytics.com>
 * @copyright   Copyright &copy; 2006 Peter Adams <peter@openwebanalytics.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GPL v2.0
 * @category    owa
 * @package     owa
 * @version		$Revision$	      
 * @since		owa 1.0.0
 */
 
/**
 * DATABASE CONFIGURATION
 *
 * Connection info for databases that will be used by OWA. 
 *
 */

define('OWA_DB_TYPE', 'mysql'); // options: mysql
define('OWA_DB_NAME', 'openwebanalytics-3231342d7f'); // name of the database
define('OWA_DB_HOST', 'sdb-x.hosting.stackcp.net'); // host name of the server housing the database
define('OWA_DB_USER', 'openwebanalytics-3231342d7f'); // database user
define('OWA_DB_PASSWORD', 'b85d4d99de44'); // database user's password

/**
 * AUTHENTICATION KEYS AND SALTS
 *
 * Change these to different unique phrases.
 */
define('OWA_NONCE_KEY', '<=ytgK|zr}H/-u2;4I.E-irQ&D$1#FF_$#Ue>YXYXP&[i=N=%iL:)uL^2Z3^(}dj');  
define('OWA_NONCE_SALT', '|kcHsRh)tSU({c?. O.Gu-bq+>IetM3_D.Hy&qg}T7EL@q.@=1YldyVTy05|0Y2u');
define('OWA_AUTH_KEY', 'mO6mb_`[rkqCt_Sh!Ka-n:C?sMePjzq`c!U)cP0}Y $;f*{kNAO@>%L4V@:EScs@');
define('OWA_AUTH_SALT', ';ux4c]:+(H]3@tWf9OAz<SW4oF^76<>/#<s01)@,(aX*E5;D:_(~aPRZ>b6y~[c?');

/** 
 * PUBLIC URL
 *
 * Define the URL of OWA's base directory e.g. http://www.domain.com/path/to/owa/ 
 * Don't forget the slash at the end.
 */
 
define('OWA_PUBLIC_URL', 'http://tasaciones-labrujita.online/tasaciones-labrujita.online/');  

/** 
 * OWA ERROR HANDLER
 *
 * Overide OWA error handler. This should be done through the admin GUI, but 
 * can be handy during install or development. 
 * 
 * Choices are: 
 *
 * 'production' - will log only critical errors to a log file.
 * 'development' - logs al sorts of useful debug to log file.
 */

//define('OWA_ERROR_HANDLER', 'development');

/** 
 * LOG PHP ERRORS
 *
 * Log all php errors to OWA's error log file. Only do this to debug.
 */

//define('OWA_LOG_PHP_ERRORS', true);
 
/** 
 * OBJECT CACHING
 *
 * Override setting to cache objects. Caching will increase performance. 
 */

//define('OWA_CACHE_OBJECTS', true);

/**
 * CONFIGURATION ID
 *
 * Override to load an alternative user configuration
 */
 
//define('OWA_CONFIGURATION_ID', '1');


?>