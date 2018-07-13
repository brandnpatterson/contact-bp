<form method="post" action="<?=SERVER_SELF;?>">
    <div class="form-group">
        <h1>Contact Me Today</h1>
    </div>
    <div class="form-group">
        <label for="name">Name</label>
        <input name="name" id="name" type="text" class="form-control" value="<?=$isValidated ? '' : $name?>">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input name="email" id="email" type="text" class="form-control" value="<?=$isValidated ? '' : $email?>">
    </div>
    <div class="form-group">
        <label for="message">Message</label>
        <textarea name="message" id="message" cols="30" rows="4" class="form-control"><?=$isValidated ? '' : $message?></textarea>
    </div>
    <button name="submit" type="submit" class="btn btn-primary btn-block">Submit</button>
</form>
