<?= $this->extend('main/layout'); ?>



<?= $this->section('judul'); ?>
Form Add Category
<?= $this->endSection('judul'); ?>

<?= $this->section('subJudul'); ?>

<?= form_button('', '<i class ="fa fa-backward"></i> Back', [
    'class' => 'btn btn-warning',
    'onclick' => "location.href=('" . site_url('category/index') . "')"
]) ?>

<?= $this->endSection('subJudul'); ?>

<?= $this->section('isi'); ?>

<?= form_open('category/saveData') ?>
<div class="form-group">
    <label for="namecategory">Name Category</label>
    <?= form_input('namecategory', '', [
        'class' => 'form-control',
        'id' => 'namecategory',
        'autofocus' => 'true',
        'placeholder' => 'input name category'
    ]) ?>

    <?= session()->getFlashdata('errorNameCategory'); ?>

</div>
<div class="form-group">
    <?= form_submit('', 'Save', [
        'class' => 'btn btn-success'
    ]) ?>
</div>
<?= form_close() ?>
<?= $this->endSection('isi'); ?>