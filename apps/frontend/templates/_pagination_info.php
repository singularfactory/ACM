<?php $url = "$model/index?page=" ?>

<div>
	<?php echo count($pager) ?> items - showing page <?php echo $pager->getPage() ?> of <?php echo $pager->getLastPage() ?>

	<?php echo link_to(image_tag('first.png', array('alt' => 'First page', 'title' => 'First page')), $url.$pager->getFirstPage()) ?>
	<?php echo link_to(image_tag('previous.png', array('alt' => 'Previous page', 'title' => 'Previous page')), $url.$pager->getPreviousPage()) ?>

	<?php foreach ($pager->getLinks() as $page): ?>
	<?php echo ($page == $pager->getPage()) ? $page : link_to($page, $url.$page) ?>
	<?php endforeach ?>

	<?php echo link_to(image_tag('next.png', array('alt' => 'Next page', 'title' => 'Next page')), $url.$pager->getNextPage()) ?>
	<?php echo link_to(image_tag('last.png', array('alt' => 'Last page', 'title' => 'Last page')), $url.$pager->getLastPage()) ?>
</div>
