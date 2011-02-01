<?php
/**
 * @package    TwitterCollage
 * @subpackage server
 * @version    v.0.4
 * @author     Andre Torgal <andre@quodis.com>
 * @license    http://www.opensource.org/licenses/bsd-license.php BSD License
 */

/**
 * escape from global scope
 */
function main()
{
	DEFINE('CLIENT', 'script');
	DEFINE('CONTEXT', __FILE__);
	include dirname(__FILE__) . '/bootstrap.php';

	// create / update page

	Db::executeFile(dirname(__FILE__) .'/schema/tables.sql');

	Cache::delete(Twitter::CACHE_KEY_LAST_TWEET);
	Cache::delete(Twitter::CACHE_KEY_LAST_TWEET_WITH_IMAGE);


	Dispatch::now(1, 'RESET ALL OK', $data);

} // main()


try
{
	main();
}
catch(Exception $e) {
	Debug::logError($e, 'EXCEPTION ' . $e->getMessage());
	Dispatch::now(0, 'EXCEPTION ' . $e->getMessage());
}

?>