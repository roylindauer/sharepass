<?php if (isset($key)): ?>
<div class="container">
    <div class="row">
        <div class="col-sm-8 col-sm-push-2 text-center">
            <h2>Your link is ready</h2>
            <div class="well well-lg">
                <p style="font-size: 2rem;"><?=getenv('DOMAIN') . 'link/' . $key?></p>
            </div>
        </div>
    </div>
</div>
<?php else: ?>
<div class="container">
    <div class="row">
        <div class="col-sm-8 col-sm-push-2">
            <h2>Encrypt Data and Generate Link</h2>
            <p>Enter the data you want to share. This can be a password, or other sensitive information. You can enter up to 255 characters. The data is encrypted at rest and during transit. The link will function for 24 hours.</p>
            <form action="/" method="POST">
                <fieldset>
                    <div class="form-group">
                        <textarea maxlength="64000" placeholder="Enter data to share here..." class="form-control" rows="10" name="mydata"></textarea>
                    </div>
                    <input type="submit" name="submit" value="Generate Link" class="btn btn-primary">
                </fieldset>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>