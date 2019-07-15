<!-- Tabs -->

<ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-top: 10px;">
    <li class="nav-item">
        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Áruház hozzáadása</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Áruházak listázása</a>
    </li>
</ul>
<div class="tab-content" id="myTabContent">
    <!-- Könyvek tab -->
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <div class="container-fluid">
            <form method="post" action="<?php echo base_url('storecontroller/addstore') ?>" style="margin-top: 20px; margin-left 20px;">
                <!-- Név -->
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Név</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Név" >
                    </div>
                </div>
                <!-- Cím -->
                <div class="form-group row">
                    <label for="address" class="col-sm-2 col-form-label">Cím</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="address" name="address" placeholder="Cím" >
                    </div>
                </div>
                <!-- Ország -->
                <div class="form-group row">
                    <label for="country" class="col-sm-2 col-form-label">Ország</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="country" name="country" placeholder="Ország" >
                    </div>
                </div>
                <!-- Város -->
                <div class="form-group row">
                    <label for="city" class="col-sm-2 col-form-label">Város</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="city" name="city" placeholder="Város" >
                    </div>
                </div>
                <!-- Postal -->
                <div class="form-group row">
                    <label for="isbn" class="col-sm-2 col-form-label">Irányítószám</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="postal" name="postal" placeholder="Irányítószám" >
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
    <!-- Áruházak listázása tab -->
    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Név</th>
                    <th scope="col">Cím</th>
                    <th scope="col">Ország</th>
                    <th scope="col">Város</th>
                    <th scope="col">Irányítószám</th>
                    <th scope="col" class="text-center">Továbbiak</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($stores as $store) { ?>  
                <tr id="<?php echo $store->STOREID ?>">
                    <td><?php echo $store->STOREID ?></td>
                    <td><?php echo $store->NAME ?></td>
                    <td><?php echo $store->ADDRESS ?></td>
                    <td><?php echo $store->COUNTRY ?></td>
                    <td><?php echo $store->CITY ?></td>
                    <td><?php echo $store->POSTAL ?></td>
                    <td class='remove text-center'>
                    <button type='button' class='btn btn-outline-danger btn-xs'>
                    <i class='fa fa-trash' aria-hidden='true'></i>
                    </button>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script>
$('td.remove').on('click', function(){
    var id = $(this).parent().attr('id');
    $.ajax({
        url: '<?php echo base_url('storecontroller/deletestore'); ?>',
        method: 'post',
        data: {id: id},
        success: function(data){
            location.reload();
            alert('Áruház törölve!');
        },
        error: function(data) {
            alert('Hiba!');
        }
    });
});

</script>
