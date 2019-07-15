<!-- Error if exists -->
<?php if (isset($error_msg)) { ?>
<div class="alert alert-danger" role="alert">
    <?php echo $error_msg;
    unset($error_msg); ?>
</div>
<?php 
} ?>

<!-- Succ if exists -->
<?php if (isset($succ_msg)) { ?>
<div class="alert alert-success" role="success">
    <?php echo $succ_msg;
    unset($succ_msg); ?>
</div>
<?php 
} ?>

<!-- Tabs -->

<ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-top: 10px;">
    <li class="nav-item">
        <a class="nav-link active" id="add-genre-tab" data-toggle="tab" href="#add-genre" role="tab" aria-controls="add-genre" aria-selected="true">Kategória hozzáadása</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="list-genres-tab" data-toggle="tab" href="#list-genres" role="tab" aria-controls="list-genres" aria-selected="false">Kategóriák listázása</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="add-subgenre-tab" data-toggle="tab" href="#add-subgenre" role="tab" aria-controls="add-subgenres" aria-selected="false">Alkategória hozzáadása</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="list-subgenres-tab" data-toggle="tab" href="#list-subgenres" role="tab" aria-controls="list-subgenres" aria-selected="false">Alkategóriák listázása</a>
    </li>
</ul>
<div class="tab-content" id="myTabContent">
    <!-- Kategória hozzáadása tab -->
    <div class="tab-pane fade show active" id="add-genre" role="tabpanel" aria-labelledby="add-genre-tab">
        <div class="container-fluid">
            <form method="post" action="<?php echo base_url('genrecontroller/addgenre') ?>" style="margin-top: 20px; margin-left 20px;">
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Kategória neve</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Név" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Hozzáadás</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Könyvek listázása tab -->
    <div class="tab-pane fade" id="list-genres" role="tabpanel" aria-labelledby="list-genres-tab">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Név</th>
                    <th class="text-center" scope="col">Művelet</th>
                </tr>
            </thead>
            <tbody>     
                <?php foreach($genres as $genre) { 
                    echo "<tr id=".$genre->GENREID.">";
                    echo "<td>".$genre->GENREID."</td>";
                    echo "<td>".$genre->NAME."</td>";
                    echo "<td class='removeg text-center'>";
                    echo "<button type='button' class='btn btn-outline-danger btn-xs'>";
                    echo "<i class='fa fa-trash' aria-hidden='true'></i>";
                    echo "</button>";
                    echo "</td>";
                    echo "</tr>"; 
                } ?>
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade show" id="add-subgenre" role="tabpanel" aria-labelledby="add-subgenre-tab">
        <div class="container-fluid">
            <form method="post" action="<?php echo base_url('genrecontroller/addsubgenre') ?>" style="margin-top: 20px; margin-left 20px;">
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Alkategória neve</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Név" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="genre" class="col-sm-2 col-form-label">Kategória</label>
                    <div class="col-sm-10">
                        <select class="custom-select" id="genre" name="genre" required>
                            <option value="-1" selected>Válassz kategóriát</option>
                            <?php foreach ($genres as $genre) { ?>
                            <option value="<?php echo $genre->GENREID ?>"><?php echo $genre->NAME ?></option>
                            <?php 
                        } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Hozzáadás</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="tab-pane fade" id="list-subgenres" role="tabpanel" aria-labelledby="list-subgenres-tab">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Név</th>
                    <th scope="col">Kategória</th>
                    <th class="text-center" scope="col">Művelet</th>
                </tr>
            </thead>
            <tbody>     
                <?php foreach($subgenres as $subgenre) { 
                    echo "<tr id=".$subgenre->SUBGENREID.">";
                    echo "<td>".$subgenre->SUBGENREID."</td>";
                    echo "<td>".$subgenre->NAME."</td>";
                    echo "<td>".$subgenre->GENRENAME."</td>";
                    echo "<td class='removesg text-center'>";
                    echo "<button type='button' class='btn btn-outline-danger btn-xs'>";
                    echo "<i class='fa fa-trash' aria-hidden='true'></i>";
                    echo "</button>";
                    echo "</td>";
                    echo "</tr>"; 
                } ?>
            </tbody>
        </table>
    </div>
</div>

<script>
$('td.removeg').on('click', function(){
    var id = $(this).parent().attr('id');
    $.ajax({
        url: '<?php echo base_url('genrecontroller/deletegenre'); ?>',
        method: 'post',
        data: {id: id},
        success: function(data){
            location.reload();
            alert('Kategória törölve!');
        },
        error: function(data) {
            alert('Hiba!');
        }
    });
});

$('td.removesg').on('click', function(){
    var id = $(this).parent().attr('id');
    $.ajax({
        url: '<?php echo base_url('genrecontroller/deletesubgenre'); ?>',
        method: 'post',
        data: {id: id},
        success: function(data){
            location.reload();
            alert('Alkategória törölve!');
        },
        error: function(data) {
            alert('Hiba!');
        }
    });
});
</script>