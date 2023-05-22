

{{--Este es el menu que se replicara a lo largo de toda la app--}}
<div class="grid-main-menu text-main-menu">
    <div>
        <x-application-logo/>
    </div>

    <div class="grid-sub-menu">
        <div><a class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Turnos</a></div>
        

        @role('admin')
        <div><a href="{{ route('dog.index') }}"" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Ver perros</a></div>
        @else
        <div><a href="{{ route('my-dog.index') }}"" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Ver perros</a></div>
        @endrole

        <div><a href="" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Servicio de paseadores y cuidadores</a></div>
        <div><a href="" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Perdida y busqueda</a></div>
        <div><a href=""class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Servicio de adopción</a></div>
        <div><a href="" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Campañas de donación</a></div>
    </div>

</div>

