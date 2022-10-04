@extends('setup.master')
@section('content')
    <style type="text/css">
        body {
            font-family: Arial;
            font-size: 10pt;
        }

        table {
            border: 1px solid #ccc;
            border-collapse: collapse;
        }

        table th {
            background-color: #F7F7F7;
            color: #333;
            font-weight: bold;
        }

        table th,
        table td {
            padding: 5px;
            border: 1px solid #ccc;
        }
    </style>
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <div class="page-header my-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title bold-heading">Chart Of Accounts</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Chart Of Accounts</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="page-menu">
                <div class="row">
                    <div class="col-sm-12">
                        <ul class="nav nav-tabs nav-tabs-bottom">
                            {{-- <li class="nav-item"> --}}
                            {{-- <a class="nav-link active" data-toggle="tab" href="#main_type">Main Type</a> --}}
                            {{-- </li> --}}
                            {{-- <li class="nav-item"> --}}
                            {{-- <a class="nav-link" data-toggle="tab" href="#sub_type">Sub Type</a> --}}
                            {{-- </li> --}}
                            {{-- <li class="nav-item"> --}}
                            {{-- <a class="nav-link" data-toggle="tab" href="#detail_type">Detail Type</a> --}}
                            {{-- </li> --}}
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#level_1">Level 1</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#level_2">Level 2</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#level_3">Level 3</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#level_4">Level 4</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#level_5">Level 5</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="tab-content">
                <!--Main Account Type-->
                <div class="tab-pane show " id="main_type">
                    <!-- Add Addition Button -->
                    <div class="text-right mb-4 clearfix">
                        <button class="btn btn-primary add-btn" type="button" data-toggle="modal"
                            data-target="#main_type_modal" title="Add Main Type">
                            <i class="fa fa-plus"></i> </button>
                    </div>
                    <!-- /Add Addition Button -->
                    <!-- Payroll Additions Table -->
                    <div class="card">
                        <div class="card-body">
                            <div class="payroll-table">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>SR#</th>
                                                <th>Main A/C Name</th>
                                                <th>Created At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="mainAccountTable">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Payroll Additions Table -->
                </div>
                <!--Main Account Type End Here-->
                <!--Sub Account Type Start Here-->


                {{-- Level 1 --}}
                <div class="tab-pane active" id="level_1">
                    <div class="text-right mb-4 clearfix">
                        <button class="btn btn-primary add-btn" type="button" data-toggle="modal"
                            data-target="#level_1_modal" title="assign allowance"><i class="fa fa-plus"></i></button>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="payroll-table">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover data-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Level Head</th>
                                                <th>Created At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="level_1_table"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Level 1 --}}

                {{-- Level 2 --}}
                <div class="tab-pane" id="level_2">
                    <div class="text-right mb-4 clearfix">
                        <button class="btn btn-primary add-btn" type="button" data-toggle="modal"
                            data-target="#level_2_modal" title="assign allowance"><i class="fa fa-plus"></i></button>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="payroll-table">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover data-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Level One </th>
                                                <th>Level Two Head</th>
                                                <th>Created At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="level_2_table">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Level 2 --}}

                {{-- Level 3 --}}
                <div class="tab-pane" id="level_3">
                    <div class="text-right mb-4 clearfix">
                        <button class="btn btn-primary add-btn" type="button" data-toggle="modal"
                            data-target="#level_3_modal" title="assign allowance"><i class="fa fa-plus"></i></button>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="payroll-table">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover data-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Level Two </th>
                                                <th>Level Three Head</th>
                                                <th>Created At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="level_3_table">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Level 3 --}}

                {{-- Level 4 --}}
                <div class="tab-pane " id="level_4">
                    <div class="text-right mb-4 clearfix">
                        <button class="btn btn-primary add-btn" type="button" data-toggle="modal"
                            data-target="#level_4_modal" title="assign allowance"><i class="fa fa-plus"></i></button>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="payroll-table">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover data-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Level Three </th>
                                                <th>Level Four Head</th>
                                                <th>Created At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="level_4_table"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Level 4 --}}

                {{-- Level 5 --}}
                <div class="tab-pane " id="level_5">
                    <div class="text-right mb-4 clearfix">
                        <button class="btn btn-primary add-btn" type="button" data-toggle="modal"
                            data-target="#level_5_modal" title="assign allowance"><i class="fa fa-plus"></i></button>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="payroll-table">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover data-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Level Four</th>
                                                <th>Level Five Head</th>
                                                <th>Created At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="level_5_table"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Level 5 --}}


            </div>
        </div>
    </div>


    <!-- Level 1 Modal Start-->
    <div id="level_1_modal" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Level 1 Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" id="level_1_form" class="needs-validation" novalidate>
                        {{-- @csrf --}}
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Level Head<span class="text-danger">*</span></label>
                                    <input type="text" name="level_head" placeholder="Level Head" required
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn add_level_1" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Level 1 Modal End-->

    <!-- Edit Level 1 Modal Start-->
    <div id="Edit_level_1_modal" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Level 1 Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" id="Edit_level_1_form" class="needs-validation" novalidate>
                        <input type="hidden" name="level_1_id">
                        {{-- @csrf --}}
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Level Head<span class="text-danger">*</span></label>
                                    <input type="text" name="level_head" placeholder="Level Head" required
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn update_level_1" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Level 1 Modal End-->


    <!-- Level 2 Modal Start-->
    <div id="level_2_modal" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Level Two Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" id="level_2_form" class="needs-validation" novalidate>
                        {{-- @csrf --}}
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Level One<span class="text-danger">*</span></label>
                                    <select name="level_one_id" class="select">
                                        <option value="" selected disabled>Select Level One</option>
                                        @foreach ($level_1 as $level)
                                            <option value="{{ $level->id }}">{{ $level->level_head }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Level Two Head<span class="text-danger">*</span></label>
                                    <input type="text" name="level_two_head" placeholder="Level Two Head"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn add_level_2" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Level 2 Modal End-->


    <!-- Edit Level 2 Modal Start-->
    <div id="Edit_level_2_modal" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Level Two Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" id="Edit_level_2_form" class="needs-validation" novalidate>
                        <input type="hidden" name="level_2_id">
                        {{-- @csrf --}}
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Level One<span class="text-danger">*</span></label>
                                    <select name="level_one_id" class="select" required>
                                        <option value="" selected disabled>Choose</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Level Two Head<span class="text-danger">*</span></label>
                                    <input type="text" name="level_two_head" placeholder="Level Head" required
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn update_level_2" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Level 2 Modal End-->


    <!-- Level 3 Modal Start-->
    <div id="level_3_modal" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Level Three Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" id="level_3_form" class="needs-validation" novalidate>
                        {{-- @csrf --}}
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Level One<span class="text-danger">*</span></label>
                                    <select name="level_one_id" class="select level_one_id" required>
                                        <option value="" selected disabled>Choose Level One</option>
                                        @foreach ($level_1 as $level)
                                            <option value="{{ $level->id }}">{{ $level->level_head }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Level Two<span class="text-danger">*</span></label>
                                    <select name="level_two_id" class="select level_two_id4" required>
                                        <option value="" selected disabled>Choose Level Two</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Level Three<span class="text-danger">*</span></label>
                                    <input type="text" name="level_three_head" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn add_level_3" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Level 3 Modal End-->

    <!-- Level 3 Modal Start-->
    <div id="Edit_level_3_modal" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Level Three Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" id="Edit_level_3_form" class="needs-validation" novalidate>
                        <input type="hidden" name="level_3_id">
                        {{-- @csrf --}}
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Level Two<span class="text-danger">*</span></label>
                                    <select name="level_two_id" class="select" required>
                                        <option value="" selected disabled>Choose Level Two</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Level Two Head<span class="text-danger">*</span></label>
                                    <input type="text" name="level_three_head" placeholder="Level Head" required
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn update_level_3" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Level 3 Modal End-->


    <!-- Level 4 Modal Start-->
    <div id="level_4_modal" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Level Four Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" id="level_4_form" class="needs-validation" novalidate>
                        {{-- @csrf --}}
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Level One<span class="text-danger">*</span></label>
                                    <select name="level_one_id" class="select level_one_id1" required>
                                        <option value="" selected disabled>Choose Level One</option>
                                        @foreach ($level_1 as $level)
                                            <option value="{{ $level->id }}">{{ $level->level_head }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Level Two<span class="text-danger">*</span></label>
                                    <select name="level_two_id" class="select level_two_id" required>
                                        <option value="" selected disabled>Choose Level Two</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Level Three<span class="text-danger">*</span></label>
                                    <select name="level_three_id" class="select level_three_id" required>
                                        <option value="" selected disabled>Choose Level Three</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Level Four Head<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="level_four_head" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn add_level_4" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Level 4 Modal End-->


    <!-- Level 4 Modal Start-->
    <div id="Edit_level_4_modal" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Level Four Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" id="Edit_level_4_form" class="needs-validation" novalidate>
                        <input type="hidden" name="level_4_id">
                        {{-- @csrf --}}
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Level Three<span class="text-danger">*</span></label>
                                    <select name="level_three_id" class="select" required>
                                        <option value="" selected disabled>Choose Level Three</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Level Four Head<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="level_four_head" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn update_level_4" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Level 4 Modal End-->


    <!-- Level 5 Modal Start-->
    <div id="level_5_modal" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Level Five Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" id="level_5_form" class="needs-validation" novalidate>
                        {{-- @csrf --}}
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Level One<span class="text-danger">*</span></label>
                                    <select name="level_one_id" class="select level_one_id1" required>
                                        <option value="" selected disabled>Choose Level One</option>
                                        @foreach ($level_1 as $level)
                                            <option value="{{ $level->id }}">{{ $level->level_head }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Level Two<span class="text-danger">*</span></label>
                                    <select name="level_two_id" class="select level_two_id" required>
                                        <option value="" selected disabled>Choose Level Two</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Level Three<span class="text-danger">*</span></label>
                                    <select name="level_three_id" class="select level_three_id" required>
                                        <option value="" selected disabled>Choose Level Three</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Level Four<span class="text-danger">*</span></label>
                                    <select name="level_four_id" class="select level_four_id5" required>
                                        <option value="" selected disabled>Choose Level Four</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Level Five Head<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="level_five_head" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn add_level_5" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Level 5 Modal End-->


    <!-- Level 5 Modal Start-->
    <div id="Edit_level_5_modal" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Level Five Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" id="Edit_level_5_form" class="needs-validation" novalidate>
                        <input type="hidden" name="level_5_id">
                        {{-- @csrf --}}
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Level Four<span class="text-danger">*</span></label>
                                    <select name="level_four_id" class="select">
                                        <option value="" selected disabled>Choose Level Four</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Level Five Head<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="level_five_head" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn update_level_5" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Level 5 Modal End-->


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- CDN for Sweet Alert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {

            getLevel1();
            getLevel2();
            getLevel3();
            getLevel4();
            getLevel5();

            //Add Level 1
            $('#level_1_form').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData($('#level_1_form')[0]);

                $.ajax({
                    type: "POST",
                    url: "{{ url('store_level_1') }}",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('.add_level_1').text('Saving...');
                        $(".add_level_1").prop("disabled", true);
                    },
                    success: function(response) {

                        if (response.status == 200) {
                            toastr.success(response.message);
                            $('.add_level_1').text('Save');
                            $(".add_level_1").prop("disabled", false);
                            $("#level_1_modal").modal('hide');
                            $('#level_1_form').find('input').val("");
                            getLevel1();
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        }

                        if (response.errors) {
                            toastr.error('Please Enter Values');
                            $('.add_level_1').text('Save');
                            $(".add_level_1").prop("disabled", false);
                        }
                    },
                    error: function() {
                        $('.add_level_1').text('Save');
                        $(".add_level_1").prop("disabled", false);
                        toastr.error('something went wrong');
                    },
                });

            });


            function getLevel1() {

                $.ajax({

                    url: '{{ url('/get_level_1') }}',
                    type: 'get',
                    async: false,
                    dataType: 'json',

                    success: function(data) {

                        var html = '';
                        var i;
                        var c = 0;

                        for (i = 0; i < data.length; i++) {

                            c++;
                            html += '<tr>' +
                                '<td>' + c + '</td>' +
                                '<td>' + data[i].level_head + '</td>' +
                                '<td>' + data[i].created_at + '</td>' +
                                '<td class="text-right">' +
                                '<div class="dropdown dropdown-action">' +
                                '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>' +
                                '<div class="dropdown-menu dropdown-menu-right">' +
                                '<a href="#" class="dropdown-item btn_edit_level_1" data="' + data[i]
                                .id + '"><i class="fa fa-pencil m-r-5n "></i> Edit</a>' +
                                '<a href="#" class="dropdown-item btn_delete_level_1" data="' + data[i]
                                .id +
                                '" id="btn_delete_clients"><i class="fa fa-trash-o m-r-5 "></i> Delete</a>' +
                                '</tr>';
                        }


                        $('#level_1_table').html(html);

                    },
                    error: function() {
                        toastr.error('something went wrong');
                    }

                });
            }

            //Edit Level 1
            $('#level_1_table').on('click', '.btn_edit_level_1', function(e) {
                e.preventDefault();

                var id = $(this).attr('data');

                $('#Edit_level_1_modal').modal('show');

                $.ajax({

                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('edit_level_1') }}',
                    data: {
                        id: id
                    },
                    async: false,
                    dataType: 'json',
                    success: function(data) {

                        $('input[name=level_1_id]').val(data.level_1.id);
                        $('input[name=level_head]').val(data.level_1.level_head);
                    },

                    error: function() {

                        toastr.error('something went wrong');

                    }

                });

            });


            //Update Level 1
            $('.update_level_1').on('click', function(e) {
                e.preventDefault();

                let EditFormData = new FormData($('#Edit_level_1_form')[0]);

                $.ajax({
                    type: "POST",
                    url: "{{ url('update_level_1') }}",
                    data: EditFormData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    beforeSend: function() {
                        $('.update_level_1').text('Updating...');
                        $(".update_level_1").prop("disabled", true);
                    },
                    success: function(response) {

                        if (response.status == 200) {
                            $('#Edit_level_1_modal').modal('hide');
                            $('#Edit_level_1_form').find('input').val("");
                            $('.update_level_1').text('Update');
                            $(".update_level_1").prop("disabled", false);
                            toastr.success(response.message);
                            getLevel1();
                        }
                    },
                    error: function() {
                        toastr.error('something went wrong');
                        $('.update_level_1').text('Update');
                        $(".update_level_1").prop("disabled", false);
                    }
                });

            });


            // Delete Level 1
            $('#level_1_table').on('click', '.btn_delete_level_1', function(e) {
                e.preventDefault();

                var id = $(this).attr('data');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to Delete this Data!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "GET",
                            url: "{{ url('delete_level_1') }}",
                            data: {
                                id: id
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: "json",
                            success: function(response) {

                                toastr.success(response.message);
                                getLevel1();
                            }
                        });
                    }
                })

            });

            //Add Level 2
            $('#level_2_form').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData($('#level_2_form')[0]);

                $.ajax({
                    type: "POST",
                    url: "{{ url('store-level-two') }}",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('.add_level_2').text('Saving...');
                        $(".add_level_2").prop("disabled", true);
                    },
                    success: function(response) {

                        if (response.status == 200) {
                            toastr.success(response.message);
                            $('.add_level_2').text('Save');
                            $(".add_level_2").prop("disabled", false);
                            $("#level_2_modal").modal('hide');
                            $('#level_2_form').find('input').val("");
                            getLevel2();
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        }

                        if (response.errors) {
                            toastr.error('Please Enter Values');
                            $('.add_level_2').text('Save');
                            $(".add_level_2").prop("disabled", false);
                        }
                    },
                    error: function() {
                        $('.add_level_2').text('Save');
                        $(".add_level_2").prop("disabled", false);
                        toastr.error('something went wrong');
                    },
                });

            });

            function getLevel2() {

                $.ajax({

                    url: '{{ url('/get-level-two') }}',
                    type: 'get',
                    async: false,
                    dataType: 'json',

                    success: function(data) {

                        // console.log(data.level_2);

                        var html = '';
                        var i;
                        var c = 0;

                        for (i = 0; i < data.length; i++) {

                            c++;
                            html += '<tr>' +
                                '<td>' + c + '</td>' +
                                '<td>' + data[i].levelone.level_head + '</td>' +
                                '<td>' + data[i].level_two_head + '</td>' +
                                '<td>' + data[i].created_at + '</td>' +
                                '<td class="text-right">' +
                                '<div class="dropdown dropdown-action">' +
                                '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>' +
                                '<div class="dropdown-menu dropdown-menu-right">' +
                                '<a href="#" class="dropdown-item btn_edit_level_2" data="' + data[i]
                                .id + '"><i class="fa fa-pencil m-r-5n "></i> Edit</a>' +
                                '<a href="#" class="dropdown-item btn_delete_level_2" data="' + data[i]
                                .id +
                                '" id="btn_delete_clients"><i class="fa fa-trash-o m-r-5 "></i> Delete</a>' +
                                '</tr>';
                        }


                        $('#level_2_table').html(html);

                    },
                    error: function() {
                        toastr.error('something went wrong');
                    }

                });
            }

            //Edit Level 2
            $('#level_2_table').on('click', '.btn_edit_level_2', function(e) {
                e.preventDefault();

                var id = $(this).attr('data');

                $('#Edit_level_2_modal').modal('show');

                $.ajax({

                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('edit-level-two') }}',
                    data: {
                        id: id
                    },
                    async: false,
                    dataType: 'json',
                    success: function(data) {


                        $('input[name=level_2_id]').val(data.level_2.id);
                        $('input[name=level_two_head]').val(data.level_2.level_two_head);

                        $.each(data.level_1, function(key, level_1) {

                            $('select[name="level_one_id"]')
                                .append(
                                    `<option value="${level_1.id}" ${level_1.id == data.level_2.level_one_id ? 'selected' : ''}>${level_1.level_head}</option>`
                                )
                        });

                    },

                    error: function() {

                        toastr.error('something went wrong');

                    }

                });

            });

            //Update Level 2
            $('.update_level_2').on('click', function(e) {
                e.preventDefault();

                let EditFormData = new FormData($('#Edit_level_2_form')[0]);

                $.ajax({
                    type: "POST",
                    url: "{{ url('update-level-two') }}",
                    data: EditFormData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    beforeSend: function() {
                        $('.update_level_2').text('Updating...');
                        $(".update_level_2").prop("disabled", true);
                    },
                    success: function(response) {

                        if (response.status == 200) {
                            $('#Edit_level_2_modal').modal('hide');
                            $('#Edit_level_2_form').find('input').val("");
                            $('.update_level_2').text('Update');
                            $(".update_level_2").prop("disabled", false);
                            toastr.success(response.message);
                            getLevel2();
                        }
                    },
                    error: function() {
                        toastr.error('something went wrong');
                        $('.update_level_2').text('Update');
                        $(".update_level_2").prop("disabled", false);
                    }
                });

            });

            // Delete Level 2
            $('#level_2_table').on('click', '.btn_delete_level_2', function(e) {
                e.preventDefault();

                var id = $(this).attr('data');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to Delete this Data!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "GET",
                            url: "{{ url('delete-level-two') }}",
                            data: {
                                id: id
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: "json",
                            success: function(response) {

                                toastr.success(response.message);
                                getLevel2()
                            }
                        });
                    }
                })

            });

            //level one get data base on level two
            $('.level_one_id').change(function() {

                var level_one_id = $(this).val();

                $.ajax({

                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('/level-two-base-level-one') }}',
                    data: {
                        level_one_id: level_one_id,
                    },
                    async: false,
                    dataType: 'json',
                    success: function(data) {

                        var html = '<option value="">Choose Level Two</option>';

                        var i;
                        if (data.length > 0) {

                            for (i = 0; i < data.length; i++) {

                                html += '<option value="' + data[i].id + '">' + data[i]
                                    .level_two_head + '</option>';
                            }
                        } else {
                            var html = '<option value="">Choose Level Two</option>';
                            toastr.error('data not found');
                        }


                        $('.level_two_id4').html(html);

                    },

                    error: function() {

                        toastr.error('db error');


                    }

                });
            });

            //Add Level 3
            $('#level_3_form').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData($('#level_3_form')[0]);

                $.ajax({
                    type: "POST",
                    url: "{{ url('store-level-three') }}",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('.add_level_3').text('Saving...');
                        $(".add_level_3").prop("disabled", true);
                    },
                    success: function(response) {

                        if (response.status == 200) {
                            toastr.success(response.message);
                            $('.add_level_3').text('Save');
                            $(".add_level_3").prop("disabled", false);
                            $("#level_3_modal").modal('hide');
                            $('#level_3_form').find('input').val("");
                            getLevel3();
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        }

                        if (response.errors) {
                            toastr.error('Please Enter Values');
                            $('.add_level_3').text('Save');
                            $(".add_level_3").prop("disabled", false);
                        }
                    },
                    error: function() {
                        $('.add_level_3').text('Save');
                        $(".add_level_3").prop("disabled", false);
                        toastr.error('something went wrong');
                    },
                });

            });


            function getLevel3() {

                $.ajax({

                    url: '{{ url('/get-level-three') }}',
                    type: 'get',
                    async: false,
                    dataType: 'json',

                    success: function(data) {

                        var html = '';
                        var i;
                        var c = 0;

                        for (i = 0; i < data.length; i++) {

                            c++;
                            html += '<tr>' +
                                '<td>' + c + '</td>' +
                                '<td>' + data[i].leveltwo.level_two_head + '</td>' +
                                '<td>' + data[i].level_three_head + '</td>' +
                                '<td>' + data[i].created_at + '</td>' +
                                '<td class="text-right">' +
                                '<div class="dropdown dropdown-action">' +
                                '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>' +
                                '<div class="dropdown-menu dropdown-menu-right">' +
                                '<a href="#" class="dropdown-item btn_edit_level_3" data="' + data[i]
                                .id + '"><i class="fa fa-pencil m-r-5n "></i> Edit</a>' +
                                '<a href="#" class="dropdown-item btn_delete_level_3" data="' + data[i]
                                .id +
                                '" id="btn_delete_clients"><i class="fa fa-trash-o m-r-5 "></i> Delete</a>' +
                                '</tr>';
                        }


                        $('#level_3_table').html(html);

                    },
                    error: function() {
                        toastr.error('something went wrong');
                    }

                });
            }

            //Edit Level 3
            $('#level_3_table').on('click', '.btn_edit_level_3', function(e) {
                e.preventDefault();

                var id = $(this).attr('data');

                $('#Edit_level_3_modal').modal('show');

                $.ajax({

                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('edit-level-three') }}',
                    data: {
                        id: id
                    },
                    async: false,
                    dataType: 'json',
                    success: function(data) {


                        $('input[name=level_3_id]').val(data.level_3.id);
                        $('input[name=level_three_head]').val(data.level_3.level_three_head);

                        $.each(data.level_2, function(key, level_2) {

                            $('select[name="level_two_id"]')
                                .append(
                                    `<option value="${level_2.id}" ${level_2.id == data.level_3.level_two_id ? 'selected' : ''}>${level_2.level_two_head}</option>`
                                )
                        });

                    },

                    error: function() {

                        toastr.error('something went wrong');

                    }

                });

            });

            //Update Level 3
            $('.update_level_3').on('click', function(e) {
                e.preventDefault();

                let EditFormData = new FormData($('#Edit_level_3_form')[0]);

                $.ajax({
                    type: "POST",
                    url: "{{ url('update-level-three') }}",
                    data: EditFormData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    beforeSend: function() {
                        $('.update_level_3').text('Updating...');
                        $(".update_level_3").prop("disabled", true);
                    },
                    success: function(response) {

                        if (response.status == 200) {
                            $('#Edit_level_3_modal').modal('hide');
                            $('#Edit_level_3_form').find('input').val("");
                            $('.update_level_3').text('Update');
                            $(".update_level_3").prop("disabled", false);
                            toastr.success(response.message);
                            getLevel3();
                        }
                    },
                    error: function() {
                        toastr.error('something went wrong');
                        $('.update_level_3').text('Update');
                        $(".update_level_3").prop("disabled", false);
                    }
                });

            });

            // Delete Level 3
            $('#level_3_table').on('click', '.btn_delete_level_3', function(e) {
                e.preventDefault();

                var id = $(this).attr('data');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to Delete this Data!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "GET",
                            url: "{{ url('delete-level-three') }}",
                            data: {
                                id: id
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: "json",
                            success: function(response) {

                                toastr.success(response.message);
                                getLevel3();
                            }
                        });
                    }
                })

            });

            function getLevel4() {

                $.ajax({

                    url: '{{ url('/get-level-four') }}',
                    type: 'get',
                    async: false,
                    dataType: 'json',

                    success: function(data) {

                        var html = '';
                        var i;
                        var c = 0;

                        for (i = 0; i < data.length; i++) {

                            c++;
                            html += '<tr>' +
                                '<td>' + c + '</td>' +
                                '<td>' + data[i].levelthree.level_three_head + '</td>' +
                                '<td>' + data[i].level_four_head + '</td>' +
                                '<td>' + data[i].created_at + '</td>' +
                                '<td class="text-right">' +
                                '<div class="dropdown dropdown-action">' +
                                '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>' +
                                '<div class="dropdown-menu dropdown-menu-right">' +
                                '<a href="#" class="dropdown-item btn_edit_level_4" data="' + data[i]
                                .id + '"><i class="fa fa-pencil m-r-5n "></i> Edit</a>' +
                                '<a href="#" class="dropdown-item btn_delete_level_4" data="' + data[i]
                                .id +
                                '" id="btn_delete_clients"><i class="fa fa-trash-o m-r-5 "></i> Delete</a>' +
                                '</tr>';
                        }


                        $('#level_4_table').html(html);

                    },
                    error: function() {
                        toastr.error('something went wrong');
                    }

                });
            }

            //level one get data base on level two
            $('.level_one_id1').change(function() {

                var level_one_id1 = $(this).val();

                $.ajax({

                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('/level-two-base-level-one') }}',
                    data: {
                        level_one_id: level_one_id1,
                    },
                    async: false,
                    dataType: 'json',
                    success: function(data) {

                        var html = '<option value="">Choose Level Two</option>';

                        var i;
                        if (data.length > 0) {

                            for (i = 0; i < data.length; i++) {

                                html += '<option value="' + data[i].id + '">' + data[i]
                                    .level_two_head + '</option>';
                            }
                        } else {
                            var html = '<option value="">Choose Level Two</option>';
                            toastr.error('data not found');
                        }


                        $('.level_two_id').html(html);

                    },

                    error: function() {

                        toastr.error('db error');


                    }

                });
            });

            //level Two get data base on level Three
            $('.level_two_id').change(function() {

                var level_two_id = $(this).val();

                $.ajax({

                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('/level-three-base-level-two') }}',
                    data: {
                        level_two_id: level_two_id,
                    },
                    async: false,
                    dataType: 'json',
                    success: function(data) {

                        var html = '<option value="">Choose Level Two</option>';

                        var i;
                        if (data.length > 0) {

                            for (i = 0; i < data.length; i++) {

                                html += '<option value="' + data[i].id + '">' + data[i]
                                    .level_three_head + '</option>';
                            }
                        } else {
                            var html = '<option value="">Choose Level Two</option>';
                            toastr.error('data not found');
                        }


                        $('.level_three_id').html(html);

                    },

                    error: function() {

                        toastr.error('db error');


                    }

                });
            });

            //Add Level 4
            $('#level_4_form').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData($('#level_4_form')[0]);

                $.ajax({
                    type: "POST",
                    url: "{{ url('store-level-four') }}",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('.add_level_4').text('Saving...');
                        $(".add_level_4").prop("disabled", true);
                    },
                    success: function(response) {

                        if (response.status == 200) {
                            toastr.success(response.message);
                            $('.add_level_4').text('Save');
                            $(".add_level_4").prop("disabled", false);
                            $("#level_4_modal").modal('hide');
                            $('#level_4_form').find('input').val("");
                            getLevel4();
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);;

                        }

                        if (response.errors) {
                            toastr.error('Please Enter Values');
                            $('.add_level_4').text('Save');
                            $(".add_level_4").prop("disabled", false);
                        }
                    },
                    error: function() {
                        $('.add_level_4').text('Save');
                        $(".add_level_4").prop("disabled", false);
                        toastr.error('something went wrong');
                    },
                });

            });

            //Edit Level 4
            $('#level_4_table').on('click', '.btn_edit_level_4', function(e) {
                e.preventDefault();

                var id = $(this).attr('data');
                // alert(id);

                $('#Edit_level_4_modal').modal('show');

                $.ajax({

                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('edit-level-four') }}',
                    data: {
                        id: id
                    },
                    async: false,
                    dataType: 'json',
                    success: function(data) {


                        $('input[name=level_4_id]').val(data.level_4.id);
                        $('input[name=level_four_head]').val(data.level_4.level_four_head);

                        $.each(data.level_3, function(key, level_3) {

                            $('select[name="level_three_id"]')
                                .append(
                                    `<option value="${level_3.id}" ${level_3.id == data.level_4.level_three_id ? 'selected' : ''}>${level_3.level_three_head}</option>`
                                )
                        });

                    },

                    error: function() {

                        toastr.error('something went wrong');

                    }

                });

            });

            //Update Level 4
            $('.update_level_4').on('click', function(e) {
                e.preventDefault();

                let EditFormData = new FormData($('#Edit_level_4_form')[0]);

                $.ajax({
                    type: "POST",
                    url: "{{ url('update-level-four') }}",
                    data: EditFormData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    beforeSend: function() {
                        $('.update_level_4').text('Updating...');
                        $(".update_level_4").prop("disabled", true);
                    },
                    success: function(response) {

                        if (response.status == 200) {
                            $('#Edit_level_4_modal').modal('hide');
                            $('#Edit_level_4_form').find('input').val("");
                            $('.update_level_4').text('Update');
                            $(".update_level_4").prop("disabled", false);
                            toastr.success(response.message);
                            getLevel4();
                        }
                    },
                    error: function() {
                        toastr.error('something went wrong');
                        $('.update_level_4').text('Update');
                        $(".update_level_4").prop("disabled", false);
                    }
                });

            });

            // Delete Level 4
            $('#level_4_table').on('click', '.btn_delete_level_4', function(e) {
                e.preventDefault();

                var id = $(this).attr('data');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to Delete this Data!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "GET",
                            url: "{{ url('delete-level-four') }}",
                            data: {
                                id: id
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: "json",
                            success: function(response) {

                                toastr.success(response.message);
                                getLevel4();
                            }
                        });
                    }
                })

            });


            function getLevel5() {

                $.ajax({

                    url: '{{ url('/get-level-five') }}',
                    type: 'get',
                    async: false,
                    dataType: 'json',

                    success: function(data) {

                        var html = '';
                        var i;
                        var c = 0;

                        for (i = 0; i < data.length; i++) {

                            c++;
                            html += '<tr>' +
                                '<td>' + c + '</td>' +
                                '<td>' + data[i].levelfour.level_four_head + '</td>' +
                                '<td>' + data[i].level_five_head + '</td>' +
                                '<td>' + data[i].created_at + '</td>' +
                                '<td class="text-right">' +
                                '<div class="dropdown dropdown-action">' +
                                '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>' +
                                '<div class="dropdown-menu dropdown-menu-right">' +
                                '<a href="#" class="dropdown-item btn_edit_level_5" data="' + data[i]
                                .id + '"><i class="fa fa-pencil m-r-5n "></i> Edit</a>' +
                                '<a href="#" class="dropdown-item btn_delete_level_5" data="' + data[i]
                                .id +
                                '" id="btn_delete_clients"><i class="fa fa-trash-o m-r-5 "></i> Delete</a>' +
                                '</tr>';
                        }


                        $('#level_5_table').html(html);

                    },
                    error: function() {
                        toastr.error('something went wrong');
                    }

                });
            }

            //level three get data base on level four
            $('.level_three_id').change(function() {

                var level_three_id = $(this).val();

                $.ajax({

                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('/level-four-base-level-three') }}',
                    data: {
                        level_three_id: level_three_id,
                    },
                    async: false,
                    dataType: 'json',
                    success: function(data) {

                        var html = '<option value="">Choose Level Two</option>';

                        var i;
                        if (data.length > 0) {

                            for (i = 0; i < data.length; i++) {

                                html += '<option value="' + data[i].id + '">' + data[i]
                                    .level_four_head + '</option>';
                            }
                        } else {
                            var html = '<option value="">Choose Level Two</option>';
                            toastr.error('data not found');
                        }


                        $('.level_four_id5').html(html);

                    },

                    error: function() {

                        toastr.error('db error');


                    }

                });
            });

            //Add Level 5
            $('#level_5_form').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData($('#level_5_form')[0]);

                $.ajax({
                    type: "POST",
                    url: "{{ url('store-level-five') }}",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('.add_level_5').text('Saving...');
                        $(".add_level_5").prop("disabled", true);
                    },
                    success: function(response) {

                        if (response.status == 200) {
                            toastr.success(response.message);
                            $('.add_level_5').text('Save');
                            $(".add_level_5").prop("disabled", false);
                            $("#level_5_modal").modal('hide');
                            $('#level_5_form').find('input').val("");
                            getLevel5();
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);


                        }

                        if (response.errors) {
                            toastr.error('Please Enter Values');
                            $('.add_level_5').text('Save');
                            $(".add_level_5").prop("disabled", false);
                        }
                    },
                    error: function() {
                        $('.add_level_5').text('Save');
                        $(".add_level_5").prop("disabled", false);
                        toastr.error('something went wrong');
                    },
                });

            });

            //Edit Level 5
            $('#level_5_table').on('click', '.btn_edit_level_5', function(e) {
                e.preventDefault();

                var id = $(this).attr('data');

                $('#Edit_level_5_modal').modal('show');

                $.ajax({

                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('edit-level-five') }}',
                    data: {
                        id: id
                    },
                    async: false,
                    dataType: 'json',
                    success: function(data) {


                        $('input[name=level_5_id]').val(data.level_5.id);
                        $('input[name=level_five_head]').val(data.level_5.level_five_head);

                        $.each(data.level_4, function(key, level_4) {

                            $('select[name="level_four_id"]')
                                .append(
                                    `<option value="${level_4.id}" ${level_4.id == data.level_5.level_four_id ? 'selected' : ''}>${level_4.level_four_head}</option>`
                                )
                        });

                    },

                    error: function() {

                        toastr.error('something went wrong');

                    }

                });

            });

            //Update Level 5
            $('.update_level_5').on('click', function(e) {
                e.preventDefault();

                let EditFormData = new FormData($('#Edit_level_5_form')[0]);

                $.ajax({
                    type: "POST",
                    url: "{{ url('update-level-five') }}",
                    data: EditFormData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    beforeSend: function() {
                        $('.update_level_5').text('Updating...');
                        $(".update_level_5").prop("disabled", true);
                    },
                    success: function(response) {

                        if (response.status == 200) {
                            $('#Edit_level_5_modal').modal('hide');
                            $('#Edit_level_5_form').find('input').val("");
                            $('.update_level_5').text('Update');
                            $(".update_level_5").prop("disabled", false);
                            toastr.success(response.message);
                            getLevel5();
                        }
                    },
                    error: function() {
                        toastr.error('something went wrong');
                        $('.update_level_5').text('Update');
                        $(".update_level_5").prop("disabled", false);
                    }
                });

            });

            // Delete Level 5
            $('#level_5_table').on('click', '.btn_delete_level_5', function(e) {
                e.preventDefault();

                var id = $(this).attr('data');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to Delete this Data!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "GET",
                            url: "{{ url('delete-level-five') }}",
                            data: {
                                id: id
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: "json",
                            success: function(response) {

                                toastr.success(response.message);
                                getLevel5();
                            }
                        });
                    }
                })

            });


        });
    </script>
@endsection
