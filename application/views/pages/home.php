<!-- Alert -->
<?php if ($this->session->userdata('logged') && $this->session->userdata('address') == null) { ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    Még nem töltötted ki a profil adataidat, így nem fogsz tudni rendelést leadni!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<?php 
} ?>

<!-- Breadcumb -->
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page">Könyvek</li>
  </ol>
</nav>


<!-- Filters -->
<form style="margin-bottom: 20px;">
  <div class="form-row d-flex container-fluid justify-content-center">
    <div class="form-group col-lg-2 col-md-4 col-sm-6">
      <label for="title">Szerző vagy cím</label>
      <input type="text" class="form-control" id="filter" name="filter" placeholder="...">
    </div>
    <div class="form-group col-lg-2 col-md-4 col-sm-6">
      <label for="genre">Kategória</label>
        <select class="custom-select" id="genre" name="genre" required>
            <option value="-1" selected>Válassz kategóriát</option>
            <?php foreach ($genres as $genre) { ?>
            <option value="<?php echo $genre->GENREID ?>"><?php echo $genre->NAME ?></option>
            <?php } ?>
        </select>
  </div>
    <div class="form-group col-lg-2 col-md-4 col-sm-6">
      <label for="subgenre">Alkategória</label>
        <select class="custom-select" id="subgenre" name="subgenre" required>
            <option value="-1" selected>Válassz alkategóriát</option>
        </select>
  </div>
  <div class="form-group col-lg-2 col-md-4 col-sm-6">
      <label for="order">Rendezés</label>
        <select class="custom-select" id="order" name="order" required>
            <option value="-1" selected>Rendezés...</option>
            <option value="0">Újak elől</option>
        </select>
</div>
</form>

<!-- Listing -->
<div class="container-fluid" id="container" style="min-height: 500px"></div>

<!-- Scripts -->
<script>

var filters = {};

$(document).ready(function(){
    $('#container').append('<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>');
    setTimeout(getBooks(), 2000);
});

$('#genre').on('change', function(){
    filters['genre'] = $(this).val();
    
    $.ajax({
        url: '<?php echo base_url('genrecontroller/listsubgenresbygenreid') ?>',
        method: 'post',
        data: {
            id: $(this).val()
        },
        success: function(data) {
            $('#subgenre').empty();
            $('#subgenre').append(data);
        }
    });

    $('#container').empty();
    $('#container').append('<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>');
    getBooks();
});

$('#subgenre').on('change', function(){
    filters['subgenre'] = $(this).val();
    $('#container').empty();
    $('#container').append('<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>');
    getBooks();
});

$('#filter').on('change', function() {
    filters['name'] = $(this).val();
    $('#container').empty();
    $('#container').append('<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>');
    getBooks();
});

$('#order').on('change', function() {
    filters['order'] = $(this).val();
    $('#container').empty();
    $('#container').append('<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>');
    getBooks();
});

function getBooks() {
    $.ajax({
        url: '<?php echo base_url('bookcontroller/filterbooks') ?>',
        method: 'post',
        data: filters,
        success: function(data){
            $('#container').empty();
            $('#container').append(data);
        }
    });
}

</script>