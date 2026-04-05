<div class="intro-y box px-5 pt-5 mt-5">
    <div class="flex flex-col lg:flex-row border-b border-gray-200 dark:border-dark-5 pb-5 -mx-5">
        <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
            <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                <img alt="avatar" class="rounded" src="{{Auth()->user()->avatar}}">
                <div class="absolute mb-1 mr-1 flex items-center justify-center bottom-0 right-0 bg-theme-1 rounded-full p-2">
                    <i class="fa-solid fa-camera" style="color:white"></i>
                </div>
            </div>
            <div class="ml-5">
                <div class="w-24 sm:w-40 truncate sm:whitespace-normal font-medium text-lg">{{Auth()->user()->name}}</div>
                <div class="text-gray-600">Developer</div>
            </div>
            <input wire:model="photo" accept="image/x-png,image/jpeg,image/jpg" class="form-control" type="file">
        </div>
        <div class="mt-6 lg:mt-0 flex-1 dark:text-gray-300 px-5 border-l border-r border-gray-200 dark:border-dark-5 border-t lg:border-t-0 pt-5 lg:pt-0">
            <div class="font-medium text-center lg:text-left lg:mt-3">Contact Details</div>
            <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                <div class="truncate sm:whitespace-normal flex items-center"> <i class="fa-solid fa-envelope mr-2" style="color:gray"></i> {{Auth()->user()->email}} </div>
                <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i class="fa-solid fa-user mr-2" style="color:gray"></i> {{Auth()->user()->profile}} </div>
                <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i class="fa-solid fa-calendar mr-2" style="color:gray"></i> {{Auth()->user()->created_at}} </div>
            </div>
        </div>
        <div class="mt-6 lg:mt-0 flex-1 px-5 border-t lg:border-0 border-gray-200 dark:border-dark-5 pt-5 lg:pt-0">
            <div class="font-medium text-center lg:text-left lg:mt-3">Change Credentials</div>
            <div class="flex flex-col justify-center items-center lg:items-start">
                <div class="w-3/4 overflow-auto">
                    <div class="input-group mt-2">
                        <div class="input-group-text"><i class="fa-solid fa-key"></i></div>
                        <input wire:model="currentpwd" id="currentpwd" type="password" class="form-control form-control-sm kioskboard" placeholder="Password actual *">
                    </div>
                    @error('currentpwd')
                    <small class="text-theme-6">{{ $message }}</small>
                    @enderror
                </div>
                <div class="w-3/4 overflow-auto">
                    <div class="input-group mt-2">
                        <div class="input-group-text">
                            <i class="fa-solid fa-key"></i>
                        </div>
                        <input wire:model="newpwd" id="newpwd" type="password" class="form-control form-control-sm kioskboard" placeholder="Nuevo password *" maxlength="255">
                    </div>
                    @error('newpwd')
                    <small class="text-theme-6">{{ $message }}</small>
                    @enderror
                </div>
                <button wire:click="saveProfileInfo" wire:loading.attr="disabled" wire:click.prevent="" type="button" class="btn btn-sm btn-secondary w-24 mt-3 mb-2 " {{ $currentpwd=='' || $newpwd=='' ? 'disabled' : ''}}>
                    <span wire:loading.remove wire:target="saveProfileInfo">
                        Guardar
                    </span>

                    <span wire:loading wire:target="saveProfileInfo">
                        Procesando
                    </span>
                </button>
            </div>
        </div>
    </div>

</div>

@include('livewire.sales.keyboard')

<script>
    const inputCP = document.getElementById('currentpwd')
    inputCP.addEventListener('change', (e) => {
        @this.currentpwd = e.target.value;
    })
    const inputNP = document.getElementById('newpwd')
    inputNP.addEventListener('change', (e) => {
        @this.newpwd = e.target.value;
    })
</script>
</div>