<div wire:ignore.self class="modal fade" id="myModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Gestión de Categorías</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3">
                    <div class="col-sm-12">
                        <label class="form-label">Nombre de la categoría</label>
                        <div class="input-group"> <span class="input-group-text"><i class='bx bxs-pencil bx-sm'></i></span>
                            <input wire:model.lazy="name" type="text" class="form-control border-start-0 {{($errors->first('name') ? "border-danger" : "")}}" placeholder="..." />
                        </div>
                        @error('name')
                        <x-alert msg="{{ $message }}" />
                        @enderror

                    </div>
                    <div class="col-sm-12 mt-3">
                        <label for="formFile" class="form-label">Elige una Imagen</label>
                        <input wire:model="photo" accept="image/x-png,image/jpeg,image/jpg" class="form-control" type="file">
                    </div>
                    <div class="col-span-12" id="avatar">
                        @if( $photo )
                        <img class="rounded-lg mb-5 recent-product-img" src="{{ $photo->temporaryUrl() }}">
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