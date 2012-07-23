<?php

/*
 * KWDS Common Functions
 */


// Checks to see if the logged-in user has permission to add rooms
function can_add_rooms($id) {
    $db = new db;
    $kwds = $db->get_kwds($_GET['kwds']);

    // Checks to see if you are on staff for the upcoming KWDS
    if (isset($_SESSION['user_id'])) {
        $jobs = $db->get_user_job($_SESSION['user_id'], $kwds['KWID']);

        foreach ($jobs as $job){
            if (($job['id'] == 1 || $job['id'] == 2 || ($job['id'] >= 6 && $job['id'] <= 9))) {
                return true;
            }
        }
    }

    // A super user should also be able to do this
    if (is_super_user($id)) {
        return true;
    }

    return false;
}


//email validate function found here: http://www.linuxjournal.com/article/9585
function check_email_address($email) {
    $isValid = true;
    $atIndex = strrpos($email, "@");
    if (is_bool($atIndex) && !$atIndex) {
        $isValid = false;
    } else {
        $domain = substr($email, $atIndex + 1);
        $local = substr($email, 0, $atIndex);
        $localLen = strlen($local);
        $domainLen = strlen($domain);
        if ($localLen < 1 || $localLen > 64) {
            // local part length exceeded
            $isValid = false;
        } else if ($domainLen < 1 || $domainLen > 255) {
            // domain part length exceeded
            $isValid = false;
        } else if ($local[0] == '.' || $local[$localLen - 1] == '.') {
            // local part starts or ends with '.'
            $isValid = false;
        } else if (preg_match('/\\.\\./', $local)) {
            // local part has two consecutive dots
            $isValid = false;
        } else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)) {
            // character not valid in domain part
            $isValid = false;
        } else if (preg_match('/\\.\\./', $domain)) {
            // domain part has two consecutive dots
            $isValid = false;
        } else if (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\", "", $local))) {
            // character not valid in local part unless local part is quoted
            if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\", "", $local))) {
                $isValid = false;
            }
        }
        if ($isValid && !(checkdnsrr($domain, "MX") || checkdnsrr($domain, "A"))) {
            // domain not found in DNS
            $isValid = false;
        }
    }
    return $isValid;
}


//Used to create a dropdown box, need list to require name and id
function dropdown($result, $type, $select = 1) {
    echo '<select name="' . $type . '">';
    
    // Loop through each index of the result
    foreach ($result as $row) {
        echo '<option value="' . $row['id'] . '" ';
        
        // Select the option if it is the same as the one selected in the database
        if ($select == $row['id']) {
            echo 'selected="selected"';
        }

        echo '>' . $row['name'] . '</option>';
    }
    
    echo '</select>';
}


// Used to create a dropdown box for hour of the day
function dropdown_hour() {
    echo'<select name="hour" class="hour">';

    // Loop 1 to 12 for AM
    for ($i = 1; $i <= 12; $i++) {
        echo'<option value="';

        // Insert preceeding zero if less than 10
        if ($i<10) {
            echo '0';
        }

        echo $i.'">'.$i.'am</option>';
    }

    // Loop 1 to 12 for PM
    for ($i = 1; $i <= 12; $i++) {
        echo'<option value="';
        echo ($i+12).'">'.$i.'pm</option>';
    }

    echo '</select>';
}


// Used to create a dropdown box for numbers
function dropdown_num($name, $start, $max, $increment=1, $index=1) {
    echo '<select name="'.$name.'" class="number">';

    // Loop from start to max and add the incrementer
    for ($i = $start; $i <= $max; $i += $increment) {
        echo'<option ';

        // Select the option if it is the one that is selected in the database
        if ($i==$index) {
            echo 'selected="selected" ';
        }

        echo'value="';

        // Add a leading zero if the number is less than 10
        if ($i<10) {
            echo '0';
        }

        echo $i.'">'.$i.'</option>';
    }

    echo '</select>';
}


