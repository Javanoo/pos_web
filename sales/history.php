<?php
  require_once '../includes/sales_helpers.inc.php';
  
  if(!isset($_SESSION['password_hash']) && 
     $_SESSION['password_hash'] == null) logout();
  echo ' 
<!--Central panel -->						
<section class="history">
  <section id="header">
  <h3>'.(date('l d F')).'</h3>
  <form action="" method="POST">
      <select id="search_category" title="start date" name="start_date">
        <option value="0"> all </option>      
      ';
      if($dates != null)
		  foreach ($dates as $date): echo 
		    '<option value="'.$date['date_id']
		      .'" '.(($selected_start_date == $date['date_id']) ? 'selected' :
		         '').'> '.$date['date_name'].' 
		      </option>';
		  endforeach; echo'						
    </select>
    <select id="search_category"  title="end date" name="end_date">
      <option value="0"> all </option>
    ';      
      if($dates != null)
		  foreach ($dates as $date): echo 
		    '<option value="'.$date['date_id']
		      .'" '.(($selected_end_date == $date['date_id']) ? 'selected' : 
		      '').'> '.$date['date_name'].' 
		      </option>';
		  endforeach; echo'						
    </select>
    <select id="search_category" title="cashier" name="cashier_id">
      <option value="0"> all </option>    
    ';
      if($cashiers != null)
		  foreach ($cashiers as $cashier): echo 
		    '<option value="'.$cashier['cashier_id']
		      .'" '.(($selected_cashier == $cashier['cashier_id']) ? 'selected' :
		       '').'> '.$cashier['cashier_name'].' 
		      </option>';
		  endforeach; echo'						
    </select>
    <input type="search" name="search_bar" title="item" id="search_bar" 
    placeholder="item name" value=""/>
    <button type="submit" name="search" value="on"> go </button> 
  </form>
  </section>
  <section id="history_table">
  <table>
	 <caption><h4>'; echo '('. (($history != null) ? 
	                             count($history) : '0');
	  echo ') ITEMS</h4></caption>
    <thead>					   	
		 <tr>
	    <th>DATE</th>									
      <th>NAME</th>																			
			<th>PRICE</th>																			
			<th>QUANTITY</th>																			
			<th>AMOUNT</th>
			<th>CASHIER</th>																				
		 </tr>
		</thead>
		<tbody>';
		 if($history != null)
		  foreach ($history as $history_item): echo
		  '<tr id="history_table_row">
		   <form action="" method="POST">
			 <td>'. $history_item["trans_id"].'</td>
			 <td class="td_center">'. $history_item['item_name'].'</td>
			 <td class="td_center">'. $history_item['item_price'].'</td>
			 <td class="td_center">'.$history_item['item_quantity'].' </td>
			 <td class="td_center">'. $history_item['item_amount'].'</td>
			 <td class="td_center">'. $history_item['cashier_name'].'</td>
			 </form>
			</tr>';
			endforeach; echo
			'</tbody>															
	</table>
</section>
</section>
';
?>