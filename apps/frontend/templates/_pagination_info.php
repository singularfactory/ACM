<?php $url = "$model/index?page=" ?>
<?php
	$searchCriteria = null;
	if ( $text = $sf_user->getAttribute('search.criteria') ) {
		$searchCriteria = "&criteria=$text";
	}
?>

<div id="pagination">
	<?php echo count($pager) ?> items - showing page <?php echo $pager->getPage() ?> of <?php echo $pager->getLastPage() ?>

	<span id="pagination_links">
		<?php echo link_to(image_tag('first.png', array('alt' => 'First page', 'title' => 'First page')), $url.$pager->getFirstPage().$searchCriteria) ?>
		<?php echo link_to(image_tag('previous.png', array('alt' => 'Previous page', 'title' => 'Previous page')), $url.$pager->getPreviousPage().$searchCriteria) ?>

		<?php foreach ($pager->getLinks() as $page): ?>
		<?php echo ($page == $pager->getPage()) ? $page : link_to($page, $url.$page.$searchCriteria) ?>
		<?php endforeach ?>
		
		<?php echo link_to(image_tag('next.png', array('alt' => 'Next page', 'title' => 'Next page')), $url.$pager->getNextPage().$searchCriteria) ?>
		<?php echo link_to(image_tag('last.png', array('alt' => 'Last page', 'title' => 'Last page')), $url.$pager->getLastPage().$searchCriteria) ?>
	</span>
</div>