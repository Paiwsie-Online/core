$('#page-header-notifications-dropdown').click(()=>{
   $('#notificationDropdownDiv').load('/notification/dropdown');

});

$('#notificationDropdownDiv').on('click', function(event){
   event.stopPropagation();
});

setInterval(()=>{
   $.get( "/notification/count", (data) => {
      let counters = JSON.parse(data);
      $('#notificationBellBadgeCount').html(counters.total);
      if (counters.total === 0) {
         $('#notificationBellBadge').hide();
      } else {
         $('#notificationBellBadge').show();
      }
      if( $('#messageCounterSpan').length )
      {
         $('#messageCounterSpan').html('('+counters.messages+')')
         if (counters.messages === 0) {
            $('#messageCounterSpan').hide();
         } else {
            $('#messageCounterSpan').show();
         }
      }
      if( $('#alertCounterSpan').length )
      {
         $('#alertCounterSpan').html('('+counters.alerts+')')
         if (counters.alerts === 0) {
            $('#alertCounterSpan').hide();
         } else {
            $('#alertCounterSpan').show();
         }
      }
      if( $('#totalNotificationsBadge').length )
      {
         $('#totalNotificationsBadgeNumber').html('('+counters.total+')')
         if (counters.total === 0) {
            $('#totalNotificationsBadge').hide();
         } else {
            $('#totalNotificationsBadge').show();
         }
      }
   });

}, 1000);

function setRead(id) {
   $.get( "/notification/read?id="+id);
}