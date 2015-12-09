<?php
	$pageTitle = "WebLab 2015 Project - Register User";
	require_once 'common/header.php';
?>
<article class="fluid textContainer">
<h2 class="fluid showAreaH2 headingStyle">Flora Registry</h2>


                    <form action="index.php" method="get" class="fluid reg-form">
                      <input type="hidden" name="action" value="register_user"> 
                      <p><label>Name</label></p>
                      <input type="text" name="name" placeholder="name" value="" required>
                      <p><label>Email</label></p>
                      <input type="email" name="email" placeholder="email" value="" required >
                      <!--
                      <label>Role: </label>
                      <select name="role">
                        <option value='2' selected>User</option>";
                        <option value='1'>Admin</option>";
                      </select>
                      <br><br> 
                      -->
                      <p><label>Password</label></p>
                      <input type="text" name="pass" placeholder="pass" value="">
                      
                      <p><input type="submit" value="Save"  class='button'></p>
                    </form>

<?php
	require_once "../views/common/footer.php";
?>
</article>