    <div>
        @if(!$form)
        <div class="intro-y col-span-12"><!--ocupamos las 12 columnas-->
            <div class="intro-y box">
                <h2 class="text-lg font-medium text-center text-theme-1 py-4">
                    <!--h2 texto large,fuente resaltada, texto centrado y tema azul, padin top y bottom de 4-->
                    CATEGORÍAS
                </h2>
                <x-search /><!--incluimos el componente blade search-->

                <div class="p-5"><!--div con padding general de 5-->
                    <div class="preview">
                        <div class="overflow-x-auto"><!--scroll horizontal-->
                            <table class="table">
                                <thead>
                                    <!--cabecera tema azul-->
                                    <tr class="text-theme-1">
                                        <!--con border inferior a 2 pixeles, color gris oscuro, ynowrap para remover saltos y mantener en una sola linea el texto del encabezado-->
                                        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap " width="10%"></th>
                                        <th class="border-b-2 dark:border-dark-5  whitespace-nowrap" width="70%">DESCRIPCIÓN</th>
                                        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap text-center"> ACTIONS </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($categories as $category)
                                    <tr class="dark:bg-dark-1 {{$loop->index % 2 >0 ? 'bg-gray-200' : '' }}">
                                        <td>
                                            <img src="{{ $category->img }}" data-action="zoom" alt="" width="100">
                                        </td>
                                        <td class="dark:border-dark-5">

                                            <h6 class="mb-1 font-medium">{{ $category->name }}</h6>
                                            <small class="font-normal">{{ $category->products->count() }} Productos</small>

                                        </td>
                                        <td class="dark:border-dark-5 text-center">
                                            <div class="d-flex justify-content-center">
                                                @if( $category->products->count() < 1) <button 
                                                onclick="destroy('categories','Destroy',{{ $category->id}})" 
                                                type="button" class="btn btn-danger text-white  border-0"><i class='fas fa-trash fa-2x'></i></button>
                                                    @endif
                                             <button class="ms-3 btn btn-warning text-white border-0 ml-3"
                                                wire:click.prevent="Edit({{$category->id}})" 
                                                type="button" >
                                                <i class="fas fa-edit fa-2x"></i>
                                            </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr class="bg-gray-200 dark:bg-dark-1">
                                        <td colspan="2">
                                            <h6 class="text-center">NO HAY CATEGORÍAS</h6>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 p-5">
                    {{$categories->links()}}
                </div>
            </div>
        </div>


        @else

        @include('livewire.categories.form')
    </div>
    @endif

    @include('livewire.sales.keyboard')

    <script>
        const inputSearch = document.getElementById('search')
        inputSearch.addEventListener('change', (e) => {
            @this.search = e.target.value;
        })
    </script>

    </div>