<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h2>Welcome, <?= ucfirst($this->session->userdata('first_name')) ?> <a href="<?= base_url() ?>auth/logout" class="btn btn-danger" style="float:right">Logout</a></h2>
        </div>
        <hr />  
        <div class="col-md-12">
                <h3>Registerd User <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" style="float:right">Add New</button></h3>

            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">First</th>
                        <th scope="col">Last</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Option</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    if(!empty($users)){
                        $i=1;
                        foreach($users as $key => $value){
                    ?>
                    <tr>
                        <th scope="row"><?= $i++ ?></th>
                        <td><?= $value['first_name']; ?></td>
                        <td><?= $value['last_name']; ?></td>
                        <td><?= $value['email']; ?></td>
                        <th scope="row"><?= $value['phone']; ?></th>
                        <td>
                            <a href="#" class="btn btn-xs btn-primary">Edit</a>
                            <a href="<?= base_url().'admin/master/delete/'.$value['id']; ?>" class="btn btn-xs btn-danger">Delete</a>
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
        <form action="" method="post" id="userform">
            <input type="hidden" name="id" id="id" value="<?= ucfirst($this->session->userdata('id')) ?>">
            
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" name="first_name" id="first_name" value="" onkeyup="text_validation(this)" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control" name="last_name" id="last_name" value="" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" class="form-control" name="email" id="email" value="" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text" class="form-control numeric_validation check_phone" minlength="10" maxlength="10" name="phone" id="phone" value="" required>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="register_user">Register</button>
      </div>
    </div>
  </div>
</div>