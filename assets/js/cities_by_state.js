/** On change of State dropdown trigger the following code  */
$('#state').on('change', function () {
     /** Variable to hold countryId */
    var countryId = $('#country').val();
     /** Variable to hold stateId */
    var stateId = $(this).val();
     /** Variable to hold countryStatus */
    var countryStatus = $('.country-status');
     /** Variable to hold stateStatus */
    var stateStatus = $('.state-status');

    /** Validate country */
    if (countryId == 'undefined' || countryId == '') {
        countryStatus.html('Please select country');
        return false;
    }

    /** Validate state */
    if (stateId == 'undefined' || stateId == '') {
        stateStatus.html('Please select state');
        return false;
    }
    stateStatus.html('');

    /** Load the cities based on the country and state selected using AJAX call */
    getCitiesByStateId(countryId, stateId);
});


/** Function to implement the AJAX cities fetching  */
function getCitiesByStateId(countryId, stateId) {
    var stateStatus = $('.country-status');
    stateStatus.html('Loading cities...');

    /** AJAX Request to API to fetch cities */
    $.ajax({
        "url": "api/city_by_state.php",
        "type": "POST",
        "dataType": "JSON",
        "data": {
            state_id: stateId,
            /** Even thought I am not using the country field I am passing data so that you may required while your implementation */
            country_id: countryId
        },
        "success": function (retObj) {
             /** Check if the ajax request return data had any error */
            if (retObj.status == 'error') {
                stateStatus.html(retObj.error);
                return false;
            }

            /** If the ajax request return data was success */
            /** Variable to store the cities records */
            var cities = retObj.data.cities;
            var cityOptions = '<option value="">Select City</option>';

            /** Loop through cities and append to city select dropdown */
            $.each(cities, function (key, city) {
                cityOptions += "<option value='" + city.id + "'>" + city.name + "</option>"
            });
            $('#city').html(cityOptions);
            stateStatus.html('');
        }
    });
}