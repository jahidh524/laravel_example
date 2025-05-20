@extends('layouts.app')

@section('title', 'Student List')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

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
@endsection

@section('content')
<div class="navbar d-flex align-items-center justify-content-start" style="gap: 10px;">
    <img src="{{ asset('uploads/logo.png') }}" alt="Logo" style="height: 40px;">
    <h4 class="text-white m-0">Automation School and College</h4>
</div>

<div class="sidebar border-end">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="{{ route('students.index') }}" class="nav-link">👨‍🎓 Students</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('logout') }}" class="nav-link text-danger" 
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
               🚪 Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    </ul>
</div>

<div class="main">
    <div class="d-flex justify-content-between mb-3">
        <h3>Student List</h3>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addStudentModal">Add New</button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <table id="studentTable" class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Department</th>
                <th>Batch</th>
                <th>Roll</th>
                <th>GPA</th>
                <th>contact</th>
                <th>Profile</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $index => $student)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->department }}</td>
                    <td>{{ $student->batch }}</td>
                    <td>{{ $student->roll }}</td>
                    <td>{{ $student->gpa }}</td>
                    <td>{{ $student->contact }}</td>
                    <td>
                        @if($student->profile_img && file_exists(public_path('uploads/' . $student->profile_img)))
                            <img src="{{ asset('uploads/' . $student->profile_img) }}" class="profile-img">
                        @else
                            No Image
                        @endif
                    </td>
                    <td>
                        <button
                            class="btn btn-warning btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#editStudentModal"
                            data-id="{{ $student->id }}"
                            data-name="{{ $student->name }}"
                            data-department="{{ $student->department }}"
                            data-batch="{{ $student->batch }}"
                            data-roll="{{ $student->roll }}"
                            data-gpa="{{ $student->gpa }}"
                            data-contact="{{ $student->contact }}">
                            Edit
                        </button>
                        <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" 
                                    onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Add Student Modal -->
    <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form method="POST" action="{{ route('students.store') }}" enctype="multipart/form-data">
                @csrf
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
                            <label>contact</label>
                            <input type="number" name="contact" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Profile Image</label>
                            <input type="file" name="profile_img" class="form-control" id="profile_img" accept="image/*">
                            <small class="text-muted">Allowed: JPG, PNG, JPEG | Max: 2MB</small>
                            <div id="image-error" class="text-danger mt-1"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Student</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Student Modal -->
    <div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form method="POST" id="edit-form">
                @csrf
                @method('PUT')
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
                            <label>contact</label>
                            <input type="text" name="contact" id="edit-contact" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update Student</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#studentTable').DataTable({
            "order": [[0, "asc"]],
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
            const studentId = button.getAttribute('data-id');
            
            document.getElementById('edit-id').value = studentId;
            document.getElementById('edit-name').value = button.getAttribute('data-name');
            document.getElementById('edit-department').value = button.getAttribute('data-department');
            document.getElementById('edit-batch').value = button.getAttribute('data-batch');
            document.getElementById('edit-roll').value = button.getAttribute('data-roll');
            document.getElementById('edit-gpa').value = button.getAttribute('data-gpa');
            document.getElementById('edit-contact').value = button.getAttribute('data-contact');
            
            // Update the form action URL with the student ID
            const form = document.getElementById('edit-form');
            form.action = "{{ route('students.update', '') }}/" + studentId;
        });
    });
</script>
@endsection