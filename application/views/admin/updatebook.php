<?php 
$authors = "";

foreach($book->AUTHORS as $author) {
    if(empty($authors)) {
        $authors.=$author->NAME;
    }
    else {
        $authors.=', '.$author->NAME;
    }
}
?>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page">Könyv adatainak frissítése</li>
  </ol>
</nav>

<div class="container-fluid">
<form method="post" action="<?php echo base_url('bookcontroller/updatebook') ?>" style="margin-top: 20px; margin-left 20px;">
    <!-- Szerző -->
    <div class="form-group row">
        <label for="title" class="col-sm-2 col-form-label">Szerző</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="author" name="author" value="<?php echo $authors ?>" disabled />
        </div>
    </div>
    <!-- Cím -->
    <div class="form-group row">
        <label for="title" class="col-sm-2 col-form-label">Cím</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="title" name="title" value="<?php echo $book->TITLE ?>">
        </div>
    </div>
    <!-- Hidden -->
    <div class="form-group row" style="display: none">
        <input type="text" class="form-control" id="subgenreid" name="subgenreid" value="<?php echo $book->SUBGENREID ?>">
    </div>
    <!-- Kategória -->
    <div class="form-group row">
        <label for="genre" class="col-sm-2 col-form-label">Kategória</label>
        <div class="col-sm-10">
            <select class="custom-select" id="genre" name="genre">
                <?php foreach ($genres as $genre) { 
                if($genre->GENREID == $book->GENREID) { ?>
                    <option value="<?php echo $genre->GENREID ?>" selected><?php echo $genre->NAME ?></option>
                <?php } else { ?>
                <option value="<?php echo $genre->GENREID ?>"><?php echo $genre->NAME ?></option>
                <?php }
            } ?>
            </select>
        </div>
    </div>
    <!-- Alkategória -->
    <div class="form-group row">
        <label for="subgenre" class="col-sm-2 col-form-label">Alkategória</label>
        <div class="col-sm-10">
            <select class="custom-select" id="subgenre" name="subgenre">
                <option value="-1" selected>Válassz alkategóriát</option>
            </select>
        </div>
    </div>
    <!-- ISBN -->
    <div class="form-group row">
        <label for="isbn" class="col-sm-2 col-form-label">ISBN</label>
        <div class="col-sm-10">
            <input type="number" class="form-control" id="isbn" name="isbn" value="<?php echo $book->ISBN ?>" readonly />
        </div>
    </div>
    <!-- Kiadás éve -->
    <div class="form-group row">
        <label for="publishdate" class="col-sm-2 col-form-label">Kiadás éve</label>
        <div class="col-sm-10">
            <input type="number" class="form-control" id="publishdate" name="publishdate"
                value="<?php echo $book->PUBLISHDATE ?>" min="1500" max="<?php echo date('Y') ?>">
        </div>
    </div>
    <!-- Kiadó -->
    <div class="form-group row">
        <label for="publisher" class="col-sm-2 col-form-label">Kiadó</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="publisher" name="publisher" value="<?php echo $book->PUBLISHER ?>">
        </div>
    </div>
    <!-- Oldalszám -->
    <div class="form-group row">
        <label for="pagenumber" class="col-sm-2 col-form-label">Oldalszám</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="pagenumber" name="pagenumber"
                value="<?php echo $book->PAGES ?>">
        </div>
    </div>
    <!-- Kötés -->
    <div class="form-group row">
        <label for="binding" class="col-sm-2 col-form-label">Kötés</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="binding" name="binding" value="<?php echo $book->BINDING ?>">
        </div>
    </div>
    <!-- Leírás -->
    <div class="form-group row">
        <label for="description" class="col-sm-2 col-form-label">Leírás</label>
        <div class="col-sm-10">
            <textarea class="form-control" id="description" name="description"><?php echo $book->DESCRIPTION ?></textarea>
        </div>
    </div> 
    <div class="form-group row">
        <div class="col-sm-10">
            <button type="submit" id="submit" class="btn btn-primary">Frissítés</button>
        </div>
    </div>
</form>
</div>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page">Áruházak frissítése</li>
  </ol>
</nav>

