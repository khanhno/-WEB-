<script type="text/javascript">
  $(document).ready(function()
  {$("#insertbtn").click(function(e) {
    e.preventDefault();
    $.ajax({
      method: "post",
      url: "insertdata.php",
      data: $("#vedformid").serialize(),
      dataType: "text",
      success: function(response) {
        $("#messagedisplay1").text(response);
      }
    });
  })}
  ); $(document).ready(function()
  {$("#displaybtn").click(function(e) {
    e.preventDefault();
    $.ajax({
      method: "post",
      url: "fetchdata.php",
      data: $("#displaydata").serialize(),
      dataType: "html",
      success: function(response) {
        $("#messagedisplay2").html(response);
      }
    });
  })}
  );
</script>;
