/*****************************************************************************
 *				LIVE-SEARCH BOX
 *****************************************************************************/

/* JS File */

// Start Ready
$(document).ready(function() {
    prepareSearch();
    
    $("input#search").on("keyup", function(e) {
        prepareSearch();
    });

});

function prepareSearch() {
// Set Timeout
    clearTimeout($.data("input#search", 'timer'));

    // Set Search String
    var search_string = $("input#search").val();

    // Do Search
    if (search_string == '') {
        $("ul#results").fadeOut();
        $('h4#results-text').fadeOut();
    } else {
        $("ul#results").fadeIn();
        $('h4#results-text').fadeIn();
        $("input#search").data('timer', setTimeout(search, 100));
    }
}

// Live Search
// On Search Submit and Get Results
function search() {
    var query_value = $('input#search').val();
    $('b#search-string').html(query_value);
    if (query_value !== '') {
        $.ajax({
            type: "POST",
            url: "procura.php",
            data: {query: query_value},
            cache: false,
            success: function(response) {
                $("ul#results").html(response);
            }
        });
    }
    return false;
}