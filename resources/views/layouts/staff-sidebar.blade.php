<nav
    class="md:left-0 md:block md:fixed md:top-0 md:bottom-0 md:overflow-y-auto md:flex-row md:flex-nowrap md:overflow-hidden shadow-xl bg-white flex flex-wrap items-center justify-between relative md:w-64 z-10 py-4 px-6">
    <div
        class="md:flex-col md:items-stretch md:min-h-full md:flex-nowrap px-0 flex flex-wrap items-center justify-between w-full mx-auto">
        <button
            class="cursor-pointer text-black opacity-50 md:hidden px-3 py-1 text-xl leading-none bg-transparent rounded border border-solid border-transparent"
            type="button" onclick="toggleNavbar('example-collapse-sidebar')">
            <i class="fas fa-bars"></i>
        </button>
        <a class="md:block text-center md:pb-2 text-blueGray-600 mr-0 inline-block whitespace-nowrap text-sm uppercase font-bold p-4 px-0"
            href="{{ route('dashboard') }}">
            Tienda online
        </a>
        @if (auth()->user()->store)
            @if (auth()->user()->store->status_id == 2)
                <div
                    class="inline-flex items-center justify-center px-3 py-1 text-orange-500 rounded-full gap-x-2 bg-orange-100/60">
                    <h2 class="text-sm font-normal">En validación</h2>
                </div>
            @endif
        @endif
        <div class="md:flex md:flex-col md:items-stretch md:opacity-100 md:relative md:mt-4 md:shadow-none shadow absolute top-0 left-0 right-0 z-40 overflow-y-auto overflow-x-hidden h-auto items-center flex-1 rounded hidden"
            id="example-collapse-sidebar">
            <div class="md:min-w-full md:hidden block pb-4 mb-4 border-b border-solid border-blueGray-200">
                <div class="flex flex-wrap">
                    <div class="w-6/12">
                        <a class="md:block text-left md:pb-2 text-blueGray-600 mr-0 inline-block whitespace-nowrap text-sm uppercase font-bold p-4 px-0"
                            href="{{ route('dashboard') }}">
                            Tienda online
                        </a>
                    </div>
                    <div class="w-6/12 flex justify-end">
                        <button type="button"
                            class="cursor-pointer text-black opacity-50 md:hidden px-3 py-1 text-xl leading-none bg-transparent rounded border border-solid border-transparent"
                            onclick="toggleNavbar('example-collapse-sidebar')">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
            <form class="mt-6 mb-4 md:hidden">
                <div class="mb-3 pt-0">
                    <input type="text" placeholder="Search"
                        class="border-0 px-3 py-2 h-12 border border-solid border-blueGray-500 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-base leading-snug shadow-none outline-none focus:outline-none w-full font-normal" />
                </div>
            </form>
            <!-- Divider -->
            <hr class="my-4 md:min-w-full" />
            <!-- Heading -->
            <h6 class="md:min-w-full text-blueGray-500 text-xs uppercase font-bold block pt-1 pb-4 no-underline">
                Inicio
            </h6>
            <!-- Navigation -->

            <ul class="md:flex-col md:min-w-full flex flex-col list-none">
                <li class="items-center">
                    <a href="{{ route('dashboard') }}"
                        class="{{ setActive('dashboard')?'text-blue-600':'' }} text-xs uppercase py-3 font-bold block hover:text-blue-900">
                        <i class="fas fa-tv mr-2 text-sm opacity-75"></i>
                        Dashboard
                    </a>
                </li>
            </ul>
            @if (auth()->user()->store)
                <!-- Divider -->
                <hr class="my-4 md:min-w-full" />
                <!-- Heading -->
                <h6 class="md:min-w-full text-blueGray-500 text-xs uppercase font-bold block pt-1 pb-4 no-underline">
                    Producto
                </h6>
                <!-- Navigation -->

                <ul class="md:flex-col md:min-w-full flex flex-col list-none md:mb-4">
                    @if (auth()->user()->store->status_id == 1)
                        <li class="items-center">
                            <a href="{{ route('staff.product.create') }}"
                                class="{{ setActive('staff.product.create')?'text-blue-600':'' }} hover:text-blueGray-500 text-xs uppercase py-3 font-bold block hover:text-blue-900">
                                <i class="fas fa-plus text-blueGray-300 mr-2 text-sm"></i>
                                Agregar
                            </a>
                        </li>
                    @endif

                    <li class="items-center">
                        <a href="{{ route('staff.products') }}"
                            class="{{ setActive('staff.products')?'text-blue-600':'' }} hover:text-blueGray-500 text-xs uppercase py-3 font-bold block hover:text-blue-900">
                            <i class="fas fa-clipboard-list text-blueGray-300 mr-2 text-sm"></i>
                            Ver todos
                        </a>
                    </li>
                </ul>
                <!-- Divider -->
                <hr class="my-4 md:min-w-full" />
                <!-- Heading -->
                <h6 class="md:min-w-full text-blueGray-500 text-xs uppercase font-bold block pt-1 pb-4 no-underline">
                    Ventas
                </h6>
                <!-- Navigation -->

                <ul class="md:flex-col md:min-w-full flex flex-col list-none md:mb-4">
                    <li class="items-center">
                        <a href="{{ route('staff.sales') }}"
                            class="{{ setActive('staff.sales')?'text-blue-600':'' }} hover:text-blueGray-500 text-xs uppercase py-3 font-bold block hover:text-blue-900">
                            <i class="fas fa-newspaper text-blueGray-300 mr-2 text-sm"></i>
                            Historial
                        </a>
                    </li>
                </ul>

            @endif
            <!-- Divider -->
            <hr class="my-4 md:min-w-full" />
            <!-- Heading -->
            <h6 class="md:min-w-full text-blueGray-500 text-xs uppercase font-bold block pt-1 pb-4 no-underline">
                Tienda
            </h6>
            <!-- Navigation -->

            <ul class="md:flex-col md:min-w-full flex flex-col list-none md:mb-4">
                <li class="items-center">
                    <a href="{{ route('staff.store') }}"
                        class="{{ setActive('staff.store')?'text-blue-600':'' }} hover:text-blueGray-500 text-xs uppercase py-3 font-bold block hover:text-blue-900">
                        <i class="fas fa-newspaper text-blueGray-300 mr-2 text-sm"></i>
                        Datos
                    </a>
                </li>
            </ul>


        </div>
    </div>
</nav>
