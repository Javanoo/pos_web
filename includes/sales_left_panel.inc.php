<?php

echo '
<!--Left most panel -->
<section id="right_panel">
					
  <section id="search_group">
    <form action="" method="POST">
      <select id="search_category" name="category_id">';
      if($categories != null)
		  foreach ($categories as $category): echo 
		    '<option value="'.$category['category_id']
		      .'" '.(($selected == $category['category_id']) ? 'selected' : '').'> '.$category['category_name'].' 
		      </option>';
		  endforeach; echo'						
    </select>
    <input type="search" name="search_bar" id="search_bar" placeholder="search" value=""/>	
     </form>							
  </section>
  <h4> ITEMS FOUND </h4>
  <table>  
  <thead>					   	
		 <tr>
		  <th>SERIAL</td>									
      <th>NAME</th>																			
			<th>PRICE</th>																			
			<th>ADD</th>																																					
		 </tr>
		</thead>
		<tbody>';
		 if($searched_items != null)
		  foreach ($searched_items as $item): echo
 		  '
 		  <form action="" method="POST">
		  <tr>
			 <input type="number" name="id" hidden value="'. $item['item_id'].'"></input>
       <td>'. $item['item_id'].'</td>			 
			 <td>'. $item['item_name'].'</td>
			 <td>'. $item['item_price'].'</td>
			 <td><button type="submit" id="edit" name="add" value="add">+</button></td>
			</tr>
      </form>			
			';
			endforeach; echo
			'</tbody>															
	</table>
				  
  <section id="buttons">
    <form action="" method="POST">
      <input type="text" class="amount_prompt" name="amount" placeholder="amount paid">
      <button type="submit" value="paid" name="action"
        id="paid">Pay</button>
      <button type="submit" value="cancel" name="action" 
        id="cancel">Cancel</button>
    </form>							
  </section>
';
?>

<html>
  
</html>