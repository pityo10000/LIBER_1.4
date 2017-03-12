$(document).ready(function() {

  loadMessagePartners();
  loadMessages();
  setInterval(function() {

    $.urlParam = function(name){
      var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
      return results[1] || 0;
    }

    var partner_id = $.urlParam('partner');


    $.ajax({
        url : 'sql/query/message_query.php?partner=' + partner_id,
        type: 'POST',
        data: {partner_id: partner_id, count: true},
        success: function(data, textStatus, jqXHR) {
          if (data != $('input[name^="count"]').val()) {
            loadMessages();
            $('input[name^="count"]').val(data);
          }
        }
    });
  }, 1000);


  $(document).on('click', 'a[id^="message_submit"]', function() {

    $.urlParam = function(name){
      var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
      return results[1] || 0;
    }

    var partner_id = $.urlParam('partner');
    var message_content = $(this).parent().parent().find('textarea[name=message_content]');

    if (message_content.val() != "") {
      $.ajax({
          url : 'sql/insert/message_insert.php',
          type: 'POST',
          data: {message_content: message_content.val(), partner_id: partner_id},
          success: function(data, textStatus, jqXHR) {
            message_content.val("");
          }
      });
    }

  });
});

  function loadMessagePartners() {
      $(function() {
        $.get("sql/query/message_partner_query.php", function(data){
          $('#partners').html(data);
      });
    });
  }

  function loadMessages() {

      $(function() {

        $.urlParam = function(name){
        	var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        	return results[1] || 0;
        }

        var partnerId = $.urlParam('partner');

        $.get("sql/query/message_query.php?partner=" + partnerId, function(data){
          $('#messages').html(data);
      });
    });
  }


  /*$("#messageSubmit").click(function() {
    var messageContent = $("#messageContent").val();
    var partnerId = $("#partnerId").val();
    var action = $("#action").val();

    $.ajax({
      url: "index.php?nav=messages&partner=" + $("#partnerId").val(),
      type: "POST",
      async: true,
      data: {
        "messageContent": messageContent,
        "partnerId": partnerId,
        "action": action,
      },
      success: function(data){
        var value =  $("#messageContent").val();

        $("#messagePanel").append(value);

        $("#messageContent").val("");
      }
    })
  });
});*/
