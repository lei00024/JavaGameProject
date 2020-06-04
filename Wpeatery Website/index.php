<!DOCTYPE html>
<html>
<?php include 'header.php' ?>
<?php include 'menuItem.php' ?>
            <div id="content" class="clearfix">
                <aside>
				<h2><?php echo date("l") . "'s"; ?> Specials</h2>
                <hr>
                <img src="images/burger_small.jpg" alt="Burger" title="Monday's Special - Burger">
				<?php 
					$i = 0;
					$menuItemArray = Array();
					while($i < 4){
						if ($i % 2 == 0){
							$menuItemArray[$i] = new menuItem("The WP Burger".str_repeat("*", $i+1).($i+1), "Freshly made all-beef patty served up with homefries", "$14");
						}	
						else {
							$menuItemArray[$i] = new menuItem("WP Kebobs".str_repeat("*", $i+1).($i+1), "Tender cuts of beef and chicken, served with your choice of side", "$17");
						}
							
						$i++;
					}
				?>
				
                        <h3><?php echo $menuItemArray[0]-> getItemName()?></h3>
                        <p><?php echo $menuItemArray[0]->getDescription()?> - <?php echo $menuItemArray[0]->getPrice()?></p>
                        <hr>
                        <img src="images/kebobs.jpg" alt="Kebobs" title="WP Kebobs">
                        <h3><?php echo $menuItemArray[1]-> getItemName()?></h3>
                        <p><?php echo $menuItemArray[1]->getDescription()?> - <?php echo $menuItemArray[1]->getPrice()?></p>
                        <hr>
						<img src="images/burger_small.jpg" alt="Burger" title="Monday's Special - Burger">
                        <h3><?php echo $menuItemArray[2]-> getItemName()?></h3>
                        <p><?php echo $menuItemArray[2]->getDescription()?> - <?php echo $menuItemArray[2]->getPrice()?></p>
                        <hr>
                        <img src="images/kebobs.jpg" alt="Kebobs" title="WP Kebobs">
                        <h3><?php echo $menuItemArray[3]-> getItemName()?></h3>
                        <p><?php echo $menuItemArray[3]->getDescription()?> - <?php echo $menuItemArray[3]->getPrice()?></p>
						<hr>
                </aside>
                <div class="main">
				
                    <h1>Welcome</h1>
                    <img src="images/dining_room.jpg" alt="Dining Room" title="The WP Eatery Dining Room" class="content_pic">
                    <p>
                    <?php
					   $mi = new MenuItem("Soup & Sandwich","Homemade soup made daily.","$9.99");
                       echo "Come on it and enjoy our <b>" . $mi->getItemName() . "</b> daily special at the low price of <u><strong>"  . $mi->getPrice() . "</strong></u></br></br>";
                       $mi2 = new MenuItem("Appetizers","","$7.99");
                       echo "Or stop in later in the day during happy hour to enjoy our <b>" . $mi2->getItemName() . "</b> for <u><strong>"  . $mi2->getPrice() . "</strong></u> each from 3pm - 5pm</br>";
                    ?>
                    </p>
					<h2>Book your Christmas Party!</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
                </div>
            </div>
<?php include 'footer.php' ?>
        </div>
    </body>
</html>
