<?php
  echo head(array('title' => 'Arborescence du corpus', 'bodyclass' => 'collections browse')); ?>
  
<style>
div.notices {
  display:none;
}
.montrer {
  cursor:pointer;
  color:#aaa;
}
.collection {
  font-weight : bold;
}
#titre-arbo {
  font-weight: bold;
}
</style>
<script>
  $ = jQuery;
  $(document).ready(function() {
    $('.montrer').click(function() {
      $(this).parent().next('.notices, .collections').toggle();
    });
  });
</script>

<div id='collection-tree'>
<h3 id="titre-arbo">Arborescence du corpus</h3>
<?php  echo $tree; ?>
</div>
<?php echo foot(); ?>