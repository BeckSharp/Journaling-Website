<?php
//RENDER FORM FUNCTIONS
function renderFormSignUp($errorEmpty, $errorUnconfirmed) {

    $errorEmptyMessage = "";
    $errorUnconfirmedMessage = "";

    if ($errorEmpty == "true") { $errorEmptyMessage =  file_get_contents("data\static\sign_up_error_empty.html"); }
    if ($errorUnconfirmed == "true") { $errorUnconfirmedMessage = file_get_contents("data\static\sign_up_error_unconfirmed.html"); }

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

    if ($errorData == "true") { $errorDataMessage = file_get_contents("data\static\log_in_error_data.html"); }
    if ($signUpSuccess == "true") { $signUpSuccessMessage = file_get_contents("data\static\sign_up_success.html"); }

    $method = appFormMethod();
    $action = "app_entry.php";

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

function renderJournalEntry($errorEmpty, $errorDate) {
    $errorEmptyMessage = "";
    $errorDateMessage = "";

    if ($errorEmpty == "true") {$errorEmptyMessage = file_get_contents("data\static\journal_entry_error_empty.html"); }
    if ($errorDate == "true") {$errorDateMessage = file_get_contents("data\static\journal_entry_error_date.html"); }

    $currentYear = date("Y");
    $dayOptions = renderNumericOptions(1, 31);
    $monthOptions = renderNumericOptions(1, 12);
    $yearOptions = renderNumericOptions($currentYear, $currentYear + 100);

    $method = appFormMethod();
    $action = appFormSelfSubmit();

    $form = <<<FORM
<form class="form-horizontal" method="{$method}" action="{$action}">
    <fieldset>
        <!-- Form Name -->
        <legend>Add Journal Entry</legend>

        {$errorEmptyMessage}
        {$errorDateMessage}

        <!-- Select Basic -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="dateDay">Date (DD/MM/YYYY)</label>
            <div>
            <div class="col-md-2">
                <select id="dateDay" name="DateDay" class="form-control">
                    {$dayOptions}
                </select>
            </div>
            <div class="col-md-2">
                <select id="dateMonth" name="DateMonth" class="form-control">
                    {$monthOptions}
                </select>
            </div>
            <div class="col-md-2">
                <select id="dateYear" name="DateYear" class="form-control">
                    {$yearOptions}
                </select>
            </div>
            </div>
         </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="weeding">Weeding</label>
            <div class="col-md-6">
                <input id="weeding" name="weeding" type="text" 
                placeholder="Type the problems you want to weed out here" class="form-control input-md" required>
            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="reflection">Reflection</label>
            <div class="col-md-6">
                <input id="reflection" name="reflection" type="text" 
                placeholder="Type and reflect upon the tasks you have done" class="form-control input-md" required>
            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="planning">Planning</label>
            <div class="col-md-6">
                <input id="planning" name="planning" type="text" 
                placeholder="Type what you are going to do the next day here" class="form-control input-md" required>
            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="notes">Notes</label>
            <div class="col-md-6">
                <input id="notes" name="notes" type="text" 
                placeholder="Type anything here you found interesting today" class="form-control input-md" required>
            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="question">Question</label>
            <div class="col-md-6">
                <input id="question" name="question" type="text" 
                placeholder="Type a deep question to ponder/meditate about" class="form-control input-md" required>
            </div>
        </div>

        <!-- Button -->
        <div class="form-group">
          <div class="col-md-4 col-md-offset-4">
            <button id="form-sub" name="form-sub" type="submit" class="btn btn-primary">Add Entry</button>
          </div>
        </div>

    </fieldset>
</form>
FORM;
    return $form;
}

//RENDER FORM OPTIONS FUNCTIONS
function renderNumericOptions($min, $max) {
    $options = "";

    for ($i = $min; $i <= $max; $i++) {
        $options .= "<option value=\"{$i}\">{$i}</option>";
        if ($i != $max) {
            $options .= "\n\t\t\t\t\t";
        }
    }

    return $options;
}