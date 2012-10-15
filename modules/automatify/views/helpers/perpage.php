<?php 
	$perpage = Request::initial()->query('perpage');
	$perpage = Automatify::perPageFilter($perpage);
?>
<div id="perpage" class="pagination pull-left">
  <ul>
    <li class="disabled"><a href="#">Per page</a></li>
    <li <?php if($perpage==10):?>class="active"<?php endif;?>><a href="?perpage=10">10</a></li>
    <li <?php if($perpage==20):?>class="active"<?php endif;?>><a href="?perpage=20">20</a></li>
    <li <?php if($perpage==50):?>class="active"<?php endif;?>><a href="?perpage=50">50</a></li>
  </ul>
</div>