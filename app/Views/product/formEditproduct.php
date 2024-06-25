<?= $this->extend('main/layout'); ?>



<?= $this->section('judul'); ?>
Form Edit Product
<?= $this->endSection('judul'); ?>

<?= $this->section('subJudul'); ?>
<button type="button" class="btn btn-sm btn-warning" onclick="location.href=('/product/index')">
    <i class=" fa fa-backward"></i>Kembali
</button>
<?= $this->endSection('subJudul'); ?>

<?= $this->section('isi'); ?>
<?= form_open_multipart('product/updateData') ?>
<?= session()->getFlashdata('error'); ?>
<?= session()->getFlashdata('success'); ?>

<div class="form-group row">
    <label for="" class="col-sm-4 col-form-label">Code Product</label>
    <div class="col-sm-8">
        <input type="text" class="form-control" id="codeproduct" name="codeproduct" readonly value="<?= $codeproduct; ?>">
    </div>
</div>

<div class="form-group row">
    <label for="" class="col-sm-4 col-form-label">Name Product</label>
    <div class="col-sm-8">
        <input type="text" class="form-control" id="nameproduct" name="nameproduct" value="<?= $nameproduct; ?>">
    </div>
</div>

<div class="form-group row">
    <label for="" class="col-sm-4 col-form-label">Category</label>
    <div class="col-sm-4">
        <select name="category" id="category" class="form-control">
            <?php foreach ($datacategory as $kat) : ?>
                <?php if ($kat['katid'] == $category) : ?>
                    <option selected value="<?= $kat['katid'] ?>"><?= $kat['katnama'] ?></option>
                <?php else : ?>
                    <option value="<?= $kat['katid'] ?>"><?= $kat['katnama'] ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<div class="form-group row">
    <label for="" class="col-sm-4 col-form-label">Choose Unit</label>
    <div class="col-sm-4">
        <select name="unit" id="unit" class="form-control">
            <?php foreach ($dataunit as $sat) : ?>
                <?php if ($sat['satid'] == $unit) : ?>
                    <option selected value="<?= $sat['satid'] ?>"><?= $sat['satnama'] ?></option>
                <?php else : ?>
                    <option value="<?= $sat['satid'] ?>"><?= $sat['satnama'] ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
    </div>
</div>


<div class="form-group row">
    <label for="" class="col-sm-4 col-form-label">Price</label>
    <div class="col-sm-4">
        <input type="number" class="form-control" id="price" name="price" value="<?= $price; ?>">
    </div>
</div>
<div class="form-group row">
    <label for="" class="col-sm-4 col-form-label">Stock</label>
    <div class="col-sm-4">
        <input type="number" class="form-control" id="stock" name="stock" value="<?= $stock; ?>">
    </div>
</div>

<div class="form-group row">
    <label for="" class="col-sm-4 col-form-label">Existing image</label>
    <div class="col-sm-4">
        <img src="<?= base_url($image) ?>" class="img-thumbnail" style="width:50%;" alt="product-image">
    </div>
</div>

<div class="form-group row">
    <label for="" class="col-sm-4 col-form-label">Upload Image (<i>Note</i>)</label>
    <div class="col-sm-4">
        <input type="file" class="form-control" id="image" name="image">
    </div>
</div>

<div class="form-group row">
    <label for="" class="col-sm-4 col-form-label"></label>
    <div class="col-sm-4">
        <input type="submit" value="Save" class="btn btn-success">
    </div>
</div>



<?= form_close(); ?>

<?= $this->endSection('isi'); ?>