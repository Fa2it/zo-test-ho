$( function() {
    $( "#ride_date" ).datepicker({
        changeMonth: true,
        changeYear: true,
        dayNamesMin: [ "Su","Mo","Di", "Mi","Do","Fr","Sa"],
        dateFormat : "dd.mm.yy",
        monthNames: [ "Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember" ],
        monthNamesShort:[ "Jan", "Feb", "Mär", "Apr", "Mai", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dez" ],
        minDate: 0,
    });

    $('#ride_duration').timepicker({ 'timeFormat': 'H:i', 'step': 5  });
    $('#ride_time').timepicker({ 'timeFormat': 'H:i' });

    setDefaultDate();
    autoCompleteSearchForm();
    searchResult();


} );



function setDefaultDate(){
    let d = new Date();
    d.setMinutes(d.getMinutes()+30);
    let year = d.getFullYear(),
        month =  setLessThan10( d.getMonth() + 1 ),
        days = setLessThan10( d.getDate() ),
        hours = setLessThan10( d.getHours() ),
        minutes = setLessThan10( d.getMinutes() );
    $( "#ride_pickup_date" ).val( days +'.'+ month +'.' + year );
    $('#ride_pickup_time').val(hours +':'+ minutes);
}

function setLessThan10( num ){
    return ( num < 10 ) ? '0'+ num : num;
}

function autoCompleteSearchForm(){
    let searchbuttons = ['start_location', 'end_location'];
    for (index = 0; index < searchbuttons.length; ++index) {

        $( "#"+ searchbuttons[index] ).autocomplete({
            source: function( request, response ) {
                if( request.term ){
                    $.ajax( {
                        url: "/search/location/"+request.term,
                        method:"GET",
                        success: function( data ) {
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

function parsePostleitzahlen( data ){
    let result =[];
    if(data){
        for( var ii = 0; ii< data.length; ii++ ){
            result.push(data[ii].ort );
        }
    }
    //console.log( result );
    return $.unique( result );
    // return [... new Set( result) ];
}

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

function germanToSymfonyDateFormat( date_d , time_d ) {
    // 07.04.2019
    if( date_d && date_d.length === 10  && ( time_d && time_d.length ==5 )){
        return    date_d.substring(6, 10)+"-"+date_d.substring(3, 5) +"-"+date_d.substring(0, 2) + " " + time_d +":00";
    }
}