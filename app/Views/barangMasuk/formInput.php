<?= $this->extend('main/layout'); ?>

<?= $this->section('judul'); ?>
Input Incoming Goods<?= $this->endSection('judul'); ?>

<?= $this->section('subJudul'); ?>
<button type="button" class="btn btn-sm btn-warning" onclick="location.href=('/barangMasuk/data')">
  <i class=" fa fa-backward"></i> Back
</button>
<?= $this->endSection('subJudul'); ?>

<?= $this->section('isi'); ?>
<div class="row">
  <div class="form-group col-md-6">
    <label>Input Faktur Incoming Goods</label>
    <input type="text" class="form-control" placeholder="No. Faktur" name="faktur" id="faktur">
  </div>

  <div class="form-group col-md-6">
    <label>Faktur Date</label>
    <input type="date" class="form-control" name="tglfaktur" id="tglfaktur" value="<?= date('Y-m-d') ?>">
  </div>
</div>

<div class="card">
  <div class="card-header bg-primary">
    Input Product
  </div>
  <div class="card-body">
    <div class="row">
      <div class="form-group col-md-3">
        <label>Code product</label>
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Code product" name="kdbarang" id="kdbarang">
          <div class="input-group-append">
            <button class="btn btn-outline-primary" type="button" id="buttonSearchProduct">
              <i class="fa fa-search"></i>
            </button>
          </div>
        </div>
      </div>
      <div class="form-group col-md-3">
        <label>Name Product</label>
        <input type="text" class="form-control" name="nameproduct" id="nameproduct" readonly>
      </div>

      <div class="form-group col-md-2">
        <label>Selling price</label>
        <input type="text" class="form-control" name="sellprice" id="sellprice" readonly>
      </div>

      <div class="form-group col-md-2">
        <label>Purchase price</label>
        <input type="number" class="form-control" name="buyprice" id="buyprice">
      </div>

      <div class="form-group col-md-1">
        <label>Total</label>
        <input type="number" class="form-control" name="total" id="total">
      </div>

      <div class="form-group col-md-1">
        <label>Action</label>
        <div class="input-group">
          <button type="button" class="btn btn-sm btn-info" title="Add Item" id="additem"><i class=" fa fa-plus-square"></i></button>&nbsp;

          <button type="button" class="btn btn-sm btn-warning" title="Reload Data" id="buttonreload"><i class=" fa fa-sync-alt"></i></button>
        </div>

      </div>
    </div>
    <div class="row" id="showDataTemp"></div>
    <div class="row justify-content-end">
      <button class="btn btn-lg btn-success" id="buttonEndTransaction">
        <i class="fa fa-save"></i> Save transaction
      </button>
    </div>
  </div>
</div>
<div class="modalSearchProduct" style="display:none;"></div>
<script>
  function dataTemp() {
    let faktur = $('#faktur').val();

    $.ajax({
      type: "post",
      url: "/barangMasuk/dataTemp",
      data: {
        faktur: faktur
      },
      //json javascript object notasi sama seperti array object ada key ada value
      dataType: "json",
      success: function(response) {
        if (response.data) {
          $('#showDataTemp').html(response.data);
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + '\n' + thrownError);
      }
    });
  }

  function kosong() {
    $('#kdbarang').val('');
    $('#nameproduct').val('');
    $('#sellprice').val('');
    $('#buyprice').val('');
    $('#total').val('');
    $('#kdbarang').focus();

  }

  function ambilDataBarang() {
    let codeproduct = $('#kdbarang').val();

    $.ajax({
      type: "post",
      url: "/barangMasuk/ambilDataBarang",
      data: {
        codeproduct: codeproduct
      },
      dataType: "json",
      success: function(response) {
        if (response.success) {
          let data = response.success;
          $('#nameproduct').val(data.nameproduct);
          $('#sellprice').val(data.sellprice);

          $('#buyprice').focus();
        }
        if (response.error) {
          alert(response.error);
          kosong();
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + '\n' + thrownError);
      }
    });
  }

  $(document).ready(function() {
    dataTemp();
    $('#kdbarang').keydown(function(e) {
      //13 kode ASCII = {enter}
      if (e.keyCode == 13) {
        e.preventDefault();
        ambilDataBarang();
      }
    });
    $('#additem').click(function(e) {
      e.preventDefault();
      let faktur = $('#faktur').val();
      let codeproduct = $('#kdbarang').val();
      let buyprice = $('#buyprice').val();
      let total = $('#total').val();
      let sellprice = $('#sellprice').val();

      if (faktur.length == 0) {
        Swal.fire({
          icon: "error",
          title: "Error.",
          text: "Sorry, this invoice cannot be left blank!"

        });
      } else if (codeproduct.length == 0) {
        alert('Sorry, Code Product is required');
      } else if (buyprice.length == 0) {
        alert('Sorry, Purchase Price is required');
      } else if (total.length == 0) {
        alert('Sorry, Total is required');
      } else {
        $.ajax({
          type: "post",
          url: "/barangMasuk/simpanTemp",
          data: {
            faktur: faktur,
            codeproduct: codeproduct,
            buyprice: buyprice,
            sellprice: sellprice,
            total: total
          },
          dataType: "json",
          success: function(response) {
            if (response.success) {
              alert(response.success);
              kosong();
              dataTemp();
            }
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + '\n' + thrownError);
          }
        });
      }
    });

    $('#buttonreload').click(function(e) {
      e.preventDefault();
      dataTemp();

    });

    $('#buttonSearchProduct').click(function(e) {
      e.preventDefault();
      $.ajax({
        url: "/barangMasuk/searchDataProduct",
        dataType: "json",
        success: function(response) {
          if (response.data) {
            // .modal dari div
            $('.modalSearchProduct').html(response.data).show();
            // #modal dari view
            $('#modalSearchProduct').modal('show');
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + '\n' + thrownError);
        }
      });

    });

    $('#buttonEndTransaction').click(function(e) {
      e.preventDefault();
      let faktur = $('#faktur').val();

      if (faktur.length == 0) {
        Swal.fire({
          title: 'Message',
          icon: 'warning',
          text: 'Invoices cannot be blank'

        });
      } else {
        Swal.fire({
          title: "End Transaction",
          text: "Are you sure you want to keep this transaction?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, Save Transaction!"
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              type: "post",
              url: "/barangMasuk/endTransaction",
              data: {
                faktur: faktur,
                tglfaktur: $('#tglfaktur').val()
              },
              dataType: "json",
              success: function(response) {
                if (response.error) {
                  Swal.fire({
                    title: 'Error',
                    icon: 'error',
                    text: response.error

                  });
                }

                if (response.success) {
                  Swal.fire({
                    title: 'Success',
                    icon: 'success',
                    text: response.success

                  }).then((result) => {
                    if (result.isConfirmed) {
                      window.location.reload();
                    }
                  })
                }
              },
              error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
              }
            });
          }
        });
      }

    });
  });
</script>
<?= $this->endSection('isi'); ?>