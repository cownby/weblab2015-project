  <?php include_once "common/header.php"; ?>

  <section id="sectionLogin1" class="fluid">
 			<p align="right"><?php displayStatusMessage(); ?></p>
 			<?php displayAdminControls($user); ?>
 			
      <ul>   
      <li class="sectionText buttonColor"><a href='index.php?action=register' class='btn'>Register</a></li>
      <li class="sectionText buttonColor"><a href='index.php?action=login' class='btn'>Login</a></li>
      </ul>
    </section>
  <!-- Primary Container starts here -->
  <article class="fluid textContainer">
    
    <h2 class="fluid showAreaH2 headingStyle">Where are you?</h2>
    <section id="sectionOne" class="fluid entry-choice">
      <h2 class="sectionText buttonColor"><a href='index.php?action=onSite'>In the field</a></h2>
      <p class="paraContent buttonDesc">We&rsquo;ll gather coordinates from your phone if it&rsquo;s location enabled.</p>
    </section>
    <section id="sectionTwo" class="fluid entry-choice">
      <h2 class="sectionText buttonColor"><a href='index.php?action=atHome'>On the couch</a></h2>
      <p class="paraContent buttonDesc">No connectivity on your hike? No worries, we&rsquo;ve got you covered.</p>
    </section>
  </article>
  <!--Primary content area ends here--> 
  
  <!--Gallery starts here-->
  <?php include '../views/Gallery.view.php' ?>
  <!--Gallery ends here-->
  
  <!-- Footer starts here -->
  
  <footer class="fluid footer">
  <?php include_once "common/footer.php"; ?>
  </footer>
  <!--Footer ends here--> 
</div>
<!--Container ends here-->
</body>
</html>
