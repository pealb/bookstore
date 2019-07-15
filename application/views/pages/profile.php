<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page">Adatok szerkesztése</li>
  </ol>
</nav>

<!-- Forms -->

<div class="float-left" style="padding-left: 20px; padding-right: 20px;">
<form action="usercontroller/updateprofile" method="post">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="name">Név</label>
      <input type="text" class="form-control" id="name" name="name" value="<?php echo $this->session->userdata('name') ?>" disabled>
    </div>
    <div class="form-group col-md-6">
      <label for="email">E-mail</label>
      <input type="email" class="form-control" id="email" name="email" value="<?php echo $this->session->userdata('email') ?>" disabled>
    </div>
  </div>
  <div class="form-group">
    <label for="address">Lakcím</label>
    <input type="text" class="form-control" id="address" name="address" value="<?php echo $this->session->userdata('address') ?>" required>
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="country">Ország</label>
      <input type="text" class="form-control" id="country" name="country" value="<?php echo $this->session->userdata('country') ?>" required>
    </div>
    <div class="form-group col-md-4">
      <label for="city">Város</label>
      <input type="text" id="city" name="city" class="form-control" value="<?php echo $this->session->userdata('city') ?>" required>
    </div>
    <div class="form-group col-md-2">
      <label for="inputZip">Zip</label>
      <input type="number" class="form-control" id="zip" name="zip" value="<?php echo $this->session->userdata('zip') ?>" required>
    </div>
  </div>
  <button type="submit" class="btn btn-success">Mentés</button>
</form>
</div>