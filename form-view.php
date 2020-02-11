<?php

declare(strict_types=1);

if (!(isset($_GET['food']))) {
    $_GET['food'] = 1;
}


if (isset($_POST['products'])) {
    $checkedBoxes = $_POST['products'];
}

$totalPrice = [];

for ($i = 0; count($products[$_GET['food']]) > $i; $i++){
    var_dump($products[$_GET['food']]);
    if (isset($checkedBoxes[$i])){
        array_push($totalPrice,$products[$_GET['food']][$i]['price']);
    }

}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errorArray = [];
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $emailErr = "E-mail is required";
        $email = "";
        array_push($errorArray, $emailErr);
        echo "<p class='btn-danger'>" . $emailErr . "</p>";
    } else {
        $email = $_POST["email"];
        $_SESSION["email"] = $email;
        $emailErr = "";
        array_push($errorArray, $emailErr);
    }

    if (empty($_POST["street"])) {
        $streetErr = "Street name is required";
        array_push($errorArray, $streetErr);
        echo "<p class='btn-danger'>" . $streetErr . "</p>";

    } else {
        $street = ($_POST["street"]);
        $_SESSION["street"] = $street;
        $streetErr = "";
        array_push($errorArray, $streetErr);
    }

    if (empty($_POST["streetNumber"])) {
        $streetNumberErr = "Fill out a street number";
        array_push($errorArray, $streetNumberErr);
        echo "<p class='btn-danger'>" . $streetNumberErr . "</p>";

    } else {
        $streetNumberErr = "";
        $streetNumber = ($_POST["streetNumber"]);
        $_SESSION["streetNumber"] = $streetNumberErr;
        array_push($errorArray, $emailErr);
    }

    if (empty($_POST["city"])) {
        $cityErr = "Fill out a valid city.";
        array_push($errorArray, $cityErr);
        echo "<p class='btn-danger'>" . $cityErr . "</p>";

    } else {
        $city = ($_POST["city"]);
        $_SESSION["city"] = $city;
        $cityErr = "";
        array_push($errorArray, $cityErr);
    }
    if (empty($_POST["zipcode"])) {
        $zipcodeErr = "Fill out a valid zipcode.";
        array_push($errorArray, $zipcodeErr);
        echo "<p class='btn-danger'>" . $zipcodeErr . "</p>";
    } else {
        $zipcode = ($_POST["zipcode"]);
        $_SESSION["zipcode"] = $zipcode;
        $zipcodeErr = "";
        array_push($errorArray, $zipcodeErr);
    }
    if (empty($_POST['express'])) {
        $_GET['express'] = 0;
        $deliveryTime = "in 2 hours";
    } else {
        $express = true;
        $deliveryTime = "in 45 mins";
    }
    if (hasNoErrors($errorArray)) {
        echo "Your order will be delivered " . $deliveryTime;
    } else {

        echo "There are some errors, check the document again";
    }
} else {
    $_SESSION["email"] = "";
    $_SESSION["street"] = "";
    $_SESSION["streetNumber"] = "";
    $_SESSION["city"] = "";
    $_SESSION["zipcode"] = "";
}
function hasNoErrors(array $array): bool
{
    for ($i = 0; count($array) > $i; $i++) {
        if ($array[$i] !== "") {
            return false;
        }
    }
    return true;
}


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" type="text/css"
          rel="stylesheet"/>
    <title>Order food & drinks</title>
</head>
<body>
<div class="container">
    <h1>Order food in restaurant "the Personal VEGAN Processors"</h1>
    <nav>
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" href="?food=1">Order food</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?food=0">Order drinks</a>
            </li>
        </ul>
    </nav>
    <form method="post">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="email">E-mail:</label>
                <input type="text" id="email" name="email" value="<?php echo $_SESSION['email'] ?>"
                       class="form-control"/>
            </div>
            <div></div>
        </div>

        <fieldset>
            <legend>Address</legend>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="street">Street:</label>
                    <input type="text" name="street" id="street" class="form-control"
                           value="<?php echo $_SESSION['street'] ?>">
                </div>
                <div class="form-group col-md-6">
                    <label for="streetnumber">Street number:</label>
                    <input type="number" id="streetnumber" name="streetNumber"
                           value="<?php echo $_SESSION['streetNumber'] ?>" class="form-control">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" class="form-control"
                           value="<?php echo $_SESSION['city'] ?>">
                </div>
                <div class="form-group col-md-6">
                    <label for="zipcode">Zipcode</label>
                    <input type="number" id="zipcode" name="zipcode" class="form-control"
                           value="<?php echo $_SESSION['zipcode'] ?>">
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Products</legend>
            <?php foreach ($products[$_GET['food']] AS $i => $product): ?>
                <label>
                    <input type="checkbox" value="1" name="products[<?php echo $i ?>]"/> <?php echo $product['name'] ?>
                    -
                    &euro; <?php echo number_format($product['price'], 2) ?></label><br/>
            <?php endforeach; ?>
        </fieldset>
        <p>Do you wish to order express?</p> <input type="checkbox" value="1" name="express"><label
                for="express">yes</label>
        <button type="submit" class="btn btn-primary" name="submit">Order!</button>
    </form>

    <footer>You already ordered <strong>&euro; <?php echo $totalValue ?></strong> in food and drinks.</footer>
</div>

<style>
    footer {
        text-align: center;
    }
</style>
</body>
</html>