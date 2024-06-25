<?= $this->extend('main/layout'); ?>



<?= $this->section('judul'); ?>
Form Edit Category
<?= $this->endSection('judul'); ?>

<?= $this->section('subJudul'); ?>

<?= form_button('', '<i class ="fa fa-backward"></i> Back', [
    'class' => 'btn btn-warning',
    'onclick' => "location.href=('" . site_url('category/index') . "')"
]) ?>

<?= $this->endSection('subJudul'); ?>

<?= $this->section('isi'); ?>

<?= form_open('category/updateData', '', [
    'idcategory' => $id
]) ?>
<div class="form-group">
    <label for="namecategory">Name Category</label>
    <?= form_input('namecategory', $nama, [
        'class' => 'form-control',
        'id' => 'namecategory',
        'autofocus' => 'true'
    ]) ?>

    <?= session()->getFlashdata('errorNameCategory'); ?>

</div>
<div class="form-group">
    <?= form_submit('', 'Update', [
        'class' => 'btn btn-success'
    ]) ?>
</div>
<?= form_close() ?>
<?= $this->endSection('isi'); ?>