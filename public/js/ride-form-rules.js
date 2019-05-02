$( function() {
    setDatePicker( 'ride_pickUpDate' );
    setDatePicker( 'ride_dropOffDate' );
    $('#ride_pickUpDate').change(function(){
        if( ! $('#ride_dropOffDate').val() ){
            $('#ride_dropOffDate').val( $(this).val());
        }
        calculateTimeDifference();
    });
    $('#ride_dropOffDate').change(function(){
        calculateTimeDifference();
    });
    $('#ride_pickUpTime_hour').change(function(){
        calculateTimeDifference();
    });
    $('#ride_pickUpTime_minute').change(function(){
        calculateTimeDifference();
    });
    $('#ride_dropOffTime_hour').change(function(){
        calculateTimeDifference();
    });
    $('#ride_dropOffTime_minute').change(function(){
        calculateTimeDifference();
    });
    autoCompleteSearchForm( ['ride_pickUp','ride_dropOff'] );

} );

function calculateTimeDifference(){
    let pickup_date = germanToDateFormat( $('#ride_pickUpDate').val() )+' '+ $('#ride_pickUpTime_hour').val()+':'+ $('#ride_pickUpTime_minute').val();
    let dropoff_date = germanToDateFormat( $('#ride_dropOffDate').val() ) +' '+ $('#ride_dropOffTime_hour').val()+':'+ $('#ride_dropOffTime_minute').val();

    let timeStamp =  ( new Date(dropoff_date).getTime() ) - ( new Date( pickup_date ).getTime() );

    if( timeStamp <= 0){
        $('#ride_duration_span').html( timeStampToDate( timeStamp ) );
        $('#ride_duration_container').addClass('bg-danger');
        $('#ride_save').prop("disabled",true);

    } else {
        $('#ride_duration_span').html( timeStampToDate( timeStamp ) );
        $('#ride_duration_container').removeClass('bg-danger');
        $('#ride_save').prop("disabled",false);
    }

}

function timeStampToDate( timestamp_in ) {
    console.log( "timestamp_in " + timestamp_in  );
    if( timestamp_in !== undefined ){
        let results = "", time_stamp = parseInt( timestamp_in );
        let sec_num = ( time_stamp ) / 1000;
        let days    = Math.floor(sec_num  / 86400);
        let hours   = Math.floor((sec_num - (days * (3600 * 24)))/3600);
        let minutes = Math.floor((sec_num - (days * (3600 * 24)) - (hours * 3600)) / 60);
        if (hours   < 10) {hours   = "0"+hours;}
        if (minutes < 10) {minutes = "0"+minutes;}

        return  days+':'+ hours+':'+minutes;
    }

}
function germanToDateFormat( d_str_in ){
    let d_str = d_str_in.trim();
    if(d_str && d_str.length == 10){
        var res = d_str.split(".");
        return res[2] + '-' + res[1] +'-'+ res[0];
    }
}