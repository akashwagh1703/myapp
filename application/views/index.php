<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h2>Welcome, <?= ucfirst($this->session->userdata('first_name')) ?> <a href="<?= base_url() ?>auth/logout" class="btn btn-danger" style="float:right">Logout</a></h2>
        </div>
        <hr />  
        <div class="col-md-12">
            <h3>Documents <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" style="float:right">Add Document</button></h3>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Document</th>
                        <th scope="col">Option</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(!empty($document)){
                        $i=1;
                        foreach($document as $key => $value){
                    ?>
                    <tr>
                        <th scope="row"><?= $i++ ?></th>
                        <td><?= $value['name']; ?></td>
                        <th scope="row">
                            <a href="<?= base_url().$value['document']; ?>" target="_blank">View</a>
                        </th>
                        <td>
                            <a href="<?= base_url().'app/delete/'.$value['id']; ?>" class="btn btn-xs btn-danger">Delete</a>
                        </td>
                    </tr>
                    
                    <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="100"><h4 class="text-center">No record found!</h4></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">User Registration</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="uploadData" enctype="multipart/form-data">
            <input type="hidden" name="id" id="id" value="<?= ucfirst($this->session->userdata('id')) ?>">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" id="doc_name" required>
            </div>
            <div class="form-group">
                <label for="document">Document</label>
                <input type="file" class="form-control" name="document" id="document" required>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="upload_document">Upload</button>
      </div>
    </div>
  </div>
</div>