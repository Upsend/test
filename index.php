<?php  
require_once('curl/curl.php');
require_once('phpquery/phpQuery/phpQuery.php');
$curl = new Curl();
function parse($res, $start, $stop){
	if($start < $stop){
		$doc = phpQuery::newDocument($res->body);
		$products = $doc->find('.item_table');
		$i = 0;
		foreach ($products as $product) {
			$i++;
			$elem = pq($product);
			echo $i. ') ';
			echo $elem->find('.item-description-title')->text(). '<br>';
			echo $elem->find('.price ')->text(). '<br>';
			echo $elem->find('.specific-params_block')->text(). '<br>';
			echo '<br/>';
			
			echo '<hr>';
			echo '<br>';
		}
		$next = 'https://www.avito.ru' . $doc->find('.pagination-pages .pagination-page_current')->next()->attr('href');
		if(!empty($next)){
			$start++;
			parse($next, $start, $stop);
		}
	}
}
$res = $curl->get('https://www.avito.ru/orenburg/avtomobili?radius=200');
$start = 0;
$stop = 2;
parse($res, $start, $stop);

?>