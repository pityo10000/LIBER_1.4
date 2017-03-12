
$(document).ready(function() {

  loadEvents();

  $(document).on('click', 'a[class^="change_status"]', function() {

    var r = confirm('Biztosan végrekívánja hajtani ezt a műveletet?');
      if (r == true) {
        var newStatus = $(this).parent().find('input[name=newStatus]').val();
        var event_id = $(this).parent().find('input[name=event_id]').val();

        var formData = {newStatus: newStatus, event_id: event_id};



        $.ajax({
            url : 'sql/update/event_update.php',
            type: 'POST',
            data: formData,
            success: function(data, textStatus, jqXHR) {
                loadEvents();
            }
        });

      }
  });

  //Rendezvények lekérdezése
  function loadEvents() {
    $('#events').load('sql/query/event_query.php', function(){

      //Céges felszerelés lekérdezés
      $('.get_event_id').each(function() {
        localEquipmentQuery($(this).val(), $('.get_company_id').val());
      });

      //Céges felszerelés lapozás
      $(document).on('click', '.loc-eq-page', function() {
        $('#local_equipment_' + $(this).attr('id')).load('sql/query/local_equipment_query.php', {event_id: $(this).attr('id'), page: $(this).text(), company_id: $('.get_company_id').val()});
      });

      //Külsős felszerelés lekérdezés
      $('.get_event_id').each(function() {
        externalEquipmentQuery($(this).val(), $('.get_company_id').val());
      });

      //Külsős felszerelés lapozás
      $(document).on('click', '.ext-eq-page', function() {
        $('#external_equipment_' + $(this).attr('id')).load('sql/query/external_equipment_query.php', {event_id: $(this).attr('id'), page: $(this).text(), company_id: $('.get_company_id').val()});
      });

      //Céges szolgáltatás lekérdezés
      $('.get_event_id').each(function() {
        localServiceQuery($(this).val(), $('.get_company_id').val());
        $('#local_service_' + $(this).val()).load('sql/query/local_service_query.php', {event_id: $(this).val(), company_id: $('.get_company_id').val()});
      });

      //Céges szolgáltatás lapozás
      $(document).on('click', '.loc-ser-page', function() {
        $('#local_service_' + $(this).attr('id')).load('sql/query/local_service_query.php', {event_id: $(this).attr('id'), page: $(this).text(), company_id: $('.get_company_id').val()});
      });

      //Céges szolgáltatás lekérdezés
      $('.get_event_id').each(function() {
        $('#external_service_' + $(this).val()).load('sql/query/external_service_query.php', {event_id: $(this).val(), company_id: $('.get_company_id').val()});
      });

      //Céges szolgáltatás lapozás
      $(document).on('click', '.ext-ser-page', function() {
        //$('#external_service_' + $(this).attr('id')).load('sql/query/external_service_query.php', {event_id: $(this).attr('id'), page: $(this).text(), company_id: $('.get_company_id').val()});
        externalServiceQuery($(this).val(), $('.get_company_id').val());
      });

      //Felszerelés, szolgáltatás módosítása
      $(document).on('click', 'a[class^="item_update"]', function() {

        var r = confirm('Biztosan végrekívánja hajtani ezt a műveletet?');
        if (r == true) {
          var event_id = $(this).parent().find('input[name=event_id]').val();
          var item_id = $(this).parent().find('input[name=item_id]').val();
          var action = $(this).parent().find('input[name=action]').val();
          var newStatus = $(this).parent().find('input[name=newStatus]').val();

          var formData = {event_id: event_id, item_id: item_id, newStatus: newStatus};

          $.ajax({
              url : 'sql/update/' + action + '.php',
              type: 'POST',
              data: formData,
              success: function(data, textStatus, jqXHR) {
                  localEquipmentQuery(event_id, $('.get_company_id').val());
                  externalEquipmentQuery(event_id, $('.get_company_id').val());
                  localServiceQuery(event_id, $('.get_company_id').val());
                  externalServiceQuery(event_id, $('.get_company_id').val());
              }
          });

        }
      });

      function localEquipmentQuery(event_id, company_id) {
          $('#local_equipment_' + event_id).load('sql/query/local_equipment_query.php', {event_id: event_id, company_id: company_id});

      }

      function externalEquipmentQuery(event_id, company_id) {
          $('#external_equipment_' + event_id).load('sql/query/external_equipment_query.php', {event_id: event_id, company_id: company_id});
      }

      function localServiceQuery(event_id, company_id) {
          $('#local_service_' + event_id).load('sql/query/local_service_query.php', {event_id: event_id, company_id: company_id});
      }

      function externalServiceQuery(event_id, company_id) {
          $('#external_service_' + event_id).load('sql/query/external_service_query.php', {event_id: event_id, company_id: company_id});
      }
    });
  }
});
