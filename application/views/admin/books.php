<!-- Tabs -->

<ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-top: 10px;">
    <li class="nav-item">
        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
            aria-selected="true">Könyv hozzáadása</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
            aria-selected="false">Könyvek listázása</a>
    </li>
</ul>
<div class="tab-content" id="myTabContent">
    <!-- Könyvek tab -->
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <div class="container-fluid">
            <form method="post" action="<?php echo base_url('bookcontroller/uploadbook') ?>" enctype='multipart/form-data'
                style="margin-top: 20px; margin-left 20px;">
                <!-- Szerző -->
                <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">Szerző</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="author" name="author" placeholder="Szerző">
                    </div>
                </div>
                <!-- Cím -->
                <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">Cím</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="title" name="title" placeholder="Cím">
                    </div>
                </div>
                <!-- Kategória -->
                <div class="form-group row">
                    <label for="genre" class="col-sm-2 col-form-label">Kategória</label>
                    <div class="col-sm-10">
                        <select class="custom-select" id="genre" name="genre">
                            <option value="-1" selected>Válassz kategóriát</option>
                            <?php foreach ($genres as $genre) { ?>
                            <option value="<?php echo $genre->GENREID ?>"><?php echo $genre->NAME ?></option>
                            <?php 
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
                        <input type="number" class="form-control" id="isbn" name="isbn" placeholder="ISBN">
                    </div>
                </div>
                <!-- Kiadás éve -->
                <div class="form-group row">
                    <label for="publishdate" class="col-sm-2 col-form-label">Kiadás éve</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="publishdate" name="publishdate"
                            placeholder="Kiadás éve" min="1500" max="<?php echo date('Y') ?>">
                    </div>
                </div>
                <!-- Kiadó -->
                <div class="form-group row">
                    <label for="publisher" class="col-sm-2 col-form-label">Kiadó</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="publisher" name="publisher" placeholder="Kiadó">
                    </div>
                </div>
                <!-- Oldalszám -->
                <div class="form-group row">
                    <label for="pagenumber" class="col-sm-2 col-form-label">Oldalszám</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="pagenumber" name="pagenumber"
                            placeholder="Oldalszám">
                    </div>
                </div>
                <!-- Kötés -->
                <div class="form-group row">
                    <label for="binding" class="col-sm-2 col-form-label">Kötés</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="binding" name="binding" placeholder="Kötés">
                    </div>
                </div>
                <!-- Leírás -->
                <div class="form-group row">
                    <label for="description" class="col-sm-2 col-form-label">Leírás</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="description" name="description"
                            placeholder="Leírás"></textarea>
                    </div>
                </div>
                <!-- Boritókép -->
                <div class="form-group row">
                    <label for="coverimage" class="col-sm-2 col-form-label">Borítókép</label>
                    <div class="col-sm-10">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="customFile" name="customFile" required>
                            <label class="custom-file-label" for="covercustomFileimage">Choose file</label>
                        </div>
                    </div>
                </div>  
                <div class="form-row d-flex justify-content-center">
                    <label for="store" class="col-sm-2 col-form-label">Áruház</label>
                    <div class="form-group col-sm-2">
                        <select class="custom-select" id="store" name="store">
                            <option value="-1" selected>Válassz áruházat</option>
                            <?php foreach ($stores as $store) { ?>
                            <option value="<?php echo $store->STOREID ?>"><?php echo $store->NAME ?></option>
                            <?php 
                    } ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-2">
                        <input type="number" class="form-control" id="price" name="price" placeholder="Ár">
                    </div>
                    <div class="form-group col-sm-2">
                        <input type="number" class="form-control" id="db" name="db" placeholder="Darabszám">
                    </div>
                    <span class="col-sm-4" id="curr" style="cursor: pointer;">
                        <i class="fas fa-plus-square fa-2x"></i>
                    </span>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" id="submit" class="btn btn-primary">Hozzáadás</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Könyvek listázása tab -->
    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Szerzők</th>
                    <th scope="col">Cím</th>
                    <th scope="col">ISBN</th>
                    <th scope="col">Kiadás éve</th>
                    <th scope="col">Adatbázisba bekerült</th>
                    <th class="text-center" scope="col">Művelet</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($books as $book) { 
                    echo "<tr id='".$book->ISBN."'>";
                    echo "<td>";
                    $first = true;
                    foreach($book->AUTHORS as $author) {
                        echo $first ? $author->NAME : " & ".$author->NAME;
                        $first = false;
                    }
                    echo "</td>";
                    echo "<td>".$book->TITLE."</td>";
                    echo "<td>".$book->ISBN."</td>";
                    echo "<td>".$book->PUBLISHDATE."</td>";
                    echo "<td>".$book->DATECREATED."</td>";
                    echo "<td class='text-center'>";
                    echo "<button type='button' class='btn btn-outline-danger btn-xs remove'>";
                    echo "<i class='fa fa-trash' aria-hidden='true'></i>";
                    echo "</button>";
                    echo '<a href="'.base_url('book/update/'.$book->ISBN).'" class="btn btn-outline-info btn-xs" style="margin-left:5px">';
                    echo "<i class='fa fa-box' aria-hidden='true'></i>";
                    echo "</a>";
                    echo "</td>";
                    echo "</tr>";
                } ?>
            </tbody>
        </table>
    </div>
</div>

<script>
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

let counter = 0;
let item = $("#curr");

item.on('click', function(){
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

$('button.remove').on('click', function(){
    var isbn = $(this).closest('tr').attr('id');
    $.ajax({
        url: '<?php echo base_url('bookcontroller/removebook'); ?>',
        method: 'post',
        data: {isbn: isbn},
        success: function(data){
            location.reload();
        },
        error: function(data) {
            alert(data);
        }
    });
});

</script>