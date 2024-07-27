<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lists</title>

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div class="mx-auto my-5" style="width: 800px;">
        <h1>Applicant</h1>

        


        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Dropdown button
            </button>
            <ul class="dropdown-menu">
                @foreach ($data as $item)
                    <li><a class="dropdown-item" href="#">{{ $item->last_name }}</a></li>
                @endforeach
            </ul>
        </div>

        @if(session('message'))
            <div class="alert alert-{{ session('status') }}">
                {{ session('message') }}
            </div>
        @endif

        <!-- FORM -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="/apply" method="post">
                    @csrf
                    <div class="row">
                        <div class="col col-6">
                            <div class="mb-3">
                                <label for="firstname" class="form-label m-0">First Name:</label>
                                <input type="text" name="firstname" id="create_firstname" class="form-control" required>
                            </div>
                        </div>
                        <div class="col col-6">
                            <div class="mb-3">
                                <label for="lastname" class="form-label m-0">Last Name:</label>
                                <input type="text" name="lastname" id="create_lastname" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-6">
                            <div class="mb-3">
                                <label for="address" class="form-label m-0">Address:</label>
                                <input type="text" name="address" id="create_address" class="form-control" required>
                            </div>
                        </div>
                        <div class="col col-6">
                            <div class="mb-3">
                                <label for="email" class="form-label m-0">Email:</label>
                                <input type="text" name="email" id="create_email" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-12 d-flex justify-content-end">
                            <input type="submit" value="Save" name="btn_save"  class="btn btn-secondary">
                            <input type="submit" value="Add" name="btn_add"  class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        

        <!-- TABLE -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $user)
                    <tr>
                        <th>{{ $user->id }}</th>
                        <td>{{ $user->first_name }}</td>
                        <td>{{ $user->last_name }}</td>
                        <td>{{ $user->address }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#edit_Modal" data-bs-id="{{ $user->id }}" data-bs-firstname="{{ $user->first_name }}" data-bs-lastname="{{ $user->last_name }}" data-bs-address="{{ $user->address }}"  data-bs-email="{{ $user->email }}">Edit</button>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete_Modal" data-bs-id="{{ $user->id }}" data-bs-firstname="{{ $user->first_name }}" data-bs-lastname="{{ $user->last_name }}" >Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>


        <!-- Address field -->
        <div>
            <div class="col-sm-6">
                <h3>Address Selector - Philippines</h3>
            </div>
            <hr>
            <div class="col-sm-6 mb-3">
                <label class="form-label">Region *</label>
                <select name="region" class="form-control form-control-md" id="region"></select>
                <input type="hidden" class="form-control form-control-md" name="region_text" id="region-text" required>
            </div>
            <div class="col-sm-6 mb-3">
                <label class="form-label">Province *</label>
                <select name="province" class="form-control form-control-md" id="province"></select>
                <input type="hidden" class="form-control form-control-md" name="province_text" id="province-text" required>
            </div>
            <div class="col-sm-6 mb-3">
                <label class="form-label">City / Municipality *</label>
                <select name="city" class="form-control form-control-md" id="city"></select>
                <input type="hidden" class="form-control form-control-md" name="city_text" id="city-text" required>
            </div>
            <div class="col-sm-6 mb-3">
                <label class="form-label">Barangay *</label>
                <select name="barangay" class="form-control form-control-md" id="barangay"></select>
                <input type="hidden" class="form-control form-control-md" name="barangay_text" id="barangay-text" required>
            </div>
        </div>
        


    </div>
    <!-- EDIT MODAL -->
    <div class="modal fade" id="edit_Modal" tabindex="-1" aria-labelledby="edit_ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="edit_ModalLabel">Edit Details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="edit_form">
                        @csrf
                        <div class="row">
                            <div class="col col-12">
                                <div class="mb-3">
                                    <label for="edit_firstname" class="form-label m-0"> First Name:</label>
                                    <input type="text" name="firstname" id="edit_firstname" class="form-control">
                                </div>
                            </div>
                            <div class="col col-12">
                                <div class="mb-3">
                                    <label for="edit_lastname" class="form-label m-0">Last Name:</label>
                                    <input type="text" name="lastname" id="edit_lastname" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col col-12">
                                <div class="mb-3">
                                    <label for="address" class="form-label m-0">Address:</label>
                                    <input type="text" name="address" id="edit_address" class="form-control">
                                </div>
                            </div>
                            <div class="col col-12">
                                <div class="mb-3">
                                    <label for="email" class="form-label m-0">Email:</label>
                                    <input type="text" name="email" id="edit_email" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col col-12 d-flex justify-content-end">
                                <!-- <input type="hidden" name="id" id="edit_id"> -->
                                <input type="submit" value="Save" name="btn_edit"  class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- JS EDIT MODAL -->
    <script>
        const edit_Modal = document.getElementById('edit_Modal')
        if (edit_Modal) {
            edit_Modal.addEventListener('show.bs.modal', event => {
            // Button that triggered the modal
            const edit_button = event.relatedTarget

            // Extract info from data-bs-* attributes
            const id = edit_button.getAttribute('data-bs-id')
            const uri = '/updateApplicant/'+id
            const firstname = edit_button.getAttribute('data-bs-firstname')
            const lastname = edit_button.getAttribute('data-bs-lastname')
            const address = edit_button.getAttribute('data-bs-address')
            const email = edit_button.getAttribute('data-bs-email')

            // Update the modal's content.
            // const modalTitle = edit_Modal.querySelector('.modal-title')
            // const modalBodyInputId = edit_Modal.querySelector('.modal-body #edit_id')
            const modalBodyForm = edit_Modal.querySelector('.modal-body #edit_form')
            const modalBodyInputFirstName = edit_Modal.querySelector('.modal-body #edit_firstname')
            const modalBodyInputLastName = edit_Modal.querySelector('.modal-body #edit_lastname')
            const modalBodyInputAddress = edit_Modal.querySelector('.modal-body #edit_address')
            const modalBodyInputEmail = edit_Modal.querySelector('.modal-body #edit_email')

            // modalTitle.textContent = `New message to ${recipient}`

            modalBodyForm.setAttribute("action", uri)
            modalBodyInputFirstName.value = firstname
            modalBodyInputLastName.value = lastname
            modalBodyInputAddress.value = address
            modalBodyInputEmail.value = email
        })
        }
    </script>

    <!-- DELETE MODAL -->
    <div class="modal fade" id="delete_Modal" tabindex="-1" aria-labelledby="delete_ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="delete_ModalLabel">Remove Applicant</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="delete_form">
                        @csrf
                        <p>Are you sure you want to remove <span id="delete_name"></span>?</p>
                        <div class="row">
                            <div class="col col-12 d-flex justify-content-end">
                                <!-- <input type="hidden" name="id" id="delete_id"> -->
                                <input type="submit" value="Yes" name="btn_delete"  class="btn btn-danger">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- JS DELETE MODAL -->
    <script>
        const delete_Modal = document.getElementById('delete_Modal')
        if (delete_Modal) {
        delete_Modal.addEventListener('show.bs.modal', event => {
            // Button that triggered the modal
            const delete_button = event.relatedTarget

            // Extract info from data-bs-* attributes
            const id = delete_button.getAttribute('data-bs-id')
            const uri = '/deleteApplicant/'+id
            const firstname = delete_button.getAttribute('data-bs-firstname')
            const lastname = delete_button.getAttribute('data-bs-lastname')
            const name = firstname+" "+lastname

            // Update the modal's content.
            // const modalTitle = delete_Modal.querySelector('.modal-title')
            // const modalBodyInputId = delete_Modal.querySelector('.modal-body #delete_id')
            const modalBodyForm = delete_Modal.querySelector('.modal-body #delete_form')
            const modalBodyInputName = delete_Modal.querySelector('.modal-body #delete_name')

            // modalTitle.textContent = `New message to ${recipient}`
            // modalBodyInputId.value = id
            modalBodyForm.setAttribute("action", uri)
            modalBodyInputName.textContent = name
        })
        }
    </script>
    
<!--Chat button will appear here-->
<div id="MyLiveChatContainer"></div>

<!--Add the following script at the bottom of the web page (before </body></html>)-->
<script type="text/javascript">function add_chatbutton(){var hccid=56590465;var nt=document.createElement("script");nt.async=true;nt.src="https://mylivechat.com/chatbutton.aspx?hccid="+hccid;var ct=document.getElementsByTagName("script")[0];ct.parentNode.insertBefore(nt,ct);}
add_chatbutton();</script>

<!-- <script src="resources/js/ph-address-selector.js"></script> -->
<script src="{{ asset('js/ph-address-selector.js') }}"></script>
</body>
</html>