/********************************************************************************************/
/* Datepicker functions                                                                     */
/********************************************************************************************/
function setDatePicker( input_elm ){
    // check if undefined
    if( input_elm === undefined ){
        return false;
    }
    // check if jquery element and its an input element
    if( $('#'+input_elm ).length ){
        $( "#"+input_elm ).datepicker({
            changeMonth: true,
            changeYear: true,
            dayNamesMin: [ "Su","Mo","Di", "Mi","Do","Fr","Sa"],
            dateFormat : "dd.mm.yy",
            monthNames: [ "Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember" ],
            monthNamesShort:[ "Jan", "Feb", "Mär", "Apr", "Mai", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dez" ],
            minDate: 0,
        });
        return true;
    }


}

function setDefaultDate(input_elm ){
    // check if undefined
    if( input_elm === undefined ){
        return false;
    }
    // check if jquery element and its an input element
    if( $('#'+input_elm ).length ) {
        let d = new Date();
        d.setMinutes(d.getMinutes() + 30);
        let year = d.getFullYear(),
            month = setLessThan10(d.getMonth() + 1),
            days = setLessThan10(d.getDate()),
            hours = setLessThan10(d.getHours()),
            minutes = setLessThan10(d.getMinutes());
        $("#"+input_elm ).val(days + '.' + month + '.' + year);
    }
}

function setLessThan10( num ){
    return ( num < 10 ) ? '0'+ num : num;
}

/********************************************************************************************/
/* search form functions                                                                     */
/********************************************************************************************/


function autoCompleteSearchForm( searchbuttons ){
    if( searchbuttons === undefined ){
        return false;
    }
    if( searchbuttons.length ){
        for (index = 0; index < searchbuttons.length; ++index) {

            $( "#"+ searchbuttons[index] ).autocomplete({
                source: function( request, response ) {
                    if( request.term ){
                        $.ajax( {
                            url: "/search/location/"+request.term,
                            method:"GET",
                            success: function( data ) {
                                //console.log( data );
                               response( parsePostleitzahlen( data ) );
                            }
                        } );
                    }

                },
                minLength: 0,
                select: function( event, ui ) {
                    // console.log( "Selected: " + ui.item.value + " aka " + ui.item.id );
                }
            } );

        }
    }

}

function parsePostleitzahlen( data ){
    let result =[];
    if(data){
        for( var ii = 0; ii< data.length; ii++ ){
            result.push(data[ii].ort );
        }
    }
    //console.log( result );
    return $.unique( result );

}


// autoCompleteSearchForm();
// searchResult();

/********************************************************************************************/
/* Search Results Scroll functions                                                          */
/********************************************************************************************/
function searchResult(){
    $("#search_ride").validate({
        rules: {
            start_location:  { required: true },
            end_location:  { required: true },
            ride_date:  { required: true },
            ride_time:  { required: true }
        },
        messages: {
            start_location: "<i class=\"fas fa-exclamation-triangle\"></i>",
            end_location: "<i class=\"fas fa-exclamation-triangle\"></i>",
            ride_date: "<i class=\"fas fa-exclamation-triangle\"></i>",
            ride_time: "<i class=\"fas fa-exclamation-triangle\"></i>",
        },
        submitHandler: function(form, event) {
            event.preventDefault();
            let formArray = $(form).serializeArray(),
                formData = {};
            for ( i = 0; i < formArray.length; i++) {
                formData[formArray[i].name] = formArray[i].value;
            }
            //console.log( formData );
            $.ajax({
                type: $(form).attr('method'),
                url: $(form).attr('action'),
                data: formData,
                success: function (data) {
                    console.log('Submission was successful.');
                    console.log(data.query_results);

                },
                error: function (data) {
                    console.log('An error occurred.');
                    console.log(data);
                },
            });

        }
    });
}
