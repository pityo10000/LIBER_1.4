$(document).ready(function() {
  $(document).on('click', 'a[id="reservation"]', function() {

    var element = $(this);
    var amount = null;
    var data_array = null;
    var action = $(this).parent().parent().parent().find('input[name="action"]').val();
    var item_id = $(this).parent().parent().parent().find('input[name="item_id"]').val();
    var event_id = $(this).parent().parent().parent().find('select[name="event_id"]').val();
    var company_id = $(this).parent().parent().parent().find('input[name="company_id"]').val();

    if (action == "event_equipment_insert") {
      amount = $(this).parent().parent().parent().find('input[name="amount"]').val();
      data_array = {amount: amount, equipment_id: item_id, event_id: event_id, company_id: company_id};
    } else if (action == "event_service_insert") {
      data_array = {service_id: item_id, event_id: event_id, company_id: company_id};
    }

      $.ajax({
          type: "POST",
          url: "sql/insert/" + action + ".php",
          data: data_array,
          success: function(data){
            element.parent().parent().parent().find('p[class="error_message"]').text(data);

            if (data == "") {
              element.parent().parent().parent().parent().parent().parent().find('button[id="close"]').click();

              $(document).find('#info').append('<div class="alert alert-success">Sikeres foglalás!</div>');

              setTimeout(
                function()
                {
                  $(document).find('#info').empty();
                }, 5000);
            }
          }
      });

  });

});
