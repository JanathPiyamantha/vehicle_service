<?php
if (isset($_GET['id']) && $_GET['id'] > 0) {
    echo "<script>console.log('ID: " . htmlspecialchars($_GET['id']) . "');</script>";
    $qry = $conn->query("SELECT * from `product` where product_id = '{$_GET['id']}' ");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = stripslashes($v);
        }
    }
    echo "<script>console.log('Product Name: " . addslashes($product_name) . "');</script>";
}
?>
<div class="card card-outline card-info">
    <div class="card-header">
        <h3 class="card-title"><?php echo isset($product_id) ? "Update " : "Create New " ?> Part</h3>
    </div>
    <div class="card-body">
        <form action="" id="product-form" enctype="multipart/form-data">
            <input type="hidden" name="product_id" value="<?php echo isset($product_id) ? $product_id : '' ?>">
            <div class="form-group">
                <label for="product_name" class="control-label">Product Name</label>
                <input name="product_name" id="product_name" type="text" class="form-control rounded-0" value="<?php echo isset($product_name) ? $product_name : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="product_image" class="control-label">Product Image</label>
                <input name="product_image" id="product_image" type="file" class="form-control rounded-0" <?php echo !isset($product_image) ? 'required' : ''; ?>>
                <?php if (isset($product_image) && !empty($product_image)) : ?>
                    <img src="<?php echo $product_image; ?>" alt="Product Image" class="img-thumbnail mt-2" style="max-width: 150px;">
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="quantity" class="control-label">Quantity</label>
                <input name="quantity" id="quantity" type="text" class="form-control rounded-0" value="<?php echo isset($quantity) ? $quantity : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="rate" class="control-label">Rate</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Rs.</span>
                    </div>
                    <input name="rate" id="rate" type="text" class="form-control rounded-0" value="<?php echo isset($rate) ? $rate : ''; ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label for="status" class="control-label">Status</label>
                <select name="status" id="status" class="custom-select selevt">
                    <option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>Available</option>
                    <option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Unavailable</option>
                </select>
            </div>
        </form>
    </div>
    <div class="card-footer">
        <button class="btn btn-flat btn-primary" form="product-form">Save</button>
        <a class="btn btn-flat btn-default" href="?page=parts">Cancel</a>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#product-form').submit(function(e) {
            e.preventDefault();
            var _this = $(this)
            $('.err-msg').remove();
            start_loader();

            var formData = new FormData(_this[0]);
            console.log('Form Data:');
            formData.forEach((value, key) => {
                console.log(key + ": " + value);
            });

            let rate = $('#rate').val();
            if (!/^\d+$/.test(rate)) {
                alert_toast("Rate must be digits only.", 'warning');
                end_loader();
                return false;
            }

            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_product",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error: err => {
                    console.log(err)
                    alert_toast("An error occured", 'error');
                    end_loader();
                },
                success: function(resp) {
                    console.log('Response:', resp);
                    if (typeof resp == 'object' && resp.status == 'success') {
                        location.href = "./?page=parts";
                    } else if (resp.status == 'failed' && !!resp.msg) {
                        console.log('Err Response:', resp);
                        var el = $('<div>')
                        el.addClass("alert alert-danger err-msg").text(resp.msg)
                        _this.prepend(el)
                        el.show('slow')
                        $("html, body").animate({
                            scrollTop: _this.closest('.card').offset().top
                        }, "fast");
                        end_loader()
                    } else {
                        console.log('Else err Response:', resp);
                        alert_toast("An error occured", 'error');
                        end_loader();
                        console.log(resp)
                    }
                }
            })
        });

        $('.summernote').summernote({
            height: 200,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ol', 'ul', 'paragraph', 'height']],
                ['table', ['table']],
                ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>
