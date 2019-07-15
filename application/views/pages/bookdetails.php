<style>
img {
    max-width: 350px;
}

.card {
    border: none;
}
</style>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Könyvek</li>
        <li class="breadcrumb-item"><a
                href="<?php echo base_url('genre/'.$book->GENREID) ?>"><?php echo $book->GENRENAME ?></a></li>
        <li class="breadcrumb-item"><a
                href="<?php echo base_url('subgenre/'.$book->SUBGENREID) ?>"><?php echo $book->SUBGENRENAME ?></a>
        </li>
    </ol>
</nav>

<?php $authors = $book->AUTHORS; ?>

<div class="container" style="margin-bottom: 20px">
    <div class="card">
        <div class="row">
            <aside class="col-sm-5 border-right d-flex justify-content-center align-items-center">
                <article class="gallery-wrap">
                    <div class="img-big-wrap">
                        <div><img src="<?php echo base_url('assets/img/covers/'.$book->COVERIMAGE.'.jpg') ?>" />
                        </div>
                    </div>
                </article>
            </aside>
            <aside class="col-sm-7">
                <article class="card-body p-5">
                    <h3 class="title mb-3"><?php echo $book->TITLE ?></h3>
                    <p class="price-detail-wrap">
                        <?php 
                            foreach($authors as $author) { 
                                if($author->AUTHORID != $authors[0]->AUTHORID) { ?>
                        <span>
                            , <a href="<?php echo base_url('author/'.$author->AUTHORID) ?>"><?php echo $author->NAME ?></a>
                        </span>
                        <?php   }
                                else { ?>
                        <span>
                            <a href="<?php echo base_url('author/'.$author->AUTHORID) ?>"><?php echo $author->NAME ?></a>
                        </span>
                        <?php } } ?>
                    </p>
                    <dl class="item-property">
                        <dt>Leírás</dt>
                        <dd>
                            <p data-toggle="popover" data-content="<?php echo $book->DESCRIPTION ?>">
                                <?php echo substr($book->DESCRIPTION, 0, 350)."..." ?></p>
                        </dd>
                    </dl>
                    <dl class="param param-feature">
                        <dt>ISBN</dt>
                        <dd id="isbn"><?php echo $book->ISBN ?></dd>
                    </dl>
                    <dl class="param param-feature">
                        <dt>Kötés</dt>
                        <dd><?php echo $book->BINDING ?></dd>
                    </dl>
                    <dl class="param param-feature">
                        <dt>Kiadó, kiadási év</dt>
                        <dd><?php echo $book->PUBLISHER.", ".$book->PUBLISHDATE ?></dd>
                    </dl>
                    <dl class="param param-feature">
                        <dt>Oldalszám</dt>
                        <dd><?php echo $book->PAGES ?></dd>
                    </dl>
                    <hr>
                    <div class="row">
                        <?php if(count($stores) > 0 && $this->session->userdata('logged') && $this->session->userdata('address') != null) { ?>
                        <div class="col-sm-6">
                            <dl class="param param-inline">
                                <dt>Áruház: </dt>
                                <dd>
                                    <select class="form-control form-control-sm" style="min-width:100px;">
                                        <?php foreach($stores as $store) { ?>
                                        <option value="<?php echo $store->STOREID ?>"><?php echo $store->NAME ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </dd>
                            </dl>
                        </div>
                        <div class="col-sm-6">
                            <dl class="param param-inline">
                                <dt>Ár: </dt>
                                <dd id="price"></dd>
                                <dd>Ft</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center" id="alertdb"></div>
                    <hr>
                <button class="btn btn-primary" id="toCart">Kosárba</button>
                <?php } else if(count($stores) > 0 && !$this->session->userdata('logged')) { ?>
                <div class="alert alert-warning" role="alert">
                    Kérlek jelentkezz be a folytatáshoz!
                </div>
        </div>
        <?php } else if(count($stores) > 0 && $this->session->userdata('logged') && $this->session->userdata('address') == null) { ?>
        <div class="alert alert-warning" role="alert">
            Kérlek töltsd ki a lakcím adataidat a folytatáshoz!
        </div>
    </div>
    <?php } else { ?>
    <div class="alert alert-warning" role="alert">
        Ez a könyv jelenleg egyik áruházunkban sem található!
    </div>
</div>
<?php } ?>
</article>
</aside>
</div>
</div>
</div>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page">További könyvek az áruházban</li>
  </ol>
</nav>

<div class="container-fluid" id="furtherbooks" style="min-height: 250px">

</div>

<script>

$(document).ready(function(){
    let isbn = $('#isbn').html();
    let storeId = $('select').val();

    $('#furtherbooks').append('<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>');
    setTimeout(getBooks(), 2000);

    $.ajax({
        url: '<?php echo base_url('storecontroller/getpricefromstorebyisbn') ?>',
        method: 'post',
        data: {
            isbn: isbn,
            storeId: storeId
        },
        dataType: 'json',
        success: function(data) {
            $("#price").html(data.PRICE);
            if(data.DB <= 10) {
                alertdb(data.DB);
            }
            else {
                $('#alertdb').empty();
            }
        }
    });
});

$('select').on('change', function(){
    let isbn = $('#isbn').html();
    let storeId = $(this).val();

    $.ajax({
        url: '<?php echo base_url('storecontroller/getpricefromstorebyisbn') ?>',
        method: 'post',
        data: {
            isbn: isbn,
            storeId: storeId
        },
        dataType: 'json',
        success: function(data) {
            $("#price").html(data.PRICE);

            if(data.DB <= 10) {
                alertdb(data.DB);
            }else {
                $('#alertdb').empty();
            }
        }
    });

    $('#furtherbooks').empty();
    $('#furtherbooks').append('<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>');
    getBooks();
});

$(function() {
    $('[data-toggle="popover"]').popover()
});

$('#toCart').on('click', function() {
    let isbn = $('#isbn').html();
    let store = $('select').val();
    let price = $('#price').html();

    $.ajax({
        url: '<?php echo base_url('cartcontroller/addbooktocart') ?>',
        method: 'post',
        data: {
            isbn: isbn,
            store: store,
            price: price
        },
        success: function(data) {
            $('.fa-layers-counter').css('display', 'block');
            $('.fa-layers-counter').html(data);
        }
    });
});

function getBooks() {
    let storeId = $('select').val();
    let isbn = $('#isbn').html();
    $.ajax({
        url: '<?php echo base_url('bookcontroller/listbooksbystoreid') ?>',
        method: 'post',
        data: {
            storeId: storeId,
            isbn: isbn
        },
        success: function(data){
            console.log(data);
            $('#furtherbooks').empty();
            $('#furtherbooks').append(data);
        }
    });
}

function alertdb(db) {
    $('#alertdb').html(`
    <div class="alert alert-warning" role="alert">
        Már csak ` + db + ` darab található a raktáron! 
    </div>
    `);
}


</script>