<?php
/*
 * KWDS User Registration Page
 */
require_once('includes/header.php');
global $db;
?>
<h2>KWDS Website Account Registration</h2>
<?php
// If user is logged in, display error and redirect back to main page
if (!$session->isLoggedIn()) {

    // If the registration form has not been submitted, display the form
    if (!isset($_POST['register'])) {
        get_register_form();
    } else {
        $username = sanit($_POST['username']);
        $email = sanit($_POST['email']);
        //$password = sanit(md5($_POST['password']));
        //$password_verify = sanit(md5($_POST['password_verify']));


        // Check to make sure all data was entered correctly.
        $result = $db->query("SELECT `username`, `email` FROM `user` WHERE `username`='$username' or `email`='$email'");

        // Check to see if user name is already being used or not
        if (count($result) > 0) {
            if ($result[0]['username'] == $username) {
                echo '<div class="box error">This user name is already taken. Please enter a different user name.</div>';
            }
            else {
                echo '<div class="box warning">If this is your email, you may want to consider using it to retrieve your password.</div>';
            }
            get_register_form();
        }
        // Make sure that a user name was entered
        elseif ($username == "") {
            echo '<div class="box warning">You must enter an user name and your email. Please try again.</div>';
            get_register_form();
        }
        // Make sure the email is a valid email and not blank
        elseif (check_email_address($email) == false) {
            echo '<div class="box error">You must enter a valid email address. Please try again.</div>';
            get_register_form();
        }
        // Make sure that the password is not blank
        /**elseif ($password == sanit(md5(""))) {
            echo '<div class="box warning">You must enter a password. Please try again.</div>';
            get_register_form();
        }**/
        // Check if passwords are the same
        else /**if ($password == $password_verify)**/ {
            // Create the user account
            $title = $_POST['title'];
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $prefix = $_POST['prefix'];
            $bio = $_POST['bio'];
            $sca_first = $_POST['sca_first'];
            $sca_last = $_POST['sca_last'];
            $group = $_POST['group'];
            $address = $_POST['address'];
            $city = $_POST['city'];
            $state = $_POST['state'];
            $country = $_POST['country'];
            $zip = $_POST['zip'];
            $phone = $_POST['phone'];
            $nickname = $_POST['nickname'];
            $db->insert_user($address, $bio, $city, $country, $email, $first_name, $group, $last_name, $nickname, $phone, $prefix, $sca_first, $sca_last, $state, $title, $username, $zip);

            // Display success message to user
            //*echo '<div class="box success">Your account has been created successfully! You will now be logged in.</div>';
            echo '<div class="box success">An email was sent with instructions for you to activate your new account.</div>';

            $random=random_gen(32);
            $db->setup_password($_POST['email'], $random);
            $message = 'To activate your account, please visit the following page and submit a password for your account: '.SITE_URL.'/reset.php?x='.$random;
            mail($email, '[KWDS]New Account Registration', $message, 'From: no_reply@kwds.org');

            // After the user has registered an account, log the user in
            /**$result = $db->login($username, $password, 'yes');
            redirect('index');**/
        }
        // If all else fails, then the passwords must not be matching
        /**else {
            echo '<div class="box error">Your passwords do not match! Please try again.</div>';
            get_register_form();
        }**/
    }
    echo '</div></div>';
} else {
    echo '<div class="box error">You are already logged in!</div>';
    redirect('index');
}

