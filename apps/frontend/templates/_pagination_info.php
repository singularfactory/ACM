<?php $url = "@{$model}_pagination?page=" ?>
<?php
	if ( $text = $sf_user->getAttribute('search.criteria') ) {
		$url = "@{$model}_search_pagination?criteria=$text&page=";
	}
?>

<div id="pagination">
	<?php echo count($pager) ?> items - showing page <?php echo $pager->getPage() ?> of <?php echo $pager->getLastPage() ?>

	<span id="pagination_links">
		<?php echo link_to(image_tag('first.png', array('alt' => 'First page', 'title' => 'First page')), $url.$pager->getFirstPage()) ?>
		<?php echo link_to(image_tag('previous.png', array('alt' => 'Previous page', 'title' => 'Previous page')), $url.$pager->getPreviousPage()) ?>

		<?php foreach ($pager->getLinks() as $page): ?>
		<?php echo ($page == $pager->getPage()) ? $page : link_to($page, $url.$page) ?>
		<?php endforeach ?>
		
		<?php echo link_to(image_tag('next.png', array('alt' => 'Next page', 'title' => 'Next page')), $url.$pager->getNextPage()) ?>
		<?php echo link_to(image_tag('last.png', array('alt' => 'Last page', 'title' => 'Last page')), $url.$pager->getLastPage()) ?>
	</span>
</div>