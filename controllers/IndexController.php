<?php
          
class Colsort_IndexController extends Omeka_Controller_AbstractActionController 
{
  
  protected $tree = ''; 
  
  public function affichecollectionsAction() {
    $query = "SELECT collection_id id, name FROM omeka_collection_trees WHERE parent_collection_id = 0";    
    $db = get_db();
    $cols = $db->query($query)->fetchAll();
    
    $this->tree .= '<ul>';    

    $cols = $this->orderCollections($cols);

    foreach ($cols as $id => $col) {
      $collection = get_record_by_id('collection', $col['id']);
      $plus = '';
      if ($items = $this->fetch_items($col['id'])) {
        $plus = "<span class='montrer'>+</span>";
      }      
      $this->tree .= "<li><a class='collection' href='collections/show/" . $col['id'] . "'>" . $col['name'] . "</a> $plus </li>";
      $this->tree .= $items;      
      $child_collections = $this->fetch_child_collections($col['id']);
    }
    $this->tree .= '</ul>';        
    $this->view->content = $this->tree;
    return true;
  }
  
  private function fetch_child_collections($collection_id) {
    $query = "SELECT collection_id id, name FROM omeka_collection_trees WHERE parent_collection_id = " . $collection_id;
    $db = get_db();
    $child_collections = $db->query($query)->fetchAll();
    if (! $child_collections) return false;
    $this->tree .= '<ul>';
    $child_collections = $this->orderCollections($child_collections);  
    $plus = '';  
    foreach ($child_collections as $id => $col) {
      $collection = get_record_by_id('collection', $col['id']);
      if ($items = $this->fetch_items($col['id'])) {
        $plus = "<span class='montrer'>+</span>";
      }  else {
        $plus = '';
      }
      $this->tree .= "<li><a class='collection' href='collections/show/". $col['id'] . "'>" . $col['name'] . "</a> $plus </li>";     
      $this->tree .= $items;        
      $child_collections = $this->fetch_child_collections($col['id']);  
    }
    $this->tree .= '</ul>';
  }

  private function fetch_items($cid) {
    $query = "SELECT id FROM omeka_items WHERE collection_id = " . $cid;
    $db = get_db();
    $items = $db->query($query)->fetchAll();
    $notices = "";
    if (! $items) {return false;}    
    $notices .= '<div class="notices"><ul>';
    foreach ($items as $id => $item) {
      $item = get_record_by_id('item', $item['id']);
      $notices .= "<li style='list-style-type:circle;'><a href='items/show/" . metadata($item, 'id') . "' >" . metadata($item, array('Dublin Core', 'Title')). "</a></li>";
    }
    $notices .= '</ul></div>';
    return $notices;
  }
 
   public function orderCollections($cols) {
    $order = unserialize(get_option('sortcol_preferences'));
    foreach ($cols as $id => $col) {
      $cols[$id]['ordre'] = $order[$col['id']];
    }
    usort($cols, function($a, $b) {return ($a['ordre'] < $b['ordre']) ? -1 : 1;});
    return $cols;
  } 

}