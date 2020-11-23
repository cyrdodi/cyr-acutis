<style>
  .scroll {
    max-height: 500px;
    overflow-y: auto;
  }
</style>
<div class="row">
  <div class="col align-self-center">
    <div class="font-weight-bold mb-4 text-uppercase">Daftar Tindakan</div>
  </div>
  <div class="col-auto">
    <nav aria-label="breadcrumb ">
      <ol class="breadcrumb bg-light">
        <li class="breadcrumb-item active" aria-current="page">Daftar Tindakan</li>
      </ol>
    </nav>
  </div>
</div>
<?= $this->session->flashdata('msg') ?>
<div class="row">
  <div class="col-lg-4">
    <div class="card shadow mb-4">
      <div class="card-body">
        <div class="font-weight-bold">Add Tindakan</div>
        <form action="" method="post">
          <div class="form-group">
            <label for="tindakan">Nama Tindakan</label>
            <input type="text" class="form-control" name="tindakan">
            <?= form_error('tindakan', '<small class="text-danger pl-3">', '</small>') ?>
          </div>
          <div class="form-group">
            <label for="tarif">Tarif</label>
            <input type="text" id="tarif" class="form-control" name="tarif">
            <?= form_error('tarif', '<small class="text-danger pl-3">', '</small>') ?>
          </div>
          <button type="submit" id="simpan-btn" class="btn btn-primary float-right"><i class="fas fa-check "></i> Simpan</button>
        </form>
      </div>
    </div>
  </div>
  <div class="col-lg-8">
    <div class="card shadow mb-4">
      <div class="card-body">
        <div class="row">
          <div class="col">
            <form action="" method="get" autocomplete="off">
              <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Masukan nama tindakan" aria-label="Example text with button addon" name="keyword" aria-describedby="button-addon1" value="<?= $is_keyword ? $this->input->get('keyword') : '' ?>" autofocus>
                <div class="input-group-prepend">
                  <button class="btn btn-primary" type="submit" id="button-addon1"><i class="fas fa-search"></i> Cari</button>
                </div>
              </div>
            </form>
          </div>
          <div class="col-auto">
            <a href="<?= base_url('Tindakan/add_tindakan') ?>" class="btn btn-primary"><i class="fas fa-plus    "></i> Tindakan</a>
          </div>
        </div>
        <div class="row">

          <div class="col scroll">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Nama Tindakan</th>
                  <th>Tarif</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php $i = 1; ?>
                <?php foreach ($search_result as $tindakan) : ?>
                  <tr>
                    <td><?= $i ?></td>
                    <td><?= $tindakan['nama_tindakan'] ?></td>
                    <td><?= number_format($tindakan['tarif']) ?></td>
                    <td>
                      <button class="btn btn-sm btn-primary">
                        <i class=" fas fa-hashtag"></i>
                      </button>
                      <button class="btn btn-primary btn-sm" tindakan-id="<?= $tindakan['id'] ?>" type=" button" data-toggle="modal" data-target="#editModal">
                        <i class="fas fa-pen"></i>
                      </button>
                    </td>
                  </tr>
                  <?php $i++ ?>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Tindakan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post">
          <div class="form-group">
            <label for="editTindakan">Nama Tindakan</label>
            <input type="text" class="form-control" id="editTindakan" name="editTindakan">
          </div>
          <div class="form-group">
            <label for="editTarif">Tarif</label>
            <input type="text" class="form-control" id="editTarif" name="editTarif">
          </div>
          <div class="form-group">
            <label for="aktif">Aktif</label>
            <select name="aktif" id="aktif" id="aktif" class="form-control">
              <option value="1">Ya</option>
              <option value="0">Tidak</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function() {
    // autonumeric
    var tarif = new AutoNumeric('#tarif', {
      currencySymbol: 'Rp. ',
      allowDecimalPadding: 'false',
      decimalCharacter: ',',
      digitGroupSeparator: '.'
    });

    var editTarif = new AutoNumeric('#editTarif', {
      currencySymbol: 'Rp. ',
      allowDecimalPadding: 'false',
      decimalCharacter: ',',
      digitGroupSeparator: '.'

    });

    $('#simpan-btn').click(function() {
      $('#tarif').val(tarif.rawValue)
    })

    $('#editModal').on('show.bs.modal', function(e) {
      // get information to update quickly to modal view as loading begins
      var opener = e.relatedTarget; //this holds the element who called the modal
      //we get details from attributes
      var id = $(opener).attr('tindakan-id');
      //set what we got to our form
      $.ajax({
        type: 'post',
        url: "<?= base_url('Tindakan/get_tindakan_by_id') ?>",
        dataType: 'json',
        data: {
          'id': id
        },
        success: function(data) {
          // $('#editMenu').find('[name="menu"]').val(menuName); // #editMenu = id form di modal
          // $('#editTarif').find('[name="editTarif"]').val(data.tarif);
          $('#editTindakan').val(data.nama_tindakan);
          $('#editTarif').val(data.tarif);
          // console.log(data)
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          alert("some error");
          console.log(errorThrown);
        }
      });

      // alternative
    })
  })
</script>