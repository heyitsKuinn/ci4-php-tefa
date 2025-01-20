<?= $this->extend('template/layout') ?>

<?= $this->section('title') ?>
    <title>Tefa IT - Send</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<style>
    .toggle-switch { 
        display: flex; 
        flex-direction: column; 
        align-items: center; 
        position: relative; 
        width: 50px; /* Ukuran disesuaikan */ 
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 20px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 20px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 16px;
        width: 16px;
        left: 2px;
        bottom: 2px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked + .slider {
        background-color: #2196F3;
    }

    input:checked + .slider:before {
        transform: translateX(30px);
    }

    .toggle-label {
        font-size: 14px;
        font-weight: bold;
        line-height: 1; /* Persempit jarak antar baris */ 
        margin-bottom: 5px; /* Persempit jarak dengan switch */ 
        text-align: center;
    }

    .description {
        margin-top: 5px;
        color: #555;
    }
</style>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Send Message</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Contact Table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Mengirim Pesan</h6>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="device" class="form-label">Device</label>
                    <select name="device" id="device" class="form-select">
                        <option value="">Select Device</option>
                        <!-- Add device options here -->
                    </select>
                </div>

                <div class="form-group">
                    <label for="target" class="form-label">Select Target</label>
                    <select name="target" id="target" class="form-select" onchange="showForm()">
                        <option value="input" selected>Input</option>
                        <option value="contact">Contact</option>
                        <option value="allContacts">All Contacts</option>
                        <option value="group">Group</option>
                        <option value="whatsappGroup">WhatsApp Group</option>
                        <option value="import">Import</option>
                    </select>
                </div>

                <!-- Form Section Target -->
                <div id="inputForm" class="form-section">
                    <div class="form-group">
                        <label for="target" class="form-label">Input Target</label>
                        <textarea name="target" id="target" class="form-control" rows="5" 
                            placeholder="1 number per line, Ex: 
                            081xxx|Fonnte|Indonesia 
                            081xxx|Who|France" style="white-space: pre-line;" required></textarea>
                    </div>
                </div>
                <div id="contactForm" class="form-section" style="display: none;">
                    <div class="form-group">
                        <label for="contact" class="form-label">Contacts</label>
                        <select name="contacts[]" id="contact" class="selectpicker form-control" multiple data-live-search="true">
                            <?php if (!empty($contacts)): ?>
                                <?php foreach ($contacts as $contact): ?>
                                    <option value="<?= $contact['id_kontak']; ?>"><?= $contact['nama']; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>         
                <div id="allContactsForm" class="form-section" style="display: none;">
                    <!-- <div class="p-3 mt-3 border">
                    </div> -->
                </div>               
                <div id="groupForm" class="form-section" style="display: none;">
                    <div class="form-group">
                        <label for="group" class="form-label">Group</label>
                        <select name="groups[]" id="group" class="selectpicker form-control" multiple data-live-search="true">
                            <?php if (!empty($groups)): ?>
                                <?php foreach ($groups as $group): ?>
                                    <option value="<?= $group['id_group']; ?>"><?= $group['nama_grup']; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
                <div id="whatsappGroupForm" class="form-section" style="display: none;">
                    <div class="form-group">
                        <label for="wa-group" class="form-label"> WhatsApp Group</label>
                        <select name="wa-groups[]" id="wa-group" class="selectpicker form-control" multiple data-live-search="true">
                            <?php if (!empty($wa_groups)): ?>
                                <?php foreach ($wa_groups as $wa_group): ?>
                                    <option value="<?= $wa_group['id_wagroup']; ?>"><?= $group['nama_grup']; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
                <div id="importForm" class="form-section" style="display: none;">
                    <div class="form-group">
                        <label for="import" class="form-label">Import</label>
                        <input type="file" name="importFile" id="importFile" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="countrycode" class="form-label">Country</label>
                    <select name="countryCode" id="countrycode" class="form-select">
                        <option data-countryCode="ID" value="62" selected>Indonesia (+62)</option>
                        <option data-countryCode="-" value="0">No country code</option>
                        <optgroup label="Other countries">
                            <option data-countryCode="DZ" value="213">Algeria (+213)</option>
                            <option data-countryCode="AD" value="376">Andorra (+376)</option>
                            <option data-countryCode="AO" value="244">Angola (+244)</option>
                            <option data-countryCode="AI" value="1264">Anguilla (+1264)</option>
                            <option data-countryCode="AG" value="1268">Antigua &amp; Barbuda (+1268)</option>
                        </optgroup>
                    </select>
                </div>
                <!-- New form for Delay and To -->
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="delay" class="form-label">Delay</label>
                        <input type="number" name="delay" id="delay" class="form-control" placeholder="Enter delay in seconds" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="to" class="form-label">To</label>
                        <input type="number" name="to" id="to" class="form-control" placeholder="Enter number of recipients" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="fileSource" class="form-label">File Source</label>
                    <select name="source" id="fileSource" class="form-select" onchange="showFileSourceForm()">
                        <option value="inputSource" selected>Input</option>
                        <option value="ImakePDF">ImakePDF</option>
                    </select>
                </div>

                <!-- Form Sections Input Source -->
                <div id="inputSourceForm" class="form-section">
                    <div class="form-group">
                        <label for="fileUpload" class="form-label">File</label>
                        <input type="file" name="fileUpload" id="fileUpload" class="form-control" required>
                    </div>
                </div>
                <div id="ImakePDFForm" class="form-section" style="display: none;">
                    <div class="form-group">
                        <label for="ImakePDFSelect" class="form-label">ImakePDF</label>
                        <select name="ImakePDF" id="ImakePDFSelect" class="form-select">
                            <option value="NoTemplate">No template yet</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="typeSchedule" class="form-label">Type Schedule</label>
                    <select name="typeSchedule" id="typeSchedule" class="form-select" onchange="showTypeScheduleForm()">
                        <option value="schedule" selected>Schedule</option>
                        <option value="split">Split</option>
                    </select>
                </div>

                <!-- Form Sections Type Schedule -->
                <div id="scheduleForm" class="form-section">
                    <div class="form-group">
                        <label for="schedule">Schedule</label>
                        <input type="datetime-local" id="start-date-schedule" class="form-control">
                    </div>
                </div>
                <div id="splitForm" class="form-section" style="display: none;">
                    <div class="form-group">
                        <label for="split" class="form-label">Split</label>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Targets</th>
                                        <th>Start</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <input type="number" name="target" id="target" class="form-control" required>
                                        </td>
                                        <td>
                                            <input type="datetime-local" id="start-date-split" class="form-control">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="messageSource" class="form-label">Message Source</label>
                    <select name="messageSource" id="messageSource" class="form-select" onchange="showMessageSourceForm()">
                        <option value="inputSource" selected>Input</option>
                        <option value="template">Template</option>
                        <option value="button">Button</option>
                        <option value="poll">Poll</option>
                    </select>
                </div>

                <!-- Form Sections Message Source -->
                <div id="inputMessageSourceForm" class="form-section">
                    <div class="form-group">
                        <label for="message" class="form-label">Message</label>
                        <textarea name="message" id="message" class="form-control" rows="5"
                                placeholder="Usable variable : {name}, {var1}, {var2},..." required></textarea>
                    </div>
                </div>
                <div id="templateForm" class="form-section" style="display: none;">
                    <div class="form-group">
                        <label for="template" class="form-label">Template</label>
                        <select name="templateSource" id="templatesource" class="form-select">
                            <option value="-" selected>no template yet</option>
                        </select>
                    </div>
                </div>
                <div id="buttonForm" class="form-section" style="display: none;">
                    <div class="form-group">
                        <label for="button" class="form-label">Button</label>
                        <select name="buttonSource" id="buttonsource" class="form-select">
                            <option value="-" selected>no button yet</option>
                        </select>
                    </div>
                </div>
                <div id="pollForm" class="form-section" style="display: none;">
                    <div class="form-group">
                        <label for="poll" class="form-label">Poll</label>
                        <select name="pollSource" id="pollsource" class="form-select">
                            <option value="-" selected>no poll yet</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="send" class="form-label">Send</label>
                    <select name="send" id="send" class="form-select" onchange="showSendForm()">
                        <option value="once" selected>Once</option>
                        <option value="recurring">Recurring</option>
                    </select>
                </div>

                <!-- Form Sections Send -->
                <div id="onceForm" class="form-section">
                    <!-- <div class="p-3 mt-3 border">
                    </div> -->
                </div>
                <div id="recurringForm" class="form-section" style="display: none;">
                    <div class="form-group">
                        <label for="recurring" class="form-label">Poll</label>
                        <select name="reccuring" id="recurring" class="form-select">
                            <option value="-" selected>no reccuring template</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group"> 
                    <label for="toggle" class="switch">Typing</label> 
                    <div class="toggle-switch">
                        <label class="switch">
                            <input type="checkbox" id="typingSwitch">
                            <span class="slider round"></span>
                        </label>
                    </div>
                    <div class="description" style="margin-top: 5px;"> Set to on if you want to simulate typing.</div>
                </div> 

                <button id="send-button" class="btn btn-sm btn-primary mr-2" style="width: 100%;">
                    <i class="bi bi-send"></i>
                    <span>Send</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function showForm() {
        var target = document.getElementById("target").value || "input"; // Set default value "input"
        var forms = {
            "inputForm": document.getElementById("inputForm"),
            "contactForm": document.getElementById("contactForm"),
            "allContactsForm": document.getElementById("allContactsForm"),
            "groupForm": document.getElementById("groupForm"),
            "whatsappGroupForm": document.getElementById("whatsappGroupForm"),
            "importForm": document.getElementById("importForm"),
        };

        for (var key in forms) {
            if (forms.hasOwnProperty(key)) {
                forms[key].style.display = "none";
            }
        }

        if (target) {
            var formId = target + "Form";
            if (forms[formId]) {
                forms[formId].style.display = "block";
            }
        }
    }

    // Panggil showForm saat halaman pertama kali dimuat untuk menampilkan form default
    document.addEventListener('DOMContentLoaded', function() {
        showForm();
    });
</script>

<script>
    function showFileSourceForm() {
        var fileSource = document.getElementById("fileSource").value;
        var inputSourceForm = document.getElementById("inputSourceForm");
        var ImakePDFForm = document.getElementById("ImakePDFForm");

        inputSourceForm.style.display = "none";
        ImakePDFForm.style.display = "none";

        if (fileSource === "inputSource") {
            inputSourceForm.style.display = "block";
        } else if (fileSource === "ImakePDF") {
            ImakePDFForm.style.display = "block";
        }
    }

    // Panggil showFileSourceForm saat halaman pertama kali dimuat untuk menampilkan form default
    document.addEventListener('DOMContentLoaded', function() {
        showFileSourceForm();
    });
</script>

<script>
    function showTypeScheduleForm() {
        var typeSchedule = document.getElementById("typeSchedule").value;
        var scheduleForm = document.getElementById("scheduleForm");
        var splitForm = document.getElementById("splitForm");

        // Default: Hide all form sections
        scheduleForm.style.display = "none";
        splitForm.style.display = "none";

        // Show the correct form section based on selection
        if (typeSchedule === "schedule") {
            scheduleForm.style.display = "block";
        } else if (typeSchedule === "split") {
            splitForm.style.display = "block";
        }
    }

    // Panggil showTypeScheduleForm saat halaman pertama kali dimuat untuk menampilkan form default
    document.addEventListener('DOMContentLoaded', function() {
        showTypeScheduleForm();
    });
</script>

<script>
    function showMessageSourceForm() {
        var messageSource = document.getElementById("messageSource").value;
        var inputMessageSourceForm = document.getElementById("inputMessageSourceForm");
        var templateForm = document.getElementById("templateForm");
        var buttonForm = document.getElementById("buttonForm");
        var pollForm = document.getElementById("pollForm");

        // Default: Hide all form sections
        inputMessageSourceForm.style.display = "none";
        templateForm.style.display = "none";
        buttonForm.style.display = "none";
        pollForm.style.display = "none";

        // Show the correct form section based on selection
        if (messageSource === "inputSource") {
            inputMessageSourceForm.style.display = "block";
        } else if (messageSource === "template") {
            templateForm.style.display = "block";
        } else if (messageSource === "button") {
            buttonForm.style.display = "block";
        } else if (messageSource === "poll") {
            pollForm.style.display = "block";
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        showMessageSourceForm();
    });
</script>

<script>
    function showSendForm() {
        var send = document.getElementById("send").value;
        var onceForm = document.getElementById("onceForm");
        var recurringForm = document.getElementById("recurringForm");

        // Default: Hide all form sections
        onceForm.style.display = "none";
        recurringForm.style.display = "none";

        // Show the correct form section based on selection
        if (send === "once") {
            onceForm.style.display = "block";
        } else if (send === "recurring") {
            recurringForm.style.display = "block";
        }
    }

    // Panggil showSendForm saat halaman pertama kali dimuat untuk menampilkan form default
    document.addEventListener('DOMContentLoaded', function() {
        showSendForm();
    });
</script>

<script>
    document.getElementById("typingSwitch").addEventListener("change", function() {
        if (this.checked) {
            console.log("Simulating typing is ON");
            // Add functionality for simulating typing here
        } else {
            console.log("Simulating typing is OFF");
            // Add functionality to stop simulating typing here
        }
    });
</script>



<?= $this->endSection() ?>
