 <div class="pos intro-y grid grid-cols-12 gap-5 mt-5">     
     <div class="intro-y col-span-12 lg:col-span-9">

         <div class="post intro-y overflow-hidden box">
             <div class="post__tabs nav nav-tabs flex-col sm:flex-row bg-gray-300 dark:bg-dark-2 text-gray-600" role="tablist">
                
                 
                <a href="">DETALLE DE VENTA</a>

                <a href="">CATEGORIAS</a>

             </div>
             <div class="post__content tab-content">
                 <div id="tabProducts" class="tab-pane {{$tabProducts ? 'active' : '' }}" role="tabpanel" >
                    
                 </div>
                 <div id="tabCategory" class="tab-pane p-5 {{$tabCategories ? 'active' : '' }}" role="tabpanel" >

                     
                 </div>
             </div>
         </div>

     </div>
     
     <div class="col-span-12 lg:col-span-3">
         <div class="intro-y box p-5">
             <div>
                 <h2 class="text-2xl text-center mb-3">Resumen de Venta</h2>
                 <button onclick="openModalCustomer()" class="btn btn-outline-dark w-full mb-3">{{$customerSelected}}</button>
             </div>
             <div class="mt-3">
                 <h1 class="text-2xl font-bold">Articulos</h1>
                 <h3 class="text-2xl">{{$itemsCart}}</h3>
             </div>
             <div class="mt-3">
                 <h1 class="text-2xl font-bold">TOTAL</h1>
                 <h3 class="text-2xl">${{number_format($totalCart,2)}}</h3>
             </div>
             <div class="mt-6">
                 <div class="input-group">
                     <div id="input-group-3" class="input-group-text"><i class="fas fa-dollar-sign fa-2x"></i></div>
                     <input wire:model="cash" id="cash" type="number" data-kioskboard-type="numpad" class="form-control form-control-lg kioskboard" placeholder="0.00">
                 </div>
                 <h1>Ingresar el Efectivo</h1>
             </div>
             <div class="mt-8">
                 @if($totalCart >0 && ($cash>= $totalCart))
                 <button wire:loading.attr="disabled" wire:target="storeSale" wire:click.prevent="storeSale" class="btn btn-primary w-full"><i class="fas fa-database mr-2"></i> Guardar Venta</button>
                 <button wire:loading.attr="disabled" wire:target="storeSale" wire:click.prevent="storeSale(true)" class="btn btn-outline-primary w-full mt-5"><i class="fas fa-receipt mr-2"></i> Guardar e Imprimir</button>
                 @endif
             </div>

         </div>
     </div>
    
     @include('livewire.sales.modal-changes')
     @include('livewire.sales.modal-customers')
     @include('livewire.sales.script')
     


     @include('livewire.sales.keyboard')

     
 </div>