<?php

/** Get list of all countries */
require_once './Country.php';

/** Load the dropdown with countries */
$countries = (new Country)->getAllCountries();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dependency Dropdown Demo</title>
    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>
    <div class="container">
        <h3 class="text-center">Dependency Dropdown Demo</h3>
        <div class="dropdown">
            <div><label for="country">Country <small class="country-status"></small></label></div>
            <div>
                <select name="country" id="country">
                    <option value="">Select Country</option>
                    <?php
                    /** We get list of all the countries from the above PHP query
                     * If you need you can even trigger on page load
                     */
                    foreach ($countries as $country) {
                    ?>
                        <option value="<?php echo $country->id; ?>"><?php echo $country->name; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="dropdown">
            <div><label for="state">State <small class="state-status"></small></label></div>
            <div>
                <!-- On page load we wont be using states, 
                    as we will load it after selecting country -->
                <select name="state" id="state">
                </select>
            </div>
        </div>
        <div class="dropdown">
            <div><label for="city">City <small class="city-status"></small></label></div>
            <div>
                <!-- On page load we wont be using cities too, 
                    as we will load it after selecting state -->
                <select name="city" id="city">
                </select>
            </div>
        </div>
    </div>
    <script src="./assets/js/jquery.js"></script>
    <script src="./assets/js/states_by_country.js"></script>
    <script src="./assets/js/cities_by_state.js"></script>
</body>

</html>