<?php

/**
* cancel any transact thats in progress
*/
function cancel_transaction(){
  global $con;
  try{
   $sql = 'DELETE FROM cart';
   $con->exec($sql);
   return true;
  }catch(PDOException $e){
   report_error($e);            
  }         
}
         
function get_items_in_cart($con){
 try{
  global $charge;
  $sql = "SELECT * FROM cart";
  $pdo = $con->query($sql);  
  $items = null;
              
  foreach($pdo as $row){                            
  //add new entry
  $items[] = array (
    'trans_id' => $row['trans_id'],
    'item_id' => $row["item_id"], 
    'item_name' => $row["item_name"],
    'item_price' => $row["item_price"],
    'item_quantity' => $row["item_quantity"],
    'item_amount' => $row["item_amount"]);
  $charge += $row["item_amount"];             
  }
            
  return $items == null ? null : $items;
 }catch(PDOException $e){
    report_error($e);
  }
}
         
 function update_table_value($con, $id, $value){
   if(is_numeric($value))
    try{
     $sql = 'UPDATE cart SET item_quantity= :quantity WHERE 
              trans_id= :id';
      $statement = $con->prepare($sql);
      $statement->bindValue(':quantity', $value);
      $statement->bindValue(':id', $id);
      $statement->execute();
      return true;
    }catch(PDOException $e){
       report_error($e);            
    }
 }
 
 function remove_table_value($con, $id){
    try{
     $sql = 'DELETE FROM cart WHERE 
              trans_id= :id';
      $statement = $con->prepare($sql);
      $statement->bindValue(':id', $id);
      $statement->execute();
      return true;
    }catch(PDOException $e){
       report_error($e);            
    }
 }
  
 function add_to_cart($con,$id, $quantity){
    try{
      //fetch from items table
      $sql = 'SELECT item_name, item_price FROM items WHERE
               item_id="'.$id.'"';            
      $results = $con->query($sql);
      
      $unit_price = 0.0;
      $item_name = "";
      while($row = $results->fetch()){
        $unit_price = $row['item_price'];
        $item_name = $row['item_name'];              
      }
      
      //add to cart
      $sql = 'INSERT INTO cart SET item_id= :id, item_name= :name,
              item_price= :unit_price, item_quantity= :quantity, cashier_id="'
              .$_SESSION['user_id'].'"'; 
      $statement = $con->prepare($sql);
      $statement->bindValue(':id', $id);
      $statement->bindValue(':name', $item_name);
      $statement->bindValue(':unit_price', $unit_price);
      $statement->bindValue(':quantity', $quantity);
      $statement->execute();
      return true;
    }catch(PDOException $e){
      report_error($e);            
    }          
 }
  
 function search_items($con){
   try{
      $sql = "SELECT * FROM items";
      $pdo = $con->query($sql);  
      $found_items = null;
        
      foreach($pdo as $row){                            
        //add new entry
        $found_items[] = array ('item_id' => $row["item_id"], 
                 'item_name' => $row["item_name"],
                 'item_price' => $row["item_price"]);            
      }
    
      return $found_items == null ? null : $found_items;
    }catch(PDOException $e){
      report_error($e);
   }   
 }
 
 function process_transaction($amount){
    global $paid;
    global $charge;
    if(is_numeric($amount) &&
      ($amount > $charge)){
     $paid = $amount;
        
     //record transaction
     write_to_history();
    
     //update inventory
     update_items();
     
     //clear everything
     return cancel_transaction();         
    }
 }
 
 function logout(){
  //unset all variables and head to main page
  $_SESSION = array();
  session_destroy();
  header('Location: ../../pos_web');
  exit();      
 }
 
 function write_to_history(){
  global $con;
  try{
    $sql = "INSERT INTO history (trans_id, item_id, item_price, 
              item_quantity, item_amount, cashier_id)
            SELECT trans_id, item_id, item_price,item_quantity,
              item_amount, cashier_id FROM cart";
    $con->exec($sql);
  }catch(PDOException $e){
    report_error($e);          
  }
 }
 
 function update_items(){
  global $con;
  try{
   $sql = 'SELECT item_id, item_quantity FROM cart';           
   $results = $con->query($sql);
          
   while($row = $results->fetch()){
    $sql_update = 'UPDATE items SET item_quantity= item_quantity - '.
      $row['item_quantity'].' WHERE item_id='.$row['item_id'];
    $con->exec($sql_update);
   }
  }catch(PDOException $e){
    report_error($e); 
  }        
 }
 
 function search_items_by_category($category, $key){
  global $con;  
  try{
    $sql = '';
    if($key != null) {
      $sql = 'SELECT * FROM items WHERE item_name LIKE "%'.$key.'%" AND
          category_id='.$category;
    }else {
      $sql = 'SELECT * FROM items';
    }
    $pdo = $con->query($sql);  
    $found_items = null;
        
    foreach($pdo as $row){                            
        //add new entry
        $found_items[] = array ('item_id' => $row["item_id"], 
                 'item_name' => $row["item_name"],
                 'item_price' => $row["item_price"]);            
      }
    
     return $found_items == null ? null : $found_items;
    }catch(PDOException $e){
      report_error($e);
   }
 }
 
 function get_categories() {
  global $con;  
  try{
      $sql = "SELECT * FROM category";
      $pdo = $con->query($sql);  
      $found_items = null;
        
      foreach($pdo as $row){                            
        //add new entry
        $found_items[] = array ('category_id' => $row["category_id"], 
                 'category_name' => $row["category_name"]);            
      }
    
      return $found_items == null ? null : $found_items;
    }catch(PDOException $e){
      report_error($e);
   } 
 }
 
