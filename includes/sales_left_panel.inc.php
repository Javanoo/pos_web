<?php

echo '
<!--Left most panel -->
<section id="right_panel">
					
  <section id="search_group">
    <select id="search_category">
      <option>hair</option>
      <option>food</option>
      <option>oil</option>
      <option>utensils</option>							
    </select>
    <input type="search" name="search_bar" placeholder="search"/>
    <h4> items found </h4>							
  </section>
				  
  <section id="buttons">
    <form action="?transact=on" method="POST">
      <button type="submit" value="paid" name="action"
        id="paid">Pay</button>
      <button type="submit" value="cancel" name="action" 
        id="cancel">Cancel</button>
    </form>							
  </section>
';
?>