<script src="https://use.fontawesome.com/c560c025cf.js"></script>

<?php if(count($items) > 0) { ?>
<div class="container">
    <div class="card shopping-cart">
        <div class="card-header bg-dark text-light">
            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
            Kosár tartalma
            <a href="<?php echo base_url('home') ?>" class="btn btn-outline-info btn-sm pull-right">Vásárlás
                folytatása</a>
            <div class="clearfix"></div>
        </div>
        <div class="card-body">
            <!-- PRODUCT -->
            <?php 
            $priceSum = 0;
            foreach($items as $item) { 
            $authors = $item->AUTHORS;
            $priceSum += $item->PRICE;    
            ?>
            <div class="row each">
                <div class="col-12 col-sm-12 col-md-2 text-center">
                    <img class="img-responsive"
                        src="<?php echo base_url('assets/img/covers/'.$item->COVERIMAGE.'.jpg') ?>" alt="prewiew"
                        width="120" height="200   ">
                </div>
                <figcaption class="media-body">
                <a href="<?php echo base_url('book/'.$item->ISBN) ?>">
                        <h6 class="title text-truncate"><?php echo $item->TITLE ?></h6>
                    </a>
                    <dl class="param param-inline small">
                        <dt>ISBN: </dt>
                        <dd><?php echo $item->ISBN ?></dd>
                    </dl>
                    <dl class="param param-inline small">
                                <dt>szerző: </dt>
                                <dd>
                                <?php foreach($authors as $author) { 
                                    if($authors[0]->AUTHORID != $author->AUTHORID) { ?>
                                        , <a href="<?php echo base_url('author/'.$author->AUTHORID) ?>"><?php echo $author->NAME ?></a>
                                    <?php continue; } ?>
                                    <a href="<?php echo base_url('author/'.$author->AUTHORID) ?>"><?php echo $author->NAME ?></a>
                                <?php } ?>
                                </dd>
                                </dl>
                    <dl class="param param-inline small">
                        <dt>kategória: </dt>
                        <a href="<?php echo base_url('genre/'.$item->GENREID) ?>"><dd><?php echo $item->GENRENAME ?></dd></a>
                    </dl>
                    <dl class="param param-inline small">
                        <dt>alkategória: </dt>
                        <a href="<?php echo base_url('subgenre/'.$item->SUBGENREID) ?>"><dd><?php echo $item->SUBGENRENAME ?></dd></a>
                    </dl>
                    <dl class="param param-inline small">
                        <dt>áruház: </dt>
                        <a href="<?php echo base_url('store/'.$item->STOREID) ?>"><dd><?php echo $item->STORENAME ?></dd></a>
                    </dl>

                </figcaption>
                    <div class="col-12 col-sm-12 text-sm-center col-md-4 text-md-right row">
                        <div class="col-3 col-sm-3 col-md-6 text-md-right" style="padding-top: 5px">
                            <h6>
                                <span class="eachprice"><?php echo $item->PRICE ?></span>
                                <span class="text-muted"> Ft</span>
                            </h6>
                        </div>
                        <div class="col-4 col-sm-4 col-md-4">&nbsp</div>
                        <div class="col-2 col-sm-2 col-md-2 text-right">
                            <button id="<?php echo $item->CARTID ?>" type="button" class="btn btn-outline-danger btn-xs deletefromcart">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
            </div>
            <hr>
            <?php } ?>
        </div>
        <div class="card-footer">
            <div class="pull-right" style="margin: 10px">
                <a href="<?php echo base_url('cartcontroller/order') ?>" class="btn btn-success pull-right">Vásárlás</a>
                <div class="pull-right" style="margin: 5px">
                    Teljes ár: <b><?php echo $priceSum.' Ft'?></b>
                </div>
            </div>
        </div>
    </div>
</div>

<?php } else { ?>
<div class="container-fluid">
    <div class="alert alert-warning text-center" role="alert" style="margin-top: 20px;">
    Üres a kosarad!
    </div>
</div>
<?php } ?>

<script>
     $('.deletefromcart').on('click', function(){
         let id = $(this).attr('id');
         $.ajax({
             url: '<?php echo base_url('cartcontroller/removeitem') ?>',
             method: 'post',
             data: { id: id },
             success: function(data) {
                location.reload();
             }
         })
     })
</script>