function get_cashiers(){
   global $con;  
    try{
      $sql = 'SELECT * FROM clients WHERE groupId="cashier"';
      $pdo = $con->query($sql);  
      $found_items = null;
        
      foreach($pdo as $row){                            
        //add new entry
        $found_items[] = array ('cashier_id' => $row["id"], 
                 'cashier_name' => $row["name"]);            
      }
    
      return $found_items == null ? null : $found_items;
    }catch(PDOException $e){
      report_error($e);
   }
 }
 
function get_dates(){
  global $con;  
    try{
      $sql = 'SELECT entry_id, Date(trans_id) AS date_only 
        FROM history GROUP BY Date(trans_id)';
      $pdo = $con->query($sql);  
      $found_items = null;
        
      foreach($pdo as $row){                            
        //add new entry
        $found_items[] = array ('date_id' => $row["entry_id"], 
                 'date_name' => $row['date_only']);            
      }
    
      return $found_items == null ? null : $found_items;
    }catch(PDOException $e){
      report_error($e);
   }
}

function get_history($start_date, $end_date, $cashier, $key) {
 global $con;  
 try{
  $sql = 'SELECT history.trans_id, history.item_price, 
          history.item_quantity, history.item_amount, 
          clients.name, items.item_name          
          FROM history INNER JOIN clients ON 
          history.cashier_id = clients.id 
          INNER JOIN items ON history.item_id = items.item_id';
    //filter chain
    //process 1      
    if(isset($start_date) && $start_date != '0'){
        $sql .= ' WHERE entry_id >="'.$start_date.'"';           
    }
    
     //process 2
    if(isset($start_date) && isset($end_date) && $end_date >= $start_date) {
      $sql .= ' AND entry_id <="'.$end_date.'"';   
    }elseif((!isset($start_date) || $start_date == '0') 
            && isset($end_date) && $end_date != '0') {
      $sql .= ' WHERE entry_id <="'.$end_date.'"';    
    }else { /* do nothin */}
    
     //process 3
    if(((isset($start_date) && $start_date != '0') ||
          (isset($end_date) && $end_date != '0')) &&  
          isset($cashier) && $cashier != '0'){
          $sql .= ' AND cashier_id='.$cashier;
    }elseif((!isset($start_date) || $start_date == '0') &&
          (!isset($end_date) || $end_date == '0') && 
          isset($cashier) && $cashier != '0') {
       $sql .= ' WHERE cashier_id='.$cashier;   
    }else {/* do not add */}
    
     //process 4
     // end of filter chain process
    if((((isset($start_date) && $start_date != '0') ||
          (isset($end_date) && $end_date != '0')) ||  
          (isset($cashier) && $cashier != '0')) && 
          (isset($key) && $key != '')) {
          $sql .= ' AND items.item_name Like "%'.$key.'%"';
    }elseif((!isset($start_date) || $start_date == '0') &&
          (!isset($end_date) || $end_date == '0') && 
          (!isset($cashier) || $cashier != '0') && 
          (isset($key) && $key != '')) {
       $sql .= ' WHERE items.item_name Like "%'.$key.'%"';   
    }else {/* do not add */}
      
  $sql .= ' ORDER BY trans_id ASC';
  $pdo = $con->query($sql);  
  $found_items = null;
        
  foreach($pdo as $row){                            
   //add new entry
   $found_items[] = array ('trans_id' => $row['trans_id'],
           'item_name' => $row['item_name'], 
           'item_price' => $row['item_price'], 
           'item_quantity' => $row['item_quantity'], 
           'item_amount' => $row['item_amount'],
           'cashier_name' => $row['name']);            
   }

   return $found_items == null ? null : $found_items;
   }catch(PDOException $e){
    report_error($e);
 } 
}
 ?>