<?php
SecurityController::checkAccess(3, 2);
$this->layout('layouts::admin');
?>

<div class="col-md-10 col-sm-12">
    <ol class="breadcrumb">
        <li><a href="<?=APP_URL?>/admin">Accueil</a></li>
        <li><a  class="active" href="<?=APP_URL?>/admin/manageItems">Infrastructure</a></li>
    </ol>
</div>

<?php Theme::loadView('admin/manageItems'); ?>

<script>
$("#categoryForm").on("submit", function(e){
  e.preventDefault();
  $.ajax({
    url: "<?=APP_URL?>/admin/add/category",
    type: "POST",
    data: $(this).serialize(),
    success: function(data){
      $("#notification").html(data);
    }
  });
});

$("#servicesForm").on("submit", function(e){
  e.preventDefault();
  $.ajax({
    url: "<?=APP_URL?>/admin/add/services",
    type: "POST",
    data: $(this).serialize(),
    success: function(data){
      $("#notification").html(data);
    }
  });
});

$(".deleteCategory").on("click", function(){
  $.ajax({
    url: "<?=APP_URL?>/admin/delete/category/"+$(this).attr('category'),
    type: "POST",
    data: $(this).serialize(),
    success: function(data){
      $('#deleteCategory-'+$(this).attr('category')).modal('toggle');
      $("#notification").html(data);
    }
  });
});

$(".deleteAllCategory").on("click", function(){
  $.ajax({
    url: "<?=APP_URL?>/admin/delete/category/all/"+$(this).attr('category'),
    type: "POST",
    data: $(this).serialize(),
    success: function(data){
      $('#deleteCategory-'+$(this).attr('category')).modal('toggle');
      $("#notification").html(data);
    }
  });
});

$("#assignServiceModalID").on("click", function(){
    var serviceId = $(this).attr('service');
    var categoryId = $("#assignedCategory").val();
    $.ajax({
        url: "<?=APP_URL?>/admin/assign/services/"+serviceId+"/to/"+categoryId,
        type: "GET",
        data: "",
        success: function(data){
            $('#assignServiceModal').modal('toggle');
            $("#notification").html(data);
        }
    });
});

$(".deleteService").on("click", function(){
  var id = $(this).attr("service");
  $.ajax({
    url: "<?=APP_URL?>/admin/delete/services/"+id,
    type: "GET",
    data: "",
    success: function(data){
      $("#service_"+id).hide();
      $("#notification").html(data);
    }
  });
});

    var categoryList = [
      <?php
      $api = new API();
      $categories = json_decode($api->getCategories());
      $categories = json_decode(json_encode($categories->data), True);
      if($categories > 0){
          foreach ($categories as $key => $value){
              echo '"'.str_replace('"', "\"", $categories[$key]['name']).'",';
          }
      }
      ?>

    ];

    var value = $('#addCategory').val().toLowerCase();

    function controllCategory(){
        setTimeout(function(){
            value = $('#addCategory').val().toLowerCase();
            if(jQuery.inArray( value, categoryList ) !== -1){
                $("#helpAddCategory").addClass("has-error");
                $("#addCategorySubmit").prop('disabled', true);
                $("#helpAddCategoryValue").html("Ce nom est déjà utilisé !");
            }else{
                $("#helpAddCategory").removeClass("has-error");
                $("#addCategorySubmit").prop('disabled', false);
                $("#helpAddCategoryValue").html("");
            }

            controllCategory();
        }, 0);
    }
    controllCategory();
</script>
<!-- Category controll //////////////////////////////////////////////////////////////////////////////////////////////// -->
