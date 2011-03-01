<?php
/**
 * @package    Firefox 4 Twitter Party
 * @subpackage server
 * @version    v.0.1
 * @author     Andre Torgal <andre@quodis.com>
 * @license    http://www.opensource.org/licenses/bsd-license.php BSD License
 */

/**
 * escape from global scope
 */
function main()
{
	DEFINE('CLIENT', 'ajax');
	DEFINE('CONTEXT', __FILE__);
	include '../bootstrap.php';

	$terms = (isset($_REQUEST['terms'])) ? $_REQUEST['terms'] : null;


	$result = Tweet::getByTerms($terms, $config['UI']['resultsLimit'], TRUE);

	// init response

	$data = array(
		'tweets' => array(),
		'total' => $result->total(),
		'count' => $result->count()
	);

	while ($tweet = $result->row())
	{
		$data['tweets'][] = $tweet;
	}

	Debug::logMsg('terms:' . $terms . ' count:' . $data['count'] . ' total:' . $data['total']);

	Dispatch::now(1, 'OK', $data);

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
