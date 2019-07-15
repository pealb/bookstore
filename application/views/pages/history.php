<script src="https://use.fontawesome.com/c560c025cf.js"></script>

<?php if(count($orders) == 0) { ?>
<div class="container-fluid">
    <div class="alert alert-warning text-center" role="alert" style="margin-top: 20px;">
    Nincsenek megjeleníthető vásárlásaid!
    </div>
</div>
<?php } else {
foreach($orders as $order) { 
$books = $order->BOOKS;
if(count($books) == 0) continue;
?>
<div class="container" style="margin-bottom: 20px; margin-top: 20px;">
<div class="card" style="margin-bottom: 40px;">
    <div class="card-header bg-dark text-light">
        <i class="fa fa-shopping-cart" aria-hidden="true"></i><?php echo ' ID: #'.$order->ORDERID ?>
        <div class="pull-right">
            <i class="fas fa-calendar-alt"></i><?php echo ' '.strtolower($order->DATECREATED) ?>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="card-body">
    <?php foreach($books as $book) { ?>
        <div class="row">
            <div class="col-xs-2 col-md-2">
                <img class="img-responsive" src="<?php echo base_url('assets/img/covers/'.$book->COVERIMAGE.'.jpg') ?>"
                    alt="prewiew" width="120" height="200">
            </div>
            <figcaption class="media-body">
                    <a href="<?php echo base_url('book/'.$book->ISBN) ?>">
                        <h6 class="title text-truncate"><?php echo $book->TITLE ?></h6>
                    </a>
                    <dl class="param param-inline small">
                        <dt>ISBN: </dt>
                        <dd><?php echo $book->ISBN ?></dd>
                    </dl>
                    <dl class="param param-inline small">
                        <dt>kategória: </dt>
                        <a href="<?php echo base_url('genre/'.$book->GENREID) ?>"><dd><?php echo $book->GENRENAME ?></dd></a>
                    </dl>
                    <dl class="param param-inline small">
                        <dt>alkategória: </dt>
                        <a href="<?php echo base_url('subgenre/'.$book->SUBGENREID) ?>"><dd><?php echo $book->SUBGENRENAME ?></dd></a>
                    </dl>
                    <dl class="param param-inline small">
                        <dt>áruház: </dt>
                        <a href="<?php echo base_url('store/'.$book->STOREID) ?>"><dd><?php echo $book->STORENAME ?></dd></a>
                    </dl>
            </figcaption>
            <div class="col-xs-6 col-md-4 row">
                <div class="col-xs-6 col-md-6 text-right" style="padding-top: 5px">&nbsp</div>
                <div class="col-xs-4 col-md-4">&nbsp</div>
                <div class="col-xs-2 col-md-2">&nbsp</button></div>
            </div>
        </div>
        <hr>
        <?php } ?>
        </div>
        <hr>
        <div class="card-footer"  style="margin-bottom: 20px;">
            <div class="pull-right" style="margin: 5px">
                Teljes ár: <b><?php echo $order->PRICE.' Ft' ?></b>
            </div>
        </div>
    </div>
    </div>
    <?php }  }?>
</div>