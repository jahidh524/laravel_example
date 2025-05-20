<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Student List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <!-- Optional: Dark Theme (like your screenshot) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <style>
        body {
            background: #f8f9fa;
        }

        .sidebar {
            width: 200px;
            background: #fff;
            min-height: 100vh;
            position: fixed;
            padding-top: 20px;
        }

        .main {
            margin-left: 220px;
            padding: 20px;
        }

        .navbar {
            background-color: rgb(132, 230, 200);
            color: white;
            padding: 15px;
        }

        .profile-img {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 5px;
        }

        .dataTables_length select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;

            background-image: url('data:image/svg+xml;utf8,<svg fill="gray" height="16" viewBox="0 0 24 24" width="16" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/></svg>');
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 16px 16px;

            padding-right: 10px;
            min-width: 60px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .dataTables_paginate {
            margin-top: 20px;
            text-align: center;
        }

        .dataTables_paginate .paginate_button {
            background-color: #0d6efd;
            /* Bootstrap primary */
            color: white !important;
            padding: 6px 12px;
            margin: 0 2px;
            border-radius: 4px;
            border: none;
            font-weight: bold;
        }

        .dataTables_paginate .paginate_button.current {
            background-color: #198754 !important;
            /* Bootstrap success */
            color: #fff !important;
        }

        .dataTables_paginate .paginate_button:hover {
            background-color: #0b5ed7;
            color: white !important;
        }
    </style>
</head>

<body>

    <div class="navbar d-flex align-items-center justify-content-start" style="gap: 10px;">
        <img src="uploads/logo.png" alt="Logo" style="height: 40px;">
        <h4 class="text-white m-0">Automation School and College</h4>
    </div>

    <div class="sidebar border-end">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="#" class="nav-link">👨‍🎓 Students</a>
            </li>
            <li class="nav-item">
                <a href="logout.php" class="nav-link text-danger">🚪 Logout</a>
            </li>
        </ul>
    </div>

    <div class="main">
        <div class="d-flex justify-content-between mb-3">
            <h3>Student List</h3>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addStudentModal">Add New</button>
        </div>
        <table id="studentTable" class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Batch</th>
                    <th>Roll</th>
                    <th>GPA</th>
                    <th>Phone</th>
                    <th>Profile</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

                @php $index = 1; @endphp

                @foreach ($result as $row)
                <tr>
                    <td>{{ $index++ }}</td>
                    <td>{{ $row->name }}</td>
                    <td>{{ $row->department }}</td>
                    <td>{{ $row->batch }}</td>
                    <td>{{ $row->roll }}</td>
                    <td>{{ $row->gpa }}</td>
                    <td>{{ $row->contact }}</td>
                    <td>
                        @if (!empty($row->profile_img) && file_exists(public_path('uploads/' . $row->profile_img)))
                        <img src="{{ asset('uploads/' . $row->profile_img) }}" class="profile-img">
                        @else
                        No Image
                        @endif
                    </td>
                    <td>
                        <button
                            class="btn btn-warning btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#editStudentModal"
                            data-id="{{ $row->id }}"
                            data-name="{{ $row->name }}"
                            data-department="{{ $row->department }}"
                            data-batch="{{ $row->batch }}"
                            data-roll="{{ $row->roll }}"
                            data-gpa="{{ $row->gpa }}"
                            data-contact="{{ $row->contact }}">
                            Edit
                        </button>
                        <form action="{{ route('students.destroy', $row->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this student?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach



            </tbody>
        </table>


        <!-- Modal -->
        <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add New Student</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body row g-3">
                            <div class="col-md-6">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label>Department</label>
                                <input type="text" name="department" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label>Batch</label>
                                <input type="text" name="batch" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label>Roll</label>
                                <input type="number" name="roll" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label>GPA</label>
                                <input type="number" name="gpa" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label>Phone</label>
                                <input type="number" name="phone" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label>Profile Image</label>
                                <input type="file" name="profile_img" class="form-control" id="profile_img" accept="image/*">
                                <small class="text-muted">Allowed: JPG, PNG, JPEG | Max: 2MB</small>
                                <div id="image-error" class="text-danger mt-1"></div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="addStudent" class="btn btn-primary">Save Student</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Student Modal -->
        <div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form method="POST" action="update_student.php">
                    <input type="hidden" name="id" id="edit-id">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Student</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body row g-3">
                            <div class="col-md-6">
                                <label>Name</label>
                                <input type="text" name="name" id="edit-name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label>Department</label>
                                <input type="text" name="department" id="edit-department" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label>Batch</label>
                                <input type="text" name="batch" id="edit-batch" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label>Roll</label>
                                <input type="text" name="roll" id="edit-roll" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label>GPA</label>
                                <input type="text" name="gpa" id="edit-gpa" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label>Phone</label>
                                <input type="text" name="phone" id="edit-phone" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="updateStudent" class="btn btn-primary">Update Student</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#studentTable').DataTable({
                "order": [
                    [0, "asc"]
                ],
                "paging": true,
                "searching": true,
                "info": true,
                "lengthChange": true
            });
        });
        document.getElementById('profile_img').addEventListener('change', function() {
            const file = this.files[0];
            const errorDiv = document.getElementById('image-error');
            errorDiv.innerText = '';

            if (file) {
                const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                const maxSize = 2 * 1024 * 1024; // 2MB

                if (!validTypes.includes(file.type)) {
                    errorDiv.innerText = 'Only JPG, PNG, and JPEG files are allowed.';
                    this.value = '';
                } else if (file.size > maxSize) {
                    errorDiv.innerText = 'Image size must be less than 2MB.';
                    this.value = '';
                }
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
            const editModal = document.getElementById('editStudentModal');
            editModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                document.getElementById('edit-id').value = button.getAttribute('data-id');
                document.getElementById('edit-name').value = button.getAttribute('data-name');
                document.getElementById('edit-department').value = button.getAttribute('data-department');
                document.getElementById('edit-batch').value = button.getAttribute('data-batch');
                document.getElementById('edit-roll').value = button.getAttribute('data-roll');
                document.getElementById('edit-gpa').value = button.getAttribute('data-gpa');
                document.getElementById('edit-phone').value = button.getAttribute('data-phone');
            });
        });
    </script>

</body>

</html>