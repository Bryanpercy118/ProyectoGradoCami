@extends('../layout/' . $layout)

@section('subhead')
    <title>Dashboard - Administración Escolar</title>
@endsection

@section('subcontent')
<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12 2xl:col-span-9">
        <div class="grid grid-cols-12 gap-6">

            <!-- 🎯 Indicadores Principales -->
            <div class="col-span-12 mt-8">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">Resumen General</h2>
                    <a href="" class="ml-auto flex items-center text-primary">
                        <i data-lucide="refresh-ccw" class="w-4 h-4 mr-3"></i> Actualizar
                    </a>
                </div>
                <div class="grid grid-cols-12 gap-6 mt-5">
                    @php
                        $cards = [
                            ['icon'=>'home','color'=>'primary','value'=>12,'label'=>'Salones','indicator'=>'+20%'],
                            ['icon'=>'users','color'=>'success','value'=>35,'label'=>'Docentes','indicator'=>'+10%'],
                            ['icon'=>'book-open','color'=>'warning','value'=>20,'label'=>'Asignaturas','indicator'=>'+5%'],
                            ['icon'=>'user-check','color'=>'pending','value'=>520,'label'=>'Estudiantes','indicator'=>'+8%'],
                            ['icon'=>'pie-chart','color'=>'info','value'=>'85%','label'=>'Tasa Aprobación','indicator'=>'+3%'],
                            ['icon'=>'activity','color'=>'rose','value'=>'1.200h','label'=>'Horas Docentes','indicator'=>'+15%'],
                        ];
                    @endphp
                    @foreach ($cards as $c)
                        <div class="col-span-12 sm:col-span-6 xl:col-span-2 intro-y">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex items-center">
                                        <i data-lucide="{{ $c['icon'] }}" class="report-box__icon text-{{ $c['color'] }}"></i>
                                        <div class="ml-auto">
                                            <div class="report-box__indicator bg-success tooltip cursor-pointer" title="Crecimiento mensual">
                                                {{ $c['indicator'] }} <i data-lucide="chevron-up" class="w-4 h-4 ml-0.5"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-3xl font-medium leading-8 mt-6">{{ $c['value'] }}</div>
                                    <div class="text-base text-slate-500 mt-1">{{ $c['label'] }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>


            <!-- 🌟 Rankings y Listados -->
            <div class="col-span-12 xl:col-span-4 mt-8 intro-y">
                <div class="box p-5">
                    <h2 class="text-lg font-medium mb-4">Salones Destacados</h2>
                    <ul class="space-y-2 text-slate-600">
                        <li>3°A – <span class="text-success font-bold">9.7</span></li>
                        <li>2°B – <span class="text-success font-bold">9.5</span></li>
                        <li>1°A – <span class="text-success font-bold">9.3</span></li>
                    </ul>
                </div>
            </div>
            <div class="col-span-12 xl:col-span-4 mt-8 intro-y">
                <div class="box p-5">
                    <h2 class="text-lg font-medium mb-4">Docentes Más Activos</h2>
                    <ul class="space-y-2 text-slate-600">
                        <li>Juan Pérez – <span class="text-success font-bold">120h</span></li>
                        <li>María López – <span class="text-success font-bold">110h</span></li>
                        <li>Carlos Gómez – <span class="text-success font-bold">105h</span></li>
                    </ul>
                </div>
            </div>
            <div class="col-span-12 xl:col-span-4 mt-8 intro-y">
                <div class="box p-5">
                    <h2 class="text-lg font-medium mb-4">Asignaturas Populares</h2>
                    <ul class="space-y-2 text-slate-600">
                        <li>Matemáticas – <span class="text-primary font-bold">15 salones</span></li>
                        <li>Ciencias – <span class="text-primary font-bold">12 salones</span></li>
                        <li>Inglés – <span class="text-primary font-bold">10 salones</span></li>
                    </ul>
                </div>
            </div>

            <!-- 📅 Próximos Eventos -->
            <div class="col-span-12 mt-8 intro-y">
                <div class="box p-5">
                    <h2 class="text-lg font-medium mb-3">Próximos Eventos</h2>
                    <ul class="list-disc pl-5 space-y-2 text-slate-600">
                        <li>10/07 – Reunión de Padres</li>
                        <li>15/07 – Examen Parcial</li>
                        <li>20/07 – Taller Docente</li>
                        <li>25/07 – Revisión Presupuestal</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
    <div class="col-span-12 2xl:col-span-3">
        <div class="2xl:border-l 2xl:pl-6 pb-10">

            <!-- 📨 Actividad Reciente -->
            <div class="intro-x mt-8">
                <h2 class="text-lg font-medium">Actividad Reciente</h2>
                <div class="mt-5 space-y-3">
                    @foreach(array_slice($fakers,0,5) as $f)
                    <div class="box px-5 py-3 flex items-center zoom-in">
                        <div class="w-10 h-10 image-fit rounded-md overflow-hidden">
                            <img src="{{ asset('build/assets/images/'.$f['photos'][0]) }}" alt="Avatar">
                        </div>
                        <div class="ml-4 mr-auto">
                            <div class="font-medium">{{ $f['users'][0]['name'] }}</div>
                            <div class="text-slate-500 text-xs mt-0.5">{{ $f['dates'][0] }}</div>
                        </div>
                        <div class="{{ $f['true_false'][0] ? 'text-success' : 'text-danger' }}">
                            {{ $f['true_false'][0] ? '+' : '-' }}${{ $f['totals'][0] }}
                        </div>
                    </div>
                    @endforeach
                    <a href="" class="block text-center text-slate-500 mt-3">Ver más</a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
