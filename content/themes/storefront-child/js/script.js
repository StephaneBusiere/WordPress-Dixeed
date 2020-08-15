(function($) {
    $(document).ready(function () {
        var ip = "8.8.8.8";
        var api_key = "at_aG914rJ2xVi4M8jSt5PFeJuQEf3Zb";
      $('.comments-load-button').click( function() {
          
        $.getJSON("https://api.ipify.org?format=jsonp&callback=?",
        function(json) {
          //document.write("My public IP address is: ", json.ip);
          $('.comments').html(json.ip); 
          console.log(json.ip)
        }
      );
         
         
          
      });
  
    });
  })(jQuery);

 