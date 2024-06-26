<div class='wp-pagenavi'>
    <span class='pages'>Page <?php echo $page; ?> of <?php if($pages == 0){echo "1";} else { echo $pages; }; ?></span>
    <?php if($page ==1){ ?>
      <span class='current'>1</span>
      <?php if($pages > 1) { ?><a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/2/<?php echo $postfix; ?>' class='page larger'>2</a><?php } ?>
      <?php if($pages > 2) { ?><a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/3/<?php echo $postfix; ?>' class='page larger'>3</a><?php } ?>
      <?php if($pages > 3) { ?><a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/4/<?php echo $postfix; ?>' class='page larger'>4</a><?php } ?>
      <?php if($pages > 4) { ?><a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/5/<?php echo $postfix; ?>' class='page larger'>5</a><?php } ?>
      <?php if($pages > 5) { ?><a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/6/<?php echo $postfix; ?>' class='page larger'>6</a><?php } ?>
      <?php if($pages > 6) { ?><a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/7/<?php echo $postfix; ?>' class='page larger'>7</a><?php } ?>
    <?php } else if($page ==2){ ?>
      <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php if(!$postfix==null){echo "1/" . $postfix;}; ?>' class='page smaller'>1</a>
      <span class='current'>2</span>
      <?php if($pages > 2) { ?><a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/3/<?php echo $postfix; ?>' class='page larger'>3</a><?php } ?>
      <?php if($pages > 3) { ?><a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/4/<?php echo $postfix; ?>' class='page larger'>4</a><?php } ?>
      <?php if($pages > 4) { ?><a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/5/<?php echo $postfix; ?>' class='page larger'>5</a><?php } ?>
      <?php if($pages > 5) { ?><a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/6/<?php echo $postfix; ?>' class='page larger'>6</a><?php } ?>
      <?php if($pages > 6) { ?><a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/7/<?php echo $postfix; ?>' class='page larger'>7</a><?php } ?>
    <?php } else if($page ==3){ ?>
      <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php if(!$postfix==null){echo "1/" . $postfix;}; ?>' class='page smaller'>1</a>
      <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/2/<?php echo $postfix; ?>' class='page smaller'>2</a>
      <span class='current'>3</span>
      <?php if($pages > 3) { ?><a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/4/<?php echo $postfix; ?>' class='page larger'>4</a><?php } ?>
      <?php if($pages > 4) { ?><a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/5/<?php echo $postfix; ?>' class='page larger'>5</a><?php } ?>
      <?php if($pages > 5) { ?><a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/6/<?php echo $postfix; ?>' class='page larger'>6</a><?php } ?>
      <?php if($pages > 6) { ?><a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/7/<?php echo $postfix; ?>' class='page larger'>7</a><?php } ?>
    <?php } else if($page ==4){ ?>
      <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php if(!$postfix==null){echo "1/" . $postfix;}; ?>' class='page smaller'>1</a>
      <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/2/<?php echo $postfix; ?>' class='page smaller'>2</a>
      <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/3/<?php echo $postfix; ?>' class='page smaller'>3</a>
      <span class='current'>4</span>
      <?php if($pages > 4) { ?><a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/5/<?php echo $postfix; ?>' class='page larger'>5</a><?php } ?>
      <?php if($pages > 5) { ?><a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/6/<?php echo $postfix; ?>' class='page larger'>6</a><?php } ?>
      <?php if($pages > 6) { ?><a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/7/<?php echo $postfix; ?>' class='page larger'>7</a><?php } ?>
    <?php } else if($page == ($pages-4)){ ?>
      <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page-2; ?>/<?php echo $postfix; ?>' class='page smaller'><?php echo $page-2; ?></a>
      <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page-1; ?>/<?php echo $postfix; ?>' class='page smaller'><?php echo $page-1; ?></a>
      <span class='current'><?php echo $page ?></span>
      <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page+1; ?>/<?php echo $postfix; ?>' class='page smaller'><?php echo $page+1; ?></a>
      <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page+2; ?>/<?php echo $postfix; ?>' class='page smaller'><?php echo $page+2; ?></a>
      <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page+3; ?>/<?php echo $postfix; ?>' class='page smaller'><?php echo $page+3; ?></a>
      <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page+4; ?>/<?php echo $postfix; ?>' class='page smaller'><?php echo $page-4; ?></a>
    <?php } else if($page == ($pages-3)){ ?>
      <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page-3; ?>/<?php echo $postfix; ?>' class='page smaller'><?php echo $page-3; ?></a>
      <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page-2; ?>/<?php echo $postfix; ?>' class='page smaller'><?php echo $page-2; ?></a>
      <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page-1; ?>/<?php echo $postfix; ?>' class='page smaller'><?php echo $page-1; ?></a>
      <span class='current'><?php echo $page ?></span>
      <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page+1; ?>/<?php echo $postfix; ?>' class='page smaller'><?php echo $page+1; ?></a>
      <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page+2; ?>/<?php echo $postfix; ?>' class='page smaller'><?php echo $page+2; ?></a>
      <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page+3; ?>/<?php echo $postfix; ?>' class='page smaller'><?php echo $page+3; ?></a>
    <?php } else if($page == ($pages-2)){ ?>
      <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page-4; ?>/<?php echo $postfix; ?>' class='page smaller'><?php echo $page-4; ?></a>
      <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page-3; ?>/<?php echo $postfix; ?>' class='page smaller'><?php echo $page-3; ?></a>
      <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page-2; ?>/<?php echo $postfix; ?>' class='page smaller'><?php echo $page-2; ?></a>
      <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page-1; ?>/<?php echo $postfix; ?>' class='page smaller'><?php echo $page-1; ?></a>
      <span class='current'><?php echo $page ?></span>
      <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page+1; ?>/<?php echo $postfix; ?>' class='page smaller'><?php echo $page+1; ?></a>
      <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page+2; ?>/<?php echo $postfix; ?>' class='page smaller'><?php echo $page+2; ?></a>
    <?php } else if($page == ($pages-1)){ ?>
      <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page-5; ?>/<?php echo $postfix; ?>' class='page smaller'><?php echo $page-5; ?></a>
      <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page-4; ?>/<?php echo $postfix; ?>' class='page smaller'><?php echo $page-4; ?></a>
      <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page-4; ?>/<?php echo $postfix; ?>' class='page smaller'><?php echo $page-3; ?></a>
      <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page-2; ?>/<?php echo $postfix; ?>' class='page smaller'><?php echo $page-2; ?></a>
      <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page-1; ?>/<?php echo $postfix; ?>' class='page smaller'><?php echo $page-1; ?></a>
      <span class='current'><?php echo $page ?></span>
      <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page+1; ?>/<?php echo $postfix; ?>' class='page smaller'><?php echo $page+1; ?></a>
    <?php } else if($page == ($pages)){ ?>
      <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page-6; ?>/<?php echo $postfix; ?>' class='page smaller'><?php echo $page-6; ?></a>
      <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page-5; ?>/<?php echo $postfix; ?>' class='page smaller'><?php echo $page-5; ?></a>
      <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page-4; ?>/<?php echo $postfix; ?>' class='page smaller'><?php echo $page-4; ?></a>
      <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page-3; ?>/<?php echo $postfix; ?>' class='page smaller'><?php echo $page-3; ?></a>
      <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page-2; ?>/<?php echo $postfix; ?>' class='page smaller'><?php echo $page-2; ?></a>
      <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page-1; ?>/<?php echo $postfix; ?>' class='page smaller'><?php echo $page-1; ?></a>
      <span class='current'><?php echo $page ?></span>
    <?php } else { ?>
      <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page-3; ?>/<?php echo $postfix; ?>' class='page smaller'><?php echo $page-3; ?></a>
      <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page-2; ?>/<?php echo $postfix; ?>' class='page smaller'><?php echo $page-2; ?></a>
      <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page-1; ?>/<?php echo $postfix; ?>' class='page smaller'><?php echo $page-1; ?></a>
      <span class='current'><?php echo $page ?></span>
      <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page+1; ?>/<?php echo $postfix; ?>' class='page smaller'><?php echo $page+1; ?></a>
      <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page+2; ?>/<?php echo $postfix; ?>' class='page smaller'><?php echo $page+2; ?></a>
      <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page+3; ?>/<?php echo $postfix; ?>' class='page smaller'><?php echo $page+3; ?></a>
    <?php } if($page < ($pages - 4)){ ?>
      <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $pages ?>/<?php echo $postfix; ?>' class='last'>Last</a>
    <?php } ?>
</div>
