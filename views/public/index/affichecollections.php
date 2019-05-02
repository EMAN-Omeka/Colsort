<?php
  echo head(array('title' => 'Arbre des collections','bodyclass' => 'collections browse')); ?>
  
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
</style>
<script>
  $ = jQuery;
  $(document).ready(function() {
    $('.montrer').click(function() {
//       console.log('OK');  
//       $(this).next('div').toggle();
      $(this).parent().next('.notices').toggle();
    });
  });
</script>

<div id='collection-tree'>
<?php  echo $content; ?>
</div>
<?php echo foot(); ?>