//Used to further sanitize user input
function escape_query($str) {
    return strtr($str, array(
        "\0" => "",
        "\'" => "&#39;",
        "'"  => "&#39;",
        '\"' => "&#34;",
        '"'  => "&#34;",
        "\\\\" => "&#92;",
        "\\" => "&#92;",
        // more secure
        "<"  => "&lt;",
        ">"  => "&gt;",
        "\r\n" =>"<br />",
        "\n" => "<br />",
    ));
}


// Displays an error page
function get_error_page($message) {
    require_once('error_page.php');
}


// Makes a dropdown list of dates that the event runs
function get_event_dates($cdate) {
    global $ksdate, $kedate;
    $begin = strtotime($ksdate);
    $end=strtotime($kedate);
    echo '<select name="date">';

    // Loop until the beginning date matches the ending date
    while ($begin<=$end) {
        $display=date('l, F j, Y', $begin);
        $value=date('Y-m-d', $begin);
        echo '<option value="'.$value.'"';

        // If the current date is the same as this date, then select it
        if ($cdate==$value) {
            echo ' selected="selected"';
        }

        echo '>'.$display.'</option>';
        $begin+=(24*60*60);
    }

    echo '</select>';
}


// Used to verify that the current user is an autocrat (or co-autocrat) of the upcoming KWDS
function is_autocrat($id,$n) {
    $db = new db;

    // Checks to see if the user is logged in
    if (isset($_SESSION['user_id'])) {
        $result = $db->get_user_job($_SESSION['user_id'], $n);

        // If your job id# equals 1, 2, or 16 then you are an autocrat type-figure
        if (count($result) > 0 && ($result[0]['id'] == 1 || $result[0]['id'] == 2 || $result[0]['id'] == 16)) {
            return true;
        }
    }

    // If you are a super user, you may also qualify
    if (is_super_user($id)) {
        return true;
    }

    return false;
}


// Used to verify that the current user has access to everything
function is_super_user() {
    if ($_SESSION['user_id'] == 1) {
        return true;
    }

    return false;
}


// Random Character Generator
function random_gen($length) {
    $random = "";
    srand((double) microtime() * 1000000);
    $char_list = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $char_list .= "abcdefghijklmnopqrstuvwxyz";
    $char_list .= "1234567890";

    // Loop through until a number of times equal to the length
    for ($i = 0; $i < $length; $i++) {
        $random .= substr($char_list, (rand() % (strlen($char_list))), 1);
    }

    return $random;
}


// A redirection function
function redirect($location, $page_id = '', $id = '') {
    switch ($location) {
        default:
        case 'index':
            $url = 'index.php';
            $message = 'Redirecting to main page... ';
            break;
        case 'login':
            $url = 'login.php';
            $message = 'Redirecting to login page... ';
            break;
        case 'profile':
            $url = 'profile.php';
            $message = 'Redirecting to your profile page... ';
            break;
        case 'schedule':
            $url = 'schedule.php';
            $message = 'Redirecting to the schedule page... ';
            break;
        case 'staff':
            $url = 'staff.php';
            $message = 'Redirecting to the staff editing page... ';
            break;
    }

    echo '
<script type="text/javascript">
    setTimeout(function () {window.location.href= "' . $url . '";},3000);
</script>';
    echo $message . ' <a href="' . $url . '">Click here to proceed</a>.';
}


// A function to reverse the effects of the escape_query() function
function redisplay($str) {
    return strtr($str, array(
        "&#39;" => "'",
        "&#34;" => '"',
        //"&#92;" => "\\",
        "<br />" => "\n",
        "&lt;" => "<",
        "&gt;" => ">",
    ));
}


// Converts an integer to Roman numerals
function roman($integer) {
    $integer = intval($integer);
    $result = '';
    $lookup = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90,
        'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);

    // Loop for number replacement
    foreach ($lookup as $roman => $value) {
        $matches = intval($integer / $value);
        $result .= str_repeat($roman, $matches);
        $integer = $integer % $value;
    }

    return $result;
}


//  A function to sanitize input
function sanit($input) {
    $input2 = escape_query($input);
    $output = mysql_real_escape_string($input2);
    return $output;
}

?>
