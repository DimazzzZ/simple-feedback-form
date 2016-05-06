<form method="post" action="/reply" enctype="multipart/form-data">
    <div class="media-body" style="display: none;" id="previewBlock">
        <div class="well well-lg">
            <h4 class="media-heading"></h4>
            <p class="date"></p>
            <p class="media-comment"></p>
            <button type="submit" class="btn btn-success">Submit</button>
            <div class="btn btn-primary toggle-preview">Edit</div>
        </div>
    </div>
    <div class="panel panel-default" id="commentFormBlock">
        <div class="panel-heading">Leave comment</div>
        <div class="panel-body">

            <div class="form-group">
                <label for="formName">Your name</label>
                <input name="name" type="text" class="form-control" id="formName" placeholder="Name"
                       data-validation="required"
                       data-validation-error-msg="User name is required field">
            </div>

            <div class="form-group">
                <label for="formEmail">Email address</label>
                <input name="email" type="email" class="form-control" id="formEmail" placeholder="Email"
                       data-validation="email">
            </div>

            <div class="form-group">
                <label for="formText">Text</label>
                <textarea name="text" class="form-control" id="formText" placeholder="Comment"
                          data-validation="required" rows="5"
                          data-validation-error-msg="Comment can not be empty"></textarea>
            </div>

            <div class="form-group">
                <label for="formFile">Attach file (optional)</label>
                <input type="file" id="formFile" name="file">
                <p class="help-block">JPG, GIF & PNG images only</p>
            </div>

            <button type="submit" class="btn btn-success">Submit</button>
            <div class="btn btn-primary toggle-preview">Preview</div>
        </div>
    </div>
</form>

<script type="application/javascript">
    $(function () {
        $.validate();

        // Toggle preview block and form
        $('.toggle-preview').on('click', function () {
            $('#previewBlock').toggle();
            $('#commentFormBlock').toggle();

            // Format date
            var date = new Date();
            var year = date.getFullYear();
            var month = (date.getMonth() < 10 ? '0' + date.getMonth() : date.getMonth());
            var day = (date.getDate() < 10 ? '0' + date.getDate() : date.getDate());
            var hours = date.getHours();
            var minutes = date.getMinutes();
            var seconds = date.getSeconds();

            var dateText = year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds;

            // Fill preview data
            $('#previewBlock .media-comment').text($('#formText').val());
            $('#previewBlock .media-heading').text($('#formName').val());
            $('#previewBlock .date').text(dateText);
        });
    });
</script>
