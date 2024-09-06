@extends('Admin.AdminLayout')
@section('title', 'Email ')
@section('content')

    <style>
        .badge {
            color: white;
            padding: 10px;
            font-size: 15px;
            cursor: pointer;
        }
    </style>

    <main>

        <div class="container-fluid px-4">
            <!-- Modal -->
            <div class="modal fade" id="contact_modal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Contact</h3>
                        </div>

                        <div class="modal-body">
                            <form id="contact_form">
                                <input type="hidden" class="form-control" value="" name="contact_id" id="contact_id">
                                <div class="form-group mb-3">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name" id="name">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Gender</label>
                                    {{-- <input type="text" class="form-control"> --}}
                                    <select class="form-select form-select-sm" aria-label=".form-select-sm example"
                                        name="gender" id="gender">
                                        <option>Male</option>
                                        <option>Female</option>
                                    </select>

                                </div>
                                <div class="form-group mb-3">
                                    <label>Capacity</label>
                                    <textarea type="text" class="form-control" name="capacity" id="capacity" rows="10"></textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Email</label>
                                    <input type="text" class="form-control" name="email" id="email">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Phone</label>
                                    <input type="number" class="form-control" name="phone" id="phone">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Experties</label>
                                    <textarea type="text" class="form-control" name="experties" id="experties" rows="10"></textarea>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Address</label>
                                    <textarea type="text" class="form-control" name="address" id="address" rows="10"></textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Tag</label>
                                    <input type="text" class="form-control" name="tag" id="tag">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="savebtn" class="btn btn-lg btn-primary" onclick="SaveContact()"
                                style="width: 100%">Save</button>
                        </div>




                    </div>
                </div>
            </div>

            <div class="modal fade" id="mail_modal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Contact</h3>
                        </div>
                        <div class="modal-body">
                            <form id="mail_form">
                                <input type="hidden" class="form-control" value="" name="contact_id"
                                    id="recipientid">

                                <div class="form-group mb-3">
                                    <label>Email</label>
                                    <input type="text" class="form-control" name="email" id="recipientEmail">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Body</label>
                                    <textarea type="text" class="form-control" name="mail_body" id="mail_body" rows="10"></textarea>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="emailbtn" class="btn btn-lg btn-primary" onclick="SendMail()"
                                style="width: 100%">Send</button>
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal fade" id="excel_modal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Import Excel <a download="Import_Template.xlsx" class="btn btn-info"
                                    href="{{ url('public/Import_Template.xlsx') }}" role="button">Download Template</a>
                            </h3>
                        </div>
                        <div class="modal-body">
                            <form id="excel_form">
                                <div class="form-group mb-3">
                                    <label>Select The Excel Sheet</label>
                                    <input type="file" class="form-control" name="excel_sheet" id="excel_sheet"
                                        onchange="UploadExcel1(this.files[0])" accept=".xls, .xlsx">
                                </div>
                            </form>
                            <div class="modal-footer">
                                <div id="recordCount" class="alert alert-info w-100"
                                    style="display:none;text-align:center;">
                                    0 records found
                                </div>

                                <button type="button" id="emailbtn" class="btn btn-lg btn-primary" style="width: 100%"
                                    onclick="UploadExcel2()">Upload</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card my-4">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h3 class="mt-2">Contact</h3>
                        </div>
                        <div class="col-6">
                            <button type="button" id="ComposeEmail" class="btn btn-secondary mt-2 mx-2"
                                style="float: right" onclick="ComposeEmail()">Email</button>
                            <button type="button" id="bulkmail" class="btn btn-secondary mt-2 mx-2 "
                                style="float: right" onclick="bulkmail()">Bulk Email</button>
                            <button type="button" class="btn btn-primary mt-2" style="float: right"
                                onclick="$('#contact_modal').modal('show')">New Contact</button>
                            <button type="button" id="bulkdelete" class="btn btn-danger mt-2 mx-2" style="float: right"
                                onclick="bulkdelete(selectedIds=contact_id)">Bulk Delete</button>
                        </div>
                    </div>

                </div>

                <div class="card-body">

                    <table id="contact_table" class="table table-bordered table-striped">
                        <thead>
                            <button type="button" class="btn btn-secondary mt-0 mx-2" style="float: left"
                                onclick="ImportExcel()">Import Excel</button>
                            <tr>

                                <th><input type="checkbox" id="CheckBox" onclick="toggleAllCheckboxes(this)" />
                                </th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Capacity</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Experties</th>
                                <th>Address</th>
                                <th>Tag</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <div>
                            <h6 style="float: right;height: 35px;margin: 0; ">Filter By Tag: <span
                                    id="current_tag"></span>
                            </h6>

                            <select id="tagSelect" class="mx-2" onchange="toggleTagFilter(this.value);">
                                <option value="">Select a tag</option>
                            </select>
                        </div>

                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script src="{{ url('public/admin/js/sweetalert2@11.js') }}"></script>


    <script>
        var tags = []; // Global variable to store the selected tag
        const colorCache = {};
        var callcount = 0;
        var isTagSelectPopulated = false;
        $(document).ready(function() {
            GetData();
        })




        ///----------------------------------- CRUD FUNCTIONS --------------------------////

        // FETCH DATATABLE



        function GetData() {
            $('#contact_table').DataTable().destroy();
            $('#contact_table').DataTable({
                ajax: {
                    url: "{{ route('ContactFetch') }}",
                    data: function(d) {
                        console.log(tags);

                        if (tags.length > 0) {
                            d.tags = tags; // Send the array of selected tags
                        }
                    },
                    dataSrc: ""
                },
                columns: [{
                        data: 'contact_id',
                        render: function(d, e, f) {
                            return `
                    <td>
                        <input type="checkbox"
                               value="${d}"
                               class="row-checkbox"
                               data-email="${f.email}"
                               onchange="toggleMailButtons()">
                    </td>`;
                        },
                        "searchable": false,
                        "orderable": false,
                    },
                    {
                        data: 'contact_id'
                    },
                    {
                        data: 'name',
                        "visible": false
                    },
                    {
                        data: 'gender',
                        "visible": false
                    },
                    {
                        data: 'capacity',
                        "visible": false
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'phone'
                    },
                    {
                        data: 'experties'
                    },
                    {
                        data: 'address',
                        "visible": false
                    },
                    {
                        data: 'tag',
                        render: function(data, type, row) {
                            return badges = (data.split(',').map(e => {
                                let singleTag = e.trim();
                                return generateBadge(singleTag, stringToColor(singleTag));
                            })).join(' ');


                        }
                    },
                    {
                        data: 'contact_id',
                        render: function(d, e, f) {
                            return `
                    <button class="btn btn-info" onclick="ContactEdit(${d})">Edit</button>
                    <button class="btn btn-danger" onclick="ContactDelete(${d})">Delete</button>
                    <button class="btn btn-primary" onclick="ComposeEmail(${d}, '${f.email}')">Mail</button>`;
                        }
                    }
                ],
                responsive: true,
                buttons: ['colvis', 'excel'],
                dom: "Bfrtip",
                initComplete: function(settings, json) {
                    TagSelect(); // Run the tag select function after DataTable is fully loaded
                }
            });
        }

        // function filterByTag(selectedTag) {
        //     if (tags === selectedTag) {
        //         tags = '';
        //         $('#current_tag').html('None'); // Reset label
        //     } else {

        //         tags = selectedTag;
        //         let color = stringToColor(tags);
        //         $('#current_tag').html(generateBadge(tags, color));
        //     }
        //     GetData(); // Reload DataTable with the new or cleared tag
        // }


        function toggleTagFilter(tag) {
            const index = tags.indexOf(tag);

            if (index > -1) {
                // Tag is already selected, remove it
                tags.splice(index, 1);
            } else {
                // Tag is not selected, add it
                tags.push(tag);
            }

            updateSelectedTagsUI(); // Update the UI with selected tags
            GetData(); // Reload the DataTable with the updated tags
        }

        function updateSelectedTagsUI() {
            if (tags.length === 0) {
                $('#current_tag').html('None');
            } else {
                let badges = tags.map(tag => {
                    let color = stringToColor(tag);
                    return generateBadge(tag, color);
                });
                $('#current_tag').html(badges.join(' '));
            }
        }

        function TagSelect() {
            if (isTagSelectPopulated) return;
            const tagSelect = document.getElementById('tagSelect');

            // Clear the existing options
            tagSelect.innerHTML = '<option value="">Select a tag</option>';
            console.log(colorCache);

            // Loop through the tags in the colorCache and create option elements
            Object.keys(colorCache).forEach(tag => {
                let option = document.createElement('option');
                option.value = tag;
                option.textContent = tag;
                tagSelect.appendChild(option);
            });
        }

        function stringToColor(str) {
            if (colorCache[str]) {
                return colorCache[str];
            }

            var hash = 0;
            for (let i = 0; i < str.length; i++) {
                hash = str.charCodeAt(i) + ((hash << 5) - hash);
            }

            const color = '#' + ((hash & 0xFFFFFF).toString(16).padStart(6, '0'));
            colorCache[str] = color;
            return color;
        }

        function generateBadge(tag, color) {
            return `<span class="badge rounded-pill" style="background-color: ${color};" onclick="toggleTagFilter('${tag}')">${tag}</span>`
        }






        $(document).ready(function() {
            toggleMailButtons();
        });

        function toggleAllCheckboxes(masterCheckbox) {
            $('.row-checkbox').prop('checked', masterCheckbox.checked);
            toggleMailButtons();
        }

        function toggleMailButtons() {
            if ($('.row-checkbox:checked').length > 0) {
                $('#bulkmail').show();
                $('#ComposeEmail').hide();
                $('#bulkdelete').show()
            } else {
                $('#bulkmail').hide();
                $('#ComposeEmail').show();
                $('#bulkdelete').hide()
            }
        }

        //CREATE NEW CONTACT
        function SaveContact() {
            $("#submitbtn").prop('disabled', true)
            var formData = new FormData($('#contact_form')[0]);
            $.ajax({
                url: "{{ 'ContactCreate' }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: (res) => {
                    if (res.success) {
                        swal("Success!", res.message, "success");
                        document.getElementById("contact_form").reset();
                        GetData();
                        $('#contact_form')[0].reset();
                    } else {
                        swal("Error!", res.message, "error");
                    }
                }
            });
        }

        function ContactDelete(contact_id) {
            $.ajax({
                url: "{{ route('ContactDelete') }}",
                type: 'get',
                data: {
                    contact_id: contact_id
                },
                success: function(data) {
                    if (data.success) {
                        swal("Success!", data.message, "success");
                        GetData();
                    } else {
                        swal("Error!", data.message, "error");
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Error:", error);
                    swal("Error!", "An error occurred while deleting the contact.", "error");
                }
            });
        }

        function bulkdelete() {
            var selectedIds = [];
            $('.row-checkbox:checked').each(function() {
                selectedIds.push($(this).val()); // Still captures the contact_id
            });

            if (selectedIds.length > 0) {
                $.ajax({
                    url: "{{ route('BulkDelete') }}",
                    type: 'get',
                    data: {
                        contact_id: selectedIds
                    },
                    success: function(data) {
                        if (data.success) {
                            swal("Success!", data.message, "success");
                            GetData(); // Refresh data
                            $('#bulkdelete').hide();
                        } else {
                            swal("Error!", data.message, "error");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log("Error:", error);
                        swal("Error!", "An error occurred while deleting the contacts.", "error");
                    }
                });
            } else {
                swal("Warning!", "No contacts selected for deletion.", "warning");
            }
        }



        function ContactEdit(contact_id) {
            $('#contact_form')[0].reset();
            $('#contact_modal').modal('show')
            $.get("{{ route('ContactFetch') }}", {
                contact_id: contact_id
            }, function(data) {
                Object.keys(data[0]).forEach(function(key) {
                    $(`#${key}`).val(data[0][key]);
                });
            });
        }

        ///----------------------------------- CRUD FUNCTIONS --------------------------////









        ///----------------------------------- MAil FUNCTIONS --------------------------////



        function SendMail() {
            showLoading();
            $("#emailbtn").prop('disabled', true);
            var formData = new FormData($('#mail_form')[0]);
            formData.append('emails', JSON.stringify(($('#recipientEmail').val()).split(',').map(email => email.trim())));

            $.ajax({
                url: "{{ route('SendMail') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    if (res.success) {
                        swal("Success!", res.message, "success");
                        $('#mail_form')[0].reset();
                        $('#mail_modal').modal('hide');
                    } else {
                        swal("Error!", res.message, "error");
                    }
                    $("#emailbtn").prop('disabled', false); // Re-enable the email button
                    hideLoading(); // Hide loading indicator
                },
                error: function() {
                    swal("Error!", "An unexpected error occurred.", "error");
                    $("#emailbtn").prop('disabled', false); // Re-enable the email button
                    hideLoading(); // Hide loading indicator
                }
            });
        }


        function ComposeEmail(contact_id, email) {
            $('#mail_form')[0].reset();
            $('#recipientid').val(contact_id);
            $('#recipientEmail').val(email);
            $('#mail_modal').modal('show');
        }

        function bulkmail() {
            var selectedEmails = [];
            $('.row-checkbox:checked').each(function() {
                selectedEmails.push($(this).data('email')); // Fetch email from data attribute
            });

            $('#recipientEmail').val(selectedEmails.join(', ')); // Join emails with commas
            $('#mail_modal').modal('show');
            GetData();
        }



        ///----------------------------------- MAil FUNCTIONS --------------------------////



        ///----------------------------------- Excel FUNCTIONS --------------------------////

        function ImportExcel(contact_id, email) {
            $('#excel_form')[0].reset();
            $('#excel_modal').modal('show');
        }

        let validatedExcelRows = null;

        function UploadExcel1(file) {
            const validFileExtensions = ['xls', 'xlsx'];
            const fileExtension = file.name.split('.').pop().toLowerCase();
            if (!validFileExtensions.includes(fileExtension)) {
                swal('Only Excel files are allowed!');
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                try {
                    const data = new Uint8Array(e.target.result);
                    const workbook = XLSX.read(data, {
                        type: 'array'
                    });
                    const worksheet = workbook.Sheets[workbook.SheetNames[0]];
                    const json = XLSX.utils.sheet_to_json(worksheet, {
                        header: 1,
                        raw: false
                    });

                    if (json.length < 1) {
                        swal('Excel file does not contain headers.');
                        GetData();
                        return;
                    }

                    let excelHeaders = json[0].map(header => header.trim().toLowerCase());
                    let excelRows = json.slice(1)
                        .map(row => row.map(cell => cell !== undefined && cell !== null ? cell.toString().trim() : ''))
                        .filter(row => row.length > 0);

                    const recordCount = excelRows.length;
                    const recordCountElement = document.getElementById('recordCount');
                    recordCountElement.style.display = 'block';
                    recordCountElement.innerText = `${recordCount} record(s) are going to be inserted.`;
                    $.ajax({
                        url: '{{ route('getContactHeaders') }}',
                        type: 'GET',
                        dataType: 'json',
                        success: function(res) {
                            if (res.success) {
                                if (!Array.isArray(res.headers)) {
                                    swal("Error!", "Invalid headers format received from the server.",
                                        "error");
                                    GetData();
                                    return;
                                }

                                let dbHeaders = res.headers.map(header => header.trim().toLowerCase());
                                let isMatched = excelHeaders.length === dbHeaders.length;

                                if (isMatched) {
                                    for (let i = 0; i < excelHeaders.length; i++) {
                                        if (excelHeaders[i] !== dbHeaders[i]) {
                                            isMatched = false;
                                            break;
                                        }
                                    }
                                }

                                if (isMatched) {
                                    swal("Success!",
                                        `Your file has been validated! Click 'Upload' to proceed.`,
                                        "success");
                                    validatedExcelRows = excelRows;
                                    GetData();
                                } else {
                                    swal("Error!", "Upload a file with the correct headers.", "error");
                                    validatedExcelRows = null;
                                    GetData();
                                }
                            } else {
                                swal("Error!", res.message, "error");
                                validatedExcelRows = null;
                                GetData();

                            }
                        },
                        error: function(xhr, status, error) {
                            swal("Error!", "Failed to fetch database headers.", "error");
                            validatedExcelRows = null;
                            GetData();
                        }
                    });
                } catch (err) {
                    swal("Error!", "Failed to process Excel file.", "error");
                    GetData();
                }
            };

            reader.readAsArrayBuffer(file);
        }

        function UploadExcel2() {
            $('#excel_modal').hide();
            if (!validatedExcelRows || validatedExcelRows.length === 0) {
                swal("Error!", "No validated data to upload. Please upload and validate the file first.", "error");
                return;
            }

            console.log('Excel Rows to Upload:', validatedExcelRows);

            $.ajax({
                url: "{{ route('BulkInsert') }}",
                type: 'POST',
                contentType: 'application/json',
                dataType: 'json',
                data: JSON.stringify({
                    excelRows: validatedExcelRows
                }),

                success: function(res) {
                    $('#recordCount').hide();

                    if (res.success) {

                        swal("Success!", res.message, "success");
                        $('#excel_modal').show();
                    } else {

                        $('#excel_modal').hide();
                        var table = `<div style="max-height: 200px;"><table class="table table-bordered" >
                        <tr>
                            <th scope="col">Phone</th>
                            <th scope="col">Email</th>
                        </tr>`
                        let duplicateMessages = res.duplicates.map(item =>
                            `<tr><td>${item.phone}</td><td>${item.email}</td></tr>`
                        ).join(''); // Join the array of strings into one string

                        table = table + duplicateMessages + `</table></div>`;

                        console.log(table);

                        Swal.fire({
                            title: "Error",
                            icon: "error",
                            html: table
                        });
                        $('#excel_modal').show();
                        GetData();

                        // swal({ html:true, title:"Error", text:table});
                        // swal("Error!", res.message + duplicateMessages, "error");
                    }

                },

                error: function(xhr, status, error) {
                    console.error("Upload Error:", status, error, xhr.responseText);
                    swal("Error!", "Failed to upload Excel data.", "error");
                    GetData();
                }
            });
        }





        ///----------------------------------- Excel FUNCTIONS --------------------------////
    </script>
@endsection
