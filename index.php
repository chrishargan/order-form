<?php


//this line makes PHP behave in a more strict way
declare(strict_types=1);

//we are going to use session variables so we need to enable sessions
session_start();

function whatIsHappening() {
    echo '<h2>$_GET</h2>';
    var_dump($_GET);
    echo '<h2>$_POST</h2>';
    var_dump($_POST);
    echo '<h2>$_COOKIE</h2>';
    var_dump($_COOKIE);
    echo '<h2>$_SESSION</h2>';
    var_dump($_SESSION);
}
whatIsHappening();

//your products with their price.
$food = [
    ['name' => 'Club Ham', 'price' => 3.20],
    ['name' => 'Club Cheese', 'price' => 3],
    ['name' => 'Club Cheese & Ham', 'price' => 4],
    ['name' => 'Club Chicken', 'price' => 4],
    ['name' => 'Club Salmon', 'price' => 5]
];

$drinks = [
    ['name' => 'Cola', 'price' => 2],
    ['name' => 'Fanta', 'price' => 2],
    ['name' => 'Sprite', 'price' => 2],
    ['name' => 'Ice-tea', 'price' => 3],
];
if(isset($_SESSION['food']) && !isset($_GET['food'])){
    $_GET['food'] = $_SESSION['food'];
}
if(!isset($_GET['food']) || $_GET['food'] === '1'){
    $products = $food;
    $_SESSION['food'] = $_GET['food'];
} else {
    $products = $drinks;
    $_SESSION['food'] = $_GET['food'];
}

$totalValue = 0;


function handleOrder(){



   $timeNow= new DateTime();
   if (isset($_POST['express_delivery'])) {
       $timeAdded = "PT45M";}
       else {$timeAdded = "PT120M";
       }
       $interval = new DateInterval($timeAdded);
       $deliveryTime = $timeNow ->add($interval);
       echo "Your order is complete!";
       echo "you ordered with email= {$_SESSION['email']}<br>";
       echo "The delivery will arrive at {$_SESSION['street']}{$_SESSION['streetnumber']} in {$_SESSION['city']}<br>";
       echo "Expected delivery time / " . $deliveryTime ->format("H:i");
       session_destroy();
       die();
   }

function handleRest() {
    echo "<div class=\"alert alert-danger\" role=\"alert\"> Please fill in all required fields</div>";
}

function validateForm(){
    $email = $_POST['email'];
    $street = $_POST['street'];
    $streetNumber = $_POST['streetnumber'];
    $city = $_POST['city'];
    $zipcode = $_POST['zipcode'];

    if(empty($email) || !filter_var($email, FILTER_SANITIZE_EMAIL)){
        echo "<div class=\"alert alert-danger\" role=\"alert\"> Please fill in a valid email.</div>";
    } else{
        $_SESSION['email'] = trim($email);
    }
    if(empty($street)){
        echo "<div class=\"alert alert-danger\" role=\"alert\"> Please fill in your street name.</div>";
    } else {
        $_SESSION['street'] = trim($street);
    }
    if(empty($streetNumber) || !is_numeric($streetNumber)){
        echo "<div class=\"alert alert-danger\" role=\"alert\"> Please fill in a valid street number.</div>";
    } else {
        $_SESSION['streetnumber'] = trim($streetNumber);
    }
    if(empty($city)){
        echo "<div class=\"alert alert-danger\" role=\"alert\"> Please fill in the city.</div>";
    } else {
        $_SESSION['city'] = trim($city);
    }
    if(empty($zipcode) || !is_numeric($zipcode)){
        echo "<div class=\"alert alert-danger\" role=\"alert\"> Please fill in a valid zipcode.</div>";
    } else {
        $_SESSION['zipcode'] = trim($zipcode);
    }
    if(empty($email) || !filter_var($email, FILTER_SANITIZE_EMAIL) || empty($street) ||
        empty($streetNumber) || !is_numeric($streetNumber) || empty($city) || empty($zipcode) || !is_numeric($zipcode)){
        handleRest();
    } else {
        handleOrder();
    }
}
if($_SESSION['isStarted']){
    validateForm();
} else {
    $_SESSION['isStarted'] = true;
}



/*
if(isset($_POST['email'])) {

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo("Thank you");
    } else {
        echo("$email is not a valid email address");
    }
//validate numbers
    if (is_numeric($streetNumber)) {
        var_dump($streetNumber);
    } else {
        echo ($streetNumber. "is not a number");
    }
    $mailTo = "@.com";
  //  $headers = "From:" . $email;
    $txt = "You have received an order from".$email.".\n\n".$street.$streetNumber.".\n".$city.$zipcode;

  //  mail($mailTo, $txt, $headers);
  //  header("Location: form-view.php?mailsend");
}
 */

// input validation

$emailError = $streetError = $streetNumberError = $cityError = $zipcodeError = "";
$email = $street = $city = "";



require 'form-view.php';