<div class="container-fluid">
<form method="post" action="<?php echo base_url('storecontroller/updatebookstore/'.$book->ISBN) ?>">
<?php 
$counter = 0;
foreach($bookstores as $bookstore) { ?>
<div class="form-row d-flex justify-content-center">
<label for="<?php echo "updatestore".$counter ?>" class="col-sm-2 col-form-label">Áruház</label>
<div class="form-group col-sm-2">
    <select class="custom-select" id="<?php echo "updatestore".$counter ?>" name="<?php echo "updatestore".$counter ?>">
        <?php foreach ($stores as $store) { 
            if($bookstore->STOREID != $store->STOREID) {?>
                <option value="<?php echo $store->STOREID ?>"><?php echo $store->NAME ?></option>
            <?php } 
            else { ?>
                <option value="<?php echo $store->STOREID ?>" selected><?php echo $store->NAME ?></option>
            <?php } ?>
        <?php } ?>
    </select>
</div>
<div class="form-group col-sm-2">
    <input type="number" class="form-control" id="<?php echo "updateprice".$counter ?>" name="<?php echo "updateprice".$counter ?>" value="<?php echo $bookstore->PRICE ?>">
</div>
<div class="form-group col-sm-2">
    <input type="number" class="form-control" id="<?php echo "updatedb".$counter ?>" name="<?php echo "updatedb".$counter ?>" value="<?php echo $bookstore->DB ?>">
</div>
<span class="col-sm-4" id="curr" style="cursor: pointer;">&nbsp</span>
</div>
<?php 
$counter++;
} ?>
<div class="form-row d-flex justify-content-center">
<label for="<?php echo "store".$counter ?>" class="col-sm-2 col-form-label">Áruház</label>
<div class="form-group col-sm-2">
    <select class="custom-select" id="<?php echo "store".$counter ?>" name="<?php echo "store".$counter ?>">
        <option value="-1" selected>Válassz áruházat</option>
        <?php foreach ($stores as $store) { ?>
        <option value="<?php echo $store->STOREID ?>"><?php echo $store->NAME ?></option>
        <?php 
} ?>
    </select>
</div>
<div class="form-group col-sm-2">
    <input type="number" class="form-control" id="<?php echo "price".$counter ?>" name="<?php echo "price".$counter ?>" placeholder="Ár">
</div>
<div class="form-group col-sm-2">
    <input type="number" class="form-control" id="<?php echo "db".$counter ?>" name="<?php echo "db".$counter ?>" placeholder="Darabszám">
</div>
<span class="col-sm-4" id="curr" style="cursor: pointer;">
    <i class="fas fa-plus-square fa-2x" id="<?php echo $counter ?>"></i>
</span>
</div>
<div class="form-group row">
<div class="col-sm-10">
    <button type="submit" id="submit" class="btn btn-primary">Frissítés</button>
</div>
</div>
</form>
</div>

<script>
$(document).ready(function(){
    var id = $("#genre").val();
    var subgenreid = $("#subgenreid").val();
    $.ajax({
        url: '<?php echo base_url('genrecontroller/listsubgenresbygenreid') ?>',
        method: 'post',
        data: {
            id: id,
            subgenreid: subgenreid
        },
        success: function(data) {
            $('#subgenre').empty();
            $('#subgenre').append(data);
            console.log(subgenreid);
        }
    });
});

$("#genre").on('change', function() {
    var id = $(this).val();
    $.ajax({
        url: '<?php echo base_url('genrecontroller/listsubgenresbygenreid') ?>',
        method: 'post',
        data: {
            id: id
        },
        success: function(data) {
            $('#subgenre').empty();
            $('#subgenre').append(data);
        }
    });
});

let item = $("#curr");
let counter = item.children('i').attr('id');

item.on('click', function(){
    console.log(counter);
    counter++;
    $('.form-row').last().before(`<div class="form-row d-flex justify-content-center">
                            <label class="col-sm-2 col-form-label">Áruház</label>
                            <div class="form-group col-sm-2">
                                <select class="custom-select">
                                    <option value="-1" selected>Válassz áruházat</option>
                                    <?php foreach ($stores as $store) { ?>
                                    <option value="<?php echo $store->STOREID ?>"><?php echo $store->NAME ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-sm-2">
                                <input type="number" class="form-control" placeholder="Ár">
                            </div>
                            <div class="form-group col-sm-2">
                                <input type="number" class="form-control" id="db" name="db" placeholder="Darabszám">
                            </div>
                            <span class="col-sm-4" class="minus" style="cursor: pointer;">
                                <i class="fas fa-minus-square fa-2x"></i>
                            </span>
                        </div>`);
    let newEl = $('.form-row').last().prev();
    newEl.find("label").attr('for', 'store'+counter);
    newEl.find("select").attr('id', 'store'+counter);
    newEl.find("select").attr('name', 'store'+counter);
    newEl.find("input:first").attr('id', 'price'+counter);
    newEl.find("input:first").attr('name', 'price'+counter);
    newEl.find("input:last").attr('id', 'db'+counter);
    newEl.find("input:last").attr('name', 'db'+counter);
    $('.form-row').last().prev().find("span").on('click', function(){
        $(this).parent().remove();
    })
});

</script>