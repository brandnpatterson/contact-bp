<form class="form" method="post" action="mailer.php">
    <div class="form-group">
        <h1>Contact Me Today</h1>
    </div>
    <div class="form-group">
        <label for="name">Name</label>
        <input name="name" id="name" type="text" class="form-control" value="" data-required="true">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input name="email" id="email" type="text" class="form-control" value="" data-required="true">
    </div>
    <div class="form-group">
        <label for="message">Message</label>
        <textarea name="message" id="message" cols="30" rows="4" class="form-control" data-required="required"></textarea>
    </div>
    <button type="submit" class="btn btn-primary btn-block">Submit</button>
</form>
