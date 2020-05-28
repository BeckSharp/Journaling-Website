<?php
//RENDER FORM FUNCTIONS
function renderFormSignUp($errorEmpty, $errorUnconfirmed) {

    $errorEmptyMessage = "";
    $errorUnconfirmedMessage = "";

    if ($errorEmpty == "true") { $errorEmptyMessage =  "<p class=\"text-center\">Please enter data in all text fields.</p>"; }

    if ($errorUnconfirmed == "true") { $errorUnconfirmedMessage = "<p class=\"text-center\">Please enter matching passwords.</p>";}

    $method = appFormMethod();
    $action = appFormSelfSubmit();

    $form = <<<FORM
<form class="form-horizontal" method="{$method}" action="{$action}">
    <fieldset>
        <!-- Form Name -->
        <legend>Sign Up Form</legend>

        {$errorEmptyMessage}

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="username">Username</label>
            <div class="col-md-4">
                <input id="username" name="username" type="text" 
                placeholder="Enter your desired username here" class="form-control input-md" required>
            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="password">Password</label>
            <div class="col-md-4">
                <input id="password" name="password" type="password" 
                placeholder="Enter your password here" class="form-control input-md" required>
            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="passwordConfirmation">Confirmation</label>
            <div class="col-md-4">
                <input id="passwordConfirmation" name="passwordConfirmation" type="password" 
                placeholder="Confirm your password here" class="form-control input-md" required>
            </div>
        </div>

        {$errorUnconfirmedMessage}

        <!-- Button -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="form-sub">Create Account</label>
          <div class="col-md-4">
            <button id="form-sub" name="form-sub" type="submit" class="btn btn-primary">Sign Up</button>
          </div>
        </div>

    </fieldset>
</form>
FORM;
    return $form;
}

function renderFormLogIn($errorData, $signUpSuccess) {
    $errorDataMessage = "";
    $signUpSuccessMessage = "";

    if ($errorData == "true") { $errorDataMessage = "<p class=\"text-center\">The credentials you entered where incorrect.</p>"; }
    if ($signUpSuccess == "true") { $signUpSuccessMessage = "<h1 class=\"text-center\">Congratulations your account has been registered!</h1>"; }

    $method = appFormMethod();
    $action = appFormSelfSubmit();

    $form = <<<FORM
<form class="form-horizontal" method="{$method}" action="{$action}">
    <fieldset>
        <!-- Form Name -->
        <legend>Log In Form</legend>

        {$signUpSuccessMessage}
        {$errorDataMessage}

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="username">Username</label>
            <div class="col-md-4">
                <input id="username" name="username" type="text" 
                placeholder="Enter your desired username here" class="form-control input-md" required>
            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="password">Password</label>
            <div class="col-md-4">
                <input id="password" name="password" type="password" 
                placeholder="Enter your password here" class="form-control input-md" required>
            </div>
        </div>

        <!-- Button -->
        <div class="form-group">
          <div class="col-md-4 col-md-offset-4">
            <button id="form-sub" name="form-sub" type="submit" class="btn btn-primary">Log In</button>
          </div>
        </div>

    </fieldset>
</form>
FORM;
    return $form;
}