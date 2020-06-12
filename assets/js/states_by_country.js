/** On change of Country dropdown trigger the following code  */
$('#country').on('change', function() {
    /** Variable to hold countryId */
    var countryId = $(this).val();
    /** Variable to hold countryStatus */
    var countryStatus = $('.country-status');

    /** Validate country */
    if (countryId == 'undefined' || countryId == '') {
        countryStatus.html('Please select country');
        return false;
    }
    countryStatus.html('');

    /** Load the states based on the country selected using AJAX call */
    getStatesByCountryId(countryId);
});


/** Function to implement the AJAX states fetching  */
function getStatesByCountryId(countryId) {
    var countryStatus = $('.country-status');
    countryStatus.html('Loading states...');

    /** AJAX Request to API to fetch states */
    $.ajax({
        "url": "api/state_by_country.php",
        "type": "POST",
        "dataType": "JSON",
        "data": {
            country_id: countryId
        },
        "success": function(retObj) {
            /** Check if the ajax request return data had any error */
            if (retObj.status == 'error') {
                countryStatus.html(retObj.error);
                return false;
            }

            /** If the ajax request return data was success */
            /** Variable to store the states records */
            var states = retObj.data.states;
            var stateOptions = '<option value="">Select State</option>';

            /** Loop through states and append to state select dropdown */
            $.each(states, function(key, state) {
                stateOptions += "<option value='" + state.id + "'>" + state.name + "</option>"
            });
            $('#state').html(stateOptions);
            countryStatus.html('');
        }
    });
}