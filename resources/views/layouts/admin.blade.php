
<x-header/>
<x-sidebar/>
@php
    $user = App\Helpers\helpers::user();
    $breeder = App\Helpers\Helpers::isBreeder();
@endphp
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                    
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route("logout")}}">Logout</a></li>
                        <li class="breadcrumb-item active"><a href="{{ url('/') }}">frontend</a></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        @yield('admin')
    </section>
</div>


<x-footer/>

