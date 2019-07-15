

<div class="container" style="margin-top: 30px">
    <div class="card">
        <table class="table table-hover shopping-cart-wrap">
            <thead class="text-muted">
                <tr>
                    <th scope="col">Könyv</th>
                    <th scope="col" width="120">&nbsp</th>
                    <th scope="col" width="120">&nbsp</th>
                    <th scope="col" width="200" class="text-right">Művelet</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($books as $book) { 
                $authors = $book->AUTHORS;    
            ?>
                <tr>
                <td>
                    <figure class="media">
                        <div class="img-wrap"><img
                                src="<?php echo base_url('assets/img/covers/'.$book->COVERIMAGE.'.jpg') ?>"
                                class="img-thumbnail img-sm" height="100"></div>
                        <figcaption class="media-body">
                            <h6 class="title text-truncate"><?php echo $book->TITLE ?></h6>
                            <dl class="param param-inline small">
                                <dt>ISBN: </dt>
                                <dd><?php echo $book->ISBN ?></dd>
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
                                    <dd><a href="<?php echo base_url('genre/'.$book->GENREID) ?>"><?php echo $book->GENRENAME ?></a>
                                    </dd>
                                </dl>
                                <dl class="param param-inline small">
                                    <dt>alkategória: </dt>
                                    <dd><a href="<?php echo base_url('subgenre/'.$book->SUBGENREID) ?>"><?php echo $book->SUBGENRENAME ?></a>
                                    </dd>
                                </dl>
                            </figcaption>
                            <figcaption class="media-body">
                                <h6 class="title text-truncate"></h6>
                                <dl class="param param-inline small">
                                    <dt>leírás: </dt>
                                    <dd><img data-toggle="popover" data-content="<?php echo $book->DESCRIPTION ?>"
                                            src="<?php echo base_url('assets/img/icons/file.svg')?>" height="25" /></dd>
                                </dl>
                                <dl class="param param-inline small">
                                    <dt>kötés: </dt>
                                    <dd><?php echo $book->BINDING ?></dd>
                                </dl>
                                <dl class="param param-inline small">
                                    <dt>kiadó, év: </dt>
                                    <dd><?php echo $book->PUBLISHER.", ".$book->PUBLISHDATE ?></dd>
                                </dl>
                                <dl class="param param-inline small">
                                    <dt>oldalszám: </dt>
                                    <dd><?php echo $book->PAGES ?></dd>
                                </dl>
                            </figcaption>
                        </figure>
                    </td>
                    <td>&nbsp</td>
                    <td>&nbsp</td>
                    <td class="text-right">
                        <a href="<?php echo base_url('book/'.$book->ISBN) ?>" class="btn btn-outline-success">Vásárlás</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

</div>

<script>
$(function() {
    $('[data-toggle="popover"]').popover()
})
</script>