 <script type="text/javascript">
    setInterval("my_function();",1000); 
    function my_function(){
      $('#time').load(location.href + ' #time');
    }
  </script>