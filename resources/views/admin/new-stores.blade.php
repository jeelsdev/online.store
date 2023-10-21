<x-app-layout>
    <div class="px-4 md:px-10 mx-auto w-full -m-24 mt-0">
        <div class="flex flex-wrap">
            <div class="w-full mb-12 px-4 mt-24">
                <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded bg-white">

                    <div class="rounded-t mb-0 px-4 py-3 border-0">
                        <div class="flex flex-wrap items-center">
                            <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                                <h3 class="font-semibold text-lg text-blueGray-700">
                                    Nuevas tiendas
                                </h3>
                                <div class="pt-5 relative mx-auto text-gray-600">
                                        <form method="GET" action="#" id="search-form" class="flex justify-between">
                                            <div class="flex">
                                                <x-input type="text" name="search" id="search-name" value="{{ request('search') }}" placeholder="Buscar por nombre o ruc"></x-input>
                                                <x-button class="ml-5 h-10">Buscar</x-button>
                                            </div>
                                            <div class="w-1/5">
                                                <x-select id="search-status" name="status" class=" w-full">
                                                    <option {{ request('status') == '' ? 'selected':'' }} value="" >Todos</option>
                                                    <option {{ request('status') == 1 ? 'selected':''  }} value="1">Activo</option>
                                                    <option {{ request('status') == 2 ? 'selected':''  }} value="2">Inactivo</option>
                                                </x-select>
                                            </div>
                                        </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="block w-full overflow-x-auto">
                        <table class="items-center w-full bg-transparent border-collapse">
                            <thead>
                                <tr>

                                    <th
                                        class="px-3 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                        ID
                                    </th>
                                    <th
                                        class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                        Nombre
                                    </th>
                                    <th
                                        class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                        RUC
                                    </th>
                                    <th
                                        class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                        Vendedor
                                    </th>

                                    <th
                                        class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                        Estado
                                    </th>

                                    <th
                                        class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                        Fecha
                                    </th>
                                    <th
                                        class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stores as $store)
                                    <tr>

                                        <th
                                            class="border-t-0 px-3 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left">
                                            {{ $store->id }}
                                        </th>
                                        <td
                                            class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left flex items-center">

                                            <span class=" font-bold text-blueGray-600">
                                                {{ $store->name }}
                                            </span>
                                        </td>

                                        <td
                                            class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                            {{ $store->ruc }}
                                        </td>
                                        <td
                                            class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                            <div class="flex items-center">
                                                <span class="mr-2">{{ $store->user->name }}</span>

                                            </div>
                                        </td>
                                        <td
                                            class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                            @if ($store->status_id == 1)
                                                <div
                                                    class="inline-flex items-center px-3 py-1 rounded-full gap-x-2 text-emerald-500 bg-emerald-100/60">
                                                    <h2 class="text-sm font-normal">Activo</h2>
                                                </div>
                                            @endif
                                            @if ($store->status_id == 2)
                                                <div
                                                    class="inline-flex items-center px-3 py-1 text-orange-500 rounded-full gap-x-2 bg-orange-100/60">
                                                    <h2 class="text-sm font-normal">Inactivo</h2>
                                                </div>
                                            @endif
                                        </td>

                                        <td
                                            class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">

                                            {{ $store->created_at->diffForHumans() }}

                                        </td>
                                        <td
                                            class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-right">
                                            <a href="{{ route('admin.store.validate', ['store' => $store->id]) }}"
                                                class="text-blue-500 transition-colors duration-200 hover:text-indigo-500 focus:outline-none">
                                                ver mas
                                            </a>

                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
                {{ $stores->links() }}
            </div>
        </div>
    </div>
    <script>
        const form = document.getElementById('search-form');
        const searchName = document.getElementById('search-name');
        const searchStatus = document.getElementById('search-status');
        
        searchName.addEventListener('keypress', function(e){
            if(e.key == "Enter"){
                form.submit();
                console.log('enviado');
            }
        });
        searchStatus.addEventListener('change', function(e){
                form.submit();
                console.log('enviado');
        })
    </script>
</x-app-layout>
