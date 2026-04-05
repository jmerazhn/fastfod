<div wire:ignore.self class="modal fade" id="myModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Gestión de Productos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3">
                    <div class="col-sm-12 col-md-8">
                        <label class="form-label">Nombre</label>
                        <div class="input-group"> <span class="input-group-text"><i class='bx bxs-keyboard bx-sm'></i></span>
                            <input wire:model.lazy="name" type="text" class="form-control border-start-0 {{($errors->first('name') ? "border-danger" : "")}}" placeholder="ej: Playera" />
                        </div>
                        @error('name')
                        <x-alert msg="{{ $message }}" />
                        @enderror
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <label class="form-label">Código</label>
                        <div class="input-group"> <span class="input-group-text"><i class='bx bxs-barcode bx-sm'></i></span>
                            <input wire:model.lazy="code" type="text" class="form-control border-start-0 {{($errors->first('code') ? "border-danger" : "")}}" placeholder="ej: 750" />
                        </div>
                        @error('code')
                        <x-alert msg="{{ $message }}" />
                        @enderror
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <label class="form-label">Costo</label>
                        <div class="input-group"> <span class="input-group-text"><i class='bx bx-dollar bx-sm'></i></span>
                            <input wire:model.lazy="cost" type="text" class="form-control border-start-0 {{($errors->first('cost') ? "border-danger" : "")}}" placeholder="0.00" />
                        </div>
                        @error('cost')
                        <x-alert msg="{{ $message }}" />
                        @enderror
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <label class="form-label">Precio</label>
                        <div class="input-group"> <span class="input-group-text"><i class='bx bxs-dollar-circle bx-sm'></i></span>
                            <input wire:model.lazy="price" type="text" class="form-control border-start-0 {{($errors->first('price') ? "border-danger" : "")}}" placeholder="0.00" />
                        </div>
                        @error('price')
                        <x-alert msg="{{ $message }}" />
                        @enderror
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <label class="form-label">Precio Oferta</label>
                        <div class="input-group"> <span class="input-group-text"><i class='bx bxs-dollar-circle bx-sm'></i></span>
                            <input wire:model.lazy="price2" type="text" class="form-control border-start-0 {{($errors->first('price2') ? "border-danger" : "")}}" placeholder="0.00" />
                        </div>
                        @error('price2')
                        <x-alert msg="{{ $message }}" />
                        @enderror
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <label class="form-label">Stock</label>
                        <div class="input-group"> <span class="input-group-text"><i class='bx bxs-component bx-sm'></i></span>
                            <input wire:model.lazy="stock" type="text" class="form-control border-start-0 {{($errors->first('stock') ? "border-danger" : "")}}" placeholder="0.00" />
                        </div>
                        @error('stock')
                        <x-alert msg="{{ $message }}" />
                        @enderror
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <label class="form-label">Stock Mínimo</label>
                        <div class="input-group"> <span class="input-group-text"><i class='bx bxs-cube bx-sm'></i></span>
                            <input wire:model.lazy="minstock" type="text" class="form-control border-start-0 {{($errors->first('minstock') ? "border-danger" : "")}}" placeholder="0.00" />
                        </div>
                        @error('minstock')
                        <x-alert msg="{{ $message }}" />
                        @enderror
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="input-group mb-3" style="margin-top:30px">
                            <label class="input-group-text" for="selectCategory"> <i class='bx bxs-category bx-sm'></i></label>
                            <select wire:model="category" class="form-select form-select-lg {{($errors->first('category') ? "border-danger" : "")}}" id="selectCategory">
                                <option value="elegir" selected disabled>Selecciona la categoría</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id}}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('category')
                        <x-alert msg="{{ $message }}" />
                        @enderror
                    </div>
                    <div class="col-sm-12 mt-3">
                        <label for="formFile" class="form-label">Elige las imágenes</label>
                        <input wire:model="gallery" accept="image/x-png,image/jpeg" class="form-control" type="file" multiple>
                    </div>
                    <div class="col-sm-12" id="avatar">
                        <!-- Loading Message for Images -->
                        <div wire:loading wire:target="gallery" class="text-info">Cargando Imagenes...</div>
                        @if( !empty( $gallery ) )
                        <div class="row">
                            @foreach ( $gallery as $image )
                            <div class="col-sm-2 mb-1">
                                <img class="recent-product-img" src="{{ $image->temporaryUrl() }}" style="border:solid;">
                            </div>
                            @endforeach
                        </div>
                        @endif

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button wire:click.prevent="CloseModal" type="button" class="btn btn-secondary">Cerrar</button>
                <button wire:click.prevent="Store" type="button" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>