function get_register_form() {
?>
<ul class="registration">
    <li>All KWDS staff and teachers must register an account.</li>
    <li>Once you make an account, you'll be able to use it from year to year.</li>
    <li>KWDS Staff members will only be allowed to edit data related to their job.</li>
    <li>Teachers will be allowed to submit classes only for the upcoming KWDS.</li>
    <li>A username, email, and password is the only information required for you to enter.</li>
    <li>It is encouraged for you to fill out as much information as you're comfortable with sharing.</li>
    <li>Your phone number, and address (if you provide it) will only be able to seen by KWDS staff members.</li>
</ul>
<h3></h3>
<form class="form" method="post" action="register.php">
    <h3>Required Information</h3>
    <ul>
        <li>
            <label for="username">Username:</label><input type="text" name="username" id="username"
            <?php if (isset($_POST['username'])) { echo 'value="'.$_POST['username'].'"'; } ?> />
        </li>
        <li>
            <label for="email">Email Address:</label><input type="text" name="email" id="email"
            <?php if (isset($_POST['email'])) { echo 'value="'.$_POST['email'].'"'; } ?> />
            <img src="images/icons/information.png" title="Your email will be used so you can retrieve your password." alt="Hint"
                 onclick="alert('This will be used so you can retrieve your password')" />
        </li>
        <!--<li><label for="password">Password:</label><input type="password" name="password" id="password" /></li>
        <li><label for="password_verify">Re-enter password:</label><input type="password" name="password_verify" id="password_verify" /></li>-->
    </ul>
    <h3>Mundane Information (optional)</h3>
    <ul>
        <li><label for="prefix">Pre-fix:</label><?php $db= new db(); $result=$db->get_list('prefix'); 
        $index = (isset($_POST['prefix']))? $_POST['prefix']:1;
        dropdown($result, "prefix", $index); ?></li>
        <li><label for="first_name">First Name:</label><input type="text" name="first_name" id="first_name"
            <?php if (isset($_POST['first_name'])) { echo 'value="'.$_POST['first_name'].'"'; } ?> /></li>
        <li><label for="last_name">Last Name:</label><input type="text" name="last_name" id="last_name"
            <?php if (isset($_POST['last_name'])) { echo 'value="'.$_POST['last_name'].'"'; } ?> /></li>
        <li><label for="nickname">Nick Name:</label><input type="text" name="nickname" id="nickname"
            <?php if (isset($_POST['nickname'])) { echo 'value="'.$_POST['nickname'].'"'; } ?> /></li>
    </ul>
    <h3>Mundane Alternate Contact Information (optional)</h3>
    <ul>
        <li><label for="address">Address:</label><input type="text" name="address" id="address"
            <?php if (isset($_POST['address'])) { echo 'value="'.$_POST['address'].'"'; } ?> /></li>
        <li><label for="city">City:</label><input type="text" name="city" id="city"
            <?php if (isset($_POST['city'])) { echo 'value="'.$_POST['city'].'"'; } ?> /></li>
        <li><label for="state">State/Province:</label><input type="text" name="state" id="state"
            <?php if (isset($_POST['state'])) { echo 'value="'.$_POST['state'].'"'; } ?> /></li>
        <li><label for="country">Country:</label><input type="text" name="country" id="country"
            <?php if (isset($_POST['country'])) { echo 'value="'.$_POST['country'].'"'; } ?> /></li>
        <li><label for="zip">Zip Code:</label><input type="text" name="zip" id="zip"
            <?php if (isset($_POST['zip'])) { echo 'value="'.$_POST['zip'].'"'; } ?> /></li>
        <li><label for="phone">Phone Number:</label><input type="text" name="phone" id="phone"
            <?php if (isset($_POST['phone'])) { echo 'value="'.$_POST['phone'].'"'; } ?> /></li>
    </ul>
    <h3>SCA Information (optional)</h3>
    <ul>
        <li><label for="title">SCA Title:</label><?php $db= new db(); $result=$db->get_list('title'); 
            $index = (isset($_POST['title']))? $_POST['title']:1;
            dropdown($result, "title", $index); ?>
        </li>
        <li><label for="sca_first">SCA First Name:</label><input type="text" name="sca_first" id="sca_first"
            <?php if (isset($_POST['sca_first'])) { echo 'value="'.$_POST['sca_first'].'"'; } ?> /></li>
        <li><label for="sca_last">SCA Last Name(s):</label><input type="text" name="sca_last" id="sca_last"
            <?php if (isset($_POST['sca_last'])) { echo 'value="'.$_POST['sca_last'].'"'; } ?> /></li>
        <li><label for="group">SCA Local Group:</label><?php $db= new db(); $result=$db->get_list('`group`');
            $index = (isset($_POST['group']))? $_POST['group']:21;
            dropdown($result, "group", $index); ?>
            <img src="images/icons/information.png" title="If your group isn't listed, you can add it and change it later." alt="Hint"
                 onclick="alert('If your group isn\'t listed, you can add it and change it later.')" />
        </li>
    </ul>
    <h3>Enter a Biography for you Profile (optional)</h3>
    <ul>
        <li><label for="bio">About You:</label><textarea name="bio" cols="5" rows="40"><?php
            if (isset($_POST['bio'])) { echo $_POST['bio']; }
            ?></textarea></li>
        <li><label> </label><input class="button" type="submit" name="register" value="Register" /></li>
    </ul>
</form>
<?php
}
?>