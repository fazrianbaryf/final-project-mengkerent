@extends('layouts.main-dashboard')

@section('page-content')

{{-- Isi Content Disini --}}
<div class="main-content">
<section class="section">
    <div class="card">
        <div class="card-header">
            Simple Datatable
        </div>
        <div class="card-body">
            <table class="table table-striped" id="table1">
                <thead>
                    <tr>
                        <th>Customer Name</th>
                        <th>Gender</th>
                        <th>Phone</th>
                        <th>Pekerjaan</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</section>

@endsection