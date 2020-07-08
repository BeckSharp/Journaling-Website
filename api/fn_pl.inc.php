<?php
//INCLUDING OBJECT CLASSES
require_once("oo_bll.inc.php");

//RENDER FORM FUNCTIONS
function renderFormSignUp() {
    $method = appFormMethod();
    $action = "app_create_profile.php";

    $form = <<<FORM
<div class="row details">
    <div class="panel panel-primary">
        <div class="panel-heading">
	        <h2 class="panel-title">Sign Up Form</h2>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" method="{$method}" action="{$action}">
                <fieldset>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="username">Username</label>
                        <div class="col-md-4">
                            <input id="username" name="username" type="password" 
                            placeholder="Enter your username here" class="form-control input-md" required>
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

                    <!-- Button -->
                    <div class="form-group">
                    <label class="col-md-4 control-label" for="form-sub">Create Account</label>
                    <div class="col-md-4">
                        <button id="form-sub" name="form-sub" type="submit" class="btn btn-primary">Sign Up</button>
                    </div>
                    </div>

                </fieldset>
            </form>
        </div>
    </div>
</div>
FORM;
    return $form;
}

function renderFormLogIn() {
    $method = appFormMethod();
    $action = "app_entry.php";

    $form = <<<FORM
<div class="row details">
    <div class="panel panel-primary">
        <div class="panel-heading">
	        <h2 class="panel-title">Log In Form</h2>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" method="{$method}" action="{$action}">
                <fieldset>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="username">Username</label>
                        <div class="col-md-4">
                            <input id="username" name="username" type="password" 
                            placeholder="Enter your username here" class="form-control input-md" required>
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
        </div>
    </div>
</div>
FORM;
    return $form;
}

function renderFormJournalEntry() {
    $currentYear = date("Y");
    $dayOptions = renderNumericOptions(1, 31);
    $monthOptions = renderNumericOptions(1, 12);
    $yearOptions = renderNumericOptions($currentYear, $currentYear + 100);

    $method = appFormMethod();
    $action = "app_create_journal_entry.php";

    $form = <<<FORM
<div class="row details">
    <div class="panel panel-primary">
        <div class="panel-heading">
	        <h2 class="panel-title">Add Journal Entry</h2>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" method="{$method}" action="{$action}">
                <fieldset>

                    <!-- Select Basic -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="dateDay">Date (DD/MM/YYYY)</label>
                        <div>
                            <div class="col-md-6">
                                <div class="col-xs-4">
                                    <select id="dateDay" name="dateDay" class="form-control">
                                        {$dayOptions}
                                    </select>
                                </div>
                                <div class="col-xs-4">
                                    <select id="dateMonth" name="dateMonth" class="form-control">
                                        {$monthOptions}
                                    </select>
                                </div>
                                <div class="col-xs-4">
                                    <select id="dateYear" name="dateYear" class="form-control">
                                        {$yearOptions}
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="weeding">Weeding</label>
                        <div class="col-md-6">
                            <input id="weeding" name="weeding" type="text" 
                            class="form-control input-md" required>
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="reflection">Reflection</label>
                        <div class="col-md-6">
                            <input id="reflection" name="reflection" type="text" 
                            class="form-control input-md" required>
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="planning">Planning</label>
                        <div class="col-md-6">
                            <input id="planning" name="planning" type="text" 
                            class="form-control input-md" required>
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="notes">Notes</label>
                        <div class="col-md-6">
                            <input id="notes" name="notes" type="text" 
                            class="form-control input-md" required>
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="question">Question</label>
                        <div class="col-md-6">
                            <input id="question" name="question" type="text" 
                            class="form-control input-md" required>
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
        </div>
    </div>
</div>
FORM;
    return $form;
}

