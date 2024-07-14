<?= $this->extend('main/layout'); ?>

<?= $this->section('judul'); ?>
Management Users
<?= $this->endSection('judul'); ?>

<?= $this->section('subJudul'); ?>
<button type="button" class="btn btn-sm btn-primary btntambah"><i class="fa fa-plus"> Add User Baru</i></button>
<?= $this->endSection('subJudul'); ?>

<?= $this->section('isi'); ?>
<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') ?>">

<!-- DataTables & Plugins -->
<script src="<?= base_url('plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('plugins/datatables-responsive/js/dataTables.responsive.min.js') ?>"></script>
<script src="<?= base_url('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') ?>"></script>

<table style="width: 100%;" id="datauser" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>No</th>
            <th>ID User</th>
            <th>Name User</th>
            <th>Level</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
</table>

<div class="viewmodal" style="display: none;"></div>

<script>
    $(document).ready(function() {
        $('.btntambah').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('users/formTambah') ?>",
                success: function(response) {
                    $('.viewmodal').html(response).show();
                    $('#modaltambah').on('shown.bs.modal', function(event) {
                        $('#iduser').focus();
                    })
                    $('#modaltambah').modal('show');
                }
            });
        });

        $('#datauser').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?= site_url('users/listData') ?>",
                type: 'POST',
            },
            columns: [{
                    data: 'nomor',
                    width: '10%'
                },
                {
                    data: 'userid'
                },
                {
                    data: 'usernama'
                },
                {
                    data: 'levelnama'
                },
                {
                    data: 'useraktif',
                    width: '25%',
                    orderable: false
                },
                {
                    data: 'action',
                    width: '20%',
                    orderable: false
                }
            ]
        });
    });

    function view(userid) {
        $.ajax({
            type: "post",
            url: "/users/formEdit",
            data: {
                userid: userid
            },
            success: function(response) {
                $('.viewmodal').html(response).show();
                $('#modaledit').on('shown.bs.modal', function(event) {
                    $('#namalengkap').focus();
                })
                $('#modaledit').modal('show');
            }
        });
    }
</script>
<?= $this->endSection('isi'); ?>