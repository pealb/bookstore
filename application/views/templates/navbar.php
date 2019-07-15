<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <span class="navbar-brand" href="#">MISR</span>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <?php if (isset($home)) { ?>
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo base_url('/home') ?>">Kezdőlap<span
                        class="sr-only">(current)</span></a>
            </li>
            <?php 
        } else { ?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('/home') ?>">Kezdőlap</a>
            </li>
            <?php 
        }
        if (!$this->session->userdata('logged')) { ?>
            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="modal" data-target="#registerModal">Regisztráció</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="modal" data-target="#loginModal">Belépés</a>
            </li>
            <?php 
        } else { ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <?php echo $this->session->userdata('name'); ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <h6 class="dropdown-header">Profil</h6>
                    <a class="dropdown-item" href="<?php echo base_url('/profile') ?>">Adataim szerkesztése</a>
                    <a class="dropdown-item" href="<?php echo base_url('/history') ?>">Vásárlásaim</a>
                    <?php if ($this->session->userdata('admin')) { ?>
                    <div class="dropdown-divider"></div>
                    <h6 class="dropdown-header">Admin Panel</h6>
                    <a class="dropdown-item" href="<?php echo base_url('admin/books') ?>">Könyvek</a>
                    <a class="dropdown-item" href="<?php echo base_url('admin/genres') ?>">Műfajok & alműfajok</a>
                    <a class="dropdown-item" href="<?php echo base_url('admin/stores') ?>">Áruházak</a>
                </div>
                <?php 
            } ?>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('/logout') ?>">Kijelentkezés</a>
            </li>
            <?php 
        } ?>
        </ul>
        <?php if($this->session->userdata('logged')) { ?>
        <a href="<?php echo base_url('cart') ?>">
            <span class="fa-layers fa-fw fa-2x">
                <i class="fas fa-shopping-cart text-light"></i>
                <?php if($this->session->has_userdata('cartSize') && $this->session->userdata('cartSize') > 0) { ?>
                <span class="fa-layers-counter fa-lg"
                    style="background:Tomato;"><?php echo $this->session->userdata('cartSize') ?></span>
                <?php } else { ?>
                <span class="fa-layers-counter fa-lg"
                    style="background:Tomato; display: none;"><?php echo $this->session->userdata('cartSize') ?></span>
                <?php } ?>
            </span>
        </a>
        <?php } ?>
    </div>
</nav>

<!-- Register Modal -->

<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Regisztráció</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="register-form" action="<?php echo base_url('usercontroller/register') ?>" method="post">
                    <div class="form-group">
                        <label for="name">Név</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Név" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email cím</label>
                        <input type="email" class="form-control" class="email" name="email" aria-describedby="emailHelp"
                            placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Jelszó</label>
                        <input type="password" class="form-control" class="password" name="password" placeholder="Jelszó"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Jelszó újra</label>
                        <input type="password" class="form-control" id="re-password" name="re-password"
                            placeholder="Jelszó" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Vissza</button>
                <button type="submit" form="register-form" class="btn btn-primary">Regisztráció</button>
            </div>
        </div>
    </div>
</div>

<!-- Login Modal -->

<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Belépés</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="login-form" action="<?php echo base_url('usercontroller/login') ?>" method="post">
                    <div class="form-group">
                        <label for="email">Email cím</label>
                        <input type="email" class="form-control" class="email" name="email" aria-describedby="emailHelp"
                            placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="password">Jelszó</label>
                        <input type="password" class="form-control" class="password" name="password" placeholder="Jelszó">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Vissza</button>
                <button type="submit" form="login-form" class="btn btn-primary">Belépés</button>
            </div>
        </div>
    </div>
</div>