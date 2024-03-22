<div class="d-grid w-100" style="height : 100vh; place-items : center">
    <div class="row w-100">
        <div class="col-sm-4"></div>
        <div class="card col-sm-4">
            <div class="card-header text-center">
                <h3>Login</h3>
            </div>
            <div class="card-body">
                <form action="<?=base_url('login')?>" method="post" id="login_form">
                    <div class="mb-3">
                        <label for="" class="form-label">Email / Username</label>
                        <input type="text" class="form-control" name="email" id="email" />
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="" />
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary">
                            Login
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-sm-4"></div>
    </div>
</div>