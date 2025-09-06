@extends('../layout/' . $layout)

@section('subhead')
    <title>Dashboard - Administración Escolar</title>
@endsection

@section('subcontent')
<div class="grid grid-cols-12 ">
    <div class="col-span-12 2xl:col-span-9">
        <div class="grid grid-cols-12 ">
            <!-- 🎯 Escudo Centrado -->
            <div class="col-span-12 mt-12 flex justify-center">
                <img 
                    alt="Escudo Colegio Salomón" 
                    class="-intro-x w-1/2 -mt-20" 
                    src="{{ asset('build/assets/images/col.png') }}">
            </div>
        </div>
    </div>
</div>

@endsection
