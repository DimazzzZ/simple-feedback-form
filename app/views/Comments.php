<form class="form-horizontal">
    <div class="form-group">
        <label class="col-sm-1 control-label">Order by</label>
        <div class="col-sm-2">
            <select name="order" class="form-control" onchange="this.form.submit()">
                <option <?php echo $order == 'id' ? 'selected' : ''; ?> value="id">Date</option>
                <option <?php echo $order == 'name' ? 'selected' : ''; ?> value="name">Author</option>
                <option <?php echo $order == 'email' ? 'selected' : ''; ?> value="email">Email</option>
            </select>
        </div>
    </div>
</form>

<ul class="media-list">
    <?php foreach ($comments as $comment): ?>
        <li class="media" data-id="<?php echo $comment['id']; ?>">
            <div class="media-body">
                <div class="well well-lg">
                    <h4 class="media-heading"><?php echo $comment['name']; ?>

                        <?php if (App::isAdmin()): ?>

                            <div class="media-heading pull-right">

                                <?php if ($comment['edited'] == 1): ?>
                                    <!-- Edited by admin label -->
                                    <span class="label label-default">Edited by admin</span>
                                <?php endif; ?>

                                <!-- Admin action buttons -->

                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-default edit-comment"
                                            data-id="<?php echo $comment['id']; ?>">Edit
                                    </button>

                                    <?php if ($comment['show'] == 0): ?>
                                        <a href="/comment/accept/<?php echo $comment['id']; ?>" class="btn btn-success">Accept</a>
                                    <?php else: ?>
                                        <a href="/comment/reject/<?php echo $comment['id']; ?>" class="btn btn-danger">Reject</a>
                                    <?php endif; ?>
                                </div>
                            </div>

                        <?php endif; ?>

                    </h4>

                    <!-- Date -->

                    <p class="date"><?php echo $comment['date']; ?></p>

                    <!-- Text -->

                    <p class="media-comment">
                        <?php echo $comment['text']; ?>
                    </p>

                    <form id="form_<?php echo $comment['id']; ?>" method="post"
                          action="/comment/update/<?php echo $comment['id']; ?>"
                          enctype="multipart/form-data" style="display: none">

                        <div class="form-group">
                            <label>Text</label>
                                <textarea name="text" class="form-control" placeholder="Comment"
                                          data-validation="required" rows="5"
                                          data-validation-error-msg="Comment can not be empty"></textarea>
                        </div>

                        <div class="checkbox">
                            <label>
                                <input name="delete_image" type="checkbox"> Delete image
                            </label>
                        </div>

                        <button type="submit" class="btn btn-success">Update</button>
                    </form>

                    <!-- Image -->

                    <?php if ($comment['image'] != null): ?>
                        <p class="image">
                            <img src="/uploads/<?php echo $comment['image'] . '.jpg'; ?>"
                                 alt="<?php echo $comment['image']; ?>" class="img-thumbnail">
                        </p>
                    <?php endif; ?>


                </div>
            </div>
        </li>
    <?php endforeach; ?>
</ul>

<!-- Feedback form -->

<?php echo \View::factory('Form'); ?>

<script type="application/javascript">
    $(function () {
        $('.edit-comment').on('click', function () {
            var dataId = $(this).data('id');
            var $container = $(this).closest('li[class="media"]');

            var $comment = $container.find('.media-comment');
            var $image = $container.find('.image');

            var text = $comment.text().trim();

            // Toggle DOM
            $comment.toggle();
            $image.toggle();

            // Fill form
            var $form = $('#form_' + dataId);

            $form.find('textarea').val(text);

            // Toggle form
            $form.toggle();
        });
    });
</script>