function renderFormChangePassword() {
    $method = appFormMethod();
    $action = "app_edit_password.php";

    $form = <<<FORM
<div class="row details">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h2 class="panel-title">Change your password here:</h2>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" method="{$method}" action="{$action}">
                <fieldset>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="password">Current Password</label>
                    <div class="col-md-4">
                        <input id="password" name="password" type="password" 
                        placeholder="Enter your current password here" class="form-control input-md" required>
                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="newPassword">New Password</label>
                    <div class="col-md-4">
                        <input id="newPassword" name="newPassword" type="password" 
                        placeholder="Enter your new password here" class="form-control input-md" required>
                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="confirmationPassword">Confirmation Password</label>
                    <div class="col-md-4">
                        <input id="confirmationPassword" name="confirmationPassword" type="password" 
                        placeholder="Confirm your new password here" class="form-control input-md" required>
                    </div>
                </div>

                <!-- Button -->
                <div class="form-group">
                    <div class="col-md-4 col-md-offset-4">
                        <button id="form-sub" name="form-sub" type="submit" class="btn btn-primary">Change</button>
                    </div>
                </div>

                </fieldset>
            </form>
        </div>
    </div>
</div>
FORM;
    return $form;
}

function renderFormDeleteJournalEntry($journalData) {
    $content = "";

    if (count($journalData) == 0) { 
        $content = file_get_contents("data\static\settings\\form_delete_journal_data_error.html"); 
    } else {
        $options = renderJournalDateOptions($journalData);
        $method = appFormMethod();
        $action = "app_delete_journal_entry.php";
        
        $content = <<<FORM
<form class="form-horizontal" method="{$method}" action="{$action}">
    <fieldset>

        <!-- Select Basic -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="date">Date (DD/MM/YYYY)</label>
            <div>
                <div class="col-md-4">
                    <select id="date" name="date" class="form-control">
                        {$options}
                    </select>
                </div>
            </div>
        </div>

        <!-- Button -->
        <div class="form-group">
            <div class="col-md-4 col-md-offset-4">
                    <button id="form-sub" name="form-sub" type="submit" class="btn btn-primary">Delete</button>
            </div>
        </div>

    </fieldset>
</form>
FORM;
    }

    $form = <<<FORM
<div class="row details">
    <div class="panel panel-primary">
        <div class="panel-heading">
	        <h2 class="panel-title">Delete a journal entry here</h2>
        </div>
        <div class="panel-body">
            {$content}
        </div>
    </div>
</div>
FORM;
    return $form;
}

//RENDER FORM OPTIONS FUNCTIONS
function renderNumericOptions($min, $max) {
    $options = "";

    for ($i = $min; $i <= $max; $i++) {
        if ($i < 10) { $i = "0" . strval($i); }
        $options .= "<option value=\"{$i}\">{$i}</option>";
        if ($i != $max) {
            $options .= "\n\t\t\t\t\t";
        }
    }

    return $options;
}

function renderJournalDateOptions($journalData) {
    $options = "";
    $count = 1;
    foreach ($journalData as $entry) {
        $options .= "<option value=\"{$count}\">{$entry->date}</option>";
        $count++;
    }
    return $options;
}

//FUNCTIONS FOR RENDERING OBJECT DATA
function renderJournalEntryData(BLLJournalEntry $entry, $count) {
    $dataRender = <<<DATA
<div class="panel panel-primary">
    <div class="panel-heading pointer">
        <h3 class="panel-title" data-target="#panel-{$count}" data-toggle="collapse">Journal Date: {$entry->date}</h3>
    </div>
    <div class="panel-collapse collapse" id="panel-{$count}">
        <div class="panel-body">
            <p><b>Weeding:</b></p>
            <p>{$entry->weeding}</p>
            <p><b>Reflection:</b></p>
            <p>{$entry->reflection}</p>
            <p><b>Planning:</b></p>
            <p>{$entry->planning}</p>
            <p><b>Note Taking:</b></p>
            <p>{$entry->noteTaking}</p>
            <p><b>Question:</b></p>
            <p>{$entry->questions}</p>
        </div>
    </div>
</div>
DATA;
    return $dataRender;
}