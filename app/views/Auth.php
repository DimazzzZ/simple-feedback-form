<form method="post" action="/auth">
    <div class="panel panel-default">
        <div class="panel-heading">Auth</div>
        <div class="panel-body">

            <div class="form-group">
                <label for="formLogin">Login</label>
                <input name="login" type="text" class="form-control" id="formLogin" placeholder="Login"
                       data-validation="required"
                       data-validation-error-msg="Login can not be empty">
            </div>

            <div class="form-group">
                <label for="formPassword">Password</label>
                <input name="password" type="password" class="form-control" id="formPassword" placeholder="Password"
                       data-validation="required"
                       data-validation-error-msg="Password can not be empty">
            </div>

            <button type="submit" class="btn btn-success">Enter</button>
        </div>
    </div>
</form>

<script>
    $(function () {
        $.validate();
    });
</script>
