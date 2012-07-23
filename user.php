<?php
/*
 * KWDS User Edit Form
 */
require_once('includes/header.php');
$edit = $db->get_user($_POST['uid']);
if (!isset($_POST['edit_user']) || count($edit) == 0) {
    echo '<div class="box error">You do not have permission to view this page.</div>';
    redirect('profile');
    die;
}
else {
    if (!isset($_POST['edit'])) {
        edit_profile_form($edit);
    } else {
        $username = sanit($_POST['username']);
        $email = sanit($_POST['email']);
        $password = sanit(md5($_POST['password']));
        $new_password = sanit(md5($_POST['new_password']));
        $password_verify = sanit(md5($_POST['password_verify']));


        // Check to make sure all data was entered correctly.
        global $db;
        $result = $db->query("SELECT id FROM user WHERE username='$username' AND id!='".$_POST['uid']."'");
        // Check to see if user name is already being used or not
        if (count($result) > 0) {
            echo '<div class="box error">This user name is already taken. Please enter a different user name.</div>';
            edit_profile_form($edit);
        }
        // Make sure that a user name was entered
        elseif ($username == "") {
            echo '<div class="box warning">You must enter your user name or email. Please try again.</div>';
            edit_profile_form($edit);
        }
        // Make sure the email is a valid email and not blank
        elseif (check_email_address($email) == false) {
            echo '<div class="box error">You must enter a valid email address. Please try again.</div>';
            edit_profile_form($edit);
        }
        // Make sure that the password is not blank
        elseif ($password == sanit(md5(""))) {
            echo '<div class="box error">You must enter a password. Please try again.</div>';
            edit_profile_form($edit);
        }
        // Check if passwords are the same
        elseif ($password == $edit['password']) {
            // Update the user account
            $title_id = $_POST['title_id'];
            $first = $_POST['first'];
            $last = $_POST['last'];
            $prefix_id = $_POST['prefix_id'];
            $id= $_POST['uid'];
            $about = $_POST['about'];
            $sca_first = $_POST['sca_first'];
            $sca_last = $_POST['sca_last'];
            $group_id = $_POST['group_id'];
            $address = $_POST['address'];
            $city = $_POST['city'];
            $state = $_POST['state'];
            $country = $_POST['country'];
            $zip = $_POST['zip'];
            $phone = $_POST['phone'];
            $nickname = $_POST['nickname'];
            if($new_password==$password_verify AND $new_password != sanit(md5(""))) {
                $password=$new_password;
            }
            $db->update_user($about, $address, $city, $country, $email, $first, $group_id, $id, $last, $nickname, $password, $phone, $prefix_id, $sca_first, $sca_last, $state, $title_id, $username, $zip);

            // Display success message to user
            echo '<div class="box success">Your profile has been successfully updated!</div>';
            redirect('profile');
            die;
        }
        // If all else fails, then the passwords must not be matching
        else {
            echo '<div class="box error">Your password does not match! Please try again.</div>';
            edit_profile_form($edit);
        }

        }
}
   
function edit_profile_form($edit) { ?>
<h1>Edit Your User Information</h1>
<form class="form" method="post" action="user.php">
    <h3>Required Information</h3>
    <ul class="box warning">
        <li><label for="username">Username:</label><input type="text" name="username" id="username"
            <?php echo 'value="'.$edit['username'].'"';?> /></li>
        <li><label for="email">Email Address:</label><input type="text" name="email" id="email"
            <?php echo 'value="'.$edit['email'].'"';?> /></li>
        <li><label for="password">Password:</label><input type="password" name="password" id="password" /></li>
    </ul>
    <h3>Mundane Information (optional)</h3>
    <ul>
        <li><label for="prefix_id">Pre-fix:</label><?php $db= new db(); $result=$db->get_list('prefix');
        $index = $edit['prefix_id'];
        dropdown($result, "prefix_id", $index); ?></li>
        <li><label for="first">First Name:</label><input type="text" name="first" id="first_name"
            <?php echo 'value="'.$edit['first'].'"';?> /></li>
        <li><label for="last">Last Name:</label><input type="text" name="last" id="last_name"
            <?php echo 'value="'.$edit['last'].'"';?> /></li>
        <li><label for="nickname">Nick Name:</label><input type="text" name="nickname" id="nickname"
            <?php echo 'value="'.$edit['nickname'].'"';?> /></li>
    </ul>
    <h3>Mundane Alternate Contact Information (optional)</h3>
    <ul>
        <li><label for="address">Address:</label><input type="text" name="address" id="address"
            <?php echo 'value="'.$edit['address'].'"';?> /></li>
        <li><label for="city">City:</label><input type="text" name="city" id="city"
            <?php echo 'value="'.$edit['city'].'"';?> /></li>
        <li><label for="state">State/Province:</label><input type="text" name="state" id="state"
            <?php echo 'value="'.$edit['state'].'"';?> /></li>
        <li><label for="country">Country:</label><input type="text" name="country" id="country"
            <?php echo 'value="'.$edit['country'].'"';?> /></li>
        <li><label for="zip">Zip Code:</label><input type="text" name="zip" id="zip"
            <?php echo 'value="'.$edit['zip'].'"';?> /></li>
        <li><label for="phone">Phone Number:</label><input type="text" name="phone" id="phone"
            <?php echo 'value="'.$edit['phone'].'"';?> /></li>
    </ul>
    <h3>SCA Information (optional)</h3>
    <ul>
        <li><label for="title">SCA Title:</label><?php $db= new db(); $result = $db->get_list('title');
            $index = $edit['title_id'];
            dropdown($result, "title_id", $index); ?></li>
        <li><label for="sca_first">SCA First Name:</label><input type="text" name="sca_first" id="sca_first"
            <?php echo 'value="'.$edit['sca_first'].'"';?> /></li>
        <li><label for="sca_last">SCA Last Name(s):</label><input type="text" name="sca_last" id="sca_last"
            <?php echo 'value="'.$edit['sca_last'].'"';?> /></li>
        <li><label for="group_id">SCA Local Group:</label><?php $db= new db(); $result=$db->get_list('`group`');
            $index = $edit['group_id'];
            dropdown($result, "group_id", $index); ?></li>
    </ul>
    <h3>Enter a Biography for you Profile (optional)</h3>
    <ul>
        <li>
            <label for="about">About You:</label>
            <textarea name="about" cols="5" rows="40"><?php echo $edit['about'];?></textarea>
        </li>
    </ul>
    <h3>Change Password (optional)</h3>
    <ul>
        <li><label for="new_password">New password:</label><input type="password" name="new_password" id="new_password" /></li>
        <li><label for="password_verify">Re-enter password:</label><input type="password" name="password_verify" id="password_verify" /></li>
        <li><label> </label><input class="button" type="submit" name="edit_user" value="Update Profile" /></li>
    </ul>
    <input type="hidden" name="uid" value="<?php echo $_POST['uid'] ?>" />
    <input type="hidden" name="edit" value="true" />
</form>
<?php }
require_once('includes/footer.php');
?>
