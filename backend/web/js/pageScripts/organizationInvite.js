//CHANGE USER-GROUP CHECKBOX
$('.usergroupCheckbox').change(function(){
   console.log('changed');
   var userGropsSelected = [];
   $('.usergroupCheckbox').each(function(){
      if (this.checked) {
         userGropsSelected.push($(this).val());
      }
   });
   var params =  {userGroups: userGropsSelected};
   $('#organizationuserrelationinvitation-invite_params').val(JSON.stringify(params));
});






//CHECK USER METHOD CHANGED
function inviteUserMethodChanged(value) {
   if (value === 'email') {
      $('#organizationuserrelationinvitation-input-Mobile').prop('disabled', true);
      $('#organizationuserrelationinvitation-input-Email').prop('disabled', false);
      $('.form-group.field-organizationuserrelationinvitation-input-Mobile').hide(50);
      $('.form-group.field-organizationuserrelationinvitation-input-Email').show(250);
   } else if (value === 'sms') {
      $('#organizationuserrelationinvitation-input-Email').prop('disabled', true);
      $('#organizationuserrelationinvitation-input-Mobile').prop('disabled', false);
      $('.form-group.field-organizationuserrelationinvitation-input-Email').hide(50);
      $('.form-group.field-organizationuserrelationinvitation-input-Mobile').show(250);
